<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SICLEAN</title>
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
            padding: 20px;
        }

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

        .register-card {
            width: 100%;
            max-width: 1000px;
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

        .brand-side {
            width: 35%; /* Lebih kecil untuk pendaftaran */
            background: linear-gradient(135deg, #0284c7 0%, #38bdf8 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            color: white;
            position: relative;
        }

        .brand-logo {
            width: 110px;
            height: auto;
            margin-bottom: 20px;
        }

        .brand-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .form-side {
            width: 65%;
            padding: 45px;
            background: rgba(255, 255, 255, 0.4);
        }

        .welcome-text h2 {
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 8px;
        }

        .welcome-text p {
            color: var(--text-muted);
            margin-bottom: 30px;
            font-size: 15px;
        }

        .input-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-main);
            font-size: 13px;
            margin-bottom: 6px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            transition: color 0.3s;
        }

        .form-control {
            height: 48px;
            padding-left: 45px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            background: rgba(255, 255, 255, 0.8);
        }

        .form-control:focus {
            background: #fff;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        .btn-primary {
            height: 50px;
            background: var(--primary-color);
            border: none;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
        }

        .footer-link {
            text-align: center;
            margin-top: 24px;
            font-size: 14px;
            color: var(--text-muted);
        }

        .footer-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }

        @media (max-width: 900px) {
            .register-card { flex-direction: column; max-width: 450px; }
            .brand-side { width: 100%; min-height: 150px; padding: 20px; }
            .form-side { width: 100%; padding: 30px; }
            .input-grid { grid-template-columns: 1fr; gap: 0; }
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--text-muted);
        }
    </style>
</head>
<body>
    <div class="mesh-bg"></div>
    
    <div class="register-card">
        <!-- Brand Side -->
        <div class="brand-side">
            <img src="{{ asset('sbadmin2/img/logoL2.png') }}" alt="SICLEAN" class="brand-logo">
            <h1 class="brand-title">SICLEAN</h1>
            <p style="font-size: 13px; text-align: center; opacity: 0.8;">Bergabunglah dengan komunitas kebersihan kami.</p>
        </div>
        
        <!-- Form Side -->
        <div class="form-side">
            <div class="welcome-text">
                <h2>Daftar Akun</h2>
                <p>Buat akun baru SICLEAN untuk mulai berlangganan.</p>
            </div>
            
            <form method="POST" action="{{ route('register.process') }}" id="registerForm">
                @csrf
                
                <div class="input-grid">
                    <div>
                        <label class="form-label">Nama Lengkap</label>
                        <div class="input-wrapper">
                            <i class="far fa-user input-icon"></i>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   placeholder="John Doe" value="{{ old('name') }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Email Address</label>
                        <div class="input-wrapper">
                            <i class="far fa-envelope input-icon"></i>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   placeholder="name@example.com" value="{{ old('email') }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="input-grid">
                    <div>
                        <label class="form-label">Kota / Alamat</label>
                        <div class="input-wrapper">
                            <i class="far fa-map-marker-alt input-icon"></i>
                            <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror" 
                                   placeholder="Alamat Lengkap" value="{{ old('alamat') }}" required>
                            @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div>
                        <label class="form-label">No Telepon</label>
                        <div class="input-wrapper">
                            <i class="far fa-phone input-icon"></i>
                            <input type="text" name="telepon" class="form-control @error('telepon') is-invalid @enderror" 
                                   placeholder="0812xxxx" value="{{ old('telepon') }}" required>
                            @error('telepon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
                
                <div class="input-grid">
                    <div>
                        <label class="form-label">Password</label>
                        <div class="input-wrapper">
                            <i class="far fa-lock input-icon"></i>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" 
                                   placeholder="••••••••" required>
                            <i class="far fa-eye-slash password-toggle" onclick="togglePass('password')"></i>
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Konfirmasi</label>
                        <div class="input-wrapper">
                            <i class="far fa-lock input-icon"></i>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" 
                                   placeholder="••••••••" required>
                            <i class="far fa-eye-slash password-toggle" onclick="togglePass('password_confirmation')"></i>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary w-100 mt-2">Daftar Sekarang</button>
            </form>
            
            <div class="footer-link">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk Disini</a>
            </div>
        </div>
    </div>
    
    <script>
        function togglePass(id) {
            const input = document.getElementById(id);
            const icon = input.nextElementSibling;
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        }
        
        document.getElementById('registerForm').addEventListener('submit', function() {
            const btn = this.querySelector('button[type="submit"]');
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';
            btn.disabled = true;
        });
    </script>
</body>
</html>
