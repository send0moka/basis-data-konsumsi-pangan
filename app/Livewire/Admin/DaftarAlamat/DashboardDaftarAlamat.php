<?php

namespace App\Livewire\Admin\DaftarAlamat;

use App\Models\DaftarAlamat;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class DashboardDaftarAlamat extends Component
{
    public $totalAlamat;
    public $totalAktif;
    public $totalWithCoordinates;
    public $totalProvinsi;
    public $recentAlamat;
    public $statusStats;
    public $kategoriStats;
    public $wilayahStats;

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $this->totalAlamat = DaftarAlamat::count();
        $this->totalAktif = DaftarAlamat::where('status', 'Aktif')->count();
        $this->totalWithCoordinates = DaftarAlamat::withCoordinates()->count();
        $this->totalProvinsi = DaftarAlamat::distinct('wilayah')->count();
        
        $this->recentAlamat = DaftarAlamat::latest()
            ->take(5)
            ->get();

        $this->statusStats = DaftarAlamat::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status')
            ->toArray();

        $this->kategoriStats = DaftarAlamat::select('kategori', DB::raw('count(*) as total'))
            ->whereNotNull('kategori')
            ->groupBy('kategori')
            ->orderByDesc('total')
            ->take(5)
            ->get()
            ->pluck('total', 'kategori')
            ->toArray();

        $this->wilayahStats = DaftarAlamat::select('wilayah', DB::raw('count(*) as total'))
            ->groupBy('wilayah')
            ->orderByDesc('total')
            ->take(10)
            ->get()
            ->pluck('total', 'wilayah')
            ->toArray();
    }

    public function render()
    {
        return view('livewire.admin.daftar-alamat.dashboard-daftar-alamat');
    }
}
