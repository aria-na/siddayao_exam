<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileSetupController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// 1. Public Route: Guest can view all tweets
Route::get('/', [TweetController::class, 'index'])->name('home');

// 2. Protected Routes: Must be logged in
Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    
    // Profile Setup (Step 2 Registration)
    Route::get('/profile-setup', [ProfileSetupController::class, 'create'])->name('profile.setup');
    Route::post('/profile-setup', [ProfileSetupController::class, 'store'])->name('profile.setup.store');

    // Dashboard (User Profile View)
    Route::get('/dashboard', function () {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // 1. My Tweets
        $tweets = $user->tweets()->withCount('likes')->latest()->get();
        
        // 2. Tweets I Liked
        // We get the 'likes' table, load the tweet inside it, and pluck the tweet out
        $likedTweets = $user->likes()->with(['tweet.user', 'tweet.likes'])->latest()->get()->pluck('tweet');

        // 3. Total Likes Received (Sum of likes on my tweets)
        $totalLikesReceived = $tweets->sum('likes_count');
        
        return view('dashboard', compact('user', 'tweets', 'likedTweets', 'totalLikesReceived'));
    })->name('dashboard');

    // Tweet Actions
    Route::post('/tweets', [TweetController::class, 'store'])->name('tweets.store');
    Route::patch('/tweets/{tweet}', [TweetController::class, 'update'])->name('tweets.update');
    Route::delete('/tweets/{tweet}', [TweetController::class, 'destroy'])->name('tweets.destroy');

    // Like System
    Route::post('/tweets/{tweet}/like', [LikeController::class, 'toggle'])->name('tweets.like');

    // Default Breeze Profile Routes (Settings)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';