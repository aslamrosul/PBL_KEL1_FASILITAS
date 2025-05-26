<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LantaiModel extends Model
{
    use HasFactory;

    protected $table = 'm_lantai';
    protected $primaryKey = 'lantai_id';
    protected $fillable = ['gedung_id', 'lantai_nomor'];


    // Relasi dengan tabel gedung (jika ada model Gedung)
    public function gedung()
    {
        return $this->belongsTo(GedungModel::class, 'gedung_id', 'gedung_id');
    }

    public function ruangs()
    {
        return $this->hasMany(RuangModel::class, 'lantai_id');
    }
}