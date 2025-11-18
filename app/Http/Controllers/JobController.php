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
        $this->authorize('create', Job::class);
        return view('jobs.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Job::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'job_type' => 'required|in:full-time,part-time,contract,temporary,freelance',
            'experience_level' => 'required|in:entry,mid,senior,executive',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0',
            'currency' => 'required|string|size:3',
            'hide_salary' => 'boolean',
            'category_id' => 'nullable|exists:categories,id',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
        ]);

        $company = auth()->user()->company;
        if (!$company) {
            return back()->with('error', 'Please create a company profile first.');
        }

        $job = new Job($validated);
        $job->company_id = $company->id;
        $job->status = 'draft';
        $job->save();

        return redirect()->route('employer.jobs.edit', $job)->with('success', 'Job created successfully!');
    }

    public function edit($id)
    {
        $job = Job::findOrFail($id);
        $this->authorize('update', $job);
        
        return view('jobs.edit', compact('job'));
    }

    public function update(Request $request, $id)
    {
        $job = Job::findOrFail($id);
        $this->authorize('update', $job);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'job_type' => 'required|in:full-time,part-time,contract,temporary,freelance',
            'experience_level' => 'required|in:entry,mid,senior,executive',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0',
            'currency' => 'required|string|size:3',
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
        $this->authorize('update', $job);

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
        $this->authorize('update', $job);

        $job->update([
            'status' => 'closed',
            'closed_at' => now(),
        ]);

        return back()->with('success', 'Job closed successfully!');
    }

    public function destroy($id)
    {
        $job = Job::findOrFail($id);
        $this->authorize('delete', $job);

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
}
