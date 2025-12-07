<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class EmployerJobController extends Controller
{
    /**
     * Display all jobs for the employer
     */
    public function index(): View
    {
        $company = auth()->user()->company;
        $jobs = $company->jobs()
            ->with('category', 'applications')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('employer.jobs.index', compact('jobs', 'company'));
    }

    /**
     * Show the form for creating a new job
     */
    public function create(): View
    {
        $categories = Category::all();
        return view('employer.jobs.create', compact('categories'));
    }

    /**
     * Store a newly created job
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'job_type' => ['required', 'in:full-time,part-time,contract,temporary,freelance'],
            'experience_level' => ['required', 'in:entry,mid,senior,executive'],
            'salary_min' => ['required', 'numeric', 'min:0'],
            'salary_max' => ['required', 'numeric', 'gte:salary_min'],
            'currency' => ['required', 'string', 'size:3'],
            'hide_salary' => ['sometimes', 'boolean'],
            'category_id' => ['required', 'exists:categories,id'],
            'requirements' => ['nullable', 'string'],
            'benefits' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $company = auth()->user()->company;

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('jobs', 'public');
        }

        $job = $company->jobs()->create([
            ...$validated,
            'status' => 'published',
            'published_at' => now(),
        ]);

        return redirect()->route('employer.jobs.index')
            ->with('success', 'Job listing created successfully!');
    }

    /**
     * Show the form for editing a job
     */
    public function edit(Job $job): View
    {
        $this->authorize('update', $job);
        $categories = Category::all();
        return view('employer.jobs.edit', compact('job', 'categories'));
    }

    /**
     * Update the specified job
     */
    public function update(Request $request, Job $job): RedirectResponse
    {
        $this->authorize('update', $job);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'job_type' => ['required', 'in:full-time,part-time,contract,temporary,freelance'],
            'experience_level' => ['required', 'in:entry,mid,senior,executive'],
            'salary_min' => ['required', 'numeric', 'min:0'],
            'salary_max' => ['required', 'numeric', 'gte:salary_min'],
            'currency' => ['required', 'string', 'size:3'],
            'hide_salary' => ['sometimes', 'boolean'],
            'category_id' => ['required', 'exists:categories,id'],
            'requirements' => ['nullable', 'string'],
            'benefits' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($job->logo) {
                \Storage::disk('public')->delete($job->logo);
            }
            $validated['logo'] = $request->file('logo')->store('jobs', 'public');
        }

        $job->update($validated);

        return redirect()->route('employer.jobs.index')
            ->with('success', 'Job listing updated successfully!');
    }

    /**
     * Delete the specified job
     */
    public function destroy(Job $job): RedirectResponse
    {
        $this->authorize('delete', $job);
        $job->delete();

        return redirect()->route('employer.jobs.index')
            ->with('success', 'Job listing deleted!');
    }

    /**
     * Publish a job
     */
    public function publish(Job $job): RedirectResponse
    {
        $this->authorize('update', $job);

        $job->update([
            'status' => 'published',
            'published_at' => now()
        ]);

        return redirect()->route('employer.jobs.index')
            ->with('success', 'Job published successfully!');
    }

    /**
     * Close a job
     */
    public function close(Job $job): RedirectResponse
    {
        $this->authorize('update', $job);

        $job->update([
            'status' => 'closed',
            'closed_at' => now()
        ]);

        return redirect()->route('employer.jobs.index')
            ->with('success', 'Job closed successfully!');
    }

    /**
     * Show applicants for a specific job
     */
    public function applicants(Job $job): View
    {
        $this->authorize('viewApplicants', $job);

        $applicants = $job->applications()
            ->with('user')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('employer.jobs.applicants', compact('job', 'applicants'));
    }

    /**
     * Show application details
     */
    public function viewApplication(Job $job, JobApplication $application): View
    {
        $this->authorize('viewApplicants', $job);

        return view('employer.jobs.application-detail', compact('application', 'job'));
    }

    /**
     * Approve an applicant
     */
    public function approveApplicant(Job $job, JobApplication $application): RedirectResponse
    {
        $this->authorize('approveApplicant', $job);

        $application->update([
            'status' => 'accepted',
            'reviewed_at' => now(),
        ]);

        $application->refresh();

        return back()->with('success', 'Applicant approved successfully!');
    }

    /**
     * Reject an applicant
     */
    public function rejectApplicant(Job $job, Request $request, JobApplication $application): RedirectResponse
    {
        $this->authorize('approveApplicant', $job);

        $validated = $request->validate([
            'rejection_reason' => ['nullable', 'string', 'max:500'],
        ]);

        $application->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Applicant rejected!');
    }

    /**
     * Download applicant resume
     */
    public function downloadResume(Job $job, JobApplication $application)
    {
        $this->authorize('viewApplicants', $job);

        if (!$application->resume_path) {
            return back()->with('error', 'No resume found for this applicant.');
        }

        return response()->download(storage_path('app/public/' . $application->resume_path));
    }
}
