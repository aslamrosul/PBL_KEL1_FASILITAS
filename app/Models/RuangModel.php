<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuangModel extends Model
{
    use HasFactory;

    protected $table = 'm_ruang';
    protected $primaryKey = 'ruang_id';
    protected $fillable = ['lantai_id', 'ruang_kode', 'ruang_nama'];


    public function lantai()
    {
        return $this->belongsTo(LantaiModel::class, 'lantai_id');
    }

    public function fasilitas()
    {
        return $this->hasMany(FasilitasModel::class, 'ruang_id');
    }
}
