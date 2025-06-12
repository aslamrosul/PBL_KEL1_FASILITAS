<?php

namespace Database\Seeders;

use App\Models\PerbaikanModel;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PerbaikanSeeder extends Seeder
{
    public function run()
    {
        $reports = range(1, 215); // Match laporan_id from LaporanSeeder
        $teknisi = range(6, 10); // Technician IDs, excluding 58
        $statuses = ['diproses', 'selesai'];
        $catatanOptions = [
            'Periksa power supply',
            'Cek kabel koneksi',
            'Periksa komponen internal',
            'Lakukan perawatan rutin',
            'Ganti suku cadang',
        ];
        $repairs = [];

        // Generate 50 repair records
        $selectedReports = array_rand(array_flip($reports), 50);

        // Assign 10 repairs to teknisi_id 58 (Rudi Pratama)
        for ($i = 0; $i < 10; $i++) {
            $laporan_id = array_shift($selectedReports); // Take a unique laporan_id
            $status = $statuses[array_rand($statuses)];
            $month = rand(1, 12);
            $tanggal_mulai = Carbon::create(2025, $month, rand(1, 28), rand(0, 23), rand(0, 59), rand(0, 59));
            $tanggal_selesai = $status === 'selesai' ? $tanggal_mulai->copy()->addHours(rand(2, 12)) : null;
            $total_biaya = $status === 'selesai' && rand(0, 1) ? rand(100000, 1000000) : null;

            $repairs[] = [
                'laporan_id' => $laporan_id,
                'teknisi_id' => 58, // Rudi Pratama
                'tanggal_mulai' => $tanggal_mulai,
                'tanggal_selesai' => $tanggal_selesai,
                'status' => $status,
                'catatan' => $catatanOptions[array_rand($catatanOptions)],
                'total_biaya' => $total_biaya,
                'created_at' => $tanggal_mulai,
                'updated_at' => $tanggal_selesai ?? $tanggal_mulai,
            ];
        }

        // Distribute remaining 40 repairs among other technicians (6–10)
        foreach ($selectedReports as $laporan_id) {
            $status = $statuses[array_rand($statuses)];
            $month = rand(1, 12);
            $tanggal_mulai = Carbon::create(2025, $month, rand(1, 28), rand(0, 23), rand(0, 59), rand(0, 59));
            $tanggal_selesai = $status === 'selesai' ? $tanggal_mulai->copy()->addHours(rand(2, 12)) : null;
            $total_biaya = $status === 'selesai' && rand(0, 1) ? rand(100000, 1000000) : null;

            $repairs[] = [
                'laporan_id' => $laporan_id,
                'teknisi_id' => $teknisi[array_rand($teknisi)], // Random technician excluding 58
                'tanggal_mulai' => $tanggal_mulai,
                'tanggal_selesai' => $tanggal_selesai,
                'status' => $status,
                'catatan' => $catatanOptions[array_rand($catatanOptions)],
                'total_biaya' => $total_biaya,
                'created_at' => $tanggal_mulai,
                'updated_at' => $tanggal_selesai ?? $tanggal_mulai,
            ];
        }

        PerbaikanModel::insert($repairs);
    }
}