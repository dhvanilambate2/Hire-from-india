<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'position',
        'employment_type',
        'start_year',
        'end_year',
        'is_current',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'is_current' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getEmploymentTypeLabelAttribute(): string
    {
        return match($this->employment_type) {
            'full_time'  => 'Full Time',
            'part_time'  => 'Part Time',
            'contract'   => 'Contract',
            'freelance'  => 'Freelance',
            'internship' => 'Internship',
            'temporary'  => 'Temporary',
            default      => ucfirst($this->employment_type),
        };
    }

    public function getDurationAttribute(): string
    {
        if ($this->is_current) {
            return $this->start_year . ' - Present';
        }
        return $this->start_year . ' - ' . ($this->end_year ?? 'N/A');
    }
}
