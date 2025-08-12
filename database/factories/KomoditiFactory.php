<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Komoditi>
 */
class KomoditiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $komoditiData = [
            // Kelompok 01 - Padi-Padian
            ['kode_kelompok' => '01', 'kode_komoditi' => '0101', 'nama' => 'Gabah'],
            ['kode_kelompok' => '01', 'kode_komoditi' => '0102', 'nama' => 'Beras'],
            ['kode_kelompok' => '01', 'kode_komoditi' => '0103', 'nama' => 'Jagung'],
            ['kode_kelompok' => '01', 'kode_komoditi' => '0104', 'nama' => 'Jagung basah'],
            ['kode_kelompok' => '01', 'kode_komoditi' => '0105', 'nama' => 'Gandum'],
            ['kode_kelompok' => '01', 'kode_komoditi' => '0106', 'nama' => 'Tepung Gandum'],
            
            // Kelompok 02 - Makanan berpati
            ['kode_kelompok' => '02', 'kode_komoditi' => '0201', 'nama' => 'Ubi Jalar'],
            ['kode_kelompok' => '02', 'kode_komoditi' => '0202', 'nama' => 'Ubi Kayu'],
            ['kode_kelompok' => '02', 'kode_komoditi' => '0203', 'nama' => 'Ubi Kayu/Gaplek'],
            ['kode_kelompok' => '02', 'kode_komoditi' => '0204', 'nama' => 'Ubi Kayu/Tapioka'],
            ['kode_kelompok' => '02', 'kode_komoditi' => '0205', 'nama' => 'Sagu/Tepung sagu'],
            
            // Kelompok 03 - Gula
            ['kode_kelompok' => '03', 'kode_komoditi' => '0301', 'nama' => 'Gula Pasir'],
            ['kode_kelompok' => '03', 'kode_komoditi' => '0302', 'nama' => 'Gula Mangkok'],
            
            // Kelompok 04 - Buah Biji Berminyak
            ['kode_kelompok' => '04', 'kode_komoditi' => '0401', 'nama' => 'Kacang tanah berkulit'],
            ['kode_kelompok' => '04', 'kode_komoditi' => '0402', 'nama' => 'Kacang tanah lepas kulit'],
            ['kode_kelompok' => '04', 'kode_komoditi' => '0403', 'nama' => 'Kedelai'],
            ['kode_kelompok' => '04', 'kode_komoditi' => '0404', 'nama' => 'Kacang Hijau'],
            ['kode_kelompok' => '04', 'kode_komoditi' => '0405', 'nama' => 'Kelapa Berkulit/daging'],
            ['kode_kelompok' => '04', 'kode_komoditi' => '0406', 'nama' => 'Kelapa daging/kopra'],
            
            // Kelompok 05 - Buah-buahan
            ['kode_kelompok' => '05', 'kode_komoditi' => '0501', 'nama' => 'Alpokat'],
            ['kode_kelompok' => '05', 'kode_komoditi' => '0502', 'nama' => 'Jeruk'],
            ['kode_kelompok' => '05', 'kode_komoditi' => '0503', 'nama' => 'Duku'],
            ['kode_kelompok' => '05', 'kode_komoditi' => '0504', 'nama' => 'Durian'],
            ['kode_kelompok' => '05', 'kode_komoditi' => '0505', 'nama' => 'Jambu'],
            ['kode_kelompok' => '05', 'kode_komoditi' => '0506', 'nama' => 'Mangga'],
        ];
        
        static $counter = 0;
        
        if ($counter < count($komoditiData)) {
            $data = $komoditiData[$counter];
            $counter++;
            return $data;
        }
        
        // Fallback jika sudah lebih dari data yang tersedia
        return [
            'kode_kelompok' => '01',
            'kode_komoditi' => 'K' . str_pad(($counter + 1), 3, '0', STR_PAD_LEFT),
            'nama' => $this->faker->words(2, true),
        ];
    }
}
