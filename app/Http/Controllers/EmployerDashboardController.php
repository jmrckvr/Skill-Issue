<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class EmployerDashboardController extends Controller
{
    /**
     * Show the employer dashboard
     */
    public function index(): View
    {
        $user = auth()->user();
        $company = $user->company;

        // Get statistics
        $totalJobs = $company->jobs()->count();
        $activeJobs = $company->jobs()->where('jobs.status', 'published')->count();
        $totalApplications = $company->applications()->count();
        $pendingApplications = $company->applications()->where('job_applications.status', 'pending')->count();

        // Get recent jobs
        $recentJobs = $company->jobs()
            ->with('applications')
            ->orderByDesc('created_at')
            ->paginate(5);

        // Get recent applications
        $recentApplications = $company->applications()
            ->with(['user', 'job'])
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        return view('employer.dashboard', compact(
            'company',
            'totalJobs',
            'activeJobs',
            'totalApplications',
            'pendingApplications',
            'recentJobs',
            'recentApplications'
        ));
    }

    /**
     * Show company profile
     */
    public function showCompanyProfile(): View
    {
        $company = auth()->user()->company;
        return view('employer.company.profile', compact('company'));
    }

    /**
     * Edit company information
     */
    public function editCompany(): View
    {
        $company = auth()->user()->company;
        return view('employer.company.edit', compact('company'));
    }

    /**
     * Update company information
     */
    public function updateCompany(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'string', 'max:20'],
            'website' => ['nullable', 'url'],
            'description' => ['nullable', 'string'],
            'city' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'industry' => ['nullable', 'string', 'max:255'],
            'employee_count' => ['nullable', 'integer', 'min:1'],
            'logo' => ['nullable', 'image', 'max:2048'],
        ]);

        $company = auth()->user()->company;

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($company->logo_path && file_exists(storage_path('app/public/' . $company->logo_path))) {
                unlink(storage_path('app/public/' . $company->logo_path));
            }

            // Store new logo
            $path = $request->file('logo')->store('company-logos', 'public');
            $validated['logo_path'] = $path;
        }

        $company->update($validated);

        return redirect()->route('employer.dashboard')
            ->with('success', 'Company information updated successfully!');
    }

    /**
     * Upload or update company logo
     */
    public function uploadLogo(Request $request): RedirectResponse
    {
        $request->validate([
            'logo' => ['required', 'image', 'max:2048'],
        ]);

        $company = auth()->user()->company;

        // Delete old logo if exists
        if ($company->logo_path && file_exists(storage_path('app/public/' . $company->logo_path))) {
            unlink(storage_path('app/public/' . $company->logo_path));
        }

        // Store new logo
        $path = $request->file('logo')->store('company-logos', 'public');
        $company->update(['logo_path' => $path]);

        return back()->with('success', 'Company logo updated successfully!');
    }
    /**
     * Delete company logo
     */
    public function deleteLogo(): RedirectResponse
    {
        $company = auth()->user()->company;

        if ($company->logo_path && file_exists(storage_path('app/public/' . $company->logo_path))) {
            unlink(storage_path('app/public/' . $company->logo_path));
        }

        $company->update(['logo_path' => null]);

        return back()->with('success', 'Company logo deleted!');
    }
}
