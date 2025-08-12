<?php

namespace App\Livewire\Admin;

use App\Models\TransaksiNbm;
use App\Models\Kelompok;
use App\Models\Komoditi;
use App\Exports\TransaksiNbmExport;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class TransaksiNbmManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public array $perPageOptions = [5, 10, 25, 100];
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;
    
    // Form fields
    public $kode_kelompok = '';
    public $kode_komoditi = '';
    public $tahun = '';
    public $status_angka = 'tetap';
    public $masukan = '';
    public $keluaran = '';
    public $impor = '';
    public $ekspor = '';
    public $perubahan_stok = '';
    public $pakan = '';
    public $bibit = '';
    public $makanan = '';
    public $bukan_makanan = '';
    public $tercecer = '';
    public $penggunaan_lain = '';
    public $bahan_makanan = '';
    public $kg_tahun = '';
    public $gram_hari = '';
    public $kalori_hari = '';
    public $protein_hari = '';
    public $lemak_hari = '';
    
    public $editingTransaksi = null;
    public $deletingTransaksi = null;
    public $exportFormat = 'xlsx';

    // Data untuk select options
    public $kelompokOptions = [];
    public $komoditiOptions = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];

    protected $casts = [
        'perPage' => 'integer',
    ];

    public function mount()
    {
        $this->loadSelectOptions();
    }

    public function loadSelectOptions()
    {
        $this->kelompokOptions = Kelompok::orderBy('kode')->get(['kode', 'nama'])->toArray();
        $this->loadKomoditiOptions();
    }

    public function loadKomoditiOptions()
    {
        if (empty($this->kode_kelompok)) {
            $this->komoditiOptions = [];
        } else {
            // Filter komoditi berdasarkan kode kelompok
            $this->komoditiOptions = Komoditi::where('kode_kelompok', $this->kode_kelompok)
                ->orderBy('kode_komoditi')
                ->get(['kode_komoditi as kode', 'nama'])
                ->toArray();
        }
    }

    public function updatedKodeKelompok()
    {
        // Reset komoditi saat kelompok berubah
        $this->kode_komoditi = '';
        $this->loadKomoditiOptions();
    }

    protected $rules = [
        'kode_kelompok' => 'required',
        'kode_komoditi' => 'required',
        'tahun' => 'required|integer|min:1900|max:2100',
        'status_angka' => 'required|in:tetap,sementara,sangat sementara',
        'masukan' => 'nullable|numeric|min:0',
        'keluaran' => 'nullable|numeric|min:0',
        'impor' => 'nullable|numeric|min:0',
        'ekspor' => 'nullable|numeric|min:0',
        'perubahan_stok' => 'nullable|numeric',
        'pakan' => 'nullable|numeric|min:0',
        'bibit' => 'nullable|numeric|min:0',
        'makanan' => 'nullable|numeric|min:0',
        'bukan_makanan' => 'nullable|numeric|min:0',
        'tercecer' => 'nullable|numeric|min:0',
        'penggunaan_lain' => 'nullable|numeric|min:0',
        'bahan_makanan' => 'nullable|numeric|min:0',
        'kg_tahun' => 'nullable|numeric|min:0',
        'gram_hari' => 'nullable|numeric|min:0',
        'kalori_hari' => 'nullable|numeric|min:0',
        'protein_hari' => 'nullable|numeric|min:0',
        'lemak_hari' => 'nullable|numeric|min:0',
    ];

    private function validateKomoditiKelompok()
    {
        if (empty($this->kode_kelompok)) {
            $this->addError('kode_kelompok', 'Kelompok harus dipilih terlebih dahulu.');
            return;
        }

        if (empty($this->kode_komoditi)) {
            $this->addError('kode_komoditi', 'Komoditi harus dipilih.');
            return;
        }

        // Validasi bahwa komoditi yang dipilih sesuai dengan kelompok
        $komoditi = Komoditi::where('kode_komoditi', $this->kode_komoditi)
            ->where('kode_kelompok', $this->kode_kelompok)
            ->first();
            
        if (!$komoditi) {
            $this->addError('kode_komoditi', 'Komoditi yang dipilih tidak sesuai dengan kelompok.');
            return;
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage($value)
    {
        if (! in_array((int)$value, $this->perPageOptions, true)) {
            $this->perPage = 10;
        }
        $this->resetPage();
    }

    public function updatingPerPage($value)
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->loadSelectOptions(); // Memuat data untuk select options
        $this->showCreateModal = true;
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
        $this->resetForm();
    }

    public function openEditModal($transaksiId)
    {
        $this->editingTransaksi = TransaksiNbm::findOrFail($transaksiId);
        $this->fillFormFromModel($this->editingTransaksi);
        $this->loadSelectOptions(); // Memuat data untuk select options
        $this->showEditModal = true;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->resetForm();
    }

    public function openDeleteModal($transaksiId)
    {
        $this->deletingTransaksi = TransaksiNbm::findOrFail($transaksiId);
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deletingTransaksi = null;
    }

    public function createTransaksi()
    {
        $this->validate();
        $this->validateKomoditiKelompok();

        TransaksiNbm::create($this->getFormData());

        session()->flash('message', 'Transaksi NBM berhasil dibuat.');
        $this->closeCreateModal();
    }

    public function updateTransaksi()
    {
        $this->validate();
        $this->validateKomoditiKelompok();

        $this->editingTransaksi->update($this->getFormData());

        session()->flash('message', 'Transaksi NBM berhasil diupdate.');
        $this->closeEditModal();
    }

    public function deleteTransaksi()
    {
        if ($this->deletingTransaksi) {
            $this->deletingTransaksi->delete();
            session()->flash('message', 'Transaksi NBM berhasil dihapus.');
            $this->closeDeleteModal();
        }
    }

    private function getFormData()
    {
        return [
            'kode_kelompok' => $this->kode_kelompok,
            'kode_komoditi' => $this->kode_komoditi,
            'tahun' => $this->tahun,
            'status_angka' => $this->status_angka,
            'masukan' => $this->masukan ?: null,
            'keluaran' => $this->keluaran ?: null,
            'impor' => $this->impor ?: null,
            'ekspor' => $this->ekspor ?: null,
            'perubahan_stok' => $this->perubahan_stok ?: null,
            'pakan' => $this->pakan ?: null,
            'bibit' => $this->bibit ?: null,
            'makanan' => $this->makanan ?: null,
            'bukan_makanan' => $this->bukan_makanan ?: null,
            'tercecer' => $this->tercecer ?: null,
            'penggunaan_lain' => $this->penggunaan_lain ?: null,
            'bahan_makanan' => $this->bahan_makanan ?: null,
            'kg_tahun' => $this->kg_tahun ?: null,
            'gram_hari' => $this->gram_hari ?: null,
            'kalori_hari' => $this->kalori_hari ?: null,
            'protein_hari' => $this->protein_hari ?: null,
            'lemak_hari' => $this->lemak_hari ?: null,
        ];
    }

    private function fillFormFromModel($transaksi)
    {
        $this->kode_kelompok = $transaksi->kode_kelompok;
        $this->kode_komoditi = $transaksi->kode_komoditi;
        $this->tahun = $transaksi->tahun;
        $this->status_angka = $transaksi->status_angka;
        $this->masukan = $transaksi->masukan;
        $this->keluaran = $transaksi->keluaran;
        $this->impor = $transaksi->impor;
        $this->ekspor = $transaksi->ekspor;
        $this->perubahan_stok = $transaksi->perubahan_stok;
        $this->pakan = $transaksi->pakan;
        $this->bibit = $transaksi->bibit;
        $this->makanan = $transaksi->makanan;
        $this->bukan_makanan = $transaksi->bukan_makanan;
        $this->tercecer = $transaksi->tercecer;
        $this->penggunaan_lain = $transaksi->penggunaan_lain;
        $this->bahan_makanan = $transaksi->bahan_makanan;
        $this->kg_tahun = $transaksi->kg_tahun;
        $this->gram_hari = $transaksi->gram_hari;
        $this->kalori_hari = $transaksi->kalori_hari;
        $this->protein_hari = $transaksi->protein_hari;
        $this->lemak_hari = $transaksi->lemak_hari;
        
        // Load komoditi options setelah kode_kelompok di-set
        $this->loadKomoditiOptions();
    }

    private function resetForm()
    {
        $this->kode_kelompok = '';
        $this->kode_komoditi = '';
        $this->tahun = '';
        $this->status_angka = 'tetap';
        $this->masukan = '';
        $this->keluaran = '';
        $this->impor = '';
        $this->ekspor = '';
        $this->perubahan_stok = '';
        $this->pakan = '';
        $this->bibit = '';
        $this->makanan = '';
        $this->bukan_makanan = '';
        $this->tercecer = '';
        $this->penggunaan_lain = '';
        $this->bahan_makanan = '';
        $this->kg_tahun = '';
        $this->gram_hari = '';
        $this->kalori_hari = '';
        $this->protein_hari = '';
        $this->lemak_hari = '';
        $this->editingTransaksi = null;
        $this->resetErrorBag();
    }

    public function render()
    {
        $perPage = (int) $this->perPage;
        if (! in_array($perPage, $this->perPageOptions, true)) {
            $perPage = 10;
        }

        $transaksiNbms = TransaksiNbm::when($this->search, function ($query) {
                $query->where(function($q) {
                    $q->where('kode_kelompok', 'like', '%' . $this->search . '%')
                      ->orWhere('kode_komoditi', 'like', '%' . $this->search . '%')
                      ->orWhere('tahun', 'like', '%' . $this->search . '%')
                      ->orWhere('status_angka', 'like', '%' . $this->search . '%');
                });
        })->orderBy('id', 'asc')->paginate($perPage);

        return view('livewire.admin.transaksi-nbm-management', [
            'transaksiNbms' => $transaksiNbms,
        ]);
    }

    public function export()
    {
        $format = strtolower($this->exportFormat ?? 'xlsx');
        if (! in_array($format, ['xlsx','csv'], true)) {
            $format = 'xlsx';
        }

        $filename = 'transaksi-nbm-' . now()->format('Ymd-His') . '.' . $format;
        
        return Excel::download(new TransaksiNbmExport(), $filename, $format === 'csv' ? \Maatwebsite\Excel\Excel::CSV : \Maatwebsite\Excel\Excel::XLSX);
    }

    public function print()
    {
        $this->dispatch('print-transaksi-nbm');
    }
}
