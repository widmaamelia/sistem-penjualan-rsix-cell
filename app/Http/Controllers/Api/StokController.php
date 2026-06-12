<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\StokRepository;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;

class StokController extends Controller
{
    use ApiResponse;

    protected $stokRepo;

    public function __construct(StokRepository $stokRepo)
    {
        $this->stokRepo = $stokRepo;
    }

    public function index(Request $request)
    {
        try {
            $user = $request->user();
            
            // Ambil parameter pencarian dan filter dari URL
            $search = $request->query('search', null);
            $filter = $request->query('filter', 'semua');

            $data = $this->stokRepo->getHalamanStok($user, $search, $filter);

            return $this->successResponse($data, "Data stok berhasil dimuat");
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
