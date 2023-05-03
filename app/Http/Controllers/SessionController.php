<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class SessionController extends Controller
{
    public function store(Request $request){
        // return $request;
        $userDetails = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if(! Auth::attempt($userDetails))
        {
            Alert::error('Failed', 'Invalid login details.');
            return back();
        }

        session()->regenerate();

        if($request->user_type === 'Customer' && User::where('username', $request->username)->exists()) {
            return redirect()->route('home.index');
        }

        if ($request->user_type === 'Client' && User::where('username', $request->username)->exists()) {
            if(User::where('username', $request->username)->where('user_type', 1)->exists()) {
                return redirect()->route('home.indexAdmin');
            }
            return redirect()->route('home.indexAgent');
        }

    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
