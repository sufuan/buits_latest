<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VolunteerController extends Controller
{
    public function showRegisterForm()
    {
        return view('volunteer.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:posts',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:255',
            // Add other validations as needed
        ]);

        Post::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'post_status' => 'pending',
            // Add other fields as needed
        ]);

        return redirect()->route('volunteer.register')->with('status', 'Registration submitted successfully. Once you are approved in the viva, you can log in with your email and password.');
    }
}
