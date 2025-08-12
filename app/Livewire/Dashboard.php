<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Kelompok;
use App\Models\Komoditi;
use App\Models\TbKelompokbps;
use App\Models\TbKomoditibps;
use App\Models\TransaksiSusenas;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

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
                'recentUsers' => User::latest()->take(5)->get(),
            ];
        }

        return view('livewire.dashboard', $data);
    }
}
