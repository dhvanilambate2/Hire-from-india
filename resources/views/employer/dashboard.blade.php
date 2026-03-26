@extends('layouts.dashboard')
@section('title', 'Employer Dashboard')
@section('content')
    <h4 class="fw-bold mb-4">Welcome, {{ auth()->user()->name }}!</h4>

    <div class="row g-4 mb-4">
        <div class="col-6 col-lg-3">
            <div class="stat-card"><div class="stat-number">{{ $stats['total_jobs'] }}</div><div class="stat-label">Total Jobs</div></div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card"><div class="stat-number">{{ $stats['active_jobs'] }}</div><div class="stat-label">Active</div></div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card"><div class="stat-number">{{ $stats['total_applications'] }}</div><div class="stat-label">Applications</div></div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card"><div class="stat-number">{{ $stats['blocked_jobs'] }}</div><div class="stat-label">Blocked</div></div>
        </div>
    </div>

    <div class="d-flex justify-content-between mb-3">
        <h5 class="fw-bold mb-0">Recent Jobs</h5>
        <a href="{{ route('employer.jobs.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i> Post Job</a>
    </div>

    <div class="data-table">
        <table class="table">
            <thead><tr><th>Title</th><th>Type</th><th>Salary</th><th>Apps</th><th>Status</th><th></th></tr></thead>
            <tbody>
                @forelse($recentJobs as $job)
                    <tr>
                        <td class="fw-semibold">{{ Str::limit($job->title, 30) }}</td>
                        <td><span class="badge-work-type badge-{{ $job->work_type }}">{{ $job->work_type_label }}</span></td>
                        <td class="job-salary" style="font-size:13px;">{{ $job->formatted_salary }}</td>
                        <td><span class="badge bg-primary rounded-pill">{{ $job->applications_count }}</span></td>
                        <td>
                            @if($job->isActive()) <span class="badge-role badge-active">Active</span>
                            @elseif($job->isBlocked()) <span class="badge-role badge-inactive">Blocked</span>
                            @else <span class="badge-role" style="background:#f1f5f9;color:#64748b;">Closed</span>
                            @endif
                        </td>
                        <td><a href="{{ route('employer.jobs.show', $job) }}" class="btn btn-sm btn-outline-primary">View</a></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">No jobs. <a href="{{ route('employer.jobs.create') }}">Post one!</a></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
