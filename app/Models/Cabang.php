<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    use HasFactory;

    protected $table = 'cabangs';
    protected $primaryKey = 'id_cabang';

    protected $fillable = [
        'nama_cabang',
        'alamat',
        'id_penanggung_jawab',
        'no_hp',
        'status',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'id_cabang', 'id_cabang');
    }

    public function penanggungJawab()
    {
        return $this->belongsTo(User::class, 'id_penanggung_jawab', 'id_user');
    }
}
