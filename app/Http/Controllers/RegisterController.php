<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

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
            'contact_no' => $userDetails['contact_no'],
            'password' => $userDetails['password'],
            'address' => $userDetails['address']
        ]);

        return redirect('/');
    }
}
