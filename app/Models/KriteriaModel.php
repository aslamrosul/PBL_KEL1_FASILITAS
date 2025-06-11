<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;

class KriteriaModel extends Model
{
    use HasFactory;

    protected $table = 'm_kriteria';
    protected $primaryKey = 'kriteria_id';
    protected $fillable = ['kriteria_kode', 'kriteria_nama', 'bobot', 'kriteria_jenis'];

    public function alternatifNilai(): HasMany
    {
        return $this->hasMany(AlternatifNilaiModel::class, 'kriteria_id');
    }

    public function pairwiseComparisons1(): HasMany
    {
        return $this->hasMany(PairwiseKriteriaModel::class, 'kriteria_id_1');
    }

    public function pairwiseComparisons2(): HasMany
    {
        return $this->hasMany(PairwiseKriteriaModel::class, 'kriteria_id_2');
    }

    public static function calculateAHPWeights()
    {
        $kriteria = self::all();
        $n = $kriteria->count();
        if ($n == 0) {
            return [];
        }

        // Build pairwise comparison matrix
        $matrix = array_fill(0, $n, array_fill(0, $n, 1.0));
        foreach ($kriteria as $i => $k1) {
            foreach ($kriteria as $j => $k2) {
                if ($i == $j) {
                    $matrix[$i][$j] = 1.0;
                } elseif ($i < $j) {
                    $pair = PairwiseKriteriaModel::where('kriteria_id_1', $k1->kriteria_id)
                        ->where('kriteria_id_2', $k2->kriteria_id)
                        ->first();
                    $matrix[$i][$j] = $pair ? $pair->nilai : 1.0;
                    $matrix[$j][$i] = $pair ? 1 / $pair->nilai : 1.0;
                }
            }
        }

        // Normalize matrix
        $columnSums = array_fill(0, $n, 0);
        for ($j = 0; $j < $n; $j++) {
            for ($i = 0; $i < $n; $i++) {
                $columnSums[$j] += $matrix[$i][$j];
            }
        }

        $normalized = array_fill(0, $n, array_fill(0, $n, 0));
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $normalized[$i][$j] = $columnSums[$j] > 0 ? $matrix[$i][$j] / $columnSums[$j] : 0;
            }
        }

        // Calculate weights
        $weights = array_fill(0, $n, 0);
        for ($i = 0; $i < $n; $i++) {
            $rowSum = array_sum($normalized[$i]);
            $weights[$i] = $rowSum / $n;
        }

        // Consistency check (simplified)
        $lambdaMax = 0;
        for ($i = 0; $i < $n; $i++) {
            $sum = 0;
            for ($j = 0; $j < $n; $j++) {
                $sum += $matrix[$i][$j] * $weights[$j];
            }
            $lambdaMax += $sum / ($weights[$i] > 0 ? $weights[$i] : 1);
        }
        $lambdaMax /= $n;

        $CI = ($lambdaMax - $n) / ($n - 1);
        $RI = [0, 0, 0.58, 0.90, 1.12, 1.24, 1.32, 1.41, 1.45]; // Random Index for n=1 to 9
        $CR = $n > 1 && isset($RI[$n]) ? $CI / $RI[$n] : 0;

        if ($CR > 0.1) {
            Log::warning('AHP consistency ratio too high', ['CR' => $CR]);
        }

        // Update bobot in KriteriaModel
        foreach ($kriteria as $i => $k) {
            $k->update(['bobot' => $weights[$i]]);
        }

        return $weights;
    }
}
