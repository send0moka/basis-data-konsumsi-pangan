<?php

namespace App\Livewire\Admin\Lahan;

use App\Models\LahanData;
use App\Models\LahanTopik;
use App\Models\LahanVariabel;
use App\Models\LahanKlasifikasi;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Maps extends Component
{
    public $selectedTopik = '';
    public $selectedVariabel = '';
    public $selectedKlasifikasi = '';
    public $selectedYear = '';
    
    public $mapData = [];
    public $topiks = [];
    public $variabels = [];
    public $klasifikasis = [];
    public $years = [];
    
    public $totalData = 0;
    public $averageValue = 0;
    public $maxValue = 0;
    public $minValue = 0;

    public function mount()
    {
        $this->loadFilters();
        $this->loadMapData();
    }

    public function updatedSelectedTopik()
    {
        $this->loadMapData();
        $this->dispatch('mapDataUpdated');
    }

    public function updatedSelectedVariabel()
    {
        $this->loadMapData();
        $this->dispatch('mapDataUpdated');
    }

    public function updatedSelectedKlasifikasi()
    {
        $this->loadMapData();
        $this->dispatch('mapDataUpdated');
    }

    public function updatedSelectedYear()
    {
        $this->loadMapData();
        $this->dispatch('mapDataUpdated');
    }

    private function loadFilters()
    {
        $this->topiks = LahanTopik::orderBy('nama')->get();
        $this->variabels = LahanVariabel::orderBy('nama')->get();
        $this->klasifikasis = LahanKlasifikasi::orderBy('nama')->get();
        $this->years = LahanData::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun')
            ->toArray();
    }

    private function loadMapData()
    {
        $query = LahanData::query();

        if ($this->selectedTopik) {
            $query->where('id_lahan_topik', $this->selectedTopik);
        }

        if ($this->selectedVariabel) {
            $query->where('id_lahan_variabel', $this->selectedVariabel);
        }

        if ($this->selectedKlasifikasi) {
            $query->where('id_lahan_klasifikasi', $this->selectedKlasifikasi);
        }

        if ($this->selectedYear) {
            $query->where('tahun', $this->selectedYear);
        }

        $data = $query->get();

        // Group by wilayah for map visualization with coordinates
        $this->mapData = $data->groupBy('wilayah')->map(function ($items, $wilayah) {
            $coordinates = $this->getWilayahCoordinates($wilayah);
            return [
                'wilayah' => $wilayah,
                'total_data' => $items->count(),
                'average_value' => round($items->avg('nilai'), 2),
                'total_value' => round($items->sum('nilai'), 2),
                'lat' => $coordinates['lat'],
                'lng' => $coordinates['lng'],
                'data_points' => $items->toArray()
            ];
        })->values()->toArray();

        // Calculate statistics
        $this->totalData = $data->count();
        $this->averageValue = $data->avg('nilai') ?: 0;
        $this->maxValue = $data->max('nilai') ?: 0;
        $this->minValue = $data->min('nilai') ?: 0;
    }

    private function getWilayahCoordinates($wilayah)
    {
        // Sample coordinates for Indonesian provinces/regions
        $coordinates = [
            'DKI Jakarta' => ['lat' => -6.2088, 'lng' => 106.8456],
            'Jawa Barat' => ['lat' => -6.9175, 'lng' => 107.6191],
            'Jawa Tengah' => ['lat' => -7.2575, 'lng' => 110.1739],
            'Jawa Timur' => ['lat' => -7.5360, 'lng' => 112.2384],
            'Yogyakarta' => ['lat' => -7.7956, 'lng' => 110.3695],
            'Banten' => ['lat' => -6.4058, 'lng' => 106.0640],
            'Sumatera Utara' => ['lat' => 3.5952, 'lng' => 98.6722],
            'Sumatera Barat' => ['lat' => -0.7893, 'lng' => 100.6500],
            'Sumatera Selatan' => ['lat' => -3.3194, 'lng' => 104.9147],
            'Lampung' => ['lat' => -5.4500, 'lng' => 105.2667],
            'Riau' => ['lat' => 0.2933, 'lng' => 101.7068],
            'Jambi' => ['lat' => -1.4852, 'lng' => 103.6118],
            'Bengkulu' => ['lat' => -3.8004, 'lng' => 102.2655],
            'Aceh' => ['lat' => 4.6951, 'lng' => 96.7494],
            'Kalimantan Barat' => ['lat' => -0.2787, 'lng' => 109.9758],
            'Kalimantan Tengah' => ['lat' => -1.6815, 'lng' => 113.3824],
            'Kalimantan Selatan' => ['lat' => -3.0926, 'lng' => 115.2838],
            'Kalimantan Timur' => ['lat' => 1.5709, 'lng' => 116.4194],
            'Kalimantan Utara' => ['lat' => 3.0730, 'lng' => 116.0413],
            'Sulawesi Utara' => ['lat' => 1.4748, 'lng' => 124.8421],
            'Sulawesi Tengah' => ['lat' => -1.4300, 'lng' => 121.4456],
            'Sulawesi Selatan' => ['lat' => -3.6687, 'lng' => 119.9740],
            'Sulawesi Tenggara' => ['lat' => -4.1400, 'lng' => 122.1750],
            'Gorontalo' => ['lat' => 0.6999, 'lng' => 122.4467],
            'Sulawesi Barat' => ['lat' => -2.8441, 'lng' => 119.2320],
            'Bali' => ['lat' => -8.4095, 'lng' => 115.1889],
            'Nusa Tenggara Barat' => ['lat' => -8.6529, 'lng' => 117.3616],
            'Nusa Tenggara Timur' => ['lat' => -8.6574, 'lng' => 121.0794],
            'Maluku' => ['lat' => -3.2385, 'lng' => 130.1453],
            'Maluku Utara' => ['lat' => 1.5709, 'lng' => 127.8089],
            'Papua' => ['lat' => -4.2699, 'lng' => 138.0804],
            'Papua Barat' => ['lat' => -1.3361, 'lng' => 133.1747],
        ];

        return $coordinates[$wilayah] ?? ['lat' => -2.5489, 'lng' => 118.0149]; // Default to Indonesia center
    }

    public function render()
    {
        return view('livewire.admin.lahan.maps');
    }
}
