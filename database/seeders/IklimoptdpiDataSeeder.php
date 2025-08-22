<?php

namespace Database\Seeders;

use App\Models\IklimoptdpiData;
use App\Models\IklimoptdpiTopik;
use App\Models\IklimoptdpiVariabel;
use App\Models\IklimoptdpiKlasifikasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IklimoptdpiDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure reference data exists first
        if (IklimoptdpiTopik::count() === 0) {
            $this->call(IklimoptdpiTopikSeeder::class);
        }
        if (IklimoptdpiVariabel::count() === 0) {
            $this->call(IklimoptdpiVariabelSeeder::class);
        }
        if (IklimoptdpiKlasifikasi::count() === 0) {
            $this->call(IklimoptdpiKlasifikasiSeeder::class);
        }

        // Create sample data
        IklimoptdpiData::factory(50)->create();
        
        // Create some specific status data
        IklimoptdpiData::factory(20)->active()->create();
        IklimoptdpiData::factory(10)->draft()->create();
        IklimoptdpiData::factory(5)->archived()->create();
    }
}
