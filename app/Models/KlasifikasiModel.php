<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KlasifikasiModel extends Model
{
    use HasFactory;

    protected $table = 'm_klasifikasi';
    protected $primaryKey = 'klasifikasi_id';

    protected $fillable = ['klasifikasi_kode', 'klasifikasi_nama'];
}