{{-- resources/views/admin/users/employers.blade.php --}}

@extends('layouts.admin')

@section('title', 'Employers')
@section('page-title', 'Employers')

@section('content')
    <div class="data-table mb-4">
        <div class="p-3">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-8">
                    <input type="text" name="search" class="form-control"
                           placeholder="Search by name or email..." value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i> Search
                    </button>
                    <a href="{{ route('admin.users.employers') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="data-table">
        <div class="p-3 border-bottom">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-building me-2"></i> Employers ({{ $employers->total() }})
            </h5>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Email Verified</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employers as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td class="fw-semibold">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?? '—' }}</td>
                        <td>
                            @if($user->email_verified_at)
                                <span class="badge-role badge-verified"><i class="fas fa-check me-1"></i>Verified</span>
                            @else
                                <span class="badge-role badge-unverified"><i class="fas fa-times me-1"></i>Unverified</span>
                            @endif
                        </td>
                        <td>
                            @if($user->is_active)
                                <span class="badge-role badge-active">Active</span>
                            @else
                                <span class="badge-role badge-inactive">Inactive</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-outline-{{ $user->is_active ? 'warning' : 'success' }}">
                                        <i class="fas fa-{{ $user->is_active ? 'ban' : 'check' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                      onsubmit="return confirm('Delete this employer?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center py-4 text-muted">No employers found</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($employers->hasPages())
            <div class="p-3">{{ $employers->withQueryString()->links() }}</div>
        @endif
    </div>
@endsection