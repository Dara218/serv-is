<?php

namespace App\Http\Controllers;

use App\Events\NotificationEvent;
use App\Events\NotificationMessageBadgeEvent;
use App\Models\AvailedPricingPlan;
use App\Models\AvailedUser;
use App\Models\Chat;
use App\Models\Notification;
use App\Models\PricingPlan;
use App\Models\SentRequest;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Stripe\Checkout\Session as CheckoutSession;
use Stripe\Stripe;

class PricingPlanController extends Controller
{
    public function index(User $user){

        $checkIfUserIsAvailed = AvailedPricingPlan::where('availed_to_id', $user->id)
                                                    ->where('availed_by_id', Auth::user()->id)
                                                    ->where('is_expired', false)
                                                    ->exists();

        if(! $checkIfUserIsAvailed){
            return view('components.home.pricing-plan', ['clientToBeAvailed' => $user]);
        }

        return back();
    }
    public function store(Request $request){

        // basic = 1 advance = 2

        $agent = $request->clientToBeAvailed;
        $customer = Auth::user();

        $userBalance = Auth::user()->current_balance;
        $pricingPlanBalance = PricingPlan::where('type', $request->plan)->first();

        $user = AvailedPricingPlan::where('availed_to_id', $agent)
                                    ->where('availed_by_id', $customer->id)
                                    ->exists();

        if($userBalance < $pricingPlanBalance->price){
            Alert::error('Cannot Avail Service', 'Insufficient balance.');
            return back();
        }
        else{
            $remainingBalance = $userBalance - $pricingPlanBalance->price;
            User::where('id', $customer->id)->update(['current_balance' => $remainingBalance]);
        }

        if(! $user){
            AvailedPricingPlan::create([
                'availed_to_id' => $agent,
                'availed_by_id' => $customer->id,
                'pricing_plan_type' => $request->plan
            ]);
        }
        else{
            $this->updateAvailedPricingPlan($agent, $customer);
        }

        $transactionType = null;

        if ($request->plan == 1)
        {
            $transactionType = 'Basic';
        }
        else if ($request->plan == 2){
            $transactionType = 'Advance';
        }

        $this->storeTransaction($customer, $transactionType, $pricingPlanBalance);

        $notificationMessage = "$customer->username has availed a $transactionType plan.";
        $notificationType = 2;

        $notification = Notification::create([
            'user_id' => $agent,
            'from_user_id' => $customer->id,
            'username' => $customer->username,
            'message' => $notificationMessage,
            'is_unread' => true,
            'status' => 3,
            'type' => 2
        ]);

        event(new NotificationEvent(
            $customer->username,
            $agent,
            $notificationMessage,
            $notificationType,
            $notification->id,
            Auth::user()->id
        ));

        // event(new NotificationMessageBadgeEvent(
        //     $agent,
        // ));

        Alert::success('Success', 'Transaction successful.');
        return redirect()->route('index');
    }

    public function updateAvailedPricingPlan($agent, $customer){
        AvailedPricingPlan::where('availed_to_id', $agent)
                            ->where('availed_by_id', $customer->id)
                            ->update([
                                'is_expired' => false
                            ]);
    }

    public function storeTransaction($customer, $transactionType, $pricingPlanBalance){
        Transaction::create([
            'user_id' => $customer->id,
            'service' => $transactionType,
            'amount_paid' => $pricingPlanBalance->price
        ]);
    }

    public function storeChat(User $user)
    {
        $authUser = Auth::user();
        $notificationMessage = "$authUser->username requested to avail your service.";
        $notificationType = 1;

        $checkAlreadyAvailedUser = AvailedUser::where('availed_by', $authUser->id)
                                            ->where('availed_to', $user->id)
                                            ->exists();

        if($checkAlreadyAvailedUser){
            Alert::info('Subscription', 'You have already availed this agent. Try updating your subscription.');
            return back();
        }

        $notification = Notification::create([
            'user_id' => $user->id,
            'from_user_id' => $authUser->id,
            'username' => $authUser->username,
            'message' => $notificationMessage,
            'is_unread' => true,
            'status' => 0,
            'type' => 1
        ]);

        event(new NotificationEvent(
            $authUser->username,
            $user->id,
            $notificationMessage,
            $notificationType,
            $notification->id,
            $authUser->id
        ));

        Chat::create([
            'sender_id' => $user->id,
            'receiver_id' => $authUser->id
        ]);

        AvailedUser::create([
            'availed_by' => $authUser->id,
            'availed_to' => $user->id,
            'is_accepted' => false,
            'notification_id' => $notification->id
        ]);

        SentRequest::create([
            'request_by' => $authUser->id,
            'request_to' => $user->id,
            'type' => 2,
            'status' => 1
        ]);

        Alert::success('Success', 'Kindly check your inbox');
        return redirect()->route('index');
    }

    public function getPricingPlan(){
        return response()->json(PricingPlan::all());
    }

    public function updatePricingPlan($id, Request $request){
        PricingPlan::find($id)->update([
            'type' => $request->title,
            'price' => $request->description
        ]);

        return response()->json($request);
    }

    public function storePricingPlan(Request $request){
        PricingPlan::create([
            'type' => $request->title,
            'price' => $request->description
        ]);

        return response()->json($request);
    }
}
