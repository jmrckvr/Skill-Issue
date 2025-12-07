<?php

namespace App\Policies;

use App\Models\SavedJob;
use App\Models\User;

class SavedJobPolicy
{
    /**
     * Determine whether the user can view saved jobs.
     * Only applicants can save and view saved jobs.
     */
    public function viewSaved(User $user): bool
    {
        return $user->canSaveJobs();
    }

    /**
     * Determine whether the user can save a job.
     * Only applicants can save jobs.
     */
    public function save(User $user): bool
    {
        return $user->canSaveJobs();
    }

    /**
     * Determine whether the user can delete a saved job.
     * Only the applicant who saved it can delete.
     */
    public function delete(User $user, SavedJob $savedJob): bool
    {
        return $user->isApplicant() && $savedJob->user_id === $user->id;
    }
}
