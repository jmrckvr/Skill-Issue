<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobSeekerController extends Controller
{
    public function applications(Request $request)
    {
        $query = auth()->user()->applications()->with('job.company');

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $applications = $query->orderByDesc('created_at')->paginate(10);

        // Get counts for filter tabs
        $allCount = auth()->user()->applications()->count();
        $pendingCount = auth()->user()->applications()->where('status', 'pending')->count();
        $reviewedCount = auth()->user()->applications()->where('status', 'reviewed')->count();
        $acceptedCount = auth()->user()->applications()->where('status', 'accepted')->count();
        $rejectedCount = auth()->user()->applications()->where('status', 'rejected')->count();

        return view('jobseeker.applications', compact(
            'applications',
            'allCount',
            'pendingCount',
            'reviewedCount',
            'acceptedCount',
            'rejectedCount'
        ));
    }
}
