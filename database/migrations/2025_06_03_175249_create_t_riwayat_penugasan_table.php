<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatPenugasanModel extends Model
{
    protected $table = 't_riwayat_penugasan';
    protected $primaryKey = 'riwayat_penugasan_id';
    protected $fillable = [
        'laporan_id',
        'teknisi_id',
        'sarpras_id',
        'tanggal_penugasan',
        'status_penugasan',
        'tanggal_selesai'
    ];

    // Relasi ke laporan
    public function laporan()
    {
        return $this->belongsTo(LaporanModel::class, 'laporan_id');
    }

    // Relasi ke teknisi
    public function teknisi()
    {
        return $this->belongsTo(UserModel::class, 'teknisi_id');
    }

    // Relasi ke petugas sarpras
    public function sarpras()
    {
        return $this->belongsTo(UserModel::class, 'sarpras_id');
    }

    // Scope untuk penugasan aktif
    public function scopeAktif($query)
    {
        return $query->whereIn('status_penugasan', ['ditugaskan', 'dikerjakan']);
    }
}