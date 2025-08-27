<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class BenihPupukController extends Controller
{
    /**
     * Display the benih pupuk page
     */
    public function index()
    {
        return view('pertanian.benih-pupuk');
    }

    /**
     * Get all topics (topik)
     */
    public function getTopiks()
    {
        $topiks = DB::table('benih_pupuk_topik')
            ->select('id', 'deskripsi')
            ->orderBy('id')
            ->get();
            
        return response()->json($topiks);
    }

    /**
     * Get variables (variabel) by topic
     */
    public function getVariabelsByTopik($topikId)
    {
        $variabels = DB::table('benih_pupuk_variabel')
            ->select('id', 'id_topik', 'deskripsi', 'satuan', 'sorter')
            ->where('id_topik', $topikId)
            ->orderBy('sorter')
            ->get();
            
        return response()->json($variabels);
    }

    /**
     * Get classifications (klasifikasi) by selected variables
     */
    public function getKlasifikasiByVariabels(Request $request)
    {
        $variabelIds = $request->input('variabel_ids', []);
        
        if (empty($variabelIds)) {
            return response()->json([]);
        }
        
        $klasifikasis = DB::table('benih_pupuk_klasifikasi as k')
            ->select('k.id', 'k.deskripsi')
            ->whereIn('k.id_variabel', $variabelIds)
            ->distinct()
            ->orderBy('k.id')
            ->get();
            
        return response()->json($klasifikasis);
    }

    /**
     * Get all regions (wilayah)
     */
    public function getWilayahs()
    {
        $wilayahs = DB::table('wilayah')
            ->select('id', 'nama', 'id_parent')
            ->orderBy('sorter')
            ->get();
            
        return response()->json($wilayahs);
    }

    /**
     * Get provinces only
     */
    public function getProvinces()
    {
        $provinces = DB::table('wilayah')
            ->select('id', 'nama')
            ->whereNull('id_parent')
            ->orderBy('sorter')
            ->get();
            
        return response()->json($provinces);
    }

    /**
     * Get kabupaten/kota by province
     */
    public function getKabupatenByProvince($provinceId)
    {
        $kabupaten = DB::table('wilayah')
            ->select('id', 'nama')
            ->where('id_parent', $provinceId)
            ->orderBy('sorter')
            ->get();
            
        return response()->json($kabupaten);
    }

    /**
     * Get months (bulan)
     */
    public function getBulans()
    {
        $bulans = DB::table('bulan')
            ->select('id', 'nama_bulan as nama')
            ->where('id', '>', 0) // Exclude id=0 ("-")
            ->orderBy('id')
            ->get();
            
        return response()->json($bulans);
    }

    /**
     * Get available years from data
     */
    public function getAvailableYears()
    {
        $years = DB::table('benih_pupuk_data')
            ->selectRaw('DISTINCT tahun')
            ->orderBy('tahun')
            ->pluck('tahun')
            ->toArray();
            
        return response()->json($years);
    }

    /**
     * Search data based on filters
     */
    public function search(Request $request)
    {
        Log::info('=== SEARCH METHOD CALLED ===');
        Log::info('Request method: ' . $request->method());
        Log::info('Request URL: ' . $request->fullUrl());
        Log::info('Request headers: ' . json_encode($request->headers->all()));
        Log::info('Raw request body: ' . $request->getContent());
        Log::info('All request data: ' . json_encode($request->all()));
        
        try {
            // Get filters from request
            $filters = $request->all();
            
            Log::info('Search request received', $filters);

            // Extract parameters from request
            $topik = $filters['topik'] ?? null;
            $variabels = is_array($filters['variabels']) ? $filters['variabels'] : [];
            $klasifikasis = is_array($filters['klasifikasis']) ? $filters['klasifikasis'] : [];
            $selectedRegions = is_array($filters['selectedRegions']) ? $filters['selectedRegions'] : [];
            $selectedMonths = is_array($filters['selectedMonths']) ? $filters['selectedMonths'] : [];

            Log::info('Parsed parameters', [
                'topik' => $topik,
                'variabels' => $variabels,
                'klasifikasis' => $klasifikasis,
                'selectedRegions' => count($selectedRegions),
                'selectedMonths' => count($selectedMonths)
            ]);

            // Handle year filtering
            $years = [];
            $yearMode = $filters['yearMode'] ?? 'range';
            
            if ($yearMode === 'specific' && !empty($filters['selectedYears'])) {
                // Use specific years when yearMode is "specific"
                $years = array_map('intval', $filters['selectedYears']);
            } elseif (!empty($filters['tahun_awal']) && !empty($filters['tahun_akhir'])) {
                // Use range when yearMode is "range" or as fallback
                for ($year = (int)$filters['tahun_awal']; $year <= (int)$filters['tahun_akhir']; $year++) {
                    $years[] = $year;
                }
            } elseif (!empty($filters['selectedYears'])) {
                // Final fallback to selectedYears
                $years = array_map('intval', $filters['selectedYears']);
            }

            Log::info('Year filtering result', [
                'yearMode' => $yearMode,
                'selectedYears' => $filters['selectedYears'] ?? null,
                'tahun_awal' => $filters['tahun_awal'] ?? null,
                'tahun_akhir' => $filters['tahun_akhir'] ?? null,
                'final_years' => $years
            ]);

            // If no filters are provided, return empty result
            if (empty($topik) || empty($variabels) || empty($klasifikasis) || 
                empty($selectedRegions) || empty($years) || empty($selectedMonths)) {
                Log::warning('Missing required parameters', [
                    'topik' => $topik,
                    'variabels' => count($variabels),
                    'klasifikasis' => count($klasifikasis),
                    'selectedRegions' => count($selectedRegions),
                    'years' => count($years),
                    'selectedMonths' => count($selectedMonths)
                ]);
                
                return response()->json([
                    'success' => true,
                    'resultIndex' => 1,
                    'topik_nama' => 'No Data - Missing Parameters',
                    'headers' => [],
                    'data' => [],
                    'totals' => [],
                    'queueItem' => $filters,
                    'selectedVariabels' => [],
                    'selectedKlasifikasis' => [],
                    'selectedRegions' => [],
                    'yearGroups' => []
                ]);
            }

            // Build the query
            $query = DB::table('benih_pupuk_data as d')
                ->join('benih_pupuk_variabel as v', 'd.id_variabel', '=', 'v.id')
                ->join('benih_pupuk_klasifikasi as k', 'd.id_klasifikasi', '=', 'k.id')
                ->join('wilayah as w', 'd.id_wilayah', '=', 'w.id')
                ->join('bulan as b', 'd.id_bulan', '=', 'b.id')
                ->join('benih_pupuk_topik as t', 'v.id_topik', '=', 't.id')
                ->select(
                    'd.tahun',
                    'd.id_bulan',
                    'b.nama as bulan_nama',
                    'd.id_wilayah',
                    'w.nama as wilayah_nama',
                    'd.id_variabel',
                    'v.deskripsi as variabel_nama',
                    'v.satuan',
                    'd.id_klasifikasi',
                    'k.deskripsi as klasifikasi_nama',
                    'd.nilai',
                    't.deskripsi as topik_nama'
                )
                ->where('v.id_topik', $topik)
                ->whereIn('d.id_variabel', $variabels)
                ->whereIn('d.id_klasifikasi', $klasifikasis)
                ->whereIn('d.id_wilayah', $selectedRegions)
                ->whereIn('d.tahun', $years)
                ->whereIn('d.id_bulan', $selectedMonths)
                ->orderBy('d.tahun')
                ->orderBy('d.id_bulan')
                ->orderBy('w.sorter')
                ->orderBy('v.sorter')
                ->orderBy('k.id');

            $rawData = $query->get();

            // Debug: Log what data we found
            Log::info('Search query found ' . $rawData->count() . ' records');
            if ($rawData->count() > 0) {
                Log::info('Sample data: ' . json_encode($rawData->first()));
            } else {
                Log::warning('No data found. Let\'s check what records exist');
                // Check if data exists with these parameters
                $checkQuery = DB::table('benih_pupuk_data as d')
                    ->join('benih_pupuk_variabel as v', 'd.id_variabel', '=', 'v.id')
                    ->select('d.id_variabel', 'v.deskripsi', 'v.id_topik')
                    ->where('v.id_topik', $topik)
                    ->whereIn('d.id_variabel', $variabels)
                    ->distinct()
                    ->get();
                Log::info('Available variabel data for topik: ' . json_encode($checkQuery));
                
                // Also check if regions exist
                $regionCheck = DB::table('wilayah')
                    ->whereIn('id', $selectedRegions)
                    ->get(['id', 'nama']);
                Log::info('Available regions: ' . json_encode($regionCheck));
                
                // Check available years
                $yearCheck = DB::table('benih_pupuk_data')
                    ->select('tahun')
                    ->distinct()
                    ->orderBy('tahun')
                    ->get();
                Log::info('Available years: ' . json_encode($yearCheck));
                
                // Let's check what data actually exists for our specific combination
                Log::info('Checking data for specific combination...');
                
                // First check: just the data table
                $dataCheck = DB::table('benih_pupuk_data')
                    ->where('id_wilayah', 1)
                    ->where('tahun', 2015)
                    ->where('id_bulan', 1)
                    ->limit(5)
                    ->get(['id_wilayah', 'id_variabel', 'id_klasifikasi', 'id_bulan', 'tahun', 'nilai']);
                Log::info('Data table records for region 1, year 2015, month 1: ' . json_encode($dataCheck));
                
                // Check foreign key relationships
                $variabelCheck = DB::table('benih_pupuk_variabel')
                    ->where('id', 1)
                    ->first(['id', 'id_topik', 'deskripsi']);
                Log::info('Variabel 1 details: ' . json_encode($variabelCheck));
                
                $klasifikasiCheck = DB::table('benih_pupuk_klasifikasi')
                    ->where('id', 1)
                    ->first(['id', 'nama', 'deskripsi']);
                Log::info('Klasifikasi 1 details: ' . json_encode($klasifikasiCheck));
            }
            Log::info('Search query found ' . $rawData->count() . ' records');
            if ($rawData->count() > 0) {
                Log::info('Sample data: ' . json_encode($rawData->first()));
            }

            // Process data based on layout type
            $layoutType = $filters['tata_letak'] ?? 'tipe_1';
            $processedData = $this->formatDataForFrontend($rawData, $years, $selectedMonths, $layoutType, $filters);

            return response()->json($processedData);

        } catch (\Exception $e) {
            Log::error('Search error: ' . $e->getMessage());
            
            // Return fallback data structure
            return response()->json([
                'success' => false,
                'resultIndex' => 1,
                'topik_nama' => 'Error - Fallback Data',
                'headers' => ['2020', '2021', '2022'],
                'data' => [
                    ['label' => 'Sample Region', 'values' => [1000, 1200, 1400]]
                ],
                'totals' => [1000, 1200, 1400],
                'queueItem' => $filters,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Format data for frontend consumption
     */
    private function formatDataForFrontend($rawData, $years, $selectedMonths, $layoutType, $filters)
    {
        $topikNama = $rawData->first()->topik_nama ?? 'Data Result';
        
        $headers = [];
        $data = [];
        $totals = [];

        if ($layoutType === 'tipe_1') {
            // Years as columns, regions as rows
            $headers = array_map('strval', $years);
            
            // Group by regions
            $regionData = [];
            $regionCounts = [];
            foreach ($rawData as $row) {
                if (!isset($regionData[$row->wilayah_nama])) {
                    $regionData[$row->wilayah_nama] = [];
                    $regionCounts[$row->wilayah_nama] = [];
                }
                if (!isset($regionData[$row->wilayah_nama][$row->tahun])) {
                    $regionData[$row->wilayah_nama][$row->tahun] = 0;
                    $regionCounts[$row->wilayah_nama][$row->tahun] = 0;
                }
                $regionData[$row->wilayah_nama][$row->tahun] += $row->nilai;
                $regionCounts[$row->wilayah_nama][$row->tahun]++;
            }
            
            // Convert sums to averages to avoid unrealistic high values
            foreach ($regionData as $regionName => $yearData) {
                foreach ($yearData as $year => $sum) {
                    $count = $regionCounts[$regionName][$year];
                    $regionData[$regionName][$year] = $count > 0 ? round($sum / $count, 2) : 0;
                }
            }

            // Get ALL selected regions from database, not just ones with data
            $allSelectedRegions = DB::table('wilayah')
                ->whereIn('id', $filters['selectedRegions'])
                ->orderBy('sorter')
                ->pluck('nama', 'id');

            // Create data for all selected regions
            foreach ($allSelectedRegions as $regionId => $regionName) {
                $values = [];
                foreach ($years as $year) {
                    $values[] = $regionData[$regionName][$year] ?? 0;
                }
                $data[] = [
                    'label' => $regionName,
                    'values' => $values
                ];
            }

        } elseif ($layoutType === 'tipe_2') {
            // Years as columns, classifications as rows
            $headers = array_map('strval', $years);
            
            Log::info('Processing tipe_2 layout', [
                'years' => $years,
                'headers' => $headers,
                'rawDataCount' => $rawData->count(),
                'sampleRawData' => $rawData->take(3)->toArray()
            ]);
            
            // Group by classifications and years, but average across regions and months
            $klasifikasiData = [];
            $klasifikasiCounts = [];
            foreach ($rawData as $row) {
                if (!isset($klasifikasiData[$row->klasifikasi_nama])) {
                    $klasifikasiData[$row->klasifikasi_nama] = [];
                    $klasifikasiCounts[$row->klasifikasi_nama] = [];
                }
                if (!isset($klasifikasiData[$row->klasifikasi_nama][$row->tahun])) {
                    $klasifikasiData[$row->klasifikasi_nama][$row->tahun] = 0;
                    $klasifikasiCounts[$row->klasifikasi_nama][$row->tahun] = 0;
                }
                $klasifikasiData[$row->klasifikasi_nama][$row->tahun] += $row->nilai;
                $klasifikasiCounts[$row->klasifikasi_nama][$row->tahun]++;
            }
            
            Log::info('Tipe_2 grouped data', [
                'klasifikasiData' => $klasifikasiData,
                'klasifikasiCounts' => $klasifikasiCounts
            ]);
            
            // Convert sums to averages to avoid unrealistic high values
            foreach ($klasifikasiData as $klasifikasiName => $yearData) {
                foreach ($yearData as $year => $sum) {
                    $count = $klasifikasiCounts[$klasifikasiName][$year];
                    $klasifikasiData[$klasifikasiName][$year] = $count > 0 ? round($sum / $count, 2) : 0;
                }
            }

            // Get ALL selected klasifikasis from database
            $allSelectedKlasifikasis = DB::table('benih_pupuk_klasifikasi')
                ->whereIn('id', $filters['klasifikasis'] ?? [])
                ->pluck('deskripsi', 'id');

            Log::info('All selected klasifikasis', [
                'filters_klasifikasis' => $filters['klasifikasis'] ?? [],
                'allSelectedKlasifikasis' => $allSelectedKlasifikasis->toArray()
            ]);

            // Create data for all selected klasifikasis
            foreach ($allSelectedKlasifikasis as $klasifikasiId => $klasifikasiName) {
                $values = [];
                foreach ($years as $year) {
                    $values[] = $klasifikasiData[$klasifikasiName][$year] ?? 0;
                }
                $data[] = [
                    'label' => $klasifikasiName,
                    'values' => $values
                ];
            }

        } else {
            // tipe_3: Months as columns, years as rows
            $monthNames = DB::table('bulan')
                ->whereIn('id', $selectedMonths)
                ->orderBy('id')
                ->pluck('nama')
                ->toArray();
            
            $headers = array_map(function($name) {
                return substr($name, 0, 3); // Shorten month names
            }, $monthNames);
            
            Log::info('Processing tipe_3 layout', [
                'selectedMonths' => $selectedMonths,
                'monthNames' => $monthNames,
                'headers' => $headers,
                'years' => $years,
                'rawDataCount' => $rawData->count(),
                'sampleRawData' => $rawData->take(3)->toArray()
            ]);
            
            // Group by years
            $yearData = [];
            $yearCounts = [];
            foreach ($rawData as $row) {
                if (!isset($yearData[$row->tahun])) {
                    $yearData[$row->tahun] = [];
                    $yearCounts[$row->tahun] = [];
                }
                if (!isset($yearData[$row->tahun][$row->id_bulan])) {
                    $yearData[$row->tahun][$row->id_bulan] = 0;
                    $yearCounts[$row->tahun][$row->id_bulan] = 0;
                }
                $yearData[$row->tahun][$row->id_bulan] += $row->nilai;
                $yearCounts[$row->tahun][$row->id_bulan]++;
            }
            
            Log::info('Tipe_3 grouped data', [
                'yearData' => $yearData,
                'yearCounts' => $yearCounts
            ]);
            
            // Convert sums to averages  
            foreach ($yearData as $year => $monthData) {
                foreach ($monthData as $monthId => $sum) {
                    $count = $yearCounts[$year][$monthId];
                    $yearData[$year][$monthId] = $count > 0 ? round($sum / $count, 2) : 0;
                }
            }

            // Create data for all years (ensure all years are shown)
            foreach ($years as $year) {
                $values = [];
                foreach ($selectedMonths as $monthId) {
                    $values[] = $yearData[$year][$monthId] ?? 0;
                }
                $data[] = [
                    'label' => (string)$year,
                    'values' => $values
                ];
            }
        }

        // Calculate column totals
        for ($i = 0; $i < count($headers); $i++) {
            $total = 0;
            foreach ($data as $row) {
                $total += $row['values'][$i] ?? 0;
            }
            $totals[] = $total;
        }

        Log::info('Final API response structure', [
            'layoutType' => $layoutType,
            'headersCount' => count($headers),
            'headers' => $headers,
            'dataCount' => count($data),
            'sampleDataItem' => count($data) > 0 ? $data[0] : null,
            'totalsCount' => count($totals)
        ]);

        return [
            'resultIndex' => 1,
            'topik_nama' => $topikNama,
            'headers' => $headers,
            'data' => $data,
            'totals' => $totals,
            'queueItem' => $filters,
            'selectedVariabels' => DB::table('benih_pupuk_variabel')
                ->whereIn('id', $filters['variabels'] ?? [])
                ->select('id', 'deskripsi', 'satuan')
                ->get()->toArray(),
            'selectedKlasifikasis' => DB::table('benih_pupuk_klasifikasi')
                ->whereIn('id', $filters['klasifikasis'] ?? [])
                ->select('id', 'deskripsi')
                ->get()->toArray(),
            'selectedRegions' => DB::table('wilayah')
                ->whereIn('id', $filters['selectedRegions'] ?? [])
                ->select('id', 'nama')
                ->orderBy('sorter')
                ->get()->toArray(),
            'yearGroups' => collect($years)->map(function($year) use ($selectedMonths) {
                return [
                    'year' => $year,
                    'months' => DB::table('bulan')
                        ->whereIn('id', $selectedMonths)
                        ->orderBy('id')
                        ->select('id', 'nama')
                        ->get()->toArray()
                ];
            })->toArray(),
            'statistics' => [
                'totalRecords' => $rawData->count(),
                'totalValue' => $rawData->sum('nilai'),
                'averageValue' => $rawData->count() > 0 ? $rawData->avg('nilai') : 0
            ],
            // Add raw data for frontend dataMap creation
            'raw_data' => $rawData->map(function($item) {
                return [
                    'id_wilayah' => $item->id_wilayah,
                    'tahun' => $item->tahun,
                    'id_bulan' => $item->id_bulan,
                    'id_variabel' => $item->id_variabel,
                    'id_klasifikasi' => $item->id_klasifikasi,
                    'nilai' => $item->nilai
                ];
            })->toArray()
        ];
    }

    /**
     * Get sample data for testing
     */
    public function getSampleData()
    {
        try {
            $sampleData = DB::table('benih_pupuk_data as d')
                ->join('benih_pupuk_variabel as v', 'd.id_variabel', '=', 'v.id')
                ->join('benih_pupuk_klasifikasi as k', 'd.id_klasifikasi', '=', 'k.id')
                ->join('wilayah as w', 'd.id_wilayah', '=', 'w.id')
                ->join('benih_pupuk_topik as t', 'v.id_topik', '=', 't.id')
                ->select(
                    't.id as topik_id',
                    't.deskripsi as topik_nama',
                    'v.id as variabel_id', 
                    'v.deskripsi as variabel_nama',
                    'k.id as klasifikasi_id',
                    'k.deskripsi as klasifikasi_nama',
                    'w.id as wilayah_id',
                    'w.nama as wilayah_nama',
                    'd.tahun',
                    'd.id_bulan',
                    'd.nilai'
                )
                ->limit(10)
                ->get();

            return response()->json([
                'success' => true,
                'sample_data' => $sampleData,
                'valid_params' => [
                    'topik' => $sampleData->first()->topik_id ?? null,
                    'variabels' => $sampleData->pluck('variabel_id')->unique()->take(2)->values()->toArray(),
                    'klasifikasis' => $sampleData->pluck('klasifikasi_id')->unique()->take(2)->values()->toArray(),
                    'regions' => $sampleData->pluck('wilayah_id')->unique()->take(5)->values()->toArray(),
                    'years' => $sampleData->pluck('tahun')->unique()->sort()->take(3)->values()->toArray()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Export benih pupuk data to Excel
     */
    public function exportExcel(Request $request)
    {
        $filters = $request->all();
        
        return Excel::download(new \App\Exports\BenihPupukExport($filters), 
            'benih-pupuk-report-' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Export benih pupuk data to CSV
     */
    public function exportCsv(Request $request)
    {
        $filters = $request->all();
        
        return Excel::download(new \App\Exports\BenihPupukExport($filters), 
            'benih-pupuk-report-' . date('Y-m-d') . '.csv');
    }

    /**
     * Export benih pupuk data to PDF
     */
    public function exportPdf(Request $request)
    {
        $filters = $request->all();
        
        // Get filtered data
        $query = DB::table('benih_pupuk_data as d')
            ->join('benih_pupuk_variabel as v', 'd.id_variabel', '=', 'v.id')
            ->join('benih_pupuk_klasifikasi as k', 'd.id_klasifikasi', '=', 'k.id')
            ->join('benih_pupuk_wilayah as w', 'd.id_wilayah', '=', 'w.id')
            ->join('benih_pupuk_bulan as b', 'd.id_bulan', '=', 'b.id')
            ->select(
                'd.tahun',
                'b.deskripsi as bulan',
                'w.nama as wilayah',
                'v.deskripsi as variabel',
                'k.deskripsi as klasifikasi',
                'd.nilai',
                'd.status'
            );

        // Apply filters
        if (!empty($filters['tahun'])) {
            $query->where('d.tahun', $filters['tahun']);
        }
        if (!empty($filters['bulan'])) {
            $query->where('d.id_bulan', $filters['bulan']);
        }
        if (!empty($filters['wilayah'])) {
            $query->where('d.id_wilayah', $filters['wilayah']);
        }
        if (!empty($filters['variabel'])) {
            $query->where('d.id_variabel', $filters['variabel']);
        }
        if (!empty($filters['klasifikasi'])) {
            $query->where('d.id_klasifikasi', $filters['klasifikasi']);
        }
        if (!empty($filters['status'])) {
            $query->where('d.status', $filters['status']);
        }

        $data = $query->orderBy('d.tahun', 'desc')
            ->orderBy('d.id_bulan')
            ->orderBy('w.nama')
            ->get();

        $pdf = Pdf::loadView('exports.benih-pupuk-pdf', compact('data', 'filters'));
        
        return $pdf->download('benih-pupuk-report-' . date('Y-m-d') . '.pdf');
    }
}
