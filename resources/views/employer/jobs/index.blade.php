@extends('layouts.dashboard')

@section('title', 'My Job Posts')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0"><i class="fas fa-briefcase me-2"></i> My Job Posts</h4>
        <a href="{{ route('employer.jobs.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Post New Job
        </a>
    </div>

    {{-- Filters --}}
    <div class="data-table mb-4">
        <div class="p-3">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search by title..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                        <option value="blocked" {{ request('status') == 'blocked' ? 'selected' : '' }}>Blocked</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="work_type" class="form-select">
                        <option value="">All Types</option>
                        @foreach(\App\Models\JobPost::WORK_TYPES as $key => $label)
                            <option value="{{ $key }}" {{ request('work_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100"><i class="fas fa-search me-1"></i> Filter</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="data-table">
        <table class="table">
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Type</th>
                    <th>Salary</th>
                    <th>Hrs/Week</th>
                    <th>Applications</th>
                    <th>Status</th>
                    <th>Post Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobs as $job)
                    <tr>
                        <td>
                            <a href="{{ route('employer.jobs.show', $job) }}"
                               class="fw-semibold text-decoration-none text-dark">
                                {{ Str::limit($job->title, 35) }}
                            </a>
                        </td>
                        <td><span class="badge-work-type badge-{{ $job->work_type }}">{{ $job->work_type_label }}</span></td>
                        <td class="job-salary" style="font-size:13px;">{{ $job->formatted_salary }}</td>
                        <td>{{ $job->hours_per_week ? $job->hours_per_week . ' hrs' : '—' }}</td>
                        <td><span class="badge bg-primary rounded-pill">{{ $job->applications_count }}</span></td>
                        <td>
                            @if($job->isActive())
                                <span class="badge-role badge-active">Active</span>
                            @elseif($job->isBlocked())
                                <span class="badge-role badge-inactive"><i class="fas fa-ban me-1"></i>Blocked</span>
                            @else
                                <span class="badge-role" style="background:#f1f5f9;color:#64748b;">Closed</span>
                            @endif
                        </td>
                        <td>{{ $job->post_date->format('M d, Y') }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('employer.jobs.show', $job) }}" class="btn btn-sm btn-outline-primary" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if(!$job->isBlocked())
                                    <a href="{{ route('employer.jobs.edit', $job) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('employer.jobs.toggle-status', $job) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-sm btn-outline-{{ $job->isActive() ? 'secondary' : 'success' }}"
                                                title="{{ $job->isActive() ? 'Close' : 'Reopen' }}">
                                            <i class="fas fa-{{ $job->isActive() ? 'pause' : 'play' }}"></i>
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('employer.jobs.destroy', $job) }}" method="POST"
                                      onsubmit="return confirm('Delete this job post?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="fas fa-briefcase fa-3x mb-3 d-block" style="opacity:0.3;"></i>
                            No jobs posted yet.
                            <br><a href="{{ route('employer.jobs.create') }}">Post your first job!</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if($jobs->hasPages())
            <div class="p-3">{{ $jobs->withQueryString()->links() }}</div>
        @endif
    </div>
@endsection
