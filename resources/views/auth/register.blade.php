<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SICLEAN</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        /* Gunakan style yang sama dengan login */
        body {
            /* Background awal abu-abu putih halus */
            background-color: #f8fafc;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            /* Transisi untuk perubahan background */
            transition: background-color 1s ease;
        }

        .login-container {
            width: 100%;
            max-width: 900px;
            height: 600px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            overflow: hidden;
            background: white;
            display: flex;
        }

        .brand-section {
            width: 40%;
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
        }

        .brand-icon {
            font-size: 5rem;
            margin-bottom: 1rem;
        }

        .brand-name {
            font-size: 2.5rem;
            font-weight: bold;
            letter-spacing: 2px;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .brand-tagline {
            font-size: 1rem;
            opacity: 0.9;
            text-align: center;
        }

        .login-section {
            width: 60%;
            padding: 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-title {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-control {
            border-radius: 50px;
            padding: 12px 20px 12px 45px;
            border: 1px solid #ddd;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
            outline: none;
        }

        .form-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 1.2rem;
        }

        /* Style untuk tombol mata */
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            cursor: pointer;
            font-size: 1.2rem;
        }

        .password-toggle:hover {
            color: #3498db;
        }

        .btn-login {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 12px 0;
            font-weight: 600;
            font-size: 1rem;
            width: 100%;
            margin-top: 1rem;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(52, 152, 219, 0.3);
        }

        .btn-login:active {
            transform: translateY(1px);
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #666;
        }

        .register-link a {
            color: #3498db;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s;
        }

        .register-link a:hover {
            color: #2980b9;
            text-decoration: underline;
        }

        .alert {
            border-radius: 10px;
            margin-bottom: 1.5rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                height: auto;
                max-width: 400px;
            }

            .brand-section {
                width: 100%;
                height: 150px;
                padding: 1rem;
            }

            .brand-icon {
                font-size: 3rem;
            }

            .brand-name {
                font-size: 1.8rem;
            }

            .login-section {
                width: 100%;
                padding: 1.5rem;
            }
        }

        /* Loading animation */
        .loading {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .loading span {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #3498db;
            margin: 0 5px;
            animation: loading 1.4s infinite ease-in-out both;
        }

        .loading span:nth-child(1) {
            animation-delay: -0.32s;
        }

        .loading span:nth-child(2) {
            animation-delay: -0.16s;
        }

        @keyframes loading {

            0%,
            80%,
            100% {
                transform: scale(0);
                opacity: 0.5;
            }

            40% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .form-container {
            position: relative;
        }

        .form-container.loading .form-control,
        .form-container.loading .btn-login {
            opacity: 0.7;
            pointer-events: none;
        }

        .form-container.loading .loading {
            display: block;
        }

        
        .password-group {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            z-index: 10;
        }

        .toggle-password:hover {
            color: #000;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <!-- Brand Section -->
        <div class="brand-section">
            <i class="fas fa-soap brand-icon"></i>
            <h1 class="brand-name">SICLEAN</h1>
            <p class="brand-tagline">Layanan Laundry Terpercaya</p>
        </div>

        <!-- Register Section -->
        <div class="login-section">
            <h2 class="login-title">DAFTAR AKUN</h2>

            @if (session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register.process') }}" class="form-container" id="registerForm">
                @csrf

                <div class="form-group">
                    <i class="fas fa-user form-icon"></i>
                    <input type="text"
                        class="form-control @error('name') is-invalid @enderror"
                        name="name"
                        placeholder="Nama Lengkap"
                        required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <i class="fas fa-envelope form-icon"></i>
                    <input type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        name="email"
                        placeholder="Email"
                        required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group password-group">
                    <i class="fas fa-lock form-icon"></i>
                    <input type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        id="password"
                        name="password"
                        placeholder="Password"
                        required>

                    <i class="fas fa-eye toggle-password" id="togglePassword"></i>

                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password Confirmation -->
                <div class="form-group password-group">
                    <i class="fas fa-lock form-icon"></i>
                    <input type="password"
                        class="form-control"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Konfirmasi Password"
                        required>

                    <i class="fas fa-eye toggle-password" id="togglePasswordConfirm"></i>
                </div>

                <button type="submit" class="btn btn-login">
                    <span class="btn-text">Daftar</span>
                </button>

                <div class="loading">
                    <span></span><span></span><span></span>
                </div>
            </form>

            <div class="register-link">
                Sudah mempunyai akun? <a href="{{ route('login') }}">Login</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            /* Smooth background */
            setTimeout(() => {
                document.body.style.backgroundColor = '#e2e8f0';
            }, 300);

            /* Prevent double submit */
            const form = document.getElementById('registerForm');
            if (form) {
                form.addEventListener('submit', function () {
                    this.classList.add('loading');
                    const btn = this.querySelector('button[type="submit"]');
                    if (btn) btn.disabled = true;
                });
            }

            /* Toggle password helper */
            function togglePassword(toggleId, inputId) {
                const toggle = document.getElementById(toggleId);
                const input  = document.getElementById(inputId);

                if (!toggle || !input) return;

                toggle.addEventListener('click', function () {
                    input.type = input.type === 'password' ? 'text' : 'password';
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            }

            togglePassword('togglePassword', 'password');
            togglePassword('togglePasswordConfirm', 'password_confirmation');
        });
    </script>
</body>


</html>
