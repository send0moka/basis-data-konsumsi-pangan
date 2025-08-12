<?php

namespace App\Exports;

use App\Models\Kelompok;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class KelompokExport implements FromCollection, WithHeadings, WithMapping
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
        return Kelompok::when($this->search, function ($query) {
            $query->where(function($q) {
                $q->where('kode', 'like', '%' . $this->search . '%')
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
            'Kode',
            'Nama Kelompok',
            'Dibuat Pada',
            'Diupdate Pada',
        ];
    }

    /**
     * @param Kelompok $kelompok
     * @return array
     */
    public function map($kelompok): array
    {
        return [
            $kelompok->kode,
            $kelompok->nama,
            $kelompok->created_at->format('d/m/Y H:i:s'),
            $kelompok->updated_at->format('d/m/Y H:i:s'),
        ];
    }
}
