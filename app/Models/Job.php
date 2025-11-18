<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'category_id',
        'title',
        'description',
        'location',
        'job_type',
        'experience_level',
        'salary_min',
        'salary_max',
        'currency',
        'hide_salary',
        'requirements',
        'benefits',
        'status',
        'application_count',
        'published_at',
        'closed_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'closed_at' => 'datetime',
        'hide_salary' => 'boolean',
    ];

    // Relationships
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function savedByUsers()
    {
        return $this->hasManyThrough(
            User::class,
            SavedJob::class,
            'job_id',
            'id',
            'id',
            'user_id'
        );
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')->whereNotNull('published_at');
    }

    public function scopeActive($query)
    {
        return $query->published()->where('status', '!=', 'closed');
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByLocation($query, $location)
    {
        return $query->where('location', 'like', '%' . $location . '%');
    }

    public function scopeByKeyword($query, $keyword)
    {
        return $query->where('title', 'like', '%' . $keyword . '%')
            ->orWhere('description', 'like', '%' . $keyword . '%');
    }

    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    // Helpers
    public function isPublished()
    {
        return $this->status === 'published' && $this->published_at !== null;
    }

    public function getFormattedSalary()
    {
        if ($this->hide_salary || (!$this->salary_min && !$this->salary_max)) {
            return 'Confidential';
        }

        if ($this->salary_min && $this->salary_max) {
            return "{$this->currency} " . number_format($this->salary_min) . " - " . number_format($this->salary_max);
        }

        if ($this->salary_min) {
            return "{$this->currency} " . number_format($this->salary_min) . "+";
        }

        return "{$this->currency} " . number_format($this->salary_max);
    }
}
