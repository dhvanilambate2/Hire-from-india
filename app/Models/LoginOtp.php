<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LoginOtp extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'otp',
        'expires_at',
        'is_used',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'is_used'    => 'boolean',
        ];
    }

    // ── Relationships ──
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ── Generate OTP ──
    public static function generateFor(User $user): self
    {
        // Invalidate all previous OTPs for this user
        static::where('user_id', $user->id)
            ->where('is_used', false)
            ->update(['is_used' => true]);

        // Create new OTP (6 digits)
        return static::create([
            'user_id'    => $user->id,
            'otp'        => str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT),
            'expires_at' => Carbon::now()->addMinutes(5), // 5 minutes validity
        ]);
    }

    // ── Verify OTP ──
    public static function verifyFor(User $user, string $otp): bool
    {
        $record = static::where('user_id', $user->id)
            ->where('otp', $otp)
            ->where('is_used', false)
            ->where('expires_at', '>', Carbon::now())
            ->latest()
            ->first();

        if ($record) {
            $record->update(['is_used' => true]);
            return true;
        }

        return false;
    }

    // ── Check if expired ──
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    // ── Cleanup old OTPs ──
    public static function cleanup(): void
    {
        static::where('expires_at', '<', Carbon::now()->subDay())
            ->delete();
    }
}
