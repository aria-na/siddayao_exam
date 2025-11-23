<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Tweet $tweet)
    {
        $user = Auth::user();
        
        // Check if user already liked this tweet
        $existingLike = $tweet->likes()->where('user_id', $user->id)->first();

        if ($existingLike) {
            // Unlike
            $existingLike->delete();
            $liked = false;
        } else {
            // Like
            $tweet->likes()->create(['user_id' => $user->id]);
            $liked = true;
        }

        // If the request expects JSON (AJAX), return JSON
        if (request()->wantsJson()) {
            return response()->json([
                'liked' => $liked,
                'count' => $tweet->likes()->count(),
            ]);
        }

        return back();
    }
}