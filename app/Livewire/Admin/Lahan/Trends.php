<?php

namespace App\Livewire\Admin\Lahan;

use Livewire\Component;
use App\Models\LahanData;
use App\Models\LahanTopik;
use App\Models\LahanVariabel;
use App\Models\LahanKlasifikasi;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Trends extends Component
{
    public $selectedTopik = '';
    public $selectedVariabel = '';
    public $selectedKlasifikasi = '';
    public $selectedRegion = '';
    public $predictionYears = 5;
    public $trendPeriod = 'yearly'; // yearly, monthly, quarterly

    public function mount()
    {
        // Initialize with default values if needed
    }

    public function render()
    {
        $topiks = LahanTopik::orderBy('nama')->get();
        $variabels = LahanVariabel::orderBy('nama')->get();
        $klasifikasis = LahanKlasifikasi::orderBy('nama')->get();
        $regions = $this->getRegions();

        // Get trend data
        $trendData = $this->getTrendData();
        $predictionData = $this->getPredictionData();
        $seasonalAnalysis = $this->getSeasonalAnalysis();
        $correlationAnalysis = $this->getCorrelationAnalysis();
        $forecastAccuracy = $this->getForecastAccuracy();

        return view('livewire.admin.lahan.trends', [
            'topiks' => $topiks,
            'variabels' => $variabels,
            'klasifikasis' => $klasifikasis,
            'regions' => $regions,
            'trendData' => $trendData,
            'predictionData' => $predictionData,
            'seasonalAnalysis' => $seasonalAnalysis,
            'correlationAnalysis' => $correlationAnalysis,
            'forecastAccuracy' => $forecastAccuracy,
        ]);
    }

    private function getRegions()
    {
        return LahanData::select('wilayah')
            ->distinct()
            ->whereNotNull('wilayah')
            ->orderBy('wilayah')
            ->pluck('wilayah')
            ->toArray();
    }

    private function getTrendData()
    {
        $query = LahanData::with(['topik', 'variabel', 'klasifikasi']);

        // Apply filters
        if ($this->selectedTopik) {
            $query->where('lahan_topik_id', $this->selectedTopik);
        }
        if ($this->selectedVariabel) {
            $query->where('lahan_variabel_id', $this->selectedVariabel);
        }
        if ($this->selectedKlasifikasi) {
            $query->where('lahan_klasifikasi_id', $this->selectedKlasifikasi);
        }
        if ($this->selectedRegion) {
            $query->where('wilayah', $this->selectedRegion);
        }

        // Group by time period
        if ($this->trendPeriod === 'yearly') {
            $data = $query->selectRaw('tahun as period, AVG(nilai) as avg_value, COUNT(*) as count')
                ->groupBy('tahun')
                ->orderBy('period')
                ->get();
        } elseif ($this->trendPeriod === 'monthly') {
            // For monthly, we'll simulate monthly data based on yearly data
            $data = $query->selectRaw('tahun, AVG(nilai) as avg_value, COUNT(*) as count')
                ->groupBy('tahun')
                ->orderBy('tahun')
                ->get()
                ->map(function ($item) {
                    $item->period = $item->tahun . '-01'; // Use January as representative month
                    return $item;
                });
        } else { // quarterly
            // For quarterly, we'll simulate quarterly data based on yearly data
            $data = $query->selectRaw('tahun, AVG(nilai) as avg_value, COUNT(*) as count')
                ->groupBy('tahun')
                ->orderBy('tahun')
                ->get()
                ->map(function ($item) {
                    $item->period = $item->tahun . '-Q1'; // Use Q1 as representative quarter
                    return $item;
                });
        }

        return $data;
    }

    private function getPredictionData()
    {
        $trendData = $this->getTrendData();
        
        if ($trendData->count() < 2) {
            return collect();
        }

        // Simple linear regression for prediction
        $values = $trendData->pluck('avg_value')->toArray();
        $periods = range(1, count($values));
        
        $n = count($values);
        $sumX = array_sum($periods);
        $sumY = array_sum($values);
        $sumXY = 0;
        $sumX2 = 0;
        
        for ($i = 0; $i < $n; $i++) {
            $sumXY += $periods[$i] * $values[$i];
            $sumX2 += $periods[$i] * $periods[$i];
        }
        
        $slope = ($n * $sumXY - $sumX * $sumY) / ($n * $sumX2 - $sumX * $sumX);
        $intercept = ($sumY - $slope * $sumX) / $n;
        
        // Generate predictions
        $predictions = collect();
        $lastPeriod = $trendData->last()->period;
        
        for ($i = 1; $i <= $this->predictionYears; $i++) {
            $nextPeriodValue = $intercept + $slope * ($n + $i);
            $nextPeriod = $this->getNextPeriod($lastPeriod, $i);
            
            $predictions->push([
                'period' => $nextPeriod,
                'predicted_value' => max(0, $nextPeriodValue), // Ensure non-negative
                'confidence_interval' => [
                    'lower' => max(0, $nextPeriodValue * 0.85),
                    'upper' => $nextPeriodValue * 1.15
                ]
            ]);
        }
        
        return $predictions;
    }

    private function getNextPeriod($lastPeriod, $increment)
    {
        if ($this->trendPeriod === 'yearly') {
            return (int)$lastPeriod + $increment;
        } elseif ($this->trendPeriod === 'monthly') {
            $date = Carbon::createFromFormat('Y-m', $lastPeriod);
            return $date->addMonths($increment)->format('Y-m');
        } else { // quarterly
            $parts = explode('-Q', $lastPeriod);
            $year = (int)$parts[0];
            $quarter = (int)$parts[1];
            
            $totalQuarters = ($year - 2000) * 4 + $quarter + $increment;
            $newYear = 2000 + intval(($totalQuarters - 1) / 4);
            $newQuarter = (($totalQuarters - 1) % 4) + 1;
            
            return $newYear . '-Q' . $newQuarter;
        }
    }

    private function getSeasonalAnalysis()
    {
        if ($this->trendPeriod !== 'monthly') {
            return collect();
        }

        $query = LahanData::query();
        
        // Apply filters
        if ($this->selectedTopik) {
            $query->where('lahan_topik_id', $this->selectedTopik);
        }
        if ($this->selectedVariabel) {
            $query->where('lahan_variabel_id', $this->selectedVariabel);
        }
        if ($this->selectedKlasifikasi) {
            $query->where('lahan_klasifikasi_id', $this->selectedKlasifikasi);
        }
        if ($this->selectedRegion) {
            $query->where('wilayah', $this->selectedRegion);
        }

        // Since we only have yearly data, simulate seasonal patterns
        $seasonalData = collect();
        $avgValue = $query->avg('nilai') ?: 0;
        $totalCount = $query->count();
        
        for ($month = 1; $month <= 12; $month++) {
            // Add some seasonal variation
            $seasonalMultiplier = 1 + (sin(($month - 1) * pi() / 6) * 0.2);
            $seasonalData->push((object) [
                'month' => $month,
                'avg_value' => $avgValue * $seasonalMultiplier,
                'count' => $totalCount
            ]);
        }
        
        return $seasonalData->map(function ($item) {
            $monthNames = [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            ];
            return [
                'month_name' => $monthNames[$item->month],
                'avg_value' => round($item->avg_value, 2),
                'count' => $item->count
            ];
        });
    }

    private function getCorrelationAnalysis()
    {
        // Analyze correlation between different variables
        $correlations = collect();
        
        if (!$this->selectedTopik) {
            return $correlations;
        }

        $variabels = LahanVariabel::all();
        
        foreach ($variabels as $var1) {
            foreach ($variabels as $var2) {
                if ($var1->id >= $var2->id) continue;
                
                $data1 = LahanData::where('lahan_topik_id', $this->selectedTopik)
                    ->where('lahan_variabel_id', $var1->id)
                    ->pluck('nilai')
                    ->toArray();
                    
                $data2 = LahanData::where('lahan_topik_id', $this->selectedTopik)
                    ->where('lahan_variabel_id', $var2->id)
                    ->pluck('nilai')
                    ->toArray();
                
                if (count($data1) > 1 && count($data2) > 1) {
                    $correlation = $this->calculateCorrelation($data1, $data2);
                    
                    $correlations->push([
                        'variable1' => $var1->nama,
                        'variable2' => $var2->nama,
                        'correlation' => $correlation,
                        'strength' => $this->getCorrelationStrength($correlation)
                    ]);
                }
            }
        }
        
        return $correlations->sortByDesc('correlation')->take(10);
    }

    private function calculateCorrelation($x, $y)
    {
        $n = min(count($x), count($y));
        if ($n < 2) return 0;
        
        $x = array_slice($x, 0, $n);
        $y = array_slice($y, 0, $n);
        
        $meanX = array_sum($x) / $n;
        $meanY = array_sum($y) / $n;
        
        $numerator = 0;
        $sumSqX = 0;
        $sumSqY = 0;
        
        for ($i = 0; $i < $n; $i++) {
            $numerator += ($x[$i] - $meanX) * ($y[$i] - $meanY);
            $sumSqX += pow($x[$i] - $meanX, 2);
            $sumSqY += pow($y[$i] - $meanY, 2);
        }
        
        $denominator = sqrt($sumSqX * $sumSqY);
        
        return $denominator == 0 ? 0 : $numerator / $denominator;
    }

    private function getCorrelationStrength($correlation)
    {
        $abs = abs($correlation);
        if ($abs >= 0.8) return 'Sangat Kuat';
        if ($abs >= 0.6) return 'Kuat';
        if ($abs >= 0.4) return 'Sedang';
        if ($abs >= 0.2) return 'Lemah';
        return 'Sangat Lemah';
    }

    private function getForecastAccuracy()
    {
        // Calculate accuracy metrics for the prediction model
        $trendData = $this->getTrendData();
        
        if ($trendData->count() < 4) {
            return [
                'mae' => 0,
                'rmse' => 0,
                'mape' => 0,
                'accuracy_percentage' => 0
            ];
        }

        // Use last 20% of data for validation
        $validationSize = max(1, intval($trendData->count() * 0.2));
        $trainingData = $trendData->take($trendData->count() - $validationSize);
        $validationData = $trendData->skip($trendData->count() - $validationSize);
        
        // Simple moving average prediction
        $predictions = collect();
        $windowSize = min(3, $trainingData->count());
        
        foreach ($validationData as $actual) {
            $recentValues = $trainingData->slice(-$windowSize)->pluck('avg_value');
            $prediction = $recentValues->avg();
            $predictions->push($prediction);
        }
        
        // Calculate accuracy metrics
        $actualValues = $validationData->pluck('avg_value');
        $mae = $this->calculateMAE($actualValues->toArray(), $predictions->toArray());
        $rmse = $this->calculateRMSE($actualValues->toArray(), $predictions->toArray());
        $mape = $this->calculateMAPE($actualValues->toArray(), $predictions->toArray());
        
        return [
            'mae' => $mae,
            'rmse' => $rmse,
            'mape' => $mape,
            'accuracy_percentage' => max(0, 100 - $mape)
        ];
    }

    private function calculateMAE($actual, $predicted)
    {
        $sum = 0;
        $n = count($actual);
        for ($i = 0; $i < $n; $i++) {
            $sum += abs($actual[$i] - $predicted[$i]);
        }
        return $n > 0 ? $sum / $n : 0;
    }

    private function calculateRMSE($actual, $predicted)
    {
        $sum = 0;
        $n = count($actual);
        for ($i = 0; $i < $n; $i++) {
            $sum += pow($actual[$i] - $predicted[$i], 2);
        }
        return $n > 0 ? sqrt($sum / $n) : 0;
    }

    private function calculateMAPE($actual, $predicted)
    {
        $sum = 0;
        $n = count($actual);
        for ($i = 0; $i < $n; $i++) {
            if ($actual[$i] != 0) {
                $sum += abs(($actual[$i] - $predicted[$i]) / $actual[$i]) * 100;
            }
        }
        return $n > 0 ? $sum / $n : 0;
    }
}
