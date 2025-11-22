<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/bn666.png') }}">
    <title>Login - Aplikasi Pelanggaran Siswa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/auth/login.css') }}">
    @stack('page-styles')
    
    @stack('styles')
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="logo-section">
                <i class="fas fa-shield-alt decorative-icon shield"></i>
                <i class="fas fa-book-open decorative-icon book"></i>
                
                <div class="logo-wrapper">
                    <img src="{{ asset('assets/img/bn666.png') }}" alt="Logo Sekolah" class="logo">
                </div>
                
                <h2>SMK Bakti Nusantara 666</h2>
                <p class="subtitle">Sistem Informasi Pelanggaran Siswa</p>
            </div>
            
            <div class="form-section">
                <h1>Selamat Datang</h1>
                <p class="welcome-text">Silahkan login dengan username dan password yang telah Anda miliki untuk mengakses sistem.</p>
                
                <form action="{{ route('login') }}" method="POST" id="loginForm">
                    @csrf
                    
                    <div class="input-group">
                        <label class="input-label">Username</label>
                        <div class="input-wrapper">
                            <span class="input-icon"><i class="fas fa-user"></i></span>
                            <input type="text" name="username" id="username" placeholder="Masukkan username" value="{{ old('username') }}" required>
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
                <div class="error-messages">
                    @foreach($errors->all() as $error)
                        <p class="error-text">{{ $error }}</p>
                    @endforeach
                </div>
                @endif


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

        // Auto Focus on Username
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('username').focus();
        });

        // Form Validation & Loading State
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();
            const loginBtn = document.getElementById('loginBtn');
            
            if (!username || !password) {
                e.preventDefault();
                
                // Show error with animation
                const errorDiv = document.createElement('div');
                errorDiv.className = 'error-messages';
                errorDiv.innerHTML = '<p class="error-text">Username dan Password harus diisi!</p>';
                
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
    </script>
</body>
</html>