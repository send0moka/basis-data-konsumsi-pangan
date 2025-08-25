<?php

namespace App\Livewire\Admin\DaftarAlamat;

use App\Models\DaftarAlamat;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class DataDaftarAlamat extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';
    
    #[Url]
    public $statusFilter = '';
    
    #[Url]
    public $kategoriFilter = '';
    
    #[Url]
    public $wilayahFilter = '';
    
    #[Url]
    public $sortBy = 'id';
    
    #[Url]
    public $sortDirection = 'asc';

    public $perPage = 10;
    public $showModal = false;
    public $modalMode = 'create';
    public $selectedId = null;

    // Form properties
    public $no = '';
    public $wilayah = '';
    public $nama_dinas = '';
    public $alamat = '';
    public $telp = '';
    public $faks = '';
    public $email = '';
    public $website = '';
    public $posisi = '';
    public $urut = '';
    public $status = 'Aktif';
    public $kategori = '';
    public $keterangan = '';
    public $latitude = '';
    public $longitude = '';

    protected $rules = [
        'wilayah' => 'required|string|max:255',
        'nama_dinas' => 'required|string|max:255',
        'alamat' => 'required|string',
        'telp' => 'nullable|string|max:255',
        'faks' => 'nullable|string|max:255',
        'email' => 'nullable|email|max:255',
        'website' => 'nullable|url|max:255',
        'posisi' => 'nullable|string|max:255',
        'urut' => 'nullable|integer',
        'status' => 'required|in:Aktif,Tidak Aktif,Draft,Arsip,Pending',
        'kategori' => 'nullable|string|max:255',
        'keterangan' => 'nullable|string',
        'latitude' => 'nullable|numeric|between:-90,90',
        'longitude' => 'nullable|numeric|between:-180,180',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingKategoriFilter()
    {
        $this->resetPage();
    }

    public function updatingWilayahFilter()
    {
        $this->resetPage();
    }

    public function sortByField($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function create()
    {
        $this->resetForm();
        $this->modalMode = 'create';
        $this->showModal = true;
    }

    public function edit($id)
    {
        $alamat = DaftarAlamat::findOrFail($id);
        $this->selectedId = $id;
        $this->fill($alamat->toArray());
        $this->modalMode = 'edit';
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'no' => $this->no,
            'wilayah' => $this->wilayah,
            'nama_dinas' => $this->nama_dinas,
            'alamat' => $this->alamat,
            'telp' => $this->telp,
            'faks' => $this->faks,
            'email' => $this->email,
            'website' => $this->website,
            'posisi' => $this->posisi,
            'urut' => $this->urut,
            'status' => $this->status,
            'kategori' => $this->kategori,
            'keterangan' => $this->keterangan,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];

        if ($this->modalMode === 'create') {
            DaftarAlamat::create($data);
            session()->flash('message', 'Data alamat berhasil ditambahkan.');
        } else {
            DaftarAlamat::findOrFail($this->selectedId)->update($data);
            session()->flash('message', 'Data alamat berhasil diperbarui.');
        }

        $this->closeModal();
    }

    public function delete($id)
    {
        DaftarAlamat::findOrFail($id)->delete();
        session()->flash('message', 'Data alamat berhasil dihapus.');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
        $this->selectedId = null;
    }

    public function resetForm()
    {
        $this->reset([
            'no', 'wilayah', 'nama_dinas', 'alamat', 'telp', 'faks', 
            'email', 'website', 'posisi', 'urut', 'status', 'kategori', 
            'keterangan', 'latitude', 'longitude'
        ]);
        $this->status = 'Aktif';
    }

    public function resetFilters()
    {
        $this->reset(['search', 'statusFilter', 'kategoriFilter', 'wilayahFilter']);
        $this->resetPage();
    }

    public function render()
    {
        $query = DaftarAlamat::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('wilayah', 'like', '%' . $this->search . '%')
                  ->orWhere('nama_dinas', 'like', '%' . $this->search . '%')
                  ->orWhere('alamat', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->kategoriFilter) {
            $query->where('kategori', $this->kategoriFilter);
        }

        if ($this->wilayahFilter) {
            $query->where('wilayah', 'like', '%' . $this->wilayahFilter . '%');
        }

        $alamats = $query->orderBy($this->sortBy, $this->sortDirection)
                        ->paginate($this->perPage);

        $statusOptions = DaftarAlamat::getStatusOptions();
        $kategoriOptions = DaftarAlamat::getKategoriOptions();
        
        $wilayahOptions = DaftarAlamat::distinct('wilayah')
                                   ->orderBy('wilayah')
                                   ->pluck('wilayah')
                                   ->toArray();

        return view('livewire.admin.daftar-alamat.data-daftar-alamat', compact(
            'alamats', 'statusOptions', 'kategoriOptions', 'wilayahOptions'
        ));
    }
}
