<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produks';
    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'id_kategori',
        'foto_produk',
        'sku',
        'nama_produk',
        'harga_beli',
        'harga_jual',
        'barcode_imei',
        'status'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriProduk::class, 'id_kategori', 'id_kategori');
    }

    public function stokCabangs()
    {
        return $this->hasMany(StokCabang::class, 'id_produk', 'id_produk');
    }

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_produk', 'id_produk');
    }

    public function logStoks()
    {
        return $this->hasMany(LogManajemenStok::class, 'id_produk', 'id_produk');
    }
}
