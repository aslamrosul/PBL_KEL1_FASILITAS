<?php

namespace Database\Seeders;

use App\Models\PerbaikanDetailModel;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PerbaikanDetailSeeder extends Seeder
{
    public function run()
    {
        $details = [];
        $tindakanOptions = [
            'komputer' => [
                ['tindakan' => 'Ganti power supply', 'deskripsi' => 'Power supply komputer diganti dengan yang baru'],
                ['tindakan' => 'Perbaiki keyboard', 'deskripsi' => 'Keyboard dibersihkan dan diperbaiki'],
                ['tindakan' => 'Ganti monitor', 'deskripsi' => 'Monitor diganti karena tidak menampilkan gambar'],
                ['tindakan' => 'Optimasi sistem', 'deskripsi' => 'Sistem dioptimasi untuk meningkatkan kecepatan'],
            ],
            'proyektor' => [
                ['tindakan' => 'Ganti lampu proyektor', 'deskripsi' => 'Lampu proyektor diganti untuk memperbaiki tampilan'],
                ['tindakan' => 'Perbaiki remote', 'deskripsi' => 'Remote proyektor diperbaiki agar berfungsi kembali'],
                ['tindakan' => 'Pasang kabel baru', 'deskripsi' => 'Kabel proyektor yang hilang diganti'],
                ['tindakan' => 'Kalibrasi proyektor', 'deskripsi' => 'Proyektor dikalibrasi untuk memperjelas gambar'],
            ],
            'furnitur' => [
                ['tindakan' => 'Perbaiki kursi', 'deskripsi' => 'Kursi yang patah diperbaiki pada bagian {part}'],
                ['tindakan' => 'Servis AC', 'deskripsi' => 'AC diservis untuk mengatasi suara berisik'],
                ['tindakan' => 'Ganti lampu', 'deskripsi' => 'Lampu yang mati diganti dengan yang baru'],
                ['tindakan' => 'Isi freon AC', 'deskripsi' => 'Freon AC diisi ulang agar dingin kembali'],
            ],
            'ruangan' => [
                ['tindakan' => 'Ganti papan tulis', 'deskripsi' => 'Papan tulis diganti karena sulit dihapus'],
                ['tindakan' => 'Perbaiki meja', 'deskripsi' => 'Meja yang retak diperbaiki dengan pengelasan'],
                ['tindakan' => 'Perbaiki jendela', 'deskripsi' => 'Jendela yang macet diperbaiki agar bisa dibuka'],
                ['tindakan' => 'Pelumas pintu', 'deskripsi' => 'Pintu yang berderit diberi pelumas'],
            ],
        ];
        $issueCategories = array_keys($tindakanOptions);
        $parts = ['sandaran', 'kaki', 'dudukan', 'lengan'];

        // Generate details for each perbaikan_id (1 to 50 from PerbaikanSeeder)
        for ($perbaikan_id = 1; $perbaikan_id <= 50; $perbaikan_id++) {
            $category = $issueCategories[array_rand($issueCategories)];
            $tindakan = $tindakanOptions[$category][array_rand($tindakanOptions[$category])];
            $part = $parts[array_rand($parts)];
            $deskripsi = str_replace('{part}', $part, $tindakan['deskripsi']);

            // Approximate timestamps based on PerbaikanSeeder
            $month = rand(1, 12);
            $created_at = Carbon::create(2025, $month, rand(1, 28), rand(0, 23), rand(0, 59), rand(0, 59));

            $details[] = [
                'perbaikan_id' => $perbaikan_id,
                'tindakan' => $tindakan['tindakan'],
                'deskripsi' => $deskripsi,
                'created_at' => $created_at,
                'updated_at' => $created_at,
            ];
        }

        PerbaikanDetailModel::insert($details);
    }
}