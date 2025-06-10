<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanModel extends Model
{
    use HasFactory;

    protected $table = 't_laporan';
    protected $primaryKey = 'laporan_id';
    protected $fillable = [
        'user_id',
        'periode_id',
        'fasilitas_id',
        'judul',
        'deskripsi',
        'foto_path',
        'gedung_id',
        'lantai_id',
        'ruang_id',
        'barang_id',
        'status',
        'alasan_penolakan',
        'tanggal_selesai'
    ];

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
        return $this->belongsTo(BobotPrioritasModel::class, 'bobot_id');
    }

    public function Gedung()
    {
        return $this->belongsTo(GedungModel::class, 'gedung_id');
    }

    public function Ruang()
    {
        return $this->belongsTo(RuangModel::class, 'ruang_id');
    }

    public function Lantai()
    {
        return $this->belongsTo(LantaiModel::class, 'lantai_id');
    }

    public function Barang()
    {
        return $this->belongsTo(BarangModel::class, 'barang_id');
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

    protected $casts = [
        'tanggal_lapor' => 'datetime',
    ];
}
