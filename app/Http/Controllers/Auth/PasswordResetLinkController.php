<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\OtpMail;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request (Generate & Send OTP).
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            // Biarkan pura-pura sukses demi keamanan (mencegah enumerasi email)
            // Atau berikan error jika ingin user tau emailnya salah. Kita kasih error saja.
            return back()->withInput($request->only('email'))
                         ->withErrors(['email' => 'Email tidak ditemukan dalam sistem.']);
        }

        // Generate 6 digit OTP
        $otp = rand(100000, 999999);

        // Simpan OTP di Cache selama 15 menit, dengan key email
        Cache::put('otp_reset_' . $user->email, $otp, now()->addMinutes(15));

        // Kirim Email OTP
        try {
            Mail::to($user->email)->send(new OtpMail($otp));
        } catch (\Exception $e) {
            return back()->withInput($request->only('email'))
                         ->withErrors(['email' => 'Gagal mengirim email OTP. Pastikan SMTP dikonfigurasi dengan benar.']);
        }

        // Arahkan ke halaman reset password dengan membawa email
        return redirect()->route('password.reset', [
            'token' => 'otp', 
            'email' => $request->email
        ])->with('status', 'Kode OTP telah dikirim ke email Anda.');
    }
}
