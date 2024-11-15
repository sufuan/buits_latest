<?php

namespace App\Http\Controllers\Backend;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Imports\UsersImport;
use App\Services\MemberIdService;
use App\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;



class UsersController extends Controller
{
    public function userlist(Request $request)
    {
        // Fetch all users, including soft-deleted ones
        $totalNotFiltered = User::withTrashed()->count();
    
        // Query for users, applying any search filter
        $usersQuery = User::withTrashed();
    
        if ($request->has('search')) {
            $search = $request->input('search');
            $usersQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
    
        // Retrieve all matching records without pagination
        $users = $usersQuery->get();
    
        // Return JSON response with all data for client-side pagination
        return response()->json([
            'total' => $users->count(),           // Total number of filtered records
            'totalNotFiltered' => $totalNotFiltered,  // Total number of records without filters
            'rows' => $users,                     // All data rows
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






    // Show the form for creating a new user
    public function create()
    {

        $departments = $this->getDepartments();
        return view('backend.pages.users.create', compact('departments'));
    }





    protected $memberIdService;

    public function __construct(MemberIdService $memberIdService)
    {
        $this->memberIdService = $memberIdService;
    }

    public function store(Request $request)
    {
        // Validation logic here
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'department' => 'required',
            'session' => 'required',
            'phone' => 'required',
            'date_of_birth' => 'required|date',
            'blood_group' => 'required',
            'class_roll' => 'required|string',
            'father_name' => 'required|string',
            'mother_name' => 'required|string',
            'current_address' => 'required|string',
            'permanent_address' => 'nullable|string',
            'skills' => 'nullable|string',
            'transaction_id' => 'required|string',
        ]);

        // Handle image upload and resizing
        $imagePath = null;
        if ($request->file('image')) {
            $manager = new ImageManager();
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image = $manager->make($image)->resize(300, 300);
            $image->save(public_path('images/users/profile/' . $imageName));
            $imagePath = 'images/users/profile/' . $imageName;
        }

        // Generate the new member ID (for new user creation)
        $memberId = $this->memberIdService->generateNewMemberId((object)[
            'department' => $request->department,
            'session' => $request->session,
        ]);

        Log::info('Generated Member ID: ' . $memberId);

        // Create a new user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'image' => $imagePath,
            'department' => $request->department,
            'session' => $request->session,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'blood_group' => $request->blood_group,
            'class_roll' => $request->class_roll,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'current_address' => $request->current_address,
            'permanent_address' => $request->permanent_address,
            'skills' => $request->skills,
            'transaction_id' => $request->transaction_id,
            'member_id' => $memberId,
        ]);

        // Redirect to the users index
        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function update(Request $request, User $user)
    {
        // Validation logic here
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'department' => 'required',
            'session' => 'required',
        ]);



        // Check if department or session has changed to update member_id
        if ($user->department !== $request->department || $user->session !== $request->session) {
            $memberId = $this->memberIdService->generateNewMemberId((object)[
                'department' => $request->department,
                'session' => $request->session,
            ], true, $user->member_id);
        } else {
            $memberId = $user->member_id;
        }

        // Update user details
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->filled('password') ? bcrypt($request->password) : $user->password,

            'department' => $request->department,
            'session' => $request->session,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'blood_group' => $request->blood_group,
            'class_roll' => $request->class_roll,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'current_address' => $request->current_address,
            'permanent_address' => $request->permanent_address,
            'skills' => $request->skills,
            'transaction_id' => $request->transaction_id,
            'member_id' => $memberId,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }



    //    display specific user 

    public function show($id)
    {
        // Fetch the user by ID
        $user = User::findOrFail($id);

        // Return the view to display the user's details
        return view('backend.pages.users.showsingleuser', compact('user'));
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        $departments = $this->getDepartments();

        return view('backend.pages.users.edit', compact('user', 'departments'));
    }





    // Remove the specified user from storage
    public function destroy(User $user)
    {
        // Delete the user image if exists
        if ($user->image && Storage::disk('public')->exists($user->image)) {
            Storage::disk('public')->delete($user->image);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully.',
            'user_id' => $user->id,
        ]);
    }




    public function uploadImage(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:5120', // 5 MB Max
        ]);

        // Find the user
        $user = User::findOrFail($id); // Make sure to import User model at the top

        // Handle file upload
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }

            // Store new image
            $path = $request->file('image')->store('profile_images', 'public');

            // Update the user's image path in the database
            $user->image = $path;
            $user->save();
        }

        // Flash success message and redirect back
        session()->flash('success', 'Profile picture updated successfully!');
        return redirect()->route('admin.users.edit', $id); // Redirect back to the edit page
    }






    // Add this method in your UsersController

    public function search(Request $request)
    {
        // Get the search term from the request
        $searchTerm = $request->input('search');

        // Initialize an empty users array if no search term is provided
        $users = [];

        if ($searchTerm) {
            // Store the search term in the session
            $request->session()->put('search', $searchTerm);

            // Query the database to find users by email, phone, or member_id
            $users = User::where('email', 'like', '%' . $searchTerm . '%')
                ->orWhere('phone', 'like', '%' . $searchTerm . '%')
                ->orWhere('member_id', 'like', '%' . $searchTerm . '%')
                ->orWhere('name', 'like', '%' . $searchTerm . '%')
                ->get();
        }

        // Clear the search term from the session after retrieving it
        $request->session()->forget('search');

        // Return the search view with users data and the search term
        return view('userSearch', compact('users', 'searchTerm'));
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
            Log::error('Error importing users: ' . $e->getMessage());

            // Redirect with error message
            return redirect()->back()->with('error', 'Error importing users: ' . $e->getMessage());
        }
    }




    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx'); // Export the user data as an Excel file
    }
}
