<?php

namespace App\Exports;

use App\Models\TransaksiNbm;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransaksiNbmExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return TransaksiNbm::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Kode Kelompok',
            'Kode Komoditi',
            'Tahun',
            'Status Angka',
            'Masukan',
            'Keluaran',
            'Impor',
            'Ekspor',
            'Perubahan Stok',
            'Pakan',
            'Bibit',
            'Makanan',
            'Bukan Makanan',
            'Tercecer',
            'Penggunaan Lain',
            'Bahan Makanan',
            'Kg/Tahun',
            'Gram/Hari',
            'Kalori/Hari',
            'Protein/Hari',
            'Lemak/Hari',
            'Created At',
            'Updated At',
        ];
    }
}
