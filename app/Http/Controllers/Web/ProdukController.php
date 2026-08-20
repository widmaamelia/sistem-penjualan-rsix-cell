<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Produk;
use App\Models\Cabang;
use App\Models\KategoriProduk;
use App\Models\StokCabang;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
    public function printBarcode($id)
    {
        $produk = Produk::findOrFail($id);
        return view('admin.produk.print_barcode', compact('produk'));
    }

    public function printMassalBarcode(Request $request)
    {
        $produksCetak = collect();

        if ($request->filled('items')) {
            // Format: [{"id": 1, "qty": 10}, {"id": 2, "qty": 5}]
            $items = json_decode($request->items, true);
            
            if (is_array($items)) {
                foreach ($items as $item) {
                    $produk = Produk::find($item['id']);
                    if ($produk) {
                        $qty = isset($item['qty']) ? (int)$item['qty'] : 1;
                        for ($i = 0; $i < $qty; $i++) {
                            $produksCetak->push($produk);
                        }
                    }
                }
            }
        } else {
            // Fallback: cetak semua sesuai filter (masing-masing 1)
            $query = Produk::query();
            
            if ($request->filled('search')) {
                $query->where(function($q) use ($request) {
                    $q->where('nama_produk', 'like', '%' . $request->search . '%')
                      ->orWhere('sku', 'like', '%' . $request->search . '%')
                      ->orWhere('barcode_imei', 'like', '%' . $request->search . '%');
                });
            }

            if ($request->filled('kategori')) {
                $query->where('id_kategori', $request->kategori);
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            $produksCetak = $query->orderBy('id_produk', 'desc')->get();
        }

        return view('admin.produk.print_massal_barcode', ['produks' => $produksCetak]);
    }

    public function index(Request $request)
    {
        $query = Produk::with(['kategori', 'stokCabangs']);

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_produk', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%')
                  ->orWhere('barcode_imei', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan Tipe (Fisik / Manual)
        $digitalCategories = ['pulsa', 'paket data', 'e-wallet', 'token pln', 'manual', 'digital'];
        if ($request->query('tipe') == 'manual') {
            $query->whereHas('kategori', function($q) use ($digitalCategories) {
                $q->where(function($q2) use ($digitalCategories) {
                    foreach($digitalCategories as $cat) {
                        $q2->orWhere('nama_kategori', 'like', '%' . $cat . '%');
                    }
                });
            });
        } else {
            // Tampilkan fisik (selain manual)
            $query->whereHas('kategori', function($q) use ($digitalCategories) {
                $q->where(function($q2) use ($digitalCategories) {
                    foreach($digitalCategories as $cat) {
                        $q2->where('nama_kategori', 'not like', '%' . $cat . '%');
                    }
                });
            })->orWhereDoesntHave('kategori'); // Produk tanpa kategori dianggap fisik
        }

        $produks = $query->orderBy('id_produk', 'desc')->paginate(10)->withQueryString();
        $kategoris = KategoriProduk::all();

        return view('admin.produk.index', compact('produks', 'kategoris'));
    }

    public function create()
    {
        $kategoris = KategoriProduk::all();
        /** @var \App\Models\User $user */
        $user = \Illuminate\Support\Facades\Auth::user();
        if ($user->role === 'admin cabang') {
            $cabangs = Cabang::where('id_cabang', $user->id_cabang)->get();
        } else {
            $cabangs = Cabang::where('status', 'aktif')->get();
        }
        return view('admin.produk.create', compact('kategoris', 'cabangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:100',
            'id_kategori' => 'required|exists:kategori_produks,id_kategori',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Generate SKU if auto
            $sku = $request->sku;
            if ($request->has('sku_auto') || empty($sku)) {
                $sku = 'PRD-' . strtoupper(Str::random(6));
            }

            // Generate Barcode if auto
            $barcode = $request->barcode_imei;
            if ($request->has('barcode_auto') || empty($barcode)) {
                $barcode = rand(100000000000, 999999999999);
            }

            // Handle Foto Produk
            $fotoUrl = null;
            if ($request->hasFile('foto_produk')) {
                $file = $request->file('foto_produk');
                $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                $file->move(public_path('uploads/produk'), $filename);
                $fotoUrl = url('uploads/produk/' . $filename);
            }

            // Buat produk baru
            $produk = Produk::create([
                'id_kategori' => $request->id_kategori,
                'nama_produk' => $request->nama_produk,
                'sku' => $sku,
                'barcode_imei' => $barcode,
                'harga_beli' => $request->harga_beli,
                'harga_jual' => $request->harga_jual,
                'foto_produk' => $fotoUrl,
                'status' => 'aktif',
            ]);

            // Masukkan stok ke masing-masing cabang
            if ($request->has('stok_cabang')) {
                foreach ($request->stok_cabang as $id_cabang => $qty) {
                    StokCabang::create([
                        'id_produk' => $produk->id_produk,
                        'id_cabang' => $id_cabang,
                        'stok_sekarang' => (int) $qty,
                        'stok_minimum' => 5,
                        'stok_maksimum' => 100,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $produk = Produk::with(['kategori', 'stokCabangs.cabang'])->findOrFail($id);
        // Kita akan me-return response JSON jika diakses via AJAX (untuk pop-up detail)
        if (request()->ajax()) {
            return response()->json($produk);
        }
        return view('admin.produk.show', compact('produk'));
    }

    public function edit($id)
    {
        $produk = Produk::with('stokCabangs.cabang')->findOrFail($id);
        $kategoris = KategoriProduk::all();
        /** @var \App\Models\User $user */
        $user = \Illuminate\Support\Facades\Auth::user();
        if ($user->role === 'admin cabang') {
            $cabangs = Cabang::where('id_cabang', $user->id_cabang)->get();
        } else {
            $cabangs = Cabang::where('status', 'aktif')->get();
        }
        return view('admin.produk.edit', compact('produk', 'kategoris', 'cabangs'));
    }

    public function update(Request $request, $id)
    {
        /** @var \App\Models\User $user */
        $user = \Illuminate\Support\Facades\Auth::user();
        if ($user->role === 'admin cabang') {
            $request->validate([
                'harga_beli' => 'required|numeric|min:0',
            ]);
        } else {
            $request->validate([
                'nama_produk' => 'required|string|max:100',
                'id_kategori' => 'required|exists:kategori_produks,id_kategori',
                'harga_beli' => 'required|numeric|min:0',
                'harga_jual' => 'required|numeric|min:0',
            ]);
        }

        $produk = Produk::findOrFail($id);

        try {
            $hargaBeliLama = $produk->harga_beli;
            $hargaBeliBaru = $request->harga_beli;

            if ($user->role === 'admin cabang') {
                $dataToUpdate = [
                    'harga_beli' => $hargaBeliBaru,
                ];
            } else {
                $dataToUpdate = [
                    'id_kategori' => $request->id_kategori,
                    'nama_produk' => $request->nama_produk,
                    'harga_beli' => $hargaBeliBaru,
                    'harga_jual' => $request->harga_jual,
                ];
            }

            // Jika user mengupload foto baru saat Edit
            if ($request->hasFile('foto_produk')) {
                // Hapus foto lama jika ada
                if ($produk->foto_produk) {
                    $oldFile = str_replace(url('/'), public_path(), $produk->foto_produk);
                    if (file_exists($oldFile) && is_file($oldFile)) {
                        unlink($oldFile);
                    }
                }
                
                // Simpan foto baru
                $file = $request->file('foto_produk');
                $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                $file->move(public_path('uploads/produk'), $filename);
                $dataToUpdate['foto_produk'] = url('uploads/produk/' . $filename);
            }

            $produk->update($dataToUpdate);

            // Log perubahan harga beli jika berbeda
            if ($hargaBeliLama != $hargaBeliBaru) {
                \App\Models\LogPerubahanHarga::create([
                    'id_produk' => $produk->id_produk,
                    'id_user' => $user->id_user,
                    'harga_beli_lama' => $hargaBeliLama,
                    'harga_beli_baru' => $hargaBeliBaru,
                    'tanggal' => date('Y-m-d H:i:s'),
                ]);
            }

            // Untuk Stok, biasanya tidak diedit langsung dari sini melainkan lewat menu Manajemen Stok, 
            // sehingga kita biarkan saja (read-only di form).

            return redirect()->route('produk.index')->with('success', 'Informasi produk berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengupdate produk: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        
        // Cek jika produk sudah pernah terjual (mencegah relasi putus)
        if ($produk->detailTransaksis()->count() > 0) {
            return redirect()->route('produk.index')->with('error', 'Gagal dihapus! Produk ini sudah pernah terjual dalam transaksi.');
        }

        try {
            $produk->delete(); // Akan menghapus data di stok_cabangs juga karena foreign key constraint (atau harus dihapus manual)
            // Hapus stok secara manual jika tidak ada constraint onDelete Cascade
            StokCabang::where('id_produk', $produk->id_produk)->delete();
            
            return redirect()->route('produk.index')->with('success', 'Produk beserta data stoknya berhasil dihapus permanen!');
        } catch (\Exception $e) {
            return redirect()->route('produk.index')->with('error', 'Terjadi kesalahan saat menghapus produk: ' . $e->getMessage());
        }
    }
}
