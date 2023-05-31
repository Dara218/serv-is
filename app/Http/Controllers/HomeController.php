<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service;
use App\Models\ServiceAddress;
use App\Models\Transaction;
use App\Models\UserPhoto;
use App\Models\ValidDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        return view('components.home.home',
        [
            'services' => Service::all(), 'categories' => Category::all(),
            'balance' => Auth::user()->current_balance,
            'transaction' => Transaction::where('user_id', Auth::user()->id)->count()
        ]);
    }

    public function indexAgent(){
        return view('components.home_agent.index');
    }

    public function indexAdmin(){
        return view('components.home_admin.index');
    }

    public function showEditProfile(){
        return view('components.home.edit-profile',
            [
                'users' => UserPhoto::where('user_id', Auth::user()->id)->get(),
                'useraddresses' => ServiceAddress::where('user_id', Auth::user()->id)->get()
            ]);
    }

}
