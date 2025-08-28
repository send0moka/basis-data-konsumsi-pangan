<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicDaftarAlamatController extends Controller
{
    public function getData()
    {
        // Sample data for public daftar alamat
        $data = [
            [
                'id' => 1,
                'nama' => 'Kantor Pusat Pertanian',
                'alamat' => 'Jl. Harsono RM. No. 3, Ragunan, Jakarta Selatan 12550',
                'wilayah' => 'DKI Jakarta',
                'jenis' => 'Kantor Pusat',
                'lat' => -6.3056,
                'lng' => 106.8200
            ],
            [
                'id' => 2,
                'nama' => 'Balai Besar Penelitian Tanaman Padi',
                'alamat' => 'Jl. Raya 9, Sukamandi, Subang, Jawa Barat 41256',
                'wilayah' => 'Jawa Barat',
                'jenis' => 'Balai Penelitian',
                'lat' => -6.5833,
                'lng' => 107.5833
            ],
            [
                'id' => 3,
                'nama' => 'Kantor Dinas Pertanian Provinsi Jawa Timur',
                'alamat' => 'Jl. Pahlawan No. 7, Surabaya, Jawa Timur 60271',
                'wilayah' => 'Jawa Timur',
                'jenis' => 'Dinas Pertanian',
                'lat' => -7.2575,
                'lng' => 112.7521
            ],
            [
                'id' => 4,
                'nama' => 'Balai Pengkajian Teknologi Pertanian',
                'alamat' => 'Jl. Tentara Pelajar No. 12C, Bogor, Jawa Barat 16114',
                'wilayah' => 'Jawa Barat',
                'jenis' => 'Balai Pengkajian',
                'lat' => -6.5971,
                'lng' => 106.8060
            ],
            [
                'id' => 5,
                'nama' => 'Kantor Dinas Pertanian Provinsi Bali',
                'alamat' => 'Jl. WR Supratman No. 502, Denpasar, Bali 80235',
                'wilayah' => 'Bali',
                'jenis' => 'Dinas Pertanian',
                'lat' => -8.6705,
                'lng' => 115.2126
            ],
            [
                'id' => 6,
                'nama' => 'Balai Besar Penelitian Tanaman Jagung dan Serealia',
                'alamat' => 'Jl. Raya Karangploso KM 4, Malang, Jawa Timur 65152',
                'wilayah' => 'Jawa Timur',
                'jenis' => 'Balai Penelitian',
                'lat' => -7.9167,
                'lng' => 112.5833
            ],
            [
                'id' => 7,
                'nama' => 'Kantor Dinas Pertanian Provinsi Sumatera Utara',
                'alamat' => 'Jl. Jend. Sudirman No. 41, Medan, Sumatera Utara 20211',
                'wilayah' => 'Sumatera Utara',
                'jenis' => 'Dinas Pertanian',
                'lat' => 3.5952,
                'lng' => 98.6722
            ],
            [
                'id' => 8,
                'nama' => 'Balai Penelitian Tanaman Kacang-kacangan dan Umbi-umbian',
                'alamat' => 'Jl. Raya Kendalpayak KM 4, Malang, Jawa Timur 65154',
                'wilayah' => 'Jawa Timur',
                'jenis' => 'Balai Penelitian',
                'lat' => -7.8833,
                'lng' => 112.5333
            ],
            [
                'id' => 9,
                'nama' => 'Kantor Dinas Pertanian Provinsi Sulawesi Selatan',
                'alamat' => 'Jl. Perintis Kemerdekaan KM 10, Makassar, Sulawesi Selatan 90245',
                'wilayah' => 'Sulawesi Selatan',
                'jenis' => 'Dinas Pertanian',
                'lat' => -5.1477,
                'lng' => 119.4327
            ],
            [
                'id' => 10,
                'nama' => 'Balai Besar Penelitian Tanaman Hortikultura',
                'alamat' => 'Jl. Raya Pacet KM 1.5, Cianjur, Jawa Barat 43253',
                'wilayah' => 'Jawa Barat',
                'jenis' => 'Balai Penelitian',
                'lat' => -6.7167,
                'lng' => 107.1333
            ]
        ];

        return response()->json($data);
    }
}
