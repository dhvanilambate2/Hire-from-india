@extends('layouts.dashboard')
@section('title', 'Freelancer Dashboard')
@section('content')
    <h4 class="fw-bold mb-4">Welcome, {{ auth()->user()->name }}!</h4>

    <div class="row g-4 mb-4">
        <div class="col-6 col-lg-3">
            <div class="stat-card"><div class="stat-number">{{ $stats['available_jobs'] }}</div><div class="stat-label">Available Jobs</div></div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card"><div class="stat-number">{{ $stats['my_applications'] }}</div><div class="stat-label">My Applications</div></div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card"><div class="stat-number">{{ $stats['pending_applications'] }}</div><div class="stat-label">Pending</div></div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card"><div class="stat-number">{{ $stats['accepted_applications'] }}</div><div class="stat-label">Accepted</div></div>
        </div>
    </div>

    <div class="d-flex justify-content-between mb-3">
        <h5 class="fw-bold mb-0">Latest Opportunities</h5>
        <a href="{{ route('freelancer.jobs.index') }}" class="btn btn-primary btn-sm"><i class="fas fa-search me-1"></i> Browse All</a>
    </div>

    <div class="row g-4">
        @forelse($latestJobs as $job)
            <div class="col-md-6 col-lg-4">
                <div class="job-card">
                    <span class="badge-work-type badge-{{ $job->work_type }} mb-2">{{ $job->work_type_label }}</span>
                    <h6 class="fw-bold">{{ Str::limit($job->title, 40) }}</h6>
                    <div class="text-muted small mb-1">{{ $job->employer->name }}</div>
                    <div class="job-salary mb-2" style="font-size:14px;">{{ $job->formatted_salary }}</div>
                    @if($job->hours_per_week)
                        <small class="text-muted"><i class="fas fa-clock me-1"></i>{{ $job->hours_per_week }} hrs/week</small>
                    @endif
                    <div class="mt-3">
                        <a href="{{ route('freelancer.jobs.show', $job) }}" class="btn btn-sm btn-outline-primary w-100">View & Apply</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted py-4">No jobs available.</div>
        @endforelse
    </div>
@endsection
