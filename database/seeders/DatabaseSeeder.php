<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            DaftarAlamatSeeder::class,
            KelompokSeeder::class,
            KomoditiSeeder::class,
            TransaksiNbmSeeder::class,
            KelompokBpsSeeder::class,
            KomoditiBpsSeeder::class,
            SusenasSeeder::class,
            LahanSeeder::class,
            IklimoptdpiTopikSeeder::class,
            IklimoptdpiVariabelSeeder::class,
            IklimoptdpiKlasifikasiSeeder::class,
            IklimoptdpiDataSeeder::class,
            BenihPupukSeeder::class,
        ]);

        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
