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
        
        .sidebar.collapsed {
            width: 80px;
        }
        
        .sidebar.collapsed .sidebar-brand,
        .sidebar.collapsed .sidebar-role,
        .sidebar.collapsed .sidebar-user-info,
        .sidebar.collapsed .nav-label,
        .sidebar.collapsed .nav-item span {
            display: none;
        }
        
        .sidebar.collapsed .nav-item {
            justify-content: center;
            padding: 12px;
        }
        
        .sidebar.collapsed .nav-item i {
            margin-right: 0;
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

            .topbar-user-name {
                display: none;
            }

            .topbar-toggle {
                display: flex !important;
                z-index: 1051;
            }

            .page-title {
                font-size: 24px;
            }
        }

        @media (max-width: 480px) {
            .main-content {
                padding: 16px;
            }

            .page-title {
                font-size: 20px;
            }
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

        .nav-item i {
            width: 20px;
            font-size: 18px;
            margin-right: 12px;
        }

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
        
        .sidebar.collapsed ~ .main-content {
            margin-left: 80px;
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
        
        .topbar-search i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            font-size: 14px;
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

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
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
        
        /* Stats cards responsive */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }
        
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

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

        /* ================ RESPONSIVE ================ */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                z-index: 1001;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            .topbar {
                left: 0;
                padding: 0 20px;
            }

            .topbar-user-name {
                display: none;
            }
            
            .topbar-search {
                display: none;
            }

            .page-title {
                font-size: 24px;
            }

            .page-breadcrumb {
                font-size: 12px;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }
        }

        @media (max-width: 480px) {
            .main-content {
                padding: 16px;
            }

            .page-title {
                font-size: 20px;
            }
            
            .topbar {
                padding: 0 16px;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <img src="{{ asset('assets/img/bn666.png') }}" alt="Logo">
            </div>
            <div class="sidebar-brand">SIPPS 666</div>
            <div class="sidebar-role">Bimbingan Konseling</div>
        </div>

        <div class="sidebar-user">
            <div class="sidebar-user-avatar">
                {{ substr(auth()->user()->nama_lengkap, 0, 1) }}
            </div>
            <div class="sidebar-user-info">
                <div class="sidebar-user-name">{{ auth()->user()->nama_lengkap }}</div>
                <div class="sidebar-user-role">BK</div>
            </div>
        </div>

        <nav class="nav-section">
            <div class="nav-label">Navigation</div>
            <a href="{{ route('bk.dashboard') }}" class="nav-item {{ Request::is('bk/dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
        </nav>

        <nav class="nav-section">
            <div class="nav-label">Konseling</div>
            <a href="{{ route('bk.siswa-perlu-konseling.index') }}" class="nav-item {{ Request::is('bk/siswa-perlu-konseling*') ? 'active' : '' }}">
                <i class="fas fa-user-clock"></i>
                <span>Siswa Perlu Konseling</span>
            </a>
            <a href="{{ route('bk.konseling.index') }}" class="nav-item {{ Request::is('bk/konseling*') ? 'active' : '' }}">
                <i class="fas fa-comments"></i>
                <span>Input Konseling</span>
            </a>
        </nav>

        <nav class="nav-section">
            <div class="nav-label">Laporan</div>
            <a href="{{ route('bk.laporan.index') }}" class="nav-item {{ Request::is('bk/laporan*') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i>
                <span>Laporan Konseling</span>
            </a>
        </nav>
    </aside>

    <!-- Mobile Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeMobileSidebar()" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 999;"></div>

    <main class="main-content">
        <div class="topbar">
            <div class="topbar-left">
                <button class="topbar-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                
                <div class="topbar-search">
                    <i class="fas fa-search"></i>
                    <input type="text" id="globalSearch" placeholder="Search menu..." onkeyup="performSearch()">
                    <div id="searchResults" class="search-results" style="display: none;"></div>
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
                        <li><a class="dropdown-item" href="{{ route('bk.data-diri.index') }}"><i class="fas fa-user"></i> Profil Saya</a></li>
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

        <div class="content">
            @yield('content')
        </div>
    </main>

    <!-- Notification Alert -->
    @if(session('notification'))
    <div id="notificationAlert" class="notification-alert notification-{{ session('notification.type') }}">
        <div class="notification-content">
            <strong>{{ session('notification.title') }}</strong>
            <p>{{ session('notification.message') }}</p>
        </div>
        <button onclick="closeNotification()" class="notification-close">&times;</button>
    </div>
    @endif

    <style>
    .notification-alert {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        padding: 15px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        max-width: 400px;
        animation: slideIn 0.3s ease;
    }
    .notification-success { background: #d4edda; border-left: 4px solid #28a745; color: #155724; }
    .notification-info { background: #d1ecf1; border-left: 4px solid #17a2b8; color: #0c5460; }
    .notification-warning { background: #fff3cd; border-left: 4px solid #ffc107; color: #856404; }
    .notification-close {
        position: absolute;
        top: 10px;
        right: 15px;
        background: none;
        border: none;
        font-size: 20px;
        cursor: pointer;
    }
    .search-results {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 1px solid #ddd;
        border-radius: 8px;
        max-height: 300px;
        overflow-y: auto;
        z-index: 1000;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .search-item {
        padding: 10px 15px;
        border-bottom: 1px solid #eee;
        cursor: pointer;
    }
    .search-item:hover { background: #f8f9fa; }
    .notification-dropdown {
        position: absolute;
        top: 100%;
        right: 0;
        width: 300px;
        background: white;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        z-index: 1000;
    }
    .notification-header {
        padding: 15px;
        border-bottom: 1px solid #eee;
        font-weight: 600;
    }
    .notification-list {
        max-height: 300px;
        overflow-y: auto;
    }
    .notification-empty {
        padding: 20px;
        text-align: center;
        color: #666;
    }
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    
    <script>
        let notifications = [];
        
        function addNotification(type, title, message) {
            const notification = {
                id: Date.now(),
                type: type,
                title: title,
                message: message,
                time: new Date().toLocaleTimeString()
            };
            notifications.unshift(notification);
            updateNotificationBadge();
            updateNotificationList();
        }
        
        function updateNotificationBadge() {
            document.getElementById('notificationCount').textContent = notifications.length;
        }
        
        function updateNotificationList() {
            const list = document.getElementById('notificationList');
            if (notifications.length === 0) {
                list.innerHTML = '<div class="notification-empty">Tidak ada notifikasi</div>';
            } else {
                list.innerHTML = notifications.map(notif => `
                    <div class="notification-item" style="padding: 15px; border-bottom: 1px solid #eee;">
                        <strong>${notif.title}</strong>
                        <p style="margin: 5px 0; font-size: 14px;">${notif.message}</p>
                        <small style="color: #666;">${notif.time}</small>
                    </div>
                `).join('');
            }
        }
        
        function toggleNotifications() {
            const dropdown = document.getElementById('notificationDropdown');
            dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
        }
        
        function closeNotification() {
            document.getElementById('notificationAlert').style.display = 'none';
        }
        
        @if(session('notification'))
        setTimeout(() => {
            const alert = document.getElementById('notificationAlert');
            if (alert) alert.style.display = 'none';
        }, 5000);
        
        addNotification('{{ session('notification.type') }}', '{{ session('notification.title') }}', '{{ session('notification.message') }}');
        @endif
   
        function performSearch() {
            const query = document.getElementById('globalSearch').value;
            const results = document.getElementById('searchResults');
            
            if (query.length < 2) {
                results.style.display = 'none';
                return;
            }
            
            const menuItems = [
                { name: 'Dashboard', url: '{{ route("bk.dashboard") }}', icon: 'fas fa-home' },
                { name: 'Siswa Perlu Konseling', url: '{{ route("bk.siswa-perlu-konseling.index") }}', icon: 'fas fa-user-clock' },
                { name: 'Input Konseling', url: '{{ route("bk.konseling.index") }}', icon: 'fas fa-comments' },
                { name: 'Laporan Konseling', url: '{{ route("bk.laporan.index") }}', icon: 'fas fa-file-alt' },
                { name: 'Data Diri', url: '{{ route("bk.data-diri.index") }}', icon: 'fas fa-user' }
            ].filter(item => 
                item.name.toLowerCase().includes(query.toLowerCase())
            );
            
            if (menuItems.length > 0) {
                results.innerHTML = menuItems.map(item => `
                    <div class="search-item" onclick="window.location.href='${item.url}'">
                        <i class="${item.icon}"></i> ${item.name}
                    </div>
                `).join('');
                results.style.display = 'block';
            } else {
                results.innerHTML = '<div class="search-item">Menu tidak ditemukan</div>';
                results.style.display = 'block';
            }
        }
        
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.topbar-search')) {
                document.getElementById('searchResults').style.display = 'none';
            }
            if (!e.target.closest('.notification-bell')) {
                document.getElementById('notificationDropdown').style.display = 'none';
            }
        });
        
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('active');
                if (overlay) overlay.style.display = sidebar.classList.contains('active') ? 'block' : 'none';
            } else {
                sidebar.classList.toggle('collapsed');
                localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
            }
        }
        
        function closeMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.remove('active');
            if (overlay) overlay.style.display = 'none';
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
                if (overlay) overlay.style.display = 'none';
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