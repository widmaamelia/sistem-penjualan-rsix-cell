<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Cabang;
use App\Models\StokCabang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokController extends Controller
{
    public function index(Request $request)
    {
        $cabangs = Cabang::where('status', 'aktif')->get();
        /** @var \App\Models\User $user */
        $user = \Illuminate\Support\Facades\Auth::user();

        if ($user->role === 'admin cabang') {
            $id_cabang = $user->id_cabang;
        } else {
            $id_cabang = $request->input('id_cabang'); // Filter by branch
        }
        $search = $request->input('search');
        $status_stok = $request->input('status_stok');

        // Query dasar dari Produk
        $query = Produk::with(['kategori', 'stokCabangs' => function ($q) use ($id_cabang) {
            if ($id_cabang) {
                $q->where('id_cabang', $id_cabang);
            }
        }]);

        // Filter Status Stok
        if ($status_stok) {
            if ($id_cabang) {
                $query->whereHas('stokCabangs', function($q) use ($id_cabang, $status_stok) {
                    $q->where('id_cabang', $id_cabang);
                    if ($status_stok == 'habis') {
                        $q->where('stok_sekarang', '<=', 0);
                    } elseif ($status_stok == 'rendah') {
                        $q->whereColumn('stok_sekarang', '<=', 'stok_minimum')->where('stok_sekarang', '>', 0);
                    } elseif ($status_stok == 'aman') {
                        $q->whereColumn('stok_sekarang', '>', 'stok_minimum');
                    }
                });
            } else {
                $query->whereIn('id_produk', function($q) use ($status_stok) {
                    $q->select('id_produk')
                      ->from('stok_cabangs')
                      ->groupBy('id_produk');
                      
                    if ($status_stok == 'habis') {
                        $q->havingRaw('SUM(stok_sekarang) <= 0');
                    } elseif ($status_stok == 'rendah') {
                        $q->havingRaw('SUM(stok_sekarang) > 0 AND SUM(stok_sekarang) <= MAX(stok_minimum)');
                    } elseif ($status_stok == 'aman') {
                        $q->havingRaw('SUM(stok_sekarang) > MAX(stok_minimum)');
                    }
                });
            }
        }

        // Filter search (SKU atau Nama)
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_produk', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        $produks = $query->orderBy('id_produk', 'desc')->paginate(10)->withQueryString();

        // Calculate summaries based on current filter (not just paginated items)
        $totalProduk = 0;
        $stokRendah = 0;
        $stokHabis = 0;

        if ($id_cabang) {
            // Summary untuk cabang spesifik
            $totalProduk = StokCabang::where('id_cabang', $id_cabang)->count();
            $stokRendah = StokCabang::where('id_cabang', $id_cabang)
                                     ->whereColumn('stok_sekarang', '<=', 'stok_minimum')
                                     ->where('stok_sekarang', '>', 0)
                                     ->count();
            $stokHabis = StokCabang::where('id_cabang', $id_cabang)->where('stok_sekarang', '<=', 0)->count();
        } else {
            // Summary untuk seluruh cabang secara agregat
            $totalProduk = Produk::count();
            
            // Hitung agregat per produk
            $agregatStok = StokCabang::select('id_produk', DB::raw('SUM(stok_sekarang) as total_stok'), DB::raw('MAX(stok_minimum) as max_min'))
                                      ->groupBy('id_produk')
                                      ->get();
            
            foreach ($agregatStok as $stok) {
                if ($stok->total_stok <= 0) {
                    $stokHabis++;
                } elseif ($stok->total_stok <= $stok->max_min) {
                    // Kita anggap rendah jika total stok <= max stok_minimum dari cabang-cabangnya
                    $stokRendah++;
                }
            }
        }

        return view('admin.stok.index', compact('produks', 'cabangs', 'id_cabang', 'totalProduk', 'stokRendah', 'stokHabis', 'search', 'status_stok'));
    }

    public function edit($id)
    {
        // Future feature: Edit manual stock
        return redirect()->back()->with('error', 'Fitur Edit Stok sedang dalam tahap pengembangan.');
    }

    public function history(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);
        /** @var \App\Models\User $user */
        $user = \Illuminate\Support\Facades\Auth::user();
        
        $query = \App\Models\LogManajemenStok::with(['cabang', 'user'])
                    ->where('id_produk', $id)
                    ->orderBy('created_at', 'desc');

        if ($user->role === 'admin cabang') {
            $query->where('id_cabang', $user->id_cabang);
        } elseif ($user->role === 'super' && $request->filled('id_cabang')) {
            $query->where('id_cabang', $request->id_cabang);
        }

        $logs = $query->paginate(15)->withQueryString();
        
        $cabangs = Cabang::where('status', 'aktif')->get();

        return view('admin.stok.history', compact('produk', 'logs', 'cabangs'));
    }

    public function tambahForm()
    {
        /** @var \App\Models\User $user */
        $user = \Illuminate\Support\Facades\Auth::user();
        if (!in_array($user->role, ['super', 'admin cabang'])) {
            return redirect()->route('stok.index')->with('error', 'Akses ditolak.');
        }

        if ($user->role === 'admin cabang' && !$user->id_cabang) {
            return redirect()->route('stok.index')->with('error', 'Akun Anda tidak terikat dengan cabang manapun.');
        }

        $produks = Produk::where('status', 'aktif')->orderBy('nama_produk', 'asc')->get();
        $cabangs = Cabang::where('status', 'aktif')->get();

        return view('admin.stok.tambah', compact('produks', 'cabangs'));
    }

    public function tambahProses(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = \Illuminate\Support\Facades\Auth::user();
        if (!in_array($user->role, ['super', 'admin cabang'])) {
            return redirect()->route('stok.index')->with('error', 'Akses ditolak.');
        }

        $rules = [
            'items' => 'required|array|min:1',
            'items.*.id_produk' => 'required|exists:produks,id_produk',
            'items.*.qty_tambah' => 'required|numeric|min:1',
            'items.*.harga_beli' => 'required|numeric|min:0',
        ];

        if ($user->role === 'super') {
            $rules['id_cabang'] = 'required|exists:cabangs,id_cabang';
        }

        $request->validate($rules);

        $id_cabang = $user->role === 'super' ? $request->id_cabang : $user->id_cabang;

        try {
            DB::beginTransaction();

            $totalKasKeluar = 0;
            $detailRestock = [];

            foreach ($request->items as $item) {
                $produk = Produk::findOrFail($item['id_produk']);

                // 1. Update stok cabang
                $stokCabang = StokCabang::firstOrCreate(
                    ['id_cabang' => $id_cabang, 'id_produk' => $item['id_produk']],
                    ['stok_sekarang' => 0, 'stok_minimum' => 5, 'stok_maksimum' => 100]
                );

                $stokSebelum = $stokCabang->stok_sekarang;
                $stokCabang->stok_sekarang += (int) $item['qty_tambah'];
                $stokCabang->save();

                // 2. Log mutasi stok
                \App\Models\LogManajemenStok::create([
                    'id_cabang' => $id_cabang,
                    'id_produk' => $item['id_produk'],
                    'id_user' => $user->id_user,
                    'qty' => $item['qty_tambah'],
                    'jenis_transaksi' => 'masuk',
                    'stok_sebelum' => $stokSebelum,
                    'stok_sesudah' => $stokCabang->stok_sekarang,
                    'keterangan' => 'Restock / Tambah Stok',
                    'tanggal' => date('Y-m-d')
                ]);

                // 3. Log & Update harga beli jika berubah
                if ($produk->harga_beli != $item['harga_beli']) {
                    $hargaBeliLama = $produk->harga_beli;
                    $produk->harga_beli = $item['harga_beli'];
                    $produk->save();

                    \App\Models\LogPerubahanHarga::create([
                        'id_produk' => $produk->id_produk,
                        'id_user' => $user->id_user,
                        'harga_beli_lama' => $hargaBeliLama,
                        'harga_beli_baru' => $item['harga_beli'],
                        'tanggal' => date('Y-m-d H:i:s'),
                    ]);
                }

                // 4. Hitung kas keluar
                $totalKasKeluar += $item['qty_tambah'] * $item['harga_beli'];
                $detailRestock[] = $item['qty_tambah'] . 'x ' . $produk->nama_produk;
            }

            // 5. Catat ke Kas Keluar
            if ($totalKasKeluar > 0) {
                $activeShift = \App\Models\Shift::where('id_user', $user->id_user)
                                                ->where('id_cabang', $id_cabang)
                                                ->where('status', 'buka')
                                                ->first();

                $keteranganStr = 'Pembelian Stok Barang (Restock): ' . implode(', ', $detailRestock);
                if (strlen($keteranganStr) > 255) {
                    $keteranganStr = substr($keteranganStr, 0, 252) . '...';
                }

                \App\Models\KasKeluar::create([
                    'id_shift' => $activeShift ? $activeShift->id_shift : null,
                    'id_cabang' => $id_cabang,
                    'jumlah_pengeluaran' => $totalKasKeluar,
                    'keterangan' => $keteranganStr,
                    'tanggal' => date('Y-m-d H:i:s')
                ]);
            }

            DB::commit();
            return redirect()->route('stok.index')->with('success', 'Stok berhasil ditambahkan dan pengeluaran kas dicatat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambah stok: ' . $e->getMessage())->withInput();
        }
    }
}
