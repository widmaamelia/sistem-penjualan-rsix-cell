<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Rsix Cell</title>
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
        
        .back-link {
            color: #6b7280;
            font-size: 13px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            transition: color 0.3s;
        }

        .back-link:hover {
            color: #1a5ca6;
        }
    </style>
</head>
<body>

<div class="reset-container">
    <div class="reset-card">
        <img src="{{ asset('logo.jpeg') }}" alt="Logo Rsix Cell" class="brand-logo">
        <h4 class="mb-2" style="font-weight: 700; color: #111827;">Lupa Password?</h4>
        <p class="mb-4" style="font-size: 13.5px; color: #6b7280; line-height: 1.5;">
            Jangan khawatir. Masukkan email Anda yang terdaftar dan kami akan mengirimkan link untuk mereset password Anda.
        </p>

        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success mb-4" style="font-size: 13px; font-weight: 500;">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="text-start">
            @csrf
            
            @if ($errors->any())
                <div class="alert alert-danger mb-3 p-2" style="font-size: 13px;">
                    Email tidak ditemukan dalam sistem.
                </div>
            @endif

            <div class="mb-3">
                <label for="email" class="form-label">Alamat Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="Contoh: admin@rsixcell.com" required autofocus>
            </div>

            <button type="submit" class="btn btn-primary">
                Kirim Link Reset Password <i class="fa-solid fa-paper-plane ms-1"></i>
            </button>
        </form>

        <a href="{{ route('login') }}" class="back-link">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Halaman Login
        </a>
    </div>
</div>

</body>
</html>
