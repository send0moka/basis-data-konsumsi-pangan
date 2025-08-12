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
                            Tahun
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Kelompok BPS
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Komoditi BPS
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Konsumsi Kuantitas
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-neutral-900 divide-y divide-neutral-200 dark:divide-neutral-700">
                    @forelse($susenas as $item)
                        <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-neutral-900 dark:text-neutral-100">
                                {{ $item->tahun }}
                            </td>
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
                                {{ number_format($item->konsumsi_kuantity, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-3">
                                    <button wire:click="edit({{ $item->id }})"
                                        class="text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <button wire:click="confirmDelete({{ $item->id }})"
                                        class="text-red-600 hover:text-red-500 dark:text-red-400 dark:hover:text-red-300 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-neutral-500 dark:text-neutral-400">
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

    <!-- Modal for Create/Edit -->
    <flux:modal name="formModal" wire:model="showModal">
        <div class="p-6">
            <h3 class="text-lg font-medium text-neutral-900 dark:text-white mb-4">
                {{ $editingId ? 'Edit Data Susenas' : 'Tambah Data Susenas' }}
            </h3>
            
            <form wire:submit="save">
                <div class="space-y-4">
                    <flux:field>
                        <flux:label>Tahun <span class="text-red-500">*</span></flux:label>
                        <flux:input type="number" wire:model="tahun" min="1900" max="2100" placeholder="Masukkan tahun" />
                        <flux:error name="tahun" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Kelompok BPS <span class="text-red-500">*</span></flux:label>
                        <flux:select wire:model.live="kd_kelompokbps" placeholder="Pilih Kelompok BPS">
                            @foreach($kelompokbps as $kelompok)
                                <option value="{{ $kelompok->kd_kelompokbps }}">
                                    {{ $kelompok->kd_kelompokbps }} - {{ $kelompok->nm_kelompokbps }}
                                </option>
                            @endforeach
                        </flux:select>
                        <flux:error name="kd_kelompokbps" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Komoditi BPS <span class="text-red-500">*</span></flux:label>
                        <flux:select wire:model="kd_komoditibps" placeholder="{{ $kd_kelompokbps ? 'Pilih Komoditi BPS' : 'Pilih kelompok BPS terlebih dahulu' }}">
                            @foreach($komoditibps as $komoditi)
                                <option value="{{ $komoditi->kd_komoditibps }}">
                                    {{ $komoditi->kd_komoditibps }} - {{ $komoditi->nm_komoditibps }}
                                </option>
                            @endforeach
                        </flux:select>
                        <flux:error name="kd_komoditibps" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Konsumsi Kuantitas <span class="text-red-500">*</span></flux:label>
                        <flux:input type="number" step="0.01" min="0" wire:model="konsumsi_kuantity" placeholder="Masukkan nilai konsumsi" />
                        <flux:error name="konsumsi_kuantity" />
                    </flux:field>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                    <flux:button type="button" variant="ghost" wire:click="closeModal">
                        Batal
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        {{ $editingId ? 'Update' : 'Simpan' }}
                    </flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    <!-- Delete Confirmation Modal -->
    <flux:modal name="deleteModal" wire:model="confirmingDeletion">
        <div class="p-6">
            <h3 class="text-lg font-medium text-neutral-900 dark:text-white mb-4">Konfirmasi Hapus</h3>
            <div class="py-4">
                <div class="text-center">
                    <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-2">
                        Apakah Anda yakin ingin menghapus data Susenas ini?
                    </p>
                    <p class="text-xs text-neutral-500 dark:text-neutral-500">
                        Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3">
                <flux:button type="button" variant="ghost" wire:click="cancelDelete">
                    Batal
                </flux:button>
                <flux:button type="button" variant="danger" wire:click="delete">
                    Hapus
                </flux:button>
            </div>
        </div>
    </flux:modal>

    @script
    <script>
        window.addEventListener('print-susenas', function () {
            window.print();
        });
    </script>
    @endscript
</div>
