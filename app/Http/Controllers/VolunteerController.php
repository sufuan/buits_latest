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
        return view('volunteer.register', compact('departments'));
    }

    public function register(Request $request)
    {
        // Validate form inputs and ensure email is unique in 'posts' table
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:posts,email', // Ensure email is unique
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:255',
            'department' => 'required|string', // Validate department selection
            'session' => 'required|string|max:9|regex:/^\d{4}-\d{4}$/', // Validate session format as YYYY-YYYY
        ]);

        // Create new post
        Post::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'department' => $request->department, // Store department
            'session' => $request->session,       // Store session
            'post_status' => 'pending', // Set status to pending
        ]);

        // Redirect with success message
        return redirect()->route('volunteer.register')->with('status', 'Registration submitted successfully. Once you are approved in the viva, you can log in with your email and password.');
    }
}
