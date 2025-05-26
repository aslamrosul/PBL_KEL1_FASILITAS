<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerbaikanModel extends Model
{
    use HasFactory;

    protected $table = 't_perbaikan';
    protected $primaryKey = 'perbaikan_id';
    
    protected $dates = [
    'tanggal_mulai',
    'tanggal_selesai',
    'tanggal_ditolak' // Tambahkan ini
];
    protected $fillable = [
        'laporan_id',
        'teknisi_id',
        'tanggal_mulai',
        'tanggal_selesai',
         'tanggal_ditolak',
        'status',
        'catatan',
        'foto_perbaikan'
    ];

    public function laporan()
    {
        return $this->belongsTo(LaporanModel::class, 'laporan_id');
    }

    public function teknisi()
    {
        return $this->belongsTo(UserModel::class, 'teknisi_id');
    }

    public function details()
    {
        return $this->hasMany(PerbaikanDetailModel::class, 'perbaikan_id');
    }
}
