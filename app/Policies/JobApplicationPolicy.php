<?php

namespace App\Policies;

use App\Models\JobApplication;
use App\Models\User;

class JobApplicationPolicy
{
    /**
     * Determine whether the user can view a job application.
     * The applicant can view their own application.
     * The employer can view applications for their jobs.
     * Admin can view all applications.
     */
    public function view(User $user, JobApplication $application): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        // Applicant can view their own applications
        if ($user->isApplicant() && $application->user_id === $user->id) {
            return true;
        }

        // Employer can view applications for their jobs
        if ($user->isEmployer() && $application->job->company->user_id === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create an application.
     * Only applicants can create applications.
     */
    public function create(User $user): bool
    {
        return $user->canApply();
    }

    /**
     * Determine whether the user can update an application (status).
     * Only the employer of the job or admin can update application status.
     */
    public function updateStatus(User $user, JobApplication $application): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->isEmployer() && $application->job->company->user_id === $user->id;
    }

    /**
     * Determine whether the user can withdraw an application.
     * Only the applicant who submitted it can withdraw.
     */
    public function withdraw(User $user, JobApplication $application): bool
    {
        return $user->isApplicant() && $application->user_id === $user->id;
    }

    /**
     * Determine whether the user can hire an applicant.
     * Only the employer of the job or admin can hire.
     */
    public function hire(User $user, JobApplication $application): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->isEmployer() && $application->job->company->user_id === $user->id;
    }

    /**
     * Determine whether the user can reject an applicant.
     * Only the employer of the job or admin can reject.
     */
    public function reject(User $user, JobApplication $application): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->isEmployer() && $application->job->company->user_id === $user->id;
    }
}
