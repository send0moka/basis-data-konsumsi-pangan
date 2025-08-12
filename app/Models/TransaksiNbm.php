<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiNbm extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode_kelompok',
        'kode_komoditi',
        'tahun',
        'status_angka',
        'masukan',
        'keluaran',
        'impor',
        'ekspor',
        'perubahan_stok',
        'pakan',
        'bibit',
        'makanan',
        'bukan_makanan',
        'tercecer',
        'penggunaan_lain',
        'bahan_makanan',
        'kg_tahun',
        'gram_hari',
        'kalori_hari',
        'protein_hari',
        'lemak_hari',
    ];

    protected $casts = [
        'masukan' => 'decimal:4',
        'keluaran' => 'decimal:4',
        'impor' => 'decimal:4',
        'ekspor' => 'decimal:4',
        'perubahan_stok' => 'decimal:4',
        'pakan' => 'decimal:4',
        'bibit' => 'decimal:4',
        'makanan' => 'decimal:4',
        'bukan_makanan' => 'decimal:4',
        'tercecer' => 'decimal:4',
        'penggunaan_lain' => 'decimal:4',
        'bahan_makanan' => 'decimal:4',
        'kg_tahun' => 'decimal:4',
        'gram_hari' => 'decimal:4',
        'kalori_hari' => 'decimal:4',
        'protein_hari' => 'decimal:4',
        'lemak_hari' => 'decimal:6',
    ];
}
