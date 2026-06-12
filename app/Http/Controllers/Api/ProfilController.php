<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfilRequest;
use App\Http\Requests\UbahPasswordRequest;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Hash;
use Exception;

class ProfilController extends Controller
{
    use ApiResponse;

    /**
     * Memperbarui profil dasar pengguna (Nama & Email)
     */
    public function updateProfil(UpdateProfilRequest $request)
    {
        try {
            $user = $request->user();
            $data = $request->validated();

            $user->update([
                'name' => $data['name'],
                'email' => $data['email']
            ]);

            return $this->successResponse($user->load('cabang'), "Profil berhasil diperbarui.");
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Memperbarui kata sandi (Password)
     */
    public function ubahPassword(UbahPasswordRequest $request)
    {
        try {
            $user = $request->user();
            $data = $request->validated();

            // Cek apakah password lama sesuai
            if (!Hash::check($data['password_lama'], $user->password)) {
                return $this->errorResponse("Password lama yang Anda masukkan salah.", 400);
            }

            // Update password baru
            $user->update([
                'password' => Hash::make($data['password_baru'])
            ]);

            return $this->successResponse(null, "Password berhasil diubah. Silakan gunakan password baru pada sesi login berikutnya.");
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }
}
