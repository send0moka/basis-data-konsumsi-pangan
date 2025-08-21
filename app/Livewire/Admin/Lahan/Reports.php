<?php

namespace App\Livewire\Admin\Lahan;

use Livewire\Component;
use App\Models\LahanData;
use App\Models\LahanTopik;
use App\Models\LahanVariabel;
use App\Models\LahanKlasifikasi;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Reports extends Component
{
    public $reportType = 'summary';
    public $selectedTopik = '';
    public $selectedVariabel = '';
    public $selectedKlasifikasi = '';
    public $selectedRegion = '';
    public $dateFrom = '';
    public $dateTo = '';
    public $reportFormat = 'table';
    public $groupBy = 'region';
    public $includeCharts = true;
    public $includeStatistics = true;

    public function mount()
    {
        $this->dateFrom = Carbon::now()->subYear()->format('Y-m-d');
        $this->dateTo = Carbon::now()->format('Y-m-d');
    }

    public function render()
    {
        $topiks = LahanTopik::orderBy('nama')->get();
        $variabels = LahanVariabel::orderBy('nama')->get();
        $klasifikasis = LahanKlasifikasi::orderBy('nama')->get();
        $regions = $this->getRegions();

        $reportData = $this->generateReportData();
        $reportSummary = $this->getReportSummary();

        return view('livewire.admin.lahan.reports', [
            'topiks' => $topiks,
            'variabels' => $variabels,
            'klasifikasis' => $klasifikasis,
            'regions' => $regions,
            'reportData' => $reportData,
            'reportSummary' => $reportSummary,
        ]);
    }

    public function generateReport()
    {
        // This method would trigger report generation
        session()->flash('message', 'Laporan berhasil dibuat!');
    }

    public function exportReport($format)
    {
        // This method would handle export functionality
        session()->flash('message', "Laporan berhasil diekspor dalam format {$format}!");
    }

    private function getRegions()
    {
        return LahanData::select('wilayah')
            ->distinct()
            ->whereNotNull('wilayah')
            ->orderBy('wilayah')
            ->pluck('wilayah')
            ->toArray();
    }

    private function generateReportData()
    {
        $query = LahanData::with(['topik', 'variabel', 'klasifikasi']);

        // Apply filters
        if ($this->selectedTopik) {
            $query->where('lahan_topik_id', $this->selectedTopik);
        }
        if ($this->selectedVariabel) {
            $query->where('lahan_variabel_id', $this->selectedVariabel);
        }
        if ($this->selectedKlasifikasi) {
            $query->where('lahan_klasifikasi_id', $this->selectedKlasifikasi);
        }
        if ($this->selectedRegion) {
            $query->where('wilayah', $this->selectedRegion);
        }
        if ($this->dateFrom) {
            $yearFrom = Carbon::parse($this->dateFrom)->year;
            $query->where('tahun', '>=', $yearFrom);
        }
        if ($this->dateTo) {
            $yearTo = Carbon::parse($this->dateTo)->year;
            $query->where('tahun', '<=', $yearTo);
        }

        // Generate different report types
        switch ($this->reportType) {
            case 'summary':
                return $this->generateSummaryReport($query);
            case 'detailed':
                return $this->generateDetailedReport($query);
            case 'comparison':
                return $this->generateComparisonReport($query);
            case 'trend':
                return $this->generateTrendReport($query);
            default:
                return collect();
        }
    }

    private function generateSummaryReport($query)
    {
        switch ($this->groupBy) {
            case 'region':
                return $query->select('wilayah as group_name')
                    ->selectRaw('COUNT(*) as total_records')
                    ->selectRaw('AVG(nilai) as avg_value')
                    ->selectRaw('SUM(nilai) as total_value')
                    ->selectRaw('MAX(nilai) as max_value')
                    ->selectRaw('MIN(nilai) as min_value')
                    ->groupBy('wilayah')
                    ->orderBy('wilayah')
                    ->get();

            case 'topik':
                return $query->join('lahan_topiks', 'lahan_data.lahan_topik_id', '=', 'lahan_topiks.id')
                    ->select('lahan_topiks.nama as group_name')
                    ->selectRaw('COUNT(*) as total_records')
                    ->selectRaw('AVG(lahan_data.nilai) as avg_value')
                    ->selectRaw('SUM(lahan_data.nilai) as total_value')
                    ->selectRaw('MAX(lahan_data.nilai) as max_value')
                    ->selectRaw('MIN(lahan_data.nilai) as min_value')
                    ->groupBy('lahan_topiks.nama')
                    ->orderBy('lahan_topiks.nama')
                    ->get();

            case 'variabel':
                return $query->join('lahan_variabels', 'lahan_data.lahan_variabel_id', '=', 'lahan_variabels.id')
                    ->select('lahan_variabels.nama as group_name')
                    ->selectRaw('COUNT(*) as total_records')
                    ->selectRaw('AVG(lahan_data.nilai) as avg_value')
                    ->selectRaw('SUM(lahan_data.nilai) as total_value')
                    ->selectRaw('MAX(lahan_data.nilai) as max_value')
                    ->selectRaw('MIN(lahan_data.nilai) as min_value')
                    ->groupBy('lahan_variabels.nama')
                    ->orderBy('lahan_variabels.nama')
                    ->get();

            case 'year':
                return $query->selectRaw('tahun as group_name')
                    ->selectRaw('COUNT(*) as total_records')
                    ->selectRaw('AVG(nilai) as avg_value')
                    ->selectRaw('SUM(nilai) as total_value')
                    ->selectRaw('MAX(nilai) as max_value')
                    ->selectRaw('MIN(nilai) as min_value')
                    ->groupBy('tahun')
                    ->orderBy('group_name')
                    ->get();

            default:
                return collect();
        }
    }

    private function generateDetailedReport($query)
    {
        return $query->select([
                'lahan_data.*',
                'lahan_topik.nama as topik_nama',
                'lahan_variabel.nama as variabel_nama',
                'lahan_klasifikasi.nama as klasifikasi_nama'
            ])
            ->join('lahan_topik', 'lahan_data.id_lahan_topik', '=', 'lahan_topik.id')
            ->join('lahan_variabel', 'lahan_data.id_lahan_variabel', '=', 'lahan_variabel.id')
            ->join('lahan_klasifikasi', 'lahan_data.id_lahan_klasifikasi', '=', 'lahan_klasifikasi.id')
            ->orderBy('lahan_data.tahun', 'desc')
            ->limit(100)
            ->get();
    }

    private function generateComparisonReport($query)
    {
        // Compare different regions or time periods
        $currentYear = Carbon::now()->year;
        $previousYear = $currentYear - 1;

        $currentYearData = (clone $query)
            ->where('tahun', $currentYear)
            ->select('wilayah')
            ->selectRaw('AVG(nilai) as avg_value')
            ->selectRaw('COUNT(*) as total_records')
            ->groupBy('wilayah')
            ->get()
            ->keyBy('wilayah');

        $previousYearData = (clone $query)
            ->where('tahun', $previousYear)
            ->select('wilayah')
            ->selectRaw('AVG(nilai) as avg_value')
            ->selectRaw('COUNT(*) as total_records')
            ->groupBy('wilayah')
            ->get()
            ->keyBy('wilayah');

        $comparison = collect();
        foreach ($currentYearData as $region => $current) {
            $previous = $previousYearData->get($region);
            $change = $previous ? (($current->avg_value - $previous->avg_value) / $previous->avg_value) * 100 : 0;

            $comparison->push([
                'region' => $region,
                'current_year' => $currentYear,
                'current_value' => $current->avg_value,
                'current_records' => $current->total_records,
                'previous_year' => $previousYear,
                'previous_value' => $previous ? $previous->avg_value : 0,
                'previous_records' => $previous ? $previous->total_records : 0,
                'change_percentage' => $change,
                'change_direction' => $change > 0 ? 'increase' : ($change < 0 ? 'decrease' : 'stable')
            ]);
        }

        return $comparison->sortByDesc('change_percentage');
    }

    private function generateTrendReport($query)
    {
        // Since we only have yearly data, simulate monthly trends
        return $query->selectRaw('tahun as year')
            ->selectRaw('AVG(nilai) as avg_value')
            ->selectRaw('COUNT(*) as total_records')
            ->groupBy('tahun')
            ->orderBy('year')
            ->get()
            ->map(function($item) {
                // Simulate monthly data for each year
                return (object) [
                    'year' => $item->year,
                    'month' => 1, // Use January as representative
                    'avg_value' => $item->avg_value,
                    'total_records' => $item->total_records
                ];
            })
            ->map(function ($item) {
                $item->period = $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT);
                $item->month_name = Carbon::create($item->year, $item->month, 1)->format('F Y');
                return $item;
            });
    }

    private function getReportSummary()
    {
        $query = LahanData::query();

        // Apply same filters as main report
        if ($this->selectedTopik) {
            $query->where('lahan_topik_id', $this->selectedTopik);
        }
        if ($this->selectedVariabel) {
            $query->where('lahan_variabel_id', $this->selectedVariabel);
        }
        if ($this->selectedKlasifikasi) {
            $query->where('lahan_klasifikasi_id', $this->selectedKlasifikasi);
        }
        if ($this->selectedRegion) {
            $query->where('wilayah', $this->selectedRegion);
        }
        if ($this->dateFrom) {
            $yearFrom = Carbon::parse($this->dateFrom)->year;
            $query->where('tahun', '>=', $yearFrom);
        }
        if ($this->dateTo) {
            $yearTo = Carbon::parse($this->dateTo)->year;
            $query->where('tahun', '<=', $yearTo);
        }

        return [
            'total_records' => $query->count(),
            'total_value' => $query->sum('nilai'),
            'average_value' => $query->avg('nilai'),
            'max_value' => $query->max('nilai'),
            'min_value' => $query->min('nilai'),
            'unique_regions' => $query->distinct('wilayah')->count(),
            'date_range' => [
                'from' => $query->min('tahun') . '-01-01',
                'to' => $query->max('tahun') . '-12-31'
            ]
        ];
    }
}
