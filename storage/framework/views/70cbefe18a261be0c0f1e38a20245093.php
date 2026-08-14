<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 500px;
            margin: auto;
            text-align: center;
        }
        .otp-code {
            font-size: 32px;
            font-weight: bold;
            color: #1a5ca6;
            letter-spacing: 5px;
            margin: 20px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
            border: 1px dashed #1a5ca6;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 style="color: #333;">Permintaan Reset Password</h2>
        <p style="color: #555; line-height: 1.5;">Anda menerima email ini karena kami menerima permintaan reset password untuk akun Rsix Cell Anda.</p>
        <p style="color: #555;">Berikut adalah kode OTP rahasia Anda:</p>
        
        <div class="otp-code"><?php echo e($otp); ?></div>
        
        <p style="color: #d9534f; font-size: 13px;">Kode ini hanya berlaku selama 15 menit. Jangan berikan kode ini kepada siapapun.</p>
        
        <div class="footer">
            &copy; <?php echo e(date('Y')); ?> Sistem Manajemen Rsix Cell. All rights reserved.
        </div>
    </div>
</body>
</html>
<?php /**PATH D:\Semester_6\TUGAS AKHIR NGODING\sistem-penjualan-rsix-cell\resources\views/emails/otp.blade.php ENDPATH**/ ?>