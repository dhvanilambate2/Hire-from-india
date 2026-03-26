<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use Illuminate\Http\Request;

class JobManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = JobPost::with('employer')->withCount('applications');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('employer', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('work_type')) {
            $query->where('work_type', $request->work_type);
        }

        $jobs = $query->latest()->paginate(15);

        $stats = [
            'total'   => JobPost::count(),
            'active'  => JobPost::where('status', 'active')->count(),
            'closed'  => JobPost::where('status', 'closed')->count(),
            'blocked' => JobPost::where('status', 'blocked')->count(),
        ];

        return view('admin.jobs.index', compact('jobs', 'stats'));
    }

    public function show(JobPost $job)
    {
        $job->load(['employer', 'applications.freelancer']);

        return view('admin.jobs.show', compact('job'));
    }

    public function block(Request $request, JobPost $job)
    {
        $request->validate([
            'block_reason' => 'required|string|max:500',
        ]);

        $job->update([
            'status'       => 'blocked',
            'block_reason' => $request->block_reason,
        ]);

        return back()->with('success', 'Job post has been blocked.');
    }

    public function unblock(JobPost $job)
    {
        $job->update([
            'status'       => 'active',
            'block_reason' => null,
        ]);

        return back()->with('success', 'Job post has been unblocked.');
    }

    public function destroy(JobPost $job)
    {
        $job->delete();

        return redirect()->route('admin.jobs.index')
            ->with('success', 'Job post deleted permanently.');
    }
}
