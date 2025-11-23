<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TweetController extends Controller
{
    use AuthorizesRequests;

    // 1. Homepage: Show all tweets
    public function index()
    {
        $tweets = Tweet::with('user') // Load author info
            ->withCount('likes') // Count likes efficiently
            ->latest() // Order by newest first
            ->get();

        return view('welcome', compact('tweets'));
    }

    // 2. Store: Create a new tweet
    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:280',
        ]);

        $request->user()->tweets()->create($validated);

        return back()->with('success', 'Thought posted!');
    }

    // 3. Update: Edit a tweet
    public function update(Request $request, Tweet $tweet)
    {
        // Ensure user owns the tweet
        if ($request->user()->id !== $tweet->user_id) {
            abort(403);
        }

        $validated = $request->validate([
            'content' => 'required|string|max:280',
        ]);

        $tweet->update([
            'content' => $validated['content'],
            'is_edited' => true, // Mark as edited
        ]);

        return back()->with('success', 'Thought updated!');
    }

    // 4. Destroy: Delete a tweet
    public function destroy(Tweet $tweet)
    {
        // Ensure user owns the tweet
        if (Auth::id() !== $tweet->user_id) {
            abort(403);
        }

        $tweet->delete();

        return back()->with('success', 'Thought deleted.');
    }
}