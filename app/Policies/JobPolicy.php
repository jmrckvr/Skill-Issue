<?php

namespace App\Policies;

use App\Models\Job;
use App\Models\User;

class JobPolicy
{
    /**
     * Determine whether the user can view a job.
     * Everyone (including guests) can view published jobs.
     */
    public function view(User $user = null, Job $job = null): bool
    {
        // If no user logged in (guest), can view published jobs
        if ($user === null) {
            return $job ? $job->status === 'published' : false;
        }

        // If user is logged in, can view their own jobs or published jobs
        if ($user->isAdmin()) {
            return true;
        }

        return $job->status === 'published' || $job->company->user_id === $user->id;
    }

    /**
     * Determine whether the user can create a job.
     * Only employers and admins can create jobs.
     */
    public function create(User $user): bool
    {
        return $user->canPostJobs();
    }

    /**
     * Determine whether the user can update a job.
     * Only the job owner (employer) or admin can update.
     */
    public function update(User $user, Job $job): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->isEmployer() && $job->company->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete a job.
     * Only the job owner (employer) or admin can delete.
     */
    public function delete(User $user, Job $job): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->isEmployer() && $job->company->user_id === $user->id;
    }

    /**
     * Determine whether the user can publish a job.
     * Only the job owner (employer) or admin can publish.
     */
    public function publish(User $user, Job $job): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->isEmployer() && $job->company->user_id === $user->id;
    }

    /**
     * Determine whether the user can close a job.
     * Only the job owner (employer) or admin can close.
     */
    public function close(User $user, Job $job): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->isEmployer() && $job->company->user_id === $user->id;
    }

    /**
     * Determine whether the user can view applicants.
     * Only the job owner (employer) or admin can view applicants.
     */
    public function viewApplicants(User $user, Job $job): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->isEmployer() && $job->company->user_id === $user->id;
    }

    /**
     * Determine whether the user can approve/reject applicants.
     * Only the job owner (employer) or admin can manage applicants.
     */
    public function approveApplicant(User $user, Job $job): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->isEmployer() && $job->company->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore a soft-deleted job.
     * Only admin can restore.
     */
    public function restore(User $user, Job $job): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete a job.
     * Only admin can force delete.
     */
    public function forceDelete(User $user, Job $job): bool
    {
        return $user->isAdmin();
    }
}
