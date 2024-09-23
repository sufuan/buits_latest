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
            // Update the post status and associate with the existing user
            $volunteer->post_status = 'published';
            $volunteer->user_id = $existingUser->id;
        } else {
            // Create a new user with volunteer's details
            $user = User::create([
                'name' => $volunteer->name,
                'email' => $volunteer->email,
                'password' => $volunteer->password, // Assuming the password is already hashed
                'phone' => $volunteer->phone,
                // Add other fields as needed
            ]);

            // Update the post status and associate with the new user
            $volunteer->post_status = 'published';
            $volunteer->user_id = $user->id;
        }

        $volunteer->save();

        return redirect()->route('admin.volunteers.view')->with('status', 'Volunteer approved and added to users.');
    }

    // public function updateVolunteerStatus(Request $request, $id)
    // {
    //     \Log::info('Update status called for ID: ' . $id);

    //     $volunteer = Post::findOrFail($id);
    //     $volunteer->post_status = $request->post_status;
    //     $volunteer->save();

    //     return response()->json(['success' => true]);
    // }


    public function updateVolunteerStatus(Request $request, $id)
    {

        if (is_null($this->user) || !$this->user->can('volunteers.approve')) {
            abort(403, 'Sorry !! You are Unauthorized to update any volunteers !');
        }

        // \Log::info('Update status called for ID: ' . $id);

        $volunteer = Post::findOrFail($id);

        // Check if the user already exists
        $existingUser = User::where('email', $volunteer->email)->first();

        if ($existingUser) {
            // Update the post status and associate with the existing user
            $volunteer->post_status = 'published';
            $volunteer->user_id = $existingUser->id; // Replace with the desired status for existing users
        } else {
            // Create a new user with volunteer's details
            $user = User::create([
                'name' => $volunteer->name,
                'email' => $volunteer->email,
                'password' => $volunteer->password, // Assuming the password is already hashed
                'phone' => $volunteer->phone,
                // Add other fields as needed
            ]);

            // Associate with the new user and set status accordingly
            $volunteer->post_status = 'published'; // Replace with the desired status for new users
            $volunteer->user_id = $user->id;
        }

        $volunteer->save();

        return response()->json(['success' => true]);
    }
}
