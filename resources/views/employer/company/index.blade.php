@extends('layouts.dashboard')
@section('title', $company ? 'Edit Company Profile' : 'Create Company Profile')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" />
<style>
    .company-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        padding: 32px;
    }
    .company-header {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 32px;
        padding-bottom: 24px;
        border-bottom: 1px solid #f1f5f9;
    }
    .company-logo-preview {
        width: 100px;
        height: 100px;
        border-radius: 16px;
        object-fit: cover;
        border: 2px solid #e2e8f0;
    }
    .company-logo-placeholder {
        width: 100px;
        height: 100px;
        border-radius: 16px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        font-size: 40px;
    }
    .form-label-custom {
        font-weight: 600;
        color: #334155;
        margin-bottom: 6px;
        font-size: 14px;
    }
    .form-control-custom {
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px 16px;
        font-size: 14px;
        transition: all 0.2s;
    }
    .form-control-custom:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
    }
    .dropzone-container {
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        padding: 30px;
        text-align: center;
        background: #f8fafc;
        cursor: pointer;
        transition: all 0.3s;
        min-height: 160px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .dropzone-container:hover {
        border-color: #6366f1;
        background: #eef2ff;
    }
    .dropzone-container.dz-drag-hover {
        border-color: #6366f1;
        background: #e0e7ff;
    }
    .dropzone-icon {
        font-size: 40px;
        color: #94a3b8;
        margin-bottom: 10px;
    }
    .dropzone-text {
        color: #64748b;
        font-size: 14px;
    }
    .dropzone-text span {
        color: #6366f1;
        font-weight: 600;
    }
    .current-logo-section {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px;
        background: #f8fafc;
        border-radius: 12px;
        margin-bottom: 12px;
    }
    .current-logo-section img {
        width: 80px;
        height: 80px;
        border-radius: 12px;
        object-fit: cover;
        border: 2px solid #e2e8f0;
    }
    .btn-remove-logo {
        background: #fee2e2;
        color: #dc2626;
        border: none;
        padding: 6px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-remove-logo:hover {
        background: #fecaca;
    }
    .field-empty {
        color: #94a3b8;
        font-style: italic;
        font-size: 13px;
    }
    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 24px;
    }
    .info-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    .info-badge-new {
        background: #dbeafe;
        color: #2563eb;
    }
    .info-badge-complete {
        background: #dcfce7;
        color: #16a34a;
    }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">
            <i class="fas fa-building me-2" style="color: #6366f1;"></i>
            {{ $company ? 'Edit Company Profile' : 'Create Company Profile' }}
        </h4>
        <p class="text-muted mb-0">
            @if($company)
                <span class="info-badge info-badge-complete"><i class="fas fa-check-circle"></i> Profile Created</span>
            @else
                <span class="info-badge info-badge-new"><i class="fas fa-info-circle"></i> Setup your company profile</span>
            @endif
        </p>
    </div>
    <a href="{{ route('employer.dashboard') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
    </a>
</div>

<div class="company-card">
    {{-- Company Header Preview --}}
    @if($company)
        <div class="company-header">
            @if($company->has_logo)
                <img src="{{ $company->logo_url }}" alt="{{ $company->company_name }}" class="company-logo-preview">
            @else
                <div class="company-logo-placeholder">
                    <i class="fas fa-building"></i>
                </div>
            @endif
            <div>
                <h5 class="fw-bold mb-1">{{ $company->company_name }}</h5>
                <p class="text-muted mb-0" style="font-size: 13px;">
                    @if($company->company_email)
                        <i class="fas fa-envelope me-1"></i> {{ $company->company_email }}
                    @else
                        <span class="field-empty">No email added</span>
                    @endif
                </p>
            </div>
        </div>
    @endif

    {{-- Form --}}
    <form action="{{ $company ? route('employer.company.update') : route('employer.company.store') }}"
          method="POST"
          enctype="multipart/form-data"
          id="companyForm">
        @csrf
        @if($company) @method('PUT') @endif

        <div class="row g-4">
            {{-- Company Name --}}
            <div class="col-md-6">
                <label class="form-label-custom">Company Name <span class="text-danger">*</span></label>
                <input type="text"
                       name="company_name"
                       class="form-control form-control-custom @error('company_name') is-invalid @enderror"
                       value="{{ old('company_name', $company->company_name ?? '') }}"
                       placeholder="Enter your company name"
                       required>
                @error('company_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Company Email --}}
            <div class="col-md-6">
                <label class="form-label-custom">Company Email</label>
                <input type="email"
                       name="company_email"
                       class="form-control form-control-custom @error('company_email') is-invalid @enderror"
                       value="{{ old('company_email', $company->company_email ?? '') }}"
                       placeholder="contact@company.com">
                @error('company_email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Company Phone --}}
            <div class="col-md-6">
                <label class="form-label-custom">Company Phone</label>
                <input type="text"
                       name="company_phone"
                       class="form-control form-control-custom @error('company_phone') is-invalid @enderror"
                       value="{{ old('company_phone', $company->company_phone ?? '') }}"
                       placeholder="+91 XXXXX XXXXX">
                @error('company_phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Company Address --}}
            <div class="col-md-6">
                <label class="form-label-custom">Company Address</label>
                <textarea name="company_address"
                          class="form-control form-control-custom @error('company_address') is-invalid @enderror"
                          rows="1"
                          placeholder="Enter company address">{{ old('company_address', $company->company_address ?? '') }}</textarea>
                @error('company_address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Company Logo (Dropzone) --}}
            <div class="col-12">
                <label class="form-label-custom">Company Logo</label>

                {{-- Current Logo --}}
                @if($company && $company->has_logo)
                    <div class="current-logo-section" id="currentLogoSection">
                        <img src="{{ $company->logo_url }}" alt="Current Logo" id="currentLogoImg">
                        <div>
                            <p class="mb-1 fw-semibold" style="font-size: 14px;">Current Logo</p>
                            <p class="text-muted mb-2" style="font-size: 12px;">Upload a new logo to replace or remove current one</p>
                            <button type="button" class="btn-remove-logo" id="removeLogoBtn">
                                <i class="fas fa-trash-alt me-1"></i> Remove Logo
                            </button>
                        </div>
                    </div>
                @endif

                {{-- Dropzone Area --}}
                <div id="logoDropzone" class="dropzone-container">
                    <div class="dropzone-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                    <p class="dropzone-text mb-1">Drag & drop your logo here or <span>browse</span></p>
                    <p class="text-muted" style="font-size: 12px;">JPG, JPEG, PNG, WEBP • Max 2MB</p>
                </div>

                {{-- Hidden file input --}}
                <input type="file" name="company_logo" id="logoFileInput" style="display: none;" accept="image/jpg,image/jpeg,image/png,image/webp">

                {{-- Preview --}}
                <div id="logoPreview" class="mt-3" style="display: none;">
                    <div class="d-flex align-items-center gap-3 p-3" style="background: #f0fdf4; border-radius: 12px; border: 1px solid #bbf7d0;">
                        <img id="previewImg" src="" alt="Preview" style="width: 60px; height: 60px; border-radius: 10px; object-fit: cover;">
                        <div class="flex-grow-1">
                            <p class="mb-0 fw-semibold" style="font-size: 14px;" id="previewName">filename.jpg</p>
                            <p class="mb-0 text-muted" style="font-size: 12px;" id="previewSize">0 KB</p>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger" id="removePreview">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                @error('company_logo')
                    <div class="text-danger mt-1" style="font-size: 13px;">{{ $message }}</div>
                @enderror
            </div>

            {{-- Submit --}}
            <div class="col-12">
                <hr class="my-2">
                <div class="d-flex justify-content-end gap-3 mt-3">
                    <a href="{{ route('employer.dashboard') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4" id="submitBtn">
                        <i class="fas fa-save me-2"></i>
                        {{ $company ? 'Update Company Profile' : 'Create Company Profile' }}
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropzone = document.getElementById('logoDropzone');
    const fileInput = document.getElementById('logoFileInput');
    const preview = document.getElementById('logoPreview');
    const previewImg = document.getElementById('previewImg');
    const previewName = document.getElementById('previewName');
    const previewSize = document.getElementById('previewSize');
    const removePreview = document.getElementById('removePreview');
    const removeLogoBtn = document.getElementById('removeLogoBtn');
    const currentLogoSection = document.getElementById('currentLogoSection');

    // Click to browse
    dropzone.addEventListener('click', function() {
        fileInput.click();
    });

    // Drag & Drop events
    ['dragenter', 'dragover'].forEach(event => {
        dropzone.addEventListener(event, function(e) {
            e.preventDefault();
            dropzone.classList.add('dz-drag-hover');
        });
    });

    ['dragleave', 'drop'].forEach(event => {
        dropzone.addEventListener(event, function(e) {
            e.preventDefault();
            dropzone.classList.remove('dz-drag-hover');
        });
    });

    dropzone.addEventListener('drop', function(e) {
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            handleFile(files[0]);
        }
    });

    // File input change
    fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            handleFile(this.files[0]);
        }
    });

    function handleFile(file) {
        // Validate type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        if (!allowedTypes.includes(file.type)) {
            alert('Please upload JPG, JPEG, PNG, or WEBP image only.');
            return;
        }

        // Validate size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('File size must be less than 2MB.');
            return;
        }

        // Set file to input
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        fileInput.files = dataTransfer.files;

        // Show preview
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewName.textContent = file.name;
            previewSize.textContent = formatFileSize(file.size);
            preview.style.display = 'block';
            dropzone.style.display = 'none';
        };
        reader.readAsDataURL(file);
    }

    // Remove preview
    if (removePreview) {
        removePreview.addEventListener('click', function() {
            fileInput.value = '';
            preview.style.display = 'none';
            dropzone.style.display = 'flex';
        });
    }

    // Remove existing logo (AJAX)
    if (removeLogoBtn) {
        removeLogoBtn.addEventListener('click', function() {
            if (!confirm('Are you sure you want to remove the company logo?')) return;

            fetch('{{ route("employer.company.remove-logo") }}', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (currentLogoSection) {
                        currentLogoSection.style.display = 'none';
                    }
                    // Update header preview if exists
                    const headerLogo = document.querySelector('.company-logo-preview');
                    if (headerLogo) {
                        headerLogo.outerHTML = '<div class="company-logo-placeholder"><i class="fas fa-building"></i></div>';
                    }
                }
            })
            .catch(error => {
                alert('Failed to remove logo. Please try again.');
            });
        });
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
});
</script>
@endpush
