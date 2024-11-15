<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\MemberIdService; // Make sure this service is created as shown earlier
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    protected $memberIdService;

    // Inject the MemberIdService to handle member ID generation
    public function __construct(MemberIdService $memberIdService)
    {
        $this->memberIdService = $memberIdService;
    }

    /**
     * Get the list of departments.
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



    public function showProfile()
    {
        $user = Auth::user(); // Get the authenticated user

        return view('profile.showUserProfile', compact('user'));
    }










    public function edit()
    {
        $user = Auth::user(); // Get the authenticated user
        $departments = $this->getDepartments();
        return view('profile.edit', compact('user', 'departments'));
    }



    /**
     * Update the authenticated user's profile.
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

        // Check if department or session has changed
        $departmentChanged = $user->department !== $request->department;
        $sessionChanged = $user->session !== $request->session;

        if ($departmentChanged || $sessionChanged) {
            // If the department or session has changed, generate a new member ID
            $newMemberId = $this->memberIdService->generateNewMemberId((object)[
                'department' => $request->department,
                'session' => $request->session,
            ], true, $user->member_id);

            $user->member_id = $newMemberId; // Update the member_id
        }

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
        return redirect()->route('profile.edit');
    }





    public function uploadImage(Request $request)
    {
        $user = Auth::user(); // Get the authenticated user

        // Validate the uploaded image
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:1024', // 1 MB max file size
        ]);

        // Delete the old profile image if it exists
        if ($user->image) {
            Storage::delete('public/' . $user->image);
        }

        // Store the new image
        $imagePath = $request->file('image')->store('profile_images', 'public');
        $user->image = $imagePath; // Save image path to the database

        // Save updated user with new image path
        $user->save();

        // Flash success message and redirect back
        session()->flash('success', 'Profile picture has been updated successfully!');
        return redirect()->back();
    }
}
