<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    // Browse available jobs
    public function index(Request $request)
    {
        $query = JobPost::active()->with('employer')->withCount('applications');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('overview', 'like', "%{$search}%");
            });
        }

        if ($request->filled('work_type')) {
            $query->where('work_type', $request->work_type);
        }

        $jobs = $query->latest()->paginate(12);

        return view('freelancer.jobs.index', compact('jobs'));
    }

    // View job details
    public function show(JobPost $job)
    {
        if ($job->isBlocked()) {
            abort(404);
        }

        $job->load('employer');
        $hasApplied  = $job->hasApplied(Auth::id());
        $application = null;

        if ($hasApplied) {
            $application = JobApplication::where('job_post_id', $job->id)
                ->where('freelancer_id', Auth::id())
                ->first();
        }

        return view('freelancer.jobs.show', compact('job', 'hasApplied', 'application'));
    }

    // Apply
    public function apply(Request $request, JobPost $job)
    {
        if (!$job->isActive()) {
            return back()->with('error', 'This job is no longer accepting applications.');
        }

        if ($job->hasApplied(Auth::id())) {
            return back()->with('error', 'You have already applied to this job.');
        }

        $request->validate([
            'cover_letter'    => 'required|string|min:20|max:2000',
            'expected_salary' => 'nullable|numeric|min:0',
        ]);

        JobApplication::create([
            'job_post_id'     => $job->id,
            'freelancer_id'   => Auth::id(),
            'cover_letter'    => $request->cover_letter,
            'expected_salary' => $request->expected_salary,
        ]);

        return redirect()->route('freelancer.jobs.show', $job)
            ->with('success', 'Application submitted successfully!');
    }

    // My applications
    public function myApplications(Request $request)
    {
        $query = Auth::user()->jobApplications()->with('jobPost.employer');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $applications = $query->latest()->paginate(10);

        return view('freelancer.jobs.applications', compact('applications'));
    }

    // Withdraw
    public function withdrawApplication(JobApplication $application)
    {
        if ($application->freelancer_id !== Auth::id()) {
            abort(403);
        }

        if (!$application->isPending()) {
            return back()->with('error', 'Can only withdraw pending applications.');
        }

        $application->delete();

        return back()->with('success', 'Application withdrawn successfully.');
    }
}
