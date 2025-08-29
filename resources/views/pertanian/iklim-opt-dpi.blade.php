<x-layouts.landing title="Laporan Data Iklim dan OPT DPI">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="iklimOptDpiForm()">

            <!-- Header & Stepper -->
            <div class="mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-neutral-900 mb-4">Laporan Data Iklim dan OPT DPI</h1>
                <p class="text-xl text-neutral-600">Analisis data iklim, OPT, dan DPI di Indonesia.</p>
                <nav class="-mb-px flex space-x-8 mt-8 border-b border-neutral-200" aria-label="Tabs">
                    <a href="#" @click.prevent="currentStep = 1" :class="{'border-blue-500 text-blue-600': currentStep === 1}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Langkah 1: Pilih Data</a>
                    <a href="#" @click.prevent="goToStep(2)" :class="{'border-blue-500 text-blue-600': currentStep === 2, 'pointer-events-none opacity-50': !stepsCompleted[1]}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Langkah 2: Konfigurasi</a>
                    <a href="#" @click.prevent="goToStep(3)" :class="{'border-blue-500 text-blue-600': currentStep === 3, 'pointer-events-none opacity-50': !stepsCompleted[2]}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Langkah 3: Hasil</a>
                </nav>
            </div>

            <!-- Step 1: Data Selection -->
            <div x-show="currentStep === 1">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Data Filter -->
                    <div class="bg-neutral-50 rounded-lg p-6">
                        <h4 class="text-md font-medium text-neutral-800 mb-4">Filter Data</h4>
                        <div class="space-y-4">
                            <!-- Topic -->
                            <select x-model="filters.topik" @change="loadVariabels" class="w-full form-select">
                                <option value="">Pilih Topik</option>
                                <template x-for="topik in topiks" :key="topik.id">
                                    <option :value="topik.id" x-text="topik.nama"></option>
                                </template>
                            </select>
                            <!-- Variable -->
                            <div class="max-h-40 overflow-y-auto border rounded-md p-2">
                                <template x-for="variabel in availableVariabels" :key="variabel.id">
                                    <label class="flex items-center">
                                        <input type="radio" :value="variabel.id" x-model="filters.selectedVariabel" @change="loadKlasifikasis" name="variabel" class="form-radio">
                                        <span class="ml-2 text-sm" x-text="variabel.nama + ' (' + variabel.satuan + ')'"></span>
                                    </label>
                                </template>
                            </div>
                            <!-- Classification -->
                            <div class="max-h-40 overflow-y-auto border rounded-md p-2">
                                <template x-for="klasifikasi in availableKlasifikasis" :key="klasifikasi.id">
                                    <label class="flex items-center">
                                        <input type="checkbox" :value="klasifikasi.id" x-model="filters.klasifikasis" class="form-checkbox">
                                        <span class="ml-2 text-sm" x-text="klasifikasi.nama"></span>
                                    </label>
                                </template>
                            </div>
                        </div>
                    </div>
                    <!-- Time Filter -->
                    <div class="bg-neutral-50 rounded-lg p-6">
                        <h4 class="text-md font-medium text-neutral-800 mb-4">Filter Waktu</h4>
                        <!-- Year Selection Mode -->
                        <div class="flex gap-4 mb-3">
                            <label><input type="radio" x-model="yearMode" value="specific" class="form-radio"><span class="ml-1">Spesifik</span></label>
                            <label><input type="radio" x-model="yearMode" value="range" class="form-radio"><span class="ml-1">Rentang</span></label>
                            <label><input type="radio" x-model="yearMode" value="all" class="form-radio"><span class="ml-1">Semua</span></label>
                        </div>
                        <!-- Specific/Range/All selection UI -->
                        <div x-show="yearMode === 'specific'">
                            <select x-model="filters.selectedYears" multiple class="w-full form-select">
                                <template x-for="year in years" :key="year">
                                    <option :value="year" x-text="year"></option>
                                </template>
                            </select>
                        </div>
                        <div x-show="yearMode === 'range'">
                            <div class="flex gap-4">
                                <select x-model="filters.tahun_awal" class="w-full form-select">
                                    <template x-for="year in years" :key="year">
                                        <option :value="year" x-text="year"></option>
                                    </template>
                                </select>
                                <span class="text-neutral-500">sampai</span>
                                <select x-model="filters.tahun_akhir" class="w-full form-select">
                                    <template x-for="year in years" :key="year">
                                        <option :value="year" x-text="year"></option>
                                    </template>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Region Filter -->
                    <div class="bg-neutral-50 rounded-lg p-6">
                        <h4 class="text-md font-medium text-neutral-800 mb-4">Filter Wilayah</h4>
                        <div class="flex gap-2 mb-2">
                            <button @click="selectAllRegions()" class="btn btn-secondary btn-sm">Pilih Semua</button>
                            <button @click="selectNoneRegions()" class="btn btn-secondary btn-sm">Kosongkan</button>
                        </div>
                        <div class="max-h-60 overflow-y-auto border rounded-md p-2">
                            <template x-for="wilayah in availableRegions" :key="wilayah.id">
                                <label class="flex items-center"><input type="checkbox" :value="wilayah.id" x-model="filters.selectedRegions" class="form-checkbox"><span class="ml-2 text-sm" x-text="wilayah.nama"></span></label>
                            </template>
                        </div>
                    </div>
                </div>
                <div class="mt-8 flex justify-end">
                    <button @click="goToStep(2)" :disabled="!isStep1Complete()" class="btn btn-primary">Lanjutkan</button>
                </div>
            </div>

            <!-- Step 2: Layout Configuration -->
            <div x-show="currentStep === 2">
                <h3 class="text-xl font-semibold mb-4">Pilih Tata Letak Tabel</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <label class="border rounded-lg p-4 flex items-center cursor-pointer"><input type="radio" x-model="filters.tata_letak" value="tipe_1" class="form-radio mr-4"><span class="font-medium">Variabel sebagai Kolom</span></label>
                    <label class="border rounded-lg p-4 flex items-center cursor-pointer"><input type="radio" x-model="filters.tata_letak" value="tipe_2" class="form-radio mr-4"><span class="font-medium">Wilayah sebagai Kolom</span></label>
                </div>
                <div class="mt-8 flex justify-between">
                    <button @click="goToStep(1)" class="btn btn-secondary">Kembali</button>
                    <button @click="submitFilters" class="btn btn-primary">Tampilkan Hasil</button>
                </div>
            </div>

            <!-- Step 3: Results -->
            <div x-show="currentStep === 3">
                <div x-show="isProcessing" class="text-center p-8">Memuat data...</div>
                <div x-show="!isProcessing && searchResults">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-semibold">Hasil</h3>
                        <button @click="exportToExcel" class="btn btn-success">Ekspor ke Excel</button>
                    </div>
                    <div class="overflow-x-auto bg-white rounded-lg shadow">
                        <table class="min-w-full divide-y divide-neutral-200">
                            <thead class="bg-neutral-50">
                                <tr><template x-for="header in searchResults.headers"><th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider" x-text="header"></th></template></tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-neutral-200">
                                <template x-for="row in searchResults.rows">
                                    <tr><template x-for="cell in row"><td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900" x-text="cell"></td></template></tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-8 bg-white rounded-lg shadow p-4"><canvas id="resultsChart"></canvas></div>
                </div>
                <div class="mt-8 flex justify-start">
                    <button @click="goToStep(2)" class="btn btn-secondary">Kembali ke Konfigurasi</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    function iklimOptDpiForm() {
        return {
            currentStep: 1,
            stepsCompleted: { 1: false, 2: false },
            isProcessing: false,
            topiks: @json($topiks),
            years: @json($years),
            availableRegions: @json($regions),
            availableVariabels: [],
            availableKlasifikasis: [],
            searchResults: null,
            chart: null,
            yearMode: 'range',
            filters: {
                topik: '',
                selectedVariabel: '',
                klasifikasis: [],
                selectedYears: [],
                tahun_awal: '',
                tahun_akhir: '',
                selectedRegions: [],
                tata_letak: 'tipe_1'
            },

            init() {
                this.filters.tahun_awal = this.years.length > 3 ? this.years[this.years.length - 4] : (this.years.length > 0 ? this.years[0] : '');
                this.filters.tahun_akhir = this.years.length > 0 ? this.years[this.years.length - 1] : '';
                this.filters.selectedRegions = this.availableRegions.map(r => r.id);
            },

            goToStep(step) {
                if (step === 2 && this.isStep1Complete()) {
                    this.stepsCompleted[1] = true;
                    this.currentStep = 2;
                } else if (step === 3 && this.stepsCompleted[2]) {
                    this.currentStep = 3;
                } else if (step < this.currentStep) {
                    this.currentStep = step;
                }
            },

            isStep1Complete() {
                const yearValid = this.yearMode === 'all' || (this.yearMode === 'specific' && this.filters.selectedYears.length > 0) || (this.yearMode === 'range' && this.filters.tahun_awal && this.filters.tahun_akhir && this.filters.tahun_awal <= this.filters.tahun_akhir);
                return this.filters.topik && this.filters.selectedVariabel && this.filters.klasifikasis.length > 0 && this.filters.selectedRegions.length > 0 && yearValid;
            },

            async loadVariabels() {
                this.availableVariabels = []; this.availableKlasifikasis = []; this.filters.selectedVariabel = ''; this.filters.klasifikasis = [];
                if (!this.filters.topik) return;
                const response = await fetch(`/api/iklim-opt-dpi/variabels/${this.filters.topik}`);
                this.availableVariabels = await response.json();
            },

            async loadKlasifikasis() {
                this.availableKlasifikasis = []; this.filters.klasifikasis = [];
                if (!this.filters.selectedVariabel) return;
                const response = await fetch(`/api/iklim-opt-dpi/klasifikasis/${this.filters.selectedVariabel}`);
                this.availableKlasifikasis = await response.json();
                this.filters.klasifikasis = this.availableKlasifikasis.map(k => k.id);
            },
            
            selectAllRegions() { this.filters.selectedRegions = this.availableRegions.map(r => r.id); },
            selectNoneRegions() { this.filters.selectedRegions = []; },

            async submitFilters() {
                if (!this.isStep1Complete()) return;
                this.isProcessing = true; this.stepsCompleted[2] = true; this.currentStep = 3; this.searchResults = null;
                
                const payload = { ...this.filters, year_mode: this.yearMode };
                    if (this.filters.tahun_awal && this.filters.tahun_akhir) {
                        if (parseInt(this.filters.tahun_akhir) < parseInt(this.filters.tahun_awal)) {
                            this.filters.tahun_akhir = this.filters.tahun_awal;
                        }
                    }
                },

                selectAllRegions() {
                    this.filters.selectedRegions = this.availableRegions.map(r => r.id);
                },

                selectNoneRegions() {
                    this.filters.selectedRegions = [];
                },

                canAddToQueue() {
                    const hasValidYears = this.yearMode === 'all' || 
                                         (this.yearMode === 'specific' && this.filters.selectedYears.length > 0) ||
                                         (this.yearMode === 'range' && this.filters.tahun_awal && this.filters.tahun_akhir);
                    
                    return this.filters.topik && 
                           this.filters.selectedVariabel && 
                           this.filters.klasifikasis.length > 0 && 
                           hasValidYears &&
                           this.filters.selectedRegions.length > 0;
                },

                async addToQueue() {
                    if (!this.canAddToQueue()) return;

                    this.addingToQueue = true;
                    await new Promise(resolve => setTimeout(resolve, 300));

                    const queueItem = {
                        ...JSON.parse(JSON.stringify(this.filters)),
                        variabels: [this.filters.selectedVariabel],
                        yearMode: this.yearMode,
                        processed: false,
                        timestamp: Date.now()
                    };
                    
                    delete queueItem.selectedVariabel;

                    this.filterQueue.push(queueItem);
                    this.addingToQueue = false;
                },

                removeFromQueue(index) {
                    this.filterQueue.splice(index, 1);
                },

                clearQueue() {
                    this.filterQueue = [];
                },

                async processQueue() {
                    if (this.filterQueue.length === 0) return;

                    this.isProcessing = true;
                    this.searchResults = [];

                    try {
                        const unprocessedItems = this.filterQueue.filter(item => !item.processed);
                        
                        if (unprocessedItems.length === 0) {
                            this.isProcessing = false;
                            return;
                        }
                        
                        const promises = unprocessedItems.map((queueItem, index) => {
                            queueItem.resultIndex = this.searchResults.length + index + 1;
                            return fetch('/api/iklim-opt-dpi/search', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify(queueItem)
                            }).then(response => response.json());
                        });

                        const results = await Promise.all(promises);

                        results.forEach((result, index) => {
                            if (result.success) {
                                this.searchResults.push(result);
                                unprocessedItems[index].processed = true;
                            } else {
                                console.error('Error processing queue item:', result.error);
                            }
                        });

                    } catch (error) {
                        console.error('Error processing queue:', error);
                    } finally {
                        this.isProcessing = false;
                        this.activeTab = 'tabel';

                        this.$nextTick(() => {
                            this.createCharts();
                        });
                    }
                },

                createCharts() {
                    this.searchResults.forEach((result, index) => {
                        const ctx = document.getElementById(`chart-${index}`);
                        if (!ctx) return;

                        // Destroy existing chart if it exists
                        if (ctx.chart) {
                            ctx.chart.destroy();
                        }

                        const colors = [
                            'rgba(54, 162, 235, 0.8)', 'rgba(255, 99, 132, 0.8)', 'rgba(75, 192, 192, 0.8)',
                            'rgba(255, 206, 86, 0.8)', 'rgba(153, 102, 255, 0.8)', 'rgba(255, 159, 64, 0.8)'
                        ];

                        ctx.chart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: result.headers,
                                datasets: result.data.map((row, i) => ({
                                    label: row.label,
                                    data: row.values,
                                    backgroundColor: colors[i % colors.length],
                                    borderColor: colors[i % colors.length].replace('0.8', '1'),
                                    borderWidth: 1
                                }))
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                },
                                plugins: {
                                    legend: {
                                        position: 'top',
                                    },
                                    title: {
                                        display: true,
                                        text: result.topik_nama
                                    }
                                }
                            }
                        });
                    });
                },

                resetAll() {
                    this.filters = {
                        topik: '',
                        selectedVariabel: '',
                        klasifikasis: [],
                        selectedYears: [],
                        tahun_awal: this.years.length > 3 ? this.years[this.years.length - 4] : '2018',
                        tahun_akhir: this.years.length > 0 ? this.years[this.years.length - 1] : '2021',
                        selectedRegions: this.availableRegions.map(r => r.id),
                        tata_letak: 'tipe_1'
                    };
                    
                    this.yearMode = 'range';
                    this.availableVariabels = [];
                    this.availableKlasifikasis = [];
                    this.filterQueue = [];
                    this.searchResults = [];
                },

                clearResults() {
                    this.searchResults = [];
                    this.filterQueue.forEach(item => {
                        item.processed = false;
                    });
                },

                getQueueSummary(queueItem) {
                    const topik = this.topiks.find(t => t.id == queueItem.topik)?.nama || 'Unknown';
                    const variabelCount = queueItem.variabels ? queueItem.variabels.length : 0;
                    const klasifikasiCount = queueItem.klasifikasis.length;
                    const regionCount = queueItem.selectedRegions.length;
                    const timeRange = `${queueItem.tahun_awal}-${queueItem.tahun_akhir}`;
                    
                    return `${topik} • ${variabelCount} var • ${klasifikasiCount} klas • ${regionCount} wil • ${timeRange}`;
                },

                getVariabelNames(queueItem) {
                    if (!queueItem.variabels || !this.availableVariabels) return 'Default Variabel';
                    const selectedVariabels = this.availableVariabels.filter(v => queueItem.variabels.includes(v.id));
                    if (selectedVariabels.length === 0) return 'Default Variabel';
                    return selectedVariabels.map(v => v.nama).join(', ');
                },

                formatNumber(value) {
                    if (value === null || value === undefined) return '-';
                    return new Intl.NumberFormat('id-ID', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 2
                    }).format(value);
                },

                exportSingleResult(result, index) {
                    const wb = XLSX.utils.book_new();
                    const wsData = [];
                    
                    const headerRow = ['Label', ...result.headers];
                    wsData.push(headerRow);
                    
                    result.data.forEach(row => {
                        wsData.push([row.label, ...row.values]);
                    });
                    
                    if (result.totals) {
                        wsData.push(['Rata-rata', ...result.totals]);
                    }
                    
                    const ws = XLSX.utils.aoa_to_sheet(wsData);
                    XLSX.utils.book_append_sheet(wb, ws, `Hasil_${result.resultIndex}`);
                    
                    const topikName = result.topik_nama.toLowerCase().replace(/ /g, '-');
                    XLSX.writeFile(wb, `laporan-iklim-opt-dpi-${topikName}-${new Date().toISOString().split('T')[0]}.xlsx`);
                }
            };
        }
    </script>
</x-layouts.landing>
