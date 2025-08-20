@extends('layouts.benih-pupuk')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-neutral-800 dark:text-neutral-200">
            {{ __('Peta Distribusi Benih & Pupuk') }}
        </h2>
        <div class="flex space-x-2">
            <div class="relative">
                <select class="form-select pr-8">
                    <option>Pilih Jenis Peta</option>
                    <option>Distribusi Benih</option>
                    <option>Distribusi Pupuk</option>
                    <option>Penyebaran Stok</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-300">
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
            <button type="button" class="btn btn-primary">
                <i class="fas fa-download mr-2"></i>Ekspor Peta
            </button>
        </div>
    </div>
@endsection

@section('content')
<div class="py-6">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Map Container -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow overflow-hidden">
            <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    Peta Sebaran Distribusi Benih & Pupuk
                </h3>
                <div class="flex space-x-2">
                    <button type="button" class="btn btn-sm btn-outline">
                        <i class="fas fa-layer-group mr-1"></i> Layer
                    </button>
                    <button type="button" class="btn btn-sm btn-outline">
                        <i class="fas fa-ruler-combined mr-1"></i> Ukur
                    </button>
                    <button type="button" class="btn btn-sm btn-outline">
                        <i class="fas fa-search-location mr-1"></i> Cari Lokasi
                    </button>
                </div>
            </div>
            
            <!-- Map Placeholder -->
            <div class="h-[600px] bg-gray-100 dark:bg-zinc-900 flex items-center justify-center">
                <div class="text-center">
                    <i class="fas fa-map-marked-alt text-4xl text-gray-400 mb-2"></i>
                    <p class="text-gray-500 dark:text-gray-400">Peta akan ditampilkan di sini</p>
                </div>
            </div>
            
            <!-- Map Legend -->
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex flex-wrap items-center space-x-6">
                    <div class="flex items-center">
                        <div class="w-4 h-4 rounded-full bg-green-500 mr-2"></div>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Stok Tersedia</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 rounded-full bg-yellow-500 mr-2"></div>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Stok Menipis</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 rounded-full bg-red-500 mr-2"></div>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Stok Habis</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 rounded-full bg-blue-500 mr-2"></div>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Distribusi</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Data Table -->
        <div class="mt-6 bg-white dark:bg-zinc-800 rounded-lg shadow overflow-hidden">
            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    Daftar Titik Distribusi
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Lokasi
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Jenis
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Stok
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-zinc-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach([
                            ['name' => 'Gudang Pusat', 'type' => 'Penyimpanan', 'stock' => '1,250 kg', 'status' => 'Tersedia', 'color' => 'green'],
                            ['name' => 'Distributor A', 'type' => 'Distributor', 'stock' => '750 kg', 'status' => 'Menipis', 'color' => 'yellow'],
                            ['name' => 'Kios Tani Sejahtera', 'type' => 'Penjualan', 'stock' => '150 kg', 'status' => 'Habis', 'color' => 'red'],
                            ['name' => 'Koperasi Tani Maju', 'type' => 'Koperasi', 'stock' => '500 kg', 'status' => 'Tersedia', 'color' => 'green'],
                        ] as $location)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-{{ $location['color'] }}-100 dark:bg-{{ $location['color'] }}-900 flex items-center justify-center">
                                        <i class="fas fa-warehouse text-{{ $location['color'] }}-600 dark:text-{{ $location['color'] }}-400"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $location['name'] }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $location['type'] }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">Benih Padi</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Pupuk Organik</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">{{ $location['stock'] }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Tersedia</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $location['color'] }}-100 text-{{ $location['color'] }}-800 dark:bg-{{ $location['color'] }}-900 dark:text-{{ $location['color'] }}-200">
                                    {{ $location['status'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="#" class="text-blue-600 hover:text-blue-900 mr-3">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="#" class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-directions"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .map-container {
        height: 600px;
        width: 100%;
    }
    .legend {
        background: white;
        padding: 10px;
        border-radius: 4px;
        box-shadow: 0 1px 5px rgba(0,0,0,0.4);
    }
    .legend i {
        width: 18px;
        height: 18px;
        float: left;
        margin-right: 8px;
        opacity: 0.7;
    }
</style>
@endpush

@push('scripts')
<script>
    // Initialize map here
    document.addEventListener('DOMContentLoaded', function() {
        // Map initialization code will go here
        console.log('Map page loaded');
    });
</script>
@endpush
@endsection
