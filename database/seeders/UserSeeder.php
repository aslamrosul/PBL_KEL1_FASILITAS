<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        UserModel::insert([
            [
                'nama' => 'Admin Sistem',
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'email' => 'admin@polinema.ac.id',
                'level_id' => 1,
                'profile_photo' => null,
            ],
            [
                'nama' => 'Mahasiswa Contoh',
                'username' => 'mahasiswa',
                'password' => Hash::make('password'),
                'email' => 'mahasiswa@polinema.ac.id',
                'level_id' => 2,
                'profile_photo' => null,
            ],
        
            [
                'nama' => 'Dosen Contoh',
                'username' => 'dosen',
                'password' => Hash::make('password'),
                'email' => 'dosen@polinema.ac.id',
                'level_id' => 3,
                'profile_photo' => null,
            ],
                [
                'nama' => 'Citra Tendik',
                'username' => 'tendik',
                'password' => Hash::make('password'),
                'email' => 'tendik@example.com',
                'level_id' => 4, // Tenaga Kependidikan
                'profile_photo' => null,

            ],
            [
                'nama' => 'Andi Sarpras',
                'username' => 'sarpras',
                'password' => Hash::make('password'),
                'email' => 'sarpras@example.com',
                'level_id' => 5, // Sarpras
                'profile_photo' => null,
            ],
            [
                'nama' => 'Teknisi Contoh',
                'username' => 'teknisi',
                'password' => Hash::make('password'),
                'email' => 'teknisi@polinema.ac.id',
                'level_id' => 6,
                'profile_photo' => null,
            ],

        ]);
    }
}
