<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class SessionController extends Controller
{
    public function store(Request $request)
    {
        $userDetails = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (!Auth::attempt($userDetails)) {
            Alert::error('Failed', 'Invalid login details.');
            return back();
        }

        session()->regenerate();

        if ($request->user_type === 'Customer' && User::where('username', $request->username)->where('user_type', 3)->exists()) {
            return redirect()->route('index');
        }

        if ($request->user_type === 'Client' && User::where('username', $request->username)->where('user_type', 2)->exists()) {
            if (User::where('username', $request->username)->where('user_type', 1)->exists()) {
                return redirect()->route('homeAdmin');
            }
            return redirect()->route('homeAgent');
        }
    }


    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
