<?php

namespace Database\Seeders;

use App\Models\IklimoptdpiKlasifikasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IklimoptdpiKlasifikasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $klasifikasis = [
            'Iklim Tropis Basah',
            'Iklim Tropis Kering',
            'Iklim Monsun',
            'Iklim Savana',
            'Iklim Pegunungan',
            'Zona Agroekologi Basah',
            'Zona Agroekologi Kering',
            'Zona Rawan Kekeringan',
            'Zona Rawan Banjir',
            'Zona Optimal Pertanian',
            'Zona Marginal',
            'Zona Konservasi',
            'Dataran Rendah',
            'Dataran Tinggi',
            'Pesisir'
        ];

        foreach ($klasifikasis as $klasifikasi) {
            IklimoptdpiKlasifikasi::create([
                'nama' => $klasifikasi,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
