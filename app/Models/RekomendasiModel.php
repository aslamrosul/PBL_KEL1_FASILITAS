<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekomendasiModel extends Model
{
    use HasFactory;

    protected $table = 't_rekomendasi';
    protected $primaryKey = 'rekomendasi_id';
    protected $fillable = [
        'laporan_id',
        'rekom_mahasiswa',
        'rekom_dosen',
        'rekom_tendik',
        'skor_final',
        'bobot_id'
    ];

    public function laporan()
    {
        return $this->belongsTo(LaporanModel::class, 'laporan_id');
    }

    public function bobotPrioritas()
    {
        return $this->belongsTo(BobotPrioritasModel::class, 'bobot_id');
    }
}
