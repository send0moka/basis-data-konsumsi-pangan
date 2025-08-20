@extends('layouts.lahan')

@section('header')
    <h2 class="font-semibold text-xl text-neutral-800 dark:text-neutral-200 leading-tight">
        {{ __('Inventaris Lahan') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Search and Filter Section -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-neutral-700">Cari</label>
                    <input type="text" name="search" id="search" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-neutral-300 rounded-md" placeholder="Cari berdasarkan ID atau lokasi...">
                </div>
                <div>
                    <label for="category" class="block text-sm font-medium text-neutral-700">Kategori</label>
                    <select id="category" name="category" class="mt-1 block w-full py-2 px-3 border border-neutral-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Semua Kategori</option>
                        <!-- Will be populated dynamically -->
                    </select>
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-neutral-700">Status</label>
                    <select id="status" name="status" class="mt-1 block w-full py-2 px-3 border border-neutral-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Semua Status</option>
                        <option value="active">Aktif</option>
                        <option value="inactive">Tidak Aktif</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm">
                        Terapkan Filter
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-white dark:bg-zinc-900 overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-medium text-neutral-900 dark:text-neutral-100">Daftar Inventaris Lahan</h3>
                    <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Tambah Lahan Baru
                    </button>
                </div>

                <!-- Inventory Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-neutral-200">
                        <thead class="bg-neutral-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                    ID Lahan
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                    Lokasi
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                    Kategori
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                    Luas (Ha)
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                    Terakhir Diperbarui
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Aksi</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-neutral-200">
                            <!-- Example row -->
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-neutral-900">
                                    LHN-001
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">
                                    Kecamatan Banyumanik
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">
                                    Lahan Pertanian
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">
                                    2.5
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Aktif
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">
                                    2025-08-20
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button type="button" class="text-indigo-600 hover:text-indigo-900 mr-3">Detail</button>
                                    <button type="button" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                                    <button type="button" class="text-red-600 hover:text-red-900">Hapus</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    <nav class="flex items-center justify-between">
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-neutral-700">
                                    Menampilkan
                                    <span class="font-medium">1</span>
                                    sampai
                                    <span class="font-medium">10</span>
                                    dari
                                    <span class="font-medium">20</span>
                                    hasil
                                </p>
                            </div>
                            <div>
                                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                                    <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-neutral-300 bg-white text-sm font-medium text-neutral-500 hover:bg-neutral-50">
                                        Sebelumnya
                                    </a>
                                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-neutral-300 bg-white text-sm font-medium text-neutral-700 hover:bg-neutral-50">
                                        1
                                    </a>
                                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-neutral-300 bg-white text-sm font-medium text-neutral-700 hover:bg-neutral-50">
                                        2
                                    </a>
                                    <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-neutral-300 bg-white text-sm font-medium text-neutral-500 hover:bg-neutral-50">
                                        Selanjutnya
                                    </a>
                                </nav>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Add/Edit Land (Hidden by default) -->
<div class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-neutral-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg leading-6 font-medium text-neutral-900" id="modal-title">
                    Tambah Lahan Baru
                </h3>
                <div class="mt-4 space-y-4">
                    <div>
                        <label for="land-id" class="block text-sm font-medium text-neutral-700">ID Lahan</label>
                        <input type="text" name="land-id" id="land-id" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-neutral-300 rounded-md">
                    </div>
                    <div>
                        <label for="location" class="block text-sm font-medium text-neutral-700">Lokasi</label>
                        <input type="text" name="location" id="location" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-neutral-300 rounded-md">
                    </div>
                    <div>
                        <label for="category" class="block text-sm font-medium text-neutral-700">Kategori</label>
                        <select id="category" name="category" class="mt-1 block w-full py-2 px-3 border border-neutral-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Pilih Kategori</option>
                            <!-- Will be populated dynamically -->
                        </select>
                    </div>
                    <div>
                        <label for="area" class="block text-sm font-medium text-neutral-700">Luas (Ha)</label>
                        <input type="number" step="0.01" name="area" id="area" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-neutral-300 rounded-md">
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-neutral-700">Status</label>
                        <select id="status" name="status" class="mt-1 block w-full py-2 px-3 border border-neutral-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="active">Aktif</option>
                            <option value="inactive">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="bg-neutral-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Simpan
                </button>
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-neutral-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-neutral-700 hover:bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // JavaScript for handling modal and CRUD operations will be implemented here
</script>
@endpush
