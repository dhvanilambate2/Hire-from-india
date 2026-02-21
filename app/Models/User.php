<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    const ROLE_ADMIN = 'admin';
    const ROLE_FREELANCER = 'freelancer';
    const ROLE_EMPLOYER = 'employer';

    const STATUS_DRAFT = 'draft';
    const STATUS_UNDER_REVIEW = 'under_review';
    const STATUS_VERIFIED = 'verified';
    const STATUS_REJECTED = 'rejected';
    const STATUS_SUSPENDED = 'suspended';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'bio',
        'is_active',
        'profile_photo',
        'hourly_rate',
        'availability',
        'resume',
        'profile_status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
            'hourly_rate'       => 'decimal:2',
        ];
    }

    // ── Role Checks ──
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isFreelancer(): bool
    {
        return $this->role === self::ROLE_FREELANCER;
    }

    public function isEmployer(): bool
    {
        return $this->role === self::ROLE_EMPLOYER;
    }

    // ── Profile Status Checks ──
    public function isDraft(): bool
    {
        return $this->profile_status === self::STATUS_DRAFT;
    }

    public function isUnderReview(): bool
    {
        return $this->profile_status === self::STATUS_UNDER_REVIEW;
    }

    public function isVerified(): bool
    {
        return $this->profile_status === self::STATUS_VERIFIED;
    }

    public function isRejected(): bool
    {
        return $this->profile_status === self::STATUS_REJECTED;
    }

    public function isSuspended(): bool
    {
        return $this->profile_status === self::STATUS_SUSPENDED;
    }

    // ── Scopes ──
    public function scopeAdmins($query)
    {
        return $query->where('role', self::ROLE_ADMIN);
    }

    public function scopeFreelancers($query)
    {
        return $query->where('role', self::ROLE_FREELANCER);
    }

    public function scopeEmployers($query)
    {
        return $query->where('role', self::ROLE_EMPLOYER);
    }

    public function scopeByProfileStatus($query, $status)
    {
        return $query->where('profile_status', $status);
    }

    // ── Relationships ──
    public function jobPosts()
    {
        return $this->hasMany(JobPost::class, 'employer_id');
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class, 'freelancer_id');
    }

    public function company()
    {
        return $this->hasOne(Company::class, 'employer_id');
    }

    public function skills()
    {
        return $this->hasMany(UserSkill::class);
    }

    public function workExperiences()
    {
        return $this->hasMany(WorkExperience::class)->orderBy('start_year', 'desc');
    }

    public function educations()
    {
        return $this->hasMany(Education::class)->orderBy('start_month', 'desc');
    }

    public function portfolioLinks()
    {
        return $this->hasMany(PortfolioLink::class);
    }

    // ── Helpers ──
    public function hasCompany()
    {
        return $this->company()->exists();
    }

    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo) {
            return asset('storage/' . $this->profile_photo);
        }
        return null;
    }

    public function getHasProfilePhotoAttribute()
    {
        return !empty($this->profile_photo);
    }

    public function getResumeUrlAttribute()
    {
        if ($this->resume) {
            return asset('storage/' . $this->resume);
        }
        return null;
    }

    public function getAvailabilityLabelAttribute()
    {
        return match($this->availability) {
            'full_time' => 'Full Time',
            'part_time' => 'Part Time',
            default     => 'Not Set',
        };
    }

    public function getProfileStatusLabelAttribute()
    {
        return match($this->profile_status) {
            'draft'        => 'Draft',
            'under_review' => 'Under Review',
            'verified'     => 'Verified',
            'rejected'     => 'Rejected',
            'suspended'    => 'Suspended',
            default        => 'Unknown',
        };
    }

    public function getProfileStatusColorAttribute()
    {
        return match($this->profile_status) {
            'draft'        => '#64748b',
            'under_review' => '#d97706',
            'verified'     => '#16a34a',
            'rejected'     => '#dc2626',
            'suspended'    => '#7c3aed',
            default        => '#64748b',
        };
    }

    // ── Profile Completeness ──
    public function getProfileCompletenessAttribute(): int
    {
        $fields = [
            'name'          => 10,
            'email'         => 10,
            'phone'         => 10,
            'bio'           => 10,
            'profile_photo' => 10,
            'hourly_rate'   => 10,
            'availability'  => 5,
            'resume'        => 10,
            'skills'        => 10,
            'experience'    => 10,
            'education'     => 5,
        ];

        $score = 0;

        if (!empty($this->name)) $score += $fields['name'];
        if (!empty($this->email)) $score += $fields['email'];
        if (!empty($this->phone)) $score += $fields['phone'];
        if (!empty($this->bio)) $score += $fields['bio'];
        if (!empty($this->profile_photo)) $score += $fields['profile_photo'];
        if (!empty($this->hourly_rate)) $score += $fields['hourly_rate'];
        if (!empty($this->availability)) $score += $fields['availability'];
        if (!empty($this->resume)) $score += $fields['resume'];
        if ($this->skills()->count() > 0) $score += $fields['skills'];
        if ($this->workExperiences()->count() > 0) $score += $fields['experience'];
        if ($this->educations()->count() > 0) $score += $fields['education'];

        return $score;
    }

    public function getProfileCompletenessColorAttribute(): string
    {
        $percentage = $this->profile_completeness;
        if ($percentage >= 80) return '#16a34a';
        if ($percentage >= 50) return '#d97706';
        return '#dc2626';
    }
}
