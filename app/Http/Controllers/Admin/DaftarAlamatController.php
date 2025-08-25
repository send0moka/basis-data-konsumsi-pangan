<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\DaftarAlamatExport;
use App\Models\DaftarAlamat;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DaftarAlamatController extends Controller
{
    /**
     * Export daftar alamat data to Excel
     */
    public function exportExcel(Request $request)
    {
        $filters = $request->only(['wilayah', 'kategori', 'status', 'date_from', 'date_to']);
        
        $filename = 'daftar-alamat-' . now()->format('Y-m-d-H-i-s') . '.xlsx';
        
        return Excel::download(new DaftarAlamatExport($filters), $filename);
    }

    /**
     * Export daftar alamat data to CSV
     */
    public function exportCsv(Request $request)
    {
        $filters = $request->only(['wilayah', 'kategori', 'status', 'date_from', 'date_to']);
        
        $filename = 'daftar-alamat-' . now()->format('Y-m-d-H-i-s') . '.csv';
        
        return Excel::download(new DaftarAlamatExport($filters), $filename, \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Export daftar alamat data to PDF (HTML format for printing)
     */
    public function exportPdf(Request $request)
    {
        $filters = $request->only(['wilayah', 'kategori', 'status', 'date_from', 'date_to', 'report_type']);
        
        // Build query with filters
        $query = DaftarAlamat::query();
        
        if (!empty($filters['date_from']) && !empty($filters['date_to'])) {
            $query->whereBetween('created_at', [$filters['date_from'], $filters['date_to'] . ' 23:59:59']);
        }
        
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        
        if (!empty($filters['kategori'])) {
            $query->where('kategori', $filters['kategori']);
        }
        
        if (!empty($filters['wilayah'])) {
            $query->where('wilayah', 'like', '%' . $filters['wilayah'] . '%');
        }
        
        $data = $query->orderBy('wilayah')->orderBy('nama_dinas')->get();
        $reportType = $filters['report_type'] ?? 'detail';
        
        // Return HTML view that can be printed as PDF by browser
        return response()->view('exports.daftar-alamat-pdf', compact('data', 'filters', 'reportType'))
                         ->header('Content-Type', 'text/html')
                         ->header('Content-Disposition', 'inline; filename="laporan-daftar-alamat-' . now()->format('Y-m-d-H-i-s') . '.html"');
    }
}
