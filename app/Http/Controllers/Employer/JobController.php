<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    // List employer's jobs
    public function index(Request $request)
    {
        $query = Auth::user()->jobPosts()->withCount('applications');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('work_type')) {
            $query->where('work_type', $request->work_type);
        }

        $jobs = $query->latest()->paginate(10);

        return view('employer.jobs.index', compact('jobs'));
    }

    // Show create form
    public function create()
    {
        return view('employer.jobs.create');
    }

    // Store new job
    public function store(Request $request)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'work_type'      => 'required|in:full_time,part_time,contract,freelance,internship,temporary',
            'salary'         => 'required|numeric|min:0',
            'salary_type'    => 'required|in:hourly,weekly,monthly,yearly,fixed',
            'hours_per_week' => 'nullable|integer|min:1|max:168',
            'post_date'      => 'required|date',
            'overview'       => 'required|string|min:20',
        ]);

        Auth::user()->jobPosts()->create([
            'title'          => $request->title,
            'work_type'      => $request->work_type,
            'salary'         => $request->salary,
            'salary_type'    => $request->salary_type,
            'hours_per_week' => $request->hours_per_week,
            'post_date'      => $request->post_date,
            'overview'       => $request->overview,
        ]);

        return redirect()->route('employer.jobs.index')
            ->with('success', 'Job posted successfully!');
    }

    // Show single job with applications
    public function show(JobPost $job)
    {
        if ($job->employer_id !== Auth::id()) {
            abort(403);
        }

        $job->load(['applications.freelancer']);

        return view('employer.jobs.show', compact('job'));
    }

    // Show edit form
    public function edit(JobPost $job)
    {
        if ($job->employer_id !== Auth::id()) {
            abort(403);
        }

        if ($job->isBlocked()) {
            return back()->with('error', 'Cannot edit a blocked job post.');
        }

        return view('employer.jobs.edit', compact('job'));
    }

    // Update job
    public function update(Request $request, JobPost $job)
    {
        if ($job->employer_id !== Auth::id()) {
            abort(403);
        }

        if ($job->isBlocked()) {
            return back()->with('error', 'Cannot update a blocked job post.');
        }

        $request->validate([
            'title'          => 'required|string|max:255',
            'work_type'      => 'required|in:full_time,part_time,contract,freelance,internship,temporary',
            'salary'         => 'required|numeric|min:0',
            'salary_type'    => 'required|in:hourly,weekly,monthly,yearly,fixed',
            'hours_per_week' => 'nullable|integer|min:1|max:168',
            'post_date'      => 'required|date',
            'overview'       => 'required|string|min:20',
        ]);

        $job->update([
            'title'          => $request->title,
            'work_type'      => $request->work_type,
            'salary'         => $request->salary,
            'salary_type'    => $request->salary_type,
            'hours_per_week' => $request->hours_per_week,
            'post_date'      => $request->post_date,
            'overview'       => $request->overview,
        ]);

        return redirect()->route('employer.jobs.show', $job)
            ->with('success', 'Job updated successfully!');
    }

    // Close / Reopen
    public function toggleStatus(JobPost $job)
    {
        if ($job->employer_id !== Auth::id()) {
            abort(403);
        }

        if ($job->isBlocked()) {
            return back()->with('error', 'Cannot change status of a blocked job.');
        }

        $job->update([
            'status' => $job->isActive() ? 'closed' : 'active',
        ]);

        $text = $job->isActive() ? 'reopened' : 'closed';

        return back()->with('success', "Job {$text} successfully!");
    }

    // Delete
    public function destroy(JobPost $job)
    {
        if ($job->employer_id !== Auth::id()) {
            abort(403);
        }

        $job->delete();

        return redirect()->route('employer.jobs.index')
            ->with('success', 'Job deleted successfully!');
    }

    // Accept / Reject application
    public function updateApplication(Request $request, JobApplication $application)
    {
        if ($application->jobPost->employer_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        $application->update(['status' => $request->status]);

        return back()->with('success', 'Application ' . $request->status . ' successfully!');
    }
}
