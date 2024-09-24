<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\User;  // Make sure you are using the correct User model
use Illuminate\Http\Request;

class UserApprovalController extends Controller
{
    /**
     * Display a listing of users waiting for approval.
     */
    public function index()
    {
        // Fetch only users who are not approved yet
        $users = User::where('is_approved', false)->get();
        return view('backend.pages.users.newuserrequest', compact('users'));
    }

    /**
     * Approve the specified user.
     */
    public function approve(User $user)
    {
        // Approve the user
        $user->is_approved = true;
        $user->save();

        return response()->json(['success' => true]);
    }
}
