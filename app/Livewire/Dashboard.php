<?php

namespace App\Livewire;

use App\Models\User;
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
                'recentUsers' => User::latest()->take(5)->get(),
            ];
        }

        return view('livewire.dashboard', $data);
    }
}
