<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class EmployerRegisterController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.employer-register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'company_name' => ['required', 'string', 'max:255'],
            'company_email' => ['required', 'email', 'max:255'],
            'company_phone' => ['required', 'string', 'max:20'],
            'company_website' => ['nullable', 'url'],
            'company_description' => ['nullable', 'string'],
            'company_city' => ['required', 'string', 'max:255'],
            'company_country' => ['required', 'string', 'max:255'],
            'company_industry' => ['nullable', 'string', 'max:255'],
        ]);

        // Create user with employer role
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'employer',
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        // Create company for the user
        Company::create([
            'user_id' => $user->id,
            'name' => $validated['company_name'],
            'email' => $validated['company_email'],
            'phone' => $validated['company_phone'],
            'website' => $validated['company_website'],
            'description' => $validated['company_description'],
            'city' => $validated['company_city'],
            'country' => $validated['company_country'],
            'industry' => $validated['company_industry'],
            'is_verified' => false,
            'state' => null,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('employer.dashboard')->with('success', 'Welcome to JobStreet! Your employer account has been created.');
    }
}
