<?php

namespace Database\Seeders;

use App\Models\LahanTopik;
use App\Models\LahanVariabel;
use App\Models\LahanKlasifikasi;
use App\Models\LahanData;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create lahan topik based on ref_pertanianlahan.sql
        $topik = LahanTopik::create([
            'deskripsi' => 'Luas Lahan'
        ]);

        // Create lahan variabel based on ref_pertanianlahan.sql
        $variabels = [
            [
                'id_topik' => $topik->id,
                'deskripsi' => 'Sawah',
                'satuan' => 'Ha',
                'sorter' => 1
            ],
            [
                'id_topik' => $topik->id,
                'deskripsi' => 'Bukan Sawah',
                'satuan' => 'Ha',
                'sorter' => 2
            ]
        ];

        $insertedVariabels = [];
        foreach ($variabels as $variabelData) {
            $insertedVariabels[] = LahanVariabel::create($variabelData);
        }

        // Create lahan klasifikasi based on ref_pertanianlahan.sql
        $klasifikasis = [
            ['deskripsi' => '-', 'sorter' => 1],
            ['deskripsi' => 'Irigasi', 'sorter' => 2],
            ['deskripsi' => 'Non Irigasi', 'sorter' => 3],
            ['deskripsi' => 'Tegal/Kebun', 'sorter' => 4],
            ['deskripsi' => 'Ladang/Huma', 'sorter' => 5],
            ['deskripsi' => 'Sementara tidak diusahakan', 'sorter' => 6],
            ['deskripsi' => 'Irigasi + NonIrigasi', 'sorter' => 7]
        ];

        $insertedKlasifikasis = [];
        foreach ($klasifikasis as $klasifikasiData) {
            $insertedKlasifikasis[] = LahanKlasifikasi::create($klasifikasiData);
        }

        // Map variabel-klasifikasi relationships based on variabelklasifikasi table
        $variabelKlasifikasiMap = [
            6 => [2, 3, 7], // Sawah -> Irigasi, Non Irigasi, Irigasi + NonIrigasi
            7 => [4, 5, 6]  // Bukan Sawah -> Tegal/Kebun, Ladang/Huma, Sementara tidak diusahakan
        ];

        // Update klasifikasi with proper id_variabel
        foreach ($variabelKlasifikasiMap as $variabelId => $klasifikasiIds) {
            // Find the corresponding new variabel (index 0 for variabel 6, index 1 for variabel 7)
            $variabelIndex = $variabelId == 6 ? 0 : 1;
            $currentVariabel = $insertedVariabels[$variabelIndex];
            
            foreach ($klasifikasiIds as $klasifikasiId) {
                // Find klasifikasi by old id (adjust index since array is 0-based but ids start from 1)
                $klasifikasiIndex = $klasifikasiId - 1;
                if (isset($insertedKlasifikasis[$klasifikasiIndex])) {
                    $insertedKlasifikasis[$klasifikasiIndex]->update([
                        'id_variabel' => $currentVariabel->id
                    ]);
                }
            }
        }

        // Note: Klasifikasi with deskripsi "-" (index 0) is intentionally left without variabel mapping
        // as it represents a default/null classification that may not be used in the new structure

        // Note: Data seeding will be done separately due to large volume
        // The actual data from ref_pertanianlahan.sql contains thousands of records
        // You can uncomment and modify the following section to seed sample data
        
        /*
        // Sample data seeding (uncomment to use)
        $sampleData = [
            ['tahun' => 2010, 'id_bulan' => 0, 'id_wilayah' => 11, 'id_variabel' => $insertedVariabels[0]->id, 'id_klasifikasi' => $insertedKlasifikasis[1]->id, 'nilai' => 201230, 'status' => null],
            ['tahun' => 2010, 'id_bulan' => 0, 'id_wilayah' => 11, 'id_variabel' => $insertedVariabels[0]->id, 'id_klasifikasi' => $insertedKlasifikasis[2]->id, 'nilai' => 112419, 'status' => null],
            // Add more sample data as needed
        ];

        foreach ($sampleData as $dataRow) {
            LahanData::create($dataRow);
        }
        */
    }
}
