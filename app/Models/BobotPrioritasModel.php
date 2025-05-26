<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BobotPrioritasModel extends Model
{
      use HasFactory;

    protected $table = 'm_bobot_prioritas';
    protected $primaryKey = 'bobot_id';
    protected $fillable = [
        'bobot_kode',
        'bobot_nama',
        'skor_min',
        'skor_max',
        'tindakan'
    ];
}
