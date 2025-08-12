<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kelompok>
 */
class KelompokFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $kelompokData = [
            ['kode' => '01', 'nama' => 'Padi - Padian'],
            ['kode' => '02', 'nama' => 'Makanan berpati'],
            ['kode' => '03', 'nama' => 'Gula'],
            ['kode' => '04', 'nama' => 'Buah Biji Berminyak'],
            ['kode' => '05', 'nama' => 'Buah-buahan'],
            ['kode' => '06', 'nama' => 'Sayur-sayuran'],
            ['kode' => '07', 'nama' => 'Daging'],
            ['kode' => '08', 'nama' => 'Telur'],
            ['kode' => '09', 'nama' => 'Susu'],
            ['kode' => '10', 'nama' => 'Minyak dan Lemak'],
        ];
        
        static $counter = 0;
        
        if ($counter < count($kelompokData)) {
            $data = $kelompokData[$counter];
            $counter++;
            return $data;
        }
        
        // Fallback jika sudah lebih dari 10 data
        return [
            'kode' => str_pad(($counter + 1), 2, '0', STR_PAD_LEFT),
            'nama' => $this->faker->words(2, true),
        ];
    }
}
