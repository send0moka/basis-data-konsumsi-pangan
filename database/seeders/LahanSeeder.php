<?php

namespace Database\Seeders;

use App\Models\LahanTopik;
use App\Models\LahanVariabel;
use App\Models\LahanKlasifikasi;
use App\Models\LahanData;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create lahan topik data
        $topiks = LahanTopik::factory(5)->create();
        
        // Create lahan variabel data
        $variabels = LahanVariabel::factory(5)->create();
        
        // Create lahan klasifikasi data
        $klasifikasis = LahanKlasifikasi::factory(5)->create();
        
        // Create lahan data with existing topik, variabel, and klasifikasi
        foreach ($topiks as $topik) {
            foreach ($variabels as $variabel) {
                foreach ($klasifikasis->take(2) as $klasifikasi) {
                    LahanData::factory(10)->create([
                        'id_lahan_topik' => $topik->id,
                        'id_lahan_variabel' => $variabel->id,
                        'id_lahan_klasifikasi' => $klasifikasi->id,
                    ]);
                }
            }
        }
    }
}
