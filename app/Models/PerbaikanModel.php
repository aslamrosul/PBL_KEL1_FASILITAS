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
];
    protected $fillable = [
        'laporan_id',
        'teknisi_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'catatan',
        'total_biaya',
        'foto_perbaikan',
    ];

    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'total_biaya' => 'decimal:2'
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

     public function scopeAktif($query)
    {
        return $query->whereIn('status', ['dalam_antrian', 'dikerjakan']);
    }

    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai');
    }
}
