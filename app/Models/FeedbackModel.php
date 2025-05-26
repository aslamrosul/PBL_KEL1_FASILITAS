<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackModel extends Model
{
    use HasFactory;

    protected $table = 't_feedback';
    protected $primaryKey = 'feedback_id';
    protected $fillable = [
        'laporan_id',
        'rating',
        'komentar'
    ];

    public function laporan()
    {
        return $this->belongsTo(LaporanModel::class, 'laporan_id');
    }
}
