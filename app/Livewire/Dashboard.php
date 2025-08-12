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

        // Data untuk admin dan superadmin
        if (auth()->user()->hasRole(['superadmin', 'admin'])) {
            $data = [
                'totalKelompok' => Kelompok::count(),
                'totalKomoditi' => Komoditi::count(),
                'recentKelompok' => Kelompok::latest()->take(5)->get(),
                'recentKomoditi' => Komoditi::latest()->take(10)->get(),
            ];
            
            // Data khusus superadmin (user management)
            if (auth()->user()->hasRole('superadmin')) {
                $data['totalUsers'] = User::count();
                $data['totalRoles'] = Role::count();
                $data['recentUsers'] = User::latest()->take(5)->get();
            }
        }

        return view('livewire.dashboard', $data);
    }
}
