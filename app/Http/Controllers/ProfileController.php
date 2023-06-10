<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\AdminRequest;
use App\Models\Notification;
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
use App\Models\ValidDocument;
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
            'checkinprices' => CheckInPrice::all()
        ]);
    }

    public function showServiceProvider()
    {
        return view('components.home.service-provider',[
            'employees' => User::where('user_type', 2)->with('userPhoto', 'serviceAddress')->get()
        ]);
    }

    public function showEmployeeProfile(User $user)
    {
        $agentService = AgentService::where('user_id', $user->id)->with('service', 'review.user')->first();

        return view('components.home.employee-profile',[
            'users' => User::where('id', $user->id)->with('userPhoto', 'agentService', 'serviceAddress')->get(),
            'service' => $agentService
        ]);
    }

    public function showServiceAddress()
    {
        return view('components.home.service-address',
        ['primaryAddress' => ServiceAddress::where('user_id', Auth::user()->id)->where('is_primary', 1)->first(),
        'secondaryAddresses' => ServiceAddress::where('user_id', Auth::user()->id)->where('is_primary', 0)->get()]);
    }

    public function showRewards(){
        return view('components.home.rewards', ['rewards' => Reward::all()]);
    }

    public function showTransactionHistory(){
        return view('components.home.transaction-history', ['transactions' => Transaction::where('user_id', Auth::user()->id)->paginate(10)]);
    }

    public function showFaqs(){
        return view('components.home.faqs', ['faqs' => Faq::all()]);
    }

    public function showAgenda()
    {
        return view('components.home.agenda',
        ['services' => Service::all(),
        'agendas' => Agenda::where('user_id', Auth::user()->id)->with('user', 'userPhoto')->get()]);
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
        $user = User::where('username', $request->receiver)->first();
        $authUser = Auth::user();

        $userChat = Message::where(function ($query) use ($authUser, $user){
                    $query->where('sender_id', $authUser->id)
                          ->where('receiver_id', $user->id);
                })->orWhere(function ($query) use ($authUser, $user){
                    $query->where('sender_id', $user->id)
                          ->where('receiver_id', $authUser->id);
                })
                ->with('sender', 'receiver')
                ->get();

        $chatRoom = Chat::where(function ($query) use ($authUser, $user){
                    $query->where('sender_id', $authUser->id)
                          ->where('receiver_id', $user->id);
                })->orWhere(function ($query) use ($authUser, $user){
                    $query->where('sender_id', $user->id)
                          ->where('receiver_id', $authUser->id);
                })
                ->first();

        if(! $chatRoom)
        {
            $chatRoom = Chat::create([
                'sender_id' => Auth::user()->id,
                'receiver_id' => $user->id
            ]);
        }

        $checkIfUserHasAvailed = AvailedPricingPlan::where(function($query) use($user, $authUser){
            $query->where('availed_to_id', $user->id)
                    ->where('availed_by_id', $authUser->id);
        })->orWhere(function($query) use ($user, $authUser){
            $query->where('availed_to_id', $authUser->id)
                    ->where('availed_by_id', $user->id);
        })
        ->exists();

        $checkIsAccepted = AvailedUser::where(function($query) use($user, $authUser){
            $query->where('availed_to', $user->id)
                    ->where('availed_by', $authUser->id)
                    ->where('is_accepted', true);
                })->orWhere(function($subQuery) use ($user, $authUser){
            $subQuery->where('availed_to', $authUser->id)
                    ->where('availed_by', $user->id)
                    ->where('is_accepted', true);
        })
        ->exists();

        $checkIfAgentOrAdmin = User::find($authUser->id);
        $confirmNotAgent = false;
        $isAccepted = false;

        if($checkIfAgentOrAdmin->user_type == 3)
        {
            $confirmNotAgent = true;
        }
        if($checkIsAccepted){
            $isAccepted = true;
        }

        $responseData = [
            $userChat, // 0
            $chatRoom, // 1
            $checkIfUserHasAvailed, // 2
            $authUser->username, // 3
            $confirmNotAgent, // 4
            $isAccepted, // 5
            $request->sender // 6
        ];

        return response()->json($responseData);
    }
}
