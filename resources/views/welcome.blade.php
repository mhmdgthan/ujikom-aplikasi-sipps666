<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/bn666.png') }}">
    <title>SMK Bakti Nusantara 666 - Sistem Informasi Pelanggaran Siswa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Reset & Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #667eea;
            --primary-dark: #5a6fd8;
            --secondary: #764ba2;
            --accent: #f093fb;
            --light: #f8f9fa;
            --dark: #2d3748;
            --gray: #718096;
            --success: #48bb78;
            --warning: #ed8936;
            --danger: #f56565;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--dark);
            overflow-x: hidden;
        }

        /* Header & Navigation */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 1.5rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        }

        header.scrolled {
            padding: 1rem 5%;
            background: rgba(255, 255, 255, 0.98);
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: contain;
            background-color: white;
            padding: 5px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .logo-text {
            display: flex;
            flex-direction: column;
        }

        .logo-text h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            line-height: 1.2;
        }

        .logo-text span {
            font-size: 0.8rem;
            color: var(--gray);
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        nav a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            transition: color 0.3s ease;
            position: relative;
        }

        nav a:hover {
            color: var(--primary);
        }

        nav a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            transition: width 0.3s ease;
        }

        nav a:hover::after {
            width: 100%;
        }

        .login-btn {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .login-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
        }

        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--dark);
            cursor: pointer;
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 120px 5% 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -200px;
            right: -200px;
            animation: float 20s infinite ease-in-out;
        }

        .hero::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            bottom: -100px;
            left: -100px;
            animation: float 15s infinite ease-in-out reverse;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-50px) rotate(180deg); }
        }

        .hero-content {
            max-width: 600px;
            color: white;
            position: relative;
            z-index: 1;
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .hero-btns {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .btn-primary {
            background: white;
            color: var(--primary);
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.4);
        }

        .btn-secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-secondary:hover {
            background: white;
            color: var(--primary);
        }

        .hero-image {
            position: absolute;
            right: 5%;
            bottom: 0;
            width: 45%;
            max-width: 600px;
            z-index: 1;
            animation: floatVertical 6s infinite ease-in-out;
        }

        @keyframes floatVertical {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        /* Features Section */
        .features {
            padding: 100px 5%;
            background: var(--light);
        }

        .section-title {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-title h2 {
            font-size: 2.5rem;
            color: var(--dark);
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }

        .section-title h2::after {
            content: '';
            position: absolute;
            width: 60%;
            height: 4px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            bottom: -10px;
            left: 20%;
            border-radius: 2px;
        }

        .section-title p {
            color: var(--gray);
            max-width: 600px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: white;
            border-radius: 16px;
            padding: 2.5rem 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .feature-card p {
            color: var(--gray);
        }

        /* About Section */
        .about {
            padding: 100px 5%;
            display: flex;
            align-items: center;
            gap: 5%;
        }

        .about-content {
            flex: 1;
        }

        .about-content h2 {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            color: var(--dark);
        }

        .about-content p {
            color: var(--gray);
            margin-bottom: 1.5rem;
        }

        .about-image {
            flex: 1;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            animation: floatHorizontal 8s infinite ease-in-out;
        }

        @keyframes floatHorizontal {
            0%, 100% { transform: translateX(0); }
            50% { transform: translateX(-10px); }
        }

        .about-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* Footer */
        footer {
            background: var(--dark);
            color: white;
            padding: 60px 5% 30px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
            margin-bottom: 3rem;
        }

        .footer-column h3 {
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
        }

        .footer-column h3::after {
            content: '';
            position: absolute;
            width: 40px;
            height: 3px;
            background: var(--primary);
            bottom: -8px;
            left: 0;
        }

        .footer-column p {
            color: #a0aec0;
            margin-bottom: 1rem;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 0.8rem;
        }

        .footer-links a {
            color: #a0aec0;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: white;
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .social-links a {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: var(--primary);
            transform: translateY(-3px);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #a0aec0;
            font-size: 0.9rem;
        }

        /* Responsive Styles */
        @media (max-width: 1024px) {
            .hero h1 {
                font-size: 3rem;
            }
            
            .about {
                flex-direction: column;
                gap: 3rem;
            }
        }

        @media (max-width: 768px) {
            header {
                padding: 1rem 5%;
                position: relative;
            }
            
            .logo-container {
                flex: 1;
            }
            
            nav {
                position: fixed;
                top: 0;
                left: -100%;
                width: 280px;
                height: 100vh;
                background: white;
                box-shadow: 2px 0 20px rgba(0, 0, 0, 0.1);
                padding: 2rem;
                transition: all 0.3s ease;
                z-index: 1001;
                overflow-y: auto;
            }
            
            nav.active {
                left: 0;
            }
            
            nav ul {
                flex-direction: column;
                gap: 1.5rem;
                margin-top: 2rem;
            }
            
            .mobile-menu-btn {
                display: block;
                z-index: 1002;
                background: rgba(255, 255, 255, 0.9);
                border-radius: 8px;
                padding: 8px 12px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                margin-left: 1rem;
            }
            
            .nav-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1000;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
            }
            
            .nav-overlay.active {
                opacity: 1;
                visibility: visible;
            }
            
            .hero {
                flex-direction: column;
                text-align: center;
                padding: 120px 5% 60px;
            }
            
            .hero-content {
                max-width: 100%;
            }
            
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .hero-image {
                position: relative;
                width: 80%;
                right: auto;
                margin-top: 3rem;
            }
            
            .hero-btns {
                justify-content: center;
            }
            
            .section-title h2 {
                font-size: 2rem;
            }
        }

        @media (max-width: 480px) {
            .hero h1 {
                font-size: 2rem;
            }
            
            .hero p {
                font-size: 1rem;
            }
            
            .btn {
                padding: 12px 24px;
            }
            
            .section-title h2 {
                font-size: 1.8rem;
            }
            
            .feature-card {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header & Navigation -->
    <header id="header">
        <div class="logo-container">
            <img src="{{ asset('assets/img/bn666.png') }}" alt="Logo SMK Bakti Nusantara 666" class="logo">
            <div class="logo-text">
                <h1>SMK BAKTI NUSANTARA 666</h1>
                <span>Sistem Informasi Pelanggaran Siswa</span>
            </div>
        </div>
        
        <nav id="nav">
            <ul>
                <li><a href="#home">Beranda</a></li>
                <li><a href="#features">Fitur</a></li>
                <li><a href="#about">Tentang</a></li>
                <li><a href="#contact">Kontak</a></li>
            </ul>
        </nav>
        
        <a href="{{ route('login') }}" class="login-btn">
            <i class="fas fa-sign-in-alt"></i>
            <span>Login</span>
        </a>
        
        <button class="mobile-menu-btn" id="mobileMenuBtn">
            <i class="fas fa-bars"></i>
        </button>
        <div class="nav-overlay" id="navOverlay"></div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-content">
            <h1>Kelola Pelanggaran Siswa dengan Sistem Terintegrasi</h1>
            <p>Platform digital untuk memantau, mencatat, dan menganalisis pelanggaran siswa secara efektif dan transparan.</p>
            <div class="hero-btns">
                <a href="#features" class="btn btn-primary">
                    <i class="fas fa-play-circle"></i>
                    <span>Pelajari Lebih Lanjut</span>
                </a>
                <a href="#about" class="btn btn-secondary">
                    <i class="fas fa-info-circle"></i>
                    <span>Tentang Kami</span>
                </a>
            </div>
        </div>
        <div class="hero-image">
            <svg viewBox="0 0 500 400" xmlns="http://www.w3.org/2000/svg">
                <path fill="#ffffff" d="M91.9,173.8c0,0,46.5-75.1,119.4-75.1s121.7,75.1,121.7,75.1s31.8,51.7,31.8,118.4s-31.8,118.4-31.8,118.4
                s-46.5,75.1-119.4,75.1s-121.7-75.1-121.7-75.1s-31.8-51.7-31.8-118.4S91.9,173.8,91.9,173.8z" opacity="0.1"/>
                <path fill="#ffffff" d="M105.5,173.8c0,0,46.5-75.1,119.4-75.1s121.7,75.1,121.7,75.1s31.8,51.7,31.8,118.4s-31.8,118.4-31.8,118.4
                s-46.5,75.1-119.4,75.1s-121.7-75.1-121.7-75.1s-31.8-51.7-31.8-118.4S105.5,173.8,105.5,173.8z" opacity="0.1"/>
                <path fill="#ffffff" d="M119.1,173.8c0,0,46.5-75.1,119.4-75.1s121.7,75.1,121.7,75.1s31.8,51.7,31.8,118.4s-31.8,118.4-31.8,118.4
                s-46.5,75.1-119.4,75.1s-121.7-75.1-121.7-75.1s-31.8-51.7-31.8-118.4S119.1,173.8,119.1,173.8z" opacity="0.1"/>
                <circle fill="#ffffff" cx="250" cy="200" r="130" opacity="0.1"/>
                <circle fill="#ffffff" cx="250" cy="200" r="110" opacity="0.1"/>
                <circle fill="#ffffff" cx="250" cy="200" r="90" opacity="0.1"/>
                <path fill="#ffffff" d="M250,110c49.7,0,90,40.3,90,90s-40.3,90-90,90s-90-40.3-90-90S200.3,110,250,110z" opacity="0.2"/>
                <path fill="#ffffff" d="M250,130c38.7,0,70,31.3,70,70s-31.3,70-70,70s-70-31.3-70-70S211.3,130,250,130z" opacity="0.3"/>
                <path fill="#ffffff" d="M250,150c27.6,0,50,22.4,50,50s-22.4,50-50,50s-50-22.4-50-50S222.4,150,250,150z" opacity="0.4"/>
                <path fill="#ffffff" d="M250,170c16.6,0,30,13.4,30,30s-13.4,30-30,30s-30-13.4-30-30S233.4,170,250,170z" opacity="0.5"/>
                
                <!-- Dashboard illustration -->
                <rect x="180" y="160" fill="#ffffff" width="140" height="100" rx="10" opacity="0.8"/>
                <rect x="190" y="175" fill="#667eea" width="40" height="10" rx="5"/>
                <rect x="240" y="175" fill="#764ba2" width="40" height="10" rx="5"/>
                <rect x="290" y="175" fill="#48bb78" width="20" height="10" rx="5"/>
                
                <rect x="190" y="195" fill="#e2e8f0" width="120" height="5" rx="2.5"/>
                <rect x="190" y="205" fill="#e2e8f0" width="100" height="5" rx="2.5"/>
                <rect x="190" y="215" fill="#e2e8f0" width="110" height="5" rx="2.5"/>
                <rect x="190" y="225" fill="#e2e8f0" width="90" height="5" rx="2.5"/>
                
                <circle cx="200" cy="250" r="15" fill="#667eea" opacity="0.7"/>
                <circle cx="230" cy="250" r="15" fill="#764ba2" opacity="0.7"/>
                <circle cx="260" cy="250" r="15" fill="#48bb78" opacity="0.7"/>
                <circle cx="290" cy="250" r="15" fill="#ed8936" opacity="0.7"/>
            </svg>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="section-title">
            <h2>Fitur Unggulan Sistem</h2>
            <p>Platform kami menyediakan berbagai fitur untuk memudahkan pengelolaan pelanggaran siswa</p>
        </div>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <h3>Analisis Data</h3>
                <p>Pantau tren pelanggaran siswa dengan dashboard analitik yang informatif dan mudah dipahami.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-bell"></i>
                </div>
                <h3>Notifikasi Real-time</h3>
                <p>Dapatkan pemberitahuan instan ketika terjadi pelanggaran untuk tindakan cepat dan tepat.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-file-export"></i>
                </div>
                <h3>Laporan Otomatis</h3>
                <p>Hasilkan laporan periodik secara otomatis untuk evaluasi dan pengambilan keputusan.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <h3>Keamanan Data</h3>
                <p>Data siswa dan pelanggaran terlindungi dengan sistem keamanan berlapis dan enkripsi.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3>Akses Mobile</h3>
                <p>Akses sistem dari perangkat mobile kapan saja dan di mana saja untuk kemudahan penggunaan.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Multi-user</h3>
                <p>Dukung kolaborasi dengan akses multi-user dan pembagian peran yang jelas.</p>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <div class="about-content">
            <h2>Tentang SMK Bakti Nusantara 666</h2>
            <p>SMK Bakti Nusantara 666 adalah lembaga pendidikan kejuruan yang berkomitmen untuk menghasilkan lulusan yang kompeten, berkarakter, dan siap bersaing di dunia kerja.</p>
            <p>Dengan sistem informasi pelanggaran siswa ini, kami bertujuan untuk menciptakan lingkungan belajar yang disiplin dan kondusif, sekaligus memberikan transparansi dalam penanganan pelanggaran.</p>
            <p>Platform digital ini dikembangkan untuk memudahkan guru dan staf dalam mencatat, memantau, dan menganalisis perilaku siswa, sehingga dapat mengambil tindakan yang tepat untuk pembinaan karakter.</p>
        </div>
        <div class="about-image">
            <!-- Placeholder for school image -->
            <svg viewBox="0 0 500 400" xmlns="http://www.w3.org/2000/svg">
                <rect width="500" height="400" fill="#f0f4f8"/>
                <rect x="50" y="50" width="400" height="300" rx="20" fill="#ffffff"/>
                <rect x="80" y="80" width="340" height="180" fill="#e2e8f0"/>
                <rect x="80" y="280" width="150" height="50" rx="10" fill="#667eea"/>
                <rect x="250" y="280" width="170" height="50" rx="10" fill="#764ba2"/>
                <circle cx="130" cy="130" r="40" fill="#667eea" opacity="0.7"/>
                <rect x="190" y="110" width="180" height="20" rx="10" fill="#cbd5e0"/>
                <rect x="190" y="140" width="150" height="15" rx="7.5" fill="#cbd5e0"/>
                <rect x="190" y="165" width="120" height="15" rx="7.5" fill="#cbd5e0"/>
            </svg>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact">
        <div class="footer-content">
            <div class="footer-column">
                <h3>SMK Bakti Nusantara 666</h3>
                <p>Lembaga pendidikan kejuruan yang berkomitmen menghasilkan lulusan kompeten dan berkarakter.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            
            <div class="footer-column">
                <h3>Kontak Kami</h3>
                <ul class="footer-links">
                    <li><i class="fas fa-map-marker-alt"></i> Jl. Raya Percobaan No.65, Cileunyi Kulon, Kec. Cileunyi, Kabupaten Bandung, Jawa Barat 40622</li>
                    <li><i class="fas fa-phone"></i> (021) 1234-5678</li>
                    <li><i class="fas fa-envelope"></i> info@smkbn666.sch.id</li>
                    <li><i class="fas fa-clock"></i> Senin - Jumat: 07:00 - 16:00</li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h3>Tautan Cepat</h3>
                <ul class="footer-links">
                    <li><a href="#home">Beranda</a></li>
                    <li><a href="#features">Fitur</a></li>
                    <li><a href="#about">Tentang</a></li>
                    <li><a href="/login">Login</a></li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2023 SMK Bakti Nusantara 666. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const nav = document.getElementById('nav');
        const navOverlay = document.getElementById('navOverlay');
        
        function toggleMobileMenu() {
            nav.classList.toggle('active');
            navOverlay.classList.toggle('active');
            mobileMenuBtn.innerHTML = nav.classList.contains('active') 
                ? '<i class="fas fa-times"></i>' 
                : '<i class="fas fa-bars"></i>';
        }
        
        mobileMenuBtn.addEventListener('click', toggleMobileMenu);
        navOverlay.addEventListener('click', toggleMobileMenu);
        
        // Header scroll effect
        const header = document.getElementById('header');
        
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                    
                    // Close mobile menu if open
                    if (nav.classList.contains('active')) {
                        nav.classList.remove('active');
                        navOverlay.classList.remove('active');
                        mobileMenuBtn.innerHTML = '<i class="fas fa-bars"></i>';
                    }
                }
            });
        });
        

        
        // Animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);
        
        // Observe elements for animation
        document.querySelectorAll('.feature-card, .about-content, .about-image').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(el);
        });
    </script>
</body>
</html>