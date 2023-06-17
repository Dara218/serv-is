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

        if (! Auth::attempt($userDetails))
        {
            Auth::logout();
            Alert::error('Failed', 'Invalid login details.');
            return redirect('/');
        }
        else{
            $userType = Auth::user()->user_type;
            session()->regenerate();

            // when code starts on this line, error

            if ($userType == 3) {
                return redirect()->route('index');
            }
            else if ($userType == 2) {
                return redirect()->route('indexAgent');
            }
            elseif ($userType == 1) {
                return redirect()->route('indexAdmin');
            }
        }
    }
    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
