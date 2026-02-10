{{-- resources/views/admin/admins/create.blade.php --}}

@extends('layouts.admin')

@section('title', 'Create Admin')
@section('page-title', 'Create New Admin')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="data-table">
                <div class="p-3 border-bottom">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-user-plus me-2"></i> New Admin Account
                    </h5>
                </div>
                <div class="p-4">
                    <form method="POST" action="{{ route('admin.admins.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Full Name</label>
                            <input type="text" name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}" placeholder="Admin Name" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email Address</label>
                            <input type="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" placeholder="admin@example.com" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Phone <small class="text-muted">(optional)</small></label>
                            <input type="text" name="phone"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   value="{{ old('phone') }}" placeholder="+1 234 567 890">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password</label>
                            <input type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Min. 8 characters" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Confirm Password</label>
                            <input type="password" name="password_confirmation"
                                   class="form-control" placeholder="Repeat password" required>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check me-2"></i> Create Admin
                            </button>
                            <a href="{{ route('admin.admins.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection