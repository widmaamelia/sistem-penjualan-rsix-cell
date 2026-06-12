<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\RiwayatRepository;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Exception;

class RiwayatController extends Controller
{
    use ApiResponse;

    protected $riwayatRepo;

    public function __construct(RiwayatRepository $riwayatRepo)
    {
        $this->riwayatRepo = $riwayatRepo;
    }

    /**
     * Menampilkan daftar riwayat transaksi
     */
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            
            // Ambil semua query parameters
            $filters = [
                'search' => $request->query('search'),
                'tanggal' => $request->query('tanggal'),
                'bulan' => $request->query('bulan'),
                'tahun' => $request->query('tahun'),
                'metode_bayar' => $request->query('metode_bayar') // 'semua', 'tunai', 'non-tunai'
            ];

            $data = $this->riwayatRepo->getRiwayat($user, $filters);

            return $this->successResponse($data, "Riwayat transaksi berhasil dimuat");
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Menampilkan detail spesifik sebuah transaksi (Struk)
     */
    public function show(Request $request, $id)
    {
        try {
            $user = $request->user();
            $data = $this->riwayatRepo->getDetailRiwayat($user, $id);

            return $this->successResponse($data, "Detail transaksi berhasil dimuat");
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }
}
