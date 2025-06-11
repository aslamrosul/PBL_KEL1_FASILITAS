<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangModel extends Model
{
     use HasFactory;

    protected $table = 'm_barang';
    protected $primaryKey = 'barang_id';
    protected $fillable = ['kategori_id','klasifikasi_id', 'barang_kode', 'barang_nama','bara'];
 protected $casts = [
    'bobot_prioritas' => 'decimal:2', // agar otomatis format 2 angka desimal
];
    
    public function kategori()
    {
        return $this->belongsTo(KategoriModel::class, 'kategori_id');
    }
    public function klasifikasi()
    {
        return $this->belongsTo(KlasifikasiModel::class, 'klasifikasi_id');
    }

    public function fasilitas()
    {
        return $this->hasMany(FasilitasModel::class, 'barang_id');
    }
}
