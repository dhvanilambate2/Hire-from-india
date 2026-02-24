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

class LoginOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $otp;

    public function __construct($user, $otp) {
        $this->user = $user;
        $this->otp = $otp;
        // dd($this->user, $this->otp);
    }

    public function build()
    {
        return $this->subject('Your Login OTP - HireFormIndia')
            ->view('emails.login-otp')
            ->with('user', $this->user)
            ->with('otp', $this->otp);
    }
}
