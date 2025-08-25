<?php

namespace Database\Seeders;

use App\Models\DaftarAlamat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DaftarAlamatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample data from alamat.sql
        $alamatData = [
            [
                'no' => '1',
                'wilayah' => 'PROVINSI ACEH',
                'nama_dinas' => 'Dinas Pertanian Tanaman Pangan',
                'alamat' => 'Jl. Panglima Nyak Makam No. 24 Lampineung, Banda Aceh',
                'telp' => '(0651) 7552041',
                'faks' => '(0651) 7552342',
                'email' => null,
                'website' => null,
                'posisi' => 'E 95° 20\' 35,3184" N 5° 33\' 44,046"',
                'urut' => 1,
                'status' => 'Aktif',
                'kategori' => 'Dinas Pertanian',
                'latitude' => 5.5622,
                'longitude' => 95.3431,
            ],
            [
                'no' => '1.6',
                'wilayah' => 'Kab. Aceh Tengah',
                'nama_dinas' => 'Dinas Perkebunan dan Kehutanan',
                'alamat' => 'Jl. Takengon Isak KM. 7 Takengon',
                'telp' => '(0643) 7426361',
                'faks' => '(0643) 7426360, 24746',
                'email' => 'disbunhut_acehtengah@yahoo.com',
                'website' => null,
                'posisi' => '-4° 35\' 15,2" N -96° 48\' 48,5" E',
                'urut' => 22,
                'status' => 'Aktif',
                'kategori' => 'Dinas Perkebunan',
                'latitude' => 4.5875,
                'longitude' => 96.8135,
            ],
            [
                'no' => '2',
                'wilayah' => 'PROVINSI SUMATERA UTARA',
                'nama_dinas' => 'Dinas Pertanian Tanaman Pangan',
                'alamat' => 'Jl. Jend. Besar AH. Nasution No. 6 Medan',
                'telp' => '(061) 7860633, 7864643',
                'faks' => '(061) 7860633',
                'email' => null,
                'website' => null,
                'posisi' => null,
                'urut' => 59,
                'status' => 'Aktif',
                'kategori' => 'Dinas Pertanian',
                'latitude' => 3.5952,
                'longitude' => 98.6722,
            ],
            [
                'no' => '4.7',
                'wilayah' => 'Kab. Rokan Hulu',
                'nama_dinas' => 'Dinas Perikanan dan Peternakan',
                'alamat' => 'Jl. Diponegoro No. 3 Pasir Pangarayan',
                'telp' => '(0782) 91547',
                'faks' => '(0762) 91547',
                'email' => null,
                'website' => null,
                'posisi' => null,
                'urut' => 201,
                'status' => 'Aktif',
                'kategori' => 'Dinas Perikanan',
                'latitude' => null,
                'longitude' => null,
            ],
            [
                'no' => '6.5',
                'wilayah' => 'Kab. Musi Rawas',
                'nama_dinas' => 'Badan Ketahanan Pangan',
                'alamat' => 'Jl. Agropolitan Center Komplek Perkantoran Pemda Mura, Muara Beliti',
                'telp' => '(0733) 4540005',
                'faks' => '(0733) 4540005',
                'email' => null,
                'website' => null,
                'posisi' => null,
                'urut' => 280,
                'status' => 'Aktif',
                'kategori' => 'Badan Ketahanan Pangan',
                'latitude' => null,
                'longitude' => null,
            ],
            [
                'no' => '26',
                'wilayah' => 'PROVINSI SULAWESI TENGAH',
                'nama_dinas' => 'Balai Pengkajian Teknologi Pertanian',
                'alamat' => 'Jl. Lasoso 62, Biromaru, Palu',
                'telp' => '(0451) 482546',
                'faks' => '(0451) 482549',
                'email' => 'bptpsulteng@yahoo.com',
                'website' => 'http://sulteng.litbang.deptan.go.id',
                'posisi' => null,
                'urut' => 978,
                'status' => 'Aktif',
                'kategori' => 'Balai Pengkajian Teknologi',
                'latitude' => -0.8917,
                'longitude' => 119.8707,
            ],
            [
                'no' => '27.22',
                'wilayah' => 'Kota Makassar',
                'nama_dinas' => 'Dinas Kelautan, Perikanan, Pertanian dan Peternakan',
                'alamat' => 'Jl. Bajiminasa No. 12 Makassar Kodepos 90126',
                'telp' => '(0411) 854920',
                'faks' => '(0411) 854759',
                'email' => null,
                'website' => null,
                'posisi' => null,
                'urut' => 1085,
                'status' => 'Aktif',
                'kategori' => 'Dinas Perikanan',
                'latitude' => -5.1477,
                'longitude' => 119.4327,
            ],
            [
                'no' => '28',
                'wilayah' => 'PROVINSI SULAWESI TENGGARA',
                'nama_dinas' => 'Dinas Pertanian dan Peternakan',
                'alamat' => 'Jl. Balai Kota No. 6 Kendari 93111',
                'telp' => '(0401) 3122733',
                'faks' => '(0401) 3121365',
                'email' => 'diistanak sultra@yahoo.com',
                'website' => null,
                'posisi' => '3.97 LS - 122.51 BT',
                'urut' => 1092,
                'status' => 'Aktif',
                'kategori' => 'Dinas Pertanian',
                'latitude' => -3.97,
                'longitude' => 122.51,
            ],
        ];

        foreach ($alamatData as $data) {
            DaftarAlamat::create($data);
        }

        // Create additional random data using factory
        DaftarAlamat::factory(50)->create();
        
        // Create some specific test data
        DaftarAlamat::factory(10)->active()->withCoordinates()->create();
        DaftarAlamat::factory(5)->fromProvince('PROVINSI JAWA BARAT')->create();
        DaftarAlamat::factory(5)->fromProvince('PROVINSI JAWA TENGAH')->create();
        DaftarAlamat::factory(5)->fromProvince('PROVINSI JAWA TIMUR')->create();
    }
}
