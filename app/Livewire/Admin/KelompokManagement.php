<?php

namespace App\Livewire\Admin;

use App\Models\Kelompok;
use App\Exports\KelompokExport;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class KelompokManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public array $perPageOptions = [5, 10, 25, 100];
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;
    
    public $kode = '';
    public $nama = '';
    public $editingKelompok = null;
    public $deletingKelompok = null;
    public $exportFormat = 'xlsx';

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];

    protected $casts = [
        'perPage' => 'integer',
    ];

    protected $rules = [
        'kode' => 'required|unique:kelompok,kode',
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

    public function openEditModal($kelompokId)
    {
        $this->editingKelompok = Kelompok::findOrFail($kelompokId);
        $this->kode = $this->editingKelompok->kode;
        $this->nama = $this->editingKelompok->nama;
        $this->showEditModal = true;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->resetForm();
    }

    public function openDeleteModal($kelompokId)
    {
        $this->deletingKelompok = Kelompok::findOrFail($kelompokId);
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deletingKelompok = null;
    }

    public function createKelompok()
    {
        $this->validate();

        Kelompok::create([
            'kode' => $this->kode,
            'nama' => $this->nama,
        ]);

        session()->flash('message', 'Kelompok berhasil dibuat.');
        $this->closeCreateModal();
    }

    public function updateKelompok()
    {
        $rules = [
            'kode' => 'required|unique:kelompok,kode,' . $this->editingKelompok->id,
            'nama' => 'required|min:3',
        ];

        $this->validate($rules);

        $this->editingKelompok->update([
            'kode' => $this->kode,
            'nama' => $this->nama,
        ]);

        session()->flash('message', 'Kelompok berhasil diupdate.');
        $this->closeEditModal();
    }

    public function deleteKelompok()
    {
        if ($this->deletingKelompok) {
            $this->deletingKelompok->delete();
            session()->flash('message', 'Kelompok berhasil dihapus.');
            $this->closeDeleteModal();
        }
    }

    private function resetForm()
    {
        $this->kode = '';
        $this->nama = '';
        $this->editingKelompok = null;
        $this->resetErrorBag();
    }

    public function render()
    {
        $perPage = (int) $this->perPage;
        if (! in_array($perPage, $this->perPageOptions, true)) {
            $perPage = 10;
        }

        $kelompoks = Kelompok::when($this->search, function ($query) {
                $query->where(function($q) {
                    $q->where('kode', 'like', '%' . $this->search . '%')
                      ->orWhere('nama', 'like', '%' . $this->search . '%');
                });
        })->paginate($perPage);

        return view('livewire.admin.kelompok-management', [
            'kelompoks' => $kelompoks,
        ]);
    }

    public function export()
    {
        $format = strtolower($this->exportFormat ?? 'xlsx');
        if (! in_array($format, ['xlsx','csv'], true)) {
            $format = 'xlsx';
        }

        $filename = 'kelompok-' . now()->format('Ymd-His') . '.' . $format;
        
        return Excel::download(new KelompokExport($this->search ?: null), $filename, $format === 'csv' ? \Maatwebsite\Excel\Excel::CSV : \Maatwebsite\Excel\Excel::XLSX);
    }

    public function print()
    {
        // Trigger browser print via JS listener
        $this->dispatch('print-kelompok');
    }
}
