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

    <link rel="stylesheet" href="{{ asset('assets/css/kepala-sekolah/layout.css') }}">
    @stack('page-styles')
    
    @stack('styles')
</head>
<body>
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <img src="{{ asset('assets/img/bn666.png') }}" alt="Logo">
            </div>
            <div class="sidebar-brand">SIPPS 666</div>
            <div class="sidebar-role">Kepala Sekolah</div>
        </div>

        <div class="sidebar-user">
            <div class="sidebar-user-avatar">
                {{ substr(auth()->user()->nama_lengkap, 0, 1) }}
            </div>
            <div class="sidebar-user-info">
                <div class="sidebar-user-name">{{ auth()->user()->nama_lengkap }}</div>
                <div class="sidebar-user-role">Kepala Sekolah</div>
            </div>
        </div>

        <nav class="nav-section">
            <div class="nav-label">Navigation</div>
            <a href="{{ route('kepala-sekolah.dashboard') }}" class="nav-item {{ Request::is('kepala-sekolah/dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
        </nav>

       

          <nav class="nav-section">
            <div class="nav-label nav-toggle" onclick="toggleNavSection('laporan')">
                <i class="fas fa-chevron-right nav-arrow" id="laporan-arrow"></i>
                Laporan
            </div>
            <div class="nav-submenu" id="laporan" style="display: none;">
                <a href="{{ route('kepala-sekolah.laporan.index') }}" class="nav-item {{ Request::is('kepala-sekolah/laporan*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i>
                    <span>Laporan Data</span>
                </a>
            </div>
        </nav>

        <nav class="nav-section">
            <div class="nav-label nav-toggle" onclick="toggleNavSection('monitoring')">
                <i class="fas fa-chevron-right nav-arrow" id="monitoring-arrow"></i>
                Monitoring
            </div>
            <div class="nav-submenu" id="monitoring" style="display: none;">
                <a href="{{ route('kepala-sekolah.monitoring-all.index') }}" class="nav-item {{ Request::is('kepala-sekolah/monitoring-all*') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Monitoring All</span>
                </a>
            </div>
        </nav>
    </aside>

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
                        <li><a class="dropdown-item" href="{{ route('kepala-sekolah.data-diri.index') }}"><i class="fas fa-user"></i> Profil Saya</a></li>
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
    .notification-alert { position: fixed; top: 20px; right: 20px; z-index: 9999; padding: 15px 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); max-width: 400px; animation: slideIn 0.3s ease; }
    .notification-success { background: #d4edda; border-left: 4px solid #28a745; color: #155724; }
    .notification-info { background: #d1ecf1; border-left: 4px solid #17a2b8; color: #0c5460; }
    .notification-warning { background: #fff3cd; border-left: 4px solid #ffc107; color: #856404; }
    .notification-close { position: absolute; top: 10px; right: 15px; background: none; border: none; font-size: 20px; cursor: pointer; }
    .search-results { position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #ddd; border-radius: 8px; max-height: 300px; overflow-y: auto; z-index: 1000; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
    .search-item { padding: 10px 15px; border-bottom: 1px solid #eee; cursor: pointer; }
    .search-item:hover { background: #f8f9fa; }
    .notification-dropdown { position: absolute; top: 100%; right: 0; width: 300px; background: white; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); z-index: 1000; }
    .notification-header { padding: 15px; border-bottom: 1px solid #eee; font-weight: 600; }
    .notification-list { max-height: 300px; overflow-y: auto; }
    .notification-empty { padding: 20px; text-align: center; color: #666; }
    @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
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
        const alert = document.getElementById('notificationAlert');
        if (alert) alert.style.display = 'none';
    }
    
    @if(session('notification'))
    setTimeout(() => {
        const alert = document.getElementById('notificationAlert');
        if (alert) alert.style.display = 'none';
    }, 5000);
    st
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
            { name: 'Dashboard', url: '{{ route("kepala-sekolah.dashboard") }}', icon: 'fas fa-home' },
            { name: 'Data Siswa', url: '{{ route("kepala-sekolah.data-siswa.index") }}', icon: 'fas fa-users' },
            { name: 'Export Laporan', url: '{{ route("kepala-sekolah.laporan.index") }}', icon: 'fas fa-file-alt' },
            { name: 'Monitoring All', url: '{{ route("kepala-sekolah.monitoring-all.index") }}', icon: 'fas fa-chart-line' }
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

        const sections = ['monitoring'];
        sections.forEach(sectionId => {
            const state = localStorage.getItem('nav-' + sectionId);
            const section = document.getElementById(sectionId);
            const arrow = document.getElementById(sectionId + '-arrow');
            
            if (state === 'open' && section && arrow) {
                section.style.display = 'block';
                arrow.classList.add('rotated');
            }
        });
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