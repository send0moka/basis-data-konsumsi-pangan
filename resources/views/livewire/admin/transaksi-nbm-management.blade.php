<div>
    <!-- Header -->
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-neutral-900 dark:text-white">Kelola Transaksi NBM</h1>
                <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">
                    Kelola data transaksi neraca bahan makanan
                </p>
            </div>
            @can('create transaksi_nbm')
            <flux:button wire:click="openCreateModal" variant="primary">
                Tambah Transaksi NBM
            </flux:button>
            @endcan
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded dark:bg-green-900/30 dark:border-green-700 dark:text-green-300">
            {{ session('message') }}
        </div>
    @endif

    <!-- Search & Per Page -->
    <div class="mb-4 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div class="flex flex-col sm:flex-row sm:items-center gap-3 flex-1">
            <flux:input 
                wire:model.live="search" 
                placeholder="Cari berdasarkan kelompok, komoditi, tahun..."
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
            @can('export transaksi_nbm')
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
            @endcan
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-neutral-800 shadow-sm rounded-lg border border-neutral-200 dark:border-neutral-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                <thead class="bg-neutral-50 dark:bg-neutral-800/50">
                    <tr>
                        <th class="px-3 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            ID
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Kelompok
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Komoditi
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Tahun
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Status Angka
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Masukan
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Keluaran
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Impor
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Ekspor
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Perubahan Stok
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Pakan
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Bibit
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Makanan
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Bukan Makanan
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Tercecer
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Penggunaan Lain
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Bahan Makanan
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Kg/Tahun
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Gram/Hari
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Kalori/Hari
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Protein/Hari
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Lemak/Hari
                        </th>
                        <th class="px-3 py-3 text-right text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                                <tbody class="bg-white dark:bg-neutral-900 divide-y divide-neutral-200 dark:divide-neutral-700">
                    @forelse($transaksiNbms as $transaksi)
                        <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/50">
                            <td class="px-3 py-3 text-sm text-neutral-900 dark:text-neutral-100">
                                {{ $transaksi->id }}
                            </td>
                            <td class="px-3 py-3 text-sm text-neutral-900 dark:text-neutral-100">
                                <div class="flex flex-col">
                                    <span class="font-medium">{{ $transaksi->kelompok->nama ?? 'N/A' }}</span>
                                    <span class="text-xs text-neutral-500 dark:text-neutral-400">{{ $transaksi->kode_kelompok }}</span>
                                </div>
                            </td>
                            <td class="px-3 py-3 text-sm text-neutral-900 dark:text-neutral-100">
                                <div class="flex flex-col">
                                    <span class="font-medium">{{ $transaksi->komoditi->nama ?? 'N/A' }}</span>
                                    <span class="text-xs text-neutral-500 dark:text-neutral-400">{{ $transaksi->kode_komoditi }}</span>
                                </div>
                            </td>
                            <td class="px-3 py-3 text-sm text-neutral-900 dark:text-neutral-100">
                                {{ $transaksi->tahun }}
                            </td>
                            <td class="px-3 py-3 text-sm">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    @if($transaksi->status_angka === 'tetap') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                    @elseif($transaksi->status_angka === 'sementara') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                                    @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                                    @endif">
                                    {{ ucfirst($transaksi->status_angka) }}
                                </span>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                {{ number_format($transaksi->masukan ?? 0, 4) }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                {{ number_format($transaksi->keluaran ?? 0, 4) }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                {{ number_format($transaksi->impor ?? 0, 4) }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                {{ number_format($transaksi->ekspor ?? 0, 4) }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                {{ number_format($transaksi->perubahan_stok ?? 0, 4) }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                {{ number_format($transaksi->pakan ?? 0, 4) }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                {{ number_format($transaksi->bibit ?? 0, 4) }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                {{ number_format($transaksi->makanan ?? 0, 4) }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                {{ number_format($transaksi->bukan_makanan ?? 0, 4) }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                {{ number_format($transaksi->tercecer ?? 0, 4) }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                {{ number_format($transaksi->penggunaan_lain ?? 0, 4) }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                {{ number_format($transaksi->bahan_makanan ?? 0, 4) }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                {{ number_format($transaksi->kg_tahun ?? 0, 4) }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                {{ number_format($transaksi->gram_hari ?? 0, 4) }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                {{ number_format($transaksi->kalori_hari ?? 0, 4) }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                {{ number_format($transaksi->protein_hari ?? 0, 4) }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                {{ number_format($transaksi->lemak_hari ?? 0, 6) }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    @can('edit transaksi_nbm')
                                    <flux:button wire:click="openEditModal({{ $transaksi->id }})" variant="ghost" size="sm">
                                        Edit
                                    </flux:button>
                                    @endcan
                                    @can('delete transaksi_nbm')
                                    <flux:button wire:click="openDeleteModal({{ $transaksi->id }})" variant="danger" size="sm">
                                        Hapus
                                    </flux:button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="23" class="px-6 py-8 text-center text-neutral-500 dark:text-neutral-400">
                                @if($search)
                                    Tidak ada transaksi NBM yang ditemukan untuk pencarian "{{ $search }}".
                                @else
                                    Belum ada data transaksi NBM.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($transaksiNbms->hasPages())
            <div class="bg-white dark:bg-neutral-800 px-4 py-3 border-t border-neutral-200 dark:border-neutral-700 sm:px-6">
                {{ $transaksiNbms->links() }}
            </div>
        @endif
    </div>

    <!-- Create Modal -->
    @if($showCreateModal)
    <div class="fixed inset-0 bg-neutral-900/70 dark:bg-neutral-950/80 backdrop-blur-sm overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-6 border border-neutral-200 dark:border-neutral-700 max-w-5xl shadow-xl rounded-md bg-white dark:!bg-neutral-800">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-neutral-900 dark:text-white mb-6">Tambah Transaksi NBM</h3>
                <form wire:submit.prevent="createTransaksi">
                    <div class="max-h-96 overflow-y-auto pr-2">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            
                            <!-- Informasi Dasar -->
                            <div class="lg:col-span-3">
                                <h4 class="font-medium text-neutral-900 dark:text-white border-b mb-1">Informasi Dasar</h4>
                            </div>
                            
                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Kode Kelompok</label>
                                <div class="relative">
                                    <select wire:model.live="kode_kelompok" class="w-full pl-4 pr-10 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm appearance-none">
                                        <option value="">Pilih Kelompok</option>
                                        @foreach($kelompokOptions as $kelompok)
                                            <option value="{{ $kelompok['kode'] }}">{{ $kelompok['kode'] }} - {{ $kelompok['nama'] }}</option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-neutral-400">
                                        <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                        </svg>
                                    </div>
                                </div>
                                @error('kode_kelompok') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Kode Komoditi</label>
                                <div class="relative">
                                    <select wire:model="kode_komoditi" class="w-full pl-4 pr-10 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm appearance-none">
                                        <option value="">Pilih Komoditi</option>
                                        @foreach($komoditiOptions as $komoditi)
                                            <option value="{{ $komoditi['kode'] }}">{{ $komoditi['kode'] }} - {{ $komoditi['nama'] }}</option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-neutral-400">
                                        <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                        </svg>
                                    </div>
                                </div>
                                @error('kode_komoditi') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Tahun</label>
                                <input type="number" wire:model="tahun" min="1900" max="2100" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm" />
                                @error('tahun') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Status Angka</label>
                                <div class="relative">
                                    <select wire:model="status_angka" class="w-full pl-4 pr-10 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm appearance-none">
                                        <option value="">Pilih Status</option>
                                        <option value="tetap">Tetap</option>
                                        <option value="sementara">Sementara</option>
                                        <option value="sangat sementara">Sangat Sementara</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-neutral-400">
                                        <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                        </svg>
                                    </div>
                                </div>
                                @error('status_angka') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            
                            <!-- Data Produksi & Perdagangan -->
                            <div class="lg:col-span-3">
                                <h4 class="font-medium text-neutral-900 dark:text-white border-b pb-2 mb-2 mt-4">Data Produksi & Perdagangan</h4>
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Masukan</label>
                                <input type="number" step="0.0001" wire:model="masukan" placeholder="0.0000" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('masukan') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Keluaran</label>
                                <input type="number" step="0.0001" wire:model="keluaran" placeholder="0.0000" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('keluaran') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Impor</label>
                                <input type="number" step="0.0001" wire:model="impor" placeholder="0.0000" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('impor') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Ekspor</label>
                                <input type="number" step="0.0001" wire:model="ekspor" placeholder="0.0000" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('ekspor') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Perubahan Stok</label>
                                <input type="number" step="0.0001" wire:model="perubahan_stok" placeholder="0.0000" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('perubahan_stok') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Data Penggunaan -->
                            <div class="lg:col-span-3">
                                <h4 class="font-medium text-neutral-900 dark:text-white border-b pb-2 mb-2 mt-6">Data Penggunaan</h4>
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Pakan</label>
                                <input type="number" step="0.0001" wire:model="pakan" placeholder="0.0000" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('pakan') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Bibit</label>
                                <input type="number" step="0.0001" wire:model="bibit" placeholder="0.0000" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('bibit') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Makanan</label>
                                <input type="number" step="0.0001" wire:model="makanan" placeholder="0.0000" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('makanan') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Bukan Makanan</label>
                                <input type="number" step="0.0001" wire:model="bukan_makanan" placeholder="0.0000" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('bukan_makanan') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Tercecer</label>
                                <input type="number" step="0.0001" wire:model="tercecer" placeholder="0.0000" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('tercecer') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Penggunaan Lain</label>
                                <input type="number" step="0.0001" wire:model="penggunaan_lain" placeholder="0.0000" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('penggunaan_lain') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Data Konsumsi & Gizi -->
                            <div class="lg:col-span-3">
                                <h4 class="font-medium text-neutral-900 dark:text-white border-b pb-2 mb-2 mt-6">Data Konsumsi & Gizi</h4>
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Bahan Makanan</label>
                                <input type="number" step="0.0001" wire:model="bahan_makanan" placeholder="0.0000" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('bahan_makanan') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Kg/Tahun</label>
                                <input type="number" step="0.0001" wire:model="kg_tahun" placeholder="0.0000" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('kg_tahun') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Gram/Hari</label>
                                <input type="number" step="0.0001" wire:model="gram_hari" placeholder="0.0000" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('gram_hari') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Kalori/Hari</label>
                                <input type="number" step="0.0001" wire:model="kalori_hari" placeholder="0.0000" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('kalori_hari') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Protein/Hari</label>
                                <input type="number" step="0.0001" wire:model="protein_hari" placeholder="0.0000" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('protein_hari') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Lemak/Hari</label>
                                <input type="number" step="0.000001" wire:model="lemak_hari" placeholder="0.000000" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('lemak_hari') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
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
        <div class="relative top-10 mx-auto p-6 border border-neutral-200 dark:border-neutral-700 max-w-5xl shadow-xl rounded-md bg-white dark:!bg-neutral-800">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-neutral-900 dark:text-white mb-6">Edit Transaksi NBM</h3>
                <form wire:submit.prevent="updateTransaksi">
                    <div class="max-h-96 overflow-y-auto pr-2">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            
                            <!-- Informasi Dasar -->
                            <div class="lg:col-span-3">
                                <h4 class="font-medium text-neutral-900 dark:text-white border-b pb-2 mb-2">Informasi Dasar</h4>
                            </div>
                            
                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Kode Kelompok</label>
                                <div class="relative">
                                    <select wire:model.live="kode_kelompok" class="w-full pl-4 pr-10 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm appearance-none">
                                        <option value="">Pilih Kelompok</option>
                                        @foreach($kelompokOptions as $kelompok)
                                            <option value="{{ $kelompok['kode'] }}">{{ $kelompok['kode'] }} - {{ $kelompok['nama'] }}</option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-neutral-400">
                                        <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                        </svg>
                                    </div>
                                </div>
                                @error('kode_kelompok') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Kode Komoditi</label>
                                <div class="relative">
                                    <select wire:model="kode_komoditi" class="w-full pl-4 pr-10 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm appearance-none">
                                        <option value="">Pilih Komoditi</option>
                                        @foreach($komoditiOptions as $komoditi)
                                            <option value="{{ $komoditi['kode'] }}">{{ $komoditi['kode'] }} - {{ $komoditi['nama'] }}</option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-neutral-400">
                                        <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                        </svg>
                                    </div>
                                </div>
                                @error('kode_komoditi') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Tahun</label>
                                <input type="number" wire:model="tahun" min="1900" max="2100" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm" />
                                @error('tahun') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Status Angka</label>
                                <div class="relative">
                                    <select wire:model="status_angka" class="w-full pl-4 pr-10 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm appearance-none">
                                        <option value="">Pilih Status</option>
                                        <option value="tetap">Tetap</option>
                                        <option value="sementara">Sementara</option>
                                        <option value="sangat sementara">Sangat Sementara</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-neutral-400">
                                        <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                        </svg>
                                    </div>
                                </div>
                                @error('status_angka') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            
                            <!-- Data Produksi & Perdagangan -->
                            <div class="lg:col-span-3">
                                <h4 class="font-medium text-neutral-900 dark:text-white border-b pb-2 mb-2 mt-6">Data Produksi & Perdagangan</h4>
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Masukan</label>
                                <input type="number" step="0.0001" wire:model="masukan" placeholder="0.0000" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('masukan') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Keluaran</label>
                                <input type="number" step="0.0001" wire:model="keluaran" placeholder="0.0000" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('keluaran') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Impor</label>
                                <input type="number" step="0.0001" wire:model="impor" placeholder="0.0000" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('impor') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Ekspor</label>
                                <input type="number" step="0.0001" wire:model="ekspor" placeholder="0.0000" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('ekspor') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Perubahan Stok</label>
                                <input type="number" step="0.0001" wire:model="perubahan_stok" placeholder="0.0000" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('perubahan_stok') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Data Penggunaan -->
                            <div class="lg:col-span-3">
                                <h4 class="font-medium text-neutral-900 dark:text-white border-b pb-2 mb-2 mt-6">Data Penggunaan</h4>
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Pakan</label>
                                <input type="number" step="0.0001" wire:model="pakan" placeholder="0.0000" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('pakan') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Bibit</label>
                                <input type="number" step="0.0001" wire:model="bibit" placeholder="0.0000" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('bibit') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Makanan</label>
                                <input type="number" step="0.0001" wire:model="makanan" placeholder="0.0000" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('makanan') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Bukan Makanan</label>
                                <input type="number" step="0.0001" wire:model="bukan_makanan" placeholder="0.0000" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('bukan_makanan') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Tercecer</label>
                                <input type="number" step="0.0001" wire:model="tercecer" placeholder="0.0000" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('tercecer') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Penggunaan Lain</label>
                                <input type="number" step="0.0001" wire:model="penggunaan_lain" placeholder="0.0000" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('penggunaan_lain') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Data Konsumsi & Gizi -->
                            <div class="lg:col-span-3">
                                <h4 class="font-medium text-neutral-900 dark:text-white border-b pb-2 mb-2 mt-6">Data Konsumsi & Gizi</h4>
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Bahan Makanan</label>
                                <input type="number" step="0.0001" wire:model="bahan_makanan" placeholder="0.0000" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('bahan_makanan') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Kg/Tahun</label>
                                <input type="number" step="0.0001" wire:model="kg_tahun" placeholder="0.0000" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('kg_tahun') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Gram/Hari</label>
                                <input type="number" step="0.0001" wire:model="gram_hari" placeholder="0.0000" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('gram_hari') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Kalori/Hari</label>
                                <input type="number" step="0.0001" wire:model="kalori_hari" placeholder="0.0000" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('kalori_hari') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Protein/Hari</label>
                                <input type="number" step="0.0001" wire:model="protein_hari" placeholder="0.0000" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('protein_hari') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Lemak/Hari</label>
                                <input type="number" step="0.000001" wire:model="lemak_hari" placeholder="0.000000" class="w-full px-4 py-3 rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent text-sm placeholder-neutral-400" />
                                @error('lemak_hari') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3 mt-8 pt-6">
                        <flux:button type="button" wire:click="closeEditModal" variant="ghost">
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

    <!-- Delete Modal -->
    @if($showDeleteModal)
    <div class="fixed inset-0 bg-neutral-900/70 dark:bg-neutral-950/80 backdrop-blur-sm overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border border-neutral-200 dark:border-neutral-700 w-96 shadow-xl rounded-md bg-white dark:!bg-neutral-800">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/30">
                    <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-neutral-900 dark:text-white mt-2">Hapus Transaksi NBM</h3>
                <div class="mt-2">
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">
                        Apakah Anda yakin ingin menghapus transaksi NBM ini?
                        <br>Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
                <div class="flex justify-center space-x-3 mt-6">
                    <flux:button type="button" variant="ghost" wire:click="closeDeleteModal">
                        Batal
                    </flux:button>
                    <flux:button type="button" variant="danger" wire:click="deleteTransaksi">
                        Hapus
                    </flux:button>
                </div>
            </div>
        </div>
    </div>
    @endif

    @script
    <script>
        window.addEventListener('print-transaksi-nbm', function () {
            window.print();
        });
    </script>
    @endscript
</div>
