<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\LoginOtpMail;
use App\Models\LoginOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // Check if user is active
            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Your account has been deactivated. Contact admin.',
                ]);
            }

            // Check if email is verified
            if (!$user->hasVerifiedEmail()) {
                Auth::logout();
                session(['pending_verification_user' => $user->id]);
                return redirect()->route('verification.notice');
            }

            // ══════════════════════════════════════════
            // ADMIN: Direct login (No OTP)
            // ══════════════════════════════════════════
            if ($user->isAdmin()) {
                $request->session()->regenerate();
                return redirect()->route('admin.dashboard');
            }

            // ══════════════════════════════════════════
            // FREELANCER & EMPLOYER: OTP Required
            // ══════════════════════════════════════════
            Auth::logout();

            // Generate OTP
            $otpRecord = LoginOtp::generateFor($user);

            // Send OTP Email
            try {
                Mail::to($user->email)->send(new LoginOtpMail($user, $otpRecord->otp));

                Log::info('OTP sent successfully', [
                    'user_id' => $user->id,
                    'email'   => $user->email,
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to send OTP email', [
                    'user_id' => $user->id,
                    'email'   => $user->email,
                    'error'   => $e->getMessage(),
                ]);

                return back()->withErrors([
                    'email' => 'Failed to send OTP. Please try again.',
                ])->onlyInput('email');
            }

            // Store session for OTP verification
            session([
                'otp_user_id'  => $user->id,
                'otp_remember' => $remember,
                'otp_sent_at'  => now()->timestamp,
            ]);

            return redirect()->route('otp.verify.form')
                ->with('success', 'OTP sent to your email address.');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // Show OTP Form
    public function showOtpForm()
    {
        if (!session('otp_user_id')) {
            return redirect()->route('login')
                ->with('error', 'Please login first.');
        }

        $user = User::find(session('otp_user_id'));

        if (!$user) {
            session()->forget(['otp_user_id', 'otp_remember', 'otp_sent_at']);
            return redirect()->route('login')
                ->with('error', 'Invalid session. Please login again.');
        }

        // Admin should never reach OTP page
        if ($user->isAdmin()) {
            session()->forget(['otp_user_id', 'otp_remember', 'otp_sent_at']);
            return redirect()->route('login');
        }

        $maskedEmail = $this->maskEmail($user->email);

        return view('auth.verify-otp', compact('maskedEmail'));
    }

    // Verify OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $userId = session('otp_user_id');
        $remember = session('otp_remember', false);

        if (!$userId) {
            return redirect()->route('login')
                ->with('error', 'Session expired. Please login again.');
        }

        $user = User::find($userId);

        if (!$user) {
            session()->forget(['otp_user_id', 'otp_remember', 'otp_sent_at']);
            return redirect()->route('login')
                ->with('error', 'Invalid session. Please login again.');
        }

        // Admin should never reach here
        if ($user->isAdmin()) {
            session()->forget(['otp_user_id', 'otp_remember', 'otp_sent_at']);
            return redirect()->route('login');
        }

        // Verify OTP
        if (LoginOtp::verifyFor($user, $request->otp)) {
            session()->forget(['otp_user_id', 'otp_remember', 'otp_sent_at']);

            Auth::login($user, $remember);
            $request->session()->regenerate();

            // Only freelancer & employer reach here
            return match ($user->role) {
                'freelancer' => redirect()->route('freelancer.dashboard'),
                'employer'   => redirect()->route('employer.dashboard'),
                default      => redirect()->route('login'),
            };
        }

        return back()->withErrors([
            'otp' => 'Invalid or expired OTP. Please try again.',
        ]);
    }

    // Resend OTP
    public function resendOtp()
    {
        $userId = session('otp_user_id');

        if (!$userId) {
            return redirect()->route('login')
                ->with('error', 'Session expired. Please login again.');
        }

        // Rate limiting
        $lastSent = session('otp_sent_at', 0);
        if (now()->timestamp - $lastSent < 60) {
            $remaining = 60 - (now()->timestamp - $lastSent);
            return back()->with('error', "Please wait {$remaining} seconds before requesting a new OTP.");
        }

        $user = User::find($userId);

        if (!$user) {
            session()->forget(['otp_user_id', 'otp_remember', 'otp_sent_at']);
            return redirect()->route('login')
                ->with('error', 'Invalid session. Please login again.');
        }

        // Admin should never reach here
        if ($user->isAdmin()) {
            session()->forget(['otp_user_id', 'otp_remember', 'otp_sent_at']);
            return redirect()->route('login');
        }

        $otpRecord = LoginOtp::generateFor($user);

        try {
            Mail::to($user->email)->send(new LoginOtpMail($user, $otpRecord->otp));

            Log::info('OTP resent successfully', [
                'user_id' => $user->id,
                'email'   => $user->email,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to resend OTP', [
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Failed to send OTP. Please try again.');
        }

        session(['otp_sent_at' => now()->timestamp]);

        return back()->with('success', 'New OTP sent to your email address.');
    }

    // Cancel OTP
    public function cancelOtp()
    {
        session()->forget(['otp_user_id', 'otp_remember', 'otp_sent_at']);
        return redirect()->route('login')->with('success', 'Login cancelled.');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }

    // Mask Email
    private function maskEmail(string $email): string
    {
        $parts = explode('@', $email);
        $name = $parts[0];
        $domain = $parts[1];

        if (strlen($name) <= 4) {
            $maskedName = substr($name, 0, 1) . str_repeat('*', strlen($name) - 1);
        } else {
            $maskedName = substr($name, 0, 2) . str_repeat('*', strlen($name) - 4) . substr($name, -2);
        }

        return $maskedName . '@' . $domain;
    }
}
