<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'       => User::count(),
            'total_freelancers' => User::freelancers()->count(),
            'total_employers'   => User::employers()->count(),
            'total_admins'      => User::admins()->count(),
            'verified_users'    => User::whereNotNull('email_verified_at')->count(),
            'unverified_users'  => User::whereNull('email_verified_at')->count(),
        ];

        $recentUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers'));
    }
}