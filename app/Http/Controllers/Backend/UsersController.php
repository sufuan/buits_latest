<?php

namespace App\Http\Controllers\Backend;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Imports\UsersImport;
use App\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;



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



    public function store(Request $request)
    {
        // Validation logic here
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validate image
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
            $manager = new ImageManager(new Driver());

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); // Generate unique file name

            $image = $manager->read($image);
            $image->resize(300, 300);
            $image->toJpeg(75)->save(base_path('public/images/users/profile/' . $imageName));
            $imagePath = 'images/users/profile/' . $imageName; // Store relative path
        }

        // Generate the new member ID
        $memberId = $this->generateNewMemberId((object) [
            'department' => $request->department,
            'session' => $request->session,
        ]);

        Log::info('Generated Member ID: ' . $memberId);

        // Create a new user and save the image path in the database if applicable
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'image' => $imagePath, // Save the image path in the database
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
            'member_id' => $memberId, // Add member_id to the user
        ]);

        // Redirect to the users index
        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
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

    // Update the specified user in storage
    public function update(Request $request, User $user)
    {
        // Validation logic here
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6', // Ensure password validation
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validate image
            // Add additional validation rules for other fields as needed
            'department' => 'required',
            'session' => 'required',
            'phone' => 'nullable|string|max:15',
            'date_of_birth' => 'nullable|date',
            'blood_group' => 'nullable|string',
            'class_roll' => 'nullable|string',
            'father_name' => 'nullable|string',
            'mother_name' => 'nullable|string',
            'current_address' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'skills' => 'nullable|string',
            'transaction_id' => 'nullable|string',
        ]);

        // Handle the image upload if an image is provided
        $imagePath = $user->image; // Default to existing image path
        if ($request->hasFile('image')) {
            // Store the new image and get the path
            $imagePath = $request->file('image')->store('images', 'public');
        }

        // Update user details
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->filled('password') ? bcrypt($request->password) : $user->password, // Only update password if provided
            'image' => $imagePath, // Save the image path
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
            'member_id' => $user->member_id, // Assuming member_id is unchanged; adjust if needed
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    // Remove the specified user from storage
    public function destroy(User $user)
    {
        // Delete the user image if exists
        if ($user->image && Storage::disk('public')->exists($user->image)) {
            Storage::disk('public')->delete($user->image);
        }

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
