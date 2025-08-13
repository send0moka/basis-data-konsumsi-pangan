<div>
    <!-- Header -->
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-neutral-900 dark:text-white">Kelola Data Susenas</h1>
                <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">
                    Kelola data konsumsi pangan dari survei Susenas
                </p>
            </div>
            <flux:button wire:click="create" variant="primary">
                Tambah Data Susenas
            </flux:button>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded dark:bg-green-900/30 dark:border-green-700 dark:text-green-300">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded dark:bg-red-900/30 dark:border-red-700 dark:text-red-300">
            {{ session('error') }}
        </div>
    @endif

    <!-- Search & Per Page -->
    <div class="mb-4 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div class="flex flex-col sm:flex-row sm:items-center gap-3 flex-1">
            <flux:input 
                wire:model.live="search" 
                placeholder="Cari data susenas..."
                class="w-full sm:max-w-sm"
            />
            <div class="flex items-center space-x-2">
                <label class="text-sm text-neutral-600 dark:text-neutral-400">Tampil</label>
                <select wire:model.live="perPage" class="text-sm rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-200 focus:ring-accent focus:border-accent">
                    @foreach($perPageOptions as $size)
                        <option value="{{ $size }}">{{ $size }}</option>
                    @endforeach
                </select>
                <span class="text-sm text-neutral-600 dark:text-neutral-400">/ halaman</span>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <div class="flex items-center space-x-2">
                <label for="exportFormat" class="text-sm text-neutral-600 dark:text-neutral-400">Export</label>
                <select id="exportFormat" wire:model="exportFormat" class="text-sm rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-200 focus:ring-accent focus:border-accent">
                    <option value="xlsx">XLSX</option>
                    <option value="csv">CSV</option>
                </select>
            </div>
            <flux:button wire:click="export" variant="ghost" class="!px-4">
                Download
            </flux:button>
            <flux:button wire:click="print" variant="ghost" class="!px-4">
                Print
            </flux:button>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-neutral-800 shadow-sm rounded-lg border border-neutral-200 dark:border-neutral-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                <thead class="bg-neutral-50 dark:bg-neutral-800/50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Kelompok BPS
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Komoditi BPS
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Tahun
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Satuan
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Konsumsi Kuantitas
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Konsumsi Nilai
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Konsumsi Gizi
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-neutral-900 divide-y divide-neutral-200 dark:divide-neutral-700">
                    @forelse($susenas as $item)
                        <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                <div class="text-sm font-medium text-neutral-900 dark:text-neutral-100">
                                    {{ $item->kelompokbps->nm_kelompokbps ?? '-' }}
                                </div>
                                <div class="text-sm text-neutral-500 dark:text-neutral-400">
                                    {{ $item->kd_kelompokbps }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                <div class="text-sm font-medium text-neutral-900 dark:text-neutral-100">
                                    {{ $item->komoditibps->nm_komoditibps ?? '-' }}
                                </div>
                                <div class="text-sm text-neutral-500 dark:text-neutral-400">
                                    {{ $item->kd_komoditibps }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-neutral-900 dark:text-neutral-100">
                                {{ $item->tahun }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-neutral-900 dark:text-neutral-100">
                                {{ $item->Satuan ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-neutral-900 dark:text-neutral-100">
                                {{ number_format($item->konsumsikuantity, 2) ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-neutral-900 dark:text-neutral-100">
                                {{ $item->konsumsinilai ? number_format($item->konsumsinilai, 2) : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-neutral-900 dark:text-neutral-100">
                                {{ $item->konsumsigizi ? number_format($item->konsumsigizi, 2) : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    @can('edit susenas')
                                    <flux:button wire:click="edit({{ $item->id }})" variant="ghost" size="sm">
                                        Edit
                                    </flux:button>
                                    @endcan
                                    @can('delete susenas')
                                    <flux:button wire:click="confirmDelete({{ $item->id }})" variant="danger" size="sm">
                                        Hapus
                                    </flux:button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-neutral-500 dark:text-neutral-400">
                                <div class="flex flex-col items-center">
                                    <svg class="h-12 w-12 text-neutral-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                    </svg>
                                    <p class="text-neutral-500 dark:text-neutral-400 font-medium">Tidak ada data Susenas</p>
                                    <p class="text-neutral-400 dark:text-neutral-500 text-sm mt-1">Klik "Tambah Data Susenas" untuk menambah data baru</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($susenas->hasPages())
            <div class="bg-white dark:bg-neutral-800 px-4 py-3 border-t border-neutral-200 dark:border-neutral-700 sm:px-6">
                {{ $susenas->links() }}
            </div>
        @endif
    </div>

    <!-- Create Modal -->
    @if($showCreateModal)
    <div class="fixed inset-0 bg-neutral-900/70 dark:bg-neutral-950/80 backdrop-blur-sm overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-6 border border-neutral-200 dark:border-neutral-700 max-w-4xl shadow-xl rounded-md bg-white dark:!bg-neutral-800">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-neutral-900 dark:text-white mb-6">Tambah Data Susenas</h3>
                <form wire:submit="save">
                    <div class="max-h-96 overflow-y-auto pr-2">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <!-- Informasi Dasar -->
                            <div class="md:col-span-2">
                                <h4 class="font-medium text-neutral-900 dark:text-white border-b">Informasi Dasar</h4>
                            </div>
                            
                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Tahun *</label>
                                <input type="number" wire:model="tahun" min="1900" max="2100" placeholder="Masukkan tahun" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm" />
                                @error('tahun') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Kelompok BPS *</label>
                                <div class="relative">
                                    <select wire:model.live="kd_kelompokbps" class="w-full px-4 py-3 pr-10 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm appearance-none">
                                        <option value="">Pilih Kelompok BPS</option>
                                        @foreach($kelompokbps as $kelompok)
                                            <option value="{{ $kelompok->kd_kelompokbps }}">
                                                {{ $kelompok->kd_kelompokbps }} - {{ $kelompok->nm_kelompokbps }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="h-4 w-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('kd_kelompokbps') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Komoditi BPS *</label>
                                <div class="relative">
                                    <select wire:model="kd_komoditibps" class="w-full px-4 py-3 pr-10 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm appearance-none">
                                        <option value="">{{ $kd_kelompokbps ? 'Pilih Komoditi BPS' : 'Pilih kelompok BPS terlebih dahulu' }}</option>
                                        @foreach($komoditibps as $komoditi)
                                            <option value="{{ $komoditi->kd_komoditibps }}">
                                                {{ $komoditi->kd_komoditibps }} - {{ $komoditi->nm_komoditibps }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="h-4 w-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('kd_komoditibps') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Satuan</label>
                                <input type="text" wire:model="Satuan" placeholder="Masukkan satuan (kg, liter, dll.)" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('Satuan') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            
                            <!-- Data Konsumsi -->
                            <div class="md:col-span-2">
                                <h4 class="font-medium text-neutral-900 dark:text-white border-b pb-2 mt-4">Data Konsumsi</h4>
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Konsumsi Kuantitas *</label>
                                <input type="number" step="0.01" min="0" wire:model="konsumsikuantity" placeholder="Masukkan nilai konsumsi kuantitas" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('konsumsikuantity') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Konsumsi Nilai</label>
                                <input type="number" step="0.01" min="0" wire:model="konsumsinilai" placeholder="Masukkan nilai konsumsi dalam rupiah" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('konsumsinilai') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Konsumsi Gizi</label>
                                <input type="number" step="0.01" min="0" wire:model="konsumsigizi" placeholder="Masukkan nilai konsumsi gizi" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('konsumsigizi') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3 mt-8 pt-6">
                        <flux:button type="button" wire:click="closeCreateModal" variant="ghost">
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

    <!-- Edit Modal -->
    @if($showEditModal)
    <div class="fixed inset-0 bg-neutral-900/70 dark:bg-neutral-950/80 backdrop-blur-sm overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-6 border border-neutral-200 dark:border-neutral-700 max-w-4xl shadow-xl rounded-md bg-white dark:!bg-neutral-800">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-neutral-900 dark:text-white mb-6">Edit Data Susenas</h3>
                <form wire:submit="save">
                    <div class="max-h-96 overflow-y-auto pr-2">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <!-- Informasi Dasar -->
                            <div class="md:col-span-2">
                                <h4 class="font-medium text-neutral-900 dark:text-white border-b">Informasi Dasar</h4>
                            </div>
                            
                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Tahun *</label>
                                <input type="number" wire:model="tahun" min="1900" max="2100" placeholder="Masukkan tahun" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm" />
                                @error('tahun') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Kelompok BPS *</label>
                                <div class="relative">
                                    <select wire:model.live="kd_kelompokbps" class="w-full px-4 py-3 pr-10 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm appearance-none">
                                        <option value="">Pilih Kelompok BPS</option>
                                        @foreach($kelompokbps as $kelompok)
                                            <option value="{{ $kelompok->kd_kelompokbps }}">
                                                {{ $kelompok->kd_kelompokbps }} - {{ $kelompok->nm_kelompokbps }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="h-4 w-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('kd_kelompokbps') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Komoditi BPS *</label>
                                <div class="relative">
                                    <select wire:model="kd_komoditibps" class="w-full px-4 py-3 pr-10 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm appearance-none">
                                        <option value="">{{ $kd_kelompokbps ? 'Pilih Komoditi BPS' : 'Pilih kelompok BPS terlebih dahulu' }}</option>
                                        @foreach($komoditibps as $komoditi)
                                            <option value="{{ $komoditi->kd_komoditibps }}">
                                                {{ $komoditi->kd_komoditibps }} - {{ $komoditi->nm_komoditibps }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="h-4 w-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('kd_komoditibps') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Satuan</label>
                                <input type="text" wire:model="Satuan" placeholder="Masukkan satuan (kg, liter, dll.)" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('Satuan') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            
                            <!-- Data Konsumsi -->
                            <div class="md:col-span-2">
                                <h4 class="font-medium text-neutral-900 dark:text-white border-b pb-2 mt-4">Data Konsumsi</h4>
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Konsumsi Kuantitas *</label>
                                <input type="number" step="0.01" min="0" wire:model="konsumsikuantity" placeholder="Masukkan nilai konsumsi kuantitas" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('konsumsikuantity') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Konsumsi Nilai</label>
                                <input type="number" step="0.01" min="0" wire:model="konsumsinilai" placeholder="Masukkan nilai konsumsi dalam rupiah" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('konsumsinilai') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Konsumsi Gizi</label>
                                <input type="number" step="0.01" min="0" wire:model="konsumsigizi" placeholder="Masukkan nilai konsumsi gizi" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('konsumsigizi') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3 mt-8 pt-6">
                        <flux:button type="button" wire:click="closeEditModal" variant="ghost">
                            Batal
                        </flux:button>
                        <flux:button type="submit" variant="primary">
                            Perbarui
                        </flux:button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal)
    <div class="fixed inset-0 bg-neutral-900/70 dark:bg-neutral-950/80 backdrop-blur-sm overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border border-neutral-200 dark:border-neutral-700 w-96 shadow-xl rounded-md bg-white dark:!bg-neutral-800">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/30">
                    <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-neutral-900 dark:text-white mt-2">Hapus Data Susenas</h3>
                <div class="mt-2">
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">
                        Apakah Anda yakin ingin menghapus data Susenas ini?
                        <br>Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
                <div class="flex justify-center space-x-3 mt-6">
                    <flux:button type="button" wire:click="closeDeleteModal" variant="ghost">
                        Batal
                    </flux:button>
                    <flux:button wire:click="delete" variant="danger">
                        Hapus
                    </flux:button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
    window.addEventListener('print-susenas', function () {
        window.print();
    });
</script>
@endpush
