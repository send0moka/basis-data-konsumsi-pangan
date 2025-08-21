<div>
    <!-- Header -->
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-neutral-900 dark:text-white">Kelola Data Lahan</h1>
                <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">
                    Kelola data lahan pertanian
                </p>
            </div>
            <flux:button wire:click="openCreateModal" variant="primary">
                Tambah Data Lahan
            </flux:button>
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
                placeholder="Cari berdasarkan wilayah, topik, variabel..."
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

    <!-- Lahan Table -->
    <div class="bg-white dark:!bg-neutral-800 overflow-hidden shadow-sm rounded-lg border border-neutral-200 dark:border-neutral-700" id="lahan-table-wrapper">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-neutral-500 dark:text-neutral-400" id="lahan-table">
                <thead class="text-xs text-neutral-700 uppercase bg-neutral-50 dark:bg-neutral-700 dark:text-neutral-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Topik</th>
                        <th scope="col" class="px-6 py-3">Variabel</th>
                        <th scope="col" class="px-6 py-3">Klasifikasi</th>
                        <th scope="col" class="px-6 py-3">Wilayah</th>
                        <th scope="col" class="px-6 py-3">Tahun</th>
                        <th scope="col" class="px-6 py-3">Nilai</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3 no-print">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lahans as $lahan)
                    <tr class="bg-white border-b dark:!bg-neutral-800 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:!bg-neutral-700 transition-colors">
                        <td class="px-6 py-4 font-medium text-neutral-900 dark:text-white">
                            {{ $lahan->lahanTopik->nama }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $lahan->lahanVariabel->nama }}
                            <span class="text-xs text-neutral-500 dark:text-neutral-400">({{ $lahan->lahanVariabel->satuan }})</span>
                        </td>
                        <td class="px-6 py-4">
                            {{ $lahan->lahanKlasifikasi->nama }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $lahan->wilayah }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $lahan->tahun }}
                        </td>
                        <td class="px-6 py-4">
                            {{ number_format($lahan->nilai, 2, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full 
                                @if($lahan->status === 'Aktif') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                @elseif($lahan->status === 'Tidak Aktif') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                                @elseif($lahan->status === 'Dalam Proses') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                                @elseif($lahan->status === 'Selesai') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300
                                @else bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-300
                                @endif">
                                {{ $lahan->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 no-print">
                            <div class="flex space-x-2">
                                <flux:button wire:click="openEditModal({{ $lahan->id }})" variant="ghost" size="sm">
                                    Edit
                                </flux:button>
                                <flux:button wire:click="openDeleteModal({{ $lahan->id }})" variant="danger" size="sm">
                                    Hapus
                                </flux:button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-neutral-500 dark:text-neutral-400">
                            Tidak ada data lahan ditemukan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-3 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="text-xs text-neutral-600 dark:text-neutral-400 md:mr-auto">
                Menampilkan
                <span class="font-medium text-neutral-800 dark:text-neutral-200">{{ $lahans->firstItem() }}</span>
                -
                <span class="font-medium text-neutral-800 dark:text-neutral-200">{{ $lahans->lastItem() }}</span>
                dari
                <span class="font-medium text-neutral-800 dark:text-neutral-200">{{ $lahans->total() }}</span>
                data lahan
            </div>
            {{ $lahans->links('vendor.pagination.tailwind') }}
        </div>
    </div>

    <!-- Create Lahan Modal -->
    @if($showCreateModal)
    <div class="fixed inset-0 bg-neutral-900/70 dark:bg-neutral-950/80 backdrop-blur-sm overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border border-neutral-200 dark:border-neutral-700 w-96 shadow-xl rounded-md bg-white dark:!bg-neutral-800">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-neutral-900 dark:text-white mb-4">Tambah Data Lahan</h3>
                <form wire:submit="createLahan">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Topik Lahan</label>
                            <select wire:model="id_lahan_topik" class="w-full text-sm rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-200 focus:ring-accent focus:border-accent" required>
                                <option value="">Pilih Topik</option>
                                @foreach($topiks as $topik)
                                    <option value="{{ $topik->id }}">{{ $topik->nama }}</option>
                                @endforeach
                            </select>
                            @error('id_lahan_topik') <span class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Variabel</label>
                            <select wire:model="id_lahan_variabel" class="w-full text-sm rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-200 focus:ring-accent focus:border-accent" required>
                                <option value="">Pilih Variabel</option>
                                @foreach($variabels as $variabel)
                                    <option value="{{ $variabel->id }}">{{ $variabel->nama }} ({{ $variabel->satuan }})</option>
                                @endforeach
                            </select>
                            @error('id_lahan_variabel') <span class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Klasifikasi</label>
                            <select wire:model="id_lahan_klasifikasi" class="w-full text-sm rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-200 focus:ring-accent focus:border-accent" required>
                                <option value="">Pilih Klasifikasi</option>
                                @foreach($klasifikasis as $klasifikasi)
                                    <option value="{{ $klasifikasi->id }}">{{ $klasifikasi->nama }}</option>
                                @endforeach
                            </select>
                            @error('id_lahan_klasifikasi') <span class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <flux:input wire:model="wilayah" label="Wilayah" placeholder="Masukkan nama wilayah" required />
                        @error('wilayah') <span class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</span> @enderror

                        <flux:input wire:model="tahun" label="Tahun" type="number" placeholder="2024" min="2000" max="2030" required />
                        @error('tahun') <span class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</span> @enderror

                        <flux:input wire:model="nilai" label="Nilai" type="number" step="0.01" placeholder="0.00" required />
                        @error('nilai') <span class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</span> @enderror

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Status</label>
                            <select wire:model="status" class="w-full text-sm rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-200 focus:ring-accent focus:border-accent" required>
                                <option value="">Pilih Status</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                                <option value="Dalam Proses">Dalam Proses</option>
                                <option value="Selesai">Selesai</option>
                                <option value="Tertunda">Tertunda</option>
                            </select>
                            @error('status') <span class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 mt-6">
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

    <!-- Edit Lahan Modal -->
    @if($showEditModal)
    <div class="fixed inset-0 bg-neutral-900/70 dark:bg-neutral-950/80 backdrop-blur-sm overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border border-neutral-200 dark:border-neutral-700 w-96 shadow-xl rounded-md bg-white dark:!bg-neutral-800">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-neutral-900 dark:text-white mb-4">Edit Data Lahan</h3>
                <form wire:submit="updateLahan">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Topik Lahan</label>
                            <select wire:model="id_lahan_topik" class="w-full text-sm rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-200 focus:ring-accent focus:border-accent" required>
                                <option value="">Pilih Topik</option>
                                @foreach($topiks as $topik)
                                    <option value="{{ $topik->id }}">{{ $topik->nama }}</option>
                                @endforeach
                            </select>
                            @error('id_lahan_topik') <span class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Variabel</label>
                            <select wire:model="id_lahan_variabel" class="w-full text-sm rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-200 focus:ring-accent focus:border-accent" required>
                                <option value="">Pilih Variabel</option>
                                @foreach($variabels as $variabel)
                                    <option value="{{ $variabel->id }}">{{ $variabel->nama }} ({{ $variabel->satuan }})</option>
                                @endforeach
                            </select>
                            @error('id_lahan_variabel') <span class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Klasifikasi</label>
                            <select wire:model="id_lahan_klasifikasi" class="w-full text-sm rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-200 focus:ring-accent focus:border-accent" required>
                                <option value="">Pilih Klasifikasi</option>
                                @foreach($klasifikasis as $klasifikasi)
                                    <option value="{{ $klasifikasi->id }}">{{ $klasifikasi->nama }}</option>
                                @endforeach
                            </select>
                            @error('id_lahan_klasifikasi') <span class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <flux:input wire:model="wilayah" label="Wilayah" placeholder="Masukkan nama wilayah" required />
                        @error('wilayah') <span class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</span> @enderror

                        <flux:input wire:model="tahun" label="Tahun" type="number" placeholder="2024" min="2000" max="2030" required />
                        @error('tahun') <span class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</span> @enderror

                        <flux:input wire:model="nilai" label="Nilai" type="number" step="0.01" placeholder="0.00" required />
                        @error('nilai') <span class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</span> @enderror

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Status</label>
                            <select wire:model="status" class="w-full text-sm rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-200 focus:ring-accent focus:border-accent" required>
                                <option value="">Pilih Status</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                                <option value="Dalam Proses">Dalam Proses</option>
                                <option value="Selesai">Selesai</option>
                                <option value="Tertunda">Tertunda</option>
                            </select>
                            @error('status') <span class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 mt-6">
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
                <h3 class="text-lg font-medium text-neutral-900 dark:text-white mt-2">Hapus Data Lahan</h3>
                <div class="mt-2">
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">
                        Apakah Anda yakin ingin menghapus data lahan <strong>{{ $deletingLahan->lahanTopik->nama ?? '' }}</strong> di wilayah <strong>{{ $deletingLahan->wilayah ?? '' }}</strong>?
                        <br>Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
                <div class="flex justify-center space-x-3 mt-6">
                    <flux:button type="button" wire:click="closeDeleteModal" variant="ghost">
                        Batal
                    </flux:button>
                    <flux:button wire:click="deleteLahan" variant="danger">
                        Hapus
                    </flux:button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
