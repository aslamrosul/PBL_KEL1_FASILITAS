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
        'catatan'
    ];

    // Relasi ke tabel laporan
    public function laporan()
    {
        return $this->belongsTo(LaporanModel::class, 'laporan_id', 'laporan_id');
    }

    // Relasi ke teknisi (user)
    public function teknisi()
    {
        return $this->belongsTo(UserModel::class, 'teknisi_id', 'user_id');
    }

    // Relasi ke petugas sarpras (user)
    public function sarpras()
    {
        return $this->belongsTo(UserModel::class, 'sarpras_id', 'user_id');
    }

    // Scope untuk status penugasan
    public function scopeDitugaskan($query)
    {
        return $query->where('status_penugasan', 'ditugaskan');
    }

    // Casting untuk tipe data khusus (optional)
    protected $casts = [
        'tanggal_penugasan' => 'date',
    ];
}