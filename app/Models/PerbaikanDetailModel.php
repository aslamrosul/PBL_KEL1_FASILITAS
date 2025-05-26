<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerbaikanDetailModel extends Model
{
    use HasFactory;

    protected $table = 't_perbaikan_detail';
    protected $primaryKey = 'detail_id';
    protected $fillable = [
        'perbaikan_id',
        'tindakan',
        'deskripsi',
        'bahan',
        'biaya'
    ];

    public function perbaikan()
    {
        return $this->belongsTo(PerbaikanModel::class, 'perbaikan_id');
    }
}
