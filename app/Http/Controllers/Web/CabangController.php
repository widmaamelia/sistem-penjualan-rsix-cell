<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use App\Models\User;
use Illuminate\Http\Request;

class CabangController extends Controller
{
    public function index(Request $request)
    {
        $query = Cabang::with('penanggungJawab');

        if ($request->filled('search')) {
            $query->where('nama_cabang', 'like', '%' . $request->search . '%')
                  ->orWhere('alamat', 'like', '%' . $request->search . '%');
        }

        $cabangs = $query->orderBy('id_cabang', 'desc')->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return view('admin.cabang.index', compact('cabangs'))->renderSections()['content'];
        }

        return view('admin.cabang.index', compact('cabangs'));
    }

    public function create()
    {
        $adminCabangs = User::where('role', 'admin cabang')->where('status', 'aktif')->get();
        return view('admin.cabang.create', compact('adminCabangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_cabang' => 'required|string|max:100',
            'alamat' => 'nullable|string',
            'id_penanggung_jawab' => 'nullable|exists:users,id_user',
            'no_hp' => 'nullable|string|max:20',
        ]);

        Cabang::create([
            'nama_cabang' => $request->nama_cabang,
            'alamat' => $request->alamat,
            'id_penanggung_jawab' => $request->id_penanggung_jawab,
            'no_hp' => $request->no_hp,
            'status' => 'aktif',
        ]);

        return redirect()->route('cabang.index')->with('success', 'Cabang baru berhasil ditambahkan!');
    }

    public function show($id)
    {
        $cabang = Cabang::with('penanggungJawab')->findOrFail($id);
        if (request()->ajax()) {
            return response()->json($cabang);
        }
        return abort(404);
    }

    public function edit($id)
    {
        $cabang = Cabang::findOrFail($id);
        $adminCabangs = User::where('role', 'admin cabang')->where('status', 'aktif')->get();
        return view('admin.cabang.edit', compact('cabang', 'adminCabangs'));
    }

    public function update(Request $request, $id)
    {
        $cabang = Cabang::findOrFail($id);

        $request->validate([
            'nama_cabang' => 'required|string|max:100',
            'alamat' => 'nullable|string',
            'id_penanggung_jawab' => 'nullable|exists:users,id_user',
            'no_hp' => 'nullable|string|max:20',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        $cabang->update([
            'nama_cabang' => $request->nama_cabang,
            'alamat' => $request->alamat,
            'id_penanggung_jawab' => $request->id_penanggung_jawab,
            'no_hp' => $request->no_hp,
            'status' => $request->status,
        ]);

        return redirect()->route('cabang.index')->with('success', 'Data cabang berhasil diperbarui!');
    }

    public function toggleStatus(Request $request, $id)
    {
        $cabang = Cabang::findOrFail($id);
        $cabang->status = $cabang->status === 'aktif' ? 'nonaktif' : 'aktif';
        $cabang->save();

        return response()->json([
            'success' => true,
            'message' => 'Status cabang berhasil diubah!',
            'new_status' => $cabang->status
        ]);
    }

    public function destroy($id)
    {
        $cabang = Cabang::findOrFail($id);
        
        // Proteksi: Jangan hapus jika ada pengguna yang masih terhubung ke cabang ini
        if ($cabang->users()->count() > 0) {
            return redirect()->route('cabang.index')->with('error', 'Gagal dihapus! Cabang ini masih memiliki pengguna yang aktif.');
        }

        // Coba periksa apakah masih ada stok cabang yang terkait dengan cabang ini
        // Kita perlu import model StokCabang jika ada, tapi karena relasi tidak terdefine di Cabang model, kita skip atau import Modelnya
        $stokCount = \App\Models\StokCabang::where('id_cabang', $id)->where('stok_sekarang', '>', 0)->count();
        if ($stokCount > 0) {
            return redirect()->route('cabang.index')->with('error', 'Gagal dihapus! Cabang ini masih memiliki sisa stok fisik.');
        }

        try {
            // Hapus stok cabang (yg kuantitasnya 0)
            \App\Models\StokCabang::where('id_cabang', $id)->delete();
            $cabang->delete();
            
            return redirect()->route('cabang.index')->with('success', 'Cabang berhasil dihapus permanen!');
        } catch (\Exception $e) {
            return redirect()->route('cabang.index')->with('error', 'Gagal dihapus! Data cabang mungkin masih digunakan di data transaksi: ' . $e->getMessage());
        }
    }
}
