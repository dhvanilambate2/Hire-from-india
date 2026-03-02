<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>HireFormIndia — Find Remote Talent & Jobs</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root{
            --bg:#ffffff;
            --text:#1f2a37;
            --muted:#6b7280;
            --line:#e5e7eb;
            --brand:#0b5ea8;
            --brand-2:#0f766e;
            --accent:#2ea043;
            --btn:#0b5ea8;
            --btnText:#fff;
            --pillBg:#f3f4f6;
            --pillStroke:#e5e7eb;
            --highlight:#dff2d8;
            --shadow:0 8px 24px rgba(17, 24, 39, .08);
            --radius:12px;
            --max:1060px;
        }

        *{box-sizing:border-box}
        body{
            margin:0;
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji","Segoe UI Emoji";
            color:var(--text);
            background:var(--bg);
            line-height:1.45;
        }

        a{color:inherit; text-decoration:none}
        a:hover{opacity:.85}

        .container{
            width:min(var(--max), calc(100% - 40px));
            margin-inline:auto;
        }

        /* Top bar */
        .topbar{
            border-bottom:1px solid var(--line);
            background:#fff;
            position:sticky;
            top:0;
            z-index:20;
        }
        .topbar .inner{
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:14px 0;
            gap:16px;
        }

        .brand{
            display:flex;
            align-items:center;
            gap:10px;
            font-weight:700;
            letter-spacing:.2px;
        }
        .logoMark{
            width:34px; height:34px;
            border-radius:10px;
            background:linear-gradient(135deg, var(--brand), #143a66);
            display:grid;
            place-items:center;
            color:#fff;
            font-weight:800;
            box-shadow: var(--shadow);
            flex:0 0 auto;
        }
        .brand small{
            display:block;
            font-weight:600;
            color:var(--muted);
            letter-spacing:0;
            margin-top:2px;
            font-size:12px;
        }

        .nav{
            display:flex;
            gap:18px;
            align-items:center;
            color:#334155;
            font-weight:600;
            font-size:14px;
        }
        .nav a{
            color:#334155;
            padding:8px 6px;
            border-radius:8px;
        }
        .nav a:hover{background:#f8fafc}

        .actions{
            display:flex;
            align-items:center;
            gap:10px;
            font-weight:700;
            font-size:13px;
            white-space:nowrap;
        }
        .btn{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            padding:10px 14px;
            border-radius:999px;
            border:1px solid transparent;
            cursor:pointer;
            font-weight:800;
            letter-spacing:.3px;
            text-transform:uppercase;
            font-size:12px;
            gap: 6px;
        }
        .btn.primary{
            background:var(--btn);
            color:var(--btnText);
            box-shadow: 0 10px 18px rgba(11,94,168,.18);
        }
        .btn.ghost{
            background:#fff;
            color:var(--brand);
            border-color:#cfe2f7;
        }
        .btn.success{
            background:#16a34a;
            color:#fff;
            box-shadow: 0 10px 18px rgba(22,163,74,.18);
        }
        .btn.danger{
            background:#dc2626;
            color:#fff;
        }
        .link{
            color:#0f172a;
            font-weight:800;
            padding:10px 8px;
            border-radius:10px;
        }
        .link:hover{background:#f8fafc}

        /* User Menu */
        .user-menu{
            position: relative;
        }
        .user-avatar{
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .user-avatar.admin-avatar{
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: #fff;
        }
        .user-avatar.employer-avatar{
            background: linear-gradient(135deg, #0b5ea8, #1e40af);
            color: #fff;
        }
        .user-avatar.freelancer-avatar{
            background: linear-gradient(135deg, #16a34a, #15803d);
            color: #fff;
        }
        .user-dropdown{
            position: absolute;
            top: 46px;
            right: 0;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 14px;
            box-shadow: 0 12px 32px rgba(17,24,39,0.12);
            min-width: 240px;
            padding: 8px;
            display: none;
            z-index: 100;
        }
        .user-dropdown.active{
            display: block;
        }
        .user-dropdown-header{
            padding: 12px 14px;
            border-bottom: 1px solid #f1f5f9;
            margin-bottom: 4px;
        }
        .user-dropdown-header .name{
            font-weight: 700;
            font-size: 14px;
            color: #1e293b;
        }
        .user-dropdown-header .email{
            font-size: 12px;
            color: #64748b;
        }
        .user-dropdown-header .role-badge{
            display: inline-flex;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 4px;
        }
        .role-admin{
            background: #fee2e2;
            color: #dc2626;
        }
        .role-employer{
            background: #dbeafe;
            color: #2563eb;
        }
        .role-freelancer{
            background: #dcfce7;
            color: #16a34a;
        }
        .user-dropdown a{
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            transition: all 0.15s;
        }
        .user-dropdown a:hover{
            background: #f1f5f9;
        }
        .user-dropdown a i{
            width: 18px;
            text-align: center;
            font-size: 14px;
            color: #64748b;
        }
        .user-dropdown .divider{
            height: 1px;
            background: #f1f5f9;
            margin: 4px 0;
        }
        .user-dropdown .logout-btn{
            color: #dc2626;
        }
        .user-dropdown .logout-btn i{
            color: #dc2626;
        }

        /* Hero */
        .hero{
            padding:44px 0 22px;
        }
        .hero h1{
            text-align:center;
            font-size: clamp(28px, 3vw, 44px);
            margin:0 0 18px;
            letter-spacing:-.02em;
        }
        .hero h1 span{
            color: var(--brand);
        }
        .hero p{
            text-align:center;
            color:var(--muted);
            margin:0 auto 26px;
            max-width:740px;
            font-size:16px;
        }

        .searchRow{
            display:grid;
            grid-template-columns: 1fr 1fr;
            gap:22px;
            align-items:start;
            margin: 18px auto 8px;
        }
        .searchCard{
            padding:18px;
            border-radius:18px;
            border:1px solid var(--line);
            background:#fff;
            box-shadow: 0 10px 28px rgba(17,24,39,.05);
        }
        .searchCard .label{
            font-weight:800;
            font-size:14px;
            color:#0f172a;
            margin:0 0 10px;
        }
        .searchCard .label span{
            color:var(--brand);
            text-decoration:underline;
            text-underline-offset:3px;
        }

        .searchBar{
            display:flex;
            gap:10px;
            align-items:center;
        }
        .field{
            flex:1;
            height:44px;
            border:1px solid var(--line);
            border-radius:999px;
            padding:0 14px;
            color:#111827;
            outline:none;
            font-weight:600;
        }
        .field::placeholder{color:#9ca3af; font-weight:600}
        .searchBtn{
            height:44px;
            padding:0 18px;
            border-radius:999px;
            border:0;
            background:#0b3a6a;
            color:#fff;
            font-weight:900;
            letter-spacing:.12em;
            font-size:12px;
            text-transform:uppercase;
            cursor:pointer;
        }
        .searchBtn:hover{filter:brightness(1.03)}

        /* Section headings */
        .section{
            padding:30px 0;
        }
        .sectionTitle{
            text-align:center;
            font-size:24px;
            margin:0;
            font-weight:900;
            letter-spacing:-.01em;
        }
        .underline{
            width:38px;
            height:3px;
            background:var(--accent);
            border-radius:999px;
            margin:12px auto 22px;
        }

        /* Common searches */
        .skills{
            display:grid;
            grid-template-columns: repeat(4, minmax(0,1fr));
            gap:10px 22px;
            margin: 0 auto 18px;
            max-width:900px;
        }
        .skills a{
            color:#2563eb;
            font-weight:700;
            font-size:13px;
            padding:4px 0;
            display:inline-block;
        }
        .skills a:hover{color:#1d4ed8; text-decoration:underline}

        .center{
            text-align:center;
        }
        .outlineBtn{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            padding:11px 18px;
            border-radius:999px;
            border:1px solid #cfd8e3;
            background:#fff;
            font-weight:900;
            letter-spacing:.08em;
            text-transform:uppercase;
            font-size:12px;
            cursor:pointer;
            color:#0f172a;
        }
        .outlineBtn:hover{background:#f8fafc}

        /* Testimonials cloud */
        .cloud{
            max-width:980px;
            margin: 0 auto 10px;
            display:flex;
            flex-wrap:wrap;
            justify-content:center;
            gap:10px 12px;
        }
        .quote{
            border:1px solid var(--pillStroke);
            background:var(--pillBg);
            border-radius:10px;
            padding:10px 12px;
            font-weight:700;
            color:#111827;
            font-size:13px;
            box-shadow: 0 6px 18px rgba(17,24,39,.04);
        }
        .quote mark{
            background:var(--highlight);
            padding:0 4px;
            border-radius:4px;
        }

        /* Footer links */
        .miniLinks{
            max-width:220px;
            margin: 18px auto 0;
            display:grid;
            gap:8px;
            text-align:center;
            color:#2563eb;
            font-weight:700;
            font-size:12px;
        }
        .miniLinks a{color:#2563eb}
        .miniLinks a:hover{text-decoration:underline}

        footer{
            border-top:1px solid var(--line);
            margin-top:30px;
            padding:16px 0 30px;
            color:#6b7280;
            font-size:12px;
        }
        .footerNav{
            display:flex;
            gap:18px;
            flex-wrap:wrap;
            justify-content:center;
            margin-bottom:10px;
            font-weight:800;
            color:#334155;
        }
        .footerNav a{
            padding:8px 10px;
            border-radius:10px;
        }
        .footerNav a:hover{background:#f8fafc}

        .copyright{
            text-align:center;
        }

        /* Auth CTA Banner */
        .auth-cta{
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 0;
            margin-top: 10px;
        }
        .auth-cta h2{
            text-align: center;
            color: #fff;
            font-size: 28px;
            margin: 0 0 10px;
        }
        .auth-cta p{
            text-align: center;
            color: #e0e7ff;
            margin: 0 0 24px;
            font-size: 15px;
        }
        .auth-cta .cta-buttons{
            display: flex;
            justify-content: center;
            gap: 14px;
            flex-wrap: wrap;
        }
        .auth-cta .btn-cta{
            padding: 12px 28px;
            border-radius: 999px;
            font-weight: 800;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 2px solid transparent;
            cursor: pointer;
        }
        .btn-cta-primary{
            background: #fff;
            color: #4f46e5;
        }
        .btn-cta-outline{
            background: transparent;
            color: #fff;
            border-color: rgba(255,255,255,0.4) !important;
        }
        .btn-cta-outline:hover{
            background: rgba(255,255,255,0.1);
        }

        /* Responsive */
        @media (max-width: 900px){
            .nav{display:none}
            .searchRow{grid-template-columns:1fr}
            .skills{grid-template-columns: repeat(2, minmax(0,1fr)); max-width:520px}
        }
        @media (max-width: 520px){
            .actions .btn.ghost{display:none}
            .skills{grid-template-columns:1fr}
            .searchCard{padding:14px}
            .user-dropdown{
                right: -10px;
                min-width: 220px;
            }
        }
    </style>
</head>

<body>
    <!-- Top navigation -->
    <header class="topbar">
        <div class="container">
            <div class="inner">
                <a class="brand" href="{{ url('/') }}">
                    <div class="logoMark">HF</div>
                    <div>
                        Hire<span style="color:var(--brand-2); font-weight:900">Form</span>India
                        <small>Hire & find remote talent</small>
                    </div>
                </a>

                <nav class="nav" aria-label="Primary">
                    <a href="#">How it Works</a>
                    <a href="#">Pricing</a>
                    <a href="#">Real Results</a>
                </nav>

                <div class="actions">
                    {{-- ══════════════════════════════════════ --}}
                    {{-- AUTHENTICATED USER --}}
                    {{-- ══════════════════════════════════════ --}}
                    @auth
                        @php $authUser = auth()->user(); @endphp

                        {{-- Role-based Quick Action Button --}}
                        @if($authUser->isEmployer())
                            <a class="btn primary" href="{{ route('employer.jobs.create') }}">
                                <i class="fas fa-plus"></i> Post a Job
                            </a>
                        @elseif($authUser->isFreelancer())
                            <a class="btn success" href="{{ route('freelancer.jobs.index') }}">
                                <i class="fas fa-search"></i> Find Jobs
                            </a>
                        @endif

                        {{-- User Menu --}}
                        <div class="user-menu">
                            <div class="user-avatar {{ $authUser->isAdmin() ? 'admin-avatar' : ($authUser->isEmployer() ? 'employer-avatar' : 'freelancer-avatar') }}"
                                 onclick="toggleUserMenu()" id="userAvatarBtn">
                                {{ strtoupper(substr($authUser->name, 0, 1)) }}
                            </div>

                            <div class="user-dropdown" id="userDropdown">
                                {{-- User Info --}}
                                <div class="user-dropdown-header">
                                    <div class="name">{{ $authUser->name }}</div>
                                    <div class="email">{{ $authUser->email }}</div>
                                    <span class="role-badge role-{{ $authUser->role }}">
                                        {{ ucfirst($authUser->role) }}
                                    </span>
                                </div>

                                {{-- Dashboard Link (Role-based) --}}
                                @if($authUser->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-tachometer-alt"></i> Admin Dashboard
                                    </a>
                                    <a href="{{ route('admin.users.all') }}">
                                        <i class="fas fa-users"></i> Manage Users
                                    </a>
                                    <a href="{{ route('admin.jobs.index') }}">
                                        <i class="fas fa-briefcase"></i> Manage Jobs
                                    </a>
                                @elseif($authUser->isEmployer())
                                    <a href="{{ route('employer.dashboard') }}">
                                        <i class="fas fa-tachometer-alt"></i> Dashboard
                                    </a>
                                    <a href="{{ route('employer.jobs.index') }}">
                                        <i class="fas fa-briefcase"></i> My Jobs
                                    </a>
                                    <a href="{{ route('employer.jobs.create') }}">
                                        <i class="fas fa-plus-circle"></i> Post a Job
                                    </a>
                                    <a href="{{ route('employer.company.index') }}">
                                        <i class="fas fa-building"></i> Company Profile
                                    </a>
                                @elseif($authUser->isFreelancer())
                                    <a href="{{ route('freelancer.dashboard') }}">
                                        <i class="fas fa-tachometer-alt"></i> Dashboard
                                    </a>
                                    <a href="{{ route('freelancer.jobs.index') }}">
                                        <i class="fas fa-search"></i> Browse Jobs
                                    </a>
                                    <a href="{{ route('freelancer.applications.index') }}">
                                        <i class="fas fa-paper-plane"></i> My Applications
                                    </a>
                                    <a href="{{ route('freelancer.profile.share') }}">
                                        <i class="fas fa-share-alt"></i> Share Profile
                                    </a>
                                @endif

                                <div class="divider"></div>

                                {{-- Common Links --}}
                                <a href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user-edit"></i> Edit Profile
                                </a>

                                <div class="divider"></div>

                                {{-- Logout --}}
                                <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                                    @csrf
                                    <a href="#" class="logout-btn" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </a>
                                </form>
                            </div>
                        </div>

                    {{-- ══════════════════════════════════════ --}}
                    {{-- GUEST USER --}}
                    {{-- ══════════════════════════════════════ --}}
                    @else
                        <a class="btn primary" href="{{ route('register') }}">
                            <i class="fas fa-user-plus"></i> Sign Up
                        </a>
                        <a class="btn ghost" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt"></i> Log In
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Hero -->
    <main>
        <section class="hero">
            <div class="container">
                <h1>The Job Board for <span>Virtual Workers</span> in India.</h1>
                <p>
                    Connect with skilled remote professionals, post roles, and find work opportunities — all in one place.
                </p>

                <div class="searchRow" role="search">
                    <div class="searchCard">
                        <p class="label"><i class="fas fa-users" style="color:var(--brand);margin-right:6px;"></i> Looking for <span>Talent?</span></p>
                        <div class="searchBar">
                            <input class="field" type="search" placeholder="Search Resumes" aria-label="Search Resumes" />
                            <button class="searchBtn" type="button">SEARCH</button>
                        </div>
                    </div>

                    <div class="searchCard">
                        <p class="label"><i class="fas fa-briefcase" style="color:var(--brand);margin-right:6px;"></i> Looking for <span>Work?</span></p>
                        <div class="searchBar">
                            <input class="field" type="search" placeholder="Search Jobs" aria-label="Search Jobs" />
                            <button class="searchBtn" type="button">SEARCH</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Common Talent Searches -->
        <section class="section">
            <div class="container">
                <h2 class="sectionTitle">Common Talent Searches</h2>
                <div class="underline"></div>

                <div class="skills">
                    <a href="#">Virtual Assistant</a>
                    <a href="#">Amazon Expert</a>
                    <a href="#">Facebook Ads Manager</a>
                    <a href="#">Copywriter</a>

                    <a href="#">WordPress Developer</a>
                    <a href="#">Sales Representative</a>
                    <a href="#">Lead Generation</a>
                    <a href="#">QuickBooks</a>

                    <a href="#">SEO</a>
                    <a href="#">Marketing Specialist</a>
                    <a href="#">Email Marketer</a>
                    <a href="#">PPC</a>

                    <a href="#">Graphic Designer</a>
                    <a href="#">Shopify Developer</a>
                    <a href="#">eBay Virtual Assistant</a>
                    <a href="#">Ecommerce</a>

                    <a href="#">Social Media Marketer</a>
                    <a href="#">Video Editor</a>
                    <a href="#">Customer Service</a>
                    <a href="#">Researcher</a>

                    <a href="#">PHP Developer</a>
                    <a href="#">Data Entry</a>
                    <a href="#">Google Ads Manager</a>
                    <a href="#">Accountant</a>

                    <a href="#">Real Estate Virtual Assistant</a>
                    <a href="#">Web Developer</a>
                    <a href="#">Magento Developer</a>
                    <a href="#">iOS Developer</a>

                    <a href="#">Content Writer</a>
                    <a href="#">Project Manager</a>
                    <a href="#">Web Designer</a>
                    <a href="#">Photoshop</a>
                </div>

                <div class="center">
                    <button class="outlineBtn" type="button">See More Skills</button>
                </div>
            </div>
        </section>

        <!-- What Employers say -->
        <section class="section" style="padding-top:10px;">
            <div class="container">
                <h2 class="sectionTitle">What our Employers say</h2>
                <div class="underline"></div>

                <div class="cloud" aria-label="Employer testimonials">
                    <div class="quote">helped me to… <mark>free up my life.</mark></div>
                    <div class="quote">…<mark>changed my life trajectory.</mark></div>
                    <div class="quote">…caused me to <mark>increase sales.</mark></div>

                    <div class="quote">I'm now <mark>doing three times as much</mark> at a <mark>tenth of the time.</mark></div>
                    <div class="quote">I am <mark>accomplishing WAY more.</mark></div>
                    <div class="quote">My life is much more <mark>organized.</mark></div>

                    <div class="quote">I've already scaled <mark>content production</mark> by at least a double.</div>
                    <div class="quote">…grow my business from <mark>500k</mark> to nearly <mark>1.5M</mark> today</div>
                    <div class="quote">…really <mark>focus</mark> on strategy and business growth.</div>

                    <div class="quote">Made <mark>managing my business</mark> easier.</div>
                    <div class="quote">The process was <mark>smooth and easy.</mark></div>
                    <div class="quote">…and the work is <mark>done.</mark></div>

                    <div class="quote">…saved me <mark>10–15 hours</mark> of work <mark>PER WEEK.</mark></div>
                    <div class="quote"><mark>they free you up</mark> to actually run your business</div>
                    <div class="quote">When I'm asleep, <mark>they're working</mark></div>

                    <div class="quote">…<mark>crushing their work.</mark></div>
                    <div class="quote">…<mark>exceeded my expectations</mark> with their work ethic and quality</div>
                    <div class="quote">…they will <mark>go above and beyond.</mark></div>

                    <div class="quote">I could not live without him.</div>
                    <div class="quote">OFS is a complete rockstar.</div>
                    <div class="quote"><mark>Extremely dedicated</mark>, honest, and loyal</div>

                    <div class="quote">…already <mark>took some tasks off my plate.</mark></div>
                </div>

                <div class="center" style="margin-top:16px;">
                    <button class="outlineBtn" type="button">Show More Real Results</button>
                </div>

                <div class="miniLinks" aria-label="FAQ links">
                    <a href="#">Why?</a>
                    <a href="#">Cost</a>
                    <a href="#">Time</a>
                    <a href="#">Trust</a>
                    <a href="#">Legal</a>
                    <a href="#">Taxes</a>
                    <a href="#">Talent</a>
                    <a href="#">Security</a>
                    <a href="#">Payments</a>
                    <a href="#">Timezones</a>
                    <a href="#">Get Started</a>
                </div>
            </div>
        </section>

        {{-- ══════════════════════════════════════ --}}
        {{-- CTA BANNER (Guest Only) --}}
        {{-- ══════════════════════════════════════ --}}
        @guest
            <section class="auth-cta">
                <div class="container">
                    <h2>Ready to Get Started?</h2>
                    <p>Join thousands of employers and freelancers on HireFormIndia</p>
                    <div class="cta-buttons">
                        <a href="{{ route('register') }}" class="btn-cta btn-cta-primary">
                            <i class="fas fa-user-plus me-1"></i> Create Free Account
                        </a>
                        <a href="{{ route('login') }}" class="btn-cta btn-cta-outline">
                            <i class="fas fa-sign-in-alt me-1"></i> Already have an account? Login
                        </a>
                    </div>
                </div>
            </section>
        @endguest
    </main>

    <footer>
        <div class="container">
            <div class="footerNav" aria-label="Footer navigation">
                <a href="#">Employers</a>
                <a href="#">Workers</a>
                <a href="#">Talented VA's</a>
                <a href="#">Other Goods</a>
                <a href="#">Contact Us</a>
                <a href="#">Connect With Us</a>
            </div>
            <div class="copyright">
                © <span id="year"></span> HireFormIndia. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        // Year
        document.getElementById("year").textContent = new Date().getFullYear();

        // User dropdown toggle
        function toggleUserMenu() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('active');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('userDropdown');
            const avatar = document.getElementById('userAvatarBtn');

            if (dropdown && avatar) {
                if (!dropdown.contains(e.target) && !avatar.contains(e.target)) {
                    dropdown.classList.remove('active');
                }
            }
        });

        // Close dropdown on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const dropdown = document.getElementById('userDropdown');
                if (dropdown) dropdown.classList.remove('active');
            }
        });
    </script>
</body>
</html>
