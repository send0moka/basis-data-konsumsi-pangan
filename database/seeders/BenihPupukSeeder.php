<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;

class BenihPupukSeeder extends Seeder
{
    /**
     * Command instance for output
     */
    public $command;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->info('Starting benih pupuk seeding...');
        
        // Disable foreign key checks for faster seeding
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        try {
            // Truncate all tables in proper order (respecting foreign key constraints)
            $this->truncateTables();
            
            // Seed reference data
            $this->seedReferenceData();
            
            // Seed wilayah data (all kabupaten/kota)
            $this->seedWilayahData();
            
            // Generate and seed data (2014-2025, all variables, all regions)
            $this->seedData();
            
            // Re-enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            
            $this->info('Benih pupuk seeding completed successfully!');
        } catch (Exception $e) {
            // Re-enable foreign key checks even if there's an error
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            throw $e;
        }
    }

    private function info($message)
    {
        if ($this->command && method_exists($this->command, 'info')) {
            $this->command->info($message);
        } elseif (method_exists($this, 'command') && $this->command) {
            $this->command->info($message);
        } else {
            echo $message . PHP_EOL;
        }
    }

    private function warn($message)
    {
        if ($this->command && method_exists($this->command, 'warn')) {
            $this->command->warn($message);
        } elseif (method_exists($this, 'command') && $this->command) {
            $this->command->warn($message);
        } else {
            echo "WARNING: " . $message . PHP_EOL;
        }
    }

    private function truncateTables(): void
    {
        $this->info('Truncating existing data...');
        
        $tables = [
            'benih_pupuk_data',
            'benih_pupuk_variabel_klasifikasi',
            'benih_pupuk_variabel',
            'benih_pupuk_wilayah',
            'benih_pupuk_wilayah_kategori',
            'benih_pupuk_klasifikasi',
            'benih_pupuk_topik',
            'benih_pupuk_bulan',
        ];

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }
    }

    private function seedReferenceData(): void
    {
        $this->info('Seeding reference data...');
        
        $this->seedBulan();
        $this->seedTopik();
        $this->seedKlasifikasi();
        $this->seedWilayahKategori();
        $this->seedVariabel();
        $this->seedVariabelKlasifikasi();
    }
    
    private function seedBulan()
    {
        DB::table('benih_pupuk_bulan')->insert([
            ['id' => 0, 'nama' => '-'],
            ['id' => 1, 'nama' => 'Januari'],
            ['id' => 2, 'nama' => 'Februari'],
            ['id' => 3, 'nama' => 'Maret'],
            ['id' => 4, 'nama' => 'April'],
            ['id' => 5, 'nama' => 'Mei'],
            ['id' => 6, 'nama' => 'Juni'],
            ['id' => 7, 'nama' => 'Juli'],
            ['id' => 8, 'nama' => 'Agustus'],
            ['id' => 9, 'nama' => 'September'],
            ['id' => 10, 'nama' => 'Oktober'],
            ['id' => 11, 'nama' => 'November'],
            ['id' => 12, 'nama' => 'Desember'],
            ['id' => 13, 'nama' => 'Setahun']
        ]);
    }
    
    private function seedTopik()
    {
        DB::table('benih_pupuk_topik')->insert([
            ['id' => 1, 'deskripsi' => 'Benih'],
            ['id' => 2, 'deskripsi' => 'Pupuk'],
        ]);
    }
    
    private function seedKlasifikasi()
    {
        DB::table('benih_pupuk_klasifikasi')->insert([
            ['id' => 1, 'deskripsi' => '-'],
            ['id' => 2, 'deskripsi' => 'Inbrida'],
            ['id' => 3, 'deskripsi' => 'Hibrida'],
            ['id' => 4, 'deskripsi' => 'Komposit'],
            ['id' => 5, 'deskripsi' => 'Alokasi'],
            ['id' => 6, 'deskripsi' => 'Realisasi'],
        ]);
    }
    
    private function seedWilayahKategori()
    {
        DB::table('benih_pupuk_wilayah_kategori')->insert([
            ['id' => 1, 'deskripsi' => 'Wilayah'],
        ]);
    }
    
    private function seedWilayahData()
    {
        $this->info('Seeding wilayah data (all kabupaten/kota)...');
        
        // All 546 Indonesian kabupaten/kota from the original SQL file
        $wilayahData = $this->getAllWilayahData();
        
        // Insert in chunks to handle large dataset
        foreach (array_chunk($wilayahData, 100) as $chunk) {
            DB::table('benih_pupuk_wilayah')->insert($chunk);
        }
        
        $this->info('Seeded ' . count($wilayahData) . ' wilayah records');
    }

    private function getAllWilayahData(): array
    {
        // Load all wilayah data (546 regions) from generated file
        $dataFile = base_path('wilayah_data.php');
        
        if (file_exists($dataFile)) {
            return require $dataFile;
        }
        
        // Fallback to minimal data if file doesn't exist
        $this->warn('wilayah_data.php not found, using province data only');
        
        return [
            ['id' => 1, 'kode' => 1, 'nama' => 'Aceh', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 1],
            ['id' => 2, 'kode' => 2, 'nama' => 'Sumatera Utara', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 2],
            ['id' => 3, 'kode' => 3, 'nama' => 'Sumatera Barat', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 3],
            ['id' => 4, 'kode' => 4, 'nama' => 'Riau', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 4],
            ['id' => 5, 'kode' => 5, 'nama' => 'Jambi', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 5],
            ['id' => 6, 'kode' => 6, 'nama' => 'Sumatera Selatan', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 6],
            ['id' => 7, 'kode' => 7, 'nama' => 'Bengkulu', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 7],
            ['id' => 8, 'kode' => 8, 'nama' => 'Lampung', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 8],
            ['id' => 9, 'kode' => 9, 'nama' => 'Bangka Belitung', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 9],
            ['id' => 10, 'kode' => 10, 'nama' => 'Kepulauan Riau', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 10],
            ['id' => 11, 'kode' => 11, 'nama' => 'DKI Jakarta', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 11],
            ['id' => 12, 'kode' => 12, 'nama' => 'Jawa Barat', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 12],
            ['id' => 13, 'kode' => 13, 'nama' => 'Jawa Tengah', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 13],
            ['id' => 14, 'kode' => 14, 'nama' => 'DI Yogyakarta', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 14],
            ['id' => 15, 'kode' => 15, 'nama' => 'Jawa Timur', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 15],
            ['id' => 16, 'kode' => 16, 'nama' => 'Banten', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 16],
            ['id' => 17, 'kode' => 17, 'nama' => 'Bali', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 17],
            ['id' => 18, 'kode' => 18, 'nama' => 'Nusa Tenggara Barat', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 18],
            ['id' => 19, 'kode' => 19, 'nama' => 'Nusa Tenggara Timur', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 19],
            ['id' => 20, 'kode' => 20, 'nama' => 'Kalimantan Barat', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 20],
            ['id' => 21, 'kode' => 21, 'nama' => 'Kalimantan Tengah', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 21],
            ['id' => 22, 'kode' => 22, 'nama' => 'Kalimantan Selatan', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 22],
            ['id' => 23, 'kode' => 23, 'nama' => 'Kalimantan Timur', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 23],
            ['id' => 24, 'kode' => 24, 'nama' => 'Kalimantan Utara', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 24],
            ['id' => 25, 'kode' => 25, 'nama' => 'Sulawesi Utara', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 25],
            ['id' => 26, 'kode' => 26, 'nama' => 'Sulawesi Tengah', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 26],
            ['id' => 27, 'kode' => 27, 'nama' => 'Sulawesi Selatan', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 27],
            ['id' => 28, 'kode' => 28, 'nama' => 'Sulawesi Tenggara', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 28],
            ['id' => 29, 'kode' => 29, 'nama' => 'Gorontalo', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 29],
            ['id' => 30, 'kode' => 30, 'nama' => 'Sulawesi Barat', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 30],
            ['id' => 31, 'kode' => 31, 'nama' => 'Maluku', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 31],
            ['id' => 32, 'kode' => 32, 'nama' => 'Maluku Utara', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 32],
            ['id' => 33, 'kode' => 33, 'nama' => 'Papua Barat', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 33],
            ['id' => 34, 'kode' => 34, 'nama' => 'Papua', 'id_kategori' => 1, 'id_parent' => null, 'sorter' => 34],
        ];
    }

    private function seedVariabel()
    {
        DB::table('benih_pupuk_variabel')->insert([
            ['id' => 1, 'id_topik' => 1, 'deskripsi' => 'Padi Benih Sebar', 'satuan' => 'Ton', 'sorter' => 2],
            ['id' => 2, 'id_topik' => 1, 'deskripsi' => 'Jagung Benih Sebar', 'satuan' => 'Ton', 'sorter' => 3],
            ['id' => 3, 'id_topik' => 1, 'deskripsi' => 'Kedelai Benih Sebar', 'satuan' => 'Ton', 'sorter' => 4],
            ['id' => 4, 'id_topik' => 2, 'deskripsi' => 'Pupuk Urea', 'satuan' => 'Ton', 'sorter' => 5],
            ['id' => 5, 'id_topik' => 2, 'deskripsi' => 'Pupuk SP-36', 'satuan' => 'Ton', 'sorter' => 6],
            ['id' => 6, 'id_topik' => 2, 'deskripsi' => 'Pupuk ZA', 'satuan' => 'Ton', 'sorter' => 7],
            ['id' => 7, 'id_topik' => 2, 'deskripsi' => 'Pupuk NPK', 'satuan' => 'Ton', 'sorter' => 8],
            ['id' => 8, 'id_topik' => 2, 'deskripsi' => 'Pupuk Organik', 'satuan' => 'Ton', 'sorter' => 9],
            ['id' => 9, 'id_topik' => 1, 'deskripsi' => 'Padi Benih Pokok', 'satuan' => 'Ton', 'sorter' => 1],
        ]);
    }
    
    private function seedVariabelKlasifikasi()
    {
        DB::table('benih_pupuk_variabel_klasifikasi')->insert([
            ['id_variabel' => 1, 'id_klasifikasi' => 2, 'keterangan' => null], // Padi Benih Sebar -> Inbrida
            ['id_variabel' => 1, 'id_klasifikasi' => 3, 'keterangan' => null], // Padi Benih Sebar -> Hibrida
            ['id_variabel' => 2, 'id_klasifikasi' => 3, 'keterangan' => null], // Jagung Benih Sebar -> Hibrida
            ['id_variabel' => 2, 'id_klasifikasi' => 4, 'keterangan' => null], // Jagung Benih Sebar -> Komposit
            ['id_variabel' => 3, 'id_klasifikasi' => 1, 'keterangan' => null], // Kedelai Benih Sebar -> -
            ['id_variabel' => 4, 'id_klasifikasi' => 5, 'keterangan' => null], // Pupuk Urea -> Alokasi
            ['id_variabel' => 4, 'id_klasifikasi' => 6, 'keterangan' => null], // Pupuk Urea -> Realisasi
            ['id_variabel' => 5, 'id_klasifikasi' => 5, 'keterangan' => null], // Pupuk SP-36 -> Alokasi
            ['id_variabel' => 5, 'id_klasifikasi' => 6, 'keterangan' => null], // Pupuk SP-36 -> Realisasi
            ['id_variabel' => 6, 'id_klasifikasi' => 5, 'keterangan' => null], // Pupuk ZA -> Alokasi
            ['id_variabel' => 6, 'id_klasifikasi' => 6, 'keterangan' => null], // Pupuk ZA -> Realisasi
            ['id_variabel' => 7, 'id_klasifikasi' => 5, 'keterangan' => null], // Pupuk NPK -> Alokasi
            ['id_variabel' => 7, 'id_klasifikasi' => 6, 'keterangan' => null], // Pupuk NPK -> Realisasi
            ['id_variabel' => 8, 'id_klasifikasi' => 5, 'keterangan' => null], // Pupuk Organik -> Alokasi
            ['id_variabel' => 8, 'id_klasifikasi' => 6, 'keterangan' => null], // Pupuk Organik -> Realisasi
            ['id_variabel' => 9, 'id_klasifikasi' => 1, 'keterangan' => null], // Padi Benih Pokok -> -
        ]);
    }

    private function seedData(): void
    {
        $this->info('Generating comprehensive benih pupuk data (2014-2025, all variables, all regions)...');
        
        $data = [];
        $now = Carbon::now();
        $batchCounter = 0;
        $totalBatches = 0;

        // Get all available regions (assuming we have all 546 regions seeded)
        $regionIds = DB::table('benih_pupuk_wilayah')->pluck('id')->toArray();
        
        // Variable-klasifikasi mapping for realistic data
        $variabelKlasifikasiData = [
            1 => [2, 3], // Padi Benih Sebar -> Inbrida, Hibrida
            2 => [3, 4], // Jagung Benih Sebar -> Hibrida, Komposit
            3 => [1],    // Kedelai Benih Sebar -> -
            4 => [5, 6], // Pupuk Urea -> Alokasi, Realisasi
            5 => [5, 6], // Pupuk SP-36 -> Alokasi, Realisasi
            6 => [5, 6], // Pupuk ZA -> Alokasi, Realisasi
            7 => [5, 6], // Pupuk NPK -> Alokasi, Realisasi
            8 => [5, 6], // Pupuk Organik -> Alokasi, Realisasi
            9 => [1],    // Padi Benih Pokok -> -
        ];

        // Estimate total records for progress tracking
        $totalRecords = 0;
        for ($tahun = 2014; $tahun <= 2025; $tahun++) {
            for ($bulan = 1; $bulan <= 12; $bulan++) {
                foreach ($regionIds as $regionId) {
                    foreach ($variabelKlasifikasiData as $variabelId => $klasifikasiIds) {
                        $totalRecords += count($klasifikasiIds);
                    }
                }
            }
        }

        $this->info("Generating ~{$totalRecords} records...");

        // Generate data for 2014-2025, all months, all regions, all variables
        for ($tahun = 2014; $tahun <= 2025; $tahun++) {
            $this->info("Processing year: {$tahun}");
            
            for ($bulan = 1; $bulan <= 12; $bulan++) {
                foreach ($regionIds as $regionId) {
                    foreach ($variabelKlasifikasiData as $variabelId => $klasifikasiIds) {
                        foreach ($klasifikasiIds as $klasifikasiId) {
                            // Generate realistic values based on variable type
                            $nilai = $this->generateRealisticValue($variabelId, $klasifikasiId, $tahun, $bulan);
                            
                            $data[] = [
                                'tahun' => $tahun,
                                'id_bulan' => $bulan,
                                'id_wilayah' => $regionId,
                                'id_variabel' => $variabelId,
                                'id_klasifikasi' => $klasifikasiId,
                                'nilai' => $nilai,
                                'status' => null,
                                'date_created' => $now,
                                'date_modified' => null
                            ];

                            // Insert in chunks to avoid memory issues
                            if (count($data) >= 5000) {
                                DB::table('benih_pupuk_data')->insert($data);
                                $data = [];
                                $batchCounter++;
                                
                                if ($batchCounter % 10 == 0) {
                                    $this->info("Inserted batch #{$batchCounter} (Year: {$tahun}, Month: {$bulan})");
                                }
                            }
                        }
                    }
                }
            }
        }

        // Insert remaining data
        if (!empty($data)) {
            DB::table('benih_pupuk_data')->insert($data);
            $batchCounter++;
        }

        $this->info("Data generation completed! Total batches: {$batchCounter}");
    }

    private function generateRealisticValue(int $variabelId, int $klasifikasiId, int $tahun, int $bulan): float
    {
        // Base values and variations for different variable types
        $baseValues = [
            1 => 150,    // Padi Benih Sebar
            2 => 85,     // Jagung Benih Sebar
            3 => 45,     // Kedelai Benih Sebar
            4 => 8500,   // Pupuk Urea
            5 => 4200,   // Pupuk SP-36
            6 => 2800,   // Pupuk ZA
            7 => 6500,   // Pupuk NPK
            8 => 1200,   // Pupuk Organik
            9 => 200,    // Padi Benih Pokok
        ];

        $base = $baseValues[$variabelId] ?? 100;
        
        // Add seasonal variation (higher values during planting seasons)
        $seasonalFactor = 1.0;
        if (in_array($bulan, [3, 4, 5, 9, 10, 11])) { // Planting seasons
            $seasonalFactor = 1.2 + (rand(0, 30) / 100); // 20-50% increase
        }
        
        // Add yearly growth trend (slight increase over time)
        $yearlyFactor = 1 + (($tahun - 2014) * 0.02); // 2% per year
        
        // Regional variation (some regions higher than others)
        $regionalFactor = 0.7 + (rand(0, 60) / 100); // 70-130% of base
        
        // Klasifikasi adjustment (realisasi typically lower than alokasi)
        $klasifikasiFactor = 1.0;
        if ($klasifikasiId == 6) { // Realisasi
            $klasifikasiFactor = 0.75 + (rand(0, 20) / 100); // 75-95% of allocation
        }
        
        // Random variation
        $randomFactor = 0.8 + (rand(0, 40) / 100); // ±20% random variation
        
        $value = $base * $seasonalFactor * $yearlyFactor * $regionalFactor * $klasifikasiFactor * $randomFactor;
        
        return round($value, 2);
    }
}
