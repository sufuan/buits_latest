<?php

namespace App\Http\Controllers\Backend;

use Log;
use App\User;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VolunteerController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }

    public function showVolunteersView()
    {
        if (is_null($this->user) || !$this->user->can('volunteers.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any Volunteers !');
        }

        return view('backend.pages.volunteers.index');
    }

    public function showPendingVolunteers()
    {
        if (is_null($this->user) || !$this->user->can('volunteers.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any volunteers !');
        }

        $volunteers = Post::all();
        return response()->json([
            'total' => $volunteers->count(),
            'rows' => $volunteers
        ]);
    }

    public function approveVolunteer($id)
    {
        if (is_null($this->user) || !$this->user->can('volunteers.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to update any volunteers !');
        }

        $volunteer = Post::findOrFail($id);

        // Check if the user already exists
        $existingUser = User::where('email', $volunteer->email)->first();

        if ($existingUser) {
            // If user exists, just update the post status to published and associate with the existing user
            $volunteer->post_status = 'published';
            $volunteer->user_id = $existingUser->id;
        } else {
            // Generate a new member ID for the user
            $memberId = $this->generateNewMemberId($volunteer);

            // Create a new user with volunteer's details
            $user = User::create([
                'name' => $volunteer->name,
                'email' => $volunteer->email,
                'password' => $volunteer->password, // Assuming the password is already hashed
                'phone' => $volunteer->phone,
                'member_id' => $memberId, // Assign the generated member ID
                // Add other fields as needed
                'department' => $volunteer->department,
                'session' => $volunteer->session,
                'gender' => $volunteer->gender,
                'date_of_birth' => $volunteer->date_of_birth,
                'blood_group' => $volunteer->blood_group,
                'class_roll' => $volunteer->class_roll,
                'father_name' => $volunteer->father_name,
                'mother_name' => $volunteer->mother_name,
                'current_address' => $volunteer->current_address,
                'permanent_address' => $volunteer->permanent_address,
                'member_id' => $memberId, // Assign the generated member ID
                'transaction_id' => $volunteer->transaction_id,
            ]);

            // Update the post status and associate with the new user
            $volunteer->post_status = 'published';
            $volunteer->user_id = $user->id;
        }

        $volunteer->save();

        return redirect()->route('admin.volunteers.view')->with('status', 'Volunteer approved and added to users.');
    }

    public function updateVolunteerStatus(Request $request, $id)
    {
        if (is_null($this->user) || !$this->user->can('volunteers.approve')) {
            abort(403, 'Sorry !! You are Unauthorized to update any volunteers !');
        }

        $volunteer = Post::findOrFail($id);

        // Check if the user already exists
        $existingUser = User::where('email', $volunteer->email)->first();

        if ($existingUser) {
            // If user exists, just update the post status to published and associate with the existing user
            $volunteer->post_status = 'published';
            $volunteer->user_id = $existingUser->id;
        } else {
            // Generate a new member ID for the user
            $memberId = $this->generateNewMemberId($volunteer);

            // Create a new user with volunteer's details
            $user = User::create([
                'name' => $volunteer->name,
                'email' => $volunteer->email,
                'password' => $volunteer->password, // Assuming the password is already hashed
                'phone' => $volunteer->phone,
                'member_id' => $memberId, // Assign the generated member ID
                // Add other fields as needed
                'department' => $volunteer->department,
                'session' => $volunteer->session,
                'gender' => $volunteer->gender,
                'date_of_birth' => $volunteer->date_of_birth,
                'blood_group' => $volunteer->blood_group,
                'class_roll' => $volunteer->class_roll,
                'father_name' => $volunteer->father_name,
                'mother_name' => $volunteer->mother_name,
                'current_address' => $volunteer->current_address,
                'permanent_address' => $volunteer->permanent_address,
                'member_id' => $memberId, // Assign the generated member ID
                'transaction_id' => $volunteer->transaction_id,
            ]);

            // Associate with the new user and set status accordingly
            $volunteer->post_status = 'published';
            $volunteer->user_id = $user->id;
        }

        $volunteer->save();

        return response()->json(['success' => true]);
    }

    private function generateNewMemberId($volunteer)
    {
        // Define department codes
        $departmentCodes = [
            "Marketing" => "04",
            "Law" => "15",
            "Mathematics" => "05",
            "Physics" => "18",
            "History & Civilization" => "23",
            "Soil & Environmental Sciences" => "10",
            "Economics" => "01",
            "Geology & Mining" => "17",
            "Management Studies" => "03",
            "Statistics" => "24",
            "Chemistry" => "12",
            "Coastal Studies and Disaster Management" => "19",
            "Accounting & Information Systems" => "07",
            "Computer Science and Engineering" => "13",
            "Sociology" => "06",
            "Botany" => "11",
            "Public Administration" => "09",
            "Philosophy" => "20",
            "Political Science" => "16",
            "Biochemistry and Biotechnology" => "21",
            "Finance and Banking" => "14",
            "Mass Communication and Journalism" => "22",
            "English" => "02",
            "Bangla" => "08"
        ];

        // Get department code
        $departmentCode = $departmentCodes[$volunteer->department] ?? null;

        // Check if the department code is valid
        if (!$departmentCode) {
            throw new \Exception('Invalid department.');
        }

        // Extract last two digits of the session (assuming session format is YYYY-YYYY)
        $sessionYear = explode('-', $volunteer->session);
        $lastTwoDigitsOfSession = substr(end($sessionYear), -2);

        // Generate the new member ID
        return $this->generateNewMemberIdHelper($departmentCode, $lastTwoDigitsOfSession);
    }

    private function generateNewMemberIdHelper($departmentCode, $lastTwoDigitsOfSession)
    {
        // Fetch the last member ID by ordering the users table by 'id' in descending order
        $lastMember = User::orderBy('id', 'desc')->first();

        // Initialize the default starting number
        $newFormNumber = 1130;

        if ($lastMember) {
            // Extract the last four digits of the member_id from the last record
            $lastFormNumber = (int)substr($lastMember->member_id, -4);

            // Increment the last form number by 1
            $newFormNumber = $lastFormNumber + 1;
        }

        // Return the new member ID with department code, session year, and the new form number
        $newMemberId = $departmentCode . $lastTwoDigitsOfSession . str_pad($newFormNumber, 4, '0', STR_PAD_LEFT);

        return $newMemberId;
    }
}
