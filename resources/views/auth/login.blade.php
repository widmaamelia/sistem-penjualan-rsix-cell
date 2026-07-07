<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Rsix Cell</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome untuk Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
        }

        .split-screen {
            display: flex;
            height: 100vh;
        }

        /* Bagian Kiri (Biru) */
        .left-side {
            background-color: #1a5ca6; /* Biru pekat sesuai desain */
            color: white;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 50px;
            position: relative;
            overflow: hidden;
        }

        .brand-container {
            position: absolute;
            top: 40px;
            left: 50px;
            z-index: 2;
        }

        .brand-container h2 {
            font-weight: 700;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .brand-icon {
            background: white;
            color: #1a5ca6;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 20px;
        }

        .brand-container p {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.8);
        }

        .illustration-container {
            margin: auto;
            position: relative;
            z-index: 1;
            /* Efek Glassmorphism di sekitar gambar */
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 15px;
            max-width: 55%; /* Diperkecil agar gambar tidak mendominasi */
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
        }

        .illustration-container img {
            width: 100%;
            border-radius: 15px;
            mix-blend-mode: luminosity; /* Memberikan efek kebiruan yang menyatu dengan background */
            opacity: 0.9;
        }

        /* Pagination Dots */
        .dots {
            position: absolute;
            bottom: 40px;
            left: 50px;
            display: flex;
            gap: 8px;
        }
        .dot {
            width: 20px;
            height: 3px;
            background: rgba(255,255,255,0.4);
            border-radius: 2px;
        }
        .dot.active {
            width: 40px;
            background: white;
        }


        /* Bagian Kanan (Form Login) */
        .right-side {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 50px 10%;
            background-color: #ffffff;
            position: relative;
        }

        .login-box {
            max-width: 400px;
            margin: 0 auto;
            width: 100%;
        }

        .login-box h3 {
            font-weight: 700;
            color: #111827;
            margin-bottom: 5px;
        }

        .login-box p {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #4b5563;
        }

        .input-group-text {
            background-color: transparent;
            border-right: none;
            color: #6b7280;
        }

        .form-control {
            border-left: none;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #dee2e6;
        }
        
        /* Memastikan border input group tetap konsisten saat focus */
        .input-group:focus-within .input-group-text,
        .input-group:focus-within .form-control {
            border-color: #1a5ca6;
        }

        .btn-login {
            background-color: #1a5ca6;
            border-color: #1a5ca6;
            color: white;
            font-weight: 600;
            padding: 12px;
            width: 100%;
            border-radius: 8px;
            margin-top: 15px;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background-color: #154a85;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(26, 92, 166, 0.3);
        }

        .forgot-link {
            color: #1a5ca6;
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        .version-text {
            position: absolute;
            bottom: 20px;
            right: 30px;
            font-size: 12px;
            color: #9ca3af;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .split-screen {
                flex-direction: column;
            }
            .left-side {
                display: none; /* Sembunyikan gambar di layar kecil agar fokus ke login */
            }
            .right-side {
                padding: 30px;
            }
        }
    </style>
</head>
<body>

<div class="split-screen">
    
    <!-- Bagian Kiri -->
    <div class="left-side">
        <div class="brand-container">
            <h2>
                <div class="brand-icon"><i class="fa-solid fa-tower-cell"></i></div>
                Rsix Cell
            </h2>
            <p>Sistem Manajemen Toko Terpadu</p>
        </div>

        <div class="illustration-container">
            <!-- TEMPAT GAMBAR MILIK ANDA -->
            <!-- Ganti 'images/login-illustration.png' dengan path gambar asli Anda nantinya -->
            <!-- Atau bisa juga langsung pakai link gambar online -->
            <img src="https://images.unsplash.com/photo-1611791484670-ce19b801d192?q=80&w=600&auto=format&fit=crop" alt="Rsix Cell Illustration" onerror="this.src='https://via.placeholder.com/600x600/1a5ca6/ffffff?text=Gambar+Anda+Disini'">
        </div>

        <div class="dots">
            <div class="dot active"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
    </div>

    <!-- Bagian Kanan -->
    <div class="right-side">
        <div class="login-box">
            <h3>Masuk ke Sistem</h3>
            <p>Silakan masukkan akun Anda untuk melanjutkan akses.</p>

            <!-- Form bawaan Laravel Breeze -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Pesan Error Global -->
                @if ($errors->any())
                    <div class="alert alert-danger" style="font-size: 13px; padding: 10px;">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label">Email atau Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-regular fa-user"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="nama@email.com" value="{{ old('email') }}" required autofocus autocomplete="username">
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" name="password" id="passwordInput" class="form-control" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" required autocomplete="current-password">
                        <span class="input-group-text" style="cursor: pointer; border-left: none; border-right: 1px solid #dee2e6;" onclick="togglePassword()">
                            <i class="fa-regular fa-eye" id="eyeIcon"></i>
                        </span>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                        <label class="form-check-label" for="rememberMe" style="font-size: 13px; color: #4b5563;">
                            Ingat Saya
                        </label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Lupa Password?</a>
                    @endif
                </div>

                <!-- Tombol Login -->
                <button type="submit" class="btn btn-login">
                    Masuk <i class="fa-solid fa-arrow-right-to-bracket ms-1"></i>
                </button>

                <!-- Bantuan -->
                <div class="text-center mt-4">
                    <span style="font-size: 13px; color: #6b7280;">Belum punya akun? <a href="#" style="color: #1a5ca6; text-decoration: none;">Hubungi Admin</a></span>
                </div>
            </form>
        </div>

        <div class="version-text">v1.0.0</div>
    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.css"></script>
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('passwordInput');
        const eyeIcon = document.getElementById('eyeIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    }
</script>
</body>
</html>
