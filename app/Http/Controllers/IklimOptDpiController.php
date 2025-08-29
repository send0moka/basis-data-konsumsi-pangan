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
     * Get classifications (klasifikasi) by a single variable
     */
    public function getKlasifikasiByVariabel($variabelId)
    {
        $klasifikasis = DB::table('iklimoptdpi_klasifikasi')
            ->where('id_variabel', $variabelId)
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
     * Filter data based on frontend request
     */
    public function filter(Request $request)
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
     * Format data for the new frontend structure
     */
    private function formatDataForFrontend($rawData, $years, $layoutType, $filters)
    {
        $headers = [];
        $rows = [];
        $pivotData = [];

        if ($layoutType === 'tipe_1') { // Variabel sebagai Kolom (Wilayah vs Tahun)
            $headerLabel = 'Wilayah';
            $colNames = $years;
            $rowNames = DB::table('wilayah')->whereIn('id', $filters['selectedRegions'])->orderBy('sorter')->pluck('nama')->toArray();
            
            foreach ($rawData as $item) {
                $pivotData[$item->wilayah_nama][(string)$item->tahun] = ($pivotData[$item->wilayah_nama][(string)$item->tahun] ?? 0) + $item->nilai;
            }

        } else { // Wilayah sebagai Kolom (Klasifikasi vs Tahun)
            $headerLabel = 'Klasifikasi';
            $colNames = $years;
            $rowNames = DB::table('iklimoptdpi_klasifikasi')->whereIn('id', $filters['klasifikasis'])->orderBy('id')->pluck('deskripsi')->toArray();

            foreach ($rawData as $item) {
                $pivotData[$item->klasifikasi_nama][(string)$item->tahun] = ($pivotData[$item->klasifikasi_nama][(string)$item->tahun] ?? 0) + $item->nilai;
            }
        }

        $headers = array_merge([$headerLabel], $colNames);

        foreach ($rowNames as $rowName) {
            $rowData = [$rowName];
            foreach ($colNames as $colName) {
                $rowData[] = $pivotData[$rowName][(string)$colName] ?? '-';
            }
            $rows[] = $rowData;
        }

        return [
            'headers' => $headers,
            'rows' => $rows,
        ];
    }
}
