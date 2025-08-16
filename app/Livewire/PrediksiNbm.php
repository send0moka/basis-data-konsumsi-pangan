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
    public $komoditiOptions = [];
    
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
        $this->komoditiOptions = $this->getKomoditiOptions();
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
    
    public function updatedData($value, $key)
    {
        // Check if the updated field is a kelompok field
        if (str_contains($key, 'kelompok')) {
            // Extract the index from the key (e.g., '0.kelompok' -> 0)
            $index = explode('.', $key)[0];
            
            // Reset komoditi when kelompok changes
            if (isset($this->data[$index])) {
                $this->data[$index]['komoditi'] = '';
            }
            
            // Update komoditi options
            $this->komoditiOptions = $this->getKomoditiOptions();
        }
    }
    
    protected function getKomoditiOptions()
    {
        return [
            'Padi-padian' => [
                ['value' => 'Beras', 'label' => 'Beras'],
                ['value' => 'Jagung', 'label' => 'Jagung'],
                ['value' => 'Gandum', 'label' => 'Gandum'],
                ['value' => 'Sorgum', 'label' => 'Sorgum'],
                ['value' => 'Ketan', 'label' => 'Ketan']
            ],
            'Umbi-umbian' => [
                ['value' => 'Ubi kayu', 'label' => 'Ubi kayu'],
                ['value' => 'Ubi jalar', 'label' => 'Ubi jalar'],
                ['value' => 'Talas', 'label' => 'Talas'],
                ['value' => 'Ganyong', 'label' => 'Ganyong']
            ],
            'Ikan/udang/cumi/kerang' => [
                ['value' => 'Ikan segar', 'label' => 'Ikan segar'],
                ['value' => 'Ikan asin', 'label' => 'Ikan asin'],
                ['value' => 'Udang', 'label' => 'Udang'],
                ['value' => 'Cumi', 'label' => 'Cumi'],
                ['value' => 'Kerang', 'label' => 'Kerang']
            ],
            'Daging' => [
                ['value' => 'Daging sapi', 'label' => 'Daging sapi'],
                ['value' => 'Daging ayam', 'label' => 'Daging ayam'],
                ['value' => 'Daging kambing', 'label' => 'Daging kambing'],
                ['value' => 'Daging bebek', 'label' => 'Daging bebek']
            ],
            'Telur dan susu' => [
                ['value' => 'Telur ayam', 'label' => 'Telur ayam'],
                ['value' => 'Telur bebek', 'label' => 'Telur bebek'],
                ['value' => 'Susu sapi', 'label' => 'Susu sapi'],
                ['value' => 'Susu kambing', 'label' => 'Susu kambing']
            ],
            'Sayur-sayuran' => [
                ['value' => 'Bayam', 'label' => 'Bayam'],
                ['value' => 'Kangkung', 'label' => 'Kangkung'],
                ['value' => 'Sawi', 'label' => 'Sawi'],
                ['value' => 'Wortel', 'label' => 'Wortel']
            ],
            'Kacang-kacangan' => [
                ['value' => 'Kacang tanah', 'label' => 'Kacang tanah'],
                ['value' => 'Kacang hijau', 'label' => 'Kacang hijau'],
                ['value' => 'Kedelai', 'label' => 'Kedelai'],
                ['value' => 'Kacang merah', 'label' => 'Kacang merah']
            ],
            'Buah-buahan' => [
                ['value' => 'Pisang', 'label' => 'Pisang'],
                ['value' => 'Jeruk', 'label' => 'Jeruk'],
                ['value' => 'Mangga', 'label' => 'Mangga'],
                ['value' => 'Apel', 'label' => 'Apel']
            ],
            'Minyak dan lemak' => [
                ['value' => 'Minyak goreng', 'label' => 'Minyak goreng'],
                ['value' => 'Mentega', 'label' => 'Mentega'],
                ['value' => 'Margarin', 'label' => 'Margarin']
            ],
            'Bahan minuman' => [
                ['value' => 'Kopi', 'label' => 'Kopi'],
                ['value' => 'Teh', 'label' => 'Teh'],
                ['value' => 'Coklat', 'label' => 'Coklat']
            ],
            'Bumbu-bumbuan' => [
                ['value' => 'Bawang merah', 'label' => 'Bawang merah'],
                ['value' => 'Bawang putih', 'label' => 'Bawang putih'],
                ['value' => 'Cabai', 'label' => 'Cabai'],
                ['value' => 'Kunyit', 'label' => 'Kunyit']
            ],
            'Konsumsi lainnya' => [
                ['value' => 'Gula', 'label' => 'Gula'],
                ['value' => 'Garam', 'label' => 'Garam'],
                ['value' => 'Kecap', 'label' => 'Kecap'],
                ['value' => 'Saus', 'label' => 'Saus']
            ]
        ];
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
