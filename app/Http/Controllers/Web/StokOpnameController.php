<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\StokOpname;
use App\Models\DetailStokOpname;
use App\Models\Produk;
use App\Models\StokCabang;
use App\Models\LogManajemenStok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StokOpnameController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = StokOpname::with(['cabang', 'user'])->orderBy('created_at', 'desc');

        if ($user->role === 'admin cabang') {
            $query->where('id_cabang', $user->id_cabang);
        } elseif ($user->role === 'super' && $request->filled('id_cabang')) {
            $query->where('id_cabang', $request->id_cabang);
        }

        if ($request->filled('date_range')) {
            $dates = explode(' to ', $request->date_range);
            if (count($dates) == 2) {
                $query->whereBetween('tanggal_opname', [$dates[0], $dates[1]]);
            } else {
                $query->whereDate('tanggal_opname', $dates[0]);
            }
        } else {
            // Default hanya tampilkan bulan ini
            $query->whereMonth('tanggal_opname', date('m'))
                  ->whereYear('tanggal_opname', date('Y'));
        }

        $opnames = $query->paginate(10)->withQueryString();
        $cabangs = \App\Models\Cabang::where('status', 'aktif')->get();
        return view('admin.stok_opname.index', compact('opnames', 'cabangs'));
    }

    public function create()
    {
        $user = Auth::user();
        if ($user->role !== 'admin cabang') {
            return redirect()->route('stok_opname.index')->with('error', 'Hanya Admin Cabang yang dapat membuat Stok Opname.');
        }

        if (!$user->id_cabang) {
            return redirect()->route('stok_opname.index')->with('error', 'Akun Anda tidak terikat dengan cabang manapun.');
        }

        // Ambil semua produk beserta stoknya di cabang ini
        $produks = Produk::with(['stokCabangs' => function ($q) use ($user) {
            $q->where('id_cabang', $user->id_cabang);
        }])->orderBy('nama_produk', 'asc')->get();

        return view('admin.stok_opname.create', compact('produks'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'admin cabang' || !$user->id_cabang) {
            return redirect()->route('stok_opname.index')->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'keterangan_umum' => 'nullable|string',
            'produks' => 'required|array',
            'produks.*.id_produk' => 'required|exists:produks,id_produk',
            'produks.*.stok_sistem' => 'required|numeric',
            'produks.*.stok_fisik' => 'nullable|numeric',
            'produks.*.keterangan' => 'nullable|string',
        ]);

        $hasFisik = false;
        foreach ($request->produks as $item) {
            if ($item['stok_fisik'] !== null && $item['stok_fisik'] !== '') {
                $hasFisik = true;
                break;
            }
        }

        if (!$hasFisik) {
            return redirect()->back()->with('error', 'Harap isi minimal satu kolom Stok Fisik barang yang ingin disesuaikan.')->withInput();
        }

        try {
            DB::beginTransaction();

            $opname = StokOpname::create([
                'id_cabang' => $user->id_cabang,
                'id_user' => $user->id_user,
                'tanggal_opname' => date('Y-m-d'),
                'status' => 'pending',
                'keterangan' => $request->keterangan_umum,
            ]);

            foreach ($request->produks as $item) {
                // Hanya simpan jika ada perubahan fisik yang diinput
                if ($item['stok_fisik'] !== null && $item['stok_fisik'] !== '') {
                    $selisih = $item['stok_fisik'] - $item['stok_sistem'];
                    DetailStokOpname::create([
                        'id_stok_opname' => $opname->id_stok_opname,
                        'id_produk' => $item['id_produk'],
                        'stok_sistem' => $item['stok_sistem'],
                        'stok_fisik' => $item['stok_fisik'],
                        'selisih' => $selisih,
                        'keterangan' => $item['keterangan'] ?? null,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('stok_opname.index')->with('success', 'Stok Opname berhasil disubmit dan menunggu persetujuan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $opname = StokOpname::with(['cabang', 'user', 'details.produk'])->findOrFail($id);
        
        $user = Auth::user();
        if ($user->role === 'admin cabang' && $opname->id_cabang !== $user->id_cabang) {
            return redirect()->route('stok_opname.index')->with('error', 'Akses ditolak.');
        }

        return view('admin.stok_opname.show', compact('opname'));
    }

    public function approve($id)
    {
        $user = Auth::user();
        if ($user->role !== 'super') {
            return redirect()->route('stok_opname.index')->with('error', 'Hanya Super Admin yang dapat menyetujui Stok Opname.');
        }

        $opname = StokOpname::with('details.produk')->findOrFail($id);
        if ($opname->status !== 'pending') {
            return redirect()->back()->with('error', 'Stok Opname ini sudah diproses.');
        }

        try {
            DB::beginTransaction();

            $opname->status = 'approved';
            $opname->save();

            $totalKasKeluar = 0;

            // Update stok fisik ke database
            foreach ($opname->details as $detail) {
                if ($detail->selisih != 0) {
                    $stokCabang = StokCabang::firstOrCreate(
                        ['id_cabang' => $opname->id_cabang, 'id_produk' => $detail->id_produk],
                        ['stok_sekarang' => 0, 'stok_minimum' => 5, 'stok_maksimal' => 100]
                    );

                    $stokSebelum = $stokCabang->stok_sekarang;
                    $stokCabang->stok_sekarang = $detail->stok_fisik;
                    $stokCabang->save();

                    LogManajemenStok::create([
                        'id_cabang' => $opname->id_cabang,
                        'id_produk' => $detail->id_produk,
                        'id_user' => $user->id_user,
                        'qty' => abs($detail->selisih),
                        'jenis_transaksi' => $detail->selisih > 0 ? 'masuk' : 'keluar',
                        'stok_sebelum' => $stokSebelum,
                        'stok_sesudah' => $detail->stok_fisik,
                        'keterangan' => 'Penyesuaian Stok Opname #' . $opname->id_stok_opname,
                        'tanggal' => date('Y-m-d')
                    ]);

                    if ($detail->selisih > 0 && $detail->produk) {
                        $totalKasKeluar += $detail->selisih * $detail->produk->harga_beli;
                    }
                }
            }

            // Jika ada pengeluaran kas otomatis karena penambahan stok
            if ($totalKasKeluar > 0) {
                // Cari apakah pembuat opname memiliki shift aktif
                $activeShift = \App\Models\Shift::where('id_user', $opname->id_user)
                                                ->where('id_cabang', $opname->id_cabang)
                                                ->where('status', 'buka')
                                                ->first();

                \App\Models\KasKeluar::create([
                    'id_shift' => $activeShift ? $activeShift->id_shift : null,
                    'id_cabang' => $opname->id_cabang,
                    'jumlah_pengeluaran' => $totalKasKeluar,
                    'keterangan' => 'Pembelian Stok Baru (Stok Opname #' . $opname->id_stok_opname . ')',
                    'tanggal' => date('Y-m-d H:i:s')
                ]);
            }

            DB::commit();
            return redirect()->route('stok_opname.show', $id)->with('success', 'Stok Opname disetujui. Stok sistem telah disesuaikan dengan stok fisik.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyetujui: ' . $e->getMessage());
        }
    }

    public function reject($id)
    {
        $user = Auth::user();
        if ($user->role !== 'super') {
            return redirect()->route('stok_opname.index')->with('error', 'Hanya Super Admin yang dapat menolak Stok Opname.');
        }

        $opname = StokOpname::findOrFail($id);
        if ($opname->status !== 'pending') {
            return redirect()->back()->with('error', 'Stok Opname ini sudah diproses.');
        }

        $opname->status = 'rejected';
        $opname->save();

        return redirect()->route('stok_opname.show', $id)->with('success', 'Stok Opname telah ditolak.');
    }
}
