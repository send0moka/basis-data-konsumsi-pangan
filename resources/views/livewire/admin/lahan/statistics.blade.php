<div>
    <!-- Header -->
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-neutral-900 dark:text-white">Statistik Lahan</h1>
                <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">
                    Analisis statistik dan visualisasi data lahan pertanian
                </p>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="mb-6 flex flex-col sm:flex-row gap-4">
        <div class="flex-1">
            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Filter Tahun</label>
            <select wire:model.live="selectedYear" class="w-full text-sm rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-200 focus:ring-accent focus:border-accent">
                <option value="">Semua Tahun</option>
                @foreach($years as $year)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex-1">
            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Filter Topik</label>
            <select wire:model.live="selectedTopik" class="w-full text-sm rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-200 focus:ring-accent focus:border-accent">
                <option value="">Semua Topik</option>
                @foreach($topiks as $topik)
                    <option value="{{ $topik->id }}">{{ $topik->nama }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-neutral-800 p-6 rounded-lg border border-neutral-200 dark:border-neutral-700">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">Total Data</p>
                    <p class="text-2xl font-semibold text-neutral-900 dark:text-white">{{ number_format($totalData) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-neutral-800 p-6 rounded-lg border border-neutral-200 dark:border-neutral-700">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-lg">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">Total Nilai</p>
                    <p class="text-2xl font-semibold text-neutral-900 dark:text-white">{{ number_format($totalValue, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-neutral-800 p-6 rounded-lg border border-neutral-200 dark:border-neutral-700">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">Rata-rata</p>
                    <p class="text-2xl font-semibold text-neutral-900 dark:text-white">{{ number_format($averageValue, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-neutral-800 p-6 rounded-lg border border-neutral-200 dark:border-neutral-700">
            <div class="flex items-center">
                <div class="p-2 {{ $growthRate >= 0 ? 'bg-green-100 dark:bg-green-900/30' : 'bg-red-100 dark:bg-red-900/30' }} rounded-lg">
                    <svg class="w-6 h-6 {{ $growthRate >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($growthRate >= 0)
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                        @endif
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">Pertumbuhan</p>
                    <p class="text-2xl font-semibold {{ $growthRate >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                        {{ number_format($growthRate, 1) }}%
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 1 -->
    <div class="mb-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Yearly Trends Chart -->
        <div class="bg-white dark:bg-neutral-800 p-6 rounded-lg border border-neutral-200 dark:border-neutral-700">
            <h3 class="text-lg font-medium text-neutral-900 dark:text-white mb-4">Tren Tahunan</h3>
            <div class="h-64 bg-neutral-100 dark:bg-neutral-700 rounded-lg flex items-center justify-center">
                <div class="text-center">
                    <svg class="w-12 h-12 text-neutral-400 dark:text-neutral-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <p class="text-neutral-600 dark:text-neutral-400 text-sm">Chart.js Line Chart</p>
                </div>
            </div>
            @if(count($yearlyTrends) > 0)
            <div class="mt-4 text-xs text-neutral-500 dark:text-neutral-400">
                Data dari {{ count($yearlyTrends) }} tahun
            </div>
            @endif
        </div>

        <!-- Topik Distribution -->
        <div class="bg-white dark:bg-neutral-800 p-6 rounded-lg border border-neutral-200 dark:border-neutral-700">
            <h3 class="text-lg font-medium text-neutral-900 dark:text-white mb-4">Distribusi Topik</h3>
            <div class="space-y-3">
                @forelse($topikDistribution as $topik)
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-medium text-neutral-900 dark:text-white">{{ $topik['name'] }}</span>
                            <span class="text-sm text-neutral-600 dark:text-neutral-400">{{ $topik['percentage'] }}%</span>
                        </div>
                        <div class="w-full bg-neutral-200 dark:bg-neutral-700 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $topik['percentage'] }}%"></div>
                        </div>
                        <div class="flex justify-between text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                            <span>{{ number_format($topik['count']) }} data</span>
                            <span>Avg: {{ number_format($topik['avg_value'], 2) }}</span>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-neutral-500 dark:text-neutral-400 text-center py-4">Tidak ada data</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Charts Row 2 -->
    <div class="mb-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Status Distribution -->
        <div class="bg-white dark:bg-neutral-800 p-6 rounded-lg border border-neutral-200 dark:border-neutral-700">
            <h3 class="text-lg font-medium text-neutral-900 dark:text-white mb-4">Distribusi Status</h3>
            <div class="space-y-3">
                @forelse($statusDistribution as $status)
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <span class="px-2 py-1 text-xs rounded-full mr-3
                            @if($status['status'] === 'Aktif') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                            @elseif($status['status'] === 'Tidak Aktif') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                            @elseif($status['status'] === 'Dalam Proses') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                            @elseif($status['status'] === 'Selesai') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300
                            @else bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-300
                            @endif">
                            {{ $status['status'] }}
                        </span>
                        <span class="text-sm text-neutral-900 dark:text-white">{{ number_format($status['count']) }}</span>
                    </div>
                    <span class="text-sm text-neutral-600 dark:text-neutral-400">{{ $status['percentage'] }}%</span>
                </div>
                @empty
                <p class="text-neutral-500 dark:text-neutral-400 text-center py-4">Tidak ada data</p>
                @endforelse
            </div>
        </div>

        <!-- Top Regions -->
        <div class="bg-white dark:bg-neutral-800 p-6 rounded-lg border border-neutral-200 dark:border-neutral-700">
            <h3 class="text-lg font-medium text-neutral-900 dark:text-white mb-4">Top 10 Wilayah</h3>
            <div class="space-y-3">
                @forelse($regionStats as $index => $region)
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <span class="w-6 h-6 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 rounded-full flex items-center justify-center text-xs font-medium mr-3">
                            {{ $index + 1 }}
                        </span>
                        <span class="text-sm font-medium text-neutral-900 dark:text-white">{{ $region['region'] }}</span>
                    </div>
                    <div class="text-right">
                        <div class="text-sm font-medium text-neutral-900 dark:text-white">{{ number_format($region['count']) }}</div>
                        <div class="text-xs text-neutral-500 dark:text-neutral-400">Avg: {{ number_format($region['avg_value'], 2) }}</div>
                    </div>
                </div>
                @empty
                <p class="text-neutral-500 dark:text-neutral-400 text-center py-4">Tidak ada data</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Variabel Comparison Table -->
    <div class="bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700">
        <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
            <h3 class="text-lg font-medium text-neutral-900 dark:text-white">Perbandingan Variabel</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-neutral-500 dark:text-neutral-400">
                <thead class="text-xs text-neutral-700 uppercase bg-neutral-50 dark:bg-neutral-700 dark:text-neutral-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Variabel</th>
                        <th scope="col" class="px-6 py-3">Satuan</th>
                        <th scope="col" class="px-6 py-3">Jumlah Data</th>
                        <th scope="col" class="px-6 py-3">Rata-rata</th>
                        <th scope="col" class="px-6 py-3">Maksimum</th>
                        <th scope="col" class="px-6 py-3">Minimum</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($variabelComparison as $variabel)
                    <tr class="bg-white border-b dark:bg-neutral-800 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-700 transition-colors">
                        <td class="px-6 py-4 font-medium text-neutral-900 dark:text-white">
                            {{ $variabel['name'] }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                {{ $variabel['unit'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            {{ number_format($variabel['count']) }}
                        </td>
                        <td class="px-6 py-4 font-medium">
                            {{ number_format($variabel['avg_value'], 2, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-green-600 dark:text-green-400 font-medium">
                            {{ number_format($variabel['max_value'], 2, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-red-600 dark:text-red-400 font-medium">
                            {{ number_format($variabel['min_value'], 2, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-neutral-500 dark:text-neutral-400">
                            Tidak ada data variabel ditemukan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
