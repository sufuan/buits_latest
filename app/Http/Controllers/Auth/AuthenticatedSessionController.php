<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\User;
use App\PendingUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Check if the user is in the pending_users table
        $pendingUser = PendingUser::where('email', $request->email)->first();
        if ($pendingUser) {
            throw ValidationException::withMessages([
                'email' => __('Your account is pending approval. Please wait for admin approval.'),
            ]);
        }

        // Attempt to authenticate the user
        $request->authenticate();

        // Find the user by their email in the `users` table
        $user = User::where('email', $request->email)->first();

        // Check if the user is approved in the `users` table
        if (!$user->is_approved) {
            Auth::logout();  // Log out the user if they are not approved
            throw ValidationException::withMessages([
                'email' => __('Your account is not approved yet. Please wait for approval.'),
            ]);
        }

        // Regenerate the session to protect against session fixation
        $request->session()->regenerate();

        // Redirect to the intended route after successful login
        return redirect()->intended(route('dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
