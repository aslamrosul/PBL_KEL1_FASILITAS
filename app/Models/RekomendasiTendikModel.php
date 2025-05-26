<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekomendasiTendikModel extends Model
{
    use HasFactory;

    protected $table = 't_rekomendasi_tendik';
    protected $primaryKey = 'rekom_id';
    protected $fillable = [
        'laporan_id',
        'nilai_kriteria',
        'skor_total'
    ];

    public function laporan()
    {
        return $this->belongsTo(LaporanModel::class, 'laporan_id');
    }
}
