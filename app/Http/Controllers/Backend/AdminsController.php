<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;

class AdminsController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }

    public function index()
    {
        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        if (is_null($this->user) || !$this->user->can('admin.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any admin !');
        }

        $admins = Admin::all();
        return view('backend.pages.admins.index', compact('admins'));
    }

    public function create()
    {
        if (is_null($this->user) || !$this->user->can('admin.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any admin !');
        }

        $roles = Role::all(); // Get all roles
        return view('backend.pages.admins.create', compact('roles'));
    }





    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('admin.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any admin !');
        }

        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|max:100|email|unique:admins',
            'username' => 'required|max:100|unique:admins',
            'password' => 'required|min:6|confirmed',
        ]);

        // Create New Admin
        $admin = new Admin();
        $admin->name = $request->name;
        $admin->username = $request->username;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->save();

        if ($request->roles) {
            $admin->assignRole($request->roles);
        }

        Alert::success('Success', 'Admin has been created successfully!')->showConfirmButton('OK', '#3085d6');

        return redirect()->route('admin.admins.index');
    }







    public function assignRole(Request $request)
    {
        // Check authorization
        // if (is_null($this->user) || !$this->user->can('admin.assignRole')) {
        //     abort(403, 'Sorry !! You are Unauthorized to assign roles to any user!');
        // }
    
        // Validate the incoming request data
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name', // Validate that each role exists in the roles table
        ]);
    
        // Fetch the user by user_id
        $user = User::findOrFail($request->user_id);
    
        // Check if the email already exists in the admins table
        if (Admin::where('email', $user->email)->exists()) {
            return redirect()->back()->withErrors(['email' => 'The email has already been registered as an admin.']);
        }
    
        // Create a new Admin entry
        $admin = new Admin();
        $admin->name = $user->name; // Copy user name
        $admin->username = $user->name; // Copy user username
        $admin->email = $user->email; // Copy user email
        $admin->password = $user->password; // Use the already hashed password from User
    
        $admin->save(); // Save the admin to the admin table
    
        // Assign roles to the new admin
        if ($request->roles) {
            $admin->assignRole($request->roles);
        }
    
        // Success message using an alert
        Alert::success('Success', 'Role has been assigned to the user successfully!')->showConfirmButton('OK', '#3085d6');
    
        // Redirect back to the admins index page
        return redirect()->route('admin.admins.index');
    }
    
    





    public function getUsersByType(Request $request)
    {
        $users = User::where('usertype', $request->usertype)->get();
        return response()->json($users);
    }

    public function edit(int $id)
    {
        if (is_null($this->user) || !$this->user->can('admin.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any admin !');
        }

        $admin = Admin::find($id);
        $roles = Role::all();
        return view('backend.pages.admins.edit', compact('admin', 'roles'));
    }

    public function update(Request $request, int $id)
    {
        if (is_null($this->user) || !$this->user->can('admin.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any admin !');
        }

        if ($id === 1) {
            session()->flash('error', 'Sorry !! You are not authorized to update this Admin as this is the Super Admin.');
            return back();
        }

        $admin = Admin::find($id);

        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|max:100|email|unique:admins,email,' . $id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->username = $request->username;
        if ($request->password) {
            $admin->password = Hash::make($request->password);
        }
        $admin->save();

        $admin->roles()->detach();
        if ($request->roles) {
            $admin->assignRole($request->roles);
        }

        session()->flash('success', 'Admin has been updated !!');
        return back();
    }

    public function destroy(int $id)
    {
        if (is_null($this->user) || !$this->user->can('admin.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any admin !');
        }

        if ($id === 1) {
            session()->flash('error', 'Sorry !! You are not authorized to delete this Admin as this is the Super Admin.');
            return back();
        }

        $admin = Admin::find($id);
        if (!is_null($admin)) {
            $admin->delete();
        }

        session()->flash('success', 'Admin has been Deleted successfully!');
        return back()->withType('message');
    }
}
