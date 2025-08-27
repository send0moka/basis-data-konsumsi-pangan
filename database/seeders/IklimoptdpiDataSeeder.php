<?php

namespace Database\Seeders;

use App\Models\IklimoptdpiData;
use App\Models\IklimoptdpiVariabel;
use App\Models\IklimoptdpiKlasifikasi;
use App\Models\Bulan;
use App\Models\Wilayah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IklimoptdpiDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure reference data exists first
        if (IklimoptdpiVariabel::count() === 0) {
            $this->call([
                IklimoptdpiTopikSeeder::class,
                IklimoptdpiVariabelSeeder::class,
                IklimoptdpiKlasifikasiSeeder::class,
            ]);
        }

        // Get reference data
        $bulans = Bulan::all();
        $wilayahs = Wilayah::all();
        
        // Create sample data
        $data = [];
        $years = [2020, 2021, 2022, 2023, 2024];
        
        // Get klasifikasi with their variabel relationships
        $klasifikasis = IklimoptdpiKlasifikasi::with('variabel')->get();
        
        // Limit the number of klasifikasis to process for performance
        foreach ($klasifikasis->take(10) as $klasifikasi) {
            foreach ($years as $year) {
                foreach ($bulans->take(6) as $bulan) { // Sample months
                    foreach ($wilayahs->take(10) as $wilayah) { // Sample wilayahs
                        $data[] = [
                        'tahun' => $year,
                        'id_bulan' => $bulan->id,
                        'id_wilayah' => $wilayah->id,
                        'id_variabel' => $klasifikasi->id_variabel,
                        'id_klasifikasi' => $klasifikasi->id,
                        'nilai' => rand(0, 1000) / 10, // Random decimal value
                        'status' => null,
                        'created_at' => now(),
                        'updated_at' => now(),];
                    }
                }
            }
        }

        // Insert data in chunks to avoid memory issues
        collect($data)->chunk(1000)->each(function ($chunk) {
            DB::table('iklimoptdpi_data')->insert($chunk->toArray());
        });
    }
}