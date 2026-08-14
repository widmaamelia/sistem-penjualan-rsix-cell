<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request using OTP.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'otp' => ['required', 'numeric', 'digits:6'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Cek OTP di Cache
        $cachedOtp = Cache::get('otp_reset_' . $request->email);

        if (!$cachedOtp || $cachedOtp != $request->otp) {
            return back()->withInput($request->only('email'))
                         ->withErrors(['otp' => 'Kode OTP salah atau sudah kedaluwarsa.']);
        }

        // Ambil User
        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Update Password
            $user->forceFill([
                'password' => Hash::make($request->password),
                'remember_token' => Str::random(60),
            ])->save();

            event(new PasswordReset($user));
        }

        // Hapus cache OTP
        Cache::forget('otp_reset_' . $request->email);

        return redirect()->route('login')->with('status', 'Password berhasil direset. Silakan login.');
    }
}
