<div>
    <!-- Header -->
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Kelola User</h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Kelola akun pengguna dan role mereka
                </p>
            </div>
            @can('create users')
            <flux:button wire:click="openCreateModal" variant="primary">
                Tambah User
            </flux:button>
            @endcan
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif

    <!-- Search -->
    <div class="mb-4">
        <flux:input 
            wire:model.live="search" 
            placeholder="Cari berdasarkan nama atau email..."
            class="w-full max-w-md"
        />
    </div>

    <!-- Users Table -->
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nama</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Role</th>
                        <th scope="col" class="px-6 py-3">Bergabung</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                            {{ $user->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4">
                            @foreach($user->roles as $role)
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                    {{ ucfirst($role->name) }}
                                </span>
                            @endforeach
                        </td>
                        <td class="px-6 py-4">
                            {{ $user->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                @can('edit users')
                                <flux:button wire:click="openEditModal({{ $user->id }})" variant="ghost" size="sm">
                                    Edit
                                </flux:button>
                                @endcan
                                @can('delete users')
                                <flux:button wire:click="openDeleteModal({{ $user->id }})" variant="danger" size="sm">
                                    Hapus
                                </flux:button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada user ditemukan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-3">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Create User Modal -->
    @if($showCreateModal)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Tambah User</h3>
                <form wire:submit="createUser">
                    <div class="space-y-4">
                        <flux:input wire:model="name" label="Nama" placeholder="Nama lengkap" required />
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                        <flux:input wire:model="email" label="Email" type="email" placeholder="email@example.com" required />
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                        <flux:input wire:model="password" label="Password" type="password" required />
                        @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                        <flux:select wire:model="selectedRole" label="Role" placeholder="Pilih role">
                            @foreach($roles as $role)
                                <flux:option value="{{ $role->name }}">{{ ucfirst($role->name) }}</flux:option>
                            @endforeach
                        </flux:select>
                        @error('selectedRole') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end space-x-3 mt-6">
                        <flux:button wire:click="closeCreateModal" variant="ghost">
                            Batal
                        </flux:button>
                        <flux:button type="submit" variant="primary">
                            Simpan
                        </flux:button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Edit User Modal -->
    @if($showEditModal && $editingUser)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Edit User</h3>
                <form wire:submit="updateUser">
                    <div class="space-y-4">
                        <flux:input wire:model="name" label="Nama" placeholder="Nama lengkap" required />
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                        <flux:input wire:model="email" label="Email" type="email" placeholder="email@example.com" required />
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                        <flux:input wire:model="password" label="Password Baru (kosongkan jika tidak ingin mengubah)" type="password" />
                        @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                        <flux:select wire:model="selectedRole" label="Role" placeholder="Pilih role">
                            @foreach($roles as $role)
                                <flux:option value="{{ $role->name }}">{{ ucfirst($role->name) }}</flux:option>
                            @endforeach
                        </flux:select>
                        @error('selectedRole') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end space-x-3 mt-6">
                        <flux:button wire:click="closeEditModal" variant="ghost">
                            Batal
                        </flux:button>
                        <flux:button type="submit" variant="primary">
                            Update
                        </flux:button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Delete User Modal -->
    @if($showDeleteModal && $deletingUser)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3 text-center">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Konfirmasi Hapus</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                    Apakah Anda yakin ingin menghapus user <strong>{{ $deletingUser->name }}</strong>?
                    Tindakan ini tidak dapat dibatalkan.
                </p>

                <div class="flex justify-center space-x-3">
                    <flux:button wire:click="closeDeleteModal" variant="ghost">
                        Batal
                    </flux:button>
                    <flux:button wire:click="deleteUser" variant="danger">
                        Hapus
                    </flux:button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
