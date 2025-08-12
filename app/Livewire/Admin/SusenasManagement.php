<?php

namespace App\Livewire\Admin;

use App\Models\TransaksiSusenas;
use App\Models\TbKelompokbps;
use App\Models\TbKomoditibps;
use App\Exports\SusenasExport;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class SusenasManagement extends Component
{
    use WithPagination;

    public $kd_kelompokbps = '';
    public $kd_komoditibps = '';
    public $tahun = '';
    public $konsumsi_kuantity = '';
    public $editingId = null;
    public $showModal = false;
    public $confirmingDeletion = false;
    public $deletingId = null;
    public $search = '';
    public $perPage = 10;
    public $perPageOptions = [10, 25, 50, 100];
    public $exportFormat = 'xlsx';

    protected $rules = [
        'kd_kelompokbps' => 'required|string|exists:tb_kelompokbps,kd_kelompokbps',
        'kd_komoditibps' => 'required|string|exists:tb_komoditibps,kd_komoditibps',
        'tahun' => 'required|integer|min:1900|max:2100',
        'konsumsi_kuantity' => 'required|numeric|min:0',
    ];

    protected $messages = [
        'kd_kelompokbps.required' => 'Kelompok BPS harus dipilih.',
        'kd_kelompokbps.exists' => 'Kelompok BPS tidak valid.',
        'kd_komoditibps.required' => 'Komoditi BPS harus dipilih.',
        'kd_komoditibps.exists' => 'Komoditi BPS tidak valid.',
        'tahun.required' => 'Tahun harus diisi.',
        'tahun.integer' => 'Tahun harus berupa angka.',
        'tahun.min' => 'Tahun minimal 1900.',
        'tahun.max' => 'Tahun maksimal 2100.',
        'konsumsi_kuantity.required' => 'Konsumsi kuantitas harus diisi.',
        'konsumsi_kuantity.numeric' => 'Konsumsi kuantitas harus berupa angka.',
        'konsumsi_kuantity.min' => 'Konsumsi kuantitas tidak boleh negatif.',
    ];

    public function mount()
    {
        // Check permission - hanya superadmin dan admin yang bisa akses
        abort_unless(auth()->user()->hasRole(['superadmin', 'admin']), 403);
        
        // Set default tahun ke tahun sekarang
        $this->tahun = date('Y');
    }

    public function render()
    {
        $susenas = TransaksiSusenas::with(['kelompokbps', 'komoditibps'])
            ->when($this->search, function ($query) {
                $query->where('tahun', 'like', '%' . $this->search . '%')
                      ->orWhere('konsumsi_kuantity', 'like', '%' . $this->search . '%')
                      ->orWhereHas('kelompokbps', function($q) {
                          $q->where('nm_kelompokbps', 'like', '%' . $this->search . '%');
                      })
                      ->orWhereHas('komoditibps', function($q) {
                          $q->where('nm_komoditibps', 'like', '%' . $this->search . '%');
                      });
            })
            ->orderBy('tahun', 'desc')
            ->orderBy('kd_kelompokbps')
            ->orderBy('kd_komoditibps')
            ->paginate($this->perPage);

        $kelompokbps = TbKelompokbps::orderBy('nm_kelompokbps')->get();
        $komoditibps = TbKomoditibps::with('kelompokbps')
            ->when($this->kd_kelompokbps, function($query) {
                $query->where('kd_kelompokbps', $this->kd_kelompokbps);
            })
            ->orderBy('nm_komoditibps')
            ->get();

        return view('livewire.admin.susenas-management', compact('susenas', 'kelompokbps', 'komoditibps'));
    }

    public function create()
    {
        abort_unless(auth()->user()->hasRole(['superadmin', 'admin']), 403);
        
        $this->resetForm();
        $this->tahun = date('Y'); // Reset ke tahun sekarang
        $this->showModal = true;
    }

    public function edit($id)
    {
        abort_unless(auth()->user()->hasRole(['superadmin', 'admin']), 403);
        
        $susenas = TransaksiSusenas::findOrFail($id);
        $this->editingId = $id;
        $this->kd_kelompokbps = $susenas->kd_kelompokbps;
        $this->kd_komoditibps = $susenas->kd_komoditibps;
        $this->tahun = $susenas->tahun;
        $this->konsumsi_kuantity = $susenas->konsumsi_kuantity;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->editingId) {
            abort_unless(auth()->user()->hasRole(['superadmin', 'admin']), 403);
            
            $susenas = TransaksiSusenas::findOrFail($this->editingId);
            $susenas->update([
                'kd_kelompokbps' => $this->kd_kelompokbps,
                'kd_komoditibps' => $this->kd_komoditibps,
                'tahun' => $this->tahun,
                'konsumsi_kuantity' => $this->konsumsi_kuantity,
            ]);

            session()->flash('message', 'Data susenas berhasil diperbarui.');
        } else {
            abort_unless(auth()->user()->hasRole(['superadmin', 'admin']), 403);
            
            TransaksiSusenas::create([
                'kd_kelompokbps' => $this->kd_kelompokbps,
                'kd_komoditibps' => $this->kd_komoditibps,
                'tahun' => $this->tahun,
                'konsumsi_kuantity' => $this->konsumsi_kuantity,
            ]);

            session()->flash('message', 'Data susenas berhasil ditambahkan.');
        }

        $this->resetForm();
        $this->showModal = false;
        $this->dispatch('close-modal');
    }

    public function confirmDelete($id)
    {
        abort_unless(auth()->user()->hasRole(['superadmin', 'admin']), 403);
        
        $this->deletingId = $id;
        $this->confirmingDeletion = true;
    }

    public function delete()
    {
        abort_unless(auth()->user()->hasRole(['superadmin', 'admin']), 403);
        
        TransaksiSusenas::findOrFail($this->deletingId)->delete();
        
        session()->flash('message', 'Data susenas berhasil dihapus.');
        $this->confirmingDeletion = false;
        $this->deletingId = null;
    }

    public function cancelDelete()
    {
        $this->confirmingDeletion = false;
        $this->deletingId = null;
    }

    public function resetForm()
    {
        $this->editingId = null;
        $this->kd_kelompokbps = '';
        $this->kd_komoditibps = '';
        $this->tahun = date('Y');
        $this->konsumsi_kuantity = '';
        $this->resetErrorBag();
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
        $this->dispatch('close-modal');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function export()
    {
        return Excel::download(new SusenasExport($this->search), 'data-susenas.' . $this->exportFormat);
    }

    public function print()
    {
        $this->dispatch('print-susenas');
    }

    public function updatedKdKelompokbps()
    {
        // Reset komoditi selection when kelompok changes
        $this->kd_komoditibps = '';
    }
}
