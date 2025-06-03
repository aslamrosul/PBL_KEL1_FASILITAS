<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodeModel extends Model
{
    protected $table = 'm_periode';
    protected $primaryKey = 'periode_id';
    protected $fillable = [
        'periode_kode',
        'periode_nama',
        'tanggal_mulai',
        'tanggal_selesai',
        'is_aktif'
    ];

    public function laporans()
    {
        return $this->hasMany(LaporanModel::class, 'periode_id');
    }
}
