{{-- resources/views/admin/admins/index.blade.php --}}

@extends('layouts.admin')

@section('title', 'All Admins')
@section('page-title', 'Admin Management')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <form method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control"
                       placeholder="Search admins..." value="{{ request('search') }}" style="width:300px;">
                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
            </form>
        </div>
        <a href="{{ route('admin.admins.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Create New Admin
        </a>
    </div>

    <div class="data-table">
        <div class="p-3 border-bottom">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-user-shield me-2"></i> Admins ({{ $admins->total() }})
            </h5>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admins as $admin)
                    <tr>
                        <td>{{ $admin->id }}</td>
                        <td class="fw-semibold">
                            {{ $admin->name }}
                            @if($admin->id === auth()->id())
                                <span class="badge bg-info ms-1">You</span>
                            @endif
                        </td>
                        <td>{{ $admin->email }}</td>
                        <td>{{ $admin->phone ?? '—' }}</td>
                        <td>{{ $admin->created_at->format('M d, Y') }}</td>
                        <td>
                            @if($admin->id !== auth()->id())
                                <form action="{{ route('admin.admins.destroy', $admin) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this admin?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash me-1"></i> Delete
                                    </button>
                                </form>
                            @else
                                <span class="text-muted small">Current user</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">No admins found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if($admins->hasPages())
            <div class="p-3">{{ $admins->withQueryString()->links() }}</div>
        @endif
    </div>
@endsection