<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Kelompok;
use App\Models\Komoditi;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Dashboard extends Component
{
    public function render()
    {
        $data = [];

        // Data untuk admin
        if (auth()->user()->hasRole(['superadmin', 'admin'])) {
            $data = [
                'totalUsers' => User::count(),
                'totalRoles' => Role::count(),
                'totalKelompok' => Kelompok::count(),
                'totalKomoditi' => Komoditi::count(),
                'recentUsers' => User::latest()->take(5)->get(),
                'recentKelompok' => Kelompok::latest()->take(5)->get(),
                'recentKomoditi' => Komoditi::latest()->take(10)->get(),
            ];
        }

        return view('livewire.dashboard', $data);
    }
}
