<x-layouts.landing title="Laporan Data Iklim dan OPT DPI">
    <!-- Add Chart.js for data visualization -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Add SheetJS library for Excel export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    
    <!-- Custom CSS for enhanced radio buttons and table layouts -->
    <style>
        .table-layout-radio:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .table-preview {
            transition: all 0.2s ease-in-out;
        }
        
        .table-layout-radio:hover .table-preview {
            transform: scale(1.02);
        }
        
        .preview-table th, .preview-table td {
            font-size: 10px;
            padding: 4px 6px;
        }
    </style>
    
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="text-neutral-700 hover:text-blue-600">Home</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-neutral-400" fill="currentColor" viewBox="0 0 20 20">
                            </svg>
                            <span class="ml-1 text-neutral-500">Pertanian</span>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-neutral-400" fill="currentColor" viewBox="0 0 20 20">
                            </svg>
                            <span class="ml-1 text-blue-600 font-medium">Laporan Iklim & OPT DPI</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-neutral-900 mb-4">
                    Laporan Data Iklim dan OPT DPI
                </h1>
                <p class="text-xl text-neutral-600">
                    Cari dan analisis data iklim dan organisme pengganggu tumbuhan (OPT) serta dampak perubahan iklim (DPI) di Indonesia.
                </p>
            </div>

            <!-- Two Column Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8" x-data="iklimOptDpiForm()">
                <!-- Search Form - Left Column -->
                <div class="lg:col-span-1">
                    <div class="bg-neutral-50 rounded-lg p-6 sticky top-24">
                        <h3 class="text-lg font-semibold text-neutral-900 mb-6">Filter Data Iklim & OPT DPI</h3>
                        
                        <!-- Data Filter Group -->
                        <div class="bg-white rounded-lg p-4 border border-neutral-200 mb-6">
                            <h4 class="text-md font-medium text-neutral-800 mb-4">Filter Data</h4>
                            <div class="space-y-4">
                                <!-- Pilih Topik -->
                                <div>
                                    <label for="topik" class="block text-sm font-medium text-neutral-700 mb-2">
                                        Topik
                                    </label>
                                    <select name="topik" x-model="filters.topik" 
                                            @change="loadVariabels()"
                                            class="w-full px-3 py-2 border border-neutral-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <option value="">Pilih Topik</option>
                                        <template x-for="topik in topiks" :key="topik.id">
                                            <option :value="topik.id" x-text="topik.nama"></option>
                                        </template>
                                    </select>
                                </div>

                                <!-- Pilih Variabel -->
                                <div>
                                    <label for="variabels" class="block text-sm font-medium text-neutral-700 mb-2">
                                        Variabel <span class="text-xs text-neutral-500">(pilih satu)</span>
                                    </label>
                                    <div class="space-y-2 max-h-32 overflow-y-auto border border-neutral-200 rounded-md p-2 bg-white" 
                                         :class="!filters.topik ? 'bg-neutral-100' : 'bg-white'">
                                        <template x-for="variabel in availableVariabels" :key="variabel.id">
                                            <label class="flex items-center cursor-pointer hover:bg-neutral-50 p-1 rounded">
                                                <input type="radio" 
                                                       :value="variabel.id" 
                                                       x-model="filters.selectedVariabel"
                                                       name="variabel"
                                                       @change="loadKlasifikasis()"
                                                       :disabled="!filters.topik"
                                                       class="border-neutral-300 text-blue-600 focus:border-blue-500 focus:ring focus:ring-blue-200">
                                                <span class="ml-2 text-sm text-neutral-700" x-text="variabel.nama + ' (' + variabel.satuan + ')'"></span>
                                            </label>
                                        </template>
                                        <div x-show="!filters.topik" class="text-sm text-neutral-500 p-2">
                                            Pilih topik terlebih dahulu
                                        </div>
                                        <div x-show="filters.topik && availableVariabels.length === 0" class="text-sm text-neutral-500 p-2">
                                            Memuat variabel...
                                        </div>
                                    </div>
                                </div>

                                <!-- Pilih Klasifikasi -->
                                <div>
                                    <label for="klasifikasis" class="block text-sm font-medium text-neutral-700 mb-2">
                                        Klasifikasi Variabel
                                    </label>
                                    <div class="space-y-2 max-h-28 overflow-y-auto border border-neutral-200 rounded-md p-2" 
                                         :class="!filters.selectedVariabel ? 'bg-neutral-100' : 'bg-white'">
                                        <template x-for="klasifikasi in availableKlasifikasis" :key="klasifikasi.id">
                                            <label class="flex items-center cursor-pointer hover:bg-neutral-50 p-1 rounded">
                                                <input type="checkbox" 
                                                       :value="klasifikasi.id" 
                                                       x-model="filters.klasifikasis"
                                                       :disabled="!filters.selectedVariabel"
                                                       class="rounded border-neutral-300 text-blue-600 focus:border-blue-500 focus:ring focus:ring-blue-200">
                                                <span class="ml-2 text-sm text-neutral-700" x-text="klasifikasi.nama"></span>
                                            </label>
                                        </template>
                                        <div x-show="!filters.selectedVariabel" class="text-sm text-neutral-500 p-2">
                                            Pilih variabel terlebih dahulu
                                        </div>
                                        <div x-show="filters.selectedVariabel && availableKlasifikasis.length === 0" class="text-sm text-neutral-500 p-2">
                                            Memuat klasifikasi...
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Time Filter Group -->
                        <div class="bg-white rounded-lg p-4 border border-neutral-200 mb-6">
                            <h4 class="text-md font-medium text-neutral-800 mb-4">Filter Waktu</h4>
                            <div class="space-y-4">
                                <!-- Tahun Selection -->
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 mb-2">
                                        Tahun
                                    </label>
                                    <div class="space-y-2">
                                        <!-- Year Selection Mode -->
                                        <div class="flex gap-2 mb-3">
                                            <label class="flex items-center cursor-pointer">
                                                <input type="radio" x-model="yearMode" value="specific" 
                                                       class="text-blue-600 focus:ring-blue-500">
                                                <span class="ml-1 text-xs text-neutral-700">Pilih Spesifik</span>
                                            </label>
                                            <label class="flex items-center cursor-pointer">
                                                <input type="radio" x-model="yearMode" value="range" 
                                                       class="text-blue-600 focus:ring-blue-500">
                                                <span class="ml-1 text-xs text-neutral-700">Rentang</span>
                                            </label>
                                            <label class="flex items-center cursor-pointer">
                                                <input type="radio" x-model="yearMode" value="all" 
                                                       class="text-blue-600 focus:ring-blue-500">
                                                <span class="ml-1 text-xs text-neutral-700">Semua</span>
                                            </label>
                                        </div>

                                        <!-- Specific Years Selection -->
                                        <div x-show="yearMode === 'specific'" class="max-h-32 overflow-y-auto border border-neutral-200 rounded-md p-2 bg-white">
                                            <template x-for="year in years" :key="year">
                                                <label class="flex items-center cursor-pointer hover:bg-neutral-50 p-1 rounded">
                                                    <input type="checkbox" 
                                                           :value="year" 
                                                           x-model="filters.selectedYears"
                                                           class="rounded border-neutral-300 text-blue-600 focus:border-blue-500 focus:ring focus:ring-blue-200">
                                                    <span class="ml-2 text-sm text-neutral-700" x-text="year"></span>
                                                </label>
                                            </template>
                                        </div>

                                        <!-- Year Range Selection -->
                                        <div x-show="yearMode === 'range'" class="grid grid-cols-2 gap-2">
                                            <div>
                                                <label class="block text-xs font-medium text-neutral-600 mb-1">Dari</label>
                                                <select x-model="filters.tahun_awal" 
                                                        @change="validateYearRange()"
                                                        class="w-full px-2 py-1 border border-neutral-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                    <option value="">Pilih Tahun</option>
                                                    <template x-for="year in years" :key="year">
                                                        <option :value="year" x-text="year"></option>
                                                    </template>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-neutral-600 mb-1">Sampai</label>
                                                <select x-model="filters.tahun_akhir" 
                                                        @change="validateYearRange()"
                                                        class="w-full px-2 py-1 border border-neutral-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                    <option value="">Pilih Tahun</option>
                                                    <template x-for="year in years" :key="year">
                                                        <option :value="year" x-text="year" :disabled="filters.tahun_awal && year < filters.tahun_awal"></option>
                                                    </template>
                                                </select>
                                            </div>
                                        </div>

                                        <div x-show="yearMode === 'all'" class="text-sm text-neutral-600 p-2 bg-blue-50 rounded">
                                            Semua tahun tersedia akan digunakan
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Region Filter Group -->
                        <div class="bg-white rounded-lg p-4 border border-neutral-200 mb-6">
                            <h4 class="text-md font-medium text-neutral-800 mb-4">Filter Wilayah</h4>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 mb-2">
                                        Pilih Wilayah
                                    </label>
                                    <div class="space-y-2">
                                        <!-- Select All/None -->
                                        <div class="flex gap-2 mb-2">
                                            <button type="button" @click="selectAllRegions()" 
                                                    class="px-2 py-1 bg-blue-500 text-white text-xs rounded hover:bg-blue-600">
                                                Pilih Semua
                                            </button>
                                            <button type="button" @click="selectNoneRegions()" 
                                                    class="px-2 py-1 bg-neutral-500 text-white text-xs rounded hover:bg-neutral-600">
                                                Kosongkan
                                            </button>
                                        </div>
                                        
                                        <!-- Region Selection -->
                                        <div class="max-h-40 overflow-y-auto border border-neutral-200 rounded-md p-2 bg-white">
                                            <template x-for="wilayah in availableRegions" :key="wilayah.id">
                                                <label class="flex items-center cursor-pointer hover:bg-neutral-50 p-1 rounded">
                                                    <input type="checkbox" 
                                                           :value="wilayah.id" 
                                                           x-model="filters.selectedRegions"
                                                           class="rounded border-neutral-300 text-blue-600 focus:border-blue-500 focus:ring focus:ring-blue-200">
                                                    <span class="ml-2 text-sm text-neutral-700" x-text="wilayah.nama"></span>
                                                </label>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Opsi Tata Letak Tabel -->
                        <div class="bg-white rounded-lg p-4 border border-neutral-200 mb-6">
                            <h4 class="text-md font-medium text-neutral-800 mb-4">📋 Opsi Tata Letak Tabel</h4>
                            <p class="text-xs text-neutral-600 mb-4">Pilih tata letak untuk menampilkan hasil data</p>
                            
                            <div class="space-y-4">
                                <!-- Tipe 1: Variabel × Tahun/Bulan -->
                                <div class="relative">
                                    <input type="radio" 
                                           id="layout-tipe1-filter"
                                           name="tata_letak"
                                           value="tipe_1"
                                           x-model="filters.tata_letak"
                                           class="sr-only">
                                    <label for="layout-tipe1-filter" 
                                           :class="filters.tata_letak === 'tipe_1' ? 'bg-blue-50 border-blue-500' : 'bg-white border-neutral-200'"
                                           class="table-layout-radio block p-3 border-2 rounded-lg cursor-pointer transition-all duration-200 hover:border-blue-300">
                                        <!-- Header -->
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center">
                                                <span class="text-sm">🌍</span>
                                                <span class="ml-2 font-medium text-neutral-900 text-sm">Tipe 1</span>
                                            </div>
                                            <div :class="filters.tata_letak === 'tipe_1' ? 'border-blue-500 bg-blue-500' : 'border-neutral-300'"
                                                 class="w-4 h-4 border-2 rounded-full flex items-center justify-center transition-all duration-200">
                                                <div :class="filters.tata_letak === 'tipe_1' ? 'opacity-100 scale-100' : 'opacity-0 scale-0'"
                                                     class="w-2 h-2 bg-white rounded-full transition-all duration-200"></div>
                                            </div>
                                        </div>
                                        
                                        <!-- Description -->
                                        <p class="text-xs text-neutral-600 mb-2">Wilayah × Variabel × Klasifikasi × Tahun</p>
                                        
                                        <!-- Mini Table Preview -->
                                        <div class="table-preview bg-neutral-50 border border-neutral-200 rounded-md overflow-hidden">
                                            <table class="preview-table w-full">
                                                <thead>
                                                    <tr class="bg-blue-500 text-white">
                                                        <th class="px-1 py-0.5 text-left border border-blue-400 text-xs">Wilayah</th>
                                                        <th class="px-1 py-0.5 text-center border border-blue-400 text-xs" colspan="2">Curah Hujan</th>
                                                    </tr>
                                                    <tr class="bg-blue-400 text-white">
                                                        <th class="px-1 py-0.5 border border-blue-300 text-xs"></th>
                                                        <th class="px-1 py-0.5 text-center border border-blue-300 text-xs">2020</th>
                                                        <th class="px-1 py-0.5 text-center border border-blue-300 text-xs">2021</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white">
                                                    <tr>
                                                        <td class="px-1 py-0.5 text-left border text-xs font-medium">Aceh</td>
                                                        <td class="px-1 py-0.5 text-right border text-xs">250</td>
                                                        <td class="px-1 py-0.5 text-right border text-xs">265</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                        <div class="mt-1 text-xs text-neutral-500">
                                            ✨ Analisis regional terstruktur
                                        </div>
                                    </label>
                                </div>

                                <!-- Tipe 2: Klasifikasi × Variabel -->
                                <div class="relative">
                                    <input type="radio" 
                                           id="layout-tipe2-filter"
                                           name="tata_letak"
                                           value="tipe_2"
                                           x-model="filters.tata_letak"
                                           class="sr-only">
                                    <label for="layout-tipe2-filter" 
                                           :class="filters.tata_letak === 'tipe_2' ? 'bg-blue-50 border-blue-500' : 'bg-white border-neutral-200'"
                                           class="table-layout-radio block p-3 border-2 rounded-lg cursor-pointer transition-all duration-200 hover:border-blue-300">
                                        <!-- Header -->
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center">
                                                <span class="text-sm">📋</span>
                                                <span class="ml-2 font-medium text-neutral-900 text-sm">Tipe 2</span>
                                            </div>
                                            <div :class="filters.tata_letak === 'tipe_2' ? 'border-blue-500 bg-blue-500' : 'border-neutral-300'"
                                                 class="w-4 h-4 border-2 rounded-full flex items-center justify-center transition-all duration-200">
                                                <div :class="filters.tata_letak === 'tipe_2' ? 'opacity-100 scale-100' : 'opacity-0 scale-0'"
                                                     class="w-2 h-2 bg-white rounded-full transition-all duration-200"></div>
                                            </div>
                                        </div>
                                        
                                        <!-- Description -->
                                        <p class="text-xs text-neutral-600 mb-2">Wilayah × Klasifikasi × Variabel × Tahun</p>
                                        
                                        <!-- Mini Table Preview -->
                                        <div class="table-preview bg-neutral-50 border border-neutral-200 rounded-md overflow-hidden">
                                            <table class="preview-table w-full">
                                                <thead>
                                                    <tr class="bg-orange-500 text-white">
                                                        <th class="px-1 py-0.5 text-left border border-orange-400 text-xs">Wilayah</th>
                                                        <th class="px-1 py-0.5 text-center border border-orange-400 text-xs" colspan="2">Padi</th>
                                                    </tr>
                                                    <tr class="bg-orange-400 text-white">
                                                        <th class="px-1 py-0.5 border border-orange-300 text-xs"></th>
                                                        <th class="px-1 py-0.5 text-center border border-orange-300 text-xs">Serangan OPT</th>
                                                        <th class="px-1 py-0.5 text-center border border-orange-300 text-xs">Puso</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white">
                                                    <tr>
                                                        <td class="px-1 py-0.5 text-left border text-xs font-medium">Jawa Barat</td>
                                                        <td class="px-1 py-0.5 text-right border text-xs">15 Ha</td>
                                                        <td class="px-1 py-0.5 text-right border text-xs">2 Ha</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                        <div class="mt-1 text-xs text-neutral-500">
                                            ✨ Komparasi per klasifikasi
                                        </div>
                                    </label>
                                </div>

                                <!-- Tipe 3: Tahun × Bulan -->
                                <div class="relative">
                                    <input type="radio" 
                                           id="layout-tipe3-filter"
                                           name="tata_letak"
                                           value="tipe_3"
                                           x-model="filters.tata_letak"
                                           class="sr-only">
                                    <label for="layout-tipe3-filter" 
                                           :class="filters.tata_letak === 'tipe_3' ? 'bg-blue-50 border-blue-500' : 'bg-white border-neutral-200'"
                                           class="table-layout-radio block p-3 border-2 rounded-lg cursor-pointer transition-all duration-200 hover:border-blue-300">
                                        <!-- Header -->
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center">
                                                <span class="text-sm">📅</span>
                                                <span class="ml-2 font-medium text-neutral-900 text-sm">Tipe 3</span>
                                            </div>
                                            <div :class="filters.tata_letak === 'tipe_3' ? 'border-blue-500 bg-blue-500' : 'border-neutral-300'"
                                                 class="w-4 h-4 border-2 rounded-full flex items-center justify-center transition-all duration-200">
                                                <div :class="filters.tata_letak === 'tipe_3' ? 'opacity-100 scale-100' : 'opacity-0 scale-0'"
                                                     class="w-2 h-2 bg-white rounded-full transition-all duration-200"></div>
                                            </div>
                                        </div>
                                        
                                        <!-- Description -->
                                        <p class="text-xs text-neutral-600 mb-2">Wilayah × Tahun × Variabel × Klasifikasi</p>
                                        
                                        <!-- Mini Table Preview -->
                                        <div class="table-preview bg-neutral-50 border border-neutral-200 rounded-md overflow-hidden">
                                            <table class="preview-table w-full">
                                                <thead>
                                                    <tr class="bg-purple-500 text-white">
                                                        <th class="px-1 py-0.5 text-left border border-purple-400 text-xs">Wilayah</th>
                                                        <th class="px-1 py-0.5 text-center border border-purple-400 text-xs">2020</th>
                                                        <th class="px-1 py-0.5 text-center border border-purple-400 text-xs">2021</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white">
                                                    <tr>
                                                        <td class="px-1 py-0.5 text-left border text-xs font-medium">Sumatera Utara</td>
                                                        <td class="px-1 py-0.5 text-right border text-xs">1,800</td>
                                                        <td class="px-1 py-0.5 text-right border text-xs">1,950</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                        <div class="mt-1 text-xs text-neutral-500">
                                            ✨ Analisis tren waktu
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Filter Queue Section -->
                        <div class="bg-white rounded-lg p-4 border border-neutral-200 mb-6">
                            <h4 class="text-md font-medium text-neutral-800 mb-4">Antrian Filter</h4>
                            
                            <!-- Add to Queue Button -->
                            <button type="button" @click="addToQueue()" :disabled="!canAddToQueue() || addingToQueue"
                                    class="w-full flex justify-center items-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:bg-neutral-400">
                                <span x-show="!addingToQueue">Tambahkan ke Antrian</span>
                                <span x-show="addingToQueue">Menambahkan...</span>
                            </button>

                            <!-- Queue List -->
                            <div x-show="filterQueue.length > 0" class="space-y-2 mt-4">
                                <template x-for="(item, index) in filterQueue" :key="item.timestamp">
                                    <div class="bg-neutral-100 p-2 rounded-md text-xs flex justify-between items-center">
                                        <span x-text="getQueueSummary(item)"></span>
                                        <button @click="removeFromQueue(index)" class="text-red-500 hover:text-red-700">&times;</button>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="space-y-3">
                            <!-- Process Queue Button -->
                            <button type="button" @click="processQueue()" :disabled="filterQueue.length === 0 || isProcessing"
                                    class="w-full flex justify-center items-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 disabled:bg-neutral-400">
                                Proses Antrian
                            </button>

                            <!-- Clear Queue Button -->
                            <button type="button" @click="clearQueue()" :disabled="filterQueue.length === 0"
                                    class="w-full flex justify-center items-center py-2 px-4 border border-neutral-300 rounded-md shadow-sm text-sm font-medium text-neutral-700 bg-white hover:bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50">
                                Bersihkan Antrian
                            </button>

                            <!-- Reset All Button -->
                            <button type="button" @click="resetAll()"
                                    class="w-full flex justify-center items-center py-2 px-4 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Reset Semua
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Results - Right Column -->
                <div class="lg:col-span-2">
                    <!-- Queue Status -->
                    <div x-show="filterQueue.length > 0 && searchResults.length === 0" class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
                        <div class="text-center">
                            <svg class="w-12 h-12 text-blue-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10m16-10v10M8 7h8m-8 5h8m-8 5h8"></path>
                            </svg>
                            <h3 class="text-lg font-medium text-blue-900 mb-2">Filter Siap Diproses</h3>
                            <p class="text-blue-700 mb-4" x-text="`Anda memiliki ${filterQueue.length} set filter dalam antrian. Klik 'Proses Antrian' untuk melihat hasilnya.`"></p>
                            <button @click="processQueue()" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                                Proses Antrian
                            </button>
                        </div>
                    </div>

                    <!-- Processing Status -->
                    <div x-show="isProcessing" class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-6">
                        <div class="text-center">
                            <svg class="animate-spin w-12 h-12 text-yellow-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <h3 class="text-lg font-medium text-yellow-900 mb-2">Memproses Data</h3>
                            <p class="text-yellow-700">
                                Harap tunggu, kami sedang mengambil dan memproses data sesuai filter Anda...
                            </p>
                        </div>
                    </div>

                    <!-- Results Container -->
                    <div x-show="searchResults.length > 0" class="space-y-6">
                        <!-- Results Header -->
                        <div class="bg-white rounded-lg shadow-sm border p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h2 class="text-2xl font-bold text-neutral-900">Hasil Laporan</h2>
                                    <p class="text-sm text-neutral-500">Ditemukan <span x-text="searchResults.length"></span> set hasil berdasarkan antrian filter Anda.</p>
                                </div>
                                <button @click="clearResults()" class="text-sm text-red-600 hover:underline">Bersihkan Hasil</button>
                            </div>
                        </div>

                        <!-- Tabs -->
                        <div class="bg-white rounded-lg shadow-sm border">
                            <!-- Tab Navigation -->
                            <div class="border-b border-neutral-200">
                                <nav class="-mb-px flex space-x-6 px-6">
                                    <button @click="activeTab = 'tabel'" :class="{'border-blue-500 text-blue-600': activeTab === 'tabel', 'border-transparent text-neutral-500 hover:text-neutral-700 hover:border-neutral-300': activeTab !== 'tabel'}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                        Tabel Data
                                    </button>
                                    <button @click="activeTab = 'grafik'" :class="{'border-blue-500 text-blue-600': activeTab === 'grafik', 'border-transparent text-neutral-500 hover:text-neutral-700 hover:border-neutral-300': activeTab !== 'grafik'}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                        Grafik
                                    </button>
                                </nav>
                            </div>

                            <!-- Tab Content -->
                            <div class="p-6">
                                <!-- Tabel Tab -->
                                <div x-show="activeTab === 'tabel'" class="space-y-8">
                                    <template x-for="(result, index) in searchResults" :key="index">
                                        <div class="border border-neutral-200 rounded-lg overflow-hidden">
                                            <div class="bg-neutral-50 p-4 border-b">
                                                <h3 class="font-semibold text-neutral-800" x-text="`Hasil #${index + 1}: ${result.topik_nama}`"></h3>
                                                <p class="text-xs text-neutral-600" x-text="getVariabelNames(result.queueItem)"></p>
                                            </div>
                                            <div class="overflow-x-auto">
                                                <table class="min-w-full divide-y divide-neutral-200">
                                                    <thead class="bg-neutral-100">
                                                        <tr>
                                                            <th class="px-4 py-2 text-left text-xs font-medium text-neutral-600 uppercase tracking-wider">Label</th>
                                                            <template x-for="header in result.headers" :key="header">
                                                                <th class="px-4 py-2 text-right text-xs font-medium text-neutral-600 uppercase tracking-wider" x-text="header"></th>
                                                            </template>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="bg-white divide-y divide-neutral-200">
                                                        <template x-for="row in result.data" :key="row.label">
                                                            <tr>
                                                                <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-neutral-900" x-text="row.label"></td>
                                                                <template x-for="value in row.values" :key="value">
                                                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-neutral-700 text-right" x-text="formatNumber(value)"></td>
                                                                </template>
                                                            </tr>
                                                        </template>
                                                    </tbody>
                                                    <tfoot class="bg-neutral-100">
                                                        <tr>
                                                            <th class="px-4 py-2 text-left text-xs font-bold text-neutral-800 uppercase">Rata-rata</th>
                                                            <template x-for="total in result.totals" :key="total">
                                                                <th class="px-4 py-2 text-right text-xs font-bold text-neutral-800" x-text="formatNumber(total)"></th>
                                                            </template>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                            <div class="bg-neutral-50 p-2 border-t text-right">
                                                <button @click="exportSingleResult(result, index)" class="text-xs bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">Export ke Excel</button>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                                <!-- Grafik Tab -->
                                <div x-show="activeTab === 'grafik'" class="space-y-8">
                                    <template x-for="(result, index) in searchResults" :key="index">
                                        <div>
                                            <h3 class="font-semibold text-neutral-800 mb-2" x-text="`Grafik #${index + 1}: ${result.topik_nama}`"></h3>
                                            <canvas :id="`chart-${index}`"></canvas>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Empty State -->
                    <div x-show="searchResults.length === 0 && filterQueue.length === 0 && !isProcessing" class="text-center py-16">
                        <svg class="w-24 h-24 text-neutral-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-neutral-900 mb-2">Siap Membuat Laporan</h3>
                        <p class="text-neutral-600 max-w-md mx-auto">
                            Lengkapi filter data di sebelah kiri, tambahkan ke antrian, dan klik "Proses Antrian" untuk menghasilkan laporan data iklim dan OPT DPI.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function iklimOptDpiForm() {
            return {
                // Form state
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
                
                // UI state
                yearMode: 'range',
                isProcessing: false,
                addingToQueue: false,
                activeTab: 'tabel',
                
                // Queue system
                filterQueue: [],
                searchResults: [],
                
                // Data from API
                availableVariabels: [],
                availableKlasifikasis: [],
                availableRegions: [],
                years: [],
                topiks: [],

                async init() {
                    console.log('Initializing Iklim & OPT DPI form...');
                    
                    // Load initial data from API
                    await this.loadInitialData();
                    
                    // Set default values
                    this.filters.tahun_awal = this.years.length > 3 ? this.years[this.years.length - 4] : '2018';
                    this.filters.tahun_akhir = this.years.length > 0 ? this.years[this.years.length - 1] : '2021';
                    this.filters.selectedRegions = this.availableRegions.map(r => r.id); // Default to all regions
                    
                    console.log('Initialization complete');
                },

                async loadInitialData() {
                    try {
                        console.log('Loading initial data from APIs...');
                        
                        const [topiks, regions, years] = await Promise.all([
                            fetch('/api/iklim-opt-dpi/topiks').then(r => r.json()),
                            fetch('/api/iklim-opt-dpi/provinces').then(r => r.json()),
                            fetch('/api/iklim-opt-dpi/years').then(r => r.json())
                        ]);

                        this.topiks = topiks;
                        this.availableRegions = regions;
                        this.years = years.sort();

                    } catch (error) {
                        console.error('Error loading initial data:', error);
                        // Fallback data
                        this.years = Array.from({length: 10}, (_, i) => 2012 + i);
                        this.topiks = [{ id: 1, nama: 'Curah Hujan (Fallback)' }];
                        this.availableRegions = [{ id: 1, nama: 'Jawa Barat (Fallback)' }];
                    }
                },

                async loadVariabels() {
                    if (!this.filters.topik) {
                        this.availableVariabels = [];
                        this.filters.selectedVariabel = '';
                        this.availableKlasifikasis = [];
                        this.filters.klasifikasis = [];
                        return;
                    }

                    try {
                        const response = await fetch(`/api/iklim-opt-dpi/variabels/${this.filters.topik}`);
                        this.availableVariabels = await response.json();
                        this.filters.selectedVariabel = '';
                        this.loadKlasifikasis();
                    } catch (error) {
                        console.error('Error loading variabels:', error);
                        this.availableVariabels = [];
                    }
                },

                async loadKlasifikasis() {
                    if (!this.filters.selectedVariabel) {
                        this.availableKlasifikasis = [];
                        this.filters.klasifikasis = [];
                        return;
                    }

                    try {
                        const response = await fetch('/api/iklim-opt-dpi/klasifikasis', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                variabel_ids: [this.filters.selectedVariabel]
                            })
                        });
                        
                        this.availableKlasifikasis = await response.json();
                        
                        if (this.availableKlasifikasis.length > 0) {
                            this.filters.klasifikasis = this.availableKlasifikasis.map(k => k.id.toString());
                        } else {
                            this.filters.klasifikasis = [];
                        }
                    } catch (error) {
                        console.error('Error loading klasifikasis:', error);
                        this.availableKlasifikasis = [];
                    }
                },

                validateYearRange() {
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
