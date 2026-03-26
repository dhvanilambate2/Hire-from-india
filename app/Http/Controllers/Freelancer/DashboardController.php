<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $stats = [
            'available_jobs'       => JobPost::active()->count(),
            'my_applications'      => $user->jobApplications()->count(),
            'pending_applications' => $user->jobApplications()->where('status', 'pending')->count(),
            'accepted_applications'=> $user->jobApplications()->where('status', 'accepted')->count(),
        ];

        $latestJobs = JobPost::active()->with('employer')->latest()->take(6)->get();

        return view('freelancer.dashboard', compact('stats', 'latestJobs'));
    }
}
