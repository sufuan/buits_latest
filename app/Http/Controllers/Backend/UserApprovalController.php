<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Mail\AdminNotificationMail;
use App\Mail\UserApprovedMail;
use App\PendingUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UserApprovalController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }

    /**
     * Display a listing of users waiting for approval.
     */
    public function index(Request $request)
    {
        // Check if user has permission to view approvals
        if (is_null($this->user) || !$this->user->can('user.approve')) {
            abort(403, 'Sorry !! You are Unauthorized to view any user !');
        }

        // Mark notifications as read if the parameter is present
        if ($request->has('markAsRead')) {
            // Get the unread notifications for the authenticated admin user
            $notifications = $this->user->unreadNotifications;

            // Mark each notification as read
            foreach ($notifications as $notification) {
                $notification->markAsRead();
            }
        }

        // Fetch users waiting for approval
        $users = PendingUser::all(); // Fetch users waiting for approval

        // Return the view with users
        return view('backend.pages.users.newuserrequest', compact('users'));
    }

    public function approve($id)
    {
        // Fetch the pending user by ID
        $pendingUser = PendingUser::findOrFail($id);
    
        // Validate required fields
        $validator = Validator::make($pendingUser->toArray(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
    
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
        $departmentCode = $departmentCodes[$pendingUser->department] ?? null;
    
        // Check if the department code is valid
        if (!$departmentCode) {
            return response()->json(['error' => 'Invalid department.'], 422);
        }
    
        // Extract last two digits of the session (assuming session format is YYYY-YYYY)
        $sessionYear = explode('-', $pendingUser->session);
        $lastTwoDigitsOfSession = substr(end($sessionYear), -2);
    
        // Generate the new member ID
        $memberId = $this->generateNewMemberId($departmentCode, $lastTwoDigitsOfSession);
    
  
    
        // Create a new user based on the pending user's data
        $newUser = User::create([
            'name' => $pendingUser->name,
            'email' => $pendingUser->email,
            'password' =>$pendingUser->password, // Hash the password
            'phone' => $pendingUser->phone,
            'department' => $pendingUser->department,
            'session' => $pendingUser->session,
            'usertype' => $pendingUser->usertype,
            'gender' => $pendingUser->gender,
            'date_of_birth' => $pendingUser->date_of_birth,
            'blood_group' => $pendingUser->blood_group,
            'class_roll' => $pendingUser->class_roll,
            'father_name' => $pendingUser->father_name,
            'mother_name' => $pendingUser->mother_name,
            'current_address' => $pendingUser->current_address,
            'permanent_address' => $pendingUser->permanent_address,
            'member_id' => $memberId, // Assign the generated member_id
            'transaction_id' => $pendingUser->transaction_id,
            'to_account' => $pendingUser->to_account,
            'is_approved' => true,
        ]);
    
        // Remove the pending user after successful approval
        $pendingUser->delete();
    

        Mail::to($newUser->email)->send(new UserApprovedMail($newUser));
        Mail::to('info.buits@gmail.com')->send(new AdminNotificationMail($newUser));

        return response()->json(['success' => true]);
    }
    
    /**
     * Generate a new unique member ID based on the highest numeric part across all member IDs.
     */
    private function generateNewMemberId($departmentCode, $lastTwoDigitsOfSession)
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
