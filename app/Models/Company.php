<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'employer_id',
        'company_name',
        'company_logo',
        'company_email',
        'company_phone',
        'company_address',
    ];

    // ── Relationships ──
    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    public function jobPosts()
    {
        return $this->hasManyThrough(JobPost::class, User::class, 'id', 'employer_id', 'employer_id', 'id');
    }

    // ── Accessors ──
    public function getLogoUrlAttribute()
    {
        if ($this->company_logo) {
            return asset('storage/' . $this->company_logo);
        }
        return null;
    }

    public function getHasLogoAttribute()
    {
        return !empty($this->company_logo);
    }
}
