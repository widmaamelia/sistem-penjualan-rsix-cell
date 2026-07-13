<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogPerubahanHarga extends Model
{
    use HasFactory;

    protected $table = 'log_perubahan_hargas';
    protected $primaryKey = 'id_log_perubahan_harga';

    protected $fillable = [
        'id_produk',
        'id_user',
        'harga_beli_lama',
        'harga_beli_baru',
        'tanggal'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
