<?php

namespace Database\Seeders;

use App\Models\LahanData;
use App\Models\LahanVariabel;
use App\Models\LahanKlasifikasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LahanDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->warn('⚠️  This seeder has been replaced by LahanDataRealisticSeeder');
        $this->command->info('🔄 Please use: php artisan db:seed --class=LahanDataRealisticSeeder');
        $this->command->info('📊 The new seeder provides more realistic and diverse data based on BPS references');
        
        if ($this->command->confirm('Do you want to run LahanDataRealisticSeeder instead?', true)) {
            $this->call(LahanDataRealisticSeeder::class);
        }
        
        return;
    }
}
