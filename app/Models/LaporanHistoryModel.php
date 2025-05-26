<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanHistoryModel extends Model
{
    use HasFactory;

    protected $table = 't_laporan_history';
    protected $primaryKey = 'history_id';
    protected $fillable = [
        'laporan_id',
        'user_id',
        'aksi',
        'keterangan'
    ];

    public function laporan()
    {
        return $this->belongsTo(LaporanModel::class, 'laporan_id');
    }

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }
}
