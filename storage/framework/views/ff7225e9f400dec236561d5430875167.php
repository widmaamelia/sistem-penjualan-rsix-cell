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
            background-color: #1a5ca6; /* Dark blue background for mobile */
        }

        .split-screen {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* Bagian Kiri (Putih) */
        .left-side {
            background-color: #ffffff;
            color: #1a5ca6;
            flex: 1.15;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 50px;
            position: relative;
            z-index: 2;
            clip-path: polygon(0 0, 100% 0, calc(100% - 150px) 100%, 0 100%);
        }



        .brand-center {
            text-align: center;
            z-index: 5;
            transform: translateX(-50px); /* Geser ke kiri untuk menyeimbangkan potongan miring di kanan */
        }

        .brand-center img {
            width: 140px;
            height: 140px;
            object-fit: contain;
            margin-bottom: 20px;
            mix-blend-mode: darken;
        }

        .brand-center h2 {
            font-weight: 800;
            font-size: 32px;
            letter-spacing: 1.5px;
            margin-bottom: 5px;
            color: #1a5ca6;
        }

        .brand-center p {
            font-size: 15px;
            font-weight: 500;
            color: #4b5563;
        }

        /* Bagian Kanan (Biru Gelap) */
        .right-side {
            flex: 1.25;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 50px 8%;
            background-color: #1a5ca6;
            color: #ffffff;
            position: relative;
            z-index: 1;
        }

        .login-box {
            max-width: 360px;
            margin: 0 auto;
            width: 100%;
            z-index: 5;
        }

        /* Form Labels & Text */
        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #ffffff;
            letter-spacing: 0.3px;
        }

        .input-group {
            margin-bottom: 15px;
            border-radius: 6px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .input-group-text {
            background-color: #ffffff;
            border: none;
            color: #6b7280;
            padding: 10px 14px;
            border-radius: 6px 0 0 6px;
        }

        .form-control {
            border: none;
            padding: 10px 14px;
            background-color: #ffffff;
            color: #111827;
            border-radius: 0 6px 6px 0;
            box-shadow: none !important;
        }

        .form-control::placeholder {
            color: #9ca3af;
            font-size: 13px;
        }
        
        .input-group .input-group-text:last-child {
            border-radius: 0 6px 6px 0;
            border-left: 1px solid #f3f4f6;
        }
        .input-group .form-control:not(:last-child) {
            border-radius: 0;
        }

        /* Button */
        .btn-login {
            background-color: #0b2559; /* Biru Sangat Gelap */
            border: none;
            color: #ffffff; /* Teks Putih */
            font-weight: 700;
            padding: 11px;
            width: 100%;
            border-radius: 6px;
            margin-top: 5px;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
        }

        .btn-login:hover {
            background-color: #051438;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            color: #ffffff;
        }

        .version-text {
            position: absolute;
            bottom: 20px;
            right: 30px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.5);
        }
        
        .forgot-link {
            color: #93c5fd; /* Light Blue, contrast against dark blue bg */
            text-decoration: none;
            font-size: 13px;
        }

        .forgot-link:hover {
            color: #ffffff;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .split-screen {
                flex-direction: column;
                overflow: auto;
            }
            .left-side {
                padding: 50px 20px;
                flex: none;
                border-bottom-left-radius: 30px;
                border-bottom-right-radius: 30px;
                box-shadow: 0 4px 20px rgba(0,0,0,0.1);
                z-index: 10;
                clip-path: none;
            }
            .brand-center {
                transform: none;
            }
            .brand-center img {
                width: 100px;
                height: 100px;
            }
            .brand-center h2 {
                font-size: 26px;
            }
            .right-side {
                padding: 50px 20px;
                flex: 1;
            }
            .mobile-splash.active {
                display: flex;
                opacity: 1;
                visibility: visible;
            }
            .mobile-splash.fade-out {
                opacity: 0;
                visibility: hidden;
            }
        }

        /* Splash Screen Mobile Style */
        .mobile-splash {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: #1a5ca6;
            z-index: 9999;
            justify-content: center;
            align-items: center;
            transition: opacity 0.6s ease-out, visibility 0.6s ease-out;
        }

        .mobile-splash img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>
<body>

<!-- Splash Screen Khusus Mobile -->
<div class="mobile-splash active" id="splashScreen">
    <img src="<?php echo e(asset('upload.png')); ?>" alt="Splash Screen Rsix Cell">
</div>

<div class="split-screen">
    
    <!-- Bagian Kiri -->
    <div class="left-side">
        <div class="brand-center">
            <img src="<?php echo e(asset('logo_rsix.png')); ?>" alt="Logo Rsix Cell">
            <h2 class="text-uppercase">RSIX CELL</h2>
            <p class="fst-italic">Sistem Manajemen Toko Terpadu</p>
        </div>
    </div>

    <!-- Bagian Kanan -->
    <div class="right-side">
        <div class="login-box">
            <form method="POST" action="<?php echo e(route('login')); ?>">
                <?php echo csrf_field(); ?>

                <!-- Pesan Error Global -->
                <?php if($errors->any()): ?>
                    <p class="text-white mb-3 p-2 rounded" style="font-size: 13.5px; font-weight: 500; background-color: rgba(239, 68, 68, 0.9);">
                        <i class="fa-solid fa-circle-exclamation me-1"></i> Email  atau Password yang Anda masukkan salah.
                    </p>
                <?php endif; ?>

                <!-- Email -->
                <div>
                    <label class="form-label">Email</label>
                    <div class="input-group">
                        <input type="email" name="email" class="form-control" style="border-radius: 6px;" placeholder="Masukkan email atau username" value="<?php echo e(old('email')); ?>" required autofocus autocomplete="username" oninvalid="this.setCustomValidity('Kolom ini wajib diisi')" oninput="this.setCustomValidity('')">
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <label class="form-label mb-0">Password</label>
                        <a href="<?php echo e(route('password.request')); ?>" class="forgot-link text-decoration-none" style="font-size: 12px; font-weight: 600;">Lupa Password?</a>
                    </div>
                    <div class="input-group mt-1">
                        <input type="password" name="password" id="passwordInput" class="form-control" placeholder="Masukkan password" required autocomplete="current-password" oninvalid="this.setCustomValidity('Kolom ini wajib diisi')" oninput="this.setCustomValidity('')">
                        <span class="input-group-text" style="cursor: pointer;" onclick="togglePassword()">
                            <i class="fa-regular fa-eye" id="eyeIcon"></i>
                        </span>
                    </div>
                </div>
                
                
                <!-- Tombol Login -->
                <button type="submit" class="btn btn-login mt-2">
                    MASUK
                </button>
            </form>
        </div>

        <div class="version-text">Widma Amelia</div>
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

    // Animasi Splash Screen Khusus Mobile
    document.addEventListener("DOMContentLoaded", function() {
        const splashScreen = document.getElementById('splashScreen');
        
        if (splashScreen) {
            // Jalankan timer tanpa syarat, agar jika user me-resize layar ke mobile di inspect element,
            // splash screen tidak menyangkut (stuck) selamanya.
            setTimeout(() => {
                splashScreen.classList.remove('active');
                splashScreen.classList.add('fade-out');
                
                // Hapus total dari pandangan setelah animasi pudar selesai
                setTimeout(() => {
                    splashScreen.style.display = 'none';
                }, 600); 
            }, 2500); // Waktu tampil 2.5 detik
        }
    });
</script>
</body>
</html>
<?php /**PATH D:\Semester_6\TUGAS AKHIR NGODING\sistem-penjualan-rsix-cell\resources\views/auth/login.blade.php ENDPATH**/ ?>