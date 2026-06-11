<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasKeluar extends Model
{
    use HasFactory;

    protected $table = 'kas_keluars';
    protected $primaryKey = 'id_kas_keluar';

    protected $fillable = [
        'id_shift',
        'jumlah_pengeluaran',
        'keterangan',
        'tanggal'
    ];

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'id_shift', 'id_shift');
    }
}
