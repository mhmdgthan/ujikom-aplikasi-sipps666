<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/bn666.png') }}">
    <title>Login Siswa - Aplikasi Pelanggaran Siswa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/auth/login-siswa.css') }}">
    @stack('page-styles')
    
    @stack('styles')
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="logo-section">
                <div class="logo-wrapper">
                    <img src="{{ asset('assets/img/bn666.png') }}" alt="Logo Sekolah" class="logo">
                </div>
                <h2>SMK Bakti Nusantara 666</h2>
                <p class="subtitle">Sistem Informasi Pelanggaran Siswa</p>
                <div class="student-badge">
                    <i class="fas fa-user-graduate"></i>
                    Portal Siswa
                </div>
            </div>
            
            <div class="form-section">
                <h1>Login Siswa</h1>
                <p class="welcome-text">Silahkan login menggunakan NISN dan password yang telah Anda miliki.</p>
                
                <div class="info-badge">
                    <i class="fas fa-info-circle"></i>
                    <span>Gunakan NISN sebagai username untuk login</span>
                </div>

               <form action="{{ route('login.siswa.post') }}" method="POST" id="loginForm">
                    @csrf
                    <div class="input-group">
                        <label class="input-label">NISN</label>
                        <div class="input-wrapper">
                            <span class="input-icon"><i class="fas fa-id-card"></i></span>
                            <input type="text" name="nisn" id="nisn" placeholder="Masukkan NISN" value="{{ old('nisn') }}" required>
                        </div>
                    </div>

                    <div class="input-group">
                        <label class="input-label">Password</label>
                        <div class="input-wrapper">
                            <span class="input-icon"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password" id="password" placeholder="Masukkan password" required>
                            <span class="toggle-password" onclick="togglePassword()">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="login-btn" id="loginBtn">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Masuk ke Sistem</span>
                    </button>
                </form>

                @if($errors->any())
                <div class="error-messages show">
                    @foreach($errors->all() as $error)
                        <p class="error-text">{{ $error }}</p>
                    @endforeach
                </div>
                @endif

                <div class="login-link">
                    <p>Bukan siswa? <a href="{{ route('login') }}">Login sebagai Staff/Guru/BK/Orang Tua</a></p>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Toggle Password Visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Auto Focus on NISN
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('nisn').focus();
        });

        // Form Validation & Loading State
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const nisn = document.getElementById('nisn').value.trim();
            const password = document.getElementById('password').value.trim();
            const loginBtn = document.getElementById('loginBtn');
            
            if (!nisn || !password) {
                e.preventDefault();
                
                // Show error with animation
                const errorDiv = document.createElement('div');
                errorDiv.className = 'error-messages show';
                errorDiv.innerHTML = '<p class="error-text">NISN dan Password harus diisi!</p>';
                
                const existingError = document.querySelector('.error-messages');
                if (existingError) {
                    existingError.remove();
                }
                
                document.querySelector('form').appendChild(errorDiv);
                
                setTimeout(() => {
                    errorDiv.remove();
                }, 3000);
            } else {
                // Add loading state
                loginBtn.classList.add('loading');
                loginBtn.querySelector('span').textContent = 'Memproses...';
            }
        });

        // Enter key handler
        document.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('loginForm').requestSubmit();
            }
        });

        // NISN Input - Only Numbers
        document.getElementById('nisn').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
</body>
</html>