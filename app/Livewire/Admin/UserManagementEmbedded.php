<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class UserManagementEmbedded extends Component
{
    use WithPagination;

    public $search = '';
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;
    
    public $name = '';
    public $email = '';
    public $password = '';
    public $selectedRole = '';
    public $editingUser = null;
    public $deletingUser = null;

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'selectedRole' => 'required',
    ];

    public function updatingSearch()
    {
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

    public function openEditModal($userId)
    {
        $this->editingUser = User::findOrFail($userId);
        $this->name = $this->editingUser->name;
        $this->email = $this->editingUser->email;
        $this->selectedRole = $this->editingUser->roles->first()?->name ?? '';
        $this->password = '';
        $this->showEditModal = true;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->resetForm();
    }

    public function openDeleteModal($userId)
    {
        $this->deletingUser = User::findOrFail($userId);
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deletingUser = null;
    }

    public function createUser()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
        ]);

        if ($this->selectedRole) {
            $user->assignRole($this->selectedRole);
        }

        session()->flash('message', 'User berhasil dibuat.');
        $this->closeCreateModal();
    }

    public function updateUser()
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $this->editingUser->id,
            'selectedRole' => 'required',
        ];

        if (!empty($this->password)) {
            $rules['password'] = 'min:8';
        }

        $this->validate($rules);

        $this->editingUser->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        if (!empty($this->password)) {
            $this->editingUser->update(['password' => bcrypt($this->password)]);
        }

        $this->editingUser->syncRoles([$this->selectedRole]);

        session()->flash('message', 'User berhasil diupdate.');
        $this->closeEditModal();
    }

    public function deleteUser()
    {
        if ($this->deletingUser) {
            $this->deletingUser->delete();
            session()->flash('message', 'User berhasil dihapus.');
            $this->closeDeleteModal();
        }
    }

    private function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->selectedRole = '';
        $this->editingUser = null;
        $this->resetErrorBag();
    }

    public function render()
    {
        $users = User::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
        })->with('roles')->paginate(10);

        $roles = Role::all();

        return view('livewire.admin.user-management-embedded', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }
}
