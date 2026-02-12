@extends('layouts.dashboard')

@section('title', 'Post New Job')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('employer.jobs.index') }}" class="btn btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h4 class="fw-bold mb-0"><i class="fas fa-plus-circle me-2 text-primary"></i> Post New Job</h4>
            </div>

            <div class="data-table">
                <div class="p-4">
                    <form method="POST" action="{{ route('employer.jobs.store') }}" id="jobForm">
                        @csrf

                        {{-- 1. Job Post Title --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-heading me-1 text-primary"></i>
                                Job Post Title <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="title"
                                   class="form-control form-control-lg @error('title') is-invalid @enderror"
                                   value="{{ old('title') }}"
                                   placeholder="e.g. Senior Web Developer, Graphic Designer..."
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 2. Type of Work --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-briefcase me-1 text-primary"></i>
                                Type of Work <span class="text-danger">*</span>
                            </label>
                            <div class="row g-2">
                                @foreach(\App\Models\JobPost::WORK_TYPES as $key => $label)
                                    <div class="col-md-4 col-6">
                                        <div class="form-check work-type-card">
                                            <input class="form-check-input" type="radio"
                                                   name="work_type" id="wt_{{ $key }}"
                                                   value="{{ $key }}"
                                                   {{ old('work_type') == $key ? 'checked' : '' }}
                                                   required>
                                            <label class="form-check-label" for="wt_{{ $key }}">
                                                @php
                                                    $icons = [
                                                        'full_time'  => 'fas fa-business-time',
                                                        'part_time'  => 'fas fa-clock',
                                                        'contract'   => 'fas fa-file-contract',
                                                        'freelance'  => 'fas fa-laptop-code',
                                                        'internship' => 'fas fa-graduation-cap',
                                                        'temporary'  => 'fas fa-hourglass-half',
                                                    ];
                                                @endphp
                                                <i class="{{ $icons[$key] ?? 'fas fa-briefcase' }} me-1"></i>
                                                {{ $label }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('work_type')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 3. Wage / Salary --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-money-bill-wave me-1 text-primary"></i>
                                Wage / Salary <span class="text-danger">*</span>
                            </label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-success text-white">$</span>
                                        <input type="number" name="salary" step="0.01" min="0"
                                               class="form-control @error('salary') is-invalid @enderror"
                                               value="{{ old('salary') }}"
                                               placeholder="Enter amount"
                                               required>
                                    </div>
                                    @error('salary')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <select name="salary_type"
                                            class="form-select form-select-lg @error('salary_type') is-invalid @enderror"
                                            required>
                                        @foreach(\App\Models\JobPost::SALARY_TYPES as $key => $label)
                                            <option value="{{ $key }}"
                                                {{ old('salary_type', 'monthly') == $key ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('salary_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- 4. Hours Per Week --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-clock me-1 text-primary"></i>
                                Hours Per Week
                            </label>
                            <div class="input-group" style="max-width: 300px;">
                                <input type="number" name="hours_per_week" min="1" max="168"
                                       class="form-control form-control-lg @error('hours_per_week') is-invalid @enderror"
                                       value="{{ old('hours_per_week') }}"
                                       placeholder="e.g. 40">
                                <span class="input-group-text">hrs/week</span>
                            </div>
                            @error('hours_per_week')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Leave empty if flexible</small>
                        </div>

                        {{-- 5. Job Post Date --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-calendar-alt me-1 text-primary"></i>
                                Job Post Date <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="post_date"
                                   class="form-control form-control-lg @error('post_date') is-invalid @enderror"
                                   value="{{ old('post_date', date('Y-m-d')) }}"
                                   style="max-width: 300px;"
                                   required>
                            @error('post_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 6. Job Post Overview (CKEditor) --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-file-alt me-1 text-primary"></i>
                                Job Post Overview <span class="text-danger">*</span>
                            </label>
                            <textarea name="overview" id="overview"
                                      class="form-control @error('overview') is-invalid @enderror">{{ old('overview') }}</textarea>
                            @error('overview')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Describe the job role, responsibilities, requirements, benefits etc.</small>
                        </div>

                        {{-- Submit --}}
                        <div class="d-flex gap-3 pt-3 border-top">
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-paper-plane me-2"></i> Post Job
                            </button>
                            <a href="{{ route('employer.jobs.index') }}" class="btn btn-outline-secondary btn-lg">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .work-type-card {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px 14px 14px 42px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .work-type-card:hover {
        border-color: #4f46e5;
        background: #f8fafc;
    }
    .work-type-card:has(.form-check-input:checked) {
        border-color: #4f46e5;
        background: #eef2ff;
    }
    .work-type-card .form-check-label {
        cursor: pointer;
        font-weight: 500;
    }
</style>
@endpush

@push('scripts')
{{-- CKEditor 5 CDN --}}
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#overview'), {
            toolbar: [
                'heading', '|',
                'bold', 'italic', 'underline', 'strikethrough', '|',
                'bulletedList', 'numberedList', '|',
                'blockQuote', 'insertTable', '|',
                'link', '|',
                'undo', 'redo'
            ],
            placeholder: 'Write a detailed job overview...\n\nInclude:\n• Job responsibilities\n• Requirements & qualifications\n• Benefits & perks\n• Company culture',
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                    { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                    { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                ]
            }
        })
        .then(editor => {
            // Set min height
            editor.editing.view.change(writer => {
                writer.setStyle('min-height', '250px', editor.editing.view.document.getRoot());
            });
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endpush
