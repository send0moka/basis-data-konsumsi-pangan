<?php

namespace App\Livewire\Admin;

use App\Models\TbKelompokbps;
use Livewire\Component;
use Livewire\WithPagination;

class KelompokbpsManagement extends Component
{
    use WithPagination;

    public $kd_kelompokbps = '';
    public $nm_kelompokbps = '';
    public $editingId = null;
    public $showModal = false;
    public $confirmingDeletion = false;
    public $deletingId = null;
    public $search = '';

    protected $rules = [
        'kd_kelompokbps' => 'required|string|max:255',
        'nm_kelompokbps' => 'required|string|max:255',
    ];

    protected $messages = [
        'kd_kelompokbps.required' => 'Kode Kelompok BPS harus diisi.',
        'kd_kelompokbps.unique' => 'Kode Kelompok BPS sudah ada.',
        'nm_kelompokbps.required' => 'Nama Kelompok BPS harus diisi.',
    ];

    public function mount()
    {
        // Check permission - hanya superadmin dan admin yang bisa akses
        abort_unless(auth()->user()->hasRole(['superadmin', 'admin']), 403);
    }

    public function render()
    {
        $kelompokbps = TbKelompokbps::query()
            ->when($this->search, function ($query) {
                $query->where('kd_kelompokbps', 'like', '%' . $this->search . '%')
                      ->orWhere('nm_kelompokbps', 'like', '%' . $this->search . '%');
            })
            ->orderBy('kd_kelompokbps')
            ->paginate(10);

        return view('livewire.admin.kelompokbps-management', compact('kelompokbps'));
    }

    public function create()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit($kd_kelompokbps)
    {
        $kelompokbps = TbKelompokbps::findOrFail($kd_kelompokbps);
        $this->editingId = $kd_kelompokbps;
        $this->kd_kelompokbps = $kelompokbps->kd_kelompokbps;
        $this->nm_kelompokbps = $kelompokbps->nm_kelompokbps;
        $this->showModal = true;
    }

    public function save()
    {
        // Validate based on whether we're creating or editing
        $rules = $this->rules;
        if ($this->editingId) {
            $rules['kd_kelompokbps'] = 'required|string|max:255|unique:tb_kelompokbps,kd_kelompokbps,' . $this->editingId . ',kd_kelompokbps';
        } else {
            $rules['kd_kelompokbps'] = 'required|string|max:255|unique:tb_kelompokbps,kd_kelompokbps';
        }

        $this->validate($rules);

        if ($this->editingId) {            
            $kelompokbps = TbKelompokbps::findOrFail($this->editingId);
            $kelompokbps->update([
                'kd_kelompokbps' => $this->kd_kelompokbps,
                'nm_kelompokbps' => $this->nm_kelompokbps,
            ]);

            session()->flash('message', 'Kelompok BPS berhasil diperbarui.');
        } else {            
            TbKelompokbps::create([
                'kd_kelompokbps' => $this->kd_kelompokbps,
                'nm_kelompokbps' => $this->nm_kelompokbps,
            ]);

            session()->flash('message', 'Kelompok BPS berhasil ditambahkan.');
        }

        $this->resetForm();
        $this->showModal = false;
    }

    public function confirmDelete($kd_kelompokbps)
    {
        $this->deletingId = $kd_kelompokbps;
        $this->confirmingDeletion = true;
    }

    public function delete()
    {
        TbKelompokbps::findOrFail($this->deletingId)->delete();
        
        session()->flash('message', 'Kelompok BPS berhasil dihapus.');
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
        $this->nm_kelompokbps = '';
        $this->resetErrorBag();
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
