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

    <link rel="stylesheet" href="{{ asset('assets/css/admin/layout.css') }}">
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
                @elseif(auth()->guard(name: 'siswa')->check())
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
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
        </nav>
        

        <nav class="nav-section">
            <div class="nav-label nav-toggle" onclick="toggleNavSection('dataMaster')">
                <i class="fas fa-chevron-right nav-arrow" id="dataMaster-arrow"></i>
                Data Master
            </div>
            <div class="nav-submenu" id="dataMaster" style="display: none;">
                <a href="{{ route('admin.users.index') }}" class="nav-item {{ Request::is('admin/users*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Data Users</span>
                </a>
                <a href="{{ route('admin.guru.index') }}" class="nav-item {{ Request::is('admin/guru*') ? 'active' : '' }}">
                    <i class="fas fa-user-tie"></i>
                    <span>Data Guru</span>
                </a>
                <a href="{{ route('admin.siswa.index') }}" class="nav-item {{ Request::is('admin/siswa*') ? 'active' : '' }}">
                    <i class="fas fa-user-graduate"></i>
                    <span>Data Siswa</span>
                </a>
                <a href="{{ route('admin.jurusan.index') }}" class="nav-item {{ Request::is('admin/jurusan*') ? 'active' : '' }}">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Data Jurusan</span>
                </a>
                <a href="{{ route('admin.kelas.index') }}" class="nav-item {{ Request::is('admin/kelas*') ? 'active' : '' }}">
                    <i class="fas fa-chalkboard"></i>
                    <span>Data Kelas</span>
                </a>
                <a href="{{ route('admin.wali-kelas.index') }}" class="nav-item {{ Request::is('admin/wali-kelas*') ? 'active' : '' }}">
                    <i class="fas fa-user-check"></i>
                    <span>Data Wali Kelas</span>
                </a>
                <a href="{{ route('admin.orang-tua.index') }}" class="nav-item {{ Request::is('admin/orang-tua*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Data Orang Tua</span>
                </a>
                <a href="{{ route('admin.tahun-ajaran.index') }}" class="nav-item {{ Request::is('admin/tahun-ajaran*') ? 'active' : '' }}">
                    <i class="fas fa-calendar"></i>
                    <span>Tahun Ajaran</span>
                </a>
            </div>
        </nav>

        <nav class="nav-section">
            <div class="nav-label nav-toggle" onclick="toggleNavSection('jenisPoin')">
                <i class="fas fa-chevron-right nav-arrow" id="jenisPoin-arrow"></i>
                Jenis Poin
            </div>
            <div class="nav-submenu" id="jenisPoin" style="display: none;">
                <a href="{{ route('admin.kategori-pelanggaran.index') }}" class="nav-item {{ Request::is('admin/kategori-pelanggaran*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i>
                    <span>Kategori Pelanggaran</span>
                </a>
                <a href="{{ route('admin.jenis-pelanggaran.index') }}" class="nav-item {{ Request::is('admin/jenis-pelanggaran*') ? 'active' : '' }}">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>Jenis Pelanggaran</span>
                </a>
                <a href="{{ route('admin.jenis-prestasi.index') }}" class="nav-item {{ Request::is('admin/jenis-prestasi*') ? 'active' : '' }}">
                    <i class="fas fa-trophy"></i>
                    <span>Jenis Prestasi</span>
                </a>
                <a href="{{ route('admin.jenis-sanksi.index') }}" class="nav-item {{ Request::is('admin/jenis-sanksi*') ? 'active' : '' }}">
                    <i class="fas fa-gavel"></i>
                    <span>Jenis Sanksi</span>
                </a>
            </div>
        </nav>

        <nav class="nav-section">
            <div class="nav-label nav-toggle" onclick="toggleNavSection('laporan')">
                <i class="fas fa-chevron-right nav-arrow" id="laporan-arrow"></i>
                Laporan
            </div>
            <div class="nav-submenu" id="laporan" style="display: none;">
                <a href="{{ route('admin.laporan.index') }}" class="nav-item {{ Request::is('admin/laporan*') ? 'active' : '' }}">
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
                <a href="{{ route('admin.monitoring-all.index') }}" class="nav-item {{ Request::is('admin/monitoring-all*') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Monitoring All</span>
                </a>
            </div>
        </nav>

        <nav class="nav-section">
            <div class="nav-label nav-toggle" onclick="toggleNavSection('system')">
                <i class="fas fa-chevron-right nav-arrow" id="system-arrow"></i>
                System
            </div>
            <div class="nav-submenu" id="system" style="display: none;">
                <a href="{{ route('admin.backup.index') }}" class="nav-item {{ Request::is('admin/backup*') ? 'active' : '' }}">
                    <i class="fas fa-database"></i>
                    <span>Backup System</span>
                </a>
            </div>
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
                    <input type="text" id="globalSearch" placeholder="Search menu..." onkeyup="performSearch()">
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
                        <li><a class="dropdown-item" href="{{ route('admin.data-diri.index') }}"><i class="fas fa-user"></i> Profil Saya</a></li>
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

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

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
                { name: 'Dashboard', url: '{{ route("admin.dashboard") }}', icon: 'fas fa-home' },
                { name: 'Data Users', url: '{{ route("admin.users.index") }}', icon: 'fas fa-users' },
                { name: 'Data Guru', url: '{{ route("admin.guru.index") }}', icon: 'fas fa-user-tie' },
                { name: 'Data Siswa', url: '{{ route("admin.siswa.index") }}', icon: 'fas fa-user-graduate' },
                { name: 'Data Jurusan', url: '{{ route("admin.jurusan.index") }}', icon: 'fas fa-graduation-cap' },
                { name: 'Data Kelas', url: '{{ route("admin.kelas.index") }}', icon: 'fas fa-chalkboard' },
                { name: 'Data Wali Kelas', url: '{{ route("admin.wali-kelas.index") }}', icon: 'fas fa-user-check' },
                { name: 'Data Orang Tua', url: '{{ route("admin.orang-tua.index") }}', icon: 'fas fa-users' },
                { name: 'Tahun Ajaran', url: '{{ route("admin.tahun-ajaran.index") }}', icon: 'fas fa-calendar' },
                { name: 'Kategori Pelanggaran', url: '{{ route("admin.kategori-pelanggaran.index") }}', icon: 'fas fa-tags' },
                { name: 'Jenis Pelanggaran', url: '{{ route("admin.jenis-pelanggaran.index") }}', icon: 'fas fa-exclamation-triangle' },
                { name: 'Jenis Prestasi', url: '{{ route("admin.jenis-prestasi.index") }}', icon: 'fas fa-trophy' },
                { name: 'Jenis Sanksi', url: '{{ route("admin.jenis-sanksi.index") }}', icon: 'fas fa-gavel' },
                { name: 'Data Pelanggaran', url: '{{ route("admin.pelanggaran.index") }}', icon: 'fas fa-exclamation-triangle' },
                { name: 'Data Prestasi', url: '{{ route("admin.prestasi.index") }}', icon: 'fas fa-trophy' },
                { name: 'Data Sanksi', url: '{{ route("admin.sanksi.index") }}', icon: 'fas fa-gavel' },
                { name: 'Verifikasi Data', url: '{{ route("admin.verifikasi-data.index") }}', icon: 'fas fa-check-double' },
                { name: 'Laporan Data', url: '{{ route("admin.laporan.index") }}', icon: 'fas fa-file-alt' },
                { name: 'Monitoring All', url: '{{ route("admin.monitoring-all.index") }}', icon: 'fas fa-chart-line' },
                { name: 'Backup System', url: '{{ route("admin.backup.index") }}', icon: 'fas fa-database' }
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

            const sections = ['dataMaster', 'jenisPoin', 'manajemenData', 'laporan', 'monitoring', 'system'];
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