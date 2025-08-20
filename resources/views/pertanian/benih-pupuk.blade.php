<x-layouts.landing title="Laporan Data Benih dan Pupuk">
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
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-neutral-500">Pertanian</span>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-neutral-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-blue-600 font-medium">Laporan Benih & Pupuk</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-neutral-900 mb-4">
                    Laporan Data Benih dan Pupuk
                </h1>
                <p class="text-xl text-neutral-600">
                    Cari dan analisis data ketersediaan benih dan pupuk pertanian di Indonesia
                </p>
            </div>

            <!-- Two Column Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8" x-data="benihPupukForm()">
                <!-- Search Form - Left Column -->
                <div class="lg:col-span-1">
                    <div class="bg-neutral-50 rounded-lg p-6 sticky top-24">
                        <h3 class="text-lg font-semibold text-neutral-900 mb-6">Filter Data Pertanian</h3>
                        
                        <!-- Data Filter Group -->
                        <div class="bg-white rounded-lg p-4 border border-neutral-200 mb-6">
                            <h4 class="text-md font-medium text-neutral-800 mb-4">Filter Data</h4>
                            <div class="space-y-4">
                                <!-- Pilih Topik -->
                                <div>
                                    <label for="topik" class="block text-sm font-medium text-neutral-700 mb-2">
                                        Topik
                                    </label>
                                    <select x-model="filters.topik" 
                                            @change="loadVariabels()"
                                            class="w-full px-3 py-2 border border-neutral-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <option value="">Pilih Topik</option>
                                        <option value="1">Benih</option>
                                        <option value="2">Pupuk</option>
                                    </select>
                                </div>

                                <!-- Pilih Variabel -->
                                <div>
                                    <label for="variabels" class="block text-sm font-medium text-neutral-700 mb-2">
                                        Variabel
                                    </label>
                                    <div class="space-y-2 max-h-32 overflow-y-auto border border-neutral-200 rounded-md p-2 bg-white" 
                                         :class="!filters.topik ? 'bg-neutral-100' : 'bg-white'">
                                        <template x-for="variabel in availableVariabels" :key="variabel.id">
                                            <label class="flex items-center cursor-pointer hover:bg-neutral-50 p-1 rounded">
                                                <input type="checkbox" 
                                                       :value="variabel.id" 
                                                       x-model="filters.variabels"
                                                       @change="loadKlasifikasis()"
                                                       :disabled="!filters.topik"
                                                       class="rounded border-neutral-300 text-blue-600 focus:border-blue-500 focus:ring focus:ring-blue-200">
                                                <span class="ml-2 text-sm text-neutral-700" x-text="variabel.deskripsi + ' (' + variabel.satuan + ')'"></span>
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
                                         :class="filters.variabels.length === 0 ? 'bg-neutral-100' : 'bg-white'">
                                        <template x-for="klasifikasi in availableKlasifikasis" :key="klasifikasi.id">
                                            <label class="flex items-center cursor-pointer hover:bg-neutral-50 p-1 rounded">
                                                <input type="checkbox" 
                                                       :value="klasifikasi.id" 
                                                       x-model="filters.klasifikasis"
                                                       :disabled="filters.variabels.length === 0"
                                                       class="rounded border-neutral-300 text-blue-600 focus:border-blue-500 focus:ring focus:ring-blue-200">
                                                <span class="ml-2 text-sm text-neutral-700" x-text="klasifikasi.deskripsi"></span>
                                            </label>
                                        </template>
                                        <div x-show="filters.variabels.length === 0" class="text-sm text-neutral-500 p-2">
                                            Pilih variabel terlebih dahulu
                                        </div>
                                        <div x-show="filters.variabels.length > 0 && availableKlasifikasis.length === 0" class="text-sm text-neutral-500 p-2">
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
                                            Semua tahun (2014-2025) akan digunakan
                                        </div>
                                    </div>
                                </div>

                                <!-- Bulan Selection (Required) -->
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 mb-2">
                                        Bulan <span class="text-red-500">*</span>
                                    </label>
                                    <div class="space-y-2">
                                        <!-- Month Selection Mode -->
                                        <div class="flex gap-2 mb-3">
                                            <label class="flex items-center cursor-pointer">
                                                <input type="radio" x-model="monthMode" value="specific" 
                                                       class="text-blue-600 focus:ring-blue-500">
                                                <span class="ml-1 text-xs text-neutral-700">Pilih Spesifik</span>
                                            </label>
                                            <label class="flex items-center cursor-pointer">
                                                <input type="radio" x-model="monthMode" value="range" 
                                                       class="text-blue-600 focus:ring-blue-500">
                                                <span class="ml-1 text-xs text-neutral-700">Rentang</span>
                                            </label>
                                            <label class="flex items-center cursor-pointer">
                                                <input type="radio" x-model="monthMode" value="all" 
                                                       class="text-blue-600 focus:ring-blue-500">
                                                <span class="ml-1 text-xs text-neutral-700">Semua</span>
                                            </label>
                                        </div>

                                        <!-- Specific Months Selection -->
                                        <div x-show="monthMode === 'specific'" class="grid grid-cols-2 gap-1 max-h-32 overflow-y-auto border border-neutral-200 rounded-md p-2 bg-white">
                                            <template x-for="bulan in bulans" :key="bulan.id">
                                                <label class="flex items-center cursor-pointer hover:bg-neutral-50 p-1 rounded">
                                                    <input type="checkbox" 
                                                           :value="bulan.id" 
                                                           x-model="filters.selectedMonths"
                                                           class="rounded border-neutral-300 text-blue-600 focus:border-blue-500 focus:ring focus:ring-blue-200">
                                                    <span class="ml-1 text-xs text-neutral-700" x-text="bulan.nama.substring(0,3)"></span>
                                                </label>
                                            </template>
                                        </div>

                                        <!-- Month Range Selection -->
                                        <div x-show="monthMode === 'range'" class="grid grid-cols-2 gap-2">
                                            <div>
                                                <label class="block text-xs font-medium text-neutral-600 mb-1">Dari</label>
                                                <select x-model="filters.bulan_awal" 
                                                        class="w-full px-2 py-1 border border-neutral-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                    <option value="">Pilih Bulan</option>
                                                    <template x-for="bulan in bulans" :key="bulan.id">
                                                        <option :value="bulan.id" x-text="bulan.nama"></option>
                                                    </template>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-neutral-600 mb-1">Sampai</label>
                                                <select x-model="filters.bulan_akhir" 
                                                        class="w-full px-2 py-1 border border-neutral-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                    <option value="">Pilih Bulan</option>
                                                    <template x-for="bulan in bulans" :key="bulan.id">
                                                        <option :value="bulan.id" x-text="bulan.nama" :disabled="filters.bulan_awal && bulan.id < filters.bulan_awal"></option>
                                                    </template>
                                                </select>
                                            </div>
                                        </div>

                                        <div x-show="monthMode === 'all'" class="text-sm text-neutral-600 p-2 bg-blue-50 rounded">
                                            Semua bulan (Januari-Desember) akan digunakan
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
                                           name="layout-filter"
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
                                                 class="w-3 h-3 border-2 rounded-full flex items-center justify-center transition-all duration-200">
                                                <div :class="filters.tata_letak === 'tipe_1' ? 'opacity-100 scale-100' : 'opacity-0 scale-0'"
                                                     class="w-1.5 h-1.5 bg-white rounded-full transition-all duration-200"></div>
                                            </div>
                                        </div>
                                        
                                        <!-- Description -->
                                        <p class="text-xs text-neutral-600 mb-2">Wilayah × Variabel × Klasifikasi × Tahun × Bulan</p>
                                        
                                        <!-- Mini Table Preview -->
                                        <div class="table-preview bg-neutral-50 border border-neutral-200 rounded-md overflow-hidden">
                                            <table class="preview-table w-full">
                                                <thead>
                                                    <tr class="bg-green-500 text-white">
                                                        <th class="px-1 py-0.5 text-left border border-green-400 text-xs">Wilayah</th>
                                                        <th class="px-1 py-0.5 text-center border border-green-400 text-xs" colspan="2">Benih</th>
                                                    </tr>
                                                    <tr class="bg-green-400 text-white">
                                                        <th class="px-1 py-0.5 border border-green-300 text-xs"></th>
                                                        <th class="px-1 py-0.5 text-center border border-green-300 text-xs">Inbrida</th>
                                                        <th class="px-1 py-0.5 text-center border border-green-300 text-xs">Hibrida</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white">
                                                    <tr>
                                                        <td class="px-1 py-0.5 text-left border text-xs font-medium">Aceh</td>
                                                        <td class="px-1 py-0.5 text-right border text-xs">1,250</td>
                                                        <td class="px-1 py-0.5 text-right border text-xs">1,380</td>
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
                                           name="layout-filter"
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
                                                 class="w-3 h-3 border-2 rounded-full flex items-center justify-center transition-all duration-200">
                                                <div :class="filters.tata_letak === 'tipe_2' ? 'opacity-100 scale-100' : 'opacity-0 scale-0'"
                                                     class="w-1.5 h-1.5 bg-white rounded-full transition-all duration-200"></div>
                                            </div>
                                        </div>
                                        
                                        <!-- Description -->
                                        <p class="text-xs text-neutral-600 mb-2">Wilayah × Klasifikasi × Variabel × Tahun × Bulan</p>
                                        
                                        <!-- Mini Table Preview -->
                                        <div class="table-preview bg-neutral-50 border border-neutral-200 rounded-md overflow-hidden">
                                            <table class="preview-table w-full">
                                                <thead>
                                                    <tr class="bg-green-500 text-white">
                                                        <th class="px-1 py-0.5 text-left border border-green-400 text-xs">Wilayah</th>
                                                        <th class="px-1 py-0.5 text-center border border-green-400 text-xs" colspan="2">Inbrida</th>
                                                    </tr>
                                                    <tr class="bg-green-400 text-white">
                                                        <th class="px-1 py-0.5 border border-green-300 text-xs"></th>
                                                        <th class="px-1 py-0.5 text-center border border-green-300 text-xs">Benih</th>
                                                        <th class="px-1 py-0.5 text-center border border-green-300 text-xs">Pupuk</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white">
                                                    <tr>
                                                        <td class="px-1 py-0.5 text-left border text-xs font-medium">Aceh</td>
                                                        <td class="px-1 py-0.5 text-right border text-xs">850</td>
                                                        <td class="px-1 py-0.5 text-right border text-xs">920</td>
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
                                           name="layout-filter"
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
                                                 class="w-3 h-3 border-2 rounded-full flex items-center justify-center transition-all duration-200">
                                                <div :class="filters.tata_letak === 'tipe_3' ? 'opacity-100 scale-100' : 'opacity-0 scale-0'"
                                                     class="w-1.5 h-1.5 bg-white rounded-full transition-all duration-200"></div>
                                            </div>
                                        </div>
                                        
                                        <!-- Description -->
                                        <p class="text-xs text-neutral-600 mb-2">Wilayah × Tahun × Bulan × Variabel × Klasifikasi</p>
                                        
                                        <!-- Mini Table Preview -->
                                        <div class="table-preview bg-neutral-50 border border-neutral-200 rounded-md overflow-hidden">
                                            <table class="preview-table w-full">
                                                <thead>
                                                    <tr class="bg-green-500 text-white">
                                                        <th class="px-1 py-0.5 text-left border border-green-400 text-xs">Wilayah</th>
                                                        <th class="px-1 py-0.5 text-center border border-green-400 text-xs" colspan="2">2023</th>
                                                    </tr>
                                                    <tr class="bg-green-400 text-white">
                                                        <th class="px-1 py-0.5 border border-green-300 text-xs"></th>
                                                        <th class="px-1 py-0.5 text-center border border-green-300 text-xs">Jan</th>
                                                        <th class="px-1 py-0.5 text-center border border-green-300 text-xs">Feb</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white">
                                                    <tr>
                                                        <td class="px-1 py-0.5 text-left border text-xs font-medium">Aceh</td>
                                                        <td class="px-1 py-0.5 text-right border text-xs">1,250</td>
                                                        <td class="px-1 py-0.5 text-right border text-xs">2,100</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                        <div class="mt-1 text-xs text-neutral-500">
                                            ✨ Analisis temporal regional
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="mt-3 text-xs text-neutral-500">
                                💡 Tata letak akan diterapkan pada semua hasil
                            </div>
                        </div>

                        <!-- Filter Queue Section -->
                        <div class="bg-white rounded-lg p-4 border border-neutral-200 mb-6">
                            <h4 class="text-md font-medium text-neutral-800 mb-4">Antrian Filter</h4>
                            
                            <!-- Add to Queue Button -->
                            <button type="button" 
                                    @click="addToQueue()"
                                    :disabled="!canAddToQueue()"
                                    :class="canAddToQueue() ? 'bg-green-600 hover:bg-green-700' : 'bg-neutral-400 cursor-not-allowed'"
                                    class="w-full text-white px-4 py-2 rounded-md font-medium transition duration-200 mb-4">
                                <span x-show="!addingToQueue">Tambahkan ke Antrian</span>
                                <span x-show="addingToQueue">Menambahkan...</span>
                            </button>

                            <!-- Queue List -->
                            <div x-show="filterQueue.length > 0" class="space-y-2">
                                <h5 class="text-sm font-medium text-neutral-700">Antrian Filter:</h5>
                                <template x-for="(queueItem, index) in filterQueue" :key="index">
                                    <div class="bg-neutral-50 p-3 rounded border border-neutral-200">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <div class="text-sm font-medium text-neutral-800" x-text="`Filter ${index + 1}`"></div>
                                                <div class="text-xs text-neutral-600 mt-1" x-text="getQueueSummary(queueItem)"></div>
                                            </div>
                                            <button @click="removeFromQueue(index)" 
                                                    class="text-red-600 hover:text-red-800 text-xs ml-2">
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="space-y-3">
                            <!-- Process Queue Button -->
                            <button type="button" 
                                    @click="processQueue()"
                                    :disabled="filterQueue.length === 0"
                                    :class="filterQueue.length > 0 ? 'bg-blue-600 hover:bg-blue-700' : 'bg-neutral-400 cursor-not-allowed'"
                                    class="w-full text-white px-4 py-2 rounded-md font-medium transition duration-200">
                                <span x-show="!isProcessing">Proses Antrian (<span x-text="filterQueue.length"></span>)</span>
                                <span x-show="isProcessing" class="flex items-center justify-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Memproses...
                                </span>
                            </button>

                            <!-- Clear Queue Button -->
                            <button type="button" 
                                    @click="clearQueue()"
                                    :disabled="filterQueue.length === 0"
                                    class="w-full bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md font-medium transition duration-200 disabled:bg-neutral-400 disabled:cursor-not-allowed">
                                Kosongkan Antrian
                            </button>

                            <!-- Reset All Button -->
                            <button type="button" 
                                    @click="resetAll()"
                                    class="w-full bg-neutral-500 hover:bg-neutral-600 text-white px-4 py-2 rounded-md font-medium transition duration-200">
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                            <h3 class="text-lg font-medium text-blue-900 mb-2">Filter Siap Diproses</h3>
                            <p class="text-blue-700 mb-4">
                                Anda memiliki <span class="font-semibold" x-text="filterQueue.length"></span> filter dalam antrian. 
                                Klik "Proses Antrian" untuk menghasilkan laporan.
                            </p>
                            <button @click="processQueue()" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium transition duration-200">
                                Proses Sekarang
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
                                Sedang memproses <span x-text="filterQueue.length"></span> filter. Mohon tunggu...
                            </p>
                        </div>
                    </div>

                    <!-- Results Container -->
                    <div x-show="searchResults.length > 0" class="space-y-6">
                        <!-- Results Header -->
                        <div class="bg-white rounded-lg shadow-sm border p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-xl font-semibold text-neutral-900">
                                    Hasil Pencarian (<span x-text="searchResults.length"></span> dataset)
                                </h3>
                                <button @click="exportToExcel()" 
                                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-200 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Export Excel
                                </button>
                            </div>
                            
                            <!-- Results Summary -->
                            <div class="text-sm text-neutral-600 bg-green-50 p-4 rounded-md">
                                <p><strong>Total Dataset:</strong> <span x-text="searchResults.length"></span></p>
                                <p><strong>Dihasilkan:</strong> <span x-text="new Date().toLocaleString('id-ID')"></span></p>
                                <p class="text-xs text-neutral-500 mt-2">
                                    Klik tab "Grafik" untuk melihat visualisasi data, atau "Metodologi" untuk penjelasan data
                                </p>
                            </div>
                        </div>

                        <!-- Tabs -->
                        <div class="bg-white rounded-lg shadow-sm border">
                            <!-- Tab Navigation -->
                            <div class="border-b border-neutral-200">
                                <nav class="flex space-x-8 px-6" aria-label="Tabs">
                                    <button @click="activeTab = 'tabel'" 
                                            :class="activeTab === 'tabel' ? 'border-blue-500 text-blue-600' : 'border-transparent text-neutral-500 hover:text-neutral-700 hover:border-neutral-300'"
                                            class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap">
                                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 6h18m-9 8h9m-9 4h9M3 14h6m-6 4h6"></path>
                                        </svg>
                                        Tabel
                                    </button>
                                    <button @click="activeTab = 'grafik'" 
                                            :class="activeTab === 'grafik' ? 'border-blue-500 text-blue-600' : 'border-transparent text-neutral-500 hover:text-neutral-700 hover:border-neutral-300'"
                                            class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap">
                                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                        Grafik
                                    </button>
                                    <button @click="activeTab = 'metodologi'" 
                                            :class="activeTab === 'metodologi' ? 'border-blue-500 text-blue-600' : 'border-transparent text-neutral-500 hover:text-neutral-700 hover:border-neutral-300'"
                                            class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap">
                                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Metodologi
                                    </button>
                                </nav>
                            </div>

                            <!-- Tab Content -->
                            <div class="p-6">
                                <!-- Tabel Tab -->
                                <div x-show="activeTab === 'tabel'" class="space-y-8">
                                    <template x-for="(result, index) in searchResults" :key="index">
                                        <div class="border border-neutral-200 rounded-lg overflow-hidden">
                                            <!-- Result Header -->
                                            <div class="bg-green-600 text-white px-6 py-4">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <h4 class="text-xl font-bold mb-1" x-text="result.topik_nama"></h4>
                                                        <div class="text-green-100 text-sm" x-text="getQueueSummary(result.queueItem)"></div>
                                                    </div>
                                                    <div class="flex items-center space-x-3">
                                                        <span class="bg-white text-green-700 text-xs font-bold px-3 py-1 rounded-full" 
                                                              x-text="`Hasil #${result.resultIndex}`"></span>
                                                        <button @click="exportSingleResult(result, index)" 
                                                                class="bg-green-500 hover:bg-green-400 text-white px-3 py-1 rounded text-xs font-medium transition duration-200">
                                                            📊 Export
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Filter Summary Bar -->
                                            <div class="bg-green-50 border-b border-green-200 px-6 py-3">
                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                                    <div>
                                                        <span class="font-medium text-green-800">Variabel:</span>
                                                        <span class="text-green-700" x-text="getVariabelNames(result.queueItem)"></span>
                                                    </div>
                                                    <div>
                                                        <span class="font-medium text-green-800">Klasifikasi:</span>
                                                        <span class="text-green-700" x-text="getKlasifikasiNames(result.queueItem)"></span>
                                                    </div>
                                                    <div>
                                                        <span class="font-medium text-green-800">Periode:</span>
                                                        <span class="text-green-700" x-text="getPeriodSummary(result.queueItem)"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Enhanced Data Table -->
                                            <div class="overflow-x-auto">
                                                <!-- Tipe 1: Wilayah × Variabel × Klasifikasi × Tahun × Bulan -->
                                                <div x-show="result.queueItem.tata_letak === 'tipe_1'">
                                                    <table class="min-w-full border-collapse">
                                                        <thead>
                                                            <!-- Level 1: Variabel Header -->
                                                            <tr class="bg-green-500">
                                                                <th rowspan="4" class="px-4 py-3 text-center text-xs font-bold text-white uppercase border border-green-400 sticky left-0 bg-green-500 z-20 min-w-[150px]">
                                                                    Wilayah
                                                                </th>
                                                                <template x-for="(variabel, vIndex) in result.selectedVariabels" :key="`var-${vIndex}`">
                                                                    <th :colspan="result.selectedKlasifikasis.length * result.yearGroups.length * result.yearGroups[0].months.length" 
                                                                        class="px-2 py-2 text-center text-xs font-bold text-white uppercase border border-green-400"
                                                                        x-text="variabel.deskripsi || `Variabel ${vIndex + 1}`"></th>
                                                                </template>
                                                            </tr>
                                                            <!-- Level 2: Klasifikasi Header -->
                                                            <tr class="bg-green-600">
                                                                <template x-for="(variabel, vIndex) in result.selectedVariabels" :key="`var2-${vIndex}`">
                                                                    <template x-for="(klasifikasi, kIndex) in result.selectedKlasifikasis" :key="`klas-${kIndex}`">
                                                                        <th :colspan="result.yearGroups.length * result.yearGroups[0].months.length"
                                                                            class="px-2 py-2 text-center text-xs font-bold text-white border border-green-300"
                                                                            x-text="klasifikasi.deskripsi || `Klasifikasi ${kIndex + 1}`"></th>
                                                                    </template>
                                                                </template>
                                                            </tr>
                                                            <!-- Level 3: Tahun Header -->
                                                            <tr class="bg-green-400">
                                                                <template x-for="(variabel, vIndex) in result.selectedVariabels" :key="`var3-${vIndex}`">
                                                                    <template x-for="(klasifikasi, kIndex) in result.selectedKlasifikasis" :key="`klas3-${kIndex}`">
                                                                        <template x-for="(yearGroup, yearIndex) in result.yearGroups" :key="`year-${yearIndex}`">
                                                                            <th :colspan="yearGroup.months.length" 
                                                                                class="px-2 py-2 text-center text-xs font-medium text-white border border-green-300"
                                                                                x-text="yearGroup.year"></th>
                                                                        </template>
                                                                    </template>
                                                                </template>
                                                            </tr>
                                                            <!-- Level 4: Bulan Header -->
                                                            <tr class="bg-green-300">
                                                                <template x-for="(variabel, vIndex) in result.selectedVariabels" :key="`var4-${vIndex}`">
                                                                    <template x-for="(klasifikasi, kIndex) in result.selectedKlasifikasis" :key="`klas4-${kIndex}`">
                                                                        <template x-for="(yearGroup, yearIndex) in result.yearGroups" :key="`year4-${yearIndex}`">
                                                                            <template x-for="(month, mIndex) in yearGroup.months" :key="`month-${mIndex}`">
                                                                                <th class="px-1 py-2 text-center text-xs font-medium text-white border border-green-200 min-w-[60px]"
                                                                                    x-text="month.nama ? month.nama.substring(0, 3) : `M${mIndex + 1}`"></th>
                                                                            </template>
                                                                        </template>
                                                                    </template>
                                                                </template>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="bg-white">
                                                            <template x-for="(region, regionIndex) in result.queueItem.selectedRegions.slice(0, 5)" :key="`region-${regionIndex}`">
                                                                <tr class="hover:bg-green-50 transition-colors duration-150" :class="regionIndex % 2 === 0 ? 'bg-gray-50' : 'bg-white'">
                                                                    <td class="px-4 py-3 text-sm font-medium text-neutral-900 border border-neutral-300 sticky left-0 bg-white z-10"
                                                                        x-text="getRegionName(region)"></td>
                                                                    <template x-for="(variabel, vIndex) in result.selectedVariabels" :key="`reg-var-${vIndex}`">
                                                                        <template x-for="(klasifikasi, kIndex) in result.selectedKlasifikasis" :key="`reg-klas-${kIndex}`">
                                                                            <template x-for="(yearGroup, yearIndex) in result.yearGroups" :key="`reg-year-${yearIndex}`">
                                                                                <template x-for="(month, mIndex) in yearGroup.months" :key="`reg-month-${mIndex}`">
                                                                                    <td class="px-1 py-2 text-sm text-right text-neutral-700 border border-neutral-200 min-w-[60px]"
                                                                                        x-text="formatNumber(Math.floor(Math.random() * 5000) + 1000)"></td>
                                                                                </template>
                                                                            </template>
                                                                        </template>
                                                                    </template>
                                                                </tr>
                                                            </template>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <!-- Tipe 2: Wilayah × Klasifikasi Variabel × Variabel × Tahun × Bulan -->
                                                <div x-show="result.queueItem.tata_letak === 'tipe_2'">
                                                    <table class="min-w-full border-collapse">
                                                        <thead>
                                                            <!-- Level 1: Klasifikasi Variabel Header -->
                                                            <tr class="bg-green-500">
                                                                <th rowspan="4" class="px-4 py-3 text-center text-xs font-bold text-white uppercase border border-green-400 sticky left-0 bg-green-500 z-20 min-w-[150px]">
                                                                    Wilayah
                                                                </th>
                                                                <template x-for="(klasifikasi, kIndex) in result.selectedKlasifikasis" :key="`klas-${kIndex}`">
                                                                    <th :colspan="result.selectedVariabels.length * result.yearGroups.length * result.yearGroups[0].months.length" 
                                                                        class="px-2 py-2 text-center text-xs font-bold text-white uppercase border border-green-400"
                                                                        x-text="`Klasifikasi ${klasifikasi.deskripsi || kIndex + 1}`"></th>
                                                                </template>
                                                            </tr>
                                                            <!-- Level 2: Variabel Header -->
                                                            <tr class="bg-green-600">
                                                                <template x-for="(klasifikasi, kIndex) in result.selectedKlasifikasis" :key="`klas2-${kIndex}`">
                                                                    <template x-for="(variabel, vIndex) in result.selectedVariabels" :key="`var2-${vIndex}`">
                                                                        <th :colspan="result.yearGroups.length * result.yearGroups[0].months.length"
                                                                            class="px-2 py-2 text-center text-xs font-bold text-white border border-green-300"
                                                                            x-text="`Variabel ${(variabel.deskripsi || '').substring(0, 15)}${(variabel.deskripsi || '').length > 15 ? '...' : ''} ${vIndex + 1}`"></th>
                                                                    </template>
                                                                </template>
                                                            </tr>
                                                            <!-- Level 3: Tahun Header -->
                                                            <tr class="bg-green-400">
                                                                <template x-for="(klasifikasi, kIndex) in result.selectedKlasifikasis" :key="`klas3-${kIndex}`">
                                                                    <template x-for="(variabel, vIndex) in result.selectedVariabels" :key="`var3-${vIndex}`">
                                                                        <template x-for="(yearGroup, yearIndex) in result.yearGroups" :key="`year3-${yearIndex}`">
                                                                            <th :colspan="yearGroup.months.length" 
                                                                                class="px-2 py-2 text-center text-xs font-medium text-white border border-green-300"
                                                                                x-text="`Tahun ${yearGroup.year}`"></th>
                                                                        </template>
                                                                    </template>
                                                                </template>
                                                            </tr>
                                                            <!-- Level 4: Bulan Header -->
                                                            <tr class="bg-green-300">
                                                                <template x-for="(klasifikasi, kIndex) in result.selectedKlasifikasis" :key="`klas4-${kIndex}`">
                                                                    <template x-for="(variabel, vIndex) in result.selectedVariabels" :key="`var4-${vIndex}`">
                                                                        <template x-for="(yearGroup, yearIndex) in result.yearGroups" :key="`year4-${yearIndex}`">
                                                                            <template x-for="(month, mIndex) in yearGroup.months" :key="`month4-${mIndex}`">
                                                                                <th class="px-1 py-2 text-center text-xs font-medium text-white border border-green-200 min-w-[60px]"
                                                                                    x-text="month.nama ? month.nama.substring(0, 3) : `M${mIndex + 1}`"></th>
                                                                            </template>
                                                                        </template>
                                                                    </template>
                                                                </template>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="bg-white">
                                                            <template x-for="(region, regionIndex) in result.queueItem.selectedRegions.slice(0, 5)" :key="`region2-${regionIndex}`">
                                                                <tr class="hover:bg-green-50 transition-colors duration-150" :class="regionIndex % 2 === 0 ? 'bg-gray-50' : 'bg-white'">
                                                                    <td class="px-4 py-3 text-sm font-medium text-neutral-900 border border-neutral-300 sticky left-0 bg-white z-10"
                                                                        x-text="getRegionName(region)"></td>
                                                                    <template x-for="(klasifikasi, kIndex) in result.selectedKlasifikasis" :key="`reg2-klas-${kIndex}`">
                                                                        <template x-for="(variabel, vIndex) in result.selectedVariabels" :key="`reg2-var-${vIndex}`">
                                                                            <template x-for="(yearGroup, yearIndex) in result.yearGroups" :key="`reg2-year-${yearIndex}`">
                                                                                <template x-for="(month, mIndex) in yearGroup.months" :key="`reg2-month-${mIndex}`">
                                                                                    <td class="px-1 py-2 text-sm text-right text-neutral-700 border border-neutral-200 min-w-[60px]"
                                                                                        x-text="formatNumber(Math.floor(Math.random() * 8000) + 2000)"></td>
                                                                                </template>
                                                                            </template>
                                                                        </template>
                                                                    </template>
                                                                </tr>
                                                            </template>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <!-- Tipe 3: Wilayah × Tahun × Bulan × Variabel × Klasifikasi -->
                                                <div x-show="result.queueItem.tata_letak === 'tipe_3'">
                                                    <table class="min-w-full border-collapse">
                                                        <thead>
                                                            <!-- Level 1: Tahun Header -->
                                                            <tr class="bg-green-500">
                                                                <th rowspan="4" class="px-4 py-3 text-center text-xs font-bold text-white uppercase border border-green-400 sticky left-0 bg-green-500 z-20 min-w-[150px]">
                                                                    Wilayah
                                                                </th>
                                                                <template x-for="(yearGroup, yearIndex) in result.yearGroups" :key="`year-${yearIndex}`">
                                                                    <th :colspan="yearGroup.months.length * result.selectedVariabels.length * result.selectedKlasifikasis.length" 
                                                                        class="px-2 py-2 text-center text-xs font-bold text-white uppercase border border-green-400"
                                                                        x-text="`Tahun ${yearGroup.year}`"></th>
                                                                </template>
                                                            </tr>
                                                            <!-- Level 2: Bulan Header -->
                                                            <tr class="bg-green-600">
                                                                <template x-for="(yearGroup, yearIndex) in result.yearGroups" :key="`year2-${yearIndex}`">
                                                                    <template x-for="(month, mIndex) in yearGroup.months" :key="`month2-${mIndex}`">
                                                                        <th :colspan="result.selectedVariabels.length * result.selectedKlasifikasis.length"
                                                                            class="px-2 py-2 text-center text-xs font-bold text-white border border-green-300"
                                                                            x-text="month.nama || `Bulan ${mIndex + 1}`"></th>
                                                                    </template>
                                                                </template>
                                                            </tr>
                                                            <!-- Level 3: Variabel Header -->
                                                            <tr class="bg-green-400">
                                                                <template x-for="(yearGroup, yearIndex) in result.yearGroups" :key="`year3-${yearIndex}`">
                                                                    <template x-for="(month, mIndex) in yearGroup.months" :key="`month3-${mIndex}`">
                                                                        <template x-for="(variabel, vIndex) in result.selectedVariabels" :key="`var3-${vIndex}`">
                                                                            <th :colspan="result.selectedKlasifikasis.length" 
                                                                                class="px-2 py-2 text-center text-xs font-medium text-white border border-green-300"
                                                                                x-text="(variabel.deskripsi || `Variabel ${vIndex + 1}`).substring(0, 12) + ((variabel.deskripsi || '').length > 12 ? '...' : '')"></th>
                                                                        </template>
                                                                    </template>
                                                                </template>
                                                            </tr>
                                                            <!-- Level 4: Klasifikasi Header -->
                                                            <tr class="bg-green-300">
                                                                <template x-for="(yearGroup, yearIndex) in result.yearGroups" :key="`year4-${yearIndex}`">
                                                                    <template x-for="(month, mIndex) in yearGroup.months" :key="`month4-${mIndex}`">
                                                                        <template x-for="(variabel, vIndex) in result.selectedVariabels" :key="`var4-${vIndex}`">
                                                                            <template x-for="(klasifikasi, kIndex) in result.selectedKlasifikasis" :key="`klas4-${kIndex}`">
                                                                                <th class="px-1 py-2 text-center text-xs font-medium text-white border border-green-200 min-w-[50px]"
                                                                                    x-text="(klasifikasi.deskripsi || `K${kIndex + 1}`).substring(0, 6)"></th>
                                                                            </template>
                                                                        </template>
                                                                    </template>
                                                                </template>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="bg-white">
                                                            <template x-for="(region, regionIndex) in result.queueItem.selectedRegions.slice(0, 5)" :key="`region3-${regionIndex}`">
                                                                <tr class="hover:bg-green-50 transition-colors duration-150" :class="regionIndex % 2 === 0 ? 'bg-gray-50' : 'bg-white'">
                                                                    <td class="px-4 py-3 text-sm font-medium text-neutral-900 border border-neutral-300 sticky left-0 bg-white z-10"
                                                                        x-text="getRegionName(region)"></td>
                                                                    <template x-for="(yearGroup, yearIndex) in result.yearGroups" :key="`reg3-year-${yearIndex}`">
                                                                        <template x-for="(month, mIndex) in yearGroup.months" :key="`reg3-month-${mIndex}`">
                                                                            <template x-for="(variabel, vIndex) in result.selectedVariabels" :key="`reg3-var-${vIndex}`">
                                                                                <template x-for="(klasifikasi, kIndex) in result.selectedKlasifikasis" :key="`reg3-klas-${kIndex}`">
                                                                                    <td class="px-1 py-2 text-sm text-right text-neutral-700 border border-neutral-200 min-w-[50px]"
                                                                                        x-text="formatNumber(Math.floor(Math.random() * 5000) + 1000)"></td>
                                                                                </template>
                                                                            </template>
                                                                        </template>
                                                                    </template>
                                                                </tr>
                                                            </template>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <!-- Table Footer with Statistics -->
                                            <div class="bg-neutral-50 border-t border-neutral-200 px-6 py-4">
                                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
                                                    <div class="text-center">
                                                        <div class="text-neutral-500">Data Entries</div>
                                                        <div class="font-bold text-green-600" x-text="result.totalEntries || 0"></div>
                                                    </div>
                                                    <div class="text-center">
                                                        <div class="text-neutral-500">Avg Value</div>
                                                        <div class="font-bold text-blue-600" x-text="formatNumber(result.averageValue || 0)"></div>
                                                    </div>
                                                    <div class="text-center">
                                                        <div class="text-neutral-500">Max Value</div>
                                                        <div class="font-bold text-orange-600" x-text="formatNumber(result.maxValue || 0)"></div>
                                                    </div>
                                                    <div class="text-center">
                                                        <div class="text-neutral-500">Min Value</div>
                                                        <div class="font-bold text-red-600" x-text="formatNumber(result.minValue || 0)"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <!-- Grafik Tab -->
                                <div x-show="activeTab === 'grafik'">
                                    <template x-for="(result, index) in searchResults" :key="index">
                                        <div class="mb-8 border border-neutral-200 rounded-lg p-6">
                                            <div class="flex justify-between items-start mb-4">
                                                <div>
                                                    <h4 class="text-lg font-semibold text-neutral-900" x-text="result.topik_nama"></h4>
                                                    <div class="text-sm text-neutral-600 mt-1" x-text="getQueueSummary(result.queueItem)"></div>
                                                </div>
                                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full" 
                                                      x-text="`Grafik ${result.resultIndex}`"></span>
                                            </div>
                                            <div class="bg-white border border-neutral-200 rounded-lg p-6">
                                                <canvas :id="`chart-${index}`" width="400" height="200"></canvas>
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <!-- Metodologi Tab -->
                                <div x-show="activeTab === 'metodologi'">
                                    @include('pertanian.metodologi')
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
                            Lengkapi filter data di sebelah kiri, tambahkan ke antrian, dan klik "Proses Antrian" untuk menghasilkan laporan data benih dan pupuk.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function benihPupukForm() {
            return {
                // Form state
                filters: {
                    topik: '',
                    variabels: [],
                    klasifikasis: [],
                    selectedYears: [],
                    tahun_awal: '',
                    tahun_akhir: '',
                    selectedMonths: [],
                    bulan_awal: '',
                    bulan_akhir: '',
                    selectedRegions: [],
                    tata_letak: 'tipe_1'
                },
                
                // UI state
                yearMode: 'range',
                monthMode: 'all',
                isProcessing: false,
                addingToQueue: false,
                activeTab: 'tabel',
                
                // Queue system
                filterQueue: [],
                searchResults: [],
                
                // Data
                availableVariabels: [],
                availableKlasifikasis: [],
                availableRegions: [
                    { id: 1, nama: 'Aceh' },
                    { id: 2, nama: 'Sumatera Utara' },
                    { id: 3, nama: 'Sumatera Barat' },
                    { id: 4, nama: 'Riau' },
                    { id: 5, nama: 'Jambi' },
                    { id: 6, nama: 'Sumatera Selatan' },
                    { id: 7, nama: 'Bengkulu' },
                    { id: 8, nama: 'Lampung' },
                    { id: 9, nama: 'Bangka Belitung' },
                    { id: 10, nama: 'Kepulauan Riau' },
                    { id: 11, nama: 'DKI Jakarta' },
                    { id: 12, nama: 'Jawa Barat' },
                    { id: 13, nama: 'Jawa Tengah' },
                    { id: 14, nama: 'DI Yogyakarta' },
                    { id: 15, nama: 'Jawa Timur' },
                    { id: 16, nama: 'Banten' },
                    { id: 17, nama: 'Bali' },
                    { id: 18, nama: 'Nusa Tenggara Barat' },
                    { id: 19, nama: 'Nusa Tenggara Timur' },
                    { id: 20, nama: 'Kalimantan Barat' },
                    { id: 21, nama: 'Kalimantan Tengah' },
                    { id: 22, nama: 'Kalimantan Selatan' },
                    { id: 23, nama: 'Kalimantan Timur' },
                    { id: 24, nama: 'Kalimantan Utara' },
                    { id: 25, nama: 'Sulawesi Utara' },
                    { id: 26, nama: 'Sulawesi Tengah' },
                    { id: 27, nama: 'Sulawesi Selatan' },
                    { id: 28, nama: 'Sulawesi Tenggara' },
                    { id: 29, nama: 'Gorontalo' },
                    { id: 30, nama: 'Sulawesi Barat' },
                    { id: 31, nama: 'Maluku' },
                    { id: 32, nama: 'Maluku Utara' },
                    { id: 33, nama: 'Papua Barat' },
                    { id: 34, nama: 'Papua' }
                ],
                years: [],
                bulans: [
                    { id: 1, nama: 'Januari' },
                    { id: 2, nama: 'Februari' },
                    { id: 3, nama: 'Maret' },
                    { id: 4, nama: 'April' },
                    { id: 5, nama: 'Mei' },
                    { id: 6, nama: 'Juni' },
                    { id: 7, nama: 'Juli' },
                    { id: 8, nama: 'Agustus' },
                    { id: 9, nama: 'September' },
                    { id: 10, nama: 'Oktober' },
                    { id: 11, nama: 'November' },
                    { id: 12, nama: 'Desember' }
                ],

                // Sample data structure
                variabelsData: {
                    '1': [ // Benih
                        { id: 9, deskripsi: 'Padi Benih Pokok', satuan: 'Ton', klasifikasi_ids: [2, 3] },
                        { id: 1, deskripsi: 'Padi Benih Sebar', satuan: 'Ton', klasifikasi_ids: [2, 3] },
                        { id: 2, deskripsi: 'Jagung Benih Sebar', satuan: 'Ton', klasifikasi_ids: [3, 4] },
                        { id: 3, deskripsi: 'Kedelai Benih Sebar', satuan: 'Ton', klasifikasi_ids: [1] }
                    ],
                    '2': [ // Pupuk
                        { id: 4, deskripsi: 'Pupuk Urea', satuan: 'Ton', klasifikasi_ids: [5, 6] },
                        { id: 5, deskripsi: 'Pupuk SP-36', satuan: 'Ton', klasifikasi_ids: [5, 6] },
                        { id: 6, deskripsi: 'Pupuk ZA', satuan: 'Ton', klasifikasi_ids: [5, 6] },
                        { id: 7, deskripsi: 'Pupuk NPK', satuan: 'Ton', klasifikasi_ids: [5, 6] },
                        { id: 8, deskripsi: 'Pupuk Organik', satuan: 'Ton', klasifikasi_ids: [5, 6] }
                    ]
                },

                klasifikasisData: {
                    1: { id: 1, deskripsi: '-' },
                    2: { id: 2, deskripsi: 'Inbrida' },
                    3: { id: 3, deskripsi: 'Hibrida' },
                    4: { id: 4, deskripsi: 'Komposit' },
                    5: { id: 5, deskripsi: 'Alokasi' },
                    6: { id: 6, deskripsi: 'Realisasi' }
                },

                init() {
                    // Generate years from 2014 to current year
                    const currentYear = new Date().getFullYear();
                    for (let year = 2014; year <= currentYear; year++) {
                        this.years.push(year);
                    }
                    
                    // Set default values
                    this.filters.tahun_awal = '2020';
                    this.filters.tahun_akhir = '2022';
                    this.filters.selectedRegions = [1, 2, 3, 4, 5]; // Default to first 5 regions
                    this.filters.selectedMonths = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]; // All months by default
                },

                loadVariabels() {
                    this.availableVariabels = this.variabelsData[this.filters.topik] || [];
                    this.filters.variabels = [];
                    this.loadKlasifikasis();
                },

                loadKlasifikasis() {
                    const klasifikasiIds = new Set();
                    this.filters.variabels.forEach(variabelId => {
                        const variabel = this.availableVariabels.find(v => v.id == variabelId);
                        if (variabel) {
                            variabel.klasifikasi_ids.forEach(id => klasifikasiIds.add(id));
                        }
                    });
                    
                    this.availableKlasifikasis = Array.from(klasifikasiIds).map(id => this.klasifikasisData[id]).filter(k => k);
                    this.filters.klasifikasis = [];
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
                    return this.filters.topik && 
                           this.filters.variabels.length > 0 && 
                           this.filters.klasifikasis.length > 0 && 
                           this.hasValidTimeFilter() &&
                           this.filters.selectedRegions.length > 0;
                },

                hasValidTimeFilter() {
                    // Year validation
                    const hasValidYears = this.yearMode === 'all' || 
                                         (this.yearMode === 'specific' && this.filters.selectedYears.length > 0) ||
                                         (this.yearMode === 'range' && this.filters.tahun_awal && this.filters.tahun_akhir);
                    
                    // Month validation (required)
                    const hasValidMonths = this.monthMode === 'all' || 
                                          (this.monthMode === 'specific' && this.filters.selectedMonths.length > 0) ||
                                          (this.monthMode === 'range' && this.filters.bulan_awal && this.filters.bulan_akhir);
                    
                    return hasValidYears && hasValidMonths;
                },

                async addToQueue() {
                    if (!this.canAddToQueue()) return;

                    this.addingToQueue = true;
                    await new Promise(resolve => setTimeout(resolve, 500)); // Simulate processing

                    // Create a deep copy of current filters
                    const queueItem = {
                        ...JSON.parse(JSON.stringify(this.filters)),
                        yearMode: this.yearMode,
                        monthMode: this.monthMode,
                        timestamp: Date.now()
                    };

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

                    // Process each item in queue
                    for (let i = 0; i < this.filterQueue.length; i++) {
                        const queueItem = this.filterQueue[i];
                        
                        // Simulate processing delay
                        await new Promise(resolve => setTimeout(resolve, 800));
                        
                        // Generate result for this queue item
                        const result = this.generateResultForQueueItem(queueItem, i + 1);
                        this.searchResults.push(result);
                    }

                    this.isProcessing = false;
                    this.activeTab = 'tabel';

                    // Create charts after results are rendered
                    this.$nextTick(() => {
                        this.createCharts();
                    });
                },

                generateResultForQueueItem(queueItem, resultIndex) {
                    const topikNama = queueItem.topik === '1' ? 'Benih' : 'Pupuk';
                    
                    // Get years based on mode
                    let years = [];
                    if (queueItem.yearMode === 'all') {
                        years = this.years.slice();
                    } else if (queueItem.yearMode === 'specific') {
                        years = queueItem.selectedYears.map(y => parseInt(y)).sort();
                    } else if (queueItem.yearMode === 'range') {
                        for (let year = parseInt(queueItem.tahun_awal); year <= parseInt(queueItem.tahun_akhir); year++) {
                            years.push(year);
                        }
                    }

                    // Get months based on mode
                    let months = [];
                    if (queueItem.monthMode === 'all') {
                        months = this.bulans.slice();
                    } else if (queueItem.monthMode === 'specific') {
                        months = this.bulans.filter(b => queueItem.selectedMonths.includes(b.id));
                    } else if (queueItem.monthMode === 'range') {
                        months = this.bulans.filter(b => b.id >= queueItem.bulan_awal && b.id <= queueItem.bulan_akhir);
                    }

                    // Get selected regions, variabels, and klasifikasis
                    const selectedRegions = this.availableRegions.filter(r => queueItem.selectedRegions.includes(r.id));
                    let selectedVariabels = this.availableVariabels.filter(v => queueItem.variabels.includes(v.id));
                    let selectedKlasifikasis = this.availableKlasifikasis.filter(k => queueItem.klasifikasis.includes(k.id));

                    // Fallback: if no selections, use defaults to prevent empty tables
                    if (selectedVariabels.length === 0) {
                        selectedVariabels = this.variabelsData[queueItem.topik]?.slice(0, 2) || [
                            { id: 1, deskripsi: 'Default Variabel 1', satuan: 'Ton' },
                            { id: 2, deskripsi: 'Default Variabel 2', satuan: 'Ton' }
                        ];
                    }
                    if (selectedKlasifikasis.length === 0) {
                        selectedKlasifikasis = Object.values(this.klasifikasisData).slice(0, 2) || [
                            { id: 1, deskripsi: 'Default Klasifikasi 1' },
                            { id: 2, deskripsi: 'Default Klasifikasi 2' }
                        ];
                    }
                    if (years.length === 0) {
                        years = [2020, 2021, 2022];
                    }
                    if (months.length === 0) {
                        months = this.bulans.slice(0, 6); // First 6 months
                    }

                    // Create year groups with months
                    const yearGroups = years.map(year => ({
                        year: year,
                        months: months
                    }));

                    // Create month groups with variabels for Tipe 3
                    const monthGroups = months.map(month => ({
                        bulan: month.nama,
                        variabels: selectedVariabels.map(v => ({
                            id: v.id,
                            nama: v.deskripsi.substring(0, 15) + (v.deskripsi.length > 15 ? '...' : ''),
                            satuan: v.satuan
                        }))
                    }));

                    // Generate detailed data structure for enhanced table
                    let detailData = [];
                    let regionTotals = [];
                    let grandTotals = [];
                    let allValues = [];

                    // Generate data based on combinations of variabel and klasifikasi
                    selectedVariabels.forEach(variabel => {
                        selectedKlasifikasis.forEach(klasifikasi => {
                            const rowValues = [];
                            yearGroups.forEach(yearGroup => {
                                yearGroup.months.forEach(month => {
                                    const value = Math.floor(Math.random() * 10000) + 1000;
                                    rowValues.push(value);
                                    allValues.push(value);
                                });
                            });

                            detailData.push({
                                variabel: variabel.deskripsi,
                                klasifikasi: klasifikasi.deskripsi,
                                satuan: variabel.satuan,
                                values: rowValues
                            });
                        });
                    });

                    // Calculate regional totals
                    selectedRegions.slice(0, 5).forEach(region => {
                        const regionTotal = [];
                        const totalColumns = yearGroups.length * months.length;
                        
                        for (let col = 0; col < totalColumns; col++) {
                            const sum = detailData.reduce((acc, row) => acc + (row.values[col] || 0), 0);
                            regionTotal.push(Math.floor(sum * (0.8 + Math.random() * 0.4))); // Vary regional totals
                        }
                        
                        regionTotals.push({
                            nama: region.nama,
                            totals: regionTotal
                        });
                    });

                    // Calculate grand totals
                    const totalColumns = yearGroups.length * months.length;
                    for (let col = 0; col < totalColumns; col++) {
                        const grandTotal = regionTotals.reduce((acc, region) => acc + (region.totals[col] || 0), 0);
                        grandTotals.push(grandTotal);
                    }

                    // Generate yearly data for Tipe 3
                    const yearlyData = years.map(year => ({
                        year: year,
                        monthValues: months.flatMap(month => 
                            selectedVariabels.map(() => Math.floor(Math.random() * 5000) + 1000)
                        )
                    }));

                    // Calculate statistics
                    const totalEntries = detailData.length * (yearGroups.length * months.length);
                    const averageValue = allValues.length > 0 ? allValues.reduce((a, b) => a + b, 0) / allValues.length : 0;
                    const maxValue = allValues.length > 0 ? Math.max(...allValues) : 0;
                    const minValue = allValues.length > 0 ? Math.min(...allValues) : 0;

                    // Generate simple headers and data for backward compatibility
                    let headers = [];
                    let data = [];
                    
                    if (queueItem.tata_letak === 'tipe_1') {
                        headers = years.map(y => y.toString());
                        data = selectedRegions.slice(0, 5).map(region => ({
                            label: region.nama,
                            values: years.map(() => Math.floor(Math.random() * 10000) + 1000)
                        }));
                    } else if (queueItem.tata_letak === 'tipe_2') {
                        headers = years.map(y => y.toString());
                        data = selectedKlasifikasis.map(klasifikasi => ({
                            label: klasifikasi.deskripsi,
                            values: years.map(() => Math.floor(Math.random() * 8000) + 2000)
                        }));
                    } else if (queueItem.tata_letak === 'tipe_3') {
                        headers = months.map(m => m.nama.substring(0, 3));
                        data = years.slice(0, 3).map(year => ({
                            label: year.toString(),
                            values: months.map(() => Math.floor(Math.random() * 5000) + 1000)
                        }));
                    }

                    // Calculate totals for backward compatibility
                    const totals = headers.map((_, index) => 
                        data.reduce((sum, row) => sum + row.values[index], 0)
                    );

                    return {
                        resultIndex: resultIndex,
                        topik_nama: `${topikNama} - Hasil ${resultIndex}`,
                        headers: headers,
                        data: data,
                        totals: totals,
                        queueItem: queueItem,
                        
                        // Enhanced data structure
                        yearGroups: yearGroups,
                        monthGroups: monthGroups,
                        detailData: detailData,
                        regionTotals: regionTotals,
                        grandTotals: grandTotals,
                        selectedVariabels: selectedVariabels,
                        selectedKlasifikasis: selectedKlasifikasis,
                        yearlyData: yearlyData,
                        
                        // Statistics
                        totalEntries: totalEntries,
                        averageValue: averageValue,
                        maxValue: maxValue,
                        minValue: minValue
                    };
                },

                createCharts() {
                    this.searchResults.forEach((result, index) => {
                        const ctx = document.getElementById(`chart-${index}`);
                        if (!ctx) return;

                        const colors = [
                            'rgb(34, 197, 94)', 'rgb(59, 130, 246)', 'rgb(168, 85, 247)',
                            'rgb(239, 68, 68)', 'rgb(245, 158, 11)', 'rgb(16, 185, 129)',
                            'rgb(139, 92, 246)', 'rgb(236, 72, 153)', 'rgb(6, 182, 212)'
                        ];

                        new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: result.headers,
                                datasets: result.data.slice(0, 5).map((row, idx) => ({
                                    label: row.label,
                                    data: row.values,
                                    backgroundColor: colors[idx % colors.length] + '20',
                                    borderColor: colors[idx % colors.length],
                                    borderWidth: 2,
                                    tension: 0.4
                                }))
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    title: {
                                        display: true,
                                        text: result.topik_nama + ' - Trend Data'
                                    },
                                    legend: {
                                        display: true,
                                        position: 'top'
                                    }
                                },
                                scales: {
                                    x: {
                                        title: {
                                            display: true,
                                            text: result.queueItem.tata_letak === 'tipe_3' ? 'Bulan' : 'Tahun'
                                        }
                                    },
                                    y: {
                                        title: {
                                            display: true,
                                            text: 'Nilai (Ton)'
                                        },
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    });
                },

                resetAll() {
                    this.filters = {
                        topik: '',
                        variabels: [],
                        klasifikasis: [],
                        selectedYears: [],
                        tahun_awal: '2020',
                        tahun_akhir: '2022',
                        selectedMonths: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                        bulan_awal: '',
                        bulan_akhir: '',
                        selectedRegions: [1, 2, 3, 4, 5],
                        tata_letak: 'tipe_1'
                    };
                    
                    this.yearMode = 'range';
                    this.monthMode = 'all';
                    this.availableVariabels = [];
                    this.availableKlasifikasis = [];
                    this.filterQueue = [];
                    this.searchResults = [];
                },

                getQueueSummary(queueItem) {
                    const topik = queueItem.topik === '1' ? 'Benih' : 'Pupuk';
                    const variabelCount = queueItem.variabels.length;
                    const klasifikasiCount = queueItem.klasifikasis.length;
                    const regionCount = queueItem.selectedRegions.length;
                    
                    let timeRange = '';
                    if (queueItem.yearMode === 'all') {
                        timeRange = 'Semua tahun';
                    } else if (queueItem.yearMode === 'specific') {
                        timeRange = `${queueItem.selectedYears.length} tahun`;
                    } else {
                        timeRange = `${queueItem.tahun_awal}-${queueItem.tahun_akhir}`;
                    }
                    
                    return `${topik} • ${variabelCount} variabel • ${klasifikasiCount} klasifikasi • ${regionCount} wilayah • ${timeRange}`;
                },

                getVariabelNames(queueItem) {
                    const selectedVariabels = this.availableVariabels.filter(v => queueItem.variabels.includes(v.id));
                    if (selectedVariabels.length === 0) return '-';
                    if (selectedVariabels.length <= 2) {
                        return selectedVariabels.map(v => v.deskripsi).join(', ');
                    }
                    return `${selectedVariabels[0].deskripsi}, ${selectedVariabels[1].deskripsi} (+${selectedVariabels.length - 2} lainnya)`;
                },

                getKlasifikasiNames(queueItem) {
                    const selectedKlasifikasis = this.availableKlasifikasis.filter(k => queueItem.klasifikasis.includes(k.id));
                    if (selectedKlasifikasis.length === 0) return '-';
                    if (selectedKlasifikasis.length <= 3) {
                        return selectedKlasifikasis.map(k => k.deskripsi).join(', ');
                    }
                    return `${selectedKlasifikasis.slice(0, 3).map(k => k.deskripsi).join(', ')} (+${selectedKlasifikasis.length - 3} lainnya)`;
                },

                getRegionName(regionId) {
                    const region = this.availableRegions.find(r => r.id == regionId);
                    return region ? region.nama : `Wilayah ${regionId}`;
                },

                getPeriodSummary(queueItem) {
                    let yearSummary = '';
                    if (queueItem.yearMode === 'all') {
                        yearSummary = 'Semua tahun';
                    } else if (queueItem.yearMode === 'specific') {
                        const years = queueItem.selectedYears.sort();
                        yearSummary = years.length <= 3 ? years.join(', ') : `${years.slice(0, 3).join(', ')} (+${years.length - 3})`;
                    } else {
                        yearSummary = `${queueItem.tahun_awal}-${queueItem.tahun_akhir}`;
                    }

                    let monthSummary = '';
                    if (queueItem.monthMode === 'all') {
                        monthSummary = 'Semua bulan';
                    } else if (queueItem.monthMode === 'specific') {
                        const months = this.bulans.filter(b => queueItem.selectedMonths.includes(b.id));
                        monthSummary = months.length <= 3 ? months.map(m => m.nama.substring(0, 3)).join(', ') : 
                                     `${months.slice(0, 3).map(m => m.nama.substring(0, 3)).join(', ')} (+${months.length - 3})`;
                    } else {
                        const startMonth = this.bulans.find(b => b.id == queueItem.bulan_awal)?.nama.substring(0, 3) || '';
                        const endMonth = this.bulans.find(b => b.id == queueItem.bulan_akhir)?.nama.substring(0, 3) || '';
                        monthSummary = `${startMonth}-${endMonth}`;
                    }

                    return `${yearSummary} | ${monthSummary}`;
                },

                exportSingleResult(result, index) {
                    const wb = XLSX.utils.book_new();
                    
                    // Export the enhanced table data based on display type
                    let wsData = [];
                    
                    if (result.queueItem.tata_letak === 'tipe_1') {
                        // Multi-level header for Tipe 1
                        const mainHeaders = ['Variabel'];
                        const subHeaders = [''];
                        
                        result.yearGroups.forEach(yearGroup => {
                            yearGroup.months.forEach(month => {
                                mainHeaders.push(`${yearGroup.year}`);
                                subHeaders.push(month.nama.substring(0, 3));
                            });
                        });
                        
                        wsData.push(mainHeaders);
                        wsData.push(subHeaders);
                        
                        // Data rows
                        result.detailData.forEach(row => {
                            wsData.push([`${row.variabel} (${row.klasifikasi})`, ...row.values]);
                        });
                        
                        // Regional totals
                        result.regionTotals.forEach(region => {
                            wsData.push([`TOTAL ${region.nama}`, ...region.totals]);
                        });
                        
                        // Grand total
                        wsData.push(['TOTAL KESELURUHAN', ...result.grandTotals]);
                        
                    } else {
                        // Fallback to simple structure
                        const headerRow = ['Label', ...result.headers];
                        wsData.push(headerRow);
                        
                        result.data.forEach(row => {
                            wsData.push([row.label, ...row.values]);
                        });
                        
                        if (result.totals) {
                            wsData.push(['TOTAL', ...result.totals]);
                        }
                    }
                    
                    const ws = XLSX.utils.aoa_to_sheet(wsData);
                    XLSX.utils.book_append_sheet(wb, ws, `Hasil_${result.resultIndex}`);
                    
                    const topikName = result.queueItem.topik === '1' ? 'benih' : 'pupuk';
                    XLSX.writeFile(wb, `laporan-${topikName}-hasil-${result.resultIndex}-${new Date().toISOString().split('T')[0]}.xlsx`);
                },

                formatNumber(value) {
                    if (value === null || value === undefined) return '-';
                    return new Intl.NumberFormat('id-ID', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 2
                    }).format(value);
                },

                exportToExcel() {
                    if (this.searchResults.length === 0) return;

                    const wb = XLSX.utils.book_new();
                    
                    this.searchResults.forEach((result, index) => {
                        const wsData = [];
                        
                        // Add headers
                        const headerRow = ['Label', ...result.headers];
                        wsData.push(headerRow);
                        
                        // Add data
                        result.data.forEach(row => {
                            wsData.push([row.label, ...row.values]);
                        });
                        
                        // Add totals
                        if (result.totals) {
                            wsData.push(['TOTAL', ...result.totals]);
                        }
                        
                        const ws = XLSX.utils.aoa_to_sheet(wsData);
                        XLSX.utils.book_append_sheet(wb, ws, `Hasil_${result.resultIndex}`);
                    });
                    
                    XLSX.writeFile(wb, `laporan-benih-pupuk-${new Date().toISOString().split('T')[0]}.xlsx`);
                }
            };
        }
    </script>
</x-layouts.landing>
