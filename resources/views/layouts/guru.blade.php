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

    <link rel="stylesheet" href="{{ asset('assets/css/guru/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/mobile-table.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/mobile-modal.css') }}">
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
            <div class="sidebar-role">
                @php
                    $isWaliKelas = \App\Models\WaliKelas::where('guru_id', auth()->user()->guru->id ?? 0)
                        ->whereNull('tanggal_selesai')
                        ->exists();
                @endphp
                {{ $isWaliKelas ? 'Guru & Wali Kelas' : 'Guru' }}
            </div>
        </div>

        <div class="sidebar-user">
            <div class="sidebar-user-avatar">
                {{ strtoupper(substr(auth()->user()->nama_lengkap ?? 'G', 0, 1)) }}
            </div>
            <div class="sidebar-user-info">
                <div class="sidebar-user-name">{{ auth()->user()->nama_lengkap ?? 'Guru' }}</div>
                <div class="sidebar-user-role">
                    @php
                        $isWaliKelas = \App\Models\WaliKelas::where('guru_id', auth()->user()->guru->id ?? 0)
                            ->whereNull('tanggal_selesai')
                            ->exists();
                    @endphp
                    {{ $isWaliKelas ? 'Guru & Wali Kelas' : 'Guru' }}
                </div>
            </div>
        </div>

        <nav class="nav-section">
            <div class="nav-label">Navigation</div>
            <a href="{{ route('guru.dashboard') }}" class="nav-item {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('guru.pelanggaran.index') }}" class="nav-item {{ request()->routeIs('guru.pelanggaran.*') ? 'active' : '' }}">
                <i class="fas fa-exclamation-triangle"></i>
                <span>Input Pelanggaran</span>
            </a>
        </nav>

        @php
            $waliKelas = \App\Models\WaliKelas::where('guru_id', auth()->user()->guru->id ?? 0)
                ->whereNull('tanggal_selesai')
                ->first();
        @endphp
      @if($waliKelas)
<nav class="nav-section">
    <div class="nav-label">Wali Kelas</div>
    <div class="nav-toggle" onclick="toggleNavSection('waliKelas')">
        <i class="fas fa-chevron-right nav-arrow" id="waliKelas-arrow"></i>
        <span>Menu Wali Kelas</span>
    </div>
    <div class="nav-submenu" id="waliKelas" style="display: none;">
        <a href="{{ route('guru.siswa-kelas.index') }}" class="nav-item {{ request()->routeIs('guru.siswa-kelas.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i>
            <span>Data Siswa Kelas</span>
        </a>
    </div>
</nav>
@endif
    </aside>

    <!-- Mobile Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeMobileSidebar()"></div>

    <main class="main-content">
        <div class="topbar">
            <div class="topbar-left">
                <button class="topbar-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                
                <div class="topbar-search">
                    <i class="fas fa-search"></i>
                    <input type="text" id="globalSearch" placeholder="Search menu..." onkeyup="performSearch()">
                    <div id="searchResults" class="search-results"></div>
                </div>
            </div>

         
                <div class="topbar-user dropdown">
                    <div class="topbar-user-info" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="topbar-user-avatar">
                            {{ strtoupper(substr(auth()->user()->nama_lengkap ?? 'G', 0, 1)) }}
                        </div>
                        <span class="topbar-user-name">{{ auth()->user()->nama_lengkap ?? 'Guru' }}</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('guru.data-diri.index') }}"><i class="fas fa-user"></i> Profil Saya</a></li>
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
                <a href="{{ route('guru.dashboard') }}">Dashboard</a>
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
            const badge = document.getElementById('notificationCount');
            if (badge) {
                badge.textContent = notifications.length;
            }
        }
        
        function updateNotificationList() {
            const list = document.getElementById('notificationList');
            if (!list) return;
            
            if (notifications.length === 0) {
                list.innerHTML = '<div class="notification-empty">Tidak ada notifikasi</div>';
            } else {
                list.innerHTML = notifications.map(notif => `
                    <div class="notification-item">
                        <strong>${notif.title}</strong>
                        <p>${notif.message}</p>
                        <small>${notif.time}</small>
                    </div>
                `).join('');
            }
        }
        
        function toggleNotifications() {
            const dropdown = document.getElementById('notificationDropdown');
            if (dropdown) {
                dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
            }
        }
        
        function closeNotification() {
            const alert = document.getElementById('notificationAlert');
            if (alert) alert.style.display = 'none';
        }
        
        @if(session('notification'))
        setTimeout(() => {
            closeNotification();
        }, 5000);
        
        addNotification('{{ session('notification.type') }}', '{{ session('notification.title') }}', '{{ session('notification.message') }}');
        @endif
        
        function performSearch() {
            const query = document.getElementById('globalSearch').value;
            const results = document.getElementById('searchResults');
            
            if (!results) return;
            
            if (query.length < 2) {
                results.style.display = 'none';
                return;
            }
            
            const menuItems = [
                { name: 'Dashboard', url: '{{ route("guru.dashboard") }}', icon: 'fas fa-home' },
                { name: 'Input Pelanggaran', url: '{{ route("guru.pelanggaran.index") }}', icon: 'fas fa-exclamation-triangle' },
                @if(\App\Models\WaliKelas::where('guru_id', auth()->user()->guru->id ?? 0)->whereNull('tanggal_selesai')->exists())
                { name: 'Data Siswa Kelas', url: '{{ route("guru.siswa-kelas.index") }}', icon: 'fas fa-users' }
                @endif
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
            const searchResults = document.getElementById('searchResults');
            const notificationDropdown = document.getElementById('notificationDropdown');
            
            if (!e.target.closest('.topbar-search') && searchResults) {
                searchResults.style.display = 'none';
            }
            if (!e.target.closest('.notification-bell') && notificationDropdown) {
                notificationDropdown.style.display = 'none';
            }
        });
        
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

            const sections = ['waliKelas'];
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