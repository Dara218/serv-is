<?php

namespace App\Http\Controllers;

use App\Events\CommentRatingEvent;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->with('userPhoto')->first();

        $request->validate([
            'star_rating' => 'required', 
            'comment' => 'required|min:5|max:200'
        ]);

        $review = Review::create([
            'user_id' => $user->id,
            'employee_id' => $request->agent_id,
            'agent_service_id' => $request->agent_service_id,
            'level' => $request->star_rating,
            'message' => $request->comment
        ]);

        event(new CommentRatingEvent(
            $user->id,
            $request->agent_id,
            $request->agent_service_id,
            $request->star_rating,
            $request->comment,
            $review->id
        ));
        
        return back();
    }

    /*
        TODO: FIX reject button on notif, add appending of new reviews on admin side
     */
}
