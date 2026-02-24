<?php

namespace App\Mail;

use App\Models\LoginOtp;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LoginOtpMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public string $otp,
    ) {
        // dd($user->email, $otp); // Debugging line - remove in production
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Login OTP - HireFormIndia',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.login-otp',
        );
    }
}
