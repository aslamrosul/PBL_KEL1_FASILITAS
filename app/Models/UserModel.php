<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use Illuminate\Foundation\Auth\User as Authenticatable; // implementasi class Authenticatable




class UserModel extends Authenticatable
{


    use HasFactory, Notifiable;

    protected $table = 'm_user';
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'nama',
        'username',
        'password',
        'email',
        'level_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = ['password' => 'hashed']; // casting password agar otomatis di hash


    public function level()
    {
        return $this->belongsTo(LevelMOdel::class, 'level_id');
    }

    /**
     * Mendapatkan nama role
     */
    public function getRoleName(): string
    {
        return $this->level->level_nama;
    }

    /**
     * Cek apakah user memiliki role tertentu
     */
    public function hasRole($role): bool
    {
        return $this->level->level_kode === $role;
    }

    /**
     * Mendapatkan kode role
     */
    public function getRole()
    {
        return $this->level->level_kode;
    }

    public function laporans()
    {
        return $this->hasMany(LaporanModel::class, 'user_id');
    }
}
