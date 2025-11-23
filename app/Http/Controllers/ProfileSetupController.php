<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileSetupController extends Controller
{
    // Show the "Finish your profile" form
    public function create()
    {
        return view('auth.profile-setup');
    }

    // Save Display Name and Photo
    public function store(Request $request)
    {
        $request->validate([
            'display_name' => 'required|string|max:255',
            'profile_photo' => 'nullable|image|max:2048', // Max 2MB
        ]);

        $user = $request->user();
        $user->display_name = $request->display_name;

        // Handle Photo Upload
        if ($request->hasFile('profile_photo')) {
            // Store in 'storage/app/public/profile-photos'
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_photo_path = $path;
        }

        $user->save();

        return redirect()->route('dashboard')->with('success', "You're all set. Enjoy!");
    }
}