<?php

namespace Database\Factories;

use App\Models\DaftarAlamat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DaftarAlamat>
 */
class DaftarAlamatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $wilayahOptions = [
            'PROVINSI ACEH',
            'PROVINSI SUMATERA UTARA',
            'PROVINSI SUMATERA BARAT',
            'PROVINSI RIAU',
            'PROVINSI JAMBI',
            'PROVINSI SUMATERA SELATAN',
            'PROVINSI BENGKULU',
            'PROVINSI LAMPUNG',
            'PROVINSI KEPULAUAN BANGKA BELITUNG',
            'PROVINSI KEPULAUAN RIAU',
            'DKI JAKARTA',
            'PROVINSI JAWA BARAT',
            'PROVINSI JAWA TENGAH',
            'PROVINSI DI YOGYAKARTA',
            'PROVINSI JAWA TIMUR',
            'PROVINSI BANTEN',
            'PROVINSI BALI',
            'PROVINSI NUSA TENGGARA BARAT',
            'PROVINSI NUSA TENGGARA TIMUR',
            'PROVINSI KALIMANTAN BARAT',
            'PROVINSI KALIMANTAN TENGAH',
            'PROVINSI KALIMANTAN SELATAN',
            'PROVINSI KALIMANTAN TIMUR',
            'PROVINSI KALIMANTAN UTARA',
            'PROVINSI SULAWESI UTARA',
            'PROVINSI SULAWESI TENGAH',
            'PROVINSI SULAWESI SELATAN',
            'PROVINSI SULAWESI TENGGARA',
            'PROVINSI GORONTALO',
            'PROVINSI SULAWESI BARAT',
            'PROVINSI MALUKU',
            'PROVINSI MALUKU UTARA',
            'PROVINSI PAPUA BARAT',
            'PROVINSI PAPUA',
        ];

        $dinasOptions = [
            'Dinas Pertanian Tanaman Pangan',
            'Dinas Peternakan dan Kesehatan Hewan',
            'Dinas Perkebunan dan Kehutanan',
            'Dinas Perikanan dan Kelautan',
            'Badan Ketahanan Pangan',
            'Badan Pelaksana Penyuluhan Pertanian',
            'Balai Pengkajian Teknologi Pertanian',
            'Dinas Pertanian dan Peternakan',
            'Dinas Kehutanan dan Perkebunan',
            'Dinas Kelautan, Perikanan, Pertanian dan Peternakan',
        ];

        $kategoriOptions = array_keys(DaftarAlamat::getKategoriOptions());

        return [
            'no' => $this->faker->numberBetween(1, 999) . '.' . $this->faker->numberBetween(1, 99),
            'wilayah' => $this->faker->randomElement($wilayahOptions),
            'nama_dinas' => $this->faker->randomElement($dinasOptions),
            'alamat' => $this->faker->streetAddress() . ', ' . $this->faker->city(),
            'telp' => $this->faker->optional(0.8)->phoneNumber(),
            'faks' => $this->faker->optional(0.6)->phoneNumber(),
            'email' => $this->faker->optional(0.7)->safeEmail(),
            'website' => $this->faker->optional(0.4)->url(),
            'posisi' => $this->faker->optional(0.5)->latitude() . '° ' . $this->faker->randomElement(['N', 'S']) . ', ' . 
                       $this->faker->longitude() . '° ' . $this->faker->randomElement(['E', 'W']),
            'urut' => $this->faker->numberBetween(1, 1500),
            'status' => $this->faker->randomElement(['Aktif', 'Tidak Aktif', 'Draft', 'Arsip', 'Pending']),
            'kategori' => $this->faker->randomElement($kategoriOptions),
            'keterangan' => $this->faker->optional(0.3)->sentence(),
            'latitude' => $this->faker->optional(0.6)->latitude(-11, 6),
            'longitude' => $this->faker->optional(0.6)->longitude(95, 141),
        ];
    }

    /**
     * Indicate that the alamat is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'Aktif',
        ]);
    }

    /**
     * Indicate that the alamat has coordinates.
     */
    public function withCoordinates(): static
    {
        return $this->state(fn (array $attributes) => [
            'latitude' => $this->faker->latitude(-11, 6),
            'longitude' => $this->faker->longitude(95, 141),
        ]);
    }

    /**
     * Indicate that the alamat is from a specific province.
     */
    public function fromProvince(string $province): static
    {
        return $this->state(fn (array $attributes) => [
            'wilayah' => $province,
        ]);
    }
}
