<?php

namespace Database\Seeders;

use App\Models\LaporanModel;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class LaporanSeeder extends Seeder
{
    public function run()
    {
        $reports = [];
        $targetReports = 215; // Slightly above 200
        $months = 12;
        
        // Sample data for randomization
        $users = range(5, 20); // User IDs (students and lecturers)
        $fasilitas = [1, 2, 3, 4]; // Facility IDs
        $statuses = ['menunggu', 'diproses', 'diterima', 'selesai'];
        $issues = [
            1 => [
                ['judul' => 'Komputer Tidak Menyala', 'deskripsi' => 'Komputer di Lab {lab} tidak bisa menyala saat dinyalakan'],
                ['judul' => 'Komputer Lambat', 'deskripsi' => 'Komputer di Lab {lab} berjalan sangat lambat'],
                ['judul' => 'Keyboard Rusak', 'deskripsi' => 'Keyboard di Lab {lab} tidak berfungsi dengan baik'],
                ['judul' => 'Monitor Mati', 'deskripsi' => 'Monitor di Lab {lab} tidak menampilkan gambar'],
            ],
            2 => [
                ['judul' => 'Proyektor Tidak Menyala', 'deskripsi' => 'Proyektor di ruang {room} tidak menyala saat digunakan'],
                ['judul' => 'Proyektor Buram', 'deskripsi' => 'Tampilan proyektor di ruang {room} buram dan sulit dibaca'],
                ['judul' => 'Kabel Proyektor Hilang', 'deskripsi' => 'Kabel proyektor di ruang {room} tidak ditemukan'],
                ['judul' => 'Remote Proyektor Rusak', 'deskripsi' => 'Remote proyektor di ruang {room} tidak berfungsi'],
            ],
            3 => [
                ['judul' => 'Kursi Rusak', 'deskripsi' => 'Kursi di ruang {room} patah pada bagian {part}'],
                ['judul' => 'AC Berisik', 'deskripsi' => 'AC di ruang {room} mengeluarkan suara berisik'],
                ['judul' => 'Lampu Mati', 'deskripsi' => 'Lampu di ruang {room} tidak menyala'],
                ['judul' => 'AC Tidak Dingin', 'deskripsi' => 'AC di ruang {room} tidak mengeluarkan udara dingin'],
            ],
            4 => [
                ['judul' => 'Papan Tulis Rusak', 'deskripsi' => 'Papan tulis di ruang {room} sulit dihapus'],
                ['judul' => 'Meja Retak', 'deskripsi' => 'Meja di ruang {room} memiliki retakan besar'],
                ['judul' => 'Jendela Macet', 'deskripsi' => 'Jendela di ruang {room} tidak bisa dibuka'],
                ['judul' => 'Pintu Berderit', 'deskripsi' => 'Pintu di ruang {room} berderit saat dibuka'],
            ],
        ];
        $rooms = ['A-101', 'A-102', 'B-203', 'B-204', 'C-104', 'C-105', 'Lab Komputer 1', 'Lab Komputer 2', 'Ruang Seminar', 'Ruang Dosen'];
        $parts = ['sandaran', 'kaki', 'dudukan', 'lengan'];

        // Generate random number of reports per month with significant variation
        $reportsPerMonth = [];
        $totalAssigned = 0;
        for ($month = 1; $month <= $months; $month++) {
            // Random number of reports, skewed for significant variation (5 to 35)
            $minReports = 5;
            $maxReports = 35;
            $reportsThisMonth = rand($minReports, $maxReports);
            
            // Adjust for the last month to meet the target
            if ($month == $months) {
                $reportsThisMonth = max($minReports, $targetReports - $totalAssigned);
            } elseif ($totalAssigned + $reportsThisMonth > $targetReports) {
                $reportsThisMonth = $targetReports - $totalAssigned;
            }
            
            $reportsPerMonth[$month] = $reportsThisMonth;
            $totalAssigned += $reportsThisMonth;
            
            if ($totalAssigned >= $targetReports) {
                break;
            }
        }

        // If we haven't reached the target, distribute remaining reports randomly
        while ($totalAssigned < $targetReports) {
            $randomMonth = rand(1, $months);
            $reportsPerMonth[$randomMonth]++;
            $totalAssigned++;
        }

        // Generate reports for each month
        foreach ($reportsPerMonth as $month => $count) {
            for ($i = 0; $i < $count; $i++) {
                $fasilitas_id = $fasilitas[array_rand($fasilitas)];
                $issue = $issues[$fasilitas_id][array_rand($issues[$fasilitas_id])];
                $room = $rooms[array_rand($rooms)];
                $part = $parts[array_rand($parts)];
                
                // Replace placeholders in judul and deskripsi
                $judul = str_replace('{lab}', 'Komputer ' . rand(1, 5), $issue['judul']);
                $deskripsi = str_replace(['{lab}', '{room}', '{part}'], ['Komputer ' . rand(1, 5), $room, $part], $issue['deskripsi']);
                
                $status = $statuses[array_rand($statuses)];
                $created_at = Carbon::create(2025, $month, rand(1, 28), rand(0, 23), rand(0, 59), rand(0, 59));
                
                $reports[] = [
                    'user_id' => $users[array_rand($users)],
                    'periode_id' => 1, // Fixed periode_id
                    'fasilitas_id' => $fasilitas_id,
                    'judul' => $judul,
                    'deskripsi' => $deskripsi,
                    'foto_path' => null,
                    'bobot_id' => null,
                    'status' => $status,
                    'alasan_penolakan' => ($status == 'selesai' && rand(0, 4) == 0) ? 'Kerusakan dianggap minor dan tidak memerlukan perbaikan segera' : null,
                    'tanggal_selesai' => ($status == 'selesai') ? $created_at->copy()->addDays(rand(1, 7)) : null,
                    'created_at' => $created_at,
                    'updated_at' => $created_at,
                ];
            }
        }

        // Insert all reports at once
        LaporanModel::insert($reports);
    }
}