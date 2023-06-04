<?php

namespace App\Http\Controllers;

use App\Events\NotificationEvent;
use App\Models\AvailedPricingPlan;
use App\Models\AvailedUser;
use App\Models\Notification;
use App\Models\PricingPlan;
use App\Models\SentRequest;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PricingPlanController extends Controller
{
    public function showPricingPlan(User $user){

        $checkIfUserIsAvailed = AvailedPricingPlan::where('availed_to_id', $user->id)
                                                    ->where('availed_by_id', Auth::user()->id)
                                                    ->exists();

        if(! $checkIfUserIsAvailed){
            return view('components.home.pricing-plan', ['clientToBeAvailed' => $user]);
        }

        return back();
    }
    public function storePricing(Request $request){

        // basic = 1 advance = 2

        $agent = $request->clientToBeAvailed;
        $customer = Auth::user();

        $userBalance = Auth::user()->current_balance;
        $pricingPlanBalance = PricingPlan::where('type', $request->plan)->first();

        $user = AvailedPricingPlan::where('availed_to_id', $agent)
                                    ->where('availed_by_id', $customer->id)
                                    ->exists();

        // add payment API.

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

        Alert::success('Success', 'Transaction successful.');
        return redirect()->route('home.index');
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
        $notificationMessage = "$user->username requested to avail your service.";
        $notificationType = 1;

        $notification = Notification::create([
            'user_id' => $user->id,
            'from_user_id' => Auth::user()->id,
            'username' => $user->username,
            'message' => $notificationMessage,
            'is_unread' => true,
            'status' => 0,
            'type' => 1
        ]);

        event(new NotificationEvent(
            $user->username,
            $user->id,
            $notificationMessage,
            $notificationType,
            $notification->id,
            Auth::user()->id
        ));

        AvailedUser::create([
            'availed_by' => Auth::user()->id,
            'availed_to' => $user->id,
            'is_accepted' => false,
            'notification_id' => $notification->id
        ]);

        SentRequest::create([
            'request_by' => Auth::user()->id,
            'request_to' => $user->id,
            'type' => 2,
            'status' => 1
        ]);

        Alert::success('Success', 'Kindly check your inbox');
        return redirect()->route('home.index');
    }
}
