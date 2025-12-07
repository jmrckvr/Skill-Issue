<?php

namespace App\Traits;

use Illuminate\Auth\Access\AuthorizationException;

/**
 * Trait for common authorization checks in controllers.
 * Provides helper methods for checking user roles and permissions.
 */
trait AuthorizesRequests
{
    /**
     * Verify user is an applicant, otherwise abort.
     */
    protected function authorizeApplicant()
    {
        if (!auth()->check() || !auth()->user()->isApplicant()) {
            throw new AuthorizationException('You must be an applicant to perform this action.');
        }
    }

    /**
     * Verify user is an employer, otherwise abort.
     */
    protected function authorizeEmployer()
    {
        if (!auth()->check() || !auth()->user()->isEmployer()) {
            throw new AuthorizationException('You must be an employer to perform this action.');
        }
    }

    /**
     * Verify user is an admin, otherwise abort.
     */
    protected function authorizeAdmin()
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            throw new AuthorizationException('You must be an admin to perform this action.');
        }
    }

    /**
     * Verify user is authenticated, otherwise abort.
     */
    protected function authorizeAuthenticated()
    {
        if (!auth()->check()) {
            throw new AuthorizationException('You must be logged in to perform this action.');
        }
    }

    /**
     * Verify user is not a guest, otherwise abort.
     */
    protected function authorizeNotGuest()
    {
        if (auth()->check() && auth()->user()->isGuest()) {
            throw new AuthorizationException('Guests cannot perform this action. Please register as an applicant.');
        }
    }
}
