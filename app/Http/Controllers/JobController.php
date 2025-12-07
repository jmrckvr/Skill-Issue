<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class JobController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a published job.
     * Public - anyone can view published jobs.
     */
    public function show($id)
    {
        $job = Job::published()
            ->with(['company', 'category', 'applications'])
            ->findOrFail($id);
        $relatedJobs = Job::published()
            ->where('company_id', $job->company_id)
            ->where('id', '!=', $id)
            ->take(5)
            ->get();

        $isSaved = false;
        if (auth()->check()) {
            $isSaved = auth()->user()->savedJobs()->where('job_id', $id)->exists();
        }

        return view('jobs.show', compact('job', 'relatedJobs', 'isSaved'));
    }

    /**
     * Get job details via API.
     * Public - anyone can request.
     */
    public function apiShow($id)
    {
        $job = Job::published()
            ->with(['company', 'category'])
            ->findOrFail($id);

        $isSaved = false;
        if (auth()->check()) {
            $isSaved = auth()->user()->savedJobs()->where('job_id', $id)->exists();
        }

        return response()->json([
            'success' => true,
            'job' => [
                'id' => $job->id,
                'title' => $job->title,
                'description' => $job->description,
                'location' => $job->location,
                'job_type' => $job->job_type,
                'experience_level' => $job->experience_level,
                'category' => $job->category ? $job->category->name : null,
                'salary_min' => $job->salary_min,
                'salary_max' => $job->salary_max,
                'hide_salary' => $job->hide_salary,
                'formatted_salary' => $job->getFormattedSalary(),
                'posted_at' => $job->published_at->diffForHumans(),
                'requirements' => $job->requirements,
                'benefits' => $job->benefits,
                'logo' => $job->logo,
                'is_saved' => $isSaved,
                'company' => [
                    'id' => $job->company->id,
                    'name' => $job->company->name,
                    'logo_path' => $job->company->logo_path,
                    'industry' => $job->company->industry,
                    'employee_count' => $job->company->employee_count,
                ],
            ],
        ]);
    }

    /**
     * Show job creation form.
     * Only employers can create jobs.
     */
    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('employer.job-form', compact('categories'));
    }

    /**
     * Store a new job.
     * Only employers can create jobs.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'job_type' => 'required|in:full-time,part-time,contract,temporary,freelance',
            'experience_level' => 'required|in:entry,mid,senior,executive',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0',
            'hide_salary' => 'boolean',
            'category_id' => 'nullable|exists:categories,id',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
        ]);

        $company = auth()->user()->company;
        if (!$company) {
            return back()->with('error', 'Please create a company profile first.');
        }

        $validated['company_id'] = $company->id;
        $validated['currency'] = 'PHP';
        $validated['status'] = 'draft';
        $validated['hide_salary'] = $validated['hide_salary'] ?? false;

        $job = Job::create($validated);

        return redirect()->route('jobs.edit', $job)->with('success', 'Job created successfully!');
    }

    /**
     * Show job edit form.
     * Only the job owner (employer) or admin can edit.
     */
    public function edit($id)
    {
        $job = Job::findOrFail($id);

        // Check authorization
        $this->authorize('update', $job);

        $categories = \App\Models\Category::all();
        return view('employer.job-form', compact('job', 'categories'));
    }

    /**
     * Update a job.
     * Only the job owner (employer) or admin can update.
     */
    public function update(Request $request, $id)
    {
        $job = Job::findOrFail($id);

        // Check authorization
        $this->authorize('update', $job);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'job_type' => 'required|in:full-time,part-time,contract,temporary,freelance',
            'experience_level' => 'required|in:entry,mid,senior,executive',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0',
            'hide_salary' => 'boolean',
            'category_id' => 'nullable|exists:categories,id',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
        ]);

        $job->update($validated);

        return back()->with('success', 'Job updated successfully!');
    }

    /**
     * Publish a job.
     * Only the job owner (employer) or admin can publish.
     */
    public function publish($id)
    {
        $job = Job::findOrFail($id);

        // Check authorization
        $this->authorize('publish', $job);

        if ($job->status == 'published') {
            return back()->with('info', 'Job is already published.');
        }

        $job->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        return back()->with('success', 'Job published successfully!');
    }

    /**
     * Close a job.
     * Only the job owner (employer) or admin can close.
     */
    public function close($id)
    {
        $job = Job::findOrFail($id);

        // Check authorization
        $this->authorize('close', $job);

        $job->update([
            'status' => 'closed',
            'closed_at' => now(),
        ]);

        return back()->with('success', 'Job closed successfully!');
    }

    /**
     * Delete a job (soft delete).
     * Only the job owner (employer) or admin can delete.
     */
    public function destroy($id)
    {
        $job = Job::findOrFail($id);

        // Check authorization
        $this->authorize('delete', $job);

        $job->delete();

        return back()->with('success', 'Job deleted successfully!');
    }

    /**
     * Save or unsave a job.
     * Only applicants can save jobs.
     */
    public function saveJob(Request $request, $jobId)
    {
        if (!auth()->check()) {
            if ($request->expectsJson() || $request->isJson()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Please login to save jobs.'
                ], 401);
            }
            return back()->with('error', 'Please login to save jobs.');
        }

        // Check if user can save jobs
        if (!auth()->user()->canSaveJobs()) {
            if ($request->expectsJson() || $request->isJson()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Only applicants can save jobs.'
                ], 403);
            }
            return back()->with('error', 'Only applicants can save jobs.');
        }

        $user = auth()->user();
        $job = Job::findOrFail($jobId);

        $existing = $user->savedJobs()->where('job_id', $jobId)->first();

        if ($existing) {
            $existing->delete();
            $message = 'Job removed from saved jobs.';
            $saved = false;
        } else {
            $user->savedJobs()->create(['job_id' => $jobId]);
            $message = 'Job saved successfully!';
            $saved = true;
        }

        if ($request->expectsJson() || $request->isJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'saved' => $saved
            ]);
        }

        return back()->with('success', $message);
    }

    /**
     * Show employer dashboard.
     * Only employers can access.
     */
    public function dashboard()
    {
        $company = auth()->user()->company;
        if (!$company) {
            return view('employer.dashboard', [
                'jobs' => collect(),
                'activeJobs' => 0,
                'totalApplications' => 0,
                'pendingApplications' => 0,
            ]);
        }

        $jobs = Job::where('company_id', $company->id)
            ->paginate(10);

        $activeJobs = Job::where('company_id', $company->id)
            ->where('status', 'published')
            ->count();

        $totalApplications = \App\Models\JobApplication::whereHas('job', function ($q) use ($company) {
            $q->where('company_id', $company->id);
        })->count();

        $pendingApplications = \App\Models\JobApplication::whereHas('job', function ($q) use ($company) {
            $q->where('company_id', $company->id);
        })->where('status', 'pending')->count();

        return view('employer.dashboard', compact('jobs', 'activeJobs', 'totalApplications', 'pendingApplications'));
    }

    /**
     * Show applicants for a job.
     * Only the job owner (employer) or admin can view.
     */
    public function applicants(Job $job, Request $request)
    {
        // Check authorization
        $this->authorize('viewApplicants', $job);

        $query = $job->applications()->with('user');

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $applicants = $query->paginate(10);

        return view('employer.applicants', compact('job', 'applicants'));
    }
}
