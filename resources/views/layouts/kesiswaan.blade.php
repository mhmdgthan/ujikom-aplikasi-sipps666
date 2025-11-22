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

    <!-- GUNAKAN CSS TERPISAH SEPERTI ADMIN -->
    <link rel="stylesheet" href="{{ asset('assets/css/kesiswaan/layout.css') }}">
    @stack('page-styles')
    
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
            <div class="sidebar-role">{{ auth()->guard('web')->check() ? ucfirst(str_replace('_', ' ', auth()->guard('web')->user()->level)) : 'Siswa' }}</div>
        </div>

        <div class="sidebar-user">
            <div class="sidebar-user-avatar">
                @if(auth()->guard('web')->check())
                    {{ substr(auth()->guard('web')->user()->nama_lengkap, 0, 1) }}
                @elseif(auth()->guard('siswa')->check())
                    {{ substr(auth()->user()->nama_lengkap, 0, 1) }}
                @endif
            </div>
            <div class="sidebar-user-info">
                <div class="sidebar-user-name">
                    @if(auth()->guard('web')->check())
                        {{ auth()->guard('web')->user()->nama_lengkap }}
                    @elseif(auth()->guard('siswa')->check())
                        {{ auth()->user()->nama_lengkap }}
                    @endif
                </div>
                <div class="sidebar-user-role">
                    @if(auth()->guard('web')->check())
                        {{ ucfirst(str_replace('_', ' ', auth()->guard('web')->user()->level)) }}
                    @else
                        Siswa
                    @endif
                </div>
            </div>
        </div>

        <nav class="nav-section">
            <div class="nav-label">Navigation</div>
            <a href="{{ route('kesiswaan.dashboard') }}" class="nav-item {{ Request::is('kesiswaan/dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
        </nav>

        <nav class="nav-section">
            <div class="nav-label nav-toggle" onclick="toggleNavSection('manajemenKesiswaan')">
                <i class="fas fa-chevron-right nav-arrow" id="manajemenKesiswaan-arrow"></i>
                Manajemen Data
            </div>
            <div class="nav-submenu" id="manajemenKesiswaan" style="display: none;">
                <a href="{{ route('kesiswaan.pelanggaran.index') }}" class="nav-item {{ Request::is('kesiswaan/pelanggaran*') ? 'active' : '' }}">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>Data Pelanggaran</span>
                </a>
                 <a href="{{ route('kesiswaan.sanksi.index') }}" class="nav-item {{ Request::is('kesiswaan/sanksi*') ? 'active' : '' }}">
                    <i class="fas fa-gavel"></i>
                    <span>Data Sanksi</span>
                </a>
                <a href="{{ route('kesiswaan.pelaksanaan-sanksi.index') }}" class="nav-item {{ Request::is('kesiswaan/pelaksanaan-sanksi*') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-check"></i>
                    <span>Pelaksanaan Sanksi</span>
                </a>
                <a href="{{ route('kesiswaan.prestasi.index') }}" class="nav-item {{ Request::is('kesiswaan/prestasi*') ? 'active' : '' }}">
                    <i class="fa-solid fa-trophy"></i>
                    <span>Data Prestasi</span>
                </a>
                 <a href="{{ route('kesiswaan.verifikasi-data.index') }}" class="nav-item {{ Request::is('kesiswaan/verifikasi-data*') ? 'active' : '' }}">
                <i class="fas fa-check-double"></i>
                <span>Verifikasi Data</span>
            </a>
            </div>
        </nav>
        <nav class="nav-section">
            <div class="nav-label nav-toggle" onclick="toggleNavSection('laporanKesiswaan')">
                <i class="fas fa-chevron-right nav-arrow" id="laporanKesiswaan-arrow"></i>
                Laporan
            </div>
            <div class="nav-submenu" id="laporanKesiswaan" style="display: none;">
                <a href="{{ route('kesiswaan.laporan.index') }}" class="nav-item {{ Request::is('kesiswaan/laporan*') ? 'active' : '' }}">
                    <i class="fa-solid fa-file-lines"></i> 
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
                <a href="{{ route('kesiswaan.monitoring-all.index') }}" class="nav-item {{ Request::is('kesiswaan/monitoring-all*') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Monitoring All</span>
                </a>
            </div>
        </nav>

    </aside>

    <!-- Mobile Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeMobileSidebar()" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 999;"></div>

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
                    <input type="text" id="globalSearch" placeholder="Search siswa, guru, pelanggaran..." onkeyup="performSearch()">
                    <div id="searchResults" class="search-results" style="display: none;"></div>
                </div>
            </div>

            <div class="topbar-right">

                <div class="topbar-user dropdown">
                    <div class="topbar-user-info" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="topbar-user-avatar">
                            @if(auth()->guard('web')->check())
                                {{ substr(auth()->guard('web')->user()->nama_lengkap, 0, 1) }}
                            @elseif(auth()->guard('siswa')->check())
                                {{ substr(auth()->user()->nama_lengkap, 0, 1) }}
                            @endif
                        </div>
                        <span class="topbar-user-name">
                            @if(auth()->guard('web')->check())
                                {{ auth()->guard('web')->user()->nama_lengkap }}
                            @elseif(auth()->guard('siswa')->check())
                                {{ auth()->user()->nama_lengkap }}
                            @endif
                        </span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('kesiswaan.data-diri.index') }}"><i class="fas fa-user"></i> Profil Saya</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="@if(auth()->guard('web')->check()) {{ route('logout') }} @else {{ route('logout.siswa') }} @endif" method="POST">
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
    /* Tambahkan di bagian CSS yang sudah ada */
.topbar-toggle {
    cursor: pointer !important;
    position: relative;
    z-index: 1001;
}

/* Pastikan icon di dalam button tidak menghalangi klik */
.topbar-toggle i {
    pointer-events: none;
}

/* Hover effect untuk konfirmasi visual */
.topbar-toggle:hover {
    background: #e2e8f0 !important;
    transform: scale(1.05);
    transition: all 0.2s ease;
}

/* Pastikan sidebar overlay bisa diklik */
.sidebar-overlay {
    cursor: pointer;
}
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
            { name: 'Dashboard', url: '{{ route("kesiswaan.dashboard") }}', icon: 'fas fa-home' },
            { name: 'Data Pelanggaran', url: '{{ route("kesiswaan.pelanggaran.index") }}', icon: 'fa-solid fa-triangle-exclamation' },
            { name: 'Data Sanksi', url: '{{ route("kesiswaan.sanksi.index") }}', icon: 'fas fa-gavel' },
            { name: 'Data Prestasi', url: '{{ route("kesiswaan.prestasi.index") }}', icon: 'fa-solid fa-trophy' },
            { name: 'Verifikasi Data', url: '{{ route("kesiswaan.verifikasi-data.index") }}', icon: 'fas fa-check-double' },
            { name: 'Laporan Data', url: '{{ route("kesiswaan.laporan.index") }}', icon: 'fa-solid fa-file-lines' },
            { name: 'Monitoring All', url: '{{ route("kesiswaan.monitoring-all.index") }}', icon: 'fas fa-chart-line' }
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
        overlay.style.display = 'none';
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

        const sections = ['manajemenKesiswaan', 'laporanKesiswaan', 'monitoring'];
        sections.forEach(sectionId => {
            const state = localStorage.getItem('nav-' + sectionId);
            const section = document.getElementById(sectionId);
            const arrow = document.getElementById(sectionId + '-arrow');
            
            if (state === 'open') {
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
            overlay.style.display = 'none';
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