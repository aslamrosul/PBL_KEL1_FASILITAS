<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifikasiModel extends Model
{
    use HasFactory;

    protected $table = 'notifikasi';
    protected $primaryKey = 'notifikasi_id';
    protected $fillable = ['judul', 'pesan', 'user_id', 'laporan_id', 'tipe', 'dibaca'];

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }

    public function laporan()
    {
        return $this->belongsTo(LaporanModel::class, 'laporan_id');
    }
}
