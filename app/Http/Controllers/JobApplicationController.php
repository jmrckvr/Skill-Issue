<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use App\Traits\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests as LaravelAuthorizesRequests;

class JobApplicationController extends Controller
{
    use LaravelAuthorizesRequests;

    /**
     * Show the application form for a specific job.
     */
    public function apply(Job $job)
    {
        // Check if user is an applicant
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!auth()->user()->isApplicant()) {
            return back()->with('error', 'Only applicants can apply for jobs.');
        }

        // Verify email
        if (!auth()->user()->email_verified_at) {
            return back()->with('error', 'Please verify your email before applying.');
        }

        // Check if user already applied
        $alreadyApplied = JobApplication::where('job_id', $job->id)
            ->where('user_id', auth()->id())
            ->exists();

        if ($alreadyApplied) {
            return back()->with('error', 'You have already applied for this job.');
        }

        return view('applications.apply', compact('job'));
    }

    /**
     * Store a new job application.
     * Only applicants can apply for jobs.
     */
    public function store(Request $request, $jobId)
    {
        // Check if user is an applicant
        if (!auth()->check() || !auth()->user()->isApplicant()) {
            $message = 'Only applicants can apply for jobs.';
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $message], 403);
            }
            return back()->with('error', $message);
        }

        // Verify email
        if (!auth()->user()->email_verified_at) {
            $message = 'Please verify your email before applying.';
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $message], 403);
            }
            return back()->with('error', $message);
        }

        $job = Job::findOrFail($jobId);

        // Check if user already applied
        $existingApplication = JobApplication::where('job_id', $jobId)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingApplication) {
            $message = 'You have already applied for this job.';
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $message], 422);
            }
            return back()->with('error', $message);
        }

        $validated = $request->validate([
            'resume' => 'required|file|mimes:pdf,doc,docx|max:5120',
            'cover_letter' => 'nullable|string|max:2000',
        ]);

        // Store resume
        $resumePath = $request->file('resume')->store('resumes', 'public');

        $user = auth()->user();

        // Create application with applicant snapshot data
        $application = JobApplication::create([
            'job_id' => $jobId,
            'user_id' => auth()->id(),
            'resume_path' => $resumePath,
            'cover_letter' => $validated['cover_letter'] ?? null,
            'status' => 'pending',
            // Applicant snapshot data
            'applicant_name' => $user->name,
            'applicant_email' => $user->email,
            'applicant_phone' => $user->contact_number,
            'applicant_location' => $user->location,
            'applicant_skills' => $user->skills,
            'applicant_bio' => $user->bio,
            'applicant_profile_picture' => $user->profile_picture,
            'application_status' => 'pending',
        ]);

        // Update job application count
        $job->increment('application_count');

        // TODO: Send email notification

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Application submitted successfully!',
                'application_id' => $application->id
            ]);
        }

        return redirect()->route('applications.success', ['application' => $application->id])
            ->with('success', 'Application submitted successfully!');
    }

    /**
     * Show application success page.
     */
    public function success($applicationId)
    {
        $application = JobApplication::with('job')->findOrFail($applicationId);

        // Check authorization
        if ($application->user_id !== auth()->id()) {
            abort(403);
        }

        return view('applications.success', compact('application'));
    }

    /**
     * Withdraw a job application.
     * Only the applicant who submitted the application can withdraw.
     */
    public function withdraw($applicationId)
    {
        $application = JobApplication::findOrFail($applicationId);

        // Check authorization
        $this->authorize('withdraw', $application);

        if ($application->status === 'withdrawn') {
            return back()->with('info', 'Application already withdrawn.');
        }

        $application->update(['status' => 'withdrawn']);
        $application->job->decrement('application_count');

        return back()->with('success', 'Application withdrawn successfully.');
    }

    /**
     * Update application status.
     * Only the employer of the job or admin can update status.
     * Status options: pending, reviewed, accepted (hired), rejected
     */
    public function updateStatus(Request $request, $applicationId)
    {
        $application = JobApplication::findOrFail($applicationId);

        // Check authorization
        $this->authorize('updateStatus', $application);

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

    /**
     * Download resume.
     * Only the applicant or employer/admin for this job can download.
     */
    public function downloadResume($applicationId)
    {
        $application = JobApplication::findOrFail($applicationId);

        // Check authorization - applicant or employer
        if (
            $application->user_id !== auth()->id() &&
            $application->job->company->user_id !== auth()->id() &&
            !auth()->user()->isAdmin()
        ) {
            return back()->with('error', 'Unauthorized action.');
        }

        return Storage::download('public/' . $application->resume_path);
    }

    /**
     * Show application details as JSON (API).
     * Used for displaying application details in a modal/side-panel.
     */
    public function showAPI(JobApplication $application)
    {
        // Check authorization - employer of the job or the applicant
        if (
            auth()->id() !== $application->job->company->user_id &&
            auth()->id() !== $application->user_id &&
            !auth()->user()?->isAdmin()
        ) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json([
            'id' => $application->id,
            'job_id' => $application->job_id,
            'user_id' => $application->user_id,
            'status' => $application->status,
            'created_at' => $application->created_at,
            'applicant_name' => $application->applicant_name,
            'applicant_email' => $application->applicant_email,
            'applicant_phone' => $application->applicant_phone,
            'applicant_location' => $application->applicant_location,
            'applicant_skills' => $application->applicant_skills,
            'applicant_bio' => $application->applicant_bio,
            'applicant_profile_picture' => $application->applicant_profile_picture,
            'cover_letter' => $application->cover_letter,
            'resume_path' => $application->resume_path,
            'job' => [
                'id' => $application->job->id,
                'title' => $application->job->title,
                'company' => [
                    'id' => $application->job->company->id,
                    'name' => $application->job->company->name,
                ]
            ]
        ]);
    }
}
