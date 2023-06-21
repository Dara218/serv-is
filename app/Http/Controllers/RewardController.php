<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    public function getRewards(){
        return response()->json(Reward::all());
    }

    public function updateReward($id, Request $request)
    {
        Reward::find($id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'points' => $request->points
        ]);

        return response()->json($request);
    }
}
