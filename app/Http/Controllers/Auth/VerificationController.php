<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    // Show email verification notice
    public function notice()
    {
        if (auth()->user()->hasVerifiedEmail()) {
            return $this->redirectBasedOnRole();
        }

        return view('auth.verify-email');
    }

    // Handle email verification link
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return $this->redirectBasedOnRole()
            ->with('success', 'Email verified successfully!');
    }

    // Resend verification email
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->redirectBasedOnRole();
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'Verification link sent! Check your email.');
    }

    private function redirectBasedOnRole()
    {
        $user = auth()->user();

        return match ($user->role) {
            'admin'      => redirect()->route('admin.dashboard'),
            'freelancer' => redirect()->route('freelancer.dashboard'),
            'employer'   => redirect()->route('employer.dashboard'),
            default      => redirect()->route('login'),
        };
    }
}