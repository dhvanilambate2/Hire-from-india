<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $freelancer->name }} - Freelancer Profile | Hire Form India</title>

    {{-- SEO Meta Tags --}}
    <meta name="description" content="{{ Str::limit($freelancer->bio, 160) }}">
    <meta property="og:title" content="{{ $freelancer->name }} - Freelancer Profile">
    <meta property="og:description" content="{{ Str::limit($freelancer->bio, 160) }}">
    <meta property="og:type" content="profile">
    @if($freelancer->has_profile_photo)
        <meta property="og:image" content="{{ $freelancer->profile_photo_url }}">
    @endif
    <meta property="og:url" content="{{ route('freelancer.profile.public', $freelancer->id) }}">

    {{-- Bootstrap & Font Awesome --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        body {
            background: #f8fafc;
            min-height: 100vh;
        }

        /* ── Navbar ── */
        .profile-navbar {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 0;
        }
        .profile-navbar .brand {
            font-weight: 800;
            font-size: 20px;
            color: #1e293b;
            text-decoration: none;
        }
        .profile-navbar .brand span {
            color: #6366f1;
        }

        /* ── Hero Section ── */
        .profile-hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 60px 0 80px;
            position: relative;
            overflow: hidden;
        }
        .profile-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .profile-hero-content {
            position: relative;
            z-index: 1;
        }

        /* ── Profile Card ── */
        .profile-main-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            margin-top: -50px;
            position: relative;
            z-index: 2;
        }

        /* ── Photo ── */
        .profile-photo-large {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #fff;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }
        .profile-photo-large-placeholder {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 56px;
            color: #fff;
            font-weight: 700;
            border: 5px solid #fff;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }

        /* ── Badges ── */
        .verified-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 12px;
            background: #dcfce7;
            color: #16a34a;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .availability-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 12px;
            background: #dbeafe;
            color: #2563eb;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .rate-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 6px 16px;
            background: #f0fdf4;
            color: #16a34a;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
        }

        /* ── Section ── */
        .profile-section {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            margin-bottom: 24px;
            overflow: hidden;
        }
        .profile-section-header {
            padding: 18px 24px;
            border-bottom: 1px solid #f1f5f9;
            background: #fafbfc;
        }
        .profile-section-body {
            padding: 24px;
        }

        /* ── Skills ── */
        .skill-badge {
            display: inline-flex;
            padding: 6px 16px;
            background: #eef2ff;
            color: #4338ca;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
            margin: 3px;
            transition: all 0.2s;
        }
        .skill-badge:hover {
            background: #e0e7ff;
            transform: translateY(-1px);
        }

        /* ── Timeline ── */
        .timeline-item {
            position: relative;
            padding-left: 30px;
            padding-bottom: 24px;
            border-left: 2px solid #e2e8f0;
        }
        .timeline-item:last-child {
            border-left: 2px solid transparent;
            padding-bottom: 0;
        }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -7px;
            top: 4px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #6366f1;
            border: 2px solid #fff;
            box-shadow: 0 0 0 3px #eef2ff;
        }
        .timeline-card {
            background: #f8fafc;
            border-radius: 12px;
            padding: 16px 20px;
            border: 1px solid #f1f5f9;
            transition: all 0.2s;
        }
        .timeline-card:hover {
            border-color: #6366f1;
            box-shadow: 0 2px 8px rgba(99,102,241,0.1);
        }

        /* ── Portfolio ── */
        .portfolio-card {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 18px;
            background: #f8fafc;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            margin-bottom: 10px;
            text-decoration: none;
            color: inherit;
            transition: all 0.2s;
        }
        .portfolio-card:hover {
            border-color: #6366f1;
            background: #eef2ff;
            color: inherit;
            transform: translateX(4px);
        }
        .portfolio-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: #eef2ff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6366f1;
        }

        /* ── Contact Info ── */
        .contact-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .contact-item:last-child {
            border-bottom: none;
        }
        .contact-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        /* ── Share Button ── */
        .share-float-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: #6366f1;
            color: #fff;
            border: none;
            box-shadow: 0 4px 15px rgba(99,102,241,0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            cursor: pointer;
            transition: all 0.3s;
            z-index: 100;
        }
        .share-float-btn:hover {
            background: #4f46e5;
            transform: scale(1.1);
        }

        /* ── Footer ── */
        .profile-footer {
            padding: 30px 0;
            text-align: center;
            color: #94a3b8;
            font-size: 13px;
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .profile-hero {
                padding: 40px 0 60px;
            }
            .profile-photo-large,
            .profile-photo-large-placeholder {
                width: 110px;
                height: 110px;
                font-size: 44px;
            }
            .profile-main-card {
                margin-top: -40px;
            }
        }

        /* ── Print Styles ── */
        @media print {
            .profile-navbar, .share-float-btn, .profile-footer {
                display: none !important;
            }
            .profile-hero {
                background: #6366f1 !important;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>

    {{-- ── Navbar ── --}}
    <nav class="profile-navbar">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ url('/') }}" class="brand">Hire<span>Form</span>India</a>
                <div class="d-flex gap-2">
                    @auth
                        @if(auth()->id() === $freelancer->id)
                            <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit me-1"></i> Edit Profile
                            </a>
                        @endif
                        <a href="{{ route(auth()->user()->role . '.dashboard') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-sign-in-alt me-1"></i> Login
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-user-plus me-1"></i> Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- ── Hero Section ── --}}
    <section class="profile-hero">
        <div class="profile-hero-content">
            <div class="container text-center text-white">
                {{-- Photo --}}
                @if($freelancer->has_profile_photo)
                    <img src="{{ $freelancer->profile_photo_url }}" alt="{{ $freelancer->name }}" class="profile-photo-large mb-3">
                @else
                    <div class="profile-photo-large-placeholder mx-auto mb-3">
                        {{ strtoupper(substr($freelancer->name, 0, 1)) }}
                    </div>
                @endif

                <h1 class="fw-bold mb-2" style="font-size: 28px;">{{ $freelancer->name }}</h1>

                {{-- Badges --}}
                <div class="d-flex justify-content-center flex-wrap gap-2 mb-3">
                    @if($freelancer->isVerified())
                        <span class="verified-badge">
                            <i class="fas fa-check-circle"></i> Verified
                        </span>
                    @endif
                    @if($freelancer->availability)
                        <span class="availability-badge">
                            <i class="fas fa-clock"></i> {{ $freelancer->availability_label }}
                        </span>
                    @endif
                </div>

                {{-- Rate --}}
                @if($freelancer->hourly_rate)
                    <div class="rate-badge mx-auto">
                        <i class="fas fa-money-bill-wave"></i> ₹{{ number_format($freelancer->hourly_rate) }}/hr
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ── Main Content ── --}}
    <div class="container" style="max-width: 1000px;">
        <div class="profile-main-card mb-4">
            <div class="row g-0">
                {{-- ── Left Content ── --}}
                <div class="col-lg-8">
                    <div class="p-4">

                        {{-- Bio --}}
                        @if($freelancer->bio)
                            <div class="mb-4">
                                <h5 class="fw-bold mb-3">
                                    <i class="fas fa-user me-2" style="color:#6366f1;"></i> About Me
                                </h5>
                                <p class="text-muted" style="line-height:1.7;">{{ $freelancer->bio }}</p>
                            </div>
                        @endif

                        {{-- Skills --}}
                        @if($freelancer->skills->count() > 0)
                            <div class="mb-4">
                                <h5 class="fw-bold mb-3">
                                    <i class="fas fa-tools me-2" style="color:#6366f1;"></i> Skills
                                </h5>
                                <div>
                                    @foreach($freelancer->skills as $skill)
                                        <span class="skill-badge">{{ $skill->skill_name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- ── Right Sidebar ── --}}
                <div class="col-lg-4" style="background:#fafbfc;border-left:1px solid #f1f5f9;">
                    <div class="p-4">
                        <h6 class="fw-bold mb-3">Quick Info</h6>

                        <div class="contact-item">
                            <div class="contact-icon" style="background:#eef2ff;color:#6366f1;">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Email</small>
                                <span class="fw-semibold" style="font-size:13px;">{{ $freelancer->email }}</span>
                            </div>
                        </div>

                        @if($freelancer->phone)
                            <div class="contact-item">
                                <div class="contact-icon" style="background:#f0fdf4;color:#16a34a;">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Phone</small>
                                    <span class="fw-semibold" style="font-size:13px;">{{ $freelancer->phone }}</span>
                                </div>
                            </div>
                        @endif

                        @if($freelancer->availability)
                            <div class="contact-item">
                                <div class="contact-icon" style="background:#fef3c7;color:#d97706;">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Availability</small>
                                    <span class="fw-semibold" style="font-size:13px;">{{ $freelancer->availability_label }}</span>
                                </div>
                            </div>
                        @endif

                        @if($freelancer->hourly_rate)
                            <div class="contact-item">
                                <div class="contact-icon" style="background:#f0fdf4;color:#16a34a;">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Hourly Rate</small>
                                    <span class="fw-semibold" style="font-size:13px;">₹{{ number_format($freelancer->hourly_rate) }}/hr</span>
                                </div>
                            </div>
                        @endif

                        <div class="contact-item">
                            <div class="contact-icon" style="background:#eef2ff;color:#6366f1;">
                                <i class="fas fa-calendar"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Member Since</small>
                                <span class="fw-semibold" style="font-size:13px;">{{ $freelancer->created_at->format('M Y') }}</span>
                            </div>
                        </div>

                        {{-- Resume Download --}}
                        @if($freelancer->resume)
                            <div class="mt-3">
                                <a href="{{ $freelancer->resume_url }}" target="_blank" class="btn btn-primary w-100">
                                    <i class="fas fa-download me-2"></i> Download Resume
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">

                {{-- ── Work Experience ── --}}
                @if($freelancer->workExperiences->count() > 0)
                    <div class="profile-section">
                        <div class="profile-section-header">
                            <h5 class="fw-bold mb-0">
                                <i class="fas fa-briefcase me-2" style="color:#6366f1;"></i>
                                Work Experience
                            </h5>
                        </div>
                        <div class="profile-section-body">
                            @foreach($freelancer->workExperiences as $exp)
                                <div class="timeline-item">
                                    <div class="timeline-card">
                                        <div class="d-flex justify-content-between align-items-start flex-wrap">
                                            <div>
                                                <h6 class="fw-bold mb-1">{{ $exp->position }}</h6>
                                                <p class="mb-1" style="color:#6366f1;font-weight:500;">
                                                    <i class="fas fa-building me-1"></i> {{ $exp->company_name }}
                                                </p>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge" style="background:#eef2ff;color:#4338ca;font-size:11px;padding:4px 10px;border-radius:10px;">
                                                    {{ $exp->employment_type_label }}
                                                </span>
                                            </div>
                                        </div>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-alt me-1"></i> {{ $exp->duration }}
                                        </small>
                                        @if($exp->description)
                                            <p class="mt-2 mb-0 text-muted" style="font-size:14px;line-height:1.6;">
                                                {{ $exp->description }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- ── Education ── --}}
                @if($freelancer->educations->count() > 0)
                    <div class="profile-section">
                        <div class="profile-section-header">
                            <h5 class="fw-bold mb-0">
                                <i class="fas fa-graduation-cap me-2" style="color:#6366f1;"></i>
                                Education
                            </h5>
                        </div>
                        <div class="profile-section-body">
                            @foreach($freelancer->educations as $edu)
                                <div class="timeline-item">
                                    <div class="timeline-card">
                                        <h6 class="fw-bold mb-1">{{ $edu->degree }}</h6>
                                        <p class="mb-1" style="color:#6366f1;font-weight:500;">
                                            <i class="fas fa-university me-1"></i> {{ $edu->institution }}
                                        </p>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-alt me-1"></i> {{ $edu->duration }}
                                            @if($edu->grade)
                                                <span class="ms-2">
                                                    <i class="fas fa-star me-1"></i> Grade: {{ $edu->grade }}
                                                </span>
                                            @endif
                                        </small>
                                        @if($edu->description)
                                            <p class="mt-2 mb-0 text-muted" style="font-size:14px;line-height:1.6;">
                                                {{ $edu->description }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-lg-4">

                {{-- ── Portfolio Links ── --}}
                @if($freelancer->portfolioLinks->count() > 0)
                    <div class="profile-section">
                        <div class="profile-section-header">
                            <h5 class="fw-bold mb-0">
                                <i class="fas fa-link me-2" style="color:#6366f1;"></i>
                                Portfolio
                            </h5>
                        </div>
                        <div class="profile-section-body">
                            @foreach($freelancer->portfolioLinks as $link)
                                <a href="{{ $link->url }}" target="_blank" class="portfolio-card">
                                    <div class="portfolio-icon">
                                        <i class="fas fa-{{ match(true) {
                                            str_contains(strtolower($link->title), 'github') => 'code-branch',
                                            str_contains(strtolower($link->title), 'linkedin') => 'user-tie',
                                            str_contains(strtolower($link->title), 'twitter') => 'hashtag',
                                            str_contains(strtolower($link->title), 'dribbble') => 'basketball-ball',
                                            str_contains(strtolower($link->title), 'behance') => 'paint-brush',
                                            str_contains(strtolower($link->title), 'website') => 'globe',
                                            str_contains(strtolower($link->title), 'youtube') => 'play-circle',
                                            default => 'external-link-alt',
                                        } }}"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold" style="font-size:14px;">{{ $link->title }}</div>
                                        <small class="text-muted">{{ Str::limit($link->url, 35) }}</small>
                                    </div>
                                    <i class="fas fa-arrow-right text-muted" style="font-size:12px;"></i>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- ── Stats Card ── --}}
                <div class="profile-section">
                    <div class="profile-section-header">
                        <h5 class="fw-bold mb-0">
                            <i class="fas fa-chart-bar me-2" style="color:#6366f1;"></i>
                            Profile Stats
                        </h5>
                    </div>
                    <div class="profile-section-body">
                        <div class="row g-3 text-center">
                            <div class="col-6">
                                <div class="p-3 rounded-3" style="background:#eef2ff;">
                                    <div class="fw-bold" style="font-size:24px;color:#6366f1;">
                                        {{ $freelancer->skills->count() }}
                                    </div>
                                    <small class="text-muted">Skills</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 rounded-3" style="background:#f0fdf4;">
                                    <div class="fw-bold" style="font-size:24px;color:#16a34a;">
                                        {{ $freelancer->workExperiences->count() }}
                                    </div>
                                    <small class="text-muted">Experiences</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 rounded-3" style="background:#fef3c7;">
                                    <div class="fw-bold" style="font-size:24px;color:#d97706;">
                                        {{ $freelancer->educations->count() }}
                                    </div>
                                    <small class="text-muted">Education</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 rounded-3" style="background:#fee2e2;">
                                    <div class="fw-bold" style="font-size:24px;color:#dc2626;">
                                        {{ $freelancer->portfolioLinks->count() }}
                                    </div>
                                    <small class="text-muted">Portfolio</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── Profile Completeness (visible to profile owner only) ── --}}
                @auth
                    @if(auth()->id() === $freelancer->id)
                        <div class="profile-section">
                            <div class="profile-section-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="fw-bold mb-0">Completeness</h6>
                                    <span class="fw-bold" style="color:{{ $freelancer->profile_completeness_color }};">
                                        {{ $freelancer->profile_completeness }}%
                                    </span>
                                </div>
                                <div style="height:8px;border-radius:4px;background:#f1f5f9;overflow:hidden;">
                                    <div style="width:{{ $freelancer->profile_completeness }}%;height:100%;background:{{ $freelancer->profile_completeness_color }};border-radius:4px;"></div>
                                </div>
                                <div class="mt-3 text-center">
                                    <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit me-1"></i> Improve Profile
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    {{-- ── Footer ── --}}
    <div class="profile-footer">
        <div class="container">
            <p class="mb-1">
                <strong>Hire<span style="color:#6366f1;">Form</span>India</strong>
            </p>
            <p class="mb-0">© {{ date('Y') }} All rights reserved.</p>
        </div>
    </div>

    {{-- ── Share Float Button ── --}}
    <button class="share-float-btn" onclick="shareProfile()" title="Share Profile">
        <i class="fas fa-share-alt"></i>
    </button>

    {{-- ── Toast for Copy Success ── --}}
    <div class="position-fixed bottom-0 start-50 translate-middle-x p-3" style="z-index: 1080;">
        <div id="shareToast" class="toast align-items-center text-white bg-success border-0" role="alert"
             style="border-radius:12px;">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-check-circle me-2"></i> Profile link copied to clipboard!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function shareProfile() {
            const url = '{{ route("freelancer.profile.public", $freelancer->id) }}';

            if (navigator.share) {
                // Native share (mobile)
                navigator.share({
                    title: '{{ $freelancer->name }} - Freelancer Profile',
                    text: 'Check out this freelancer profile on HireFormIndia',
                    url: url,
                }).catch(() => {
                    copyToClipboard(url);
                });
            } else {
                copyToClipboard(url);
            }
        }

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                const toast = new bootstrap.Toast(document.getElementById('shareToast'));
                toast.show();
            }).catch(() => {
                // Fallback
                const input = document.createElement('input');
                input.value = text;
                document.body.appendChild(input);
                input.select();
                document.execCommand('copy');
                document.body.removeChild(input);

                const toast = new bootstrap.Toast(document.getElementById('shareToast'));
                toast.show();
            });
        }
    </script>
</body>
</html>
