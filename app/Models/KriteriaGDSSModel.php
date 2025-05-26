<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaGDSSModel extends Model
{
    use HasFactory;

    protected $table = 'm_kriteria_gdss';
    protected $primaryKey = 'kriteria_id';
    protected $fillable = ['kriteria_kode', 'kriteria_nama', 'bobot'];

    // public function rekomendasiMahasiswa()
    // {
    //     return $this->hasMany(RekomendasiMahasiswaModel::class, 'kriteria_id');
    // }
}
