<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VolunteerController extends Controller
{
    public function showRegisterForm()
    {
        // Fetch the first setting
        $setting = Setting::first();
    
        // If no settings found, treat it as volunteer application disabled (default behavior)
        if (!$setting || !$setting->volunteer_application_enabled) {
            return view('volunteer.registrationClosed');
        }

        // Proceed to the registration form if enabled
        return view('volunteer.register');
    }

    public function register(Request $request)
    {
        // Validate form inputs and ensure email is unique in 'posts' table
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:posts,email', // Ensure email is unique
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:255',
        ]);

        // Create new post
        Post::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'post_status' => 'pending', // Set status to pending
        ]);

        // Redirect with success message
        return redirect()->route('volunteer.register')->with('status', 'Registration submitted successfully. Once you are approved in the viva, you can log in with your email and password.');
    }
}
