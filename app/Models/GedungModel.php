<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GedungModel extends Model
{
   use HasFactory;

    protected $table = 'm_gedung';
    protected $primaryKey = 'gedung_id';
    protected $fillable = ['gedung_kode', 'gedung_nama'];

    public function lantais()
    {
        return $this->hasMany(LantaiModel::class, 'gedung_id');
    }
}