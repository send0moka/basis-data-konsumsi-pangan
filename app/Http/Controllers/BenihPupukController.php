<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class BenihPupukController extends Controller
{
    /**
     * Display the benih pupuk page
     */
    public function index()
    {
        $topiks = DB::table('benih_pupuk_topik')->select('id', 'deskripsi as nama')->orderBy('id')->get();
        $variabels = DB::table('benih_pupuk_variabel')->select('id', 'id_topik as topik_id', 'deskripsi as nama', 'satuan')->orderBy('sorter')->get();
        $klasifikasis = DB::table('benih_pupuk_klasifikasi')->select('id', 'id_variabel as variabel_id', 'deskripsi as nama')->orderBy('id')->get();
        $tahuns = DB::table('benih_pupuk_data')->select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');
        $bulans = DB::table('bulan')->select('id', 'nama as nama')->where('id', '>', 0)->orderBy('id')->get();
        
        $provinsis = DB::table('wilayah')->whereNull('id_parent')->orderBy('sorter')->get(['id', 'nama']);
        $kabupatens = DB::table('wilayah')->whereNotNull('id_parent')->orderBy('sorter')->get(['id', 'nama', 'id_parent']);

        $wilayahs = $provinsis->map(function ($provinsi) use ($kabupatens) {
            $provinsi->kabupaten = $kabupatens->where('id_parent', $provinsi->id)->values();
            return $provinsi;
        });

        return view('pertanian.benih-pupuk', compact('topiks', 'variabels', 'klasifikasis', 'tahuns', 'bulans', 'wilayahs'));
    }

    /**
     * Get all topics (topik)
     */
    public function getTopiks()
    {
        $topiks = DB::table('benih_pupuk_topik')
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
        $variabels = DB::table('benih_pupuk_variabel')
            ->select('id', 'id_topik', 'deskripsi as nama', 'satuan', 'sorter')
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
            ->select('k.id', 'k.deskripsi as nama')
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
            ->select('id', 'nama as nama')
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
    public function filter(Request $request)
    {
        try {
            $payload = $request->validate([
                'selections' => 'required|array',
                'config' => 'required|array',
                'config.tata_letak' => 'required|string',
                'config.provinsi_ids' => 'nullable|array',
                'config.kabupaten_ids' => 'nullable|array',
                'selections.*.variabel_id' => 'required',
                'selections.*.tahun_ids' => 'required|array',
                'selections.*.klasifikasi_ids' => 'required|array',
                'selections.*.bulan_ids' => 'required|array',
            ]);

            $tataLetak = $payload['config']['tata_letak'];
            $wilayahIds = array_unique(array_merge($payload['config']['provinsi_ids'] ?? [], $payload['config']['kabupaten_ids'] ?? []));
            $selections = $payload['selections'];

            if (empty($wilayahIds) || empty($selections)) {
                return response()->json(['headers' => [], 'rows' => [], 'columnOrder' => [], 'data' => []]);
            }

            $query = DB::table('benih_pupuk_data as d')
                ->join('bulan as b', 'd.id_bulan', '=', 'b.id')
                ->join('benih_pupuk_variabel as v', 'd.id_variabel', '=', 'v.id')
                ->join('benih_pupuk_klasifikasi as k', 'd.id_klasifikasi', '=', 'k.id')
                ->join('wilayah as w', 'd.id_wilayah', '=', 'w.id')
                ->select(
                    'd.nilai',
                    'v.deskripsi as variabel',
                    'k.deskripsi as klasifikasi',
                    'd.tahun',
                    'b.nama as bulan',
                    'w.nama as wilayah'
                )
                ->whereIn('d.id_wilayah', $wilayahIds)
                ->where(function ($q) use ($selections) {
                    foreach ($selections as $selection) {
                        $q->orWhere(function ($sq) use ($selection) {
                            $sq->where('d.id_variabel', $selection['variabel_id'])
                               ->whereIn('d.tahun', $selection['tahun_ids'])
                               ->whereIn('d.id_klasifikasi', $selection['klasifikasi_ids'])
                               ->whereIn('d.id_bulan', $selection['bulan_ids']);
                        });
                    }
                });

            
            // Log the query and bindings for debugging
            Log::info('BenihPupuk Filter SQL: ' . $query->toSql());
            Log::info('BenihPupuk Filter Bindings: ', $query->getBindings());

            $data = $query->get();

            Log::info('BenihPupuk Filter Results Count: ' . $data->count());

            // Always process data to ensure consistent response structure
            // This prevents UI flickering when results are empty

            $columnOrder = $this->getColumnOrder($tataLetak);
            $result = $this->processDataForLayout($data, $tataLetak, $columnOrder);

            return response()->json([
                'data' => $result,
                'columnOrder' => $columnOrder,
                'config' => ['tata_letak' => $tataLetak]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Filter validation error: ' . $e->getMessage(), ['errors' => $e->errors()]);
            return response()->json(['message' => 'Data input tidak valid.', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error in filter method: ' . $e->getMessage() . '\n' . $e->getTraceAsString());
            return response()->json(['message' => 'Terjadi kesalahan pada server saat memproses data.'], 500);
        }
    }

    public function exportExcel(Request $request)
    {
        try {
            $data = $request->validate([
                'headers' => 'required|json',
                'rows' => 'required|json',
                'title' => 'required|string',
            ]);

            $headers = json_decode($data['headers'], true);
            $rows = json_decode($data['rows'], true);
            $title = $data['title'];

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Set Title
            $sheet->mergeCells('A1:' . Coordinate::stringFromColumnIndex(count($headers[count($headers) - 1]) + 1) . '1');
            $sheet->setCellValue('A1', $title);
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Set Headers
            $headerRowIndex = 3;
            foreach ($headers as $headerGroup) {
                $colIndex = 1;
                foreach ($headerGroup as $header) {
                    $colLetter = Coordinate::stringFromColumnIndex($colIndex);
                    $endColLetter = Coordinate::stringFromColumnIndex($colIndex + ($header['span'] ?? 1) - 1);
                    $rowspan = $header['rowspan'] ?? 1;

                    if (($header['span'] ?? 1) > 1 || $rowspan > 1) {
                        $sheet->mergeCells($colLetter . $headerRowIndex . ':' . $endColLetter . ($headerRowIndex + $rowspan - 1));
                    }
                    
                    $sheet->setCellValue($colLetter . $headerRowIndex, $header['name']);
                    $style = $sheet->getStyle($colLetter . $headerRowIndex . ':' . $endColLetter . ($headerRowIndex + $rowspan - 1));
                    $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
                    $style->getFont()->setBold(true);
                    $style->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                    $colIndex += ($header['span'] ?? 1);
                }
                $headerRowIndex++;
            }

            // Set Rows
            $dataRowIndex = $headerRowIndex;
            foreach ($rows as $row) {
                $sheet->setCellValue('A' . $dataRowIndex, $row['wilayah']);
                $sheet->getStyle('A' . $dataRowIndex)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                $colIndex = 2;
                foreach ($row['values'] as $value) {
                    $colLetter = Coordinate::stringFromColumnIndex($colIndex);
                    $sheet->setCellValue($colLetter . $dataRowIndex, $value);
                    $sheet->getStyle($colLetter . $dataRowIndex)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                    $sheet->getStyle($colLetter . $dataRowIndex)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                    $colIndex++;
                }
                $dataRowIndex++;
            }

            // Auto-size columns
            foreach (range('A', $sheet->getHighestDataColumn()) as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            $writer = new Xlsx($spreadsheet);
            $fileName = 'Laporan Benih dan Pupuk - ' . date('Y-m-d His') . '.xlsx';

            return response()->streamDownload(function () use ($writer) {
                $writer->save('php://output');
            }, $fileName);

        } catch (\Exception $e) {
            Log::error('Export error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Gagal mengekspor data: ' . $e->getMessage()], 500);
        }
    }

    private function getColumnOrder($tataLetak)
    {
        switch ($tataLetak) {
            case 'master-header-variabel':
                return ['wilayah', 'variabel', 'klasifikasi', 'tahun', 'bulan'];
            case 'master-header-klasifikasi':
                return ['wilayah', 'klasifikasi', 'variabel', 'tahun', 'bulan'];
            case 'master-header-waktu':
                return ['wilayah', 'tahun', 'bulan', 'variabel', 'klasifikasi'];
            case 'data-series':
            default:
                return ['variabel', 'klasifikasi', 'tahun', 'bulan'];
        }
    }

    private function processDataForLayout($data, $layout, $columnOrder)
    {
        $pivotData = [];
        $rowKeys = $data->pluck('wilayah')->unique()->sort()->values();

        $colKeys = $data->map(function ($item) {
            return $item->variabel . '|' . $item->klasifikasi . '|' . $item->tahun . '|' . $item->bulan;
        })->unique()->sort()->values();

        // Initialize pivot table with nulls
        foreach ($rowKeys as $rowKey) {
            foreach ($colKeys as $colKey) {
                $pivotData[$rowKey][$colKey] = '-';
            }
        }

        // Populate with actual values
        foreach ($data as $item) {
            $rowKey = $item->wilayah;
            $colKey = $item->variabel . '|' . $item->klasifikasi . '|' . $item->tahun . '|' . $item->bulan;
            $pivotData[$rowKey][$colKey] = $item->nilai;
        }

        // Format for frontend
        $result = [];
        foreach ($pivotData as $wilayah => $values) {
            $result[] = [
                'wilayah' => $wilayah,
                'values' => array_values($values)
            ];
        }

        return $result;
    }






}
