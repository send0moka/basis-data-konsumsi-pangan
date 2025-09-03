<div>
    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-md shadow-lg z-50">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-md shadow-lg z-50">
            {{ session('error') }}
        </div>
    @endif

    <!-- Header -->
    <div class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-neutral-900 dark:text-white">Data Daftar Alamat</h1>
                <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">
                    Kelola data alamat dinas pertanian seluruh Indonesia
                </p>
            </div>
            <div class="mt-4 sm:mt-0">
                <button wire:click="create"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                        </path>
                    </svg>
                    Tambah Alamat
                </button>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div
        class="bg-white dark:!bg-neutral-800 rounded-lg shadow-sm border border-neutral-200 dark:border-neutral-700 p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <div class="relative">
                    <input wire:model.live.debounce.300ms="search" placeholder="Cari alamat..."
                        class="w-full pl-10 pr-4 py-2 text-sm rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent" />
                    <svg class="absolute left-3 top-2.5 w-4 h-4 text-neutral-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607z">
                        </path>
                    </svg>
                </div>
            </div>
            <div>
                <select wire:model.live="statusFilter"
                    class="w-full text-sm rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent">
                    <option value="">Semua Status</option>
                    @foreach ($statusOptions as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select wire:model.live="wilayahFilter"
                    class="w-full text-sm rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent">
                    <option value="">Semua Wilayah</option>
                    @foreach ($wilayahOptions as $wilayah)
                        <option value="{{ $wilayah }}">{{ $wilayah }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mt-4 flex justify-between items-center">
            <button wire:click="resetFilters"
                class="px-3 py-1.5 text-sm text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-neutral-200 transition-colors">
                Reset Filter
            </button>
            <div class="flex items-center space-x-2">
                <span class="text-sm text-neutral-600 dark:text-neutral-400">Per halaman:</span>
                <select wire:model.live="perPage"
                    class="text-sm rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-200 focus:ring-accent focus:border-accent">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div
        class="bg-white dark:!bg-neutral-800 rounded-lg shadow-sm border border-neutral-200 dark:border-neutral-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                <thead class="bg-neutral-50 dark:bg-neutral-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider cursor-pointer hover:text-neutral-700 dark:hover:text-neutral-200 transition-colors"
                            wire:click="sortByField('id')">
                            <div class="flex items-center space-x-1">
                                <span>ID</span>
                                @if ($sortBy === 'id')
                                    @if ($sortDirection === 'asc')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 15l7-7 7 7"></path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    @endif
                                @else
                                    <svg class="w-4 h-4 text-neutral-300 dark:text-neutral-600" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider cursor-pointer hover:text-neutral-700 dark:hover:text-neutral-200 transition-colors"
                            wire:click="sortByField('provinsi')">
                            <div class="flex items-center space-x-1">
                                <span>Provinsi</span>
                                @if ($sortBy === 'provinsi')
                                    @if ($sortDirection === 'asc')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 15l7-7 7 7"></path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    @endif
                                @else
                                    <svg class="w-4 h-4 text-neutral-300 dark:text-neutral-600" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider cursor-pointer hover:text-neutral-700 dark:hover:text-neutral-200 transition-colors"
                            wire:click="sortByField('kabupaten_kota')">
                            <div class="flex items-center space-x-1">
                                <span>Kabupaten/Kota</span>
                                @if ($sortBy === 'kabupaten_kota')
                                    @if ($sortDirection === 'asc')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 15l7-7 7 7"></path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    @endif
                                @else
                                    <svg class="w-4 h-4 text-neutral-300 dark:text-neutral-600" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Gambar
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider cursor-pointer hover:text-neutral-700 dark:hover:text-neutral-200 transition-colors"
                            wire:click="sortByField('nama_dinas')">
                            <div class="flex items-center space-x-1">
                                <span>Nama Dinas</span>
                                @if ($sortBy === 'nama_dinas')
                                    @if ($sortDirection === 'asc')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 15l7-7 7 7"></path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    @endif
                                @else
                                    <svg class="w-4 h-4 text-neutral-300 dark:text-neutral-600" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider cursor-pointer hover:text-neutral-700 dark:hover:text-neutral-200 transition-colors"
                            wire:click="sortByField('email')">
                            <div class="flex items-center space-x-1">
                                <span>Kontak (email)</span>
                                @if ($sortBy === 'email')
                                    @if ($sortDirection === 'asc')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 15l7-7 7 7"></path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    @endif
                                @else
                                    <svg class="w-4 h-4 text-neutral-300 dark:text-neutral-600" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider cursor-pointer hover:text-neutral-700 dark:hover:text-neutral-200 transition-colors"
                            wire:click="sortByField('status')">
                            <div class="flex items-center space-x-1">
                                <span>Status</span>
                                @if ($sortBy === 'status')
                                    @if ($sortDirection === 'asc')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 15l7-7 7 7"></path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    @endif
                                @else
                                    <svg class="w-4 h-4 text-neutral-300 dark:text-neutral-600" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider cursor-pointer hover:text-neutral-700 dark:hover:text-neutral-200 transition-colors"
                            wire:click="sortByField('latitude')">
                            <div class="flex items-center space-x-1">
                                <span>Koordinat</span>
                                @if ($sortBy === 'latitude')
                                    @if ($sortDirection === 'asc')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 15l7-7 7 7"></path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    @endif
                                @else
                                    <svg class="w-4 h-4 text-neutral-300 dark:text-neutral-600" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th
                            class="px-6 py-3 text-right text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:!bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
                    @forelse($alamats as $alamat)
                        <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-700">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-white">
                                {{ $alamat->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-white">
                                {{ $alamat->provinsi }}
                            </td>
                            <td class="px-6 py-4 text-sm text-neutral-900 dark:text-white">
                                <div class="max-w-xs truncate">{{ $alamat->kabupaten_kota }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($alamat->gambar)
                                    <img src="{{ $alamat->gambar_url }}" alt="Gambar {{ $alamat->nama_dinas }}"
                                        class="w-12 h-12 object-cover rounded-lg shadow-sm">
                                @else
                                    <div
                                        class="w-12 h-12 bg-neutral-100 dark:bg-neutral-700 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-neutral-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-neutral-900 dark:text-white">
                                <div class="max-w-xs">
                                    <div class="font-medium truncate">{{ $alamat->nama_dinas }}</div>
                                    <div class="text-neutral-500 dark:text-neutral-400 truncate">
                                        {{ $alamat->alamat }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-neutral-500 dark:text-neutral-400">
                                <div class="space-y-1">
                                    @if ($alamat->telp)
                                        <div class="flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                            <span class="truncate">{{ $alamat->telp }}</span>
                                        </div>
                                    @endif
                                    @if ($alamat->email)
                                        <div class="flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            <span class="truncate">{{ $alamat->email }}</span>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $alamat->status_badge }}">
                                    {{ $alamat->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">
                                @if ($alamat->has_coordinates)
                                    <span class="inline-flex items-center text-green-600 dark:text-green-400">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Ada
                                    </span>
                                @else
                                    <span class="inline-flex items-center text-neutral-400">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Tidak Ada
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <button wire:click="edit({{ $alamat->id }})"
                                        class="inline-flex items-center px-2 py-1 text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                        Edit
                                    </button>
                                    <button wire:click="delete({{ $alamat->id }})"
                                        wire:confirm="Yakin ingin menghapus data ini?"
                                        class="inline-flex items-center px-2 py-1 text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-neutral-500 dark:text-neutral-400">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 mb-4 text-neutral-300 dark:text-neutral-600" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-lg font-medium">Tidak ada data ditemukan</p>
                                    <p class="text-sm">Coba ubah filter atau tambah data baru</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($alamats->hasPages())
            <div class="px-6 py-3 border-t border-neutral-200 dark:border-neutral-700">
                {{ $alamats->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Form -->
    @if ($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <!-- Backdrop -->
            <div class="fixed inset-0 transition-opacity" style="background-color: rgba(0, 0, 0, 0.5);"
                aria-hidden="true" wire:click="$set('showModal', false)"></div>

            <!-- Modal container -->
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="relative inline-block align-bottom bg-white dark:bg-neutral-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full z-10">
                    <form id="alamat-form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="modal-mode" value="{{ $modalMode }}">
                        <input type="hidden" id="selected-id" value="{{ $selectedId }}">
                        <div class="bg-white dark:bg-neutral-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-medium text-neutral-900 dark:text-white" id="modal-title">
                                    {{ $modalMode === 'create' ? 'Tambah Alamat Baru' : 'Edit Alamat' }}
                                </h3>
                                <button type="button" wire:click="$set('showModal', false)"
                                    class="text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Provinsi
                                            *</label>
                                        <div class="relative">
                                            <select wire:model.live="provinsi" wire:change="validateProvinsi"
                                                class="w-full px-3 py-2 text-sm rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent {{ $provinsiValidationError ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}">
                                                <option value="">Pilih Provinsi</option>
                                                <option value="Aceh">Aceh</option>
                                                <option value="Sumatera Utara">Sumatera Utara</option>
                                                <option value="Sumatera Barat">Sumatera Barat</option>
                                                <option value="Riau">Riau</option>
                                                <option value="Kepulauan Riau">Kepulauan Riau</option>
                                                <option value="Jambi">Jambi</option>
                                                <option value="Sumatera Selatan">Sumatera Selatan</option>
                                                <option value="Bengkulu">Bengkulu</option>
                                                <option value="Lampung">Lampung</option>
                                                <option value="Kepulauan Bangka Belitung">Kepulauan Bangka Belitung
                                                </option>
                                                <option value="Daerah Khusus Jakarta">Daerah Khusus Jakarta
                                                </option>
                                                <option value="Jawa Barat">Jawa Barat</option>
                                                <option value="Jawa Tengah">Jawa Tengah</option>
                                                <option value="Daerah Istimewa Yogyakarta">Daerah Istimewa
                                                    Yogyakarta</option>
                                                <option value="Jawa Timur">Jawa Timur</option>
                                                <option value="Banten">Banten</option>
                                                <option value="Bali">Bali</option>
                                                <option value="Nusa Tenggara Barat">Nusa Tenggara Barat</option>
                                                <option value="Nusa Tenggara Timur">Nusa Tenggara Timur</option>
                                                <option value="Kalimantan Barat">Kalimantan Barat</option>
                                                <option value="Kalimantan Tengah">Kalimantan Tengah</option>
                                                <option value="Kalimantan Selatan">Kalimantan Selatan</option>
                                                <option value="Kalimantan Timur">Kalimantan Timur</option>
                                                <option value="Kalimantan Utara">Kalimantan Utara</option>
                                                <option value="Sulawesi Utara">Sulawesi Utara</option>
                                                <option value="Sulawesi Tengah">Sulawesi Tengah</option>
                                                <option value="Sulawesi Selatan">Sulawesi Selatan</option>
                                                <option value="Sulawesi Tenggara">Sulawesi Tenggara</option>
                                                <option value="Gorontalo">Gorontalo</option>
                                                <option value="Sulawesi Barat">Sulawesi Barat</option>
                                                <option value="Maluku">Maluku</option>
                                                <option value="Maluku Utara">Maluku Utara</option>
                                                <option value="Papua Barat">Papua Barat</option>
                                                <option value="Papua Barat Daya">Papua Barat Daya</option>
                                                <option value="Papua Selatan">Papua Selatan</option>
                                                <option value="Papua Tengah">Papua Tengah</option>
                                                <option value="Papua">Papua</option>
                                                <option value="Papua Pegunungan">Papua Pegunungan</option>
                                            </select>
                                            @if ($provinsiValidationError)
                                                <div
                                                    class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                    <svg class="h-5 w-5 text-red-500" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        @error('provinsi')
                                            <span
                                                class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</span>
                                        @enderror
                                        @if ($provinsiValidationError)
                                            <span
                                                class="text-red-500 dark:text-red-400 text-sm">{{ $provinsiValidationError }}</span>
                                        @endif
                                    </div>

                                    <div>
                                        <label
                                            class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                                            Kabupaten/Kota *
                                            <span wire:loading wire:target="provinsi"
                                                class="text-accent font-normal text-xs ml-1">(Memproses...)</span>
                                        </label>
                                        <div class="relative">
                                            <select wire:model.live="kabupaten_kota"
                                                wire:change="validateKabupatenKota"
                                                class="w-full px-3 py-2 text-sm rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent {{ !$provinsi ? 'opacity-50 cursor-not-allowed' : '' }} {{ $kabupatenValidationError ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}"
                                                wire:loading.class="opacity-50 cursor-not-allowed"
                                                wire:target="provinsi" {{ !$provinsi ? 'disabled' : '' }}
                                                wire:loading.attr="disabled" wire:target="provinsi">

                                                <option value="" wire:loading.remove wire:target="provinsi">
                                                    {{ $provinsi ? 'Pilih Kabupaten/Kota' : 'Pilih provinsi terlebih dahulu' }}
                                                </option>
                                                <option value="" wire:loading wire:target="provinsi">Memuat
                                                    data kabupaten/kota...</option>

                                                @if ($provinsi)
                                                    <div wire:loading.remove wire:target="provinsi">
                                                        @php
                                                            $kabupatenOptions = $this->getKabupatenByProvinsi(
                                                                $provinsi,
                                                            );
                                                        @endphp
                                                        @foreach ($kabupatenOptions as $kabupaten)
                                                            <option value="{{ $kabupaten }}">
                                                                {{ $kabupaten }}</option>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </select>

                                            <!-- Loading Spinner when province is changing -->
                                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none"
                                                wire:loading wire:target="provinsi">
                                                <svg class="animate-spin h-5 w-5 text-accent" fill="none"
                                                    viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                                        stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor"
                                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                    </path>
                                                </svg>
                                            </div>

                                            <!-- Error icon when not loading -->
                                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none"
                                                wire:loading.remove wire:target="provinsi">
                                                @if ($kabupatenValidationError)
                                                    <svg class="h-5 w-5 text-red-500" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                @endif
                                            </div>
                                        </div>
                                        @error('kabupaten_kota')
                                            <span
                                                class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</span>
                                        @enderror
                                        @if ($kabupatenValidationError)
                                            <span
                                                class="text-red-500 dark:text-red-400 text-sm">{{ $kabupatenValidationError }}</span>
                                        @endif
                                    </div>

                                    <div class="md:col-span-2">
                                        <label
                                            class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Nama
                                            Dinas *</label>
                                        <input wire:model="nama_dinas" placeholder="Nama lengkap dinas"
                                            class="w-full px-3 py-2 text-sm rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent" />
                                        @error('nama_dinas')
                                            <span
                                                class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="md:col-span-2">
                                        <label
                                            class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Alamat
                                            *</label>
                                        <textarea wire:model="alamat" placeholder="Alamat lengkap" rows="3"
                                            class="w-full px-3 py-2 text-sm rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent"></textarea>
                                        @error('alamat')
                                            <span
                                                class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label
                                            class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Telepon</label>
                                        <input wire:model="telp" placeholder="Nomor telepon"
                                            class="w-full px-3 py-2 text-sm rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent" />
                                        @error('telp')
                                            <span
                                                class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label
                                            class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Email</label>
                                        <input wire:model="email" type="email" placeholder="Alamat email"
                                            class="w-full px-3 py-2 text-sm rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent" />
                                        @error('email')
                                            <span
                                                class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label
                                            class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Website</label>
                                        <input wire:model="website" type="url" placeholder="URL website"
                                            class="w-full px-3 py-2 text-sm rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent" />
                                        @error('website')
                                            <span
                                                class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label
                                            class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Status
                                            *</label>
                                        <select wire:model="status"
                                            class="w-full px-3 py-2 text-sm rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent">
                                            @foreach ($statusOptions as $value => $label)
                                                <option value="{{ $value }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        @error('status')
                                            <span
                                                class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Location Map Section -->
                                    <div class="md:col-span-2">
                                        <label
                                            class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Lokasi</label>

                                        <!-- Get Current Location Button -->
                                        <div class="mb-3">
                                            <button type="button" id="get-current-location"
                                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-blue-500 dark:hover:bg-blue-600">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                Gunakan Lokasi Saat Ini
                                            </button>
                                        </div>

                                        <!-- Map Container -->
                                        <div id="location-map"
                                            class="w-full h-80 border border-neutral-300 dark:border-neutral-600 rounded-lg mb-3">
                                        </div>

                                        <!-- Coordinates Display -->
                                        <div class="grid grid-cols-2 gap-4 text-sm">
                                            <div class="flex items-center">
                                                <span
                                                    class="font-medium text-neutral-700 dark:text-neutral-300 mr-2">Latitude:</span>
                                                <span id="current-latitude"
                                                    class="text-blue-600 dark:text-blue-400 font-mono">-</span>
                                            </div>
                                            <div class="flex items-center">
                                                <span
                                                    class="font-medium text-neutral-700 dark:text-neutral-300 mr-2">Longitude:</span>
                                                <span id="current-longitude"
                                                    class="text-blue-600 dark:text-blue-400 font-mono">-</span>
                                            </div>
                                        </div>

                                        <!-- Hidden inputs for Livewire -->
                                        <input type="hidden" wire:model="latitude" id="latitude-input">
                                        <input type="hidden" wire:model="longitude" id="longitude-input">

                                        @error('latitude')
                                            <span class="text-red-500 dark:text-red-400 text-sm">Latitude
                                                diperlukan</span>
                                        @enderror
                                        @error('longitude')
                                            <span class="text-red-500 dark:text-red-400 text-sm">Longitude
                                                diperlukan</span>
                                        @enderror
                                    </div>

                                    <!-- Image Upload Section -->
                                    <div class="md:col-span-2">
                                        <label
                                            class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Gambar</label>

                                        <!-- File Input -->
                                        <div class="mt-1">
                                            <input id="gambar-upload" type="file" accept="image/*"
                                                class="w-full text-sm rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-200 focus:ring-accent focus:border-accent file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900 dark:file:text-blue-300"
                                                onchange="previewImage(this)" />
                                            @error('gambar')
                                                <span
                                                    class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Image Preview -->
                                        <div id="image-preview" class="mt-4 hidden">
                                            <p class="text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                                Preview:</p>
                                            <div
                                                class="border-2 border-dashed border-neutral-300 dark:border-neutral-600 rounded-lg p-4">
                                                <img id="preview-img" src="" alt="Preview"
                                                    class="max-w-full h-auto max-h-48 mx-auto rounded-lg shadow-sm">
                                            </div>
                                        </div>

                                        <!-- Existing Image -->
                                        @if ($existingGambar)
                                            <div class="mt-4" id="existing-image">
                                                <p
                                                    class="text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                                    Gambar Saat Ini:</p>
                                                <div class="relative inline-block">
                                                    <img src="{{ asset('storage/' . $existingGambar) }}"
                                                        alt="Existing Image"
                                                        class="max-w-full h-auto max-h-48 rounded-lg shadow-sm">
                                                    <button wire:click="deleteImage" type="button"
                                                        wire:confirm="Apakah Anda yakin ingin menghapus gambar ini?"
                                                        class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1 shadow-lg">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        @endif

                                        <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                                            Format yang didukung: JPEG, PNG, JPG, GIF, SVG. Maksimal 2MB.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="bg-neutral-50 dark:bg-neutral-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="button" onclick="submitForm()" id="submit-btn"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                                    <span
                                        id="submit-text">{{ $modalMode === 'create' ? 'Simpan' : 'Perbarui' }}</span>
                                    <span id="loading-text" class="hidden">
                                        <div class="flex items-center">
                                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                            {{ $modalMode === 'create' ? 'Menyimpan...' : 'Memperbarui...' }}
                                        </div>
                                    </span>
                                </button>
                                <button type="button" wire:click="$set('showModal', false)"
                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-neutral-300 dark:border-neutral-600 shadow-sm px-4 py-2 bg-white dark:bg-neutral-800 text-base font-medium text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-neutral-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    Batal
                                </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            // Load Leaflet CSS and JS dynamically
            function loadLeaflet() {
                return new Promise((resolve, reject) => {
                    // Check if Leaflet is already loaded
                    if (window.L) {
                        resolve();
                        return;
                    }

                    // Load CSS
                    const link = document.createElement('link');
                    link.rel = 'stylesheet';
                    link.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
                    link.integrity = 'sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=';
                    link.crossOrigin = '';
                    document.head.appendChild(link);

                    // Load JS
                    const script = document.createElement('script');
                    script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
                    script.integrity = 'sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=';
                    script.crossOrigin = '';
                    script.onload = () => {
                        // Add custom styles
                        const style = document.createElement('style');
                        style.textContent = `
                        .crosshair {
                            z-index: 1000;
                        }
                        
                        .dark .leaflet-popup-content-wrapper,
                        .dark .leaflet-popup-tip {
                            background: #374151;
                            color: #f3f4f6;
                        }
                        
                        .dark .leaflet-container {
                            background: #1f2937;
                        }
                        
                        .animate-spin {
                            animation: spin 1s linear infinite;
                        }
                        
                        @keyframes spin {
                            from { transform: rotate(0deg); }
                            to { transform: rotate(360deg); }
                        }
                    `;
                        document.head.appendChild(style);
                        resolve();
                    };
                    script.onerror = reject;
                    document.head.appendChild(script);
                });
            }

            function previewImage(input) {
                const preview = document.getElementById('image-preview');
                const previewImg = document.getElementById('preview-img');
                const existingImage = document.getElementById('existing-image');

                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        preview.classList.remove('hidden');
                        if (existingImage) {
                            existingImage.style.display = 'none';
                        }
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            // Leaflet Map Implementation
            let map;
            let marker;
            const defaultLat = -2.5489; // Indonesia center
            const defaultLng = 118.0149;

            // Initialize map when modal is opened
            function initializeMap() {
                // Load Leaflet first
                loadLeaflet().then(() => {
                    // Wait for the map container to be visible
                    setTimeout(() => {
                        if (document.getElementById('location-map')) {
                            // Remove existing map if any
                            if (map) {
                                map.remove();
                            }

                            // Initialize map
                            map = L.map('location-map').setView([defaultLat, defaultLng], 5);

                            // Add OpenStreetMap tiles
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '© OpenStreetMap contributors'
                            }).addTo(map);

                            // Add center crosshair
                            const crosshairIcon = L.divIcon({
                                className: 'crosshair',
                                iconSize: [20, 20],
                                iconAnchor: [10, 10],
                                html: '<div style="width: 20px; height: 20px; position: relative;"><div style="position: absolute; top: 50%; left: 0; right: 0; height: 2px; background: #e74c3c; transform: translateY(-50%);"></div><div style="position: absolute; left: 50%; top: 0; bottom: 0; width: 2px; background: #e74c3c; transform: translateX(-50%);"></div><div style="position: absolute; top: 50%; left: 50%; width: 8px; height: 8px; background: #e74c3c; border: 2px solid white; border-radius: 50%; transform: translate(-50%, -50%);"></div></div>'
                            });

                            // Add fixed center marker
                            const centerMarker = L.marker([defaultLat, defaultLng], {
                                icon: crosshairIcon,
                                interactive: false
                            }).addTo(map);

                            // Update coordinates when map moves
                            map.on('move', function() {
                                const center = map.getCenter();
                                updateCoordinates(center.lat, center.lng);
                                centerMarker.setLatLng(center);
                            });

                            // Initialize coordinates display
                            updateCoordinates(defaultLat, defaultLng);

                            // Check if there are existing coordinates from edit mode
                            const existingLat = document.getElementById('latitude-input').value;
                            const existingLng = document.getElementById('longitude-input').value;

                            if (existingLat && existingLng && existingLat !== '' && existingLng !== '') {
                                const lat = parseFloat(existingLat);
                                const lng = parseFloat(existingLng);
                                map.setView([lat, lng], 15);
                                updateCoordinates(lat, lng);
                            }
                        }
                    }, 100);
                }).catch(error => {
                    console.error('Failed to load Leaflet:', error);
                });
            }

            // Update coordinate displays and hidden inputs
            function updateCoordinates(lat, lng) {
                document.getElementById('current-latitude').textContent = lat.toFixed(6);
                document.getElementById('current-longitude').textContent = lng.toFixed(6);
                document.getElementById('latitude-input').value = lat.toFixed(6);
                document.getElementById('longitude-input').value = lng.toFixed(6);

                // Trigger Livewire update
                @this.set('latitude', lat.toFixed(6));
                @this.set('longitude', lng.toFixed(6));
            }

            // Get current location
            document.addEventListener('click', function(e) {
                if (e.target.id === 'get-current-location' || e.target.closest('#get-current-location')) {
                    e.preventDefault();

                    if (!navigator.geolocation) {
                        alert('Geolocation tidak didukung oleh browser ini.');
                        return;
                    }

                    const button = document.getElementById('get-current-location');
                    const originalText = button.innerHTML;

                    // Show loading state
                    button.innerHTML =
                        '<svg class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Mengambil lokasi...';
                    button.disabled = true;

                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            const lat = position.coords.latitude;
                            const lng = position.coords.longitude;

                            if (map) {
                                map.setView([lat, lng], 15);
                                updateCoordinates(lat, lng);
                            }

                            // Restore button
                            button.innerHTML = originalText;
                            button.disabled = false;
                        },
                        function(error) {
                            let message = 'Gagal mendapatkan lokasi. ';
                            switch (error.code) {
                                case error.PERMISSION_DENIED:
                                    message += 'Permisi akses lokasi ditolak.';
                                    break;
                                case error.POSITION_UNAVAILABLE:
                                    message += 'Informasi lokasi tidak tersedia.';
                                    break;
                                case error.TIMEOUT:
                                    message += 'Permintaan lokasi timeout.';
                                    break;
                                default:
                                    message += 'Terjadi kesalahan yang tidak diketahui.';
                                    break;
                            }
                            alert(message);

                            // Restore button
                            button.innerHTML = originalText;
                            button.disabled = false;
                        }, {
                            enableHighAccuracy: true,
                            timeout: 10000,
                            maximumAge: 60000
                        }
                    );
                }
            });

            // Initialize map when modal opens
            document.addEventListener('livewire:init', function() {
                Livewire.hook('morph.updated', () => {
                    if (document.getElementById('location-map')) {
                        initializeMap();
                    }
                });

                // Listen for map initialization event
                Livewire.on('initializeMap', () => {
                    setTimeout(() => {
                        initializeMap();
                    }, 200);
                });
            });

            function submitForm() {
                const form = document.getElementById('alamat-form');
                const submitBtn = document.getElementById('submit-btn');
                const submitText = document.getElementById('submit-text');
                const loadingText = document.getElementById('loading-text');

                // Show loading state
                submitBtn.disabled = true;
                submitText.classList.add('hidden');
                loadingText.classList.remove('hidden');

                const formData = new FormData();
                const modalMode = document.getElementById('modal-mode').value;
                const selectedId = document.getElementById('selected-id').value;

                // Add all form fields manually
                formData.append('provinsi', document.querySelector('select[wire\\:model="provinsi"]').value || '');
                formData.append('kabupaten_kota', document.querySelector('select[wire\\:model="kabupaten_kota"]').value || '');
                formData.append('nama_dinas', document.querySelector('input[wire\\:model="nama_dinas"]').value || '');
                formData.append('alamat', document.querySelector('textarea[wire\\:model="alamat"]').value || '');
                formData.append('telp', document.querySelector('input[wire\\:model="telp"]').value || '');
                formData.append('email', document.querySelector('input[wire\\:model="email"]').value || '');
                formData.append('website', document.querySelector('input[wire\\:model="website"]').value || '');
                formData.append('status', document.querySelector('select[wire\\:model="status"]').value || '');
                formData.append('latitude', document.querySelector('input[wire\\:model="latitude"]').value || '');
                formData.append('longitude', document.querySelector('input[wire\\:model="longitude"]').value || '');

                // Handle file upload with base64 encoding to bypass PHP temp file issues
                const fileInput = document.getElementById('gambar-upload');

                if (fileInput && fileInput.files[0]) {
                    const file = fileInput.files[0];

                    if (file.type.startsWith('image/') && file.size <= 2048000) {
                        // Convert to base64 to bypass PHP temp file system
                        const reader = new FileReader();
                        reader.onload = function(e) {

                            formData.append('gambar_base64', e.target.result);
                            formData.append('gambar_name', file.name);
                            formData.append('gambar_type', file.type);

                            // Submit form after file is read
                            submitFormData(formData);
                        };
                        reader.onerror = function(e) {
                            console.error('FileReader error:', e);
                            submitFormData(formData); // Submit without image
                        };
                        reader.readAsDataURL(file);
                        return; // Exit here, will continue in reader.onload
                    }
                }

                // Submit form without file
                submitFormData(formData);
            }

            function submitFormData(formData) {
                const submitBtn = document.getElementById('submit-btn');
                const submitText = document.getElementById('submit-text');
                const loadingText = document.getElementById('loading-text');
                const modalMode = document.getElementById('modal-mode').value;
                const selectedId = document.getElementById('selected-id').value;

                // Add mode and ID to formData
                formData.append('mode', modalMode);
                if (selectedId) {
                    formData.append('id', selectedId);
                }


                fetch('{{ route('admin.daftar-alamat.save') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        const contentType = response.headers.get('content-type');
                        if (!contentType || !contentType.includes('application/json')) {
                            return response.text().then(text => {
                                console.error('Server returned non-JSON response:', text);
                                // Try to extract JSON from mixed content
                                const jsonMatch = text.match(/\{.*\}$/);
                                if (jsonMatch) {
                                    try {
                                        return JSON.parse(jsonMatch[0]);
                                    } catch (e) {
                                        throw new Error('Server returned HTML instead of JSON. Check server logs.');
                                    }
                                }
                                throw new Error('Server returned HTML instead of JSON. Check server logs.');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Close modal and refresh
                            @this.set('showModal', false);
                            @this.$refresh();

                            // Show success message
                            const message = document.createElement('div');
                            message.className =
                                'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-md shadow-lg z-50';
                            message.textContent = data.message;
                            document.body.appendChild(message);
                            setTimeout(() => message.remove(), 3000);
                        } else {
                            throw new Error(data.message || 'Terjadi kesalahan');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);

                        // Show error message
                        const message = document.createElement('div');
                        message.className = 'fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-md shadow-lg z-50';
                        message.textContent = error.message || 'Terjadi kesalahan saat menyimpan data';
                        document.body.appendChild(message);
                        setTimeout(() => message.remove(), 5000);
                    })
                    .finally(() => {
                        // Reset button state
                        submitBtn.disabled = false;
                        submitText.classList.remove('hidden');
                        loadingText.classList.add('hidden');
                    });
            }
        </script>
    @endif
</div>
