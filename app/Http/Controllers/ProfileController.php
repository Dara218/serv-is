<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\User;
use App\Models\ValidDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    public function update(ProfileRequest $request){
        $user = User::where('id', Auth::user()->id);

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

        $user->update($userDetails);

        Alert::success('Success', 'Your changes has been saved.');
        return back();
    }

    public function showWallet(){
        return view('components.home.my-wallet');
    }

    public function showServiceProvider(){
        return view('components.home.service-provider', ['employees' => User::where('user_type', 2)->with('validDocuments')->get()]);
    }

    public function showEmployeeProfile(User $user){
        return view('components.home.employee-profile', ['users' => User::where('id', $user->id)->with('validDocuments')->get()]);
    }
}
