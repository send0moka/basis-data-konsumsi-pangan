<?php

namespace Database\Seeders;

use App\Models\IklimoptdpiTopik;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IklimoptdpiTopikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $topiks = [
            'Curah Hujan',
            'Suhu Udara',
            'Kelembaban Udara',
            'Kecepatan Angin',
            'Radiasi Matahari',
            'Tekanan Udara',
            'Evapotranspirasi',
            'Indeks Kekeringan',
            'Pola Iklim Musiman',
            'Anomali Iklim',
            'El Nino Southern Oscillation',
            'Indian Ocean Dipole',
            'Monsun',
            'Siklus Karbon',
            'Emisi Gas Rumah Kaca'
        ];

        foreach ($topiks as $topik) {
            IklimoptdpiTopik::create([
                'nama' => $topik,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
