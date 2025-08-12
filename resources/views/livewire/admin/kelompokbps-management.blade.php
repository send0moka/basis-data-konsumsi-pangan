<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-2xl font-semibold text-white">Kelompok BPS</h1>
                <p class="mt-1 text-sm text-gray-400">
                    Kelola kelompok BPS untuk klasifikasi data konsumsi pangan.
                </p>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                <button type="button" wire:click="create"
                    class="inline-flex items-center gap-x-1.5 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    <svg class="-ml-0.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                    </svg>
                    Tambah Kelompok BPS
                </button>
            </div>
        </div>

        @if (session()->has('message'))
            <div class="mt-4 rounded-md bg-green-50 dark:bg-green-900/20 p-4 border border-green-200 dark:border-green-700">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.236 4.53L7.53 10.25a.75.75 0 00-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800 dark:text-green-200">
                            {{ session('message') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Search -->
        <div class="mt-6">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <div class="max-w-lg w-full lg:max-w-xs">
                        <label for="search" class="sr-only">Search</label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input wire:model.live="search" id="search" name="search"
                                class="block w-full rounded-md border-0 bg-gray-800 py-1.5 pl-10 pr-3 text-white ring-1 ring-inset ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                placeholder="Cari data kelompok..." type="search">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-700">
                            <thead class="bg-gray-900">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wide">
                                        Kode
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wide">
                                        Nama Kelompok BPS
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wide">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-800 divide-y divide-gray-700">
                                @forelse($kelompokbps as $item)
                                    <tr class="hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                                            {{ $item->kd_kelompokbps }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                                            {{ $item->nm_kelompokbps }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button wire:click="edit('{{ $item->kd_kelompokbps }}')"
                                                class="text-blue-400 hover:text-blue-300 mr-4 font-medium">
                                                Edit
                                            </button>
                                            <button wire:click="confirmDelete('{{ $item->kd_kelompokbps }}')"
                                                class="text-red-400 hover:text-red-300 font-medium">
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 whitespace-nowrap text-sm text-gray-400 text-center">
                                            <div class="flex flex-col items-center">
                                                <svg class="h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                                </svg>
                                                <p class="text-gray-400 font-medium">Tidak ada kelompok BPS</p>
                                                <p class="text-gray-500 text-xs mt-1">Klik "Tambah Kelompok BPS" untuk menambah data baru</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        @if($kelompokbps->hasPages())
            <div class="mt-6">
                {{ $kelompokbps->links() }}
            </div>
        @endif
    </div>

    <!-- Create/Edit Modal -->
    @if($showModal)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-gray-800">
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-3">
                <h3 class="text-lg font-bold text-white">
                    {{ $editingId ? 'Edit Kelompok BPS' : 'Tambah Kelompok BPS' }}
                </h3>
                <button wire:click="closeModal" class="text-gray-400 hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <form wire:submit.prevent="save" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Kode Kelompok BPS</label>
                    <input wire:model="kd_kelompokbps" type="text" 
                           class="w-full px-3 py-2 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white placeholder-gray-400"
                           placeholder="KEL001">
                    @error('kd_kelompokbps')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Nama Kelompok BPS</label>
                    <input wire:model="nm_kelompokbps" type="text" 
                           class="w-full px-3 py-2 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white placeholder-gray-400"
                           placeholder="Nama kelompok BPS">
                    @error('nm_kelompokbps')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Modal Footer -->
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" wire:click="closeModal" 
                            class="px-4 py-2 bg-gray-600 text-gray-300 rounded hover:bg-gray-500">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">
                        {{ $editingId ? 'Update' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($confirmingDeletion)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-gray-800">
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-3">
                <h3 class="text-lg font-bold text-white">Konfirmasi Hapus</h3>
                <button wire:click="cancelDelete" class="text-gray-400 hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="py-4">
                <div class="text-center">
                    <p class="text-sm text-gray-300 mb-2">
                        Apakah Anda yakin ingin menghapus kelompok BPS ini?
                    </p>
                    <p class="text-xs text-gray-400">
                        Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
                
                <!-- Modal Footer -->
                <div class="flex justify-center gap-3 pt-6">
                    <button wire:click="cancelDelete" 
                            class="px-4 py-2 bg-gray-600 text-gray-300 rounded hover:bg-gray-500">
                        Batal
                    </button>
                    <button wire:click="delete" 
                            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-500">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
