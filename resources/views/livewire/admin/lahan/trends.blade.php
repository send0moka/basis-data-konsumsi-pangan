<div>
    <!-- Header -->
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-neutral-900 dark:text-white">Tren & Prediksi</h1>
                <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">
                    Analisis tren historis dan prediksi data lahan pertanian
                </p>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="mb-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
        <div>
            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Periode</label>
            <select wire:model.live="trendPeriod" class="w-full text-sm rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-200 focus:ring-accent focus:border-accent">
                <option value="yearly">Tahunan</option>
                <option value="quarterly">Kuartalan</option>
                <option value="monthly">Bulanan</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Topik</label>
            <select wire:model.live="selectedTopik" class="w-full text-sm rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-200 focus:ring-accent focus:border-accent">
                <option value="">Semua Topik</option>
                @foreach($topiks as $topik)
                    <option value="{{ $topik->id }}">{{ $topik->nama }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Variabel</label>
            <select wire:model.live="selectedVariabel" class="w-full text-sm rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-200 focus:ring-accent focus:border-accent">
                <option value="">Semua Variabel</option>
                @foreach($variabels as $variabel)
                    <option value="{{ $variabel->id }}">{{ $variabel->nama }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Klasifikasi</label>
            <select wire:model.live="selectedKlasifikasi" class="w-full text-sm rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-200 focus:ring-accent focus:border-accent">
                <option value="">Semua Klasifikasi</option>
                @foreach($klasifikasis as $klasifikasi)
                    <option value="{{ $klasifikasi->id }}">{{ $klasifikasi->nama }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Wilayah</label>
            <select wire:model.live="selectedRegion" class="w-full text-sm rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-200 focus:ring-accent focus:border-accent">
                <option value="">Semua Wilayah</option>
                @foreach($regions as $region)
                    <option value="{{ $region }}">{{ $region }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Prediksi (Tahun)</label>
            <select wire:model.live="predictionYears" class="w-full text-sm rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-200 focus:ring-accent focus:border-accent">
                <option value="3">3 Tahun</option>
                <option value="5">5 Tahun</option>
                <option value="10">10 Tahun</option>
            </select>
        </div>
    </div>

    <!-- Trend Chart and Prediction -->
    <div class="mb-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Trend Chart -->
        <div class="lg:col-span-2 bg-white dark:bg-neutral-800 p-6 rounded-lg border border-neutral-200 dark:border-neutral-700">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-neutral-900 dark:text-white">Tren Historis & Prediksi</h3>
                <div class="flex items-center space-x-2 text-xs">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-blue-500 rounded mr-1"></div>
                        <span class="text-neutral-600 dark:text-neutral-400">Data Historis</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-red-500 rounded mr-1"></div>
                        <span class="text-neutral-600 dark:text-neutral-400">Prediksi</span>
                    </div>
                </div>
            </div>
            <div class="h-80 bg-white dark:bg-neutral-700 rounded-lg p-4">
                @if(count($trendData) > 0)
                    <canvas id="trendChart" class="w-full h-full"></canvas>
                @else
                    <div class="h-full flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-16 h-16 text-neutral-400 dark:text-neutral-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-neutral-600 dark:text-neutral-400">Tidak ada data yang tersedia</p>
                            <p class="text-neutral-500 dark:text-neutral-500 text-xs mt-1">
                                Pilih filter yang berbeda untuk melihat data
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Forecast Accuracy -->
        <div class="bg-white dark:bg-neutral-800 p-6 rounded-lg border border-neutral-200 dark:border-neutral-700">
            <h3 class="text-lg font-medium text-neutral-900 dark:text-white mb-4">Akurasi Model</h3>
            <div class="space-y-4">
                <div class="text-center">
                    <div class="text-3xl font-bold text-green-600 dark:text-green-400">
                        {{ number_format($forecastAccuracy['accuracy_percentage'], 1) }}%
                    </div>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">Akurasi Prediksi</p>
                </div>
                
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-neutral-600 dark:text-neutral-400">MAE</span>
                        <span class="text-sm font-medium text-neutral-900 dark:text-white">
                            {{ number_format($forecastAccuracy['mae'], 2) }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-neutral-600 dark:text-neutral-400">RMSE</span>
                        <span class="text-sm font-medium text-neutral-900 dark:text-white">
                            {{ number_format($forecastAccuracy['rmse'], 2) }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-neutral-600 dark:text-neutral-400">MAPE</span>
                        <span class="text-sm font-medium text-neutral-900 dark:text-white">
                            {{ number_format($forecastAccuracy['mape'], 2) }}%
                        </span>
                    </div>
                </div>

                <div class="pt-3 border-t border-neutral-200 dark:border-neutral-700">
                    <div class="text-xs text-neutral-500 dark:text-neutral-400">
                        <p class="mb-1"><strong>MAE:</strong> Mean Absolute Error</p>
                        <p class="mb-1"><strong>RMSE:</strong> Root Mean Square Error</p>
                        <p><strong>MAPE:</strong> Mean Absolute Percentage Error</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Prediction Table and Seasonal Analysis -->
    <div class="mb-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Prediction Values -->
        <div class="bg-white dark:bg-neutral-800 p-6 rounded-lg border border-neutral-200 dark:border-neutral-700">
            <h3 class="text-lg font-medium text-neutral-900 dark:text-white mb-4">Nilai Prediksi</h3>
            <div class="space-y-3">
                @forelse($predictionData as $prediction)
                <div class="flex justify-between items-center p-3 bg-neutral-50 dark:bg-neutral-700 rounded-lg">
                    <div>
                        <div class="font-medium text-neutral-900 dark:text-white">{{ $prediction['period'] }}</div>
                        <div class="text-xs text-neutral-500 dark:text-neutral-400">
                            Range: {{ number_format($prediction['confidence_interval']['lower'], 2) }} - {{ number_format($prediction['confidence_interval']['upper'], 2) }}
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-lg font-semibold text-blue-600 dark:text-blue-400">
                            {{ number_format($prediction['predicted_value'], 2) }}
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-neutral-500 dark:text-neutral-400 text-center py-4">Tidak ada data prediksi</p>
                @endforelse
            </div>
        </div>

        <!-- Seasonal Analysis -->
        @if($trendPeriod === 'monthly' && count($seasonalAnalysis) > 0)
        <div class="bg-white dark:bg-neutral-800 p-6 rounded-lg border border-neutral-200 dark:border-neutral-700">
            <h3 class="text-lg font-medium text-neutral-900 dark:text-white mb-4">Analisis Musiman</h3>
            <div class="space-y-2">
                @foreach($seasonalAnalysis as $month)
                <div class="flex justify-between items-center">
                    <span class="text-sm text-neutral-600 dark:text-neutral-400">{{ $month->month_name }}</span>
                    <div class="flex items-center">
                        <div class="w-20 bg-neutral-200 dark:bg-neutral-700 rounded-full h-2 mr-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($month->avg_value / $seasonalAnalysis->max('avg_value')) * 100 }}%"></div>
                        </div>
                        <span class="text-sm font-medium text-neutral-900 dark:text-white w-16 text-right">
                            {{ number_format($month->avg_value, 1) }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="bg-white dark:bg-neutral-800 p-6 rounded-lg border border-neutral-200 dark:border-neutral-700">
            <h3 class="text-lg font-medium text-neutral-900 dark:text-white mb-4">Analisis Musiman</h3>
            <div class="text-center py-8">
                <svg class="w-12 h-12 text-neutral-400 dark:text-neutral-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <p class="text-neutral-500 dark:text-neutral-400 text-sm">
                    Pilih periode "Bulanan" untuk melihat analisis musiman
                </p>
            </div>
        </div>
        @endif
    </div>

    <!-- Correlation Analysis -->
    @if(count($correlationAnalysis) > 0)
    <div class="mb-6 bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700">
        <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
            <h3 class="text-lg font-medium text-neutral-900 dark:text-white">Analisis Korelasi Variabel</h3>
            <p class="text-sm text-neutral-600 dark:text-neutral-400 mt-1">
                Hubungan antar variabel dalam topik yang dipilih
            </p>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($correlationAnalysis as $correlation)
                <div class="p-4 border border-neutral-200 dark:border-neutral-700 rounded-lg">
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex-1">
                            <div class="text-sm font-medium text-neutral-900 dark:text-white">
                                {{ $correlation['variable1'] }}
                            </div>
                            <div class="text-xs text-neutral-500 dark:text-neutral-400">vs</div>
                            <div class="text-sm font-medium text-neutral-900 dark:text-white">
                                {{ $correlation['variable2'] }}
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs px-2 py-1 rounded-full
                            @if(abs($correlation['correlation']) >= 0.8) bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                            @elseif(abs($correlation['correlation']) >= 0.6) bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300
                            @elseif(abs($correlation['correlation']) >= 0.4) bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                            @elseif(abs($correlation['correlation']) >= 0.2) bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300
                            @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                            @endif">
                            {{ $correlation['strength'] }}
                        </span>
                        <span class="text-lg font-bold {{ $correlation['correlation'] >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                            {{ number_format($correlation['correlation'], 3) }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Historical Data Summary -->
    <div class="bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700">
        <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
            <h3 class="text-lg font-medium text-neutral-900 dark:text-white">Data Historis</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-neutral-500 dark:text-neutral-400">
                <thead class="text-xs text-neutral-700 uppercase bg-neutral-50 dark:bg-neutral-700 dark:text-neutral-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Periode</th>
                        <th scope="col" class="px-6 py-3">Rata-rata Nilai</th>
                        <th scope="col" class="px-6 py-3">Jumlah Data</th>
                        <th scope="col" class="px-6 py-3">Tren</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($trendData as $index => $data)
                    <tr class="bg-white border-b dark:bg-neutral-800 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-700 transition-colors">
                        <td class="px-6 py-4 font-medium text-neutral-900 dark:text-white">
                            {{ $data->period }}
                        </td>
                        <td class="px-6 py-4">
                            {{ number_format($data->avg_value, 2, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            {{ number_format($data->count) }}
                        </td>
                        <td class="px-6 py-4">
                            @if($index > 0)
                                @php
                                    $prevValue = $trendData[$index - 1]->avg_value;
                                    $change = (($data->avg_value - $prevValue) / $prevValue) * 100;
                                @endphp
                                <div class="flex items-center">
                                    @if($change > 0)
                                        <svg class="w-4 h-4 text-green-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                        </svg>
                                        <span class="text-green-600 dark:text-green-400 text-sm">+{{ number_format($change, 1) }}%</span>
                                    @elseif($change < 0)
                                        <svg class="w-4 h-4 text-red-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                                        </svg>
                                        <span class="text-red-600 dark:text-red-400 text-sm">{{ number_format($change, 1) }}%</span>
                                    @else
                                        <svg class="w-4 h-4 text-neutral-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14"></path>
                                        </svg>
                                        <span class="text-neutral-600 dark:text-neutral-400 text-sm">0%</span>
                                    @endif
                                </div>
                            @else
                                <span class="text-neutral-400 dark:text-neutral-500 text-sm">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-neutral-500 dark:text-neutral-400">
                            Tidak ada data historis ditemukan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('livewire:initialized', () => {
        @php
            // Ensure we have arrays to work with
            $trendData = is_array($trendData) ? $trendData : $trendData->toArray();
            $predictionData = is_array($predictionData) ? $predictionData : (is_object($predictionData) ? $predictionData->toArray() : []);
            
            // Extract periods and values
            $trendPeriods = array_column($trendData, 'period');
            $trendValues = array_column($trendData, 'avg_value');
            
            $predictionPeriods = [];
            $predictionValues = [];
            
            if (!empty($predictionData)) {
                $predictionPeriods = array_column($predictionData, 'period');
                $predictionValues = array_column($predictionData, 'value');
            }
            
            // Combine periods for x-axis labels
            $allPeriods = array_merge($trendPeriods, $predictionPeriods);
        @endphp
        
        renderChart({
            labels: @json($allPeriods),
            historicalData: @json($trendValues),
            predictionData: @json($predictionValues),
            historicalLabel: 'Data Historis',
            predictionLabel: 'Prediksi'
        });
        
        // Listen for Livewire events to update the chart
        Livewire.on('updateChart', (chartData) => {
            renderChart(chartData);
        });
    });
    
    function renderChart(chartData) {
        const ctx = document.getElementById('trendChart');
        if (!ctx) return;
        
        // Destroy existing chart if it exists
        if (window.trendChart) {
            window.trendChart.destroy();
        }
        
        const historicalData = chartData.historicalData || [];
        const predictionData = chartData.predictionData || [];
        const allData = [...historicalData, ...predictionData];
        
        // Calculate min and max for y-axis with padding
        const minValue = allData.length > 0 ? Math.min(...allData) * 0.9 : 0; // 10% padding
        const maxValue = allData.length > 0 ? Math.max(...allData) * 1.1 : 10; // 10% padding
        
        window.trendChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData.labels,
                datasets: [
                    {
                        label: chartData.historicalLabel || 'Data Historis',
                        data: [...historicalData, ...Array(predictionData.length).fill(null)],
                        borderColor: '#3b82f6', // blue-500
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 2,
                        tension: 0.3,
                        pointRadius: historicalData.length > 12 ? 2 : 4,
                        fill: false
                    },
                    predictionData.length > 0 ? {
                        label: chartData.predictionLabel || 'Prediksi',
                        data: [...Array(historicalData.length).fill(null), ...predictionData],
                        borderColor: '#ef4444', // red-500
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        borderWidth: 2,
                        borderDash: [5, 5],
                        tension: 0.3,
                        pointRadius: 4,
                        fill: false
                    } : null
                ].filter(Boolean)
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: false,
                        min: minValue,
                        max: maxValue,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            color: '#6b7280' // gray-500
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#6b7280' // gray-500
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(255, 255, 255, 0.95)',
                        titleColor: '#111827',
                        bodyColor: '#4b5563',
                        borderColor: '#e5e7eb',
                        borderWidth: 1,
                        padding: 12,
                        displayColors: true,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('id-ID', {
                                        maximumFractionDigits: 2
                                    }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                }
            }
        });
    }
</script>
@endpush
