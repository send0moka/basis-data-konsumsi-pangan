<?php

namespace App\Livewire;

use App\Models\User;
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

        // Data untuk admin - cek dengan cara yang lebih safe
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user && $user->isAdmin()) {
            $data = [
                'totalUsers' => User::count(),
                'totalRoles' => Role::count(),
                'recentUsers' => User::latest()->take(5)->get(),
                
                // Susenas data
                'totalKelompokbps' => TbKelompokbps::count(),
                'totalKomoditibps' => TbKomoditibps::count(),
                'totalSusenas' => TransaksiSusenas::count(),
                'recentSusenas' => TransaksiSusenas::with(['kelompokbps', 'komoditibps'])
                    ->latest()
                    ->take(5)
                    ->get(),
            ];
        }

        return view('livewire.dashboard', $data);
    }
}
