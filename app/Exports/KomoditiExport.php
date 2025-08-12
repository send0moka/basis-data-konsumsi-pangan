<?php

namespace App\Exports;

use App\Models\Komoditi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class KomoditiExport implements FromCollection, WithHeadings, WithMapping
{
    protected $search;

    public function __construct($search = null)
    {
        $this->search = $search;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Komoditi::when($this->search, function ($query) {
            $query->where(function($q) {
                $q->where('kode_kelompok', 'like', '%' . $this->search . '%')
                  ->orWhere('kode_komoditi', 'like', '%' . $this->search . '%')
                  ->orWhere('nama', 'like', '%' . $this->search . '%');
            });
        })->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Kode Kelompok',
            'Kode Komoditi',
            'Nama Komoditi',
            'Dibuat Pada',
            'Diupdate Pada',
        ];
    }

    /**
     * @param Komoditi $komoditi
     * @return array
     */
    public function map($komoditi): array
    {
        return [
            $komoditi->kode_kelompok,
            $komoditi->kode_komoditi,
            $komoditi->nama,
            $komoditi->created_at->format('d/m/Y H:i:s'),
            $komoditi->updated_at->format('d/m/Y H:i:s'),
        ];
    }
}
