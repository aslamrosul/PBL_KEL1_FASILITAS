<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlternatifNilaiModel extends Model
{
    protected $table = 't_alternatif_nilai';
    protected $primaryKey = 'alternatif_id';
    protected $fillable = [
        'fasilitas_id',
        'kriteria_id',
        'periode_id',
        'nilai'
    ];

    public function fasilitas()
    {
        return $this->belongsTo(FasilitasModel::class, 'fasilitas_id');
    }

    public function kriteria()
    {
        return $this->belongsTo(KriteriaModel::class, 'kriteria_id');
    }

    public function periode()
    {
        return $this->belongsTo(PeriodeModel::class, 'periode_id');
    }
}