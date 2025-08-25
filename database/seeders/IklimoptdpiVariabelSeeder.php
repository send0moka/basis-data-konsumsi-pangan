<?php

namespace Database\Seeders;

use App\Models\IklimoptdpiVariabel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IklimoptdpiVariabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $variabels = [
            ['nama' => 'Curah Hujan Harian', 'satuan' => 'mm'],
            ['nama' => 'Curah Hujan Bulanan', 'satuan' => 'mm'],
            ['nama' => 'Suhu Maksimum', 'satuan' => '°C'],
            ['nama' => 'Suhu Minimum', 'satuan' => '°C'],
            ['nama' => 'Suhu Rata-rata', 'satuan' => '°C'],
            ['nama' => 'Kelembaban Relatif', 'satuan' => '%'],
            ['nama' => 'Kecepatan Angin', 'satuan' => 'm/s'],
            ['nama' => 'Arah Angin', 'satuan' => 'derajat'],
            ['nama' => 'Radiasi Matahari', 'satuan' => 'MJ/m²'],
            ['nama' => 'Lama Penyinaran', 'satuan' => 'jam'],
            ['nama' => 'Tekanan Udara', 'satuan' => 'hPa'],
            ['nama' => 'Evapotranspirasi Potensial', 'satuan' => 'mm'],
            ['nama' => 'Indeks Kekeringan Palmer', 'satuan' => 'indeks'],
            ['nama' => 'Standardized Precipitation Index', 'satuan' => 'indeks'],
            ['nama' => 'Normalized Difference Vegetation Index', 'satuan' => 'indeks'],
        ];

        foreach ($variabels as $variabel) {
            IklimoptdpiVariabel::create([
                'nama' => $variabel['nama'],
                'satuan' => $variabel['satuan'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
