<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PairwiseKriteriaModel extends Model
{
    use HasFactory;

    protected $table = 'm_pairwise_kriteria';
    protected $primaryKey = 'pairwise_id';
    protected $fillable = ['kriteria_id_1', 'kriteria_id_2', 'nilai'];

    public function kriteria1()
    {
        return $this->belongsTo(KriteriaModel::class, 'kriteria_id_1');
    }

    public function kriteria2()
    {
        return $this->belongsTo(KriteriaModel::class, 'kriteria_id_2');
    }
}
