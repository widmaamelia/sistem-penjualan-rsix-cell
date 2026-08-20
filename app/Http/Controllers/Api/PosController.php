<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCheckoutRequest;
use App\Repositories\PosRepository;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;

class PosController extends Controller
{
    use ApiResponse;

    protected $posRepo;

    public function __construct(PosRepository $posRepo)
    {
        $this->posRepo = $posRepo;
    }

    /**
     * Menampilkan daftar produk fisik untuk POS
     */
    public function produk(Request $request)
    {
        try {
            /** @var \App\Models\User $user */
        $user = $request->user();
            $search = $request->query('search');
            $kategori = $request->query('kategori');

            $data = $this->posRepo->getProdukPos($user, $search, $kategori);

            return $this->successResponse($data, "Data produk POS berhasil dimuat");
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function kategori()
    {
        try {
            $kategori = \App\Models\KategoriProduk::select('id_kategori', 'nama_kategori')->get();
            return $this->successResponse($kategori, "Data kategori berhasil dimuat");
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Memproses keranjang belanja kasir
     */
    public function checkout(StoreCheckoutRequest $request)
    {
        try {
            /** @var \App\Models\User $user */
        $user = $request->user();
            $data = $request->validated();
            
            $result = $this->posRepo->prosesCheckout($user, $data);

            return $this->successResponse($result, "Transaksi berhasil diproses!", 201);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }
}
