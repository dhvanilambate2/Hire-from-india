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

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'bio',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

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

    public function jobPosts()
    {
        return $this->hasMany(JobPost::class, 'employer_id');
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class, 'freelancer_id');
    }
}
