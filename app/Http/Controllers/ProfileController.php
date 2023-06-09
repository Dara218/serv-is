<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\Review;
use App\Models\WalletHistory;
use App\Models\Agenda;
use App\Models\CheckInPrice;
use App\Models\Reward;
use App\Models\AgentService;
use App\Models\Service;
use App\Models\AvailedPricingPlan;
use App\Models\AvailedUser;
use App\Models\Chat;
use App\Models\Faq;
use App\Models\Message;
use App\Models\ServiceAddress;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    public function update(ProfileRequest $request)
    {
        $user = User::find(Auth::user()->id);
        $userDetails = $request->validated();

        if(Auth::user()->username != $userDetails['username'] && User::where('username', $request->username)->exists() ){
            return back()->withErrors(['username', 'Username already exists.']);
        }

        if(Auth::user()->email_address != $userDetails['email_address'] && User::where('email_address', $request->email_address)->exists() ){
            return back()->withErrors(['email_address', 'Email address already exists.']);
        }

        if(Auth::user()->contact_no != $userDetails['contact_no'] && User::where('contact_no', $request->contact_no)->exists() ){
            return back()->withErrors(['contact_no', 'Contact Number already exists.']);
        }

        $userDetails['password'] = bcrypt($userDetails['password']);
        $photoId = 'profile_picture';
        $userProfilePictureExists = UserPhoto::where('user_id', Auth::user()->id)->exists();

        if ($request->hasFile($photoId))
        {
            $file = $request->file($photoId);
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/uploads', $fileName);
            $photoId = '/storage/uploads/' . $fileName;

            if ($userProfilePictureExists)
            {
                UserPhoto::where('user_id', Auth::user()->id)->first()->update([
                    'profile_picture' => $photoId,
                ]);
            }
            else {
                UserPhoto::create([
                    'user_id' => Auth::user()->id,
                    'profile_picture' => $photoId,
                    'user_type' => Auth::user()->user_type
                ]);
            }
        }

        ServiceAddress::where('user_id', Auth::user()->id)
                        ->where('is_primary', true)
                        ->first()
                        ->update([
                            'user_id' => Auth::user()->id,
                            'address' => $request->address,
                            'is_active' => true
                        ]);

        $user->update($userDetails);

        auth()->setUser($user);

        Alert::success('Success', 'Your changes has been saved.');
        return back();
    }

    public function showWallet(){
        return view('components.home.my-wallet', [
            'userBalance' => Auth::user()->current_balance,
            'checkInPrices' => CheckInPrice::all(),
            'walletHistories' => WalletHistory::where('user_id', Auth::user()->id)->get()
        ]);
    }

    public function showServiceProvider()
    {
        return view('components.home.service-provider',[
            'employees' => User::where('user_type', 2)
                                ->with('userPhoto', 'serviceAddress')
                                ->inRandomOrder()
                                ->get()
        ]);
    }

    public function showEmployeeProfile(User $user)
    {
        $agentService = AgentService::where('user_id', $user->id)->with('service', 'review.user.userPhoto')->first();
        $agentServiceOverAllRating = Review::where('employee_id', $user->id)->get();
        $ratings = [];

        foreach($agentServiceOverAllRating as $overallRating)
        {
            $ratings[] = $overallRating->level;
        }

        $sumOfOverallRating = array_sum($ratings);

        $averageRating = 0;

        if($sumOfOverallRating > 0)
        {
            $averageRating = $sumOfOverallRating / $agentServiceOverAllRating->count();
        }


        return view('components.home.employee-profile', [
            'users' => User::where('id', $user->id)->with('userPhoto', 'agentService', 'serviceAddress')->get(),
            'service' => $agentService,
            'authuser' => User::where('id', Auth::user()->id)->with('userPhoto', 'availedPricingPlan')->first(),
            'averageRating' => $averageRating
        ]);
    }

    public function showServiceAddress()
    {
        return view('components.home.service-address', [
            'primaryAddress' => ServiceAddress::where('user_id', Auth::user()->id)->where('is_primary', 1)->first(),
            'secondaryAddresses' => ServiceAddress::where('user_id', Auth::user()->id)->where('is_primary', 0)->get()
        ]);
    }

    public function showRewards(){
        return view('components.home.rewards', ['rewards' => Reward::all()]);
    }

    public function showTransactionHistory(){
        return view('components.home.transaction-history', [
            'transactions' => Transaction::where('user_id', Auth::user()->id)->paginate(10)
        ]);
    }

    public function showFaqs(){
        return view('components.home.faqs', ['faqs' => Faq::all()]);
    }

    public function showAgenda()
    {
        return view('components.home.agenda', [
            'services' => Service::all(),
            'agendas' => Agenda::where('user_id', Auth::user()->id)->with('user', 'userPhoto')->get()
        ]);
    }

    public function showChat(){
        return view('components.home.chat', [
            'agents' => User::where('user_type', 2)->with('userPhoto', 'adminRequest')->get()
        ]);
    }

    public function tryChat(Request $request)
    {
        $receiver = User::where('username', $request->receiver_hidden)->first();
        $receiverId = $receiver->id;
        return $receiverId;
    }

    public function getUserChat(Request $request)
    {
        $user = User::where('id', $request->fromUserId)->first();
        $sender = $request->sender;
        $authUser = Auth::user();

        $userChat = Message::where(function ($query) use ($sender, $user){
                    $query->where('sender_id', $sender)
                          ->where('receiver_id', $user->id);
                })->orWhere(function ($query) use ($sender, $user){
                    $query->where('sender_id', $user->id)
                          ->where('receiver_id', $sender);
                })
                ->with('sender', 'receiver')
                ->get();

        $chatRoom = Chat::where('id', $request->chatId)->first();
        $checkChatRoom = Chat::where('id', $request->chatId)->exists();

        if(! $checkChatRoom)
        {
            $checkChatRoom = Chat::create([
                'sender_id' => Auth::user()->id,
                'receiver_id' => $user->id
            ]);
        }

        $fromUserId = $request->fromUserId;

        $checkIfUserHasAvailed = AvailedPricingPlan::where(function($query) use($fromUserId, $sender){
            $query->where('availed_to_id', $fromUserId)
                    ->where('availed_by_id', $sender);
        })->orWhere(function($query) use ($fromUserId, $sender){
            $query->where('availed_to_id', $sender)
                    ->where('availed_by_id', $fromUserId);
        })
        ->exists();

        $checkIsAccepted = AvailedUser::where(function($query) use($user, $sender){
            $query->where('availed_to', $user->id)
                    ->where('availed_by', $sender)
                    ->where('is_accepted', true);
                })->orWhere(function($subQuery) use ($user, $sender){
            $subQuery->where('availed_to', $sender)
                    ->where('availed_by', $user->id)
                    ->where('is_accepted', true);
        })
        ->exists();

        $checkIfAgentOrAdmin = User::find($authUser->id);
        $confirmNotAgent = false;

        if($checkIfAgentOrAdmin->user_type == 3)
        {
            $confirmNotAgent = true;
        }

        $isAccepted = false;

        if($checkIsAccepted){
            $isAccepted = true;
        }

        $availedPricingPlan = AvailedPricingPlan::where(function($query) use($user, $sender){
            $query->where('availed_to_id', $user->id)
                    ->where('availed_by_id', $sender);
                })->orWhere(function($subQuery) use ($user, $sender){
            $subQuery->where('availed_to_id', $sender)
                    ->where('availed_by_id', $user->id);
        })
        ->first();

        $isExpired = false;

        if($authUser->user_type != 1)
        {
            if($availedPricingPlan && $availedPricingPlan->is_expired == true)
            {
                $isExpired = true;
            }
        }

        $checkIfChatHasAdmin = false;

        if($authUser->user_type == 1 || $user->user_type == 1){
            $checkIfChatHasAdmin = true;
        }

        $responseData = [
            'userChat' => $userChat, // 0
            'chatRoom' => $chatRoom, // 1
            'checkIfUserHasAvailed' => $checkIfUserHasAvailed, // 2
            'authenticatedUser' => $authUser->username, // 3
            'confirmNotAgent' => $confirmNotAgent, // 4
            'isAccepted' => $isAccepted, // 5
            'sender' => $request->sender, // 6
            'isExpired' => $isExpired,
            'checkIfChatHasAdmin' => $checkIfChatHasAdmin,
            'receiverUsername' => $user->username,
            'user1' => $fromUserId,
            'user2' => $sender
        ];

        return response()->json($responseData);
    }
}
