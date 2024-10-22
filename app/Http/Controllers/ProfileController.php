<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User; // Adjust if your User model is in a different namespace
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the authenticated user's profile.
     *
     * @return \Illuminate\Http\Response
     */





     private function getDepartments()
     {
         return [
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
     }



 
    public function edit()
    {
        $user = Auth::user(); // Get the authenticated user
        $departments = $this->getDepartments();
        return view('profile.edit', compact('user', 'departments')); // Correct view path

      
    }

    /**
     * Update the authenticated user's profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = Auth::user(); // Get the authenticated user

        // Validate the request
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|email|max:100|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'phone' => 'required',
            'session' => 'nullable',
            'department' => 'nullable',
            'gender' => 'nullable',
            'date_of_birth' => 'nullable|date',
            'blood_group' => 'nullable',
            'class_roll' => 'nullable',
            'father_name' => 'nullable|max:50',
            'mother_name' => 'nullable|max:50',
            'current_address' => 'nullable',
            'permanent_address' => 'nullable',
            'skills' => 'nullable',
        ]);

        // Update user data
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->phone = $request->phone;
        $user->session = $request->session;
        $user->department = $request->department;
        $user->gender = $request->gender;
        $user->date_of_birth = $request->date_of_birth;
        $user->blood_group = $request->blood_group;
        $user->class_roll = $request->class_roll;
        $user->father_name = $request->father_name;
        $user->mother_name = $request->mother_name;
        $user->current_address = $request->current_address;
        $user->permanent_address = $request->permanent_address;
        $user->skills = $request->skills;

        // Save updated user
        $user->save();

        // Flash success message and redirect back
        session()->flash('success', 'Profile has been updated successfully!');
        return redirect()->route('profile.edit'); // Adjust the route as necessary
    }
}
