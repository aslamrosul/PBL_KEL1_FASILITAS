<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RekomendasiModel extends Model
{
    use HasFactory;
    protected $table = 't_rekomendasi'; 
    protected $primaryKey = 'rekomendasi_id'; 
    protected $casts = [
        'nilai_kriteria' => 'array', // Cast 'nilai_kriteria' ke array/JSON
        'skor_total' => 'decimal:4', // Cast 'skor_total' ke desimal dengan 4 tempat desimal
    ];
    protected $fillable = [
        'laporan_id',
        'nilai_kriteria',
        'skor_total',
        'bobot_id',
    ];


 
    public function laporan(): BelongsTo
    {
        return $this->belongsTo(LaporanModel::class, 'laporan_id', 'laporan_id');
    }
  
    public function bobotPrioritas(): BelongsTo
    {
        return $this->belongsTo(BobotPrioritasModel::class, 'bobot_id', 'bobot_id');
    }
}
