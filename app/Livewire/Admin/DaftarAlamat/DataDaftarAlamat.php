<?php

namespace App\Livewire\Admin\DaftarAlamat;

use App\Models\DaftarAlamat;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class DataDaftarAlamat extends Component
{
    use WithPagination, WithFileUploads;

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
    public $provinsi = '';
    public $kabupaten_kota = '';
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
    public $gambar = null;
    public $existingGambar = null;

    protected $rules = [
        'provinsi' => 'required|string|max:255',
        'kabupaten_kota' => 'required|string|max:255',
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
        'gambar' => 'nullable|file|image|max:2048',
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
        $this->existingGambar = $alamat->gambar;
        $this->modalMode = 'edit';
        $this->showModal = true;
    }

    public function save()
    {
        try {
            $this->validate();

            $data = [
                'provinsi' => $this->provinsi,
                'kabupaten_kota' => $this->kabupaten_kota,
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

            // Handle image upload
            if ($this->gambar) {
                try {
                    // Ensure storage directory exists
                    if (!Storage::disk('public')->exists('daftar-alamat')) {
                        Storage::disk('public')->makeDirectory('daftar-alamat');
                    }

                    // Delete old image if editing
                    if ($this->modalMode === 'edit' && $this->existingGambar) {
                        Storage::disk('public')->delete($this->existingGambar);
                    }
                    
                    // Store new image
                    $fileName = time() . '_' . $this->gambar->getClientOriginalName();
                    $path = $this->gambar->storeAs('daftar-alamat', $fileName, 'public');
                    $data['gambar'] = $path;
                } catch (\Exception $uploadError) {
                    session()->flash('error', 'Gagal mengupload gambar: ' . $uploadError->getMessage());
                    return;
                }
            } elseif ($this->modalMode === 'edit') {
                // Keep existing image if no new image uploaded
                $data['gambar'] = $this->existingGambar;
            }

            if ($this->modalMode === 'create') {
                DaftarAlamat::create($data);
                session()->flash('message', 'Data alamat berhasil ditambahkan.');
            } else {
                DaftarAlamat::findOrFail($this->selectedId)->update($data);
                session()->flash('message', 'Data alamat berhasil diperbarui.');
            }

            $this->closeModal();
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Let Livewire handle validation errors normally
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error saving daftar alamat: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::check() ? Auth::id() : null,
                'data' => $data ?? []
            ]);
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        $alamat = DaftarAlamat::findOrFail($id);
        
        // Delete associated image
        if ($alamat->gambar) {
            Storage::disk('public')->delete($alamat->gambar);
        }
        
        $alamat->delete();
        session()->flash('message', 'Data alamat berhasil dihapus.');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
        $this->selectedId = null;
    }

    public function deleteImage()
    {
        if ($this->existingGambar) {
            Storage::disk('public')->delete($this->existingGambar);
            
            if ($this->selectedId) {
                DaftarAlamat::findOrFail($this->selectedId)->update(['gambar' => null]);
            }
            
            $this->existingGambar = null;
            session()->flash('message', 'Gambar berhasil dihapus.');
        }
    }

    public function resetForm()
    {
        $this->reset([
            'provinsi', 'kabupaten_kota', 'nama_dinas', 'alamat', 'telp', 'faks', 
            'email', 'website', 'posisi', 'urut', 'status', 'kategori', 
            'keterangan', 'latitude', 'longitude', 'gambar', 'existingGambar'
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
                $q->where('provinsi', 'like', '%' . $this->search . '%')
                  ->orWhere('kabupaten_kota', 'like', '%' . $this->search . '%')
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
            $query->where(function ($q) {
                $q->where('provinsi', 'like', '%' . $this->wilayahFilter . '%')
                  ->orWhere('kabupaten_kota', 'like', '%' . $this->wilayahFilter . '%');
            });
        }

        $alamats = $query->orderBy($this->sortBy, $this->sortDirection)
                        ->paginate($this->perPage);

        $statusOptions = DaftarAlamat::getStatusOptions();
        $kategoriOptions = DaftarAlamat::getKategoriOptions();
        
        $wilayahOptions = collect()
            ->merge(DaftarAlamat::distinct('provinsi')->orderBy('provinsi')->pluck('provinsi'))
            ->merge(DaftarAlamat::distinct('kabupaten_kota')->orderBy('kabupaten_kota')->pluck('kabupaten_kota'))
            ->filter()
            ->unique()
            ->sort()
            ->values()
            ->toArray();

        return view('livewire.admin.daftar-alamat.data-daftar-alamat', compact(
            'alamats', 'statusOptions', 'kategoriOptions', 'wilayahOptions'
        ));
    }
}
