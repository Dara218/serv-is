<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Category;
use App\Models\SentRequest;
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

    public function indexAgent()
    {
        // $agendas = Agenda::where('is_available', true)->with('sentRequest')->get();

        // $sentRequest = '';

        // foreach($agendas as $agenda){
        //     $sentRequest = SentRequest::where('request_by', Auth::user()->id)->where('request_to', $agenda->user->id)->where('type', 1)->with('agenda')->get();
        // }

        return view('components.home_agent.index',
        [
            'balance' => Auth::user()->current_balance,
            'services' => Transaction::where('user_id', Auth::user()->id)->count(),
            'agendas' => Agenda::where('is_available', true)->get(),
            // 'request' =>  $sentRequest
        ]);
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
