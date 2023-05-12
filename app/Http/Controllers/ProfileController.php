<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\Faq;
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
    public function update(ProfileRequest $request){
        // $user = User::where('id', Auth::user()->id);
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

        if ($request->hasFile($photoId)) {
            $file = $request->file($photoId);
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/uploads', $fileName);
            $photoId = '/storage/uploads/' . $fileName;
        }

        $userProfilePicture = UserPhoto::where('user_id', Auth::user()->id)->first();

        if($userProfilePicture){
            $userProfilePicture->update([
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

        $user->update($userDetails);

        $userAddress = ServiceAddress::find(Auth::user()->id);
        $userAddress->update([
            'user_id' => Auth::user()->id,
            'address' => $request->address,
            'is_active' => true
        ]);

        Alert::success('Success', 'Your changes has been saved.');
        return back();
    }

    public function showWallet(){
        return view('components.home.my-wallet');
    }

    public function showServiceProvider(){
        return view('components.home.service-provider', ['employees' => User::where('user_type', 2)->with('userPhoto')->get()]);
    }

    public function showEmployeeProfile(User $user){
        return view('components.home.employee-profile', ['users' => User::where('id', $user->id)->with('userPhoto')->get()]);
    }

    public function showServiceAddress(){
        return view('components.home.service-address', ['userAddress' => Auth::user()->address]);
    }

    public function showRewards(){
        return view('components.home.rewards');
    }

    public function showTransactionHistory(){
        return view('components.home.transaction-history', ['transactions' => Transaction::where('id', Auth::user()->id)]);
    }

    public function showFaqs(){
        return view('components.home.faqs', ['faqs' => Faq::all()]);
    }

    public function showAgenda(){
        return view('components.home.agenda');
    }

    public function showChat(){
        return view('components.home.chat', ['agents' => User::where('user_type',2)->with('userPhoto')->get()]);
    }
}
