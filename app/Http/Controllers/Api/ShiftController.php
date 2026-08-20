<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBukaShiftRequest;
use App\Repositories\ShiftRepository;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    use ApiResponse;

    protected $shiftRepo;

    public function __construct(ShiftRepository $shiftRepo)
    {
        $this->shiftRepo = $shiftRepo;
    }

    /**
     * Mengambil halaman manajemen shift
     */
    public function index(Request $request)
    {
        try {
            /** @var \App\Models\User $user */
        $user = $request->user();
            $bulan = $request->query('bulan');
            $tahun = $request->query('tahun');

            $data = $this->shiftRepo->getHalamanShift($user, $bulan, $tahun);

            return $this->successResponse($data, "Data shift berhasil dimuat");
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Membuka shift baru
     */
    public function buka(StoreBukaShiftRequest $request)
    {
        try {
            /** @var \App\Models\User $user */
        $user = $request->user();
            $saldo_awal = $request->saldo_awal;

            $shift = $this->shiftRepo->bukaShift($user, $saldo_awal);

            return $this->successResponse($shift, "Shift berhasil dibuka", 201);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Menampilkan ringkasan sebelum tutup shift
     */
    public function ringkasanTutup(Request $request)
    {
        try {
            /** @var \App\Models\User $user */
        $user = $request->user();
            $ringkasan = $this->shiftRepo->getRingkasanTutupShift($user);

            return $this->successResponse($ringkasan, "Ringkasan tutup shift berhasil dimuat");
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Menutup shift aktif
     */
    public function tutup(\App\Http\Requests\StoreTutupShiftRequest $request)
    {
        try {
            /** @var \App\Models\User $user */
        $user = $request->user();
            $data = $request->validated();
            
            $shift = $this->shiftRepo->tutupShift($user, $data);

            $msg = "Shift berhasil ditutup.";
            if ($shift->selisih < 0) {
                $msg .= " Peringatan: Terdapat selisih minus (tekor) sebesar Rp " . number_format(abs($shift->selisih), 0, ',', '.');
            } elseif ($shift->selisih > 0) {
                $msg .= " Catatan: Terdapat selisih lebih sebesar Rp " . number_format($shift->selisih, 0, ',', '.');
            }

            return $this->successResponse($shift, $msg);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }
}
