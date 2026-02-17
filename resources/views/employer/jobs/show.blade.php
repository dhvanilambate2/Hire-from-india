@extends('layouts.dashboard')

@section('title', $job->title)

@section('content')
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('employer.jobs.index') }}" class="btn btn-outline-secondary me-3">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h4 class="fw-bold mb-0">Job Details</h4>
    </div>

    @if($job->isBlocked())
        <div class="alert alert-danger">
            <i class="fas fa-ban me-2"></i> <strong>This job has been blocked by admin.</strong>
            @if($job->block_reason) <br>Reason: {{ $job->block_reason }} @endif
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="data-table">
                <div class="p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h3 class="fw-bold mb-2">{{ $job->title }}</h3>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge-work-type badge-{{ $job->work_type }}">{{ $job->work_type_label }}</span>
                                @if($job->isActive())
                                    <span class="badge-role badge-active">Active</span>
                                @elseif($job->isBlocked())
                                    <span class="badge-role badge-inactive">Blocked</span>
                                @else
                                    <span class="badge-role" style="background:#f1f5f9;color:#64748b;">Closed</span>
                                @endif
                            </div>
                        </div>
                        @if(!$job->isBlocked())
                            <a href="{{ route('employer.jobs.edit', $job) }}" class="btn btn-outline-warning btn-sm">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>
                        @endif
                    </div>

                    {{-- Key Info --}}
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="p-3 rounded-3" style="background:#f0fdf4;">
                                <small class="text-muted d-block">Salary</small>
                                <span class="fw-bold text-success" style="font-size:18px;">
                                    {{ $job->formatted_salary }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded-3" style="background:#eef2ff;">
                                <small class="text-muted d-block">Hours Per Week</small>
                                <span class="fw-bold" style="font-size:18px;">
                                    {{ $job->hours_per_week ? $job->hours_per_week . ' hours' : 'Flexible' }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded-3" style="background:#fef3c7;">
                                <small class="text-muted d-block">Post Date</small>
                                <span class="fw-bold" style="font-size:18px;">
                                    {{ $job->post_date->format('M d, Y') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Overview --}}
                    <div>
                        <h5 class="fw-bold mb-3">
                            <i class="fas fa-file-alt me-2 text-primary"></i> Job Overview
                        </h5>
                        <div class="job-overview-content p-3 rounded-3" style="background:#f8fafc;">
                            {!! $job->overview !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="data-table">
                <div class="p-3 border-bottom">
                    <h6 class="fw-bold mb-0">Application Stats</h6>
                </div>
                <div class="p-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Total</span>
                        <span class="fw-bold">{{ $job->applications->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Pending</span>
                        <span class="badge-role badge-app-pending">{{ $job->applications->where('status','pending')->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Accepted</span>
                        <span class="badge-role badge-app-accepted">{{ $job->applications->where('status','accepted')->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Rejected</span>
                        <span class="badge-role badge-app-rejected">{{ $job->applications->where('status','rejected')->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Applications --}}
    <div class="data-table mt-4">
        <div class="p-3 border-bottom">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-users me-2"></i> Applications ({{ $job->applications->count() }})
            </h5>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Freelancer</th>
                    <th>Cover Letter</th>
                    <th>Expected Salary</th>
                    <th>Status</th>
                    <th>Applied</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($job->applications as $application)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $application->freelancer->name }}</div>
                            <small class="text-muted">{{ $application->freelancer->email }}</small>
                            @if($application->freelancer->phone)
                                <br><small class="text-muted"><i class="fas fa-phone me-1"></i>{{ $application->freelancer->phone }}</small>
                            @endif
                        </td>
                        <td><span title="{{ $application->cover_letter }}">{{ Str::limit($application->cover_letter, 80) }}</span></td>
                        <td>
                            @if($application->expected_salary)
                                <span class="fw-bold text-success">${{ number_format($application->expected_salary, 2) }}</span>
                            @else —
                            @endif
                        </td>
                        <td>
                            @if($application->isPending())
                                <span class="badge-role badge-app-pending">Pending</span>
                            @elseif($application->isAccepted())
                                <span class="badge-role badge-app-accepted">Accepted</span>
                            @else
                                <span class="badge-role badge-app-rejected">Rejected</span>
                            @endif
                        </td>
                        <td>{{ $application->created_at->diffForHumans() }}</td>
                        <td>
                            @if($application->isPending())
                                <div class="d-flex gap-1">
                                    <form action="{{ route('employer.applications.update', $application) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="accepted">
                                        <button class="btn btn-sm btn-success" title="Accept">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('employer.applications.update', $application) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="rejected">
                                        <button class="btn btn-sm btn-danger" title="Reject">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="text-muted small">{{ ucfirst($application->status) }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-2x mb-2 d-block" style="opacity:0.3;"></i>
                            No applications yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
