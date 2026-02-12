@extends('layouts.dashboard')

@section('title', 'My Applications')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0"><i class="fas fa-file-alt me-2"></i> My Applications</h4>
        <a href="{{ route('freelancer.jobs.index') }}" class="btn btn-primary">
            <i class="fas fa-search me-2"></i> Browse Jobs
        </a>
    </div>

    <div class="data-table mb-4">
        <div class="p-3">
            <form method="GET" class="d-flex gap-3">
                <select name="status" class="form-select" style="max-width:200px;">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
                <button class="btn btn-primary"><i class="fas fa-filter me-1"></i> Filter</button>
            </form>
        </div>
    </div>

    <div class="data-table">
        <table class="table">
            <thead>
                <tr>
                    <th>Job</th>
                    <th>Employer</th>
                    <th>Type</th>
                    <th>Salary</th>
                    <th>Status</th>
                    <th>Applied</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $app)
                    <tr>
                        <td>
                            <a href="{{ route('freelancer.jobs.show', $app->jobPost) }}"
                               class="fw-semibold text-decoration-none text-dark">
                                {{ Str::limit($app->jobPost->title, 30) }}
                            </a>
                        </td>
                        <td>{{ $app->jobPost->employer->name }}</td>
                        <td><span class="badge-work-type badge-{{ $app->jobPost->work_type }}">{{ $app->jobPost->work_type_label }}</span></td>
                        <td class="job-salary" style="font-size:13px;">{{ $app->jobPost->formatted_salary }}</td>
                        <td>
                            @if($app->isPending())
                                <span class="badge-role badge-app-pending">Pending</span>
                            @elseif($app->isAccepted())
                                <span class="badge-role badge-app-accepted">Accepted</span>
                            @else
                                <span class="badge-role badge-app-rejected">Rejected</span>
                            @endif
                        </td>
                        <td>{{ $app->created_at->diffForHumans() }}</td>
                        <td>
                            @if($app->isPending())
                                <form action="{{ route('freelancer.applications.withdraw', $app) }}" method="POST"
                                      onsubmit="return confirm('Withdraw?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-undo"></i></button>
                                </form>
                            @else —
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-file-alt fa-3x mb-3 d-block" style="opacity:0.3;"></i>
                            No applications yet. <a href="{{ route('freelancer.jobs.index') }}">Browse jobs</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if($applications->hasPages())
            <div class="p-3">{{ $applications->withQueryString()->links() }}</div>
        @endif
    </div>
@endsection
