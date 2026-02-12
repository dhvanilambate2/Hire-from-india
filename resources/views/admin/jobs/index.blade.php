@extends('layouts.admin')

@section('title', 'All Job Posts')
@section('page-title', 'Job Management')

@section('content')
    {{-- Stats --}}
    <div class="row g-4 mb-4">
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between">
                    <div><div class="stat-number">{{ $stats['total'] }}</div><div class="stat-label">Total</div></div>
                    <div class="stat-icon" style="background:#eef2ff;color:#4f46e5;"><i class="fas fa-briefcase"></i></div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between">
                    <div><div class="stat-number">{{ $stats['active'] }}</div><div class="stat-label">Active</div></div>
                    <div class="stat-icon" style="background:#dcfce7;color:#16a34a;"><i class="fas fa-check-circle"></i></div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between">
                    <div><div class="stat-number">{{ $stats['closed'] }}</div><div class="stat-label">Closed</div></div>
                    <div class="stat-icon" style="background:#f1f5f9;color:#64748b;"><i class="fas fa-pause-circle"></i></div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between">
                    <div><div class="stat-number">{{ $stats['blocked'] }}</div><div class="stat-label">Blocked</div></div>
                    <div class="stat-icon" style="background:#fee2e2;color:#dc2626;"><i class="fas fa-ban"></i></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="data-table mb-4">
        <div class="p-3">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control"
                           placeholder="Search title or employer..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                        <option value="blocked" {{ request('status') == 'blocked' ? 'selected' : '' }}>Blocked</option>
                    </select>
                </div>
                <div class="col-md-2">
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
                <div class="col-md-2">
                    <a href="{{ route('admin.jobs.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="data-table">
        <div class="p-3 border-bottom">
            <h5 class="mb-0 fw-bold"><i class="fas fa-briefcase me-2"></i> Job Posts ({{ $jobs->total() }})</h5>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Employer</th>
                    <th>Type</th>
                    <th>Salary</th>
                    <th>Hrs/Week</th>
                    <th>Apps</th>
                    <th>Status</th>
                    <th>Post Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobs as $job)
                    <tr>
                        <td>{{ $job->id }}</td>
                        <td>
                            <a href="{{ route('admin.jobs.show', $job) }}" class="fw-semibold text-decoration-none text-dark">
                                {{ Str::limit($job->title, 30) }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('admin.users.show', $job->employer) }}" class="text-decoration-none">
                                {{ $job->employer->name }}
                            </a>
                        </td>
                        <td><span class="badge-work-type badge-{{ $job->work_type }}">{{ $job->work_type_label }}</span></td>
                        <td class="job-salary" style="font-size:12px;">{{ $job->formatted_salary }}</td>
                        <td>{{ $job->hours_per_week ?? '—' }}</td>
                        <td><span class="badge bg-primary rounded-pill">{{ $job->applications_count }}</span></td>
                        <td>
                            @if($job->isActive()) <span class="badge-role badge-active">Active</span>
                            @elseif($job->isBlocked()) <span class="badge-role badge-inactive"><i class="fas fa-ban me-1"></i>Blocked</span>
                            @else <span class="badge-role" style="background:#f1f5f9;color:#64748b;">Closed</span>
                            @endif
                        </td>
                        <td>{{ $job->post_date->format('M d, Y') }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.jobs.show', $job) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a>
                                @if(!$job->isBlocked())
                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#blockModal{{ $job->id }}">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                @else
                                    <form action="{{ route('admin.jobs.unblock', $job) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-success"><i class="fas fa-check"></i></button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.jobs.destroy', $job) }}" method="POST"
                                      onsubmit="return confirm('Delete permanently?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>

                            {{-- Block Modal --}}
                            @if(!$job->isBlocked())
                                <div class="modal fade" id="blockModal{{ $job->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="border-radius:16px;">
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold text-danger">
                                                    <i class="fas fa-ban me-2"></i> Block Job
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.jobs.block', $job) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <p>Block: <strong>{{ $job->title }}</strong></p>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">Reason <span class="text-danger">*</span></label>
                                                        <textarea name="block_reason" rows="3" class="form-control"
                                                                  placeholder="Why is this being blocked?" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger"><i class="fas fa-ban me-1"></i> Block</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="10" class="text-center py-4 text-muted">No job posts found</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($jobs->hasPages())
            <div class="p-3">{{ $jobs->withQueryString()->links() }}</div>
        @endif
    </div>
@endsection
