<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterClientRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Agent;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class RegisterController extends Controller
{
    public function create(){

        return view('components.register.register');
    }

    public function store(RegisterRequest $request){

        $userDetails = $request->validated();

        $userDetails['password'] = bcrypt($userDetails['password']);

        User::create([
            'fullname' => $userDetails['fullname'],
            'username' => $userDetails['username'],
            'email_address' => $userDetails['email_address'],
            'contact_no' => $userDetails['contact_no'],
            'password' => $userDetails['password'],
            'address' => $userDetails['address'],
            'region' => $userDetails['region']
        ]);

        Alert::success('Success', 'Registration successful');
        return redirect('/');
    }

    public function storeAgent(RegisterClientRequest $request)
{
    $userDetails = $request->validated();

    $userDetails['password'] = bcrypt($userDetails['password']);

    $agent = new Agent([
        'fullname' => $userDetails['fullname'],
        'username' => $userDetails['username'],
        'email_address' => $userDetails['email_address'],
        'contact_no' => $userDetails['contact_no'],
        'password' => $userDetails['password'],
        'address' => $userDetails['address'],
        'region' => $userDetails['region'],
    ]);

    // Handle file uploads
    $fileFields = [
        'photo_id',
        'nbi_clearance',
        'police_clearance',
        'birth_certificate',
        'cert_of_employment',
        'other_valid_id',
    ];

    foreach ($fileFields as $field) {
        if ($request->hasFile($field)) {
            $file = $request->file($field);
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/uploads', $fileName);
            $agent->{$field} = '/storage/uploads/' . $fileName;
        }
    }

    $agent->save();

    Alert::success('Success', 'Registration successful');
    return redirect('/');
}

}
