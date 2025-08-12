<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col space-y-4 lg:flex-row lg:items-center lg:justify-between lg:space-y-0">
        <div>
            <h1 class="text-2xl font-bold text-white">Komoditi BPS</h1>
            <p class="mt-1 text-sm text-gray-400">
                Kelola data komoditi BPS untuk klasifikasi jenis pangan
            </p>
        </div>
        <div class="flex-shrink-0">
            <button wire:click="create" 
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Tambah Komoditi
            </button>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="bg-green-800 border border-green-700 text-green-100 px-4 py-3 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>{{ session('message') }}</span>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-800 border border-red-700 text-red-100 px-4 py-3 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Search -->
    <div class="bg-gray-800 border border-gray-700 rounded-lg p-4">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-3 lg:space-y-0 lg:space-x-4">
            <div class="flex-1 min-w-0">
                <div class="max-w-lg w-full lg:max-w-xs">
                    <label for="search" class="sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input wire:model.live="search" id="search" name="search"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="Cari komoditi..." type="search">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-gray-800 border border-gray-700 rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-750">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Kode
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Nama Komoditi
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Kelompok BPS
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($komoditibps as $item)
                        <tr class="hover:bg-gray-750 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                                {{ $item->kd_komoditibps }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                                {{ $item->nm_komoditibps }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                <div class="text-sm font-medium text-white">
                                    {{ $item->kelompokbps->nm_kelompokbps ?? '-' }}
                                </div>
                                <div class="text-sm text-gray-400">
                                    {{ $item->kd_kelompokbps }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-3">
                                    <button wire:click="edit('{{ $item->kd_komoditibps }}')"
                                        class="text-blue-400 hover:text-blue-300 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <button wire:click="confirmDelete('{{ $item->kd_komoditibps }}')"
                                        class="text-red-400 hover:text-red-300 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="h-12 w-12 text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                    <p class="text-gray-400 font-medium">Tidak ada data komoditi</p>
                                    <p class="text-gray-500 text-sm mt-1">Klik "Tambah Komoditi" untuk menambah data baru</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $komoditibps->links() }}
    </div>

    <!-- Modal for Create/Edit -->
    @if($showModal)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-gray-800">
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-3">
                <h3 class="text-lg font-bold text-white">
                    {{ $editingId ? 'Edit Komoditi' : 'Tambah Komoditi' }}
                </h3>
                <button wire:click="closeModal" class="text-gray-400 hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <form wire:submit="save">
                <div class="space-y-4">
                    <div>
                        <label for="kd_komoditibps" class="block text-sm font-medium text-gray-300 mb-2">
                            Kode Komoditi <span class="text-red-400">*</span>
                        </label>
                        <input wire:model="kd_komoditibps" type="text" id="kd_komoditibps"
                            class="w-full px-3 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('kd_komoditibps') border-red-500 @enderror"
                            placeholder="Masukkan kode komoditi">
                        @error('kd_komoditibps')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nm_komoditibps" class="block text-sm font-medium text-gray-300 mb-2">
                            Nama Komoditi <span class="text-red-400">*</span>
                        </label>
                        <input wire:model="nm_komoditibps" type="text" id="nm_komoditibps"
                            class="w-full px-3 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nm_komoditibps') border-red-500 @enderror"
                            placeholder="Masukkan nama komoditi">
                        @error('nm_komoditibps')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="kd_kelompokbps" class="block text-sm font-medium text-gray-300 mb-2">
                            Kelompok BPS <span class="text-red-400">*</span>
                        </label>
                        <select wire:model="kd_kelompokbps" id="kd_kelompokbps"
                            class="w-full px-3 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('kd_kelompokbps') border-red-500 @enderror">
                            <option value="">Pilih Kelompok BPS</option>
                            @foreach($kelompokbps as $kelompok)
                                <option value="{{ $kelompok->kd_kelompokbps }}">
                                    {{ $kelompok->kd_kelompokbps }} - {{ $kelompok->nm_kelompokbps }}
                                </option>
                            @endforeach
                        </select>
                        @error('kd_kelompokbps')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Modal Footer -->
                <div class="flex justify-end gap-3 pt-6">
                    <button wire:click="closeModal" type="button" 
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
                        Apakah Anda yakin ingin menghapus komoditi ini?
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
