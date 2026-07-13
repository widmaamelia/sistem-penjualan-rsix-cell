<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailStokOpname extends Model
{
    use HasFactory;

    protected $table = 'detail_stok_opnames';
    protected $primaryKey = 'id_detail_stok_opname';

    protected $fillable = [
        'id_stok_opname',
        'id_produk',
        'stok_sistem',
        'stok_fisik',
        'selisih',
        'keterangan',
    ];

    public function stokOpname()
    {
        return $this->belongsTo(StokOpname::class, 'id_stok_opname', 'id_stok_opname');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}
