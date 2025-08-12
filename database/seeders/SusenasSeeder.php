<?php

namespace Database\Seeders;

use App\Models\TransaksiSusenas;
use Illuminate\Database\Seeder;

class SusenasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Hapus data lama jika ada
        TransaksiSusenas::truncate();
        
        // Enable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Data contoh konsumsi pangan per kapita per tahun (dalam kg)
        $susenasData = [
            // Data tahun 2023
            ['tahun' => 2023, 'kd_kelompokbps' => '01', 'kd_komoditibps' => '0101', 'konsumsi_kuantity' => 114.6], // Beras
            ['tahun' => 2023, 'kd_kelompokbps' => '01', 'kd_komoditibps' => '0102', 'konsumsi_kuantity' => 8.2], // Jagung Basah
            ['tahun' => 2023, 'kd_kelompokbps' => '02', 'kd_komoditibps' => '0201', 'konsumsi_kuantity' => 12.5], // Ketela Pohon
            ['tahun' => 2023, 'kd_kelompokbps' => '02', 'kd_komoditibps' => '0205', 'konsumsi_kuantity' => 4.8], // Kentang
            ['tahun' => 2023, 'kd_kelompokbps' => '03', 'kd_komoditibps' => '0301', 'konsumsi_kuantity' => 15.3], // Ikan Segar
            ['tahun' => 2023, 'kd_kelompokbps' => '04', 'kd_komoditibps' => '0404', 'konsumsi_kuantity' => 8.9], // Daging Ayam
            ['tahun' => 2023, 'kd_kelompokbps' => '04', 'kd_komoditibps' => '0401', 'konsumsi_kuantity' => 2.1], // Daging Sapi
            ['tahun' => 2023, 'kd_kelompokbps' => '05', 'kd_komoditibps' => '0501', 'konsumsi_kuantity' => 4.2], // Telur Ayam
            ['tahun' => 2023, 'kd_kelompokbps' => '05', 'kd_komoditibps' => '0503', 'konsumsi_kuantity' => 3.7], // Susu Segar
            ['tahun' => 2023, 'kd_kelompokbps' => '06', 'kd_komoditibps' => '0605', 'konsumsi_kuantity' => 6.8], // Tomat
            ['tahun' => 2023, 'kd_kelompokbps' => '06', 'kd_komoditibps' => '0608', 'konsumsi_kuantity' => 2.3], // Cabai
            ['tahun' => 2023, 'kd_kelompokbps' => '07', 'kd_komoditibps' => '0705', 'konsumsi_kuantity' => 7.5], // Tahu
            ['tahun' => 2023, 'kd_kelompokbps' => '07', 'kd_komoditibps' => '0706', 'konsumsi_kuantity' => 8.9], // Tempe
            ['tahun' => 2023, 'kd_kelompokbps' => '08', 'kd_komoditibps' => '0804', 'konsumsi_kuantity' => 9.6], // Pisang
            ['tahun' => 2023, 'kd_kelompokbps' => '09', 'kd_komoditibps' => '0902', 'konsumsi_kuantity' => 11.4], // Minyak Sawit
            ['tahun' => 2023, 'kd_kelompokbps' => '10', 'kd_komoditibps' => '1003', 'konsumsi_kuantity' => 15.2], // Gula Pasir
            
            // Data tahun 2022
            ['tahun' => 2022, 'kd_kelompokbps' => '01', 'kd_komoditibps' => '0101', 'konsumsi_kuantity' => 118.3], // Beras
            ['tahun' => 2022, 'kd_kelompokbps' => '01', 'kd_komoditibps' => '0102', 'konsumsi_kuantity' => 7.8], // Jagung Basah
            ['tahun' => 2022, 'kd_kelompokbps' => '02', 'kd_komoditibps' => '0201', 'konsumsi_kuantity' => 11.8], // Ketela Pohon
            ['tahun' => 2022, 'kd_kelompokbps' => '02', 'kd_komoditibps' => '0205', 'konsumsi_kuantity' => 4.2], // Kentang
            ['tahun' => 2022, 'kd_kelompokbps' => '03', 'kd_komoditibps' => '0301', 'konsumsi_kuantity' => 14.9], // Ikan Segar
            ['tahun' => 2022, 'kd_kelompokbps' => '04', 'kd_komoditibps' => '0404', 'konsumsi_kuantity' => 8.3], // Daging Ayam
            ['tahun' => 2022, 'kd_kelompokbps' => '04', 'kd_komoditibps' => '0401', 'konsumsi_kuantity' => 1.9], // Daging Sapi
            ['tahun' => 2022, 'kd_kelompokbps' => '05', 'kd_komoditibps' => '0501', 'konsumsi_kuantity' => 4.0], // Telur Ayam
            ['tahun' => 2022, 'kd_kelompokbps' => '05', 'kd_komoditibps' => '0503', 'konsumsi_kuantity' => 3.4], // Susu Segar
            ['tahun' => 2022, 'kd_kelompokbps' => '06', 'kd_komoditibps' => '0605', 'konsumsi_kuantity' => 6.2], // Tomat
            ['tahun' => 2022, 'kd_kelompokbps' => '06', 'kd_komoditibps' => '0608', 'konsumsi_kuantity' => 2.1], // Cabai
            ['tahun' => 2022, 'kd_kelompokbps' => '07', 'kd_komoditibps' => '0705', 'konsumsi_kuantity' => 7.2], // Tahu
            ['tahun' => 2022, 'kd_kelompokbps' => '07', 'kd_komoditibps' => '0706', 'konsumsi_kuantity' => 8.6], // Tempe
            ['tahun' => 2022, 'kd_kelompokbps' => '08', 'kd_komoditibps' => '0804', 'konsumsi_kuantity' => 9.1], // Pisang
            ['tahun' => 2022, 'kd_kelompokbps' => '09', 'kd_komoditibps' => '0902', 'konsumsi_kuantity' => 10.8], // Minyak Sawit
            ['tahun' => 2022, 'kd_kelompokbps' => '10', 'kd_komoditibps' => '1003', 'konsumsi_kuantity' => 14.7], // Gula Pasir
            
            // Data tahun 2021
            ['tahun' => 2021, 'kd_kelompokbps' => '01', 'kd_komoditibps' => '0101', 'konsumsi_kuantity' => 121.5], // Beras
            ['tahun' => 2021, 'kd_kelompokbps' => '01', 'kd_komoditibps' => '0102', 'konsumsi_kuantity' => 8.5], // Jagung Basah
            ['tahun' => 2021, 'kd_kelompokbps' => '02', 'kd_komoditibps' => '0201', 'konsumsi_kuantity' => 13.2], // Ketela Pohon
            ['tahun' => 2021, 'kd_kelompokbps' => '03', 'kd_komoditibps' => '0301', 'konsumsi_kuantity' => 16.1], // Ikan Segar
            ['tahun' => 2021, 'kd_kelompokbps' => '04', 'kd_komoditibps' => '0404', 'konsumsi_kuantity' => 7.8], // Daging Ayam
            ['tahun' => 2021, 'kd_kelompokbps' => '05', 'kd_komoditibps' => '0501', 'konsumsi_kuantity' => 3.8], // Telur Ayam
            ['tahun' => 2021, 'kd_kelompokbps' => '07', 'kd_komoditibps' => '0705', 'konsumsi_kuantity' => 6.9], // Tahu
            ['tahun' => 2021, 'kd_kelompokbps' => '07', 'kd_komoditibps' => '0706', 'konsumsi_kuantity' => 8.2], // Tempe
            ['tahun' => 2021, 'kd_kelompokbps' => '10', 'kd_komoditibps' => '1003', 'konsumsi_kuantity' => 13.9], // Gula Pasir
        ];

        foreach ($susenasData as $data) {
            TransaksiSusenas::create($data);
        }

        $this->command->info('Susenas seeder completed successfully!');
        $this->command->info('Total data created: ' . count($susenasData));
    }
}
