<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SICLEAN</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #0284c7;
            --primary-hover: #0369a1;
            --glass-bg: rgba(255, 255, 255, 0.7);
            --glass-border: rgba(255, 255, 255, 0.3);
            --text-main: #1e293b;
            --text-muted: #64748b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Outfit', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
            overflow-x: hidden;
            position: relative;
        }

        /* Animated Mesh Gradient Background */
        .mesh-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background-color: #f1f5f9;
            background-image: 
                radial-gradient(at 0% 0%, hsla(242,100%,70%,0.15) 0px, transparent 50%),
                radial-gradient(at 100% 0%, hsla(189,100%,56%,0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, hsla(262,79%,54%,0.15) 0px, transparent 50%),
                radial-gradient(at 0% 100%, hsla(331,100%,71%,0.15) 0px, transparent 50%);
        }

        .login-card {
            width: 100%;
            max-width: 950px;
            min-height: 580px;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            display: flex;
            overflow: hidden;
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Brand Side */
        .brand-side {
            width: 45%;
            background: linear-gradient(135deg, #0284c7 0%, #38bdf8 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            color: white;
            position: relative;
        }

        .brand-side::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.3;
        }

        .brand-logo {
            width: 140px;
            height: auto;
            margin-bottom: 24px;
            filter: drop-shadow(0 10px 15px rgba(0,0,0,0.2));
            z-index: 1;
        }

        .brand-title {
            font-size: 32px;
            font-weight: 700;
            letter-spacing: -0.5px;
            margin-bottom: 8px;
            z-index: 1;
        }

        .brand-desc {
            font-size: 14px;
            opacity: 0.85;
            text-align: center;
            line-height: 1.6;
            z-index: 1;
        }

        /* Form Side */
        .form-side {
            width: 55%;
            padding: 50px;
            background: rgba(255, 255, 255, 0.4);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .welcome-text h2 {
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 8px;
        }

        .welcome-text p {
            color: var(--text-muted);
            margin-bottom: 32px;
            font-size: 15px;
        }

        /* Forms */
        .form-label {
            font-weight: 600;
            color: var(--text-main);
            font-size: 14px;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
            margin-bottom: 20px;
        }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            transition: color 0.3s;
        }

        .form-control {
            height: 52px;
            padding-left: 50px;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            background: rgba(255, 255, 255, 0.8);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-control:focus {
            background: #fff;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        .form-control:focus + .input-icon {
            color: var(--primary-color);
        }

        .password-toggle {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            cursor: pointer;
            transition: color 0.3s;
        }

        .password-toggle:hover {
            color: var(--primary-color);
        }

        /* Buttons */
        .btn-primary {
            height: 52px;
            background: var(--primary-color);
            border: none;
            border-radius: 14px;
            font-weight: 600;
            letter-spacing: 0.3px;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2), 0 2px 4px -1px rgba(79, 70, 229, 0.1);
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .divider {
            text-align: center;
            margin: 24px 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 1px;
            background: #e2e8f0;
            left: 0;
            top: 50%;
        }

        .divider span {
            background: #f8fafc;
            padding: 0 16px;
            color: var(--text-muted);
            font-size: 13px;
            position: relative;
            z-index: 1;
        }

        .footer-link {
            text-align: center;
            font-size: 14px;
            color: var(--text-muted);
        }

        .footer-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }

        .footer-link a:hover {
            text-decoration: underline;
        }

        /* Loading */
        .btn-loader {
            display: none;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 0.8s linear infinite;
            margin-right: 8px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .submitting .btn-text { display: none; }
        .submitting .btn-loader { display: inline-block; }

        @media (max-width: 768px) {
            .login-card { flex-direction: column; max-width: 450px; }
            .brand-side { width: 100%; min-height: 200px; padding: 30px; }
            .form-side { width: 100%; padding: 35px; }
            .brand-logo { width: 100px; margin-bottom: 12px; }
            .brand-title { font-size: 24px; }
        }
    </style>
</head>
<body>
    <div class="mesh-bg"></div>
    
    <div class="login-card">
        <!-- Brand Side -->
        <div class="brand-side">
            <img src="{{ asset('sbadmin2/img/logoL2.png') }}" alt="SICLEAN" class="brand-logo">
            <h1 class="brand-title">SICLEAN</h1>
            <p class="brand-desc">Layanan Laundry Terpercaya untuk Kebersihan Pakaian Anda.</p>
        </div>
        
        <!-- Form Side -->
        <div class="form-side">
            <div class="welcome-text">
                <h2>Selamat Datang</h2>
                <p>Silakan masuk ke akun Anda</p>
            </div>
            
            @if(session('error'))
                <div class="alert alert-danger p-2 small mb-3" role="alert">
                    <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
                </div>
            @endif
            
            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf
                
                <label class="form-label">Email Address</label>
                <div class="input-wrapper">
                    <i class="far fa-envelope input-icon"></i>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                           placeholder="name@example.com" value="{{ old('email') }}" required autofocus>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <label class="form-label">Password</label>
                <div class="input-wrapper">
                    <i class="far fa-lock-alt input-icon"></i>
                    <input type="password" name="password" id="passwordInput" class="form-control @error('password') is-invalid @enderror" 
                           placeholder="••••••••" required>
                    <i class="far fa-eye-slash password-toggle" id="togglePassword"></i>
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label small" for="remember">Ingat saya</label>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary w-100 d-flex align-items-center justify-content-center">
                    <span class="btn-loader"></span>
                    <span class="btn-text">Masuk Sekarang</span>
                </button>
            </form>
            
            <div class="divider">
                <span>Atau</span>
            </div>
            
            <div class="footer-link">
                Belum punya akun? <a href="{{ route('register') }}">Daftar Gratis</a>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('loginForm');
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('passwordInput');
            
            // Password Visibility
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
            
            // Loading State
            loginForm.addEventListener('submit', function() {
                this.classList.add('submitting');
                const btn = this.querySelector('button[type="submit"]');
                btn.disabled = true;
            });
        });
    </script>
</body>
</html>