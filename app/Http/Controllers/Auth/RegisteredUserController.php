<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->request->remove('_token');

        // Validate the standard user fields
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'session' => ['nullable', 'integer'],
            'gender' => ['nullable', 'string', 'max:255'],
            'date_of_birth' => ['nullable', 'date'],
            'blood_group' => ['nullable', 'string', 'max:255'],
            'class_roll' => ['nullable', 'integer'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'mother_name' => ['nullable', 'string', 'max:255'],
            'current_address' => ['nullable', 'string', 'max:255'],
            'permanent_address' => ['nullable', 'string', 'max:255'],
        ]);

        // Extract and validate the custom form data
        $customFormData = $request->except([
            'name', 'email', 'password', 'password_confirmation', 'phone', 'usertype', 'session',
            'department', 'gender', 'date_of_birth', 'blood_group', 'class_roll', 'father_name',
            'mother_name', 'current_address', 'permanent_address'
        ]);

        // Optionally, you can validate custom form data here if needed
        // $request->validate([...]);

        // Create the user with standard attributes and custom form data
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'department' => $request->department,
            'session' => $request->session,
            'usertype' => 'user', // default value for usertype
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'blood_group' => $request->blood_group,
            'class_roll' => $request->class_roll,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'current_address' => $request->current_address,
            'permanent_address' => $request->permanent_address,
            'custom-form' => json_encode($customFormData) // Save custom form data as JSON
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard'));
    }
}
