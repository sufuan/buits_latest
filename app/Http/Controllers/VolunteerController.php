<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Setting;
use App\User; // Make sure to use the correct model namespace
use Illuminate\Http\Request;

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

        // List of departments to show in the registration form
        $departments = [
            'Marketing',
            'Law',
            'Mathematics',
            'Physics',
            'History & Civilization',
            'Soil & Environmental Sciences',
            'Economics',
            'Geology & Mining',
            'Management Studies',
            'Statistics',
            'Chemistry',
            'Coastal Studies and Disaster Management',
            'Accounting & Information Systems',
            'Computer Science and Engineering',
            'Sociology',
            'Botany',
            'Public Administration',
            'Philosophy',
            'Political Science',
            'Biochemistry and Biotechnology',
            'Finance and Banking',
            'Mass Communication and Journalism',
            'English',
            'Bangla',
        ];

        // Proceed to the registration form with the departments
        return view('volunteer.register', compact('departments', 'setting'));
    }

    public function verifyMemberId(Request $request)
    {
        // Validate the member ID
        $request->validate([
            'member_id' => 'required|string|max:255',
        ]);

        // Search for the user by member ID
        $user = User::where('member_id', $request->member_id)->first();

        if (!$user) {
            return redirect()->route('volunteer.register')->withErrors(['member_id' => 'Invalid Member ID or you are not a member. You must register first as member.']);
        }

        // Redirect back to the registration form with the user data
        return redirect()->route('volunteer.register')->with(['user' => $user]);
    }

    public function register(Request $request)
    {
        // Validate form inputs
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:posts,email',
            'phone' => 'nullable|string|max:255',
            'department' => 'required|string',
            'session' => 'required|string|max:9|regex:/^\d{4}-\d{4}$/',
            'member_id' => 'required|string|max:255'
        ]);

        // Create new post
        Post::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'department' => $request->department,
            'session' => $request->session,
            'member_id' => $request->member_id,
            'post_status' => 'pending',
        ]);

        // Redirect with success message
        return redirect()->route('volunteer.register')->with('status', 'Registration submitted successfully. Once you are approved in the viva, you can log in with your email and password.');
    }
}
