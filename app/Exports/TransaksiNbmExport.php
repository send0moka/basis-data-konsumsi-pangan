<?php

namespace App\Exports;

use App\Models\TransaksiNbm;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Collection;

class TransaksiNbmExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return TransaksiNbm::with(['kelompok', 'komoditi'])->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Kelompok',
            'Komoditi', 
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

    public function map($transaksi): array
    {
        return [
            $transaksi->id,
            $transaksi->kelompok ? ($transaksi->kelompok->kode . ' - ' . $transaksi->kelompok->nama) : $transaksi->kode_kelompok,
            $transaksi->komoditi ? ($transaksi->komoditi->kode_komoditi . ' - ' . $transaksi->komoditi->nama) : ($transaksi->kode_komoditi ?: 'N/A'),
            $transaksi->tahun,
            $transaksi->status_angka,
            $transaksi->masukan ?? 0,
            $transaksi->keluaran ?? 0,
            $transaksi->impor ?? 0,
            $transaksi->ekspor ?? 0,
            $transaksi->perubahan_stok ?? 0,
            $transaksi->pakan ?? 0,
            $transaksi->bibit ?? 0,
            $transaksi->makanan ?? 0,
            $transaksi->bukan_makanan ?? 0,
            $transaksi->tercecer ?? 0,
            $transaksi->penggunaan_lain ?? 0,
            $transaksi->bahan_makanan ?? 0,
            $transaksi->kg_tahun ?? 0,
            $transaksi->gram_hari ?? 0,
            $transaksi->kalori_hari ?? 0,
            $transaksi->protein_hari ?? 0,
            $transaksi->lemak_hari ?? 0,
            $transaksi->created_at ? $transaksi->created_at->format('Y-m-d H:i:s') : '',
            $transaksi->updated_at ? $transaksi->updated_at->format('Y-m-d H:i:s') : '',
        ];
    }
}
