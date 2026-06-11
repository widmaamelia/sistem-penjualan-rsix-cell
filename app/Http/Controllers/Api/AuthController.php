<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Repositories\AuthRepository;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponse;

    protected $authRepo;

    public function __construct(AuthRepository $authRepo)
    {
        $this->authRepo = $authRepo;
    }

    public function login(LoginRequest $request)
    {
        try {
            $validated = $request->validated();

            // 1. Cari user di Repository (menggunakan email untuk project ini)
            $user = $this->authRepo->findByEmail($validated['email']);

            // 2. Cek apakah user ada dan password cocok
            if (!$user || !Hash::check($validated['password'], $user->password)) {
                return $this->unauthorizedResponse("Email atau password salah");
            }

            // 3. Cek apakah status user aktif
            if ($user->status !== 'aktif') {
                return $this->errorResponse("Akun anda dinonaktifkan. Silakan hubungi admin.", 403);
            }

            // 4. Buat Token Sanctum
            $token = $user->createToken('auth_token')->plainTextToken;

            // Load cabang data for mobile context if it exists
            $user->load('cabang');

            return $this->successResponse([
                'user' => $user,
                'token' => $token,
                'token_type' => 'Bearer'
            ], "Login Berhasil");
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = $request->user();

            // Cek dulu apakah usernya ada dan punya token aktif
            if ($user && $user->currentAccessToken()) {
                // Hapus token aktif untuk logout
                $user->currentAccessToken()->delete();
            }

            return $this->successResponse(null, "Logout Berhasil");
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
