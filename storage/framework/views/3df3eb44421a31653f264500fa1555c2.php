<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Password Baru - Rsix Cell</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        
        .reset-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .reset-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            max-width: 450px;
            width: 100%;
            padding: 40px;
            text-align: center;
        }

        .brand-logo {
            width: 90px;
            height: 90px;
            object-fit: contain;
            margin-bottom: 15px;
            mix-blend-mode: darken;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #4b5563;
            text-align: left;
            display: block;
        }

        .form-control {
            border: 1px solid #d1d5db;
            padding: 10px 14px;
            border-radius: 6px;
            font-size: 14px;
        }
        
        .form-control:focus {
            border-color: #1a5ca6;
            box-shadow: 0 0 0 0.25rem rgba(26, 92, 166, 0.25);
        }

        .btn-primary {
            background-color: #1a5ca6;
            border: none;
            font-weight: 600;
            padding: 10px;
            border-radius: 6px;
            width: 100%;
            margin-top: 15px;
        }

        .btn-primary:hover {
            background-color: #0F3A6B;
        }
        
        .error-message {
            color: #dc3545;
            font-size: 12px;
            text-align: left;
            margin-top: 4px;
            display: block;
        }
    </style>
</head>
<body>

<div class="reset-container">
    <div class="reset-card">
        <img src="<?php echo e(asset('logo.jpeg')); ?>" alt="Logo Rsix Cell" class="brand-logo">
        <h4 class="mb-2" style="font-weight: 700; color: #111827;">Buat Password Baru</h4>
        <p class="mb-4" style="font-size: 13.5px; color: #6b7280; line-height: 1.5;">
            Silakan masukkan email Anda beserta password baru yang ingin Anda gunakan.
        </p>

        <form method="POST" action="<?php echo e(route('password.store')); ?>" class="text-start">
            <?php echo csrf_field(); ?>
            
            <!-- Password Reset Token -->
            <!-- Token tidak diperlukan lagi karena kita pakai OTP via Cache -->

            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label">Email Anda</label>
                <input type="email" name="email" id="email" class="form-control" value="<?php echo e(old('email', session('email') ?? $request->email)); ?>" required readonly style="background-color: #f3f4f6;">
                <?php if($errors->has('email')): ?>
                    <span class="error-message"><i class="fa-solid fa-circle-exclamation"></i> <?php echo e($errors->first('email')); ?></span>
                <?php endif; ?>
            </div>

            <!-- OTP -->
            <div class="mb-3">
                <label for="otp" class="form-label">Kode OTP (Cek Email Anda)</label>
                <input type="text" name="otp" id="otp" class="form-control" required autofocus autocomplete="off" placeholder="Masukkan 6 digit angka OTP" maxlength="6" style="letter-spacing: 2px; font-weight: bold; text-align: center; font-size: 18px;">
                <?php if($errors->has('otp')): ?>
                    <span class="error-message"><i class="fa-solid fa-circle-exclamation"></i> <?php echo e($errors->first('otp')); ?></span>
                <?php endif; ?>
            </div>

            <!-- Password Baru -->
            <div class="mb-3">
                <label for="password" class="form-label">Password Baru</label>
                <input type="password" name="password" id="password" class="form-control" required autofocus autocomplete="new-password">
                <?php if($errors->has('password')): ?>
                    <span class="error-message"><i class="fa-solid fa-circle-exclamation"></i> <?php echo e($errors->first('password')); ?></span>
                <?php endif; ?>
            </div>

            <!-- Konfirmasi Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Ulangi Password Baru</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required autocomplete="new-password">
            </div>

            <button type="submit" class="btn btn-primary">
                Simpan & Login <i class="fa-solid fa-check ms-1"></i>
            </button>
        </form>
    </div>
</div>

</body>
</html>
<?php /**PATH D:\Semester_6\TUGAS AKHIR NGODING\sistem-penjualan-rsix-cell\resources\views/auth/reset-password.blade.php ENDPATH**/ ?>