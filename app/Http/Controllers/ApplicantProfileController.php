<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApplicantProfileController extends Controller
{
    /**
     * Show the applicant dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Only applicants can access this
        if (!$user || !$user->isApplicant()) {
            return redirect()->route('home');
        }

        $applications = $user->jobApplications()->with('job')->latest()->get();

        return view('applicant.dashboard', [
            'user' => $user,
            'applications' => $applications,
        ]);
    }

    /**
     * Show edit profile form
     */
    public function editProfile()
    {
        $user = Auth::user();

        if (!$user || !$user->isApplicant()) {
            return redirect()->route('home');
        }

        return view('applicant.edit-profile', ['user' => $user]);
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        if (!$user || !$user->isApplicant()) {
            return redirect()->route('home');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'contact_number' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
            'skills' => 'nullable|string|max:1000',
            'bio' => 'nullable|string|max:1000',
            'linkedin_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'portfolio_url' => 'nullable|url|max:255',
        ]);

        $user->update($validated);

        return redirect()->route('applicant.dashboard')->with('success', 'Profile updated successfully!');
    }

    /**
     * Handle profile picture upload
     */
    public function uploadProfilePicture(Request $request)
    {
        $user = Auth::user();

        if (!$user || !$user->isApplicant()) {
            return redirect()->route('home');
        }

        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ]);

        // Delete old picture if exists
        if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        // Store new picture
        $file = $request->file('profile_picture');
        $filename = 'profile_pictures/' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();

        Storage::disk('public')->putFileAs('', $file, $filename);

        $user->update(['profile_picture' => $filename]);

        return redirect()->route('applicant.dashboard')->with('success', 'Profile picture updated successfully!');
    }

    /**
     * Handle resume upload
     */
    public function uploadResume(Request $request)
    {
        $user = Auth::user();

        if (!$user || !$user->isApplicant()) {
            return redirect()->route('home');
        }

        $request->validate([
            'resume' => 'required|mimes:pdf|max:10240', // PDF only, 10MB max
        ]);

        // Delete old resume if exists
        if ($user->resume_path && Storage::disk('public')->exists($user->resume_path)) {
            Storage::disk('public')->delete($user->resume_path);
        }

        // Store new resume
        $file = $request->file('resume');
        $filename = 'resumes/' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();

        Storage::disk('public')->putFileAs('resumes', $file, basename($filename));

        $user->update(['resume_path' => $filename]);

        return redirect()->route('applicant.dashboard')->with('success', 'Resume uploaded successfully!');
    }

    /**
     * Download resume
     */
    public function downloadResume()
    {
        $user = Auth::user();

        if (!$user || !$user->isApplicant() || !$user->resume_path) {
            return redirect()->route('applicant.dashboard');
        }

        return Storage::disk('public')->download($user->resume_path);
    }

    /**
     * Show saved searches page
     */
    public function savedSearches()
    {
        $user = Auth::user();

        if (!$user || !$user->isApplicant()) {
            return redirect()->route('home');
        }

        return view('applicant.saved-searches', ['user' => $user]);
    }

    /**
     * Show saved jobs page
     */
    public function savedJobs()
    {
        $user = Auth::user();

        if (!$user || !$user->isApplicant()) {
            return redirect()->route('home');
        }

        // Get user's saved jobs (using the job_saves relationship)
        $savedJobs = $user->savedJobs()->with('company')->latest()->get();
        $applications = $user->jobApplications()->with('job', 'job.company')->latest()->get();

        return view('applicant.saved-jobs', [
            'user' => $user,
            'savedJobs' => $savedJobs,
            'applications' => $applications,
        ]);
    }

    /**
     * Show job applications page
     */
    public function jobApplications()
    {
        $user = Auth::user();

        if (!$user || !$user->isApplicant()) {
            return redirect()->route('home');
        }

        $applications = $user->jobApplications()->with('job', 'job.company')->latest()->get();

        return view('applicant.job-applications', [
            'user' => $user,
            'applications' => $applications,
        ]);
    }

    /**
     * Show settings page
     */
    public function settings()
    {
        $user = Auth::user();

        if (!$user || !$user->isApplicant()) {
            return redirect()->route('home');
        }

        return view('applicant.settings', ['user' => $user]);
    }
}
