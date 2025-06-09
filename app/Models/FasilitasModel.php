<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FasilitasModel extends Model
{
    use HasFactory;

    protected $table = 'm_fasilitas';
    protected $primaryKey = 'fasilitas_id';
    protected $fillable = [
        'ruang_id',
        'barang_id',
        'fasilitas_kode',
        'fasilitas_nama',
        'keterangan',
        'status',
        'tahun_pengadaan'
        
    ];

    public function ruang()
    {
        return $this->belongsTo(RuangModel::class, 'ruang_id');
    }

    public function barang()
    {
        return $this->belongsTo(BarangModel::class, 'barang_id');
    }

    public function laporans()
    {
        return $this->hasMany(LaporanModel::class, 'fasilitas_id');
    }
       public function alternatifNilai()
    {
        return $this->hasMany(AlternatifNilaiModel::class, 'fasilitas_id');
    }
}
