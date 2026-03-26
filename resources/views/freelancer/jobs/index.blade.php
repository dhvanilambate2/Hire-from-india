@extends('layouts.dashboard')

@section('title', 'Browse Jobs')

@section('content')
    <h4 class="fw-bold mb-4"><i class="fas fa-search me-2"></i> Browse Available Jobs</h4>

    {{-- Filters --}}
    <div class="data-table mb-4">
        <div class="p-3">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control"
                           placeholder="Search jobs..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="work_type" class="form-select">
                        <option value="">All Types</option>
                        @foreach(\App\Models\JobPost::WORK_TYPES as $key => $label)
                            <option value="{{ $key }}" {{ request('work_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary w-100"><i class="fas fa-search me-1"></i> Search</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Job Cards --}}
    <div class="row g-4">
        @forelse($jobs as $job)
            <div class="col-md-6 col-lg-4">
                <div class="job-card">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge-work-type badge-{{ $job->work_type }}">{{ $job->work_type_label }}</span>
                        @if($job->hasApplied(auth()->id()))
                            <span class="badge bg-info text-white" style="border-radius:6px;font-size:10px;">
                                <i class="fas fa-check me-1"></i>Applied
                            </span>
                        @endif
                    </div>

                    <h5 class="job-title">{{ Str::limit($job->title, 45) }}</h5>

                    <div class="job-meta">
                        <span><i class="fas fa-building"></i> {{ $job->employer->name }}</span>
                        @if($job->hours_per_week)
                            <span><i class="fas fa-clock"></i> {{ $job->hours_per_week }} hrs/week</span>
                        @endif
                    </div>

                    <div class="job-salary mb-2">{{ $job->formatted_salary }}</div>

                    <p class="text-muted small mb-3">
                        {{ Str::limit(strip_tags($job->overview), 100) }}
                    </p>

                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="fas fa-calendar me-1"></i> {{ $job->post_date->format('M d, Y') }}
                        </small>
                        <a href="{{ route('freelancer.jobs.show', $job) }}" class="btn btn-sm btn-primary">
                            View Details <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="data-table">
                    <div class="p-5 text-center text-muted">
                        <i class="fas fa-briefcase fa-3x mb-3 d-block" style="opacity:0.3;"></i>
                        <h5>No jobs available right now</h5>
                        <p>Check back later for new opportunities!</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    @if($jobs->hasPages())
        <div class="mt-4">{{ $jobs->withQueryString()->links() }}</div>
    @endif
@endsection
