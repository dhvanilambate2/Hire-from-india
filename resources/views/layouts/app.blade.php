{{-- resources/views/layouts/app.blade.php --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Freelancer Platform')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --sidebar-width: 260px;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f1f5f9;
        }

        /* ---- AUTH PAGES ---- */
        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .auth-card {
            background: #fff;
            border-radius: 16px;
            padding: 40px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .auth-card h2 {
            font-weight: 700;
            color: #1e293b;
        }

        .auth-card .form-control {
            border-radius: 10px;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            transition: border-color 0.2s;
        }

        .auth-card .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .auth-card .btn-primary {
            background: var(--primary);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            font-size: 16px;
        }

        .auth-card .btn-primary:hover {
            background: var(--primary-dark);
        }

        .role-selector .form-check {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px 16px 16px 45px;
            margin-bottom: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .role-selector .form-check:hover {
            border-color: var(--primary);
        }

        .role-selector .form-check-input:checked ~ .form-check-label {
            color: var(--primary);
        }

        .role-selector .form-check:has(.form-check-input:checked) {
            border-color: var(--primary);
            background: #eef2ff;
        }

        /* ---- SIDEBAR ---- */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            color: #fff;
            z-index: 1000;
            overflow-y: auto;
            transition: transform 0.3s;
        }

        .sidebar-brand {
            padding: 24px 20px;
            font-size: 20px;
            font-weight: 800;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-brand i {
            color: #818cf8;
        }

        .sidebar-menu {
            list-style: none;
            padding: 16px 12px;
            margin: 0;
        }

        .sidebar-menu .menu-header {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #64748b;
            padding: 16px 16px 8px;
            font-weight: 600;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 11px 16px;
            color: #cbd5e1;
            text-decoration: none;
            border-radius: 10px;
            margin-bottom: 2px;
            transition: all 0.2s;
            font-size: 14px;
        }

        .sidebar-menu a:hover {
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
        }

        .sidebar-menu a.active {
            background: var(--primary);
            color: #fff;
            font-weight: 600;
        }

        .sidebar-menu a i {
            width: 20px;
            margin-right: 12px;
            text-align: center;
        }

        /* ---- MAIN CONTENT ---- */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        .top-navbar {
            background: #fff;
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .top-navbar .user-dropdown .btn {
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 8px 16px;
            font-weight: 500;
        }

        .content-area {
            padding: 32px;
        }

        /* ---- STAT CARDS ---- */
        .stat-card {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #f1f5f9;
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
        }

        .stat-card .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .stat-card .stat-number {
            font-size: 28px;
            font-weight: 800;
            color: #1e293b;
        }

        .stat-card .stat-label {
            color: #64748b;
            font-size: 13px;
            font-weight: 500;
        }

        /* ---- TABLE ---- */
        .data-table {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #f1f5f9;
            overflow: hidden;
        }

        .data-table .table {
            margin: 0;
        }

        .data-table .table th {
            background: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
            padding: 14px 20px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            font-weight: 700;
        }

        .data-table .table td {
            padding: 14px 20px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
        }

        .badge-role {
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-freelancer { background: #dbeafe; color: #1d4ed8; }
        .badge-employer   { background: #fef3c7; color: #b45309; }
        .badge-admin      { background: #ede9fe; color: #7c3aed; }

        .badge-active   { background: #dcfce7; color: #16a34a; }
        .badge-inactive { background: #fee2e2; color: #dc2626; }

        .badge-verified   { background: #dcfce7; color: #16a34a; }
        .badge-unverified { background: #fee2e2; color: #dc2626; }

        /* ---- RESPONSIVE ---- */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>
    @yield('body')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>