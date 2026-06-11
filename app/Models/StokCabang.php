<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokCabang extends Model
{
    use HasFactory;

    protected $table = 'stok_cabangs';
    protected $primaryKey = 'id_stok_cabang';

    protected $fillable = [
        'id_produk',
        'id_cabang',
        'stok_sekarang'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang', 'id_cabang');
    }
}
