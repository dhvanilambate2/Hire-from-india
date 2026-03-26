<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $table = 'educations';

    protected $fillable = [
        'user_id',
        'institution',
        'degree',
        'start_month',
        'end_month',
        'grade',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedStartAttribute(): string
    {
        return \Carbon\Carbon::parse($this->start_month . '-01')->format('M Y');
    }

    public function getFormattedEndAttribute(): ?string
    {
        if (!$this->end_month) return 'Present';
        return \Carbon\Carbon::parse($this->end_month . '-01')->format('M Y');
    }

    public function getDurationAttribute(): string
    {
        return $this->formatted_start . ' - ' . $this->formatted_end;
    }
}
