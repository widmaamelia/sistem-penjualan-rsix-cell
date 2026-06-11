<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\DashboardRepository;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use ApiResponse;

    protected $dashboardRepo;

    public function __construct(DashboardRepository $dashboardRepo)
    {
        $this->dashboardRepo = $dashboardRepo;
    }

    public function index(Request $request)
    {
        try {
            // Ambil data user yang sedang login beserta relasi cabangnya
            $user = $request->user()->load('cabang');

            $data = $this->dashboardRepo->getDashboardData($user);

            return $this->successResponse($data, "Data dashboard berhasil dimuat");
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
