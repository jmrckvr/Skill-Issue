<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JobApplicationController extends Controller
{
    public function store(Request $request, $jobId)
    {
        if (!auth()->check() || !auth()->user()->isJobseeker()) {
            return back()->with('error', 'Only jobseekers can apply for jobs.');
        }

        if (!auth()->user()->email_verified_at) {
            return back()->with('error', 'Please verify your email before applying.');
        }

        $job = Job::findOrFail($jobId);

        // Check if user already applied
        $existingApplication = JobApplication::where('job_id', $jobId)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingApplication) {
            return back()->with('error', 'You have already applied for this job.');
        }

        $validated = $request->validate([
            'resume' => 'required|file|mimes:pdf,doc,docx|max:5120',
            'cover_letter' => 'nullable|string|max:2000',
        ]);

        // Store resume
        $resumePath = $request->file('resume')->store('resumes', 'public');

        // Create application
        $application = JobApplication::create([
            'job_id' => $jobId,
            'user_id' => auth()->id(),
            'resume_path' => $resumePath,
            'cover_letter' => $validated['cover_letter'] ?? null,
            'status' => 'pending',
        ]);

        // Update job application count
        $job->increment('application_count');

        // TODO: Send email notification

        return back()->with('success', 'Application submitted successfully!');
    }

    public function withdraw($applicationId)
    {
        $application = JobApplication::findOrFail($applicationId);

        if ($application->user_id != auth()->id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        if ($application->status === 'withdrawn') {
            return back()->with('info', 'Application already withdrawn.');
        }

        $application->update(['status' => 'withdrawn']);
        $application->job->decrement('application_count');

        return back()->with('success', 'Application withdrawn successfully.');
    }

    public function updateStatus(Request $request, $applicationId)
    {
        $application = JobApplication::findOrFail($applicationId);
        $job = $application->job;

        // Check if user is employer for this job
        if ($job->company->user_id != auth()->id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,reviewed,accepted,rejected',
            'rejection_reason' => 'nullable|string|max:1000',
        ]);

        $application->update([
            'status' => $validated['status'],
            'rejection_reason' => $validated['rejection_reason'] ?? null,
            'reviewed_at' => now(),
        ]);

        // TODO: Send email notification to applicant

        return back()->with('success', 'Application status updated.');
    }

    public function downloadResume($applicationId)
    {
        $application = JobApplication::findOrFail($applicationId);
        $job = $application->job;

        // Check authorization
        if ($job->company->user_id != auth()->id() && $application->user_id != auth()->id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        return Storage::download('public/' . $application->resume_path);
    }
}
