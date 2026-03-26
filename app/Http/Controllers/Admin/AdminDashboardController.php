<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\JobPost;
use App\Models\JobApplication;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'        => User::whereIn('role', ['freelancer', 'employer'])->count(),
            'total_freelancers'  => User::freelancers()->count(),
            'total_employers'    => User::employers()->count(),
            'total_admins'       => User::admins()->count(),
            'total_jobs'         => JobPost::count(),
            'active_jobs'        => JobPost::where('status', 'active')->count(),
            'blocked_jobs'       => JobPost::where('status', 'blocked')->count(),
            'verified_users'    => User::whereNotNull('email_verified_at')->count(),
            'unverified_users'  => User::whereNull('email_verified_at')->count(),
            'total_applications' => JobApplication::count(),

            // ── NEW: Profile Status Stats ──
            'profiles_draft'        => User::where('profile_status', 'draft')->count(),
            'profiles_under_review' => User::where('profile_status', 'under_review')->count(),
            'profiles_verified'     => User::where('profile_status', 'verified')->count(),
            'profiles_rejected'     => User::where('profile_status', 'rejected')->count(),
            'profiles_suspended'    => User::where('profile_status', 'suspended')->count(),
        ];


        $recentUsers = User::latest()->take(5)->get();
        $recentJobs  = JobPost::with('employer')->withCount('applications')->latest()->take(5)->get();
        // Users pending review
        $pendingReviews = User::where('profile_status', 'under_review')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'pendingReviews', 'recentUsers', 'recentJobs'));
    }
}
