<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin; // Import the Admin model
use App\Notifications\NewUserRegistered; // Import the notification class
use App\PendingUser;
use App\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
 // In your RegisterController or the relevant controller method
public function create()
{
    $departments = [
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

    return view('auth.register', compact('departments'));
}


    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {

        // dd($request->all()); // To check all form data
        $request->request->remove('_token');

        // Validate the standard user fields
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'session' => ['required', 'string', 'regex:/^\d{4}-\d{4}$/'],  
            'gender' => ['required', 'string', 'max:255'],
            'class_roll' => ['required', 'string'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'mother_name' => ['nullable', 'string', 'max:255'],
            'current_address' => ['nullable', 'string', 'max:255'],
            'permanent_address' => ['nullable', 'string', 'max:255'],
            'transaction_id' => ['required', 'string', 'max:255'],
            'to_account' => ['required','string',]

        ]);

        // Create the pending user
        $pendingUser = PendingUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'department' => $request->department,
            'session' => $request->session,
            'usertype' => 'user', // default value for usertype
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'class_roll' => $request->class_roll,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'current_address' => $request->current_address,
            'permanent_address' => $request->permanent_address,
            'transaction_id' => $request->transaction_id,
            'to_account' => $request->to_account,
        ]);

        // Notify all admins about the new user registration
        $admins = Admin::all(); // Query the Admin model to get all admins
        foreach ($admins as $admin) {
            $admin->notify(new NewUserRegistered($pendingUser)); // Send the notification
        }

        return redirect()->route('login')->with('status', 'Registration successful! Please wait for approval.');
    }
}
