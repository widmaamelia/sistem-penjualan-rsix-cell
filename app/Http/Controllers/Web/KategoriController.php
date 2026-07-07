<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\KategoriProduk;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $query = KategoriProduk::withCount('produks')->orderBy('id_kategori', 'desc');

        if ($request->has('search') && $request->search != '') {
            $query->where('nama_kategori', 'like', '%' . $request->search . '%');
        }

        $kategoris = $query->paginate(10)->withQueryString();
        
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori_produks,nama_kategori'
        ]);

        KategoriProduk::create([
            'nama_kategori' => $request->nama_kategori
        ]);
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kategori = KategoriProduk::findOrFail($id);
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori_produks,nama_kategori,' . $id . ',id_kategori'
        ]);

        $kategori = KategoriProduk::findOrFail($id);
        $kategori->update([
            'nama_kategori' => $request->nama_kategori
        ]);
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diubah!');
    }

    public function destroy($id)
    {
        $kategori = KategoriProduk::findOrFail($id);
        
        // Cek jika kategori sudah dipakai produk
        if ($kategori->produks()->count() > 0) {
            return redirect()->route('kategori.index')->with('error', 'Gagal dihapus! Kategori ini masih memiliki produk.');
        }

        $kategori->delete();
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
