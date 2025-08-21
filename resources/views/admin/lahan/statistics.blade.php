@extends('layouts.lahan')

@section('header')
    <h2 class="font-semibold text-xl text-neutral-800 dark:text-neutral-200 leading-tight">
        {{ __('Statistik') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <livewire:admin.lahan.statistics />
    </div>
</div>
@endsection
                        <option value="">Semua Wilayah</option>
                        <!-- Will be populated dynamically -->
                    </select>
                </div>
            </div>
        </div>

        <!-- Statistics Overview Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <!-- Total Area Card -->
            <div class="bg-white dark:bg-zinc-900 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-neutral-900 dark:text-neutral-100">Total Luas</h3>
                        <p class="text-3xl font-semibold text-indigo-600">1,250 Ha</p>
                        <p class="text-sm text-neutral-500">+5.25% dari periode sebelumnya</p>
                    </div>
                </div>
            </div>

            <!-- Total Plots Card -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-neutral-900">Jumlah Lahan</h3>
                        <p class="text-3xl font-semibold text-green-600">458</p>
                        <p class="text-sm text-neutral-500">+12 lahan baru bulan ini</p>
                    </div>
                </div>
            </div>

            <!-- Utilization Rate Card -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-neutral-900">Tingkat Pemanfaatan</h3>
                        <p class="text-3xl font-semibold text-yellow-600">85.7%</p>
                        <p class="text-sm text-neutral-500">+2.3% dari periode sebelumnya</p>
                    </div>
                </div>
            </div>

            <!-- Productivity Score Card -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-neutral-900">Skor Produktivitas</h3>
                        <p class="text-3xl font-semibold text-blue-600">7.8/10</p>
                        <p class="text-sm text-neutral-500">+0.5 dari periode sebelumnya</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Land Distribution Chart -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-neutral-900 mb-4">Distribusi Lahan per Kategori</h3>
                <div class="h-80" id="category-distribution-chart">
                    <!-- Chart will be rendered here -->
                </div>
            </div>

            <!-- Land Utilization Trend -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-neutral-900 mb-4">Tren Pemanfaatan Lahan</h3>
                <div class="h-80" id="utilization-trend-chart">
                    <!-- Chart will be rendered here -->
                </div>
            </div>
        </div>

        <!-- Detailed Statistics Table -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6">
                <h3 class="text-lg font-medium text-neutral-900 mb-4">Statistik Detail</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-neutral-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-neutral-50 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                    Kategori
                                </th>
                                <th class="px-6 py-3 bg-neutral-50 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                    Total Luas (Ha)
                                </th>
                                <th class="px-6 py-3 bg-neutral-50 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                    Jumlah Lahan
                                </th>
                                <th class="px-6 py-3 bg-neutral-50 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                    Rata-rata Produktivitas
                                </th>
                                <th class="px-6 py-3 bg-neutral-50 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                    Perubahan YoY
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-neutral-200">
                            <!-- Example row -->
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-neutral-900">
                                    Lahan Pertanian
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">
                                    750.5
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">
                                    245
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">
                                    8.2/10
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        +4.5%
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
