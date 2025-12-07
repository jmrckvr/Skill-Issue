<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    /**
     * Redirect to Google OAuth
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Unable to authenticate with Google. Please try again.');
        }

        // Find or create user
        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'password' => bcrypt(Str::random(24)),
                'email_verified_at' => now(),
                'role' => 'applicant', // Google Sign-In registration always creates Applicant accounts
            ]
        );

        // Update google_id if it wasn't set
        if (!$user->google_id) {
            $user->update(['google_id' => $googleUser->getId()]);
        }

        // Log the user in
        Auth::login($user, remember: true);

        // Redirect based on user role
        return redirect()->intended(
            match ($user->role) {
                'employer' => route('employer.dashboard', absolute: false),
                'admin' => route('admin.dashboard', absolute: false),
                default => route('dashboard', absolute: false),
            }
        );
    }
}
