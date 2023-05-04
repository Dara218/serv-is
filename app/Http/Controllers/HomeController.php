<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ValidDocument;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){

        $admins = ValidDocument::where('user_type', 1)->get();
        foreach($admins as $admin){

        }

        return view('components.home.home', ['services' => Service::all(),
                                            'admin' => $admin]);
    }

    public function indexAgent(){
        return view('components.home_agent.index');
    }

    public function indexAdmin(){
        return view('components.home_admin.index');
    }

}
