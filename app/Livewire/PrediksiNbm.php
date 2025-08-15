<?php

namespace App\Livewire;

use App\Services\NBMPredictionService;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class PrediksiNbm extends Component
{
    public $data = [];
    public $predictionResult = null;
    public $apiStatus = 'checking';
    public $modelStats = null;
    public $isLoading = false;
    
    protected NBMPredictionService $predictionService;
    
    public function boot(NBMPredictionService $predictionService)
    {
        $this->predictionService = $predictionService;
    }
    
    public function mount()
    {
        $this->initializeData();
        $this->checkApiHealth();
        $this->loadModelStats();
    }
    
    public function initializeData()
    {
        $currentDate = now();
        $this->data = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = $currentDate->copy()->subMonths($i);
            $this->data[] = [
                'tahun' => $date->year,
                'bulan' => $date->month,
                'month_name' => $date->locale('id')->format('F Y'),
                'kelompok' => '',
                'komoditi' => '',
                'kalori_hari' => ''
            ];
        }
    }
    
    public function checkApiHealth()
    {
        try {
            $result = $this->predictionService->checkHealth();
            $this->apiStatus = $result['success'] ? 'healthy' : 'error';
        } catch (\Exception $e) {
            $this->apiStatus = 'error';
            Log::error('API Health Check Failed: ' . $e->getMessage());
        }
    }
    
    public function loadModelStats()
    {
        try {
            $result = $this->predictionService->getModelStats();
            if ($result['success']) {
                $this->modelStats = $result['stats'];
            }
        } catch (\Exception $e) {
            Log::error('Failed to load model stats: ' . $e->getMessage());
        }
    }
    
    public function loadSampleData()
    {
        $sampleData = [
            ['kelompok' => 'Padi-padian', 'komoditi' => 'Beras', 'kalori' => 45.5],
            ['kelompok' => 'Padi-padian', 'komoditi' => 'Beras', 'kalori' => 47.2],
            ['kelompok' => 'Padi-padian', 'komoditi' => 'Beras', 'kalori' => 46.8],
            ['kelompok' => 'Padi-padian', 'komoditi' => 'Beras', 'kalori' => 48.1],
            ['kelompok' => 'Padi-padian', 'komoditi' => 'Beras', 'kalori' => 47.9],
            ['kelompok' => 'Padi-padian', 'komoditi' => 'Beras', 'kalori' => 49.3]
        ];
        
        foreach ($this->data as $index => $item) {
            if (isset($sampleData[$index])) {
                $this->data[$index]['kelompok'] = $sampleData[$index]['kelompok'];
                $this->data[$index]['komoditi'] = $sampleData[$index]['komoditi'];
                $this->data[$index]['kalori_hari'] = $sampleData[$index]['kalori'];
            }
        }
    }
    
    public function clearData()
    {
        $this->initializeData();
        $this->predictionResult = null;
    }
    
    public function predict()
    {
        $this->validate([
            'data.*.kelompok' => 'required|string',
            'data.*.komoditi' => 'required|string',
            'data.*.kalori_hari' => 'required|numeric|min:0|max:1000'
        ]);
        
        $this->isLoading = true;
        
        try {
            // Prepare data for API
            $apiData = collect($this->data)->map(function ($item) {
                return [
                    'tahun' => (int) $item['tahun'],
                    'bulan' => (int) $item['bulan'],
                    'kelompok' => $item['kelompok'],
                    'komoditi' => $item['komoditi'],
                    'kalori_hari' => (float) $item['kalori_hari']
                ];
            })->toArray();
            
            $result = $this->predictionService->predict($apiData);
            
            if ($result['success']) {
                $this->predictionResult = $result['data'];
                session()->flash('message', 'Prediksi berhasil dibuat!');
            } else {
                session()->flash('error', 'Gagal membuat prediksi: ' . ($result['error'] ?? $result['message'] ?? 'Unknown error'));
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
            Log::error('Prediction failed: ' . $e->getMessage());
        } finally {
            $this->isLoading = false;
        }
    }
    
    public function exportResult()
    {
        if (!$this->predictionResult) {
            return;
        }
        
        $data = [
            'prediction' => $this->predictionResult['prediction'],
            'confidence_interval' => $this->predictionResult['confidence_interval'],
            'model_info' => $this->predictionResult['model_info'],
            'input_summary' => $this->predictionResult['input_summary'],
            'timestamp' => $this->predictionResult['timestamp'],
            'exported_at' => now()->toISOString()
        ];
        
        $filename = 'nbm-prediction-' . now()->format('Y-m-d-H-i-s') . '.json';
        
        return response()->streamDownload(function () use ($data) {
            echo json_encode($data, JSON_PRETTY_PRINT);
        }, $filename, [
            'Content-Type' => 'application/json',
        ]);
    }
    
    public function render()
    {
        return view('livewire.prediksi-nbm');
    }
}
