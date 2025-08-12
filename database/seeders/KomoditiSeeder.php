<?php

namespace Database\Seeders;

use App\Models\Komoditi;
use Illuminate\Database\Seeder;

class KomoditiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample komoditi data
        Komoditi::factory(26)->create();
    }
}
