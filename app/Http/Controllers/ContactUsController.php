<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactUsRequest;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ContactUsController extends Controller
{
    public function storeContactMessage(ContactUsRequest $request){

        $contactUsDetails = $request->validated();

        ContactUs::create([
            'user_id' => Auth::user()->id,
            'email' => $contactUsDetails['email_address'],
            'subject' => $contactUsDetails['subject'],
            'message' => $contactUsDetails['message']
        ]);

        Alert::success('Success', 'Message has been sent!');
        return back();
    }

    public function index(){
        return view('components.home-admin.manage-customer-support', [
            'contactUs' => ContactUs::where('is_unread', true)->with('user.userPhoto')->get()
        ]);
    }
}
