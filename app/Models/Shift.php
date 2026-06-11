<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $table = 'shifts';
    protected $primaryKey = 'id_shift';

    protected $fillable = [
        'id_user',
        'id_cabang',
        'saldo_awal',
        'saldo_akhir',
        'waktu_buka',
        'waktu_tutup',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang', 'id_cabang');
    }

    public function kasKeluars()
    {
        return $this->hasMany(KasKeluar::class, 'id_shift', 'id_shift');
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'id_shift', 'id_shift');
    }
}
