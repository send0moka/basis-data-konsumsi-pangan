@extends('layouts.lahan')

@section('header')
    <h2 class="font-semibold text-xl text-neutral-800 dark:text-neutral-200 leading-tight">
        {{ __('Tren Lahan') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Filters Section -->
        <div class="bg-white dark:bg-zinc-900 overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="date-range" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Rentang Waktu</label>
                    <select id="date-range" name="date-range" class="mt-1 block w-full py-2 px-3 border border-neutral-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="1y">1 Tahun Terakhir</option>
                        <option value="2y">2 Tahun Terakhir</option>
                        <option value="5y">5 Tahun Terakhir</option>
                        <option value="custom">Kustom</option>
                    </select>
                </div>
                <div>
                    <label for="trend-type" class="block text-sm font-medium text-neutral-700">Jenis Tren</label>
                    <select id="trend-type" name="trend-type" class="mt-1 block w-full py-2 px-3 border border-neutral-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="usage">Penggunaan Lahan</option>
                        <option value="productivity">Produktivitas</option>
                        <option value="conversion">Konversi Lahan</option>
                        <option value="all">Semua Metrik</option>
                    </select>
                </div>
                <div>
                    <label for="region" class="block text-sm font-medium text-neutral-700">Wilayah</label>
                    <select id="region" name="region" class="mt-1 block w-full py-2 px-3 border border-neutral-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Semua Wilayah</option>
                        <!-- Will be populated dynamically -->
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm">
                        Terapkan Filter
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Trend Chart -->
        <div class="bg-white dark:bg-zinc-900 overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
            <h3 class="text-lg font-medium text-neutral-900 dark:text-neutral-100 mb-4">Tren Utama</h3>
            <div class="h-96" id="main-trend-chart">
                <!-- Main trend chart will be rendered here -->
            </div>
        </div>

        <!-- Trend Metrics Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Land Use Change -->
            <div class="bg-white dark:bg-zinc-900 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h4 class="text-md font-medium text-neutral-900 dark:text-neutral-100 mb-2">Perubahan Penggunaan Lahan</h4>
                <div class="flex items-center justify-between mb-4">
                    <span class="text-3xl font-bold text-indigo-600">+5.2%</span>
                    <span class="px-2 py-1 text-sm rounded-full bg-green-100 text-green-800">↑ Meningkat</span>
                </div>
                <div class="h-40" id="land-use-chart">
                    <!-- Mini chart will be rendered here -->
                </div>
            </div>

            <!-- Productivity Trends -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h4 class="text-md font-medium text-neutral-900 mb-2">Tren Produktivitas</h4>
                <div class="flex items-center justify-between mb-4">
                    <span class="text-3xl font-bold text-indigo-600">8.4/10</span>
                    <span class="px-2 py-1 text-sm rounded-full bg-green-100 text-green-800">↑ Membaik</span>
                </div>
                <div class="h-40" id="productivity-chart">
                    <!-- Mini chart will be rendered here -->
                </div>
            </div>

            <!-- Land Conversion Rate -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h4 class="text-md font-medium text-neutral-900 mb-2">Tingkat Konversi Lahan</h4>
                <div class="flex items-center justify-between mb-4">
                    <span class="text-3xl font-bold text-indigo-600">-2.1%</span>
                    <span class="px-2 py-1 text-sm rounded-full bg-yellow-100 text-yellow-800">↓ Menurun</span>
                </div>
                <div class="h-40" id="conversion-chart">
                    <!-- Mini chart will be rendered here -->
                </div>
            </div>
        </div>

        <!-- Trend Analysis Table -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6">
                <h3 class="text-lg font-medium text-neutral-900 mb-4">Analisis Tren Terperinci</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-neutral-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-neutral-50 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                    Periode
                                </th>
                                <th class="px-6 py-3 bg-neutral-50 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                    Penggunaan Lahan
                                </th>
                                <th class="px-6 py-3 bg-neutral-50 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                    Produktivitas
                                </th>
                                <th class="px-6 py-3 bg-neutral-50 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                    Tingkat Konversi
                                </th>
                                <th class="px-6 py-3 bg-neutral-50 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                    Tren
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-neutral-200">
                            <!-- Example row -->
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-neutral-900">
                                    Q3 2025
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">
                                    85.7%
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">
                                    8.4/10
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">
                                    -2.1%
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Positif
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Include Chart.js or any other charting library -->
<script>
    // Charts initialization and data visualization code will be implemented here
</script>
@endpush
