<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class RegisterController extends Controller
{
    public function create(){

        return view('components.register.register');
    }

    public function store(RegisterRequest $request){
        // return $request;
        $userDetails = $request->validated();

        $userDetails['password'] = bcrypt($userDetails['password']);

        User::create([
            'fullname' => $userDetails['fullname'],
            'username' => $userDetails['username'],
            'email' => $userDetails['email'],
            'contact_no' => $userDetails['contact_no'],
            'password' => $userDetails['password'],
            'region' => $userDetails['region'],
            'address' => $userDetails['address']
        ]);

        Alert::success('Success', 'Registration successful');
        return redirect('/');
    }
}
