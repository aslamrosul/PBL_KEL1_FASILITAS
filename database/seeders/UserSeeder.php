<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [];

        // 4 Admin users
        $users[] = [
            'nama' => 'Budi Santoso',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'email' => 'budi.santoso@polinema.ac.id',
            'level_id' => 1,
            'profile_photo' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        $users[] = [
            'nama' => 'Siti Aminah',
            'username' => 'admin2',
            'password' => Hash::make('admin123'),
            'email' => 'siti.aminah@polinema.ac.id',
            'level_id' => 1,
            'profile_photo' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        $users[] = [
            'nama' => 'Agus Wijaya',
            'username' => 'admin3',
            'password' => Hash::make('admin123'),
            'email' => 'agus.wijaya@polinema.ac.id',
            'level_id' => 1,
            'profile_photo' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        $users[] = [
            'nama' => 'Rina Susanti',
            'username' => 'admin4',
            'password' => Hash::make('admin123'),
            'email' => 'rina.susanti@polinema.ac.id',
            'level_id' => 1,
            'profile_photo' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        // 100 Mahasiswa users
        $mahasiswa = [
            ['nama' => 'Ahmad Fauzi', 'username' => 'sarpras', 'email' => 'ahmad.fauzi1@polinema.ac.id'],
            ['nama' => 'Dewi Lestari', 'username' => 'dewilelstari1', 'email' => 'dewi.lestari1@polinema.ac.id'],
            ['nama' => 'Rizki Pratama', 'username' => 'rizkipratama1', 'email' => 'rizki.pratama1@polinema.ac.id'],
            ['nama' => 'Fitri Rahayu', 'username' => 'fitrirahayu1', 'email' => 'fitri.rahayu1@polinema.ac.id'],
            ['nama' => 'Eko Nugroho', 'username' => 'ekonugroho1', 'email' => 'eko.nugroho1@polinema.ac.id'],
            ['nama' => 'Sari Wulandari', 'username' => 'sariwulandari1', 'email' => 'sari.wulandari1@polinema.ac.id'],
            ['nama' => 'Hendra Kurniawan', 'username' => 'hendrakurniawan1', 'email' => 'hendra.kurniawan1@polinema.ac.id'],
            ['nama' => 'Lina Marlina', 'username' => 'linamarlina1', 'email' => 'lina.marlina1@polinema.ac.id'],
            ['nama' => 'Dedi Setiawan', 'username' => 'dedisetiawan1', 'email' => 'dedi.setiawan1@polinema.ac.id'],
            ['nama' => 'Nia Kurniasih', 'username' => 'niakurniasih1', 'email' => 'nia.kurniasih1@polinema.ac.id'],
            ['nama' => 'Arif Hidayat', 'username' => 'arifhidayat1', 'email' => 'arif.hidayat1@polinema.ac.id'],
            ['nama' => 'Maya Sari', 'username' => 'mayasari1', 'email' => 'maya.sari1@polinema.ac.id'],
            ['nama' => 'Bayu Pratama', 'username' => 'bayupratama1', 'email' => 'bayu.pratama1@polinema.ac.id'],
       
           
        ];
        foreach ($mahasiswa as $mhs) {
            $users[] = [
                'nama' => $mhs['nama'],
                'username' => $mhs['username'],
                'password' => Hash::make('password'),
                'email' => $mhs['email'],
                'level_id' => 2,
                'profile_photo' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        // 50 Dosen users
        $dosen = [
            ['nama' => 'Dr. Bambang Suharto', 'username' => 'dosen', 'email' => 'bambang.suharto1@polinema.ac.id'],
            ['nama' => 'Dr. Ani Rahmawati', 'username' => 'anirahmawati1', 'email' => 'ani.rahmawati1@polinema.ac.id'],
            ['nama' => 'Dr. Joko Widodo', 'username' => 'jokowidodo1', 'email' => 'joko.widodo1@polinema.ac.id'],
            ['nama' => 'Dr. Sri Hartati', 'username' => 'srihartati1', 'email' => 'sri.hartati1@polinema.ac.id'],
            ['nama' => 'Dr. Wahyu Hidayat', 'username' => 'wahyuhidayat1', 'email' => 'wahyu.hidayat1@polinema.ac.id'],
            ['nama' => 'Dr. Rina Puspita', 'username' => 'rinapuspita2', 'email' => 'rina.puspita2@polinema.ac.id'],
            ['nama' => 'Dr. Adi Nugroho', 'username' => 'adinugroho2', 'email' => 'adi.nugroho2@polinema.ac.id'],
            ['nama' => 'Dr. Eka Sari', 'username' => 'ekasari2', 'email' => 'eka.sari2@polinema.ac.id'],
            ['nama' => 'Dr. Hasan Basri', 'username' => 'hasanbasri2', 'email' => 'hasan.basri2@polinema.ac.id'],
            ['nama' => 'Dr. Lita Dewi', 'username' => 'litadewi2', 'email' => 'lita.dewi2@polinema.ac.id'],
            ['nama' => 'Dr. Dwi Santoso', 'username' => 'dwisantoso2', 'email' => 'dwi.santoso2@polinema.ac.id'],
            ['nama' => 'Dr. Mira Andini', 'username' => 'miraandini2', 'email' => 'mira.andini2@polinema.ac.id'],
           
         
        ];
        foreach ($dosen as $dsn) {
            $users[] = [
                'nama' => $dsn['nama'],
                'username' => $dsn['username'],
                'password' => Hash::make('password'),
                'email' => $dsn['email'],
                'level_id' => 3,
                'profile_photo' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        // 30 Tendik users
        $tendik = [
            ['nama' => 'Rudi Hermawan', 'username' => 'tendik', 'email' => 'rudi.hermawan3@example.com'],
            ['nama' => 'Siti Fatimah', 'username' => 'sitifatimah3', 'email' => 'siti.fatimah3@example.com'],
            ['nama' => 'Eko Susilo', 'username' => 'ekosusilo3', 'email' => 'eko.susilo3@example.com'],
            ['nama' => 'Ayu Lestari', 'username' => 'ayulestari3', 'email' => 'ayu.lestari3@example.com'],
            ['nama' => 'Bima Sakti', 'username' => 'bimasakti3', 'email' => 'bima.sakti3@example.com'],
            ['nama' => 'Rina Kurniawati', 'username' => 'rinakurniawati3', 'email' => 'rina.kurniawati3@example.com'],
            ['nama' => 'Hadi Santoso', 'username' => 'hadisantoso3', 'email' => 'hadi.santoso3@example.com'],
            ['nama' => 'Lina Septiani', 'username' => 'linaseptiani3', 'email' => 'lina.septiani3@example.com'],
            ['nama' => 'Tono Wijaya', 'username' => 'tonowijaya3', 'email' => 'tono.wijaya3@example.com'],
            ['nama' => 'Mila Sari', 'username' => 'milasari3', 'email' => 'mila.sari3@example.com'],
            ['nama' => 'Andi Prasetyo', 'username' => 'andiprasetyo3', 'email' => 'andi.prasetyo3@example.com'],
            ['nama' => 'Sari Indah', 'username' => 'sariindah3', 'email' => 'sari.indah3@example.com'],
            ['nama' => 'Budi Hartono', 'username' => 'budihartono3', 'email' => 'budi.hartono3@example.com'],
            
        ];
        foreach ($tendik as $tdk) {
            $users[] = [
                'nama' => $tdk['nama'],
                'username' => $tdk['username'],
                'password' => Hash::make('password'),
                'email' => $tdk['email'],
                'level_id' => 4,
                'profile_photo' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        // 30 Sarpras users
        $sarpras = [
            ['nama' => 'Andi Prasetyo', 'username' => 'sarpras', 'email' => 'andi.prasetyo4@example.com'],
            ['nama' => 'Sari Indah', 'username' => 'sariindah4', 'email' => 'sari.indah4@example.com'],
            ['nama' => 'Budi Hartono', 'username' => 'budihartono4', 'email' => 'budi.hartono4@example.com'],
            ['nama' => 'Rina Wulandari', 'username' => 'rinawulandari4', 'email' => 'rina.wulandari4@example.com'],
            ['nama' => 'Dedi Kurniawan', 'username' => 'dedikurniawan4', 'email' => 'dedi.kurniawan4@example.com'],
            ['nama' => 'Lia Safitri', 'username' => 'liasafitri4', 'email' => 'lia.safitri4@example.com'],
            ['nama' => 'Hendra Setiawan', 'username' => 'hendrasetiawan4', 'email' => 'hendra.setiawan4@example.com'],
            ['nama' => 'Tina Marlina', 'username' => 'tinamarlina4', 'email' => 'tina.marlina4@example.com'],
            ['nama' => 'Fajar Nugroho', 'username' => 'fajarnugroho4', 'email' => 'fajar.nugroho4@example.com'],
            ['nama' => 'Mira Puspita', 'username' => 'mirapuspita4', 'email' => 'mira.puspita4@example.com'],
            ['nama' => 'Rudi Pratama', 'username' => 'rudipratama4', 'email' => 'rudi.pratama4@example.com'],
            ['nama' => 'Siti Rahayu', 'username' => 'sitirahayu4', 'email' => 'siti.rahayu4@example.com'],
            ['nama' => 'Eko Wahyudi', 'username' => 'ekowahyudi4', 'email' => 'eko.wahyudi4@example.com'],
            ['nama' => 'Ayu Permata', 'username' => 'ayupermata4', 'email' => 'ayu.permata4@example.com'],
            ['nama' => 'Bima Nugroho', 'username' => 'bimanugroho4', 'email' => 'bima.nugroho4@example.com'],
           
        ];
        foreach ($sarpras as $srp) {
            $users[] = [
                'nama' => $srp['nama'],
                'username' => $srp['username'],
                'password' => Hash::make('password'),
                'email' => $srp['email'],
                'level_id' => 5,
                'profile_photo' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        // 20 Teknisi users
        $teknisi = [
            ['nama' => 'Rudi Pratama', 'username' => 'teknisi', 'email' => 'rudi.pratama5@polinema.ac.id'],
            ['nama' => 'Siti Rahayu', 'username' => 'sitirahayu5', 'email' => 'siti.rahayu5@polinema.ac.id'],
            ['nama' => 'Eko Wahyudi', 'username' => 'ekowahyudi5', 'email' => 'eko.wahyudi5@polinema.ac.id'],
            ['nama' => 'Ayu Permata', 'username' => 'ayupermata5', 'email' => 'ayu.permata5@polinema.ac.id'],
            ['nama' => 'Bima Nugroho', 'username' => 'bimanugroho5', 'email' => 'bima.nugroho5@polinema.ac.id'],
            ['nama' => 'Rina Anggraini', 'username' => 'rinaanggraini5', 'email' => 'rina.anggraini5@polinema.ac.id'],
            ['nama' => 'Hadi Kurniawan', 'username' => 'hadikurniawan5', 'email' => 'hadi.kurniawan5@polinema.ac.id'],
            ['nama' => 'Lina Wulandari', 'username' => 'linawulandari5', 'email' => 'lina.wulandari5@polinema.ac.id'],
            ['nama' => 'Ahmad Zaki', 'username' => 'ahmadzaki5', 'email' => 'ahmad.zaki5@polinema.ac.id'],
            ['nama' => 'Dewi Safitri', 'username' => 'dewifitri5', 'email' => 'dewi.safitri5@polinema.ac.id'],
          
        ];
        foreach ($teknisi as $tkn) {
            $users[] = [
                'nama' => $tkn['nama'],
                'username' => $tkn['username'],
                'password' => Hash::make('password'),
                'email' => $tkn['email'],
                'level_id' => 6,
                'profile_photo' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        // Insert all users into the database
        UserModel::insert($users);
    }
}