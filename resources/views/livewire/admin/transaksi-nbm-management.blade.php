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
                placeholder="Cari berdasarkan kode kelompok, komoditi, tahun..."
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
                            Kode Kelompok
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Kode Komoditi
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
                                {{ $transaksi->kode_kelompok }}
                            </td>
                            <td class="px-3 py-3 text-sm text-neutral-900 dark:text-neutral-100">
                                {{ $transaksi->kode_komoditi }}
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
    <flux:modal name="createModal" wire:model="showCreateModal" style="full">
        <div class="p-6">
            <h3 class="text-lg font-medium text-neutral-900 dark:text-white mb-4">Tambah Transaksi NBM</h3>
            
            <form wire:submit.prevent="createTransaksi">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Basic Info -->
                    <div class="space-y-4 md:col-span-3">
                        <h4 class="font-medium text-neutral-900 dark:text-white border-b pb-2">Informasi Dasar</h4>
                    </div>
                    
                    <flux:field>
                        <flux:label>Kode Kelompok</flux:label>
                        <flux:select wire:model.live="kode_kelompok" placeholder="Pilih Kelompok">
                            @foreach($kelompokOptions as $kelompok)
                                <option value="{{ $kelompok['kode'] }}">{{ $kelompok['kode'] }} - {{ $kelompok['nama'] }}</option>
                            @endforeach
                        </flux:select>
                        <flux:error name="kode_kelompok" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Kode Komoditi</flux:label>
                        <flux:select wire:model="kode_komoditi" placeholder="Pilih Komoditi">
                            @foreach($komoditiOptions as $komoditi)
                                <option value="{{ $komoditi['kode'] }}">{{ $komoditi['kode'] }} - {{ $komoditi['nama'] }}</option>
                            @endforeach
                        </flux:select>
                        <flux:error name="kode_komoditi" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Tahun</flux:label>
                        <flux:input type="number" wire:model="tahun" min="1900" max="2100" />
                        <flux:error name="tahun" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Status Angka</flux:label>
                        <flux:select wire:model="status_angka">
                            <option value="tetap">Tetap</option>
                            <option value="sementara">Sementara</option>
                            <option value="sangat sementara">Sangat Sementara</option>
                        </flux:select>
                        <flux:error name="status_angka" />
                    </flux:field>

                    <!-- Production Data -->
                    <div class="space-y-4 md:col-span-3">
                        <h4 class="font-medium text-neutral-900 dark:text-white border-b pb-2">Data Produksi</h4>
                    </div>

                    <flux:field>
                        <flux:label>Masukan</flux:label>
                        <flux:input type="number" step="0.0001" wire:model="masukan" />
                        <flux:error name="masukan" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Keluaran</flux:label>
                        <flux:input type="number" step="0.0001" wire:model="keluaran" />
                        <flux:error name="keluaran" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Impor</flux:label>
                        <flux:input type="number" step="0.0001" wire:model="impor" />
                        <flux:error name="impor" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Ekspor</flux:label>
                        <flux:input type="number" step="0.0001" wire:model="ekspor" />
                        <flux:error name="ekspor" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Perubahan Stok</flux:label>
                        <flux:input type="number" step="0.0001" wire:model="perubahan_stok" />
                        <flux:error name="perubahan_stok" />
                    </flux:field>

                    <!-- Usage Data -->
                    <div class="space-y-4 md:col-span-3">
                        <h4 class="font-medium text-neutral-900 dark:text-white border-b pb-2">Data Penggunaan</h4>
                    </div>

                    <flux:field>
                        <flux:label>Pakan</flux:label>
                        <flux:input type="number" step="0.0001" wire:model="pakan" />
                        <flux:error name="pakan" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Bibit</flux:label>
                        <flux:input type="number" step="0.0001" wire:model="bibit" />
                        <flux:error name="bibit" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Makanan</flux:label>
                        <flux:input type="number" step="0.0001" wire:model="makanan" />
                        <flux:error name="makanan" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Bukan Makanan</flux:label>
                        <flux:input type="number" step="0.0001" wire:model="bukan_makanan" />
                        <flux:error name="bukan_makanan" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Tercecer</flux:label>
                        <flux:input type="number" step="0.0001" wire:model="tercecer" />
                        <flux:error name="tercecer" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Penggunaan Lain</flux:label>
                        <flux:input type="number" step="0.0001" wire:model="penggunaan_lain" />
                        <flux:error name="penggunaan_lain" />
                    </flux:field>

                    <!-- Nutrition Data -->
                    <div class="space-y-4 md:col-span-3">
                        <h4 class="font-medium text-neutral-900 dark:text-white border-b pb-2">Data Gizi</h4>
                    </div>

                    <flux:field>
                        <flux:label>Bahan Makanan</flux:label>
                        <flux:input type="number" step="0.0001" wire:model="bahan_makanan" />
                        <flux:error name="bahan_makanan" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Kg/Tahun</flux:label>
                        <flux:input type="number" step="0.0001" wire:model="kg_tahun" />
                        <flux:error name="kg_tahun" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Gram/Hari</flux:label>
                        <flux:input type="number" step="0.0001" wire:model="gram_hari" />
                        <flux:error name="gram_hari" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Kalori/Hari</flux:label>
                        <flux:input type="number" step="0.0001" wire:model="kalori_hari" />
                        <flux:error name="kalori_hari" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Protein/Hari</flux:label>
                        <flux:input type="number" step="0.0001" wire:model="protein_hari" />
                        <flux:error name="protein_hari" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Lemak/Hari</flux:label>
                        <flux:input type="number" step="0.000001" wire:model="lemak_hari" />
                        <flux:error name="lemak_hari" />
                    </flux:field>
                </div>

                <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                    <flux:button type="button" variant="ghost" wire:click="closeCreateModal">
                        Batal
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        Simpan
                    </flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    <!-- Edit Modal -->
    <flux:modal name="editModal" wire:model="showEditModal" style="full">
        <div class="p-6">
            <h3 class="text-lg font-medium text-neutral-900 dark:text-white mb-4">Edit Transaksi NBM</h3>
            
            <form wire:submit.prevent="updateTransaksi">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Basic Info -->
                    <div class="space-y-4 md:col-span-3">
                        <h4 class="font-medium text-neutral-900 dark:text-white border-b pb-2">Informasi Dasar</h4>
                    </div>
                    
                    <flux:field>
                        <flux:label>Kode Kelompok</flux:label>
                        <flux:select wire:model.live="kode_kelompok" placeholder="Pilih Kelompok">
                            @foreach($kelompokOptions as $kelompok)
                                <option value="{{ $kelompok['kode'] }}">{{ $kelompok['kode'] }} - {{ $kelompok['nama'] }}</option>
                            @endforeach
                        </flux:select>
                        <flux:error name="kode_kelompok" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Kode Komoditi</flux:label>
                        <flux:select wire:model="kode_komoditi" placeholder="Pilih Komoditi">
                            @foreach($komoditiOptions as $komoditi)
                                <option value="{{ $komoditi['kode'] }}">{{ $komoditi['kode'] }} - {{ $komoditi['nama'] }}</option>
                            @endforeach
                        </flux:select>
                        <flux:error name="kode_komoditi" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Tahun</flux:label>
                        <flux:input type="number" wire:model="tahun" min="1900" max="2100" />
                        <flux:error name="tahun" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Status Angka</flux:label>
                        <flux:select wire:model="status_angka">
                            <option value="tetap">Tetap</option>
                            <option value="sementara">Sementara</option>
                            <option value="sangat sementara">Sangat Sementara</option>
                        </flux:select>
                        <flux:error name="status_angka" />
                    </flux:field>

                    <!-- Production Data -->
                    <div class="space-y-4 md:col-span-3">
                        <h4 class="font-medium text-neutral-900 dark:text-white border-b pb-2">Data Produksi</h4>
                    </div>

                    <flux:field>
                        <flux:label>Masukan</flux:label>
                        <flux:input type="number" step="0.0001" wire:model="masukan" />
                        <flux:error name="masukan" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Keluaran</flux:label>
                        <flux:input type="number" step="0.0001" wire:model="keluaran" />
                        <flux:error name="keluaran" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Impor</flux:label>
                        <flux:input type="number" step="0.0001" wire:model="impor" />
                        <flux:error name="impor" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Ekspor</flux:label>
                        <flux:input type="number" step="0.0001" wire:model="ekspor" />
                        <flux:error name="ekspor" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Perubahan Stok</flux:label>
                        <flux:input type="number" step="0.0001" wire:model="perubahan_stok" />
                        <flux:error name="perubahan_stok" />
                    </flux:field>

                    <!-- Usage Data -->
                    <div class="space-y-4 md:col-span-3">
                        <h4 class="font-medium text-neutral-900 dark:text-white border-b pb-2">Data Penggunaan</h4>
                    </div>

                    <flux:field>
                        <flux:label>Pakan</flux:label>
                        <flux:input type="number" step="0.0001" wire:model="pakan" />
                        <flux:error name="pakan" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Bibit</flux:label>
                        <flux:input type="number" step="0.0001" wire:model="bibit" />
                        <flux:error name="bibit" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Makanan</flux:label>
                        <flux:input type="number" step="0.0001" wire:model="makanan" />
                        <flux:error name="makanan" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Bukan Makanan</flux:label>
                        <flux:input type="number" step="0.0001" wire:model="bukan_makanan" />
                        <flux:error name="bukan_makanan" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Tercecer</flux:label>
                        <flux:input type="number" step="0.0001" wire:model="tercecer" />
                        <flux:error name="tercecer" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Penggunaan Lain</flux:label>
                        <flux:input type="number" step="0.0001" wire:model="penggunaan_lain" />
                        <flux:error name="penggunaan_lain" />
                    </flux:field>

                    <!-- Nutrition Data -->
                    <div class="space-y-4 md:col-span-3">
                        <h4 class="font-medium text-neutral-900 dark:text-white border-b pb-2">Data Gizi</h4>
                    </div>

                    <flux:field>
                        <flux:label>Bahan Makanan</flux:label>
                        <flux:input type="number" step="0.0001" wire:model="bahan_makanan" />
                        <flux:error name="bahan_makanan" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Kg/Tahun</flux:label>
                        <flux:input type="number" step="0.0001" wire:model="kg_tahun" />
                        <flux:error name="kg_tahun" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Gram/Hari</flux:label>
                        <flux:input type="number" step="0.0001" wire:model="gram_hari" />
                        <flux:error name="gram_hari" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Kalori/Hari</flux:label>
                        <flux:input type="number" step="0.0001" wire:model="kalori_hari" />
                        <flux:error name="kalori_hari" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Protein/Hari</flux:label>
                        <flux:input type="number" step="0.0001" wire:model="protein_hari" />
                        <flux:error name="protein_hari" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Lemak/Hari</flux:label>
                        <flux:input type="number" step="0.000001" wire:model="lemak_hari" />
                        <flux:error name="lemak_hari" />
                    </flux:field>
                </div>

                <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                    <flux:button type="button" variant="ghost" wire:click="closeEditModal">
                        Batal
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        Update
                    </flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    <!-- Delete Modal -->
    <flux:modal name="deleteModal" wire:model="showDeleteModal">
        <div class="p-6">
            <h3 class="text-lg font-medium text-neutral-900 dark:text-white mb-4">Konfirmasi Hapus</h3>
            @if($deletingTransaksi)
                <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-4">
                    Apakah Anda yakin ingin menghapus transaksi NBM untuk kelompok 
                    <strong>{{ $deletingTransaksi->kode_kelompok }}</strong>, 
                    komoditi <strong>{{ $deletingTransaksi->kode_komoditi }}</strong>, 
                    tahun <strong>{{ $deletingTransaksi->tahun }}</strong>?
                </p>
            @endif
            <div class="flex justify-end space-x-3">
                <flux:button type="button" variant="ghost" wire:click="closeDeleteModal">
                    Batal
                </flux:button>
                <flux:button type="button" variant="danger" wire:click="deleteTransaksi">
                    Hapus
                </flux:button>
            </div>
        </div>
    </flux:modal>

    @script
    <script>
        window.addEventListener('print-transaksi-nbm', function () {
            window.print();
        });
    </script>
    @endscript
</div>
