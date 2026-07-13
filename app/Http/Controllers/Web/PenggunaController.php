<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Cabang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PenggunaController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('cabang');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $penggunas = $query->orderBy('id_user', 'desc')->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return view('admin.pengguna.index', compact('penggunas'))->renderSections()['content'];
        }

        return view('admin.pengguna.index', compact('penggunas'));
    }

    public function create()
    {
        $cabangs = Cabang::where('status', 'aktif')->get();
        return view('admin.pengguna.create', compact('cabangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:super,admin cabang,karyawan',
            'id_cabang' => [
                'nullable',
                Rule::requiredIf(in_array($request->role, ['admin cabang', 'karyawan'])),
                'exists:cabangs,id_cabang'
            ]
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'id_cabang' => $request->role === 'super' ? null : $request->id_cabang,
            'status' => 'aktif',
        ]);

        return redirect()->route('pengguna.index')->with('success', 'Pengguna baru berhasil ditambahkan!');
    }

    public function show($id)
    {
        $pengguna = User::with('cabang')->findOrFail($id);
        
        if (request()->ajax()) {
            return response()->json($pengguna);
        }
        
        return view('admin.pengguna.show', compact('pengguna'));
    }

    public function edit($id)
    {
        $pengguna = User::findOrFail($id);
        $cabangs = Cabang::where('status', 'aktif')->get();
        return view('admin.pengguna.edit', compact('pengguna', 'cabangs'));
    }

    public function update(Request $request, $id)
    {
        $pengguna = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users,email,' . $id . ',id_user',
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:super,admin cabang,karyawan',
            'status' => 'required|in:aktif,nonaktif',
            'id_cabang' => [
                'nullable',
                Rule::requiredIf(in_array($request->role, ['admin cabang', 'karyawan'])),
                'exists:cabangs,id_cabang'
            ]
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
            'id_cabang' => $request->role === 'super' ? null : $request->id_cabang,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $pengguna->update($data);

        return redirect()->route('pengguna.index')->with('success', 'Data pengguna berhasil diperbarui!');
    }

    public function toggleStatus(Request $request, $id)
    {
        $pengguna = User::findOrFail($id);
        
        // Proteksi jangan nonaktifkan diri sendiri
        if (auth()->id() == $id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak bisa menonaktifkan akun Anda sendiri!'
            ], 403);
        }

        $pengguna->status = $pengguna->status === 'aktif' ? 'nonaktif' : 'aktif';
        $pengguna->save();

        return response()->json([
            'success' => true,
            'message' => 'Status pengguna berhasil diubah!',
            'new_status' => $pengguna->status
        ]);
    }

    public function destroy($id)
    {
        $pengguna = User::findOrFail($id);
        
        // Proteksi agar tidak bisa menghapus diri sendiri
        if (auth()->id() == $id) {
            return redirect()->route('pengguna.index')->with('error', 'Gagal dihapus! Anda tidak dapat menghapus akun Anda sendiri saat sedang login.');
        }

        try {
            $pengguna->delete();
            return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('pengguna.index')->with('error', 'Gagal dihapus! Akun pengguna ini mungkin masih memiliki riwayat transaksi.');
        }
    }
}
