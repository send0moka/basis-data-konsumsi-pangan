<?php

namespace App\Livewire\Admin;

use App\Models\Komoditi;
use App\Models\Kelompok;
use App\Exports\KomoditiExport;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class KomoditiManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public array $perPageOptions = [5, 10, 25, 100];
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;
    
    public $kode_kelompok = '';
    public $kode_komoditi = '';
    public $nama = '';
    public $editingKomoditi = null;
    public $deletingKomoditi = null;
    public $exportFormat = 'xlsx';

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];

    protected $casts = [
        'perPage' => 'integer',
    ];

    protected $rules = [
        'kode_kelompok' => 'required|exists:kelompok,kode',
        'kode_komoditi' => 'required|unique:komoditi,kode_komoditi',
        'nama' => 'required|min:3',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage($value)
    {
        if (! in_array((int)$value, $this->perPageOptions, true)) {
            $this->perPage = 10; // fallback
        }
        $this->resetPage();
    }

    public function updatingPerPage($value)
    {
        // Reset pagination before value changes to avoid out-of-range page
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->showCreateModal = true;
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
        $this->resetForm();
    }

    public function openEditModal($komoditiId)
    {
        $this->editingKomoditi = Komoditi::findOrFail($komoditiId);
        $this->kode_kelompok = $this->editingKomoditi->kode_kelompok;
        $this->kode_komoditi = $this->editingKomoditi->kode_komoditi;
        $this->nama = $this->editingKomoditi->nama;
        $this->showEditModal = true;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->resetForm();
    }

    public function openDeleteModal($komoditiId)
    {
        $this->deletingKomoditi = Komoditi::findOrFail($komoditiId);
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deletingKomoditi = null;
    }

    public function createKomoditi()
    {
        $this->validate();

        Komoditi::create([
            'kode_kelompok' => $this->kode_kelompok,
            'kode_komoditi' => $this->kode_komoditi,
            'nama' => $this->nama,
        ]);

        session()->flash('message', 'Komoditi berhasil dibuat.');
        $this->closeCreateModal();
    }

    public function updateKomoditi()
    {
        $rules = [
            'kode_kelompok' => 'required|exists:kelompok,kode',
            'kode_komoditi' => 'required|unique:komoditi,kode_komoditi,' . $this->editingKomoditi->id,
            'nama' => 'required|min:3',
        ];

        $this->validate($rules);

        $this->editingKomoditi->update([
            'kode_kelompok' => $this->kode_kelompok,
            'kode_komoditi' => $this->kode_komoditi,
            'nama' => $this->nama,
        ]);

        session()->flash('message', 'Komoditi berhasil diupdate.');
        $this->closeEditModal();
    }

    public function deleteKomoditi()
    {
        if ($this->deletingKomoditi) {
            $this->deletingKomoditi->delete();
            session()->flash('message', 'Komoditi berhasil dihapus.');
            $this->closeDeleteModal();
        }
    }

    private function resetForm()
    {
        $this->kode_kelompok = '';
        $this->kode_komoditi = '';
        $this->nama = '';
        $this->editingKomoditi = null;
        $this->resetErrorBag();
    }

    public function render()
    {
        $perPage = (int) $this->perPage;
        if (! in_array($perPage, $this->perPageOptions, true)) {
            $perPage = 10;
        }

        $komoditis = Komoditi::when($this->search, function ($query) {
                $query->where(function($q) {
                    $q->where('kode_kelompok', 'like', '%' . $this->search . '%')
                      ->orWhere('kode_komoditi', 'like', '%' . $this->search . '%')
                      ->orWhere('nama', 'like', '%' . $this->search . '%');
                });
        })->paginate($perPage);

        $kelompoks = Kelompok::all();

        return view('livewire.admin.komoditi-management', [
            'komoditis' => $komoditis,
            'kelompoks' => $kelompoks,
        ]);
    }

    public function export()
    {
        $format = strtolower($this->exportFormat ?? 'xlsx');
        if (! in_array($format, ['xlsx','csv'], true)) {
            $format = 'xlsx';
        }

        $filename = 'komoditi-' . now()->format('Ymd-His') . '.' . $format;
        
        return Excel::download(new KomoditiExport($this->search ?: null), $filename, $format === 'csv' ? \Maatwebsite\Excel\Excel::CSV : \Maatwebsite\Excel\Excel::XLSX);
    }

    public function print()
    {
        // Trigger browser print via JS listener
        $this->dispatch('print-komoditi');
    }
}
