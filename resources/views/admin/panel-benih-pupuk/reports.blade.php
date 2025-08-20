@extends('layouts.benih-pupuk')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-neutral-800 dark:text-neutral-200">
            {{ __('Laporan Benih & Pupuk') }}
        </h2>
        <button type="button" class="btn btn-primary">
            <i class="fas fa-file-export mr-2"></i>Ekspor Laporan
        </button>
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
                        <label class="form-label">Jenis Laporan</label>
                        <select class="form-select">
                            <option>Pilih Jenis Laporan</option>
                            <option>Laporan Stok</option>
                            <option>Laporan Distribusi</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Periode</label>
                        <select class="form-select">
                            <option>Bulan Ini</option>
                            <option>Bulan Lalu</option>
                            <option>Tahun Ini</option>
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

        <!-- Report Summary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="card">
                <div class="card-body">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 mr-4">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Total Stok</p>
                            <p class="text-xl font-semibold">2,450 kg</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400 mr-4">
                            <i class="fas fa-truck"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Distribusi Bulan Ini</p>
                            <p class="text-xl font-semibold">1,280 kg</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-400 mr-4">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Stok Hampir Habis</p>
                            <p class="text-xl font-semibold">5 Jenis</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Table -->
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-medium">Daftar Laporan</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b dark:border-gray-700">
                            <th class="text-left py-3 px-4">Nama Laporan</th>
                            <th class="text-left py-3 px-4">Jenis</th>
                            <th class="text-left py-3 px-4">Periode</th>
                            <th class="text-right py-3 px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach([
                            ['name' => 'Laporan Stok Bulanan', 'type' => 'Stok', 'period' => 'Agustus 2023'],
                            ['name' => 'Laporan Distribusi', 'type' => 'Distribusi', 'period' => 'Juli 2023'],
                            ['name' => 'Laporan Penerimaan', 'type' => 'Penerimaan', 'period' => 'Juli 2023'],
                        ] as $report)
                        <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="py-3 px-4">{{ $report['name'] }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $report['type'] == 'Stok' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : '' }}
                                    {{ $report['type'] == 'Distribusi' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : '' }}
                                    {{ $report['type'] == 'Penerimaan' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200' : '' }}">
                                    {{ $report['type'] }}
                                </span>
                            </td>
                            <td class="py-3 px-4">{{ $report['period'] }}</td>
                            <td class="py-3 px-4 text-right">
                                <a href="#" class="text-blue-600 hover:text-blue-900 mr-3">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                                <a href="#" class="text-green-600 hover:text-green-900">
                                    <i class="fas fa-download"></i> Unduh
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
@endsection
