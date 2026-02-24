@extends('layouts.app')

@section('title', 'Verify OTP')

@push('styles')
<style>
    .otp-inputs {
        display: flex;
        gap: 10px;
        justify-content: center;
        margin: 24px 0;
    }
    .otp-input {
        width: 52px;
        height: 60px;
        text-align: center;
        font-size: 24px;
        font-weight: 700;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        outline: none;
        transition: all 0.2s;
        color: #1e293b;
        background: #f8fafc;
    }
    .otp-input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
        background: #fff;
    }
    .otp-input.filled {
        border-color: #6366f1;
        background: #eef2ff;
    }
    .otp-input.error {
        border-color: #dc2626;
        background: #fef2f2;
    }
    .timer-text {
        font-size: 14px;
        color: #64748b;
    }
    .timer-count {
        font-weight: 700;
        color: #6366f1;
    }
    .resend-btn {
        background: none;
        border: none;
        color: #6366f1;
        font-weight: 600;
        cursor: pointer;
        font-size: 14px;
        padding: 0;
        text-decoration: underline;
    }
    .resend-btn:disabled {
        color: #94a3b8;
        cursor: not-allowed;
        text-decoration: none;
    }
    .security-notice {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 13px;
        color: #166534;
    }
    .email-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 16px;
        background: #eef2ff;
        color: #4338ca;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 500;
    }
    .cancel-link {
        color: #64748b;
        font-size: 13px;
        text-decoration: none;
    }
    .cancel-link:hover {
        color: #dc2626;
    }

    /* Hidden real input */
    .otp-hidden-input {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }
</style>
@endpush

@section('body')
<div class="auth-wrapper">
    <div class="auth-card" style="max-width: 460px;">
        <div class="text-center mb-4">
            <div style="width:70px;height:70px;border-radius:50%;background:linear-gradient(135deg,#667eea,#764ba2);margin:0 auto 16px;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-shield-alt fa-xl" style="color:#fff;"></i>
            </div>
            <h2 class="fw-bold" style="font-size:22px;">Verify Your Identity</h2>
            <p class="text-muted mb-3" style="font-size:14px;">
                We've sent a 6-digit OTP to your email
            </p>
            <div class="email-badge">
                <i class="fas fa-envelope"></i>
                {{ $maskedEmail }}
            </div>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" style="border-radius:10px;font-size:14px;">
                <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" style="font-size:12px;"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" style="border-radius:10px;font-size:14px;">
                <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" style="font-size:12px;"></button>
            </div>
        @endif

        {{-- OTP Form --}}
        <form method="POST" action="{{ route('otp.verify') }}" id="otpForm">
            @csrf

            {{-- Hidden input for actual OTP value --}}
            <input type="hidden" name="otp" id="otpHiddenInput">

            {{-- OTP Input Boxes --}}
            <div class="otp-inputs" id="otpInputs">
                <input type="text" class="otp-input" maxlength="1" data-index="0" inputmode="numeric" autofocus>
                <input type="text" class="otp-input" maxlength="1" data-index="1" inputmode="numeric">
                <input type="text" class="otp-input" maxlength="1" data-index="2" inputmode="numeric">
                <input type="text" class="otp-input" maxlength="1" data-index="3" inputmode="numeric">
                <input type="text" class="otp-input" maxlength="1" data-index="4" inputmode="numeric">
                <input type="text" class="otp-input" maxlength="1" data-index="5" inputmode="numeric">
            </div>

            @error('otp')
                <div class="text-center mb-3">
                    <small class="text-danger fw-semibold">
                        <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                    </small>
                </div>
            @enderror

            {{-- Submit Button --}}
            <button type="submit" class="btn btn-primary w-100 mb-3" id="verifyBtn" disabled>
                <i class="fas fa-check-circle me-2"></i> Verify OTP
            </button>
        </form>

        {{-- Timer & Resend --}}
        <div class="text-center mb-3">
            <div id="timerSection">
                <span class="timer-text">
                    Resend OTP in <span class="timer-count" id="timer">60</span>s
                </span>
            </div>
            <div id="resendSection" style="display:none;">
                <span class="timer-text">Didn't receive the code? </span>
                <form method="POST" action="{{ route('otp.resend') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="resend-btn">
                        <i class="fas fa-redo me-1"></i> Resend OTP
                    </button>
                </form>
            </div>
        </div>

        {{-- Security Notice --}}
        <div class="security-notice mb-3">
            <i class="fas fa-lock me-1"></i>
            <strong>Security:</strong> OTP is valid for 5 minutes. Never share your OTP with anyone.
        </div>

        {{-- Cancel --}}
        <div class="text-center">
            <a href="{{ route('otp.cancel') }}" class="cancel-link">
                <i class="fas fa-arrow-left me-1"></i> Back to Login
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.otp-input');
    const hiddenInput = document.getElementById('otpHiddenInput');
    const verifyBtn = document.getElementById('verifyBtn');
    const otpForm = document.getElementById('otpForm');
    const timerSection = document.getElementById('timerSection');
    const resendSection = document.getElementById('resendSection');
    const timerEl = document.getElementById('timer');

    // ── OTP Input Logic ──
    inputs.forEach((input, index) => {
        // Only allow numbers
        input.addEventListener('input', function(e) {
            const value = this.value.replace(/[^0-9]/g, '');
            this.value = value;

            if (value) {
                this.classList.add('filled');
                // Move to next input
                if (index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            } else {
                this.classList.remove('filled');
            }

            updateHiddenInput();
        });

        // Handle backspace
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && !this.value && index > 0) {
                inputs[index - 1].focus();
                inputs[index - 1].value = '';
                inputs[index - 1].classList.remove('filled');
                updateHiddenInput();
            }

            // Handle Enter
            if (e.key === 'Enter') {
                e.preventDefault();
                if (!verifyBtn.disabled) {
                    otpForm.submit();
                }
            }
        });

        // Handle paste
        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedData = (e.clipboardData || window.clipboardData).getData('text');
            const digits = pastedData.replace(/[^0-9]/g, '').slice(0, 6);

            digits.split('').forEach((digit, i) => {
                if (inputs[i]) {
                    inputs[i].value = digit;
                    inputs[i].classList.add('filled');
                }
            });

            // Focus last filled or next empty
            const focusIndex = Math.min(digits.length, inputs.length - 1);
            inputs[focusIndex].focus();

            updateHiddenInput();
        });

        // Select all text on focus
        input.addEventListener('focus', function() {
            this.select();
        });
    });

    function updateHiddenInput() {
        let otp = '';
        inputs.forEach(input => {
            otp += input.value;
        });
        hiddenInput.value = otp;

        // Enable/disable verify button
        verifyBtn.disabled = otp.length !== 6;

        // Remove error styling
        if (otp.length > 0) {
            inputs.forEach(input => input.classList.remove('error'));
        }
    }

    // ── Add error class if validation failed ──
    @if($errors->has('otp'))
        inputs.forEach(input => {
            input.classList.add('error');
            input.value = '';
            input.classList.remove('filled');
        });
        inputs[0].focus();
    @endif

    // ── Countdown Timer ──
    let countdown = 60;

    // Check if there's remaining time from session
    @if(session('otp_sent_at'))
        const sentAt = {{ session('otp_sent_at') }};
        const now = Math.floor(Date.now() / 1000);
        const elapsed = now - sentAt;
        countdown = Math.max(0, 60 - elapsed);
    @endif

    function startTimer() {
        if (countdown <= 0) {
            showResend();
            return;
        }

        timerEl.textContent = countdown;
        timerSection.style.display = 'block';
        resendSection.style.display = 'none';

        const interval = setInterval(() => {
            countdown--;
            timerEl.textContent = countdown;

            if (countdown <= 0) {
                clearInterval(interval);
                showResend();
            }
        }, 1000);
    }

    function showResend() {
        timerSection.style.display = 'none';
        resendSection.style.display = 'block';
    }

    startTimer();
});
</script>
@endpush
