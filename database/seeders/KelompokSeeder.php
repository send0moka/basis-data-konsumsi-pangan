<?php

namespace Database\Seeders;

use App\Models\Kelompok;
use Illuminate\Database\Seeder;

class KelompokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the 10 specific kelompok data
        Kelompok::factory(10)->create();
    }
}
