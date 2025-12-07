<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'google_id',
        'email_verified_at',
        'contact_number',
        'location',
        'skills',
        'bio',
        'profile_picture',
        'resume_path',
        'linkedin_url',
        'github_url',
        'portfolio_url',
        'is_applicant',
        'is_employer',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function savedJobs()
    {
        return $this->hasMany(SavedJob::class);
    }

    // Accessors for profile picture and resume
    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile_picture) {
            return asset('storage/' . $this->profile_picture);
        }
        // Return a default avatar
        $initials = strtoupper(substr($this->name, 0, 1));
        return "https://via.placeholder.com/200?text={$initials}";
    }

    public function getResumeUrlAttribute()
    {
        if ($this->resume_path) {
            return asset('storage/' . $this->resume_path);
        }
        return null;
    }

    // Scopes
    public function scopeJobseekers($query)
    {
        return $query->where('role', 'jobseeker');
    }

    public function scopeEmployers($query)
    {
        return $query->where('role', 'employer');
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    // Helpers - Role checking methods
    public function isGuest()
    {
        return $this->role === 'guest';
    }

    public function isApplicant()
    {
        return $this->role === 'applicant';
    }

    public function isEmployer()
    {
        return $this->role === 'employer';
    }

    public function isJobseeker()
    {
        return $this->role === 'applicant'; // Alias for applicant
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user can apply for jobs
     */
    public function canApply()
    {
        return $this->role === 'applicant';
    }

    /**
     * Check if user can save jobs
     */
    public function canSaveJobs()
    {
        return $this->role === 'applicant';
    }

    /**
     * Check if user can post jobs
     */
    public function canPostJobs()
    {
        return $this->role === 'employer';
    }

    /**
     * Check if user can manage job applications
     */
    public function canManageApplications()
    {
        return $this->role === 'employer' || $this->role === 'admin';
    }

    /**
     * Check if user can manage all users
     */
    public function canManageUsers()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user can manage platform settings
     */
    public function canManagePlatform()
    {
        return $this->role === 'admin';
    }
}
