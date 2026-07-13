<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalShift extends Model
{
    use HasFactory;

    protected $table = 'jadwal_shifts';
    protected $primaryKey = 'id_jadwal_shift';

    protected $fillable = [
        'id_cabang',
        'id_user',
        'id_master_shift',
        'tanggal',
        'tipe',
        'keterangan',
        'status',
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang', 'id_cabang');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function masterShift()
    {
        return $this->belongsTo(MasterShift::class, 'id_master_shift', 'id_master_shift');
    }
}
