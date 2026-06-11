<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogManajemenStok extends Model
{
    use HasFactory;

    protected $table = 'log_manajemen_stoks';
    protected $primaryKey = 'id_log_stok';

    protected $fillable = [
        'id_cabang',
        'id_produk',
        'id_user',
        'qty',
        'jenis_transaksi',
        'stok_sebelum',
        'stok_sesudah',
        'keterangan',
        'tanggal'
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang', 'id_cabang');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
