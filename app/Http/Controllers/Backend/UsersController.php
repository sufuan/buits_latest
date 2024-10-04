<?php

namespace App\Http\Controllers\Backend;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Imports\UsersImport;
use App\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{
    // Fetch user data for the Bootstrap table
    public function userlist(Request $request)
    {
        // Get pagination parameters
        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);

        // Apply search filter if present
        $search = $request->input('search', '');
        $query = User::query();

        if (!empty($search)) {
            $query->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%");
        }

        // Get total number of users
        $total = $query->count();

        // Get users with pagination
        $users = $query->skip($offset)->take($limit)->get();

        return response()->json([
            'total' => $total,
            'rows' => $users,
        ]);
    }




    // Display a listing of the users
    public function index()
    {
        // Fetch all users from the database
        $users = User::all();

        // Pass users to the view
        return view('backend.pages.users.index', compact('users'));
    }





    // Show the form for creating a new user
    public function create()
    {
        return view('backend.pages.users.create');
    }




    // Store a newly created user in storage
    public function store(Request $request)
    {
        // Validation logic here
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        // Create a new user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Redirect to the users index
        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }





    // Display the specified user
    public function show(User $user)
    {
        return view('backend.pages.users.show', compact('user'));
    }

    // Show the form for editing the specified user
    public function edit(User $user)
    {
        return view('backend.pages.users.edit', compact('user'));
    }






    // Update the specified user in storage
    public function update(Request $request, User $user)
    {
        // Validation logic here
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        // Update user details
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }





    // Remove the specified user from storage
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }



    public function importView()
    {
        return view('backend.pages.users.bulkImport'); // View for the bulk import form
    }

    public function import(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'import_file' => 'required|file|mimes:xlsx,xls,csv|max:2048',
        ], [
            'import_file.required' => 'Please upload an Excel or CSV file.',
            'import_file.mimes' => 'The uploaded file must be in Excel (xlsx, xls) or CSV format.',
            'import_file.max' => 'The uploaded file size cannot exceed 2MB.',
        ]);
    
        try {
            // Import the file
            Excel::import(new UsersImport, $request->file('import_file'));
    
            // Redirect with success message
            return redirect()->back()->with('success', 'Users Imported Successfully.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            // Handle the validation errors from Excel rows
            $failures = $e->failures();
    
            // Gather all error messages
            $errorMessages = [];
            foreach ($failures as $failure) {
                foreach ($failure->errors() as $error) {
                    $errorMessages[] = "Row {$failure->row()}: {$error}";
                }
            }
    
            // Redirect back with the list of error messages
            return redirect()->back()->with('error', 'Import failed due to validation errors.')->withErrors($errorMessages);
        } catch (\Exception $e) {
            // Log the error for debugging
          
    
            // Redirect with error message
            return redirect()->back()->with('error', 'Error importing users: ' . $e->getMessage());
        }
    }
    
    

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx'); // Export the user data as an Excel file
    }

}
