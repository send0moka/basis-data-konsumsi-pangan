<?php

namespace App\Livewire\Admin;

use App\Models\LahanTopik;
use App\Models\LahanVariabel;
use App\Models\LahanKlasifikasi;
use App\Models\LahanData;
use Livewire\Component;
use Livewire\WithPagination;

class LahanManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public array $perPageOptions = [5, 10, 25, 100];
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;
    
    public $nilai = '';
    public $wilayah = '';
    public $tahun = '';
    public $status = '';
    public $id_lahan_topik = '';
    public $id_lahan_variabel = '';
    public $id_lahan_klasifikasi = '';
    public $editingLahan = null;
    public $deletingLahan = null;
    public $exportFormat = 'xlsx';

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];

    protected $casts = [
        'perPage' => 'integer',
    ];

    protected $rules = [
        'nilai' => 'required|numeric|min:0',
        'wilayah' => 'required|min:3',
        'tahun' => 'required|integer|min:2000|max:2030',
        'status' => 'required|in:Aktif,Tidak Aktif,Dalam Proses,Selesai,Tertunda',
        'id_lahan_topik' => 'required|exists:lahan_topik,id',
        'id_lahan_variabel' => 'required|exists:lahan_variabel,id',
        'id_lahan_klasifikasi' => 'required|exists:lahan_klasifikasi,id',
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

    public function openEditModal($lahanId)
    {
        $this->editingLahan = LahanData::findOrFail($lahanId);
        $this->nilai = $this->editingLahan->nilai;
        $this->wilayah = $this->editingLahan->wilayah;
        $this->tahun = $this->editingLahan->tahun;
        $this->status = $this->editingLahan->status;
        $this->id_lahan_topik = $this->editingLahan->id_lahan_topik;
        $this->id_lahan_variabel = $this->editingLahan->id_lahan_variabel;
        $this->id_lahan_klasifikasi = $this->editingLahan->id_lahan_klasifikasi;
        $this->showEditModal = true;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->resetForm();
    }

    public function openDeleteModal($lahanId)
    {
        $this->deletingLahan = LahanData::findOrFail($lahanId);
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deletingLahan = null;
    }

    public function createLahan()
    {
        $this->validate();

        LahanData::create([
            'nilai' => $this->nilai,
            'wilayah' => $this->wilayah,
            'tahun' => $this->tahun,
            'status' => $this->status,
            'id_lahan_topik' => $this->id_lahan_topik,
            'id_lahan_variabel' => $this->id_lahan_variabel,
            'id_lahan_klasifikasi' => $this->id_lahan_klasifikasi,
        ]);

        session()->flash('message', 'Data lahan berhasil dibuat.');
        $this->closeCreateModal();
    }

    public function updateLahan()
    {
        $this->validate();

        $this->editingLahan->update([
            'nilai' => $this->nilai,
            'wilayah' => $this->wilayah,
            'tahun' => $this->tahun,
            'status' => $this->status,
            'id_lahan_topik' => $this->id_lahan_topik,
            'id_lahan_variabel' => $this->id_lahan_variabel,
            'id_lahan_klasifikasi' => $this->id_lahan_klasifikasi,
        ]);

        session()->flash('message', 'Data lahan berhasil diupdate.');
        $this->closeEditModal();
    }

    public function deleteLahan()
    {
        if ($this->deletingLahan) {
            $this->deletingLahan->delete();
            session()->flash('message', 'Data lahan berhasil dihapus.');
            $this->closeDeleteModal();
        }
    }

    private function resetForm()
    {
        $this->nilai = '';
        $this->wilayah = '';
        $this->tahun = '';
        $this->status = '';
        $this->id_lahan_topik = '';
        $this->id_lahan_variabel = '';
        $this->id_lahan_klasifikasi = '';
        $this->editingLahan = null;
        $this->resetErrorBag();
    }

    public function render()
    {
        $perPage = (int) $this->perPage;
        if (! in_array($perPage, $this->perPageOptions, true)) {
            $perPage = 10;
        }

        $lahans = LahanData::with(['lahanTopik', 'lahanVariabel', 'lahanKlasifikasi'])
            ->when($this->search, function ($query) {
                $query->where(function($q) {
                    $q->where('wilayah', 'like', '%' . $this->search . '%')
                      ->orWhere('tahun', 'like', '%' . $this->search . '%')
                      ->orWhere('status', 'like', '%' . $this->search . '%')
                      ->orWhereHas('lahanTopik', function($subQ) {
                          $subQ->where('nama', 'like', '%' . $this->search . '%');
                      })
                      ->orWhereHas('lahanVariabel', function($subQ) {
                          $subQ->where('nama', 'like', '%' . $this->search . '%');
                      })
                      ->orWhereHas('lahanKlasifikasi', function($subQ) {
                          $subQ->where('nama', 'like', '%' . $this->search . '%');
                      });
                });
            })->paginate($perPage);

        $topiks = LahanTopik::all();
        $variabels = LahanVariabel::all();
        $klasifikasis = LahanKlasifikasi::all();

        return view('livewire.admin.lahan-management', [
            'lahans' => $lahans,
            'topiks' => $topiks,
            'variabels' => $variabels,
            'klasifikasis' => $klasifikasis,
        ]);
    }

    public function export()
    {
        // Export functionality can be added later
        session()->flash('message', 'Export functionality will be implemented soon.');
    }

    public function print()
    {
        // Trigger browser print via JS listener
        $this->dispatch('print-lahan');
    }
}
