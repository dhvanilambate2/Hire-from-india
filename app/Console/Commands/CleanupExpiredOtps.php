<?php

namespace App\Console\Commands;

use App\Models\LoginOtp;
use Illuminate\Console\Command;

class CleanupExpiredOtps extends Command
{
    protected $signature = 'otp:cleanup';
    protected $description = 'Delete expired OTP records';

    public function handle()
    {
        LoginOtp::cleanup();
        $this->info('Expired OTPs cleaned up successfully.');
    }
}
