<?php

namespace App\Http\Controllers;

use App\Models\AvailedPricingPlan;
use App\Models\PricingPlan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PricingPlanController extends Controller
{

    public function showPricingPlan(User $user){

        $checkIfUserIsAvailed = AvailedPricingPlan::where('availed_to_id', $user->id)
                                                    ->where('availed_by_id', Auth::user()->id)
                                                    ->exists();

        if(! $checkIfUserIsAvailed){
            return view('components.home.pricing-plan', ['clientToBeAvailed' => $user]);
        }

        return back();
    }

    public function storePricing(Request $request){

        // basic = 1 advance = 2

        $agent = $request->clientToBeAvailed;
        $customer = Auth::user();

        $userBalance = Auth::user()->current_balance;
        $pricingPlanBalance = PricingPlan::where('price', $request->plan);

        $user = AvailedPricingPlan::where('availed_to_id', $agent)
                                    ->where('availed_by_id', $customer->id)
                                    ->exists();

        if(! $user){
            AvailedPricingPlan::create([ //has error
                'availed_to_id' => $agent,
                'availed_by_id' => $customer,
                'pricing_plan_type' => $request->plan
            ]);
        }

        // add payment API.

        if($userBalance < $pricingPlanBalance){
            Alert::error('Cannot Avail Service', 'Insufficient balance.');
            return back();
        }
        else{
            $remainingBalance = $userBalance - $pricingPlanBalance;
            User::where('id', $customer->id)->update(['current_balance', $remainingBalance]);
        }

        return back();
    }
}
