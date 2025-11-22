<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/bn666.png') }}">
    <title>@yield('title', 'Dashboard') - SMK Bakti Nusantara 666</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #4169e1;
            --primary-dark: #2952cc;
            --sidebar-bg: #ffffff;
            --sidebar-width: 240px;
            --topbar-height: 70px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #2d3748;
        }

        /* ================ SIDEBAR ================ */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
            overflow-y: auto;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 2px;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar-header {
            padding: 24px 20px;
            text-align: center;
            border-bottom: 1px solid #f1f5f9;
        }

        .sidebar-logo {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            position: relative;
        }

        .sidebar-logo::after {
            content: 'pro';
            position: absolute;
            top: -4px;
            right: -8px;
            background: #f6ad55;
            color: white;
            font-size: 9px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 4px;
            text-transform: uppercase;
        }

        .sidebar-logo img {
            width: 30px;
            height: 30px;
            object-fit: cover;
        }

        .sidebar-brand {
            font-size: 20px;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 4px;
        }

        .sidebar-role {
            font-size: 12px;
            color: #718096;
            font-weight: 500;
        }

        .sidebar.collapsed .sidebar-brand,
        .sidebar.collapsed .sidebar-role {
            display: none;
        }

        /* User Profile in Sidebar */
        .sidebar-user {
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid #f1f5f9;
            margin-bottom: 8px;
        }

        .sidebar-user-avatar {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 16px;
            flex-shrink: 0;
        }

        .sidebar-user-info {
            flex: 1;
            min-width: 0;
        }

        .sidebar-user-name {
            font-size: 14px;
            font-weight: 600;
            color: #2d3748;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-user-role {
            font-size: 12px;
            color: #718096;
        }

        .sidebar.collapsed .sidebar-user-info {
            display: none;
        }

        /* NAVIGATION */
        .nav-section {
            padding: 8px 0;
        }

        .nav-label {
            padding: 16px 20px 8px;
            font-size: 11px;
            font-weight: 700;
            color: #a0aec0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .nav-toggle {
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
            padding: 12px 20px;
            margin: 0 12px 4px;
            border-radius: 8px;
        }

        .nav-toggle:hover {
            background: #f7fafc;
            color: var(--primary);
        }

        .nav-arrow {
            font-size: 10px;
            transition: transform 0.2s ease;
        }

        .nav-arrow.rotated {
            transform: rotate(90deg);
        }

        .nav-submenu {
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .nav-submenu .nav-item {
            margin-left: 20px;
        }

        .sidebar.collapsed .nav-label {
            display: none;
        }

        .sidebar.collapsed .nav-submenu {
            display: none !important;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #4a5568;
            text-decoration: none;
            transition: all 0.2s ease;
            margin: 0 12px 4px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            position: relative;
        }

        .nav-item:hover {
            background: #f7fafc;
            color: var(--primary);
        }

        .nav-item.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .nav-item.active:hover {
            color: white;
        }

        .nav-item i {
            width: 20px;
            font-size: 18px;
            margin-right: 12px;
        }

        .sidebar.collapsed .nav-item {
            justify-content: center;
            padding: 12px;
        }

        .sidebar.collapsed .nav-item span {
            display: none;
        }

        .sidebar.collapsed .nav-item i {
            margin-right: 0;
        }

        .sidebar.collapsed .nav-toggle {
            justify-content: center;
            padding: 12px;
        }

        .sidebar.collapsed .nav-toggle span {
            display: none;
        }

        .sidebar.collapsed .nav-arrow {
            display: none;
        }

        /* ================ TOPBAR ================ */
        .topbar {
            position: fixed;
            left: var(--sidebar-width);
            top: 0;
            right: 0;
            height: var(--topbar-height);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            transition: all 0.3s ease;
            z-index: 999;
        }

        .sidebar.collapsed ~ .main-content .topbar {
            left: 80px;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .topbar-toggle {
            width: 40px;
            height: 40px;
            border: none;
            background: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #4a5568;
            transition: all 0.2s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .topbar-toggle:hover {
            background: #f7fafc;
            color: var(--primary);
        }

        .topbar-search {
            position: relative;
        }

        .topbar-search input {
            width: 320px;
            height: 40px;
            padding: 0 16px 0 42px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s ease;
            background: white;
        }

        .topbar-search input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .topbar-search i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            font-size: 14px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topbar-icon {
            width: 40px;
            height: 40px;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #4a5568;
            transition: all 0.2s ease;
            position: relative;
        }

        .topbar-icon:hover {
            background: #f7fafc;
            border-color: var(--primary);
            color: var(--primary);
        }

        .topbar-icon .badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: #f56565;
            color: white;
            font-size: 10px;
            font-weight: 700;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid white;
        }

        .topbar-user {
            position: relative;
        }

        .topbar-user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 12px 6px 6px;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .topbar-user-info:hover {
            border-color: var(--primary);
        }

        .topbar-user-info i {
            font-size: 10px;
            color: #a0aec0;
        }

        .dropdown-menu {
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
            padding: 8px 0;
            min-width: 180px;
        }

        .dropdown-item {
            padding: 8px 16px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 8px;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }

        .dropdown-item:hover {
            background: #f7fafc;
        }

        .dropdown-item i {
            width: 16px;
            font-size: 12px;
        }

        .topbar-user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 13px;
        }

        .topbar-user-name {
            font-size: 13px;
            font-weight: 600;
            color: #2d3748;
        }

        /* ================ MAIN CONTENT ================ */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--topbar-height);
            padding: 32px;
            transition: all 0.3s ease;
            min-height: calc(100vh - var(--topbar-height));
        }

        .sidebar.collapsed ~ .main-content {
            margin-left: 80px;
        }

        /* Page Header */
        .page-header {
            margin-bottom: 28px;
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: white;
            margin-bottom: 4px;
        }

        .page-breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.8);
        }

        .page-breadcrumb a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
        }

        .page-breadcrumb a:hover {
            color: white;
        }

        /* ================ SIDEBAR OVERLAY ================ */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1040;
            display: none;
            cursor: pointer;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }

        /* ================ RESPONSIVE ================ */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                z-index: 1050;
                transition: transform 0.3s ease;
            }

            .sidebar.active {
                transform: translateX(0) !important;
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            .topbar {
                left: 0;
                padding: 0 20px;
            }

            .topbar-search {
                display: none;
            }

            .topbar-user-name {
                display: none;
            }

            .topbar-toggle {
                display: flex !important;
                z-index: 1051;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <img src="{{ asset('assets/img/bn666.png') }}" alt="Logo">
            </div>
            <div class="sidebar-brand">SIPPS 666</div>
            <div class="sidebar-role">
                @php
                    $waliKelasCheck = \App\Models\WaliKelas::where('guru_id', auth()->user()->id)
                        ->whereNull('tanggal_selesai')
                        ->exists();
                @endphp
                @if($waliKelasCheck)
                    Guru & Wali Kelas
                @else
                    {{ ucfirst(str_replace('_', ' ', auth()->user()->level)) }}
                @endif
            </div>
        </div>

        <div class="sidebar-user">
            <div class="sidebar-user-avatar">
                {{ substr(auth()->user()->nama_lengkap, 0, 1) }}
            </div>
            <div class="sidebar-user-info">
                <div class="sidebar-user-name">{{ auth()->user()->nama_lengkap }}</div>
                <div class="sidebar-user-role">
                    @php
                        $waliKelasCheck = \App\Models\WaliKelas::where('guru_id', auth()->user()->id)
                            ->whereNull('tanggal_selesai')
                            ->exists();
                    @endphp
                    @if($waliKelasCheck)
                        Guru & Wali Kelas
                    @else
                        {{ ucfirst(str_replace('_', ' ', auth()->user()->level)) }}
                    @endif
                </div>
            </div>
        </div>

        <nav class="nav-section">
            <div class="nav-label">Navigation</div>
            <a href="{{ route('wali-kelas.dashboard') }}" class="nav-item {{ Request::is('wali-kelas/dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>

                 <a href="{{ route('wali-kelas.data-siswa.index') }}" class="nav-item {{ Request::is('wali-kelas/data-siswa*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Data Siswa</span>
                </a>
                 <a href="{{ route('wali-kelas.pelanggaran.index') }}" class="nav-item {{ request()->routeIs('wali-kelas.pelanggaran.*') ? 'active' : '' }}">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>Input Pelanggaran</span>
                </a>
                 <a href="{{ route('wali-kelas.laporan.index') }}" class="nav-item {{ request()->routeIs('wali-kelas.laporan.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i>
                    <span>Laporan</span>
                </a>
        </nav>

    </aside>

    <!-- Mobile Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeMobileSidebar()"></div>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        <!-- TOPBAR -->
        <div class="topbar">
            <div class="topbar-left">
                <button class="topbar-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                
                <div class="topbar-search">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search...">
                </div>
            </div>

            <div class="topbar-right">

                <div class="topbar-user dropdown">
                    <div class="topbar-user-info" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="topbar-user-avatar">
                            {{ substr(auth()->user()->nama_lengkap, 0, 1) }}
                        </div>
                        <span class="topbar-user-name">{{ auth()->user()->nama_lengkap }}</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('wali-kelas.data-diri.index') }}"><i class="fas fa-user"></i> Profil Saya</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- PAGE HEADER -->
        <div class="page-header">
            <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
            <div class="page-breadcrumb">
                <i class="fas fa-home"></i>
                <span>/</span>
                <a href="#">Dashboard</a>
                <span>/</span>
                <span>@yield('page-title', 'Dashboard')</span>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="content">
            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('active');
                if (overlay) {
                    if (sidebar.classList.contains('active')) {
                        overlay.classList.add('active');
                        overlay.style.display = 'block';
                    } else {
                        overlay.classList.remove('active');
                        setTimeout(() => {
                            overlay.style.display = 'none';
                        }, 300);
                    }
                }
            } else {
                sidebar.classList.toggle('collapsed');
                localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
            }
        }

        function closeMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.remove('active');
            if (overlay) {
                overlay.classList.remove('active');
                setTimeout(() => {
                    overlay.style.display = 'none';
                }, 300);
            }
        }

        function toggleNavSection(sectionId) {
            const section = document.getElementById(sectionId);
            const arrow = document.getElementById(sectionId + '-arrow');
            
            if (section.style.display === 'none' || section.style.display === '') {
                section.style.display = 'block';
                arrow.classList.add('rotated');
                localStorage.setItem('nav-' + sectionId, 'open');
            } else {
                section.style.display = 'none';
                arrow.classList.remove('rotated');
                localStorage.setItem('nav-' + sectionId, 'closed');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isCollapsed) {
                document.getElementById('sidebar').classList.add('collapsed');
            }


        });

        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            if (window.innerWidth > 768) {
                sidebar.classList.remove('active');
                if (overlay) {
                    overlay.classList.remove('active');
                    overlay.style.display = 'none';
                }
            }
        });

        document.addEventListener('click', function(e) {
            if (window.innerWidth <= 768 && e.target.closest('.nav-item')) {
                closeMobileSidebar();
            }
        });
    </script>
    @stack('scripts')
</body>
</html>