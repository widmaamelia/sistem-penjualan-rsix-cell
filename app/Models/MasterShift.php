<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterShift extends Model
{
    use HasFactory;

    protected $table = 'master_shifts';
    protected $primaryKey = 'id_master_shift';

    protected $fillable = [
        'nama_shift',
        'jam_mulai',
        'jam_selesai',
    ];

    public function jadwalShifts()
    {
        return $this->hasMany(JadwalShift::class, 'id_master_shift', 'id_master_shift');
    }
}
