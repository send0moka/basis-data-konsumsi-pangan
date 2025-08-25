<?php

namespace App\Livewire\Admin\Lahan;

use App\Models\LahanData;
use App\Models\LahanTopik;
use App\Models\LahanVariabel;
use App\Models\LahanKlasifikasi;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Categories extends Component
{
    public $activeTab = 'topik';
    
    // Statistics
    public $topikStats = [];
    public $variabelStats = [];
    public $klasifikasiStats = [];
    
    public function mount()
    {
        $this->loadStatistics();
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    private function loadStatistics()
    {
        // Topik statistics
        $this->topikStats = LahanTopik::withCount('lahanData')
            ->with(['lahanData' => function($query) {
                $query->select('id_lahan_topik', DB::raw('AVG(nilai) as avg_nilai'), DB::raw('SUM(nilai) as total_nilai'))
                      ->groupBy('id_lahan_topik');
            }])
            ->get()
            ->map(function($topik) {
                $avgValue = $topik->lahanData->avg('nilai') ?: 0;
                $totalValue = $topik->lahanData->sum('nilai') ?: 0;
                
                return [
                    'id' => $topik->id,
                    'nama' => $topik->nama,
                    'total_data' => $topik->lahan_data_count,
                    'avg_value' => $avgValue,
                    'total_value' => $totalValue,
                    'created_at' => $topik->created_at
                ];
            })->toArray();

        // Variabel statistics
        $this->variabelStats = LahanVariabel::withCount('lahanData')
            ->with(['lahanData' => function($query) {
                $query->select('id_lahan_variabel', DB::raw('AVG(nilai) as avg_nilai'), DB::raw('SUM(nilai) as total_nilai'))
                      ->groupBy('id_lahan_variabel');
            }])
            ->get()
            ->map(function($variabel) {
                $avgValue = $variabel->lahanData->avg('nilai') ?: 0;
                $totalValue = $variabel->lahanData->sum('nilai') ?: 0;
                
                return [
                    'id' => $variabel->id,
                    'nama' => $variabel->nama,
                    'satuan' => $variabel->satuan,
                    'total_data' => $variabel->lahan_data_count,
                    'avg_value' => $avgValue,
                    'total_value' => $totalValue,
                    'created_at' => $variabel->created_at
                ];
            })->toArray();

        // Klasifikasi statistics
        $this->klasifikasiStats = LahanKlasifikasi::withCount('lahanData')
            ->with(['lahanData' => function($query) {
                $query->select('id_lahan_klasifikasi', DB::raw('AVG(nilai) as avg_nilai'), DB::raw('SUM(nilai) as total_nilai'))
                      ->groupBy('id_lahan_klasifikasi');
            }])
            ->get()
            ->map(function($klasifikasi) {
                $avgValue = $klasifikasi->lahanData->avg('nilai') ?: 0;
                $totalValue = $klasifikasi->lahanData->sum('nilai') ?: 0;
                
                return [
                    'id' => $klasifikasi->id,
                    'nama' => $klasifikasi->nama,
                    'total_data' => $klasifikasi->lahan_data_count,
                    'avg_value' => $avgValue,
                    'total_value' => $totalValue,
                    'created_at' => $klasifikasi->created_at
                ];
            })->toArray();
    }

    public function render()
    {
        return view('livewire.admin.lahan.categories');
    }
}
