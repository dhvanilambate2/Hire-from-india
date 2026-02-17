<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    use HasFactory;

    protected $table = 'job_posts';

    const WORK_TYPES = [
        'full_time'  => 'Full Time',
        'part_time'  => 'Part Time',
        'contract'   => 'Contract',
        'freelance'  => 'Freelance',
        'internship' => 'Internship',
        'temporary'  => 'Temporary',
    ];

    const SALARY_TYPES = [
        'hourly'  => 'Per Hour',
        'weekly'  => 'Per Week',
        'monthly' => 'Per Month',
        'yearly'  => 'Per Year',
        'fixed'   => 'Fixed Price',
    ];

    protected $fillable = [
        'employer_id',
        'title',
        'work_type',
        'salary',
        'salary_type',
        'hours_per_week',
        'post_date',
        'overview',
        'status',
        'block_reason',
    ];

    protected $casts = [
        'salary'    => 'decimal:2',
        'post_date' => 'date',
    ];

    // ── Relationships ──
    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class, 'job_post_id');
    }

    // ── Scopes ──
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeBlocked($query)
    {
        return $query->where('status', 'blocked');
    }

    // ── Helpers ──
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isBlocked(): bool
    {
        return $this->status === 'blocked';
    }

    public function isClosed(): bool
    {
        return $this->status === 'closed';
    }

    public function getWorkTypeLabelAttribute(): string
    {
        return self::WORK_TYPES[$this->work_type] ?? $this->work_type;
    }

    public function getSalaryTypeLabelAttribute(): string
    {
        return self::SALARY_TYPES[$this->salary_type] ?? $this->salary_type;
    }

    public function getFormattedSalaryAttribute(): string
    {
        return '$' . number_format($this->salary, 2) . ' / ' . $this->salary_type_label;
    }

    public function hasApplied($freelancerId): bool
    {
        return $this->applications()->where('freelancer_id', $freelancerId)->exists();
    }
}
