<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name'              => 'Super Admin',
                'password'          => Hash::make('password'),
                'role'              => 'admin',
                'email_verified_at' => now(),
                'is_active'         => true,
            ]
        );
    }
}