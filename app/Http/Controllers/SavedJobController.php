<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\SavedJob;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class SavedJobController extends Controller
{
    /**
     * Save a job for the authenticated applicant.
     */
    public function store(Request $request, Job $job): JsonResponse
    {
        // Ensure user is authenticated and is an applicant
        if (!auth()->check() || !auth()->user()->isApplicant()) {
            return response()->json(['error' => 'Only applicants can save jobs'], 403);
        }

        // Check if job is already saved
        $existing = SavedJob::where('user_id', auth()->id())
            ->where('job_id', $job->id)
            ->first();

        if ($existing) {
            return response()->json(['error' => 'Job already saved'], 400);
        }

        // Create saved job
        SavedJob::create([
            'user_id' => auth()->id(),
            'job_id' => $job->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Job saved successfully',
            'saved' => true,
        ]);
    }

    /**
     * Remove a saved job for the authenticated applicant.
     */
    public function destroy(Request $request, Job $job): JsonResponse
    {
        // Ensure user is authenticated and is an applicant
        if (!auth()->check() || !auth()->user()->isApplicant()) {
            return response()->json(['error' => 'Only applicants can unsave jobs'], 403);
        }

        // Delete saved job
        $deleted = SavedJob::where('user_id', auth()->id())
            ->where('job_id', $job->id)
            ->delete();

        if (!$deleted) {
            return response()->json(['error' => 'Job not found in saved jobs'], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Job removed from saved',
            'saved' => false,
        ]);
    }

    /**
     * Check if a job is saved by the authenticated applicant.
     */
    public function check(Job $job): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json(['saved' => false]);
        }

        $saved = SavedJob::where('user_id', auth()->id())
            ->where('job_id', $job->id)
            ->exists();

        return response()->json(['saved' => $saved]);
    }

    /**
     * Get all saved jobs for the authenticated applicant.
     */
    public function index(): JsonResponse
    {
        if (!auth()->check() || !auth()->user()->isApplicant()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $savedJobs = SavedJob::where('user_id', auth()->id())
            ->with('job', 'job.company')
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($saved) {
                return [
                    'id' => $saved->job->id,
                    'title' => $saved->job->title,
                    'company' => $saved->job->company->name,
                    'location' => $saved->job->location,
                    'job_type' => $saved->job->job_type,
                    'salary_min' => $saved->job->salary_min,
                    'salary_max' => $saved->job->salary_max,
                    'currency' => $saved->job->currency,
                    'saved_at' => $saved->created_at,
                ];
            });

        return response()->json([
            'success' => true,
            'saved_jobs' => $savedJobs,
        ]);
    }
}
