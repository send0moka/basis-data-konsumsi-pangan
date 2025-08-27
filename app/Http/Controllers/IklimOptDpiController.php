<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IklimOptDpiController extends Controller
{
    /**
     * Display the iklim opt dpi page
     */
    public function index()
    {
        return view('pertanian.iklim-opt-dpi');
    }

    /**
     * Get all topics (topik)
     */
    public function getTopiks()
    {
        $topiks = DB::table('iklimoptdpi_topik')
            ->select('id', 'deskripsi as nama')
            ->orderBy('id')
            ->get();
            
        return response()->json($topiks);
    }

    /**
     * Get variables (variabel) by topic
     */
    public function getVariabelsByTopik($topikId)
    {
        $variabels = DB::table('iklimoptdpi_variabel')
            ->select('id', 'deskripsi as nama', 'satuan')
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
        
        $klasifikasis = DB::table('iklimoptdpi_klasifikasi')
            ->whereIn('id_variabel', $variabelIds)
            ->select('id', 'deskripsi as nama')
            ->orderBy('id')
            ->get();
            
        return response()->json($klasifikasis);
    }

    /**
     * Get all regions (wilayah) - Using provinces from benih_pupuk for consistency
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
     * Get months (bulan) - Using months from benih_pupuk for consistency
     */
    public function getBulans()
    {
        $bulans = DB::table('bulan')
            ->select('id', 'nama')
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
        $years = DB::table('iklimoptdpi_data')
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
        Log::info('=== IKLIM OPT DPI SEARCH METHOD CALLED ===');
        Log::info('Request method: ' . $request->method());
        Log::info('Request URL: ' . $request->fullUrl());
        Log::info('All request data: ' . json_encode($request->all()));
        
        try {
            // Get filters from request
            $filters = $request->all();
            
            Log::info('Iklim OptDpi search request received', $filters);

            // Extract parameters from request
            $topik = $filters['topik'] ?? null;
            $variabels = is_array($filters['variabels']) ? $filters['variabels'] : [];
            $klasifikasis = is_array($filters['klasifikasis']) ? $filters['klasifikasis'] : [];
            $selectedRegions = is_array($filters['selectedRegions']) ? $filters['selectedRegions'] : [];

            Log::info('Parsed parameters', [
                'topik' => $topik,
                'variabels' => $variabels,
                'klasifikasis' => $klasifikasis,
                'selectedRegions' => count($selectedRegions)
            ]);

            // Handle year filtering
            $years = [];
            $yearMode = $filters['yearMode'] ?? 'range';
            
            if ($yearMode === 'specific' && !empty($filters['selectedYears'])) {
                $years = array_map('intval', $filters['selectedYears']);
            } elseif (!empty($filters['tahun_awal']) && !empty($filters['tahun_akhir'])) {
                for ($year = (int)$filters['tahun_awal']; $year <= (int)$filters['tahun_akhir']; $year++) {
                    $years[] = $year;
                }
            } elseif (!empty($filters['selectedYears'])) {
                $years = array_map('intval', $filters['selectedYears']);
            }

            Log::info('Year filtering result', [
                'yearMode' => $yearMode,
                'final_years' => $years
            ]);

            // If no filters are provided, return empty result
            if (empty($topik) || empty($variabels) || empty($klasifikasis) || 
                empty($selectedRegions) || empty($years)) {
                Log::warning('Missing required parameters for Iklim OptDpi search');
                
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
            $query = DB::table('iklimoptdpi_data as d')
                ->join('iklimoptdpi_variabel as v', 'd.id_variabel', '=', 'v.id')
                ->join('iklimoptdpi_klasifikasi as k', 'd.id_klasifikasi', '=', 'k.id')
                ->join('iklimoptdpi_topik as t', 'v.id_topik', '=', 't.id')
                ->join('wilayah as w', 'd.id_wilayah', '=', 'w.id')
                ->leftJoin('bulan as b', 'd.id_bulan', '=', 'b.id')
                ->select(
                    'd.tahun',
                    'w.nama as wilayah_nama',
                    'w.id as wilayah_id',
                    'v.id as variabel_id',
                    'v.deskripsi as variabel_nama',
                    'v.satuan',
                    'k.id as klasifikasi_id',
                    'k.deskripsi as klasifikasi_nama',
                    'd.nilai',
                    't.deskripsi as topik_nama',
                    'd.status',
                    'b.nama as bulan_nama',
                    'd.id_bulan'
                )
                ->where('t.id', $topik)
                ->whereIn('v.id', $variabels)
                ->whereIn('k.id', $klasifikasis)
                ->whereIn('w.id', $selectedRegions)
                ->whereIn('d.tahun', $years)
                ->orderBy('d.tahun')
                ->orderBy('w.sorter')
                ->orderBy('v.sorter')
                ->orderBy('k.id');

            $rawData = $query->get();

            // Debug: Log what data we found
            Log::info('Iklim OptDpi search query found ' . $rawData->count() . ' records');
            if ($rawData->count() > 0) {
                Log::info('Sample data: ' . json_encode($rawData->first()));
            }

            // Process data based on layout type
            $layoutType = $filters['tata_letak'] ?? 'tipe_1';
            $processedData = $this->formatDataForFrontend($rawData, $years, $layoutType, $filters);

            return response()->json($processedData);

        } catch (\Exception $e) {
            Log::error('Iklim OptDpi search error: ' . $e->getMessage());
            
            // Return fallback data structure
            return response()->json([
                'success' => false,
                'resultIndex' => 1,
                'topik_nama' => 'Error - Fallback Data',
                'headers' => ['2020', '2021', '2022'],
                'data' => [
                    ['label' => 'Sample Region', 'values' => [25.5, 26.2, 24.8]]
                ],
                'totals' => [25.5, 26.2, 24.8],
                'queueItem' => $filters,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Format data for frontend consumption
     */
    private function formatDataForFrontend($rawData, $years, $layoutType, $filters)
    {
        $topikNama = $rawData->first()->topik_nama ?? 'Iklim & OPT DPI Data';
        
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
            
            // Convert sums to averages
            foreach ($regionData as $regionName => $yearData) {
                foreach ($yearData as $year => $sum) {
                    $count = $regionCounts[$regionName][$year];
                    $regionData[$regionName][$year] = $count > 0 ? round($sum / $count, 2) : 0;
                }
            }

            // Get ALL selected regions from database
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
            
            // Group by classifications
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
            
            // Convert sums to averages
            foreach ($klasifikasiData as $klasifikasiName => $yearData) {
                foreach ($yearData as $year => $sum) {
                    $count = $klasifikasiCounts[$klasifikasiName][$year];
                    $klasifikasiData[$klasifikasiName][$year] = $count > 0 ? round($sum / $count, 2) : 0;
                }
            }

            // Get ALL selected klasifikasis from database
            $allSelectedKlasifikasis = DB::table('iklimoptdpi_klasifikasi')
                ->whereIn('id', $filters['klasifikasis'] ?? [])
                ->pluck('nama', 'id');

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
            // tipe_3: Variables as columns, years as rows (simplified since iklim doesn't have months)
            $variabelNames = DB::table('iklimoptdpi_variabel')
                ->whereIn('id', $filters['variabels'] ?? [])
                ->orderBy('id')
                ->pluck('nama')
                ->toArray();
            
            $headers = $variabelNames;
            
            // Group by years
            $yearData = [];
            $yearCounts = [];
            foreach ($rawData as $row) {
                if (!isset($yearData[$row->tahun])) {
                    $yearData[$row->tahun] = [];
                    $yearCounts[$row->tahun] = [];
                }
                if (!isset($yearData[$row->tahun][$row->variabel_nama])) {
                    $yearData[$row->tahun][$row->variabel_nama] = 0;
                    $yearCounts[$row->tahun][$row->variabel_nama] = 0;
                }
                $yearData[$row->tahun][$row->variabel_nama] += $row->nilai;
                $yearCounts[$row->tahun][$row->variabel_nama]++;
            }

            // Convert to averages
            foreach ($yearData as $year => $variabelData) {
                foreach ($variabelData as $variabelName => $sum) {
                    $count = $yearCounts[$year][$variabelName];
                    $yearData[$year][$variabelName] = $count > 0 ? round($sum / $count, 2) : 0;
                }
            }

            // Create data for each year
            foreach ($years as $year) {
                $values = [];
                foreach ($variabelNames as $variabelName) {
                    $values[] = $yearData[$year][$variabelName] ?? 0;
                }
                $data[] = [
                    'label' => (string)$year,
                    'values' => $values
                ];
            }
        }

        // Calculate totals
        if (!empty($data)) {
            $totals = array_fill(0, count($headers), 0);
            foreach ($data as $row) {
                foreach ($row['values'] as $index => $value) {
                    $totals[$index] += $value;
                }
            }
            // Convert totals to averages
            $totalRows = count($data);
            if ($totalRows > 0) {
                $totals = array_map(function($total) use ($totalRows) {
                    return round($total / $totalRows, 2);
                }, $totals);
            }
        }

        // Get detailed references for enhanced data structure
        $selectedVariabels = DB::table('iklimoptdpi_variabel')
            ->whereIn('id', $filters['variabels'] ?? [])
            ->get(['id', 'nama', 'satuan']);
            
        $selectedKlasifikasis = DB::table('iklimoptdpi_klasifikasi')
            ->whereIn('id', $filters['klasifikasis'] ?? [])
            ->get(['id', 'nama']);
            
        $selectedRegions = DB::table('wilayah')
            ->whereIn('id', $filters['selectedRegions'] ?? [])
            ->get(['id', 'nama']);

        // Create year groups (no months for iklim data)
        $yearGroups = array_map(function($year) {
            return [
                'year' => $year,
                'months' => [] // Empty for iklim data
            ];
        }, $years);

        return [
            'success' => true,
            'resultIndex' => $filters['resultIndex'] ?? 1,
            'topik_nama' => $topikNama,
            'headers' => $headers,
            'data' => $data,
            'totals' => $totals,
            'queueItem' => $filters,
            'selectedVariabels' => $selectedVariabels,
            'selectedKlasifikasis' => $selectedKlasifikasis,
            'selectedRegions' => $selectedRegions,
            'yearGroups' => $yearGroups,
            'raw_data' => $rawData->toArray(),
            'totalEntries' => $rawData->count(),
            'averageValue' => !empty($totals) ? array_sum($totals) / count($totals) : 0,
            'maxValue' => !empty($totals) ? max($totals) : 0,
            'minValue' => !empty($totals) ? min($totals) : 0
        ];
    }
}
