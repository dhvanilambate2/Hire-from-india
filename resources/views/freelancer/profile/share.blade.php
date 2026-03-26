@extends('layouts.dashboard')

@section('title', 'Share Profile')
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="data-table">
                <div class="p-3 border-bottom">
                    <h5 class="fw-bold mb-0"><i class="fas fa-share-alt me-2"></i> Share Your Profile</h5>
                </div>
                <div class="p-4">
                    {{-- Profile Preview --}}
                    <div class="text-center mb-4">
                        @if($user->has_profile_photo)
                            <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"
                                 style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:3px solid #e2e8f0;">
                        @else
                            <div style="width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,#667eea,#764ba2);display:inline-flex;align-items:center;justify-content:center;font-size:32px;color:#fff;font-weight:700;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                        <h5 class="fw-bold mt-2 mb-0">{{ $user->name }}</h5>
                        <p class="text-muted small">{{ $user->email }}</p>
                    </div>

                    {{-- Shareable Link --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Your Profile Link</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="profileUrl" value="{{ $profileUrl }}" readonly
                                   style="background:#f8fafc;font-size:14px;">
                            <button class="btn btn-primary" onclick="copyLink()" id="copyBtn">
                                <i class="fas fa-copy me-1"></i> Copy
                            </button>
                        </div>
                    </div>

                    {{-- Share Options --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Share On</label>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="https://wa.me/?text=Check out my freelancer profile: {{ urlencode($profileUrl) }}"
                               target="_blank" class="btn btn-success">
                                <i class="fab fa-whatsapp me-1"></i> WhatsApp
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($profileUrl) }}"
                               target="_blank" class="btn btn-primary">
                                <i class="fab fa-linkedin me-1"></i> LinkedIn
                            </a>
                            <a href="https://twitter.com/intent/tweet?text=Check out my freelancer profile on HireFormIndia&url={{ urlencode($profileUrl) }}"
                               target="_blank" class="btn btn-info text-white">
                                <i class="fab fa-twitter me-1"></i> Twitter
                            </a>
                            <a href="mailto:?subject=My Freelancer Profile&body=Check out my profile: {{ $profileUrl }}"
                               class="btn btn-secondary">
                                <i class="fas fa-envelope me-1"></i> Email
                            </a>
                        </div>
                    </div>

                    {{-- QR Code --}}
                    <div class="text-center p-4" style="background:#f8fafc;border-radius:12px;">
                        <p class="fw-semibold mb-3">QR Code</p>
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($profileUrl) }}"
                             alt="QR Code" style="border-radius:12px;border:4px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,0.1);">
                        <p class="text-muted small mt-2 mb-0">Scan to view profile</p>
                    </div>

                    {{-- Preview Button --}}
                    <div class="text-center mt-4">
                        <a href="{{ $profileUrl }}" target="_blank" class="btn btn-outline-primary">
                            <i class="fas fa-external-link-alt me-2"></i> Preview Public Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function copyLink() {
        const input = document.getElementById('profileUrl');
        const btn = document.getElementById('copyBtn');

        navigator.clipboard.writeText(input.value).then(() => {
            btn.innerHTML = '<i class="fas fa-check me-1"></i> Copied!';
            btn.classList.remove('btn-primary');
            btn.classList.add('btn-success');

            setTimeout(() => {
                btn.innerHTML = '<i class="fas fa-copy me-1"></i> Copy';
                btn.classList.remove('btn-success');
                btn.classList.add('btn-primary');
            }, 2000);
        });
    }
</script>
@endpush
