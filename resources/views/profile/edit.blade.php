@extends($layout)

@section('title', 'Edit Profile')
@section('page-title', 'Edit Profile')

@section('content')
    <div class="row g-4">
        {{-- Profile Info Card --}}
        <div class="col-lg-8">
            <div class="data-table">
                <div class="p-3 border-bottom">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-user me-2"></i> Profile Information
                    </h5>
                </div>
                <div class="p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Full Name</label>
                                <input type="text" name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email Address</label>
                                <input type="email" name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if(!$user->hasVerifiedEmail())
                                    <small class="text-danger">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        Email not verified.
                                        <form action="{{ route('verification.resend') }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-link btn-sm p-0 text-primary">
                                                Resend verification
                                            </button>
                                        </form>
                                    </small>
                                @else
                                    <small class="text-success">
                                        <i class="fas fa-check-circle me-1"></i> Verified
                                    </small>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Phone</label>
                                <input type="text" name="phone"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       value="{{ old('phone', $user->phone) }}"
                                       placeholder="+1 234 567 890">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Role</label>
                                <input type="text" class="form-control" value="{{ ucfirst($user->role) }}" disabled>
                                <small class="text-muted">Role cannot be changed</small>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Bio</label>
                                <textarea name="bio" rows="4"
                                          class="form-control @error('bio') is-invalid @enderror"
                                          placeholder="Tell us about yourself...">{{ old('bio', $user->bio) }}</textarea>
                                @error('bio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Profile Summary Card --}}
        <div class="col-lg-4">
            <div class="data-table mb-4">
                <div class="p-4 text-center">
                    <div style="width:100px;height:100px;border-radius:50%;background:linear-gradient(135deg,#667eea,#764ba2);margin:0 auto 16px;display:flex;align-items:center;justify-content:center;font-size:40px;color:#fff;font-weight:700;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                    <p class="text-muted mb-2">{{ $user->email }}</p>
                    <span class="badge-role badge-{{ $user->role }}">{{ ucfirst($user->role) }}</span>

                    <hr class="my-3">

                    <div class="text-start">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Phone</span>
                            <span class="small fw-semibold">{{ $user->phone ?? '—' }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Status</span>
                            <span>
                                @if($user->is_active)
                                    <span class="badge-role badge-active" style="font-size:11px;">Active</span>
                                @else
                                    <span class="badge-role badge-inactive" style="font-size:11px;">Inactive</span>
                                @endif
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Email Verified</span>
                            <span>
                                @if($user->hasVerifiedEmail())
                                    <span class="badge-role badge-verified" style="font-size:11px;">Yes</span>
                                @else
                                    <span class="badge-role badge-unverified" style="font-size:11px;">No</span>
                                @endif
                            </span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small">Member Since</span>
                            <span class="small fw-semibold">{{ $user->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Change Password Card --}}
    <div class="row g-4 mt-1">
        <div class="col-lg-6">
            <div class="data-table">
                <div class="p-3 border-bottom">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-lock me-2"></i> Change Password
                    </h5>
                </div>
                <div class="p-4">
                    @if(session('password_success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-1"></i> {{ session('password_success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.password') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Current Password</label>
                            <input type="password" name="current_password"
                                   class="form-control @error('current_password') is-invalid @enderror"
                                   placeholder="Enter current password" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">New Password</label>
                            <input type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Min. 8 characters" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Confirm New Password</label>
                            <input type="password" name="password_confirmation"
                                   class="form-control"
                                   placeholder="Repeat new password" required>
                        </div>

                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-key me-2"></i> Change Password
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Delete Account Card --}}
        <div class="col-lg-6">
            <div class="data-table" style="border: 2px solid #fee2e2;">
                <div class="p-3 border-bottom" style="background:#fef2f2;">
                    <h5 class="mb-0 fw-bold text-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i> Danger Zone
                    </h5>
                </div>
                <div class="p-4">
                    <p class="text-muted">
                        Once you delete your account, all data will be <strong>permanently removed</strong>.
                        This action cannot be undone.
                    </p>

                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                            data-bs-target="#deleteAccountModal">
                        <i class="fas fa-trash me-2"></i> Delete My Account
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Account Modal --}}
    <div class="modal fade" id="deleteAccountModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius:16px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i> Delete Account
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('profile.delete') }}">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p class="text-muted">
                            Are you sure you want to delete your account? This will permanently remove all your data.
                            Enter your password to confirm.
                        </p>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Confirm Password</label>
                            <input type="password" name="delete_password"
                                   class="form-control @error('delete_password') is-invalid @enderror"
                                   placeholder="Enter your password" required>
                            @error('delete_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-2"></i> Yes, Delete Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Auto-open modal if delete_password error --}}
    @if($errors->has('delete_password'))
        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    new bootstrap.Modal(document.getElementById('deleteAccountModal')).show();
                });
            </script>
        @endpush
    @endif
@endsection
