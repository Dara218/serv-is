<?php

namespace App\Http\Controllers;

use App\Models\AdminRequest;
use App\Models\Agenda;
use App\Models\AvailedPricingPlan;
use App\Models\Category;
use App\Models\Review;
use App\Models\Service;
use App\Models\ServiceAddress;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserPhoto;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        return view('components.home',
        [
            // 'services' => AgentService::where('is_pending', 0)->inRandomOrder()->paginate(6),
            'categories' => Category::all(),
            'balance' => Auth::user()->current_balance,
            'transaction' => Transaction::where('user_id', Auth::user()->id)->count(),
            'services' => Service::all()
        ]);
    }

    public function indexAgent()
    {
        $user = Auth::user();

        return view('components.home-agent.index',
        [
            'balance' => $user->current_balance,
            'services' => Transaction::where('user_id', $user->id)->count(),
            'agendas' => Agenda::where('is_available', true)
                                ->where('deadline', '>', now())
                                ->with('userPhoto')
                                ->get(),
            'accepted' => AdminRequest::where('request_by', $user->id)
                                        ->where('type', 1)
                                        ->where('is_accepted', false)
                                        ->exists(),
            'reviews' => Review::where('employee_id', Auth::user()->id)->with('user.userPhoto')
                                ->orderBy('created_at', 'DESC')
                                ->get(),
            'totalservices' => AvailedPricingPlan::where('availed_to_id', $user->id)->count(),
            'finishedservice' => AvailedPricingPlan::where('availed_to_id', $user->id)
                                                    ->where('is_expired', true)
                                                    ->count()
        ]);
    }

    public function indexAdmin(){
        return view('components.home-admin.index', [
            'users' => User::where('user_type', '!=', 1)
                            ->with('serviceAddress', 'userPhoto', 'serviceAddress', 'transaction', 'agenda', 'review', 'agentService')
                            ->paginate(10)
        ]);
    }

    public function showEditProfile(){
        return view('components.home.edit-profile',
            [
                'users' => User::where('id', Auth::user()->id)->with('userPhoto')->first(),
                'useraddress' => ServiceAddress::where('user_id', Auth::user()->id)
                                                ->where('is_primary', true)
                                                ->first()
            ]);
    }

    public function showManageWebsite(){
        return view('components.home-admin.manage-website');
    }

}
