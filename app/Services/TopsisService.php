<?php

namespace App\Services;

use App\Models\KriteriaModel;
use App\Models\LaporanModel;
use Illuminate\Support\Facades\Log;

class TopsisService
{
    public static function hitungSkorPrioritas(LaporanModel $laporan): array
    {
        $kriteria = KriteriaModel::all();
        $kriteriaKeys = $kriteria->pluck('kriteria_kode')->map(fn($kode) => strtolower($kode))->toArray();
        $fasilitas = $laporan->fasilitas;

        if (!$fasilitas || !$fasilitas->barang || !$fasilitas->barang->klasifikasi) {
            Log::error('Fasilitas atau data terkait tidak lengkap untuk laporan_id: ' . $laporan->laporan_id);
            return [
                'nilai_kriteria' => array_fill_keys($kriteriaKeys, 0),
                'skor_total' => 0,
                'max_values' => []
            ];
        }

        $batchLaporans = LaporanModel::with(['fasilitas.barang.klasifikasi'])
            ->where('periode_id', $laporan->periode_id)
            ->where('status', 'diterima')
            ->get();

        if ($batchLaporans->isEmpty()) {
            Log::warning('Tidak ada laporan lain dalam periode untuk laporan_id: ' . $laporan->laporan_id);
            return [
                'nilai_kriteria' => array_fill_keys($kriteriaKeys, 0),
                'skor_total' => 0,
                'max_values' => []
            ];
        }

        $matriks = [];
        foreach ($batchLaporans as $lap) {
            try {
                $nilaiKriteria = [];
                foreach ($kriteria as $k) {
                    $kode = strtolower($k->kriteria_kode);
                    $nilaiKriteria[$kode] = match ($kode) {
                        'frekuensi' => self::hitungFrekuensiLaporan($lap->fasilitas->fasilitas_id),
                        'usia' => self::hitungUsiaFasilitas($lap->fasilitas->tahun_pengadaan),
                        'kondisi' => self::hitungKondisiFasilitas($lap->fasilitas->status),
                        'barang' => (float)($lap->fasilitas->barang->bobot_prioritas ?? 0),
                        'klasifikasi' => (float)($lap->fasilitas->barang->klasifikasi->bobot_prioritas ?? 0),
                        default => 0
                    };
                }
            } catch (\Exception $e) {
                Log::error('Error processing bobot_prioritas for laporan_id: ' . $lap->laporan_id, [
                    'barang_id' => $lap->fasilitas->barang->barang_id ?? null,
                    'klasifikasi_id' => $lap->fasilitas->barang->klasifikasi->klasifikasi_id ?? null,
                    'error' => $e->getMessage()
                ]);
                $nilaiKriteria = array_fill_keys($kriteriaKeys, 0);
            }
            $matriks[] = array_merge(['laporan_id' => $lap->laporan_id], $nilaiKriteria);
        }

        $normalized = [];
        foreach ($kriteria as $k) {
            $kode = strtolower($k->kriteria_kode);
            $kolom = array_column($matriks, $kode);
            $sumSquares = sqrt(array_sum(array_map(fn($x) => $x * $x, $kolom)));
            if ($sumSquares === 0.0) {
                Log::warning("Sum of squares is zero for criteria $kode in periode_id: {$laporan->periode_id}");
                foreach ($matriks as $i => $row) {
                    $normalized[$i][$kode] = 0;
                }
                continue;
            }
            foreach ($matriks as $i => $row) {
                $normalized[$i][$kode] = $row[$kode] / $sumSquares;
            }
        }

        $terbobot = [];
        foreach ($normalized as $i => $row) {
            foreach ($kriteria as $k) {
                $kode = strtolower($k->kriteria_kode);
                $terbobot[$i][$kode] = $row[$kode] * $k->bobot;
            }
        }

        $positif = [];
        $negatif = [];
        foreach ($kriteria as $k) {
            $kode = strtolower($k->kriteria_kode);
            $kolom = array_column($terbobot, $kode);
            $positif[$kode] = $k->kriteria_jenis == 'benefit' ? max($kolom) : min($kolom);
            $negatif[$kode] = $k->kriteria_jenis == 'benefit' ? min($kolom) : max($kolom);
        }

        foreach ($terbobot as $i => $row) {
            $jarakPositif = 0;
            $jarakNegatif = 0;
            foreach ($row as $kode => $nilai) {
                $jarakPositif += pow($nilai - $positif[$kode], 2);
                $jarakNegatif += pow($nilai - $negatif[$kode], 2);
            }
            $jarakPositif = sqrt($jarakPositif);
            $jarakNegatif = sqrt($jarakNegatif);
            $skor = ($jarakPositif + $jarakNegatif) != 0 ? $jarakNegatif / ($jarakPositif + $jarakNegatif) : 0;

            if ($matriks[$i]['laporan_id'] == $laporan->laporan_id) {
                return [
                    'nilai_kriteria' => $normalized[$i],
                    'skor_total' => $skor,
                    'max_values' => []
                ];
            }
        }

        return [
            'nilai_kriteria' => array_fill_keys($kriteriaKeys, 0),
            'skor_total' => 0,
            'max_values' => []
        ];
    }
    private static function hitungFrekuensiLaporan($fasilitasId)
    {
        return LaporanModel::where('fasilitas_id', $fasilitasId)->count();
    }

    private static function hitungUsiaFasilitas($tahunPengadaan)
    {
        return now()->year - $tahunPengadaan;
    }

    private static function hitungKondisiFasilitas($status)
    {
        return ['rusak_berat' => 4, 'rusak_sedang' => 3, 'rusak_ringan' => 2, 'baik' => 5][$status] ?? 0;
    }
}
