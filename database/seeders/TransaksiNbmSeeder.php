<?php

namespace Database\Seeders;

use App\Models\TransaksiNbm;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransaksiNbmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample data from SQL file adapted to our migration structure
        $data = [
            [
                'kode_kelompok' => '01',
                'kode_komoditi' => '0102',
                'tahun' => 1993,
                'status_angka' => 'tetap',
                'masukan' => 44230.0000,
                'keluaran' => 28750.0000,
                'impor' => 24.0000,
                'ekspor' => 351.0000,
                'perubahan_stok' => -474.0000,
                'pakan' => 0.0000,
                'bibit' => 0.0000,
                'makanan' => 0.0000,
                'bukan_makanan' => 0.0000,
                'tercecer' => 722.0000,
                'penggunaan_lain' => null,
                'bahan_makanan' => 28175.0000,
                'kg_tahun' => 150.2000,
                'gram_hari' => 411.4900,
                'kalori_hari' => 1481.0000,
                'protein_hari' => 27.9800,
                'lemak_hari' => 2.880000,
            ],
            [
                'kode_kelompok' => '01',
                'kode_komoditi' => '0102',
                'tahun' => 1994,
                'status_angka' => 'tetap',
                'masukan' => 42753.0000,
                'keluaran' => 27789.0000,
                'impor' => 625.0000,
                'ekspor' => 160.0000,
                'perubahan_stok' => -1069.0000,
                'pakan' => 0.0000,
                'bibit' => 0.0000,
                'makanan' => 0.0000,
                'bukan_makanan' => 0.0000,
                'tercecer' => 733.0000,
                'penggunaan_lain' => null,
                'bahan_makanan' => 28590.0000,
                'kg_tahun' => 149.9400,
                'gram_hari' => 410.8000,
                'kalori_hari' => 1479.0000,
                'protein_hari' => 27.9300,
                'lemak_hari' => 2.880000,
            ],
            [
                'kode_kelompok' => '01',
                'kode_komoditi' => '0103',
                'tahun' => 1993,
                'status_angka' => 'tetap',
                'masukan' => 0.0000,
                'keluaran' => 6460.0000,
                'impor' => 494.0000,
                'ekspor' => 61.0000,
                'perubahan_stok' => 0.0000,
                'pakan' => 414.0000,
                'bibit' => 76.0000,
                'makanan' => 0.0000,
                'bukan_makanan' => 646.0000,
                'tercecer' => 345.0000,
                'penggunaan_lain' => null,
                'bahan_makanan' => 5412.0000,
                'kg_tahun' => 28.8500,
                'gram_hari' => 79.0400,
                'kalori_hari' => 253.0000,
                'protein_hari' => 6.5400,
                'lemak_hari' => 2.770000,
            ],
            [
                'kode_kelompok' => '02',
                'kode_komoditi' => '0205',
                'tahun' => 1993,
                'status_angka' => 'tetap',
                'masukan' => 321.0000,
                'keluaran' => 129.0000,
                'impor' => 0.0000,
                'ekspor' => 1.0000,
                'perubahan_stok' => 0.0000,
                'pakan' => 0.0000,
                'bibit' => 0.0000,
                'makanan' => 0.0000,
                'bukan_makanan' => 0.0000,
                'tercecer' => 0.0000,
                'penggunaan_lain' => null,
                'bahan_makanan' => 128.0000,
                'kg_tahun' => 0.6800,
                'gram_hari' => 1.8600,
                'kalori_hari' => 7.0000,
                'protein_hari' => 0.0100,
                'lemak_hari' => 0.000000,
            ],
            [
                'kode_kelompok' => '05',
                'kode_komoditi' => '0537',
                'tahun' => 2021,
                'status_angka' => 'tetap',
                'masukan' => 0.0000,
                'keluaran' => 0.0000,
                'impor' => 5.4572,
                'ekspor' => 0.0002,
                'perubahan_stok' => 0.0000,
                'pakan' => 0.0000,
                'bibit' => 0.0000,
                'makanan' => 0.0000,
                'bukan_makanan' => 0.0000,
                'tercecer' => 0.0606,
                'penggunaan_lain' => 0.0000,
                'bahan_makanan' => 5.3965,
                'kg_tahun' => 0.0198,
                'gram_hari' => 0.0542,
                'kalori_hari' => 0.0417,
                'protein_hari' => 0.0004,
                'lemak_hari' => 0.000325,
            ],
            [
                'kode_kelompok' => '01',
                'kode_komoditi' => '0106',
                'tahun' => 2020,
                'status_angka' => 'sementara',
                'masukan' => 4758.0000,
                'keluaran' => 3426.0000,
                'impor' => 779.0000,
                'ekspor' => 145.0000,
                'perubahan_stok' => 0.0000,
                'pakan' => 0.0000,
                'bibit' => 0.0000,
                'makanan' => 0.0000,
                'bukan_makanan' => 34.0000,
                'tercecer' => 12.0000,
                'penggunaan_lain' => null,
                'bahan_makanan' => 4014.0000,
                'kg_tahun' => 16.8300,
                'gram_hari' => 46.1100,
                'kalori_hari' => 1564.0000,
                'protein_hari' => 4.1500,
                'lemak_hari' => 0.460000,
            ],
        ];

        foreach ($data as $item) {
            TransaksiNbm::create($item);
        }

        // Create additional random data using factory
        TransaksiNbm::factory(50)->create();
    }
}
