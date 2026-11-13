<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Antrian Kendaraan')</title>
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --app-bg: #eaf3fe;
            --app-bg-gradient: linear-gradient(180deg, #dbeafe 0%, #eff6ff 45%, #f8fafc 100%);
            --primary-blue: #2563eb;
            --primary-gradient: linear-gradient(135deg, #38bdf8 0%, #2563eb 100%);
            --primary-hover: #1d4ed8;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --surface-card: #ffffff;
            --card-border: rgba(191, 219, 254, 0.6);
            --card-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.08), 0 8px 10px -6px rgba(59, 130, 246, 0.04);
            --sidebar-width: 260px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--app-bg-gradient);
            background-attachment: fixed;
            color: var(--text-main);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        a, button, input[type="button"], input[type="submit"], select, .btn, label[for] {
            cursor: pointer;
        }

        :focus-visible {
            outline: 2px solid var(--primary-blue);
            outline-offset: 2px;
        }

        .btn {
            font-weight: 600;
            border-radius: 12px;
            padding: 0.55rem 1.15rem;
            min-height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        }

        .btn-primary:hover, .btn-primary:focus {
            background: linear-gradient(135deg, #0284c7 0%, #1d4ed8 100%);
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(37, 99, 235, 0.35);
        }

        .btn-outline-primary {
            border: 1.5px solid #bfdbfe;
            color: var(--primary-blue);
            background: #ffffff;
        }

        .btn-outline-primary:hover {
            background: #eff6ff;
            color: var(--primary-hover);
            border-color: #93c5fd;
        }

        .btn-sm {
            min-height: 36px;
            padding: 0.35rem 0.8rem;
            border-radius: 10px;
            font-size: 0.875rem;
        }

        /* Sidebar Styling */
        .sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: #ffffff;
            border-right: 1px solid var(--card-border);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1040;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 2px 0 16px rgba(59, 130, 246, 0.04);
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            padding: 1.5rem 1.4rem;
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            display: flex;
            align-items: center;
            gap: 0.85rem;
        }

        .brand-icon-box {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            background: var(--primary-gradient);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            box-shadow: 0 6px 14px rgba(37, 99, 235, 0.28);
            flex-shrink: 0;
        }

        .brand-title {
            line-height: 1.2;
        }

        .brand-title h5 {
            font-weight: 800;
            font-size: 1.05rem;
            margin: 0;
            color: var(--text-main);
            letter-spacing: -0.02em;
        }

        .brand-title span {
            font-size: 0.75rem;
            color: var(--primary-blue);
            font-weight: 600;
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }

        .sidebar-nav {
            padding: 1.25rem 0.9rem;
            list-style: none;
            flex-grow: 1;
        }

        .sidebar-nav .nav-item {
            margin-bottom: 0.35rem;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 0.75rem 1rem;
            color: #475569;
            text-decoration: none;
            font-size: 0.92rem;
            font-weight: 500;
            border-radius: 12px;
            transition: all 0.2s ease;
        }

        .sidebar-nav .nav-link:hover {
            color: var(--primary-blue);
            background: #f0f7ff;
        }

        .sidebar-nav .nav-link.active {
            color: #1d4ed8;
            background: #e0f2fe;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.08);
        }

        .sidebar-nav .nav-link i {
            width: 22px;
            text-align: center;
            font-size: 1.05rem;
            color: inherit;
        }

        .sidebar-nav .nav-link.active i {
            color: var(--primary-blue);
        }

        .logout-wrapper {
            margin-top: auto;
            padding: 1rem 0.9rem 1.5rem;
            border-top: 1px solid rgba(226, 232, 240, 0.8);
        }

        .btn-logout {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 0.75rem 1rem;
            color: #dc2626;
            background: #fff5f5;
            border: 1px solid #fee2e2;
            border-radius: 12px;
            font-size: 0.92rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-logout:hover {
            background: #fee2e2;
            color: #b91c1c;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .top-navbar {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--card-border);
            padding: 0.85rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        .user-pill {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 0.4rem 0.9rem;
            border-radius: 999px;
            font-size: 0.88rem;
        }

        .user-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--primary-gradient);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.8rem;
        }

        .btn-sidebar-toggle {
            display: none;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font-size: 1.1rem;
            color: #334155;
            cursor: pointer;
            width: 40px;
            height: 40px;
            align-items: center;
            justify-content: center;
        }

        .content-wrapper {
            padding: 2rem;
            max-width: 1400px;
        }

        /* Card Styles */
        .card {
            background: var(--surface-card);
            border: 1px solid var(--card-border);
            border-radius: 18px;
            box-shadow: var(--card-shadow);
            transition: box-shadow 0.2s ease, transform 0.2s ease;
        }

        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .hover-lift:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 30px -5px rgba(59, 130, 246, 0.16) !important;
        }

        .card-header {
            background: #ffffff;
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            border-top-left-radius: 18px !important;
            border-top-right-radius: 18px !important;
            padding: 1.15rem 1.5rem;
        }

        .form-control, .form-select {
            border: 1.5px solid #cbd5e1;
            border-radius: 12px;
            padding: 0.65rem 1rem;
            font-size: 0.93rem;
            color: var(--text-main);
            background-color: #ffffff;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
            outline: none;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.88rem;
            color: #334155;
            margin-bottom: 0.45rem;
        }

        /* Table Styles */
        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: #f8fafc;
            color: #475569;
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            padding: 0.95rem 1.25rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .table tbody td {
            padding: 1rem 1.25rem;
            color: #1e293b;
            font-size: 0.92rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .table-hover tbody tr:hover {
            background-color: #f0f7ff;
        }

        /* Status Badges */
        .badge-status {
            font-weight: 600;
            font-size: 0.82rem;
            padding: 0.35rem 0.75rem;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .badge-menunggu {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        .badge-diproses {
            background: #e0f2fe;
            color: #0369a1;
            border: 1px solid rgba(14, 165, 233, 0.3);
        }

        .badge-selesai {
            background: #dcfce7;
            color: #166534;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }

        .badge-dibatalkan {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(4px);
            z-index: 1035;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .btn-sidebar-toggle {
                display: flex;
            }

            .sidebar-overlay.active {
                display: block;
            }

            .content-wrapper {
                padding: 1.25rem;
            }

            .top-navbar {
                padding: 0.75rem 1.25rem;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <nav class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon-box">
                <i class="fas fa-truck-moving"></i>
            </div>
            <div class="brand-title">
                <h5>Antrian Kendaraan</h5>
                <span>Sistem Digital</span>
            </div>
        </div>
        <ul class="sidebar-nav">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('kendaraan.index') }}" class="nav-link {{ request()->routeIs('kendaraan.*') ? 'active' : '' }}">
                    <i class="fas fa-car"></i>
                    <span>Data Kendaraan</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('antrian.index') }}" class="nav-link {{ request()->routeIs('antrian.*') ? 'active' : '' }}">
                    <i class="fas fa-list-ol"></i>
                    <span>Data Antrian</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                    <i class="fas fa-file-pdf"></i>
                    <span>Laporan</span>
                </a>
            </li>
        </ul>

        <div class="logout-wrapper">
            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Keluar (Logout)</span>
                </button>
            </form>
        </div>
    </nav>

    <div class="main-content">
        <div class="top-navbar">
            <button class="btn-sidebar-toggle" id="sidebarToggle" aria-label="Buka navigasi">
                <i class="fas fa-bars"></i>
            </button>
            <div class="user-pill">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    Halo, <strong>{{ Auth::user()->name }}</strong>
                </div>
            </div>
        </div>

        <div class="content-wrapper">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert" style="background:#dcfce7; color:#166534; border-radius:14px;">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert" style="background:#fee2e2; color:#991b1b; border-radius:14px;">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggle = document.getElementById('sidebarToggle');

        toggle.addEventListener('click', function () {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        });

        overlay.addEventListener('click', function () {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });

        document.querySelectorAll('.alert-dismissible').forEach(function (alert) {
            setTimeout(function () {
                var bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                bsAlert.close();
            }, 4000);
        });
    </script>
    @stack('scripts')
</body>
</html>

