<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Company;
use Illuminate\Http\Request;

class JobController extends Controller
{
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

    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('employer.job-form', compact('categories'));
    }

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

    public function edit($id)
    {
        $job = Job::findOrFail($id);

        // Verify the job belongs to the current user's company
        if ($job->company_id !== auth()->user()->company->id) {
            abort(403);
        }

        $categories = \App\Models\Category::all();
        return view('employer.job-form', compact('job', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $job = Job::findOrFail($id);

        // Verify the job belongs to the current user's company
        if ($job->company_id !== auth()->user()->company->id) {
            abort(403);
        }

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

    public function publish($id)
    {
        $job = Job::findOrFail($id);

        // Verify the job belongs to the current user's company
        if ($job->company_id !== auth()->user()->company->id) {
            abort(403);
        }

        if ($job->status == 'published') {
            return back()->with('info', 'Job is already published.');
        }

        $job->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        return back()->with('success', 'Job published successfully!');
    }

    public function close($id)
    {
        $job = Job::findOrFail($id);

        // Verify the job belongs to the current user's company
        if ($job->company_id !== auth()->user()->company->id) {
            abort(403);
        }

        $job->update([
            'status' => 'closed',
            'closed_at' => now(),
        ]);

        return back()->with('success', 'Job closed successfully!');
    }

    public function destroy($id)
    {
        $job = Job::findOrFail($id);

        // Verify the job belongs to the current user's company
        if ($job->company_id !== auth()->user()->company->id) {
            abort(403);
        }

        $job->delete();

        return back()->with('success', 'Job deleted successfully!');
    }

    public function saveJob(Request $request, $jobId)
    {
        if (!auth()->check()) {
            return back()->with('error', 'Please login to save jobs.');
        }

        $user = auth()->user();
        $job = Job::findOrFail($jobId);

        $existing = $user->savedJobs()->where('job_id', $jobId)->first();

        if ($existing) {
            $existing->delete();
            return back()->with('success', 'Job removed from saved jobs.');
        } else {
            $user->savedJobs()->create(['job_id' => $jobId]);
            return back()->with('success', 'Job saved successfully!');
        }
    }

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

    public function applicants(Job $job, Request $request)
    {
        // Verify the job belongs to the current user's company
        if ($job->company_id !== auth()->user()->company->id) {
            abort(403);
        }

        $query = $job->applications()->with('user');

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $applicants = $query->paginate(10);

        return view('employer.applicants', compact('job', 'applicants'));
    }
}
