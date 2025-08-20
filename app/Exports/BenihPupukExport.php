<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BenihPupukExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $exportData = [];
        
        foreach ($this->data as $resultSet) {
            $queueItem = $resultSet['queue_item'];
            $pivotData = $resultSet['data'];
            
            // Add header for this dataset
            $exportData[] = ['Dataset: ' . $queueItem['topik']];
            $exportData[] = ['Variabel: ' . implode(', ', $queueItem['variabels'])];
            $exportData[] = ['Klasifikasi: ' . implode(', ', $queueItem['klasifikasis'])];
            $exportData[] = ['Periode: ' . $queueItem['tahun_awal'] . ' - ' . $queueItem['tahun_akhir']];
            $exportData[] = ['Bulan: ' . implode(', ', $queueItem['bulans'])];
            $exportData[] = []; // Empty row
            
            // Add table data
            if (!empty($pivotData['data'])) {
                // Get all column headers
                $allColumns = [];
                foreach ($pivotData['data'] as $wilayah => $variabelData) {
                    foreach ($variabelData as $variabel => $tahunData) {
                        foreach (array_keys($tahunData) as $tahunBulan) {
                            $colKey = $variabel . ' - ' . $tahunBulan;
                            if (!in_array($colKey, $allColumns)) {
                                $allColumns[] = $colKey;
                            }
                        }
                    }
                }
                
                // Add table header
                $headerRow = array_merge(['Wilayah'], $allColumns);
                $exportData[] = $headerRow;
                
                // Add data rows
                foreach ($pivotData['data'] as $wilayah => $variabelData) {
                    $row = [$wilayah];
                    foreach ($allColumns as $column) {
                        $parts = explode(' - ', $column);
                        $variabel = $parts[0];
                        $tahunBulan = $parts[1] ?? '';
                        
                        $value = 0;
                        if (isset($variabelData[$variabel][$tahunBulan])) {
                            $value = $variabelData[$variabel][$tahunBulan];
                        }
                        $row[] = $value;
                    }
                    $exportData[] = $row;
                }
                
                // Add totals row
                if (!empty($pivotData['totals'])) {
                    $totalRow = ['TOTAL'];
                    foreach ($allColumns as $column) {
                        $parts = explode(' - ', $column);
                        $variabel = $parts[0];
                        $tahunBulan = $parts[1] ?? '';
                        
                        $totalValue = $pivotData['totals'][$variabel][$tahunBulan] ?? 0;
                        $totalRow[] = $totalValue;
                    }
                    $exportData[] = $totalRow;
                }
            }
            
            $exportData[] = []; // Empty row between datasets
            $exportData[] = []; // Empty row between datasets
        }
        
        return $exportData;
    }

    public function headings(): array
    {
        return [
            'Laporan Data Benih dan Pupuk',
            'Generated: ' . date('Y-m-d H:i:s')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 16]],
            2 => ['font' => ['size' => 12]],
        ];
    }
}
