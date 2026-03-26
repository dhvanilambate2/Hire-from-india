<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $stats = [
            'total_jobs'         => $user->jobPosts()->count(),
            'active_jobs'        => $user->jobPosts()->where('status', 'active')->count(),
            'total_applications' => $user->jobPosts()->withCount('applications')->get()->sum('applications_count'),
            'blocked_jobs'       => $user->jobPosts()->where('status', 'blocked')->count(),
        ];

        $recentJobs = $user->jobPosts()->withCount('applications')->latest()->take(5)->get();

        return view('employer.dashboard', compact('stats', 'recentJobs'));
    }
}
