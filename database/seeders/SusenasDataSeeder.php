<?php

namespace Database\Seeders;

use App\Models\TbKelompokbps;
use App\Models\TbKomoditibps;
use App\Models\TransaksiSusenas;
use Illuminate\Database\Seeder;

class SusenasDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data Kelompok BPS Sample
        $kelompokData = [
            ['kd_kelompokbps' => 'KEL001', 'nm_kelompokbps' => 'Beras dan Olahan'],
            ['kd_kelompokbps' => 'KEL002', 'nm_kelompokbps' => 'Umbi-umbian dan Olahan'],
            ['kd_kelompokbps' => 'KEL003', 'nm_kelompokbps' => 'Daging dan Olahan'],
            ['kd_kelompokbps' => 'KEL004', 'nm_kelompokbps' => 'Ikan dan Seafood'],
            ['kd_kelompokbps' => 'KEL005', 'nm_kelompokbps' => 'Sayur-sayuran'],
        ];

        foreach ($kelompokData as $kelompok) {
            TbKelompokbps::firstOrCreate(
                ['kd_kelompokbps' => $kelompok['kd_kelompokbps']],
                $kelompok
            );
        }

        // Data Komoditi BPS Sample
        $komoditiData = [
            // Beras dan Olahan
            ['kd_komoditibps' => 'KOM001', 'nm_komoditibps' => 'Beras Premium', 'kd_kelompokbps' => 'KEL001'],
            ['kd_komoditibps' => 'KOM002', 'nm_komoditibps' => 'Beras Medium', 'kd_kelompokbps' => 'KEL001'],
            ['kd_komoditibps' => 'KOM003', 'nm_komoditibps' => 'Tepung Beras', 'kd_kelompokbps' => 'KEL001'],
            
            // Umbi-umbian dan Olahan
            ['kd_komoditibps' => 'KOM004', 'nm_komoditibps' => 'Kentang', 'kd_kelompokbps' => 'KEL002'],
            ['kd_komoditibps' => 'KOM005', 'nm_komoditibps' => 'Ubi Jalar', 'kd_kelompokbps' => 'KEL002'],
            ['kd_komoditibps' => 'KOM006', 'nm_komoditibps' => 'Singkong', 'kd_kelompokbps' => 'KEL002'],
            
            // Daging dan Olahan
            ['kd_komoditibps' => 'KOM007', 'nm_komoditibps' => 'Daging Sapi', 'kd_kelompokbps' => 'KEL003'],
            ['kd_komoditibps' => 'KOM008', 'nm_komoditibps' => 'Daging Ayam', 'kd_kelompokbps' => 'KEL003'],
            ['kd_komoditibps' => 'KOM009', 'nm_komoditibps' => 'Telur Ayam', 'kd_kelompokbps' => 'KEL003'],
            
            // Ikan dan Seafood
            ['kd_komoditibps' => 'KOM010', 'nm_komoditibps' => 'Ikan Segar', 'kd_kelompokbps' => 'KEL004'],
            ['kd_komoditibps' => 'KOM011', 'nm_komoditibps' => 'Ikan Asin', 'kd_kelompokbps' => 'KEL004'],
            ['kd_komoditibps' => 'KOM012', 'nm_komoditibps' => 'Udang', 'kd_kelompokbps' => 'KEL004'],
            
            // Sayur-sayuran
            ['kd_komoditibps' => 'KOM013', 'nm_komoditibps' => 'Bayam', 'kd_kelompokbps' => 'KEL005'],
            ['kd_komoditibps' => 'KOM014', 'nm_komoditibps' => 'Kangkung', 'kd_kelompokbps' => 'KEL005'],
            ['kd_komoditibps' => 'KOM015', 'nm_komoditibps' => 'Tomat', 'kd_kelompokbps' => 'KEL005'],
        ];

        foreach ($komoditiData as $komoditi) {
            TbKomoditibps::firstOrCreate(
                ['kd_komoditibps' => $komoditi['kd_komoditibps']],
                $komoditi
            );
        }

        // Data Transaksi Susenas Sample
        $susenasData = [
            // Data tahun 2023
            ['kd_kelompokbps' => 'KEL001', 'kd_komoditibps' => 'KOM001', 'tahun' => 2023, 'konsumsi_kuantity' => 125.50],
            ['kd_kelompokbps' => 'KEL001', 'kd_komoditibps' => 'KOM002', 'tahun' => 2023, 'konsumsi_kuantity' => 98.75],
            ['kd_kelompokbps' => 'KEL001', 'kd_komoditibps' => 'KOM003', 'tahun' => 2023, 'konsumsi_kuantity' => 15.25],
            
            ['kd_kelompokbps' => 'KEL002', 'kd_komoditibps' => 'KOM004', 'tahun' => 2023, 'konsumsi_kuantity' => 45.80],
            ['kd_kelompokbps' => 'KEL002', 'kd_komoditibps' => 'KOM005', 'tahun' => 2023, 'konsumsi_kuantity' => 32.50],
            ['kd_kelompokbps' => 'KEL002', 'kd_komoditibps' => 'KOM006', 'tahun' => 2023, 'konsumsi_kuantity' => 28.75],
            
            ['kd_kelompokbps' => 'KEL003', 'kd_komoditibps' => 'KOM007', 'tahun' => 2023, 'konsumsi_kuantity' => 12.30],
            ['kd_kelompokbps' => 'KEL003', 'kd_komoditibps' => 'KOM008', 'tahun' => 2023, 'konsumsi_kuantity' => 25.90],
            ['kd_kelompokbps' => 'KEL003', 'kd_komoditibps' => 'KOM009', 'tahun' => 2023, 'konsumsi_kuantity' => 18.60],
            
            // Data tahun 2024
            ['kd_kelompokbps' => 'KEL001', 'kd_komoditibps' => 'KOM001', 'tahun' => 2024, 'konsumsi_kuantity' => 130.25],
            ['kd_kelompokbps' => 'KEL001', 'kd_komoditibps' => 'KOM002', 'tahun' => 2024, 'konsumsi_kuantity' => 102.50],
            ['kd_kelompokbps' => 'KEL001', 'kd_komoditibps' => 'KOM003', 'tahun' => 2024, 'konsumsi_kuantity' => 17.75],
            
            ['kd_kelompokbps' => 'KEL004', 'kd_komoditibps' => 'KOM010', 'tahun' => 2024, 'konsumsi_kuantity' => 22.50],
            ['kd_kelompokbps' => 'KEL004', 'kd_komoditibps' => 'KOM011', 'tahun' => 2024, 'konsumsi_kuantity' => 8.25],
            ['kd_kelompokbps' => 'KEL004', 'kd_komoditibps' => 'KOM012', 'tahun' => 2024, 'konsumsi_kuantity' => 5.80],
            
            ['kd_kelompokbps' => 'KEL005', 'kd_komoditibps' => 'KOM013', 'tahun' => 2024, 'konsumsi_kuantity' => 15.40],
            ['kd_kelompokbps' => 'KEL005', 'kd_komoditibps' => 'KOM014', 'tahun' => 2024, 'konsumsi_kuantity' => 12.75],
            ['kd_kelompokbps' => 'KEL005', 'kd_komoditibps' => 'KOM015', 'tahun' => 2024, 'konsumsi_kuantity' => 20.90],
        ];

        foreach ($susenasData as $susenas) {
            TransaksiSusenas::firstOrCreate(
                [
                    'kd_kelompokbps' => $susenas['kd_kelompokbps'],
                    'kd_komoditibps' => $susenas['kd_komoditibps'],
                    'tahun' => $susenas['tahun']
                ],
                $susenas
            );
        }
    }
}
