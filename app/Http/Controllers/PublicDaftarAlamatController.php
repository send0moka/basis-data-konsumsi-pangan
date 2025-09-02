<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DaftarAlamat;

class PublicDaftarAlamatController extends Controller
{
    public function getData()
    {
        // Get actual data from database - filter for active records with coordinates
        $data = DaftarAlamat::active()
            ->withCoordinates()
            ->select([
                'id',
                'nama_dinas as nama',
                'alamat',
                'provinsi',
                'kabupaten_kota',
                'latitude as lat',
                'longitude as lng',
                'gambar',
                'telp',
                'email',
                'website'
            ])
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nama' => $item->nama,
                    'alamat' => $item->alamat,
                    'provinsi' => $item->provinsi,
                    'kabupaten_kota' => $item->kabupaten_kota,
                    'wilayah' => $item->kabupaten_kota . ', ' . $item->provinsi, // Keep for backward compatibility
                    'jenis' => 'Dinas Pertanian', // Default value for backward compatibility
                    'lat' => (float) $item->lat,
                    'lng' => (float) $item->lng,
                    'gambar' => $item->gambar_url, // This will use the getGambarUrlAttribute accessor
                    'telp' => $item->telp,
                    'email' => $item->email,
                    'website' => $item->website
                ];
            })
            ->toArray();

        return response()->json($data);
    }
}
