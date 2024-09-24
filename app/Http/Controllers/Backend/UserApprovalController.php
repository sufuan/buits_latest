<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\PendingUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function index()
    {

        if (is_null($this->user) || !$this->user->can('user.approve')) {
            abort(403, 'Sorry !! You are Unauthorized to view any user !');
        }


        $users = PendingUser::all(); // Fetch users waiting for approval
        return view('backend.pages.users.newuserrequest', compact('users'));
    }

    /**
     * Approve the specified user.
     */
    public function approve($id)
    {
        // Fetch the pending user by ID
        $pendingUser = PendingUser::findOrFail($id);
        
        // Ensure all required fields are present before creating the user
        if (!$pendingUser->name || !$pendingUser->email || !$pendingUser->password) {
            return response()->json(['error' => 'Incomplete data for approval.'], 422);
        }

        // Create a new user based on the pending user's data
        User::create([
            'name' => $pendingUser->name,
            'email' => $pendingUser->email,
            'password' => $pendingUser->password, // Assumes password is already hashed
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
            'is_approved' => true,
        ]);

        // Remove the pending user after successful approval
        $pendingUser->delete();

        return response()->json(['success' => true]);
    }
}
