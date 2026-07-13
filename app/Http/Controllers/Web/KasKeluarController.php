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
        $user = auth()->user();
        
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

        $kasKeluars = $query->orderBy('tanggal', 'desc')->paginate(15)->withQueryString();
        
        $cabangs = [];
        if ($user->role === 'super') {
            $cabangs = Cabang::all();
        }

        return view('admin.kas_keluar.index', compact('kasKeluars', 'cabangs'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        
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

    public function destroy($id)
    {
        $kasKeluar = KasKeluar::findOrFail($id);
        $user = auth()->user();

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
