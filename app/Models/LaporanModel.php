<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon; // Ensure Carbon is imported for type hinting if needed

class LaporanModel extends Model
{
    use HasFactory;

    protected $table = 't_laporan'; // Your laporan table name
    protected $primaryKey = 'laporan_id';
    protected $fillable = [
        'user_id',
        'periode_id',
        'fasilitas_id',
        'judul',
        'deskripsi',
        'foto_path',
        'bobot_id', // Based on your migration, it's 'bobot_id'
        'status',
        'alasan_penolakan',
        'tanggal_selesai',
    ];

    // Define direct relationships as per your migration
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }

    public function periode()
    {
        return $this->belongsTo(PeriodeModel::class, 'periode_id');
    }

    public function fasilitas()
    {
        return $this->belongsTo(FasilitasModel::class, 'fasilitas_id');
    }

    public function bobotPrioritas()
    {
        // Relationship for bobot_id
        return $this->belongsTo(BobotPrioritasModel::class, 'bobot_id');
    }

    public function histories()
    {
        return $this->hasMany(LaporanHistoryModel::class, 'laporan_id');
    }

    public function perbaikans()
    {
        return $this->hasMany(PerbaikanModel::class, 'laporan_id');
    }

    public function feedback()
    {
        return $this->hasOne(FeedbackModel::class, 'laporan_id');
    }

    public function rekomendasi()
    {
        return $this->hasOne(RekomendasiModel::class, 'laporan_id');
    }

    protected $casts = [
        'tanggal_lapor' => 'datetime',
        'tanggal_selesai' => 'datetime', // Uncomment if you want to cast this too
    ];
}
