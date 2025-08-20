@extends('layouts.benih-pupuk')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-neutral-800 dark:text-neutral-200">
            {{ __('Data Benih & Pupuk') }}
        </h2>
        <div class="flex space-x-2">
            <button type="button" class="btn btn-primary">
                <i class="fas fa-plus mr-2"></i>Tambah Data
            </button>
            <button type="button" class="btn btn-secondary">
                <i class="fas fa-download mr-2"></i>Ekspor
            </button>
        </div>
    </div>
@endsection

@section('content')
<div class="py-6">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Filters -->
        <div class="card mb-6">
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="form-label">Jenis</label>
                        <select class="form-select">
                            <option>Semua Jenis</option>
                            <option>Benih</option>
                            <option>Pupuk</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Kategori</label>
                        <select class="form-select">
                            <option>Semua Kategori</option>
                            <option>Padi</option>
                            <option>Jagung</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Status Stok</label>
                        <select class="form-select">
                            <option>Semua Status</option>
                            <option>Tersedia</option>
                            <option>Hampir Habis</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="button" class="btn btn-primary w-full">
                            <i class="fas fa-filter mr-2"></i>Filter
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="card">
            <div class="card-body p-0">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Produk
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Jenis
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Stok
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @for($i = 1; $i <= 5; $i++)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-green-100 dark:bg-green-900 rounded-md flex items-center justify-center">
                                            <i class="fas fa-seedling text-green-600 dark:text-green-400"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                Benih Padi IR{{ $i }}6
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                BP-00{{ $i }}23
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        Benih
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">{{ $i * 125 }} kg</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Tersedia</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="#" class="text-blue-600 hover:text-blue-900 mr-3">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="px-6 py-4 flex items-center justify-between border-t border-gray-200 dark:border-gray-700">
                    <div class="text-sm text-gray-700 dark:text-gray-300">
                        Menampilkan <span class="font-medium">1</span> sampai <span class="font-medium">5</span> dari <span class="font-medium">24</span> hasil
                    </div>
                    <div class="flex space-x-2">
                        <button class="btn btn-sm btn-outline" disabled>
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="btn btn-sm btn-primary">1</button>
                        <button class="btn btn-sm btn-outline">2</button>
                        <button class="btn btn-sm btn-outline">3</button>
                        <button class="btn btn-sm btn-outline">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
