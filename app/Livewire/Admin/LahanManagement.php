<?php

namespace App\Livewire\Admin;

use App\Models\LahanTopik;
use App\Models\LahanVariabel;
use App\Models\LahanKlasifikasi;
use App\Models\LahanData;
use App\Exports\LahanExport;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class LahanManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public array $perPageOptions = [5, 10, 25, 100];
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;
    public $showFilters = false;

    // Form fields
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
    
    // Sorting
    public $sortField = 'id';
    public $sortDirection = 'asc';
    
    // Filters
    public $filterTahun = '';
    public $filterTopik = '';
    public $filterVariabel = '';
    public $filterKlasifikasi = '';
    public $filterStatus = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => 'id'],
        'sortDirection' => ['except' => 'asc'],
        'filterTahun' => ['except' => ''],
        'filterTopik' => ['except' => ''],
        'filterVariabel' => ['except' => ''],
        'filterKlasifikasi' => ['except' => ''],
        'filterStatus' => ['except' => ''],
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
    
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }
    
    public function toggleFilters()
    {
        $this->showFilters = !$this->showFilters;
    }
    
    public function clearFilters()
    {
        $this->reset([
            'filterTahun', 
            'filterTopik', 
            'filterVariabel', 
            'filterKlasifikasi', 
            'filterStatus'
        ]);
    }
    
    public function resetSort()
    {
        $this->reset(['sortField', 'sortDirection']);
    }

    public function export()
    {
        $fileName = 'data-lahan-' . now()->format('Y-m-d-H-i-s') . '.' . $this->exportFormat;
        return Excel::download(new LahanExport($this->search), $fileName);
    }


    public function render()
    {
        $query = LahanData::with(['lahanTopik', 'lahanVariabel', 'lahanKlasifikasi'])
            ->when($this->search, function ($query) {
                $search = '%' . $this->search . '%';
                $query->where('wilayah', 'like', $search)
                    ->orWhere('tahun', 'like', $search)
                    ->orWhere('nilai', 'like', $search)
                    ->orWhereHas('lahanTopik', function($q) use ($search) {
                        $q->where('nama', 'like', $search);
                    })
                    ->orWhereHas('lahanVariabel', function($q) use ($search) {
                        $q->where('nama', 'like', $search);
                    })
                    ->orWhereHas('lahanKlasifikasi', function($q) use ($search) {
                        $q->where('nama', 'like', $search);
                    });
            })
            ->when($this->filterTahun, function ($query) {
                $query->where('tahun', $this->filterTahun);
            })
            ->when($this->filterTopik, function ($query) {
                $query->where('id_lahan_topik', $this->filterTopik);
            })
            ->when($this->filterVariabel, function ($query) {
                $query->where('id_lahan_variabel', $this->filterVariabel);
            })
            ->when($this->filterKlasifikasi, function ($query) {
                $query->where('id_lahan_klasifikasi', $this->filterKlasifikasi);
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            });

        // Apply sorting
        if ($this->sortField) {
            $query->orderBy($this->sortField, $this->sortDirection);
        }

        $lahans = $query->paginate($this->perPage);

        $topiks = LahanTopik::all();
        $variabels = LahanVariabel::all();
        $klasifikasis = LahanKlasifikasi::all();

        return view('livewire.admin.lahan-management', [
            'lahans' => $lahans,
            'topiks' => LahanTopik::orderBy('nama')->get(),
            'variabels' => LahanVariabel::orderBy('nama')->get(),
            'klasifikasis' => LahanKlasifikasi::orderBy('nama')->get(),
            'tahunOptions' => LahanData::select('tahun')
                ->distinct()
                ->orderBy('tahun', 'desc')
                ->pluck('tahun'),
            'statusOptions' => ['Aktif', 'Tidak Aktif', 'Dalam Proses', 'Selesai', 'Tertunda']
        ]);
    }
}
