<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKasKeluarRequest;
use App\Repositories\KasKeluarRepository;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;

class KasKeluarController extends Controller
{
    use ApiResponse;

    protected $kasKeluarRepo;

    public function __construct(KasKeluarRepository $kasKeluarRepo)
    {
        $this->kasKeluarRepo = $kasKeluarRepo;
    }

    /**
     * Menampilkan halaman Kas Keluar (Statistik & Daftar)
     */
    public function index(Request $request)
    {
        try {
            /** @var \App\Models\User $user */
        $user = $request->user();
            $data = $this->kasKeluarRepo->getHalamanKasKeluar($user);

            return $this->successResponse($data, "Data kas keluar berhasil dimuat");
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Menambahkan data Kas Keluar baru
     */
    public function store(StoreKasKeluarRequest $request)
    {
        try {
            /** @var \App\Models\User $user */
        $user = $request->user();
            $validatedData = $request->validated();

            $kasKeluarBaru = $this->kasKeluarRepo->tambahKasKeluar($user, $validatedData);

            return $this->successResponse($kasKeluarBaru, "Data kas keluar berhasil ditambahkan", 201);
        } catch (Exception $e) {
            // Biasanya masuk sini karena validasi shift aktif gagal
            return $this->errorResponse($e->getMessage(), 400);
        }
    }
}
