<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\KasKeluar;
use App\Models\Cabang;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KasKeluarController extends Controller
{
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = \Illuminate\Support\Facades\Auth::user();
        
        if ($user->role === 'admin cabang') {
            $query = KasKeluar::with(['shift.user', 'cabang'])
                ->where(function($q) use ($user) {
                    $q->where('id_cabang', $user->id_cabang)
                      ->orWhereHas('shift', function($sq) use ($user) {
                          $sq->where('id_cabang', $user->id_cabang);
                      });
                });
        } else {
            // Super Admin
            $query = KasKeluar::with(['shift.user', 'cabang', 'shift.cabang']);
            
            if ($request->filled('id_cabang')) {
                $query->where(function($q) use ($request) {
                    $q->where('id_cabang', $request->id_cabang)
                      ->orWhereHas('shift', function($sq) use ($request) {
                          $sq->where('id_cabang', $request->id_cabang);
                      });
                });
            }
        }

        // Filter pencarian berdasarkan keterangan
        if ($request->filled('search')) {
            $query->where('keterangan', 'like', '%' . $request->search . '%');
        }

        // Filter rentang tanggal
        if ($request->filled('date_range')) {
            $dates = explode(' to ', $request->date_range);
            if (count($dates) == 2) {
                $query->whereBetween('tanggal', [$dates[0], $dates[1]]);
            } else {
                $query->whereDate('tanggal', $dates[0]);
            }
        } else {
            // Default hanya tampilkan bulan ini jika filter kosong
            $query->whereMonth('tanggal', date('m'))
                  ->whereYear('tanggal', date('Y'));
        }

        // Dihitung sebelum paginate agar totalnya mencakup seluruh data
        // hasil filter, bukan hanya 15 baris yang tampil di halaman ini.
        // Pemisahan otomatis vs manual memakai pola keterangan yang sama
        // dengan badge "Tipe Pengeluaran" di tabel.
        $filterOtomatis = function ($q) {
            $q->where('keterangan', 'like', '%restock%')
              ->orWhere('keterangan', 'like', '%opname%');
        };

        $totalPengeluaran = (clone $query)->sum('jumlah_pengeluaran');
        $totalOtomatis = (clone $query)->where($filterOtomatis)->sum('jumlah_pengeluaran');
        $jumlahOtomatis = (clone $query)->where($filterOtomatis)->count();
        $jumlahSemua = (clone $query)->count();

        $ringkasan = [
            'total' => $totalPengeluaran,
            'otomatis' => $totalOtomatis,
            'manual' => $totalPengeluaran - $totalOtomatis,
            'jumlah_semua' => $jumlahSemua,
            'jumlah_otomatis' => $jumlahOtomatis,
            'jumlah_manual' => $jumlahSemua - $jumlahOtomatis,
            'terbesar' => (clone $query)->max('jumlah_pengeluaran') ?? 0,
            'rata_rata' => $jumlahSemua > 0 ? $totalPengeluaran / $jumlahSemua : 0,
        ];

        $kasKeluars = $query->orderBy('tanggal', 'desc')->paginate(10)->withQueryString();

        $cabangs = [];
        if ($user->role === 'super') {
            $cabangs = Cabang::all();
        }

        return view('admin.kas_keluar.index', compact('kasKeluars', 'cabangs', 'ringkasan'));
    }
    public function create()
    {
        /** @var \App\Models\User $user */
        $user = \Illuminate\Support\Facades\Auth::user();
        if (!in_array($user->role, ['super', 'admin cabang'])) {
            return abort(403);
        }
        
        $cabangs = [];
        if ($user->role === 'super') {
            $cabangs = Cabang::all();
        }
        return view('admin.kas_keluar.create', compact('cabangs'));
    }

    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = \Illuminate\Support\Facades\Auth::user();
        
        $rules = [
            'jumlah_pengeluaran' => 'required|numeric|min:0',
            'keterangan' => 'required|string|max:255',
            'tanggal' => 'nullable|date',
        ];

        if ($user->role === 'super') {
            $rules['id_cabang'] = 'required|exists:cabangs,id_cabang';
        }

        $request->validate($rules);

        $idCabang = $user->role === 'super' ? $request->id_cabang : $user->id_cabang;

        KasKeluar::create([
            'id_cabang' => $idCabang,
            'jumlah_pengeluaran' => $request->jumlah_pengeluaran,
            'keterangan' => $request->keterangan,
            'tanggal' => $request->filled('tanggal') ? Carbon::parse($request->tanggal) : now(),
        ]);

        return redirect()->route('kas_keluar.index')->with('success', 'Catatan kas keluar berhasil ditambahkan.');
    }

    public function show($id)
    {
        $kasKeluar = KasKeluar::with(['shift.user', 'cabang'])->findOrFail($id);
        /** @var \App\Models\User $user */
        $user = \Illuminate\Support\Facades\Auth::user();

        // Validasi hak akses cabang
        if ($user->role === 'admin cabang') {
            $ownerCabangId = $kasKeluar->id_cabang ?? ($kasKeluar->shift->id_cabang ?? null);
            if ($ownerCabangId !== $user->id_cabang) {
                return abort(403);
            }
        }

        return view('admin.kas_keluar.show', compact('kasKeluar'));
    }

    public function destroy($id)
    {
        $kasKeluar = KasKeluar::findOrFail($id);
        /** @var \App\Models\User $user */
        $user = \Illuminate\Support\Facades\Auth::user();

        // Validasi hak akses cabang
        if ($user->role === 'admin cabang') {
            $ownerCabangId = $kasKeluar->id_cabang ?? ($kasKeluar->shift->id_cabang ?? null);
            if ($ownerCabangId !== $user->id_cabang) {
                return abort(403);
            }
        }

        // Pengeluaran otomatis dari sistem (restok atau stok opname selisih kurang) sebaiknya tidak dihapus agar data konsisten
        if (str_contains(strtolower($kasKeluar->keterangan), 'restock') || str_contains(strtolower($kasKeluar->keterangan), 'opname')) {
            return redirect()->route('kas_keluar.index')->with('error', 'Pengeluaran otomatis sistem tidak dapat dihapus.');
        }

        $kasKeluar->delete();
        return redirect()->route('kas_keluar.index')->with('success', 'Catatan kas keluar berhasil dihapus.');
    }
}