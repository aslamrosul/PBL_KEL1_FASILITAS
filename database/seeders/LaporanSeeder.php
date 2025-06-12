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
        $fasilitas = range(1, 135); // Facility IDs (1 to 135)
        $statuses = ['menunggu', 'diproses', 'diterima', 'selesai'];
        $issues = [
            'komputer' => [
                ['judul' => 'Komputer Tidak Menyala', 'deskripsi' => 'Komputer tidak bisa menyala saat dinyalakan'],
                ['judul' => 'Komputer Lambat', 'deskripsi' => 'Komputer berjalan sangat lambat'],
                ['judul' => 'Keyboard Rusak', 'deskripsi' => 'Keyboard tidak berfungsi dengan baik'],
                ['judul' => 'Monitor Mati', 'deskripsi' => 'Monitor tidak menampilkan gambar'],
            ],
            'proyektor' => [
                ['judul' => 'Proyektor Tidak Menyala', 'deskripsi' => 'Proyektor tidak menyala saat digunakan'],
                ['judul' => 'Proyektor Buram', 'deskripsi' => 'Tampilan proyektor buram dan sulit dibaca'],
                ['judul' => 'Kabel Proyektor Hilang', 'deskripsi' => 'Kabel proyektor tidak ditemukan'],
                ['judul' => 'Remote Proyektor Rusak', 'deskripsi' => 'Remote proyektor tidak berfungsi'],
            ],
            'furnitur' => [
                ['judul' => 'Kursi Rusak', 'deskripsi' => 'Kursi patah pada bagian {part}'],
                ['judul' => 'AC Berisik', 'deskripsi' => 'AC mengeluarkan suara berisik'],
                ['judul' => 'Lampu Mati', 'deskripsi' => 'Lampu tidak menyala'],
                ['judul' => 'AC Tidak Dingin', 'deskripsi' => 'AC tidak mengeluarkan udara dingin'],
            ],
            'ruangan' => [
                ['judul' => 'Papan Tulis Rusak', 'deskripsi' => 'Papan tulis sulit dihapus'],
                ['judul' => 'Meja Retak', 'deskripsi' => 'Meja memiliki retakan besar'],
                ['judul' => 'Jendela Macet', 'deskripsi' => 'Jendela tidak bisa dibuka'],
                ['judul' => 'Pintu Berderit', 'deskripsi' => 'Pintu berderit saat dibuka'],
            ],
        ];
        $issueCategories = array_keys($issues); // ['komputer', 'proyektor', 'furnitur', 'ruangan']
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
                $fasilitas_id = $fasilitas[array_rand($fasilitas)]; // Random facility ID (1-135)
                $category = $issueCategories[array_rand($issueCategories)]; // Random issue category
                $issue = $issues[$category][array_rand($issues[$category])]; // Random issue from category
                $part = $parts[array_rand($parts)];
                
                // Replace placeholders in judul and deskripsi
                $judul = $issue['judul'];
                $deskripsi = str_replace('{part}', $part, $issue['deskripsi']);
                
                $status = $statuses[array_rand($statuses)];
                $created_at = Carbon::create(2025, $month, rand(1, 28), rand(0, 23), rand(0, 59), rand(0, 59));
                
                $reports[] = [
                    'user_id' => $users[array_rand($users)],
                    'periode_id' => 1, // Fixed periode_id
                    'fasilitas_id' => $fasilitas_id,
                    'judul' => $judul,
                    'deskripsi' => $deskripsi,
                    'foto_path' => null,
                    'tanggal_lapor' => $created_at,
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