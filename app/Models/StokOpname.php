<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokOpname extends Model
{
    use HasFactory;

    protected $table = 'stok_opnames';
    protected $primaryKey = 'id_stok_opname';

    protected $fillable = [
        'id_cabang',
        'id_user',
        'tanggal_opname',
        'status',
        'keterangan',
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang', 'id_cabang');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function details()
    {
        return $this->hasMany(DetailStokOpname::class, 'id_stok_opname', 'id_stok_opname');
    }
}
