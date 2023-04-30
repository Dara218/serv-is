<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class SessionController extends Controller
{
    public function store(Request $request){
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
        return redirect()->route('home.index');

    }
}
