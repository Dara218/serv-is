<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        return view('components.home.home', ['services' => Service::all()]);
    }

    public function indexAgent(){
        return view('components.home_agent.index');
    }

    public function indexAdmin(){
        return view('components.home_admin.index');
    }

}
