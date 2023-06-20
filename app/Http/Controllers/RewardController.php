<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    public function getRewards(){
        return response()->json(Reward::all());
    }
}
