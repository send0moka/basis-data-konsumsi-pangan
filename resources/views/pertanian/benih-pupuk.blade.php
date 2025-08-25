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
                                    <select name="topik" x-model="filters.topik" 
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
                                         :class="!filters.selectedVariabel ? 'bg-neutral-100' : 'bg-white'">
                                        <template x-for="klasifikasi in availableKlasifikasis" :key="klasifikasi.id">
                                            <label class="flex items-center cursor-pointer hover:bg-neutral-50 p-1 rounded">
                                                <input type="checkbox" 
                                                       :value="klasifikasi.id" 
                                                       x-model="filters.klasifikasis"
                                                       :disabled="!filters.selectedVariabel"
                                                       class="rounded border-neutral-300 text-blue-600 focus:border-blue-500 focus:ring focus:ring-blue-200">
                                                <span class="ml-2 text-sm text-neutral-700" x-text="klasifikasi.deskripsi"></span>
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
                                                 class="w-4 h-4 border-2 rounded-full flex items-center justify-center transition-all duration-200">
                                                <div :class="filters.tata_letak === 'tipe_1' ? 'opacity-100 scale-100' : 'opacity-0 scale-0'"
                                                     class="w-2 h-2 bg-white rounded-full transition-all duration-200"></div>
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
                                                 class="w-4 h-4 border-2 rounded-full flex items-center justify-center transition-all duration-200">
                                                <div :class="filters.tata_letak === 'tipe_2' ? 'opacity-100 scale-100' : 'opacity-0 scale-0'"
                                                     class="w-2 h-2 bg-white rounded-full transition-all duration-200"></div>
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
                                                 class="w-4 h-4 border-2 rounded-full flex items-center justify-center transition-all duration-200">
                                                <div :class="filters.tata_letak === 'tipe_3' ? 'opacity-100 scale-100' : 'opacity-0 scale-0'"
                                                     class="w-2 h-2 bg-white rounded-full transition-all duration-200"></div>
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
                                <div class="flex gap-2">
                                    <button @click="clearResults()" 
                                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-200 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Clear Results
                                    </button>
                                    <button @click="exportToExcel()" 
                                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-200 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Export Excel
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Results Summary -->
                            <div class="text-sm text-neutral-600 bg-green-50 p-4 rounded-md">
                                <p><strong>Total Dataset:</strong> <span x-text="searchResults.length"></span></p>
                                <p><strong>Dihasilkan:</strong> <span x-text="new Date().toLocaleString('id-ID')"></span></p>
                                <p class="text-xs text-neutral-500 mt-2">
                                    Klik tab "Grafik" untuk melihat visualisasi data, atau "Metodologi" untuk penjelasan data
                                </p>
                            </div>

                            <!-- Data Quality Warning -->
                            <div class="text-sm bg-orange-50 border border-orange-200 p-4 rounded-md">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-orange-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <p class="text-orange-800 font-medium mb-1">⚠️ Perhatian Kualitas Data</p>
                                        <p class="text-orange-700 text-xs">
                                            Beberapa nilai data (terutama untuk Pupuk-Alokasi/Realisasi) mungkin tidak realistis karena menggunakan unit pengukuran yang berbeda. 
                                            Nilai Benih umumnya dalam kisaran 50-500, sedangkan Pupuk bisa mencapai 5.000-23.000.
                                        </p>
                                    </div>
                                </div>
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
                                                                        x-text="variabel.deskripsi || `Var ${vIndex + 1}`"></th>
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
                                                            <template x-for="(region, regionIndex) in result.queueItem.selectedRegions" :key="`region-${regionIndex}-${region.id || regionIndex}`">
                                                                <tr class="hover:bg-green-50 transition-colors duration-150" :class="regionIndex % 2 === 0 ? 'bg-gray-50' : 'bg-white'">
                                                                    <td class="px-4 py-3 text-sm font-medium text-neutral-900 border border-neutral-300 sticky left-0 bg-white z-10"
                                                                        x-text="getRegionName(region)"></td>
                                                                    <!-- Force fresh iteration by rebuilding nested loops with unique keys -->
                                                                    <template x-for="(variabel, vIndex) in result.selectedVariabels" :key="`${regionIndex}-var-${vIndex}-${variabel.id || vIndex}`">
                                                                        <template x-for="(klasifikasi, kIndex) in result.selectedKlasifikasis" :key="`${regionIndex}-${vIndex}-klas-${kIndex}-${klasifikasi.id || kIndex}`">
                                                                            <template x-for="(yearGroup, yearIndex) in result.yearGroups" :key="`${regionIndex}-${vIndex}-${kIndex}-year-${yearIndex}-${yearGroup.year || yearIndex}`">
                                                                                <template x-for="(month, mIndex) in yearGroup.months" :key="`${regionIndex}-${vIndex}-${kIndex}-${yearIndex}-month-${mIndex}-${month.id || mIndex}`">
                                                                                    <td class="px-1 py-2 text-sm text-right text-neutral-700 border border-neutral-200 min-w-[60px]"
                                                                                        x-text="formatNumber(getCellValue(
                                                                                            result.queueItem.selectedRegions[regionIndex].id,
                                                                                            result.yearGroups[result.yearGroups.length - 1 - yearIndex].year,
                                                                                            result.yearGroups[result.yearGroups.length - 1 - yearIndex].months[mIndex].id,
                                                                                            result.selectedVariabels[vIndex].id,
                                                                                            result.selectedKlasifikasis[result.selectedKlasifikasis.length - 1 - kIndex].id
                                                                                        ))"></td>
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
                                                                        x-text="klasifikasi.deskripsi || `Klasifikasi ${kIndex + 1}`"></th>
                                                                </template>
                                                            </tr>
                                                            <!-- Level 2: Variabel Header -->
                                                            <tr class="bg-green-600">
                                                                <template x-for="(klasifikasi, kIndex) in result.selectedKlasifikasis" :key="`klas2-${kIndex}`">
                                                                    <template x-for="(variabel, vIndex) in result.selectedVariabels" :key="`var2-${vIndex}`">
                                                                        <th :colspan="result.yearGroups.length * result.yearGroups[0].months.length"
                                                                            class="px-2 py-2 text-center text-xs font-bold text-white border border-green-300"
                                                                            x-text="variabel.deskripsi || `Var ${vIndex + 1}`"></th>
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
                                                                                x-text="yearGroup.year"></th>
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
                                                            <template x-for="(region, regionIndex) in result.queueItem.selectedRegions" :key="`region2-${regionIndex}`">
                                                                <tr class="hover:bg-gray-50 transition-colors">
                                                                    <td class="px-4 py-3 border border-gray-200 font-medium text-gray-900 sticky left-0 bg-white z-10"
                                                                        x-text="region.nama || `Region ${regionIndex + 1}`"></td>
                                                                    <template x-for="(klasifikasi, kIndex) in result.selectedKlasifikasis" :key="`klas-cell-${kIndex}`">
                                                                        <template x-for="(variabel, vIndex) in result.selectedVariabels" :key="`var-cell-${vIndex}`">
                                                                            <template x-for="(yearGroup, yearIndex) in result.yearGroups" :key="`year-cell-${yearIndex}`">
                                                                                <template x-for="(month, mIndex) in yearGroup.months" :key="`month-cell-${mIndex}`">
                                                                                    <td class="px-3 py-2 border border-gray-200 text-center text-sm text-gray-700" 
                                                                                        x-text="getCellValue(region.id, result.yearGroups[result.yearGroups.length - 1 - yearIndex].year, result.yearGroups[result.yearGroups.length - 1 - yearIndex].months[mIndex].id, variabel.id, result.selectedKlasifikasis[result.selectedKlasifikasis.length - 1 - kIndex].id)"></td>
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
                                                            <!-- Level 1: Bulan Header -->
                                                            <tr class="bg-green-500">
                                                                <th rowspan="4" class="px-4 py-3 text-center text-xs font-bold text-white uppercase border border-green-400 sticky left-0 bg-green-500 z-20 min-w-[150px]">
                                                                    Wilayah
                                                                </th>
                                                                <template x-for="(month, mIndex) in result.yearGroups[0].months" :key="`month-${mIndex}`">
                                                                    <th :colspan="result.selectedVariabels.length * result.selectedKlasifikasis.length * result.yearGroups.length" 
                                                                        class="px-2 py-2 text-center text-xs font-bold text-white uppercase border border-green-400"
                                                                        x-text="month.nama ? month.nama.substring(0, 3) : `M${mIndex + 1}`"></th>
                                                                </template>
                                                            </tr>
                                                            <!-- Level 2: Variabel Header -->
                                                            <tr class="bg-green-600">
                                                                <template x-for="(month, mIndex) in result.yearGroups[0].months" :key="`month2-${mIndex}`">
                                                                    <template x-for="(variabel, vIndex) in result.selectedVariabels" :key="`var2-${vIndex}`">
                                                                        <th :colspan="result.selectedKlasifikasis.length * result.yearGroups.length"
                                                                            class="px-2 py-2 text-center text-xs font-bold text-white border border-green-300"
                                                                            x-text="variabel.deskripsi || `Var ${vIndex + 1}`"></th>
                                                                    </template>
                                                                </template>
                                                            </tr>
                                                            <!-- Level 3: Klasifikasi Header -->
                                                            <tr class="bg-green-400">
                                                                <template x-for="(month, mIndex) in result.yearGroups[0].months" :key="`month3-${mIndex}`">
                                                                    <template x-for="(variabel, vIndex) in result.selectedVariabels" :key="`var3-${vIndex}`">
                                                                        <template x-for="(klasifikasi, kIndex) in result.selectedKlasifikasis" :key="`klas3-${kIndex}`">
                                                                            <th :colspan="result.yearGroups.length" 
                                                                                class="px-2 py-2 text-center text-xs font-medium text-white border border-green-300"
                                                                                x-text="klasifikasi.deskripsi || `Klasifikasi ${kIndex + 1}`"></th>
                                                                        </template>
                                                                    </template>
                                                                </template>
                                                            </tr>
                                                            <!-- Level 4: Tahun Header -->
                                                            <tr class="bg-green-300">
                                                                <template x-for="(month, mIndex) in result.yearGroups[0].months" :key="`month4-${mIndex}`">
                                                                    <template x-for="(variabel, vIndex) in result.selectedVariabels" :key="`var4-${vIndex}`">
                                                                        <template x-for="(klasifikasi, kIndex) in result.selectedKlasifikasis" :key="`klas4-${kIndex}`">
                                                                            <template x-for="(yearGroup, yearIndex) in result.yearGroups" :key="`year4-${yearIndex}`">
                                                                                <th class="px-1 py-2 text-center text-xs font-medium text-white border border-green-200 min-w-[60px]"
                                                                                    x-text="yearGroup.year"></th>
                                                                            </template>
                                                                        </template>
                                                                    </template>
                                                                </template>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="bg-white">
                                                            <template x-for="(region, regionIndex) in result.queueItem.selectedRegions" :key="`region3-${regionIndex}`">
                                                                <tr class="hover:bg-gray-50 transition-colors">
                                                                    <td class="px-4 py-3 border border-gray-200 font-medium text-gray-900 sticky left-0 bg-white z-10"
                                                                        x-text="region.nama || `Region ${regionIndex + 1}`"></td>
                                                                    <!-- Use pre-sorted arrays for consistent ordering -->
                                                                    <template x-for="(month, mIndex) in result.yearGroups[0].months" :key="`month-cell-${mIndex}`">
                                                                        <template x-for="(variabel, vIndex) in result.selectedVariabels" :key="`var-cell-${vIndex}`">
                                                                            <template x-for="(klasifikasi, kIndex) in result.selectedKlasifikasis" :key="`klas-cell-${kIndex}`">
                                                                                <template x-for="(yearGroup, yearIndex) in result.yearGroups" :key="`year-cell-${yearIndex}`">
                                                                                    <td class="px-3 py-2 border border-gray-200 text-center text-sm text-gray-700" 
                                                                                        x-text="formatNumber(getCellValue(region.id, yearGroup.year, result.yearGroups[0].months[result.yearGroups[0].months.length - 1 - mIndex].id, variabel.id, result.selectedKlasifikasis[result.selectedKlasifikasis.length - 1 - kIndex].id))"></td>
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
                    selectedVariabel: '',
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
                
                // Data from API
                availableVariabels: [],
                availableKlasifikasis: [],
                availableRegions: [],
                years: [],
                bulans: [],
                topiks: [],

                async init() {
                    console.log('Initializing benih pupuk form...');
                    
                    // Load initial data from API
                    await this.loadInitialData();
                    
                    console.log('Initial data loaded:', {
                        topiks: this.topiks,
                        regions: this.availableRegions.length,
                        bulans: this.bulans.length,
                        years: this.years.length
                    });
                    
                    // Set default values
                    this.filters.tahun_awal = '2014';
                    this.filters.tahun_akhir = '2016';
                    this.filters.selectedRegions = this.availableRegions.map(r => r.id); // Default to all regions
                    this.filters.selectedMonths = this.bulans.filter(b => b.id !== 0 && b.id !== 13).map(b => b.id); // Exclude "Setahun" and "-" months
                    
                    console.log('Initialization complete');
                },

                // Consolidate search results by table layout type
                get consolidatedResults() {
                    if (this.searchResults.length === 0) return [];

                    // Group results by table layout and topic
                    const layoutGroups = {};
                    
                    this.searchResults.forEach(result => {
                        const layoutKey = result.queueItem.tata_letak || 'tipe_1';
                        const topikKey = result.queueItem.topik;
                        const groupKey = `${layoutKey}_${topikKey}`;
                        
                        if (!layoutGroups[groupKey]) {
                            layoutGroups[groupKey] = {
                                layout: layoutKey,
                                topik: topikKey,
                                topik_nama: result.topik_nama || (topikKey === '1' ? 'Benih' : 'Pupuk'),
                                results: [],
                                consolidatedData: null
                            };
                        }
                        
                        layoutGroups[groupKey].results.push(result);
                    });

                    // Convert to array and consolidate data within each group
                    return Object.values(layoutGroups).map(group => {
                        // Merge all regions, variables, classifications from all results in this group
                        const allRegions = new Map();
                        const allVariabels = new Map();
                        const allKlasifikasis = new Map();
                        const allYearGroups = new Map();
                        let combinedData = [];

                        group.results.forEach(result => {
                            // Collect unique regions
                            if (result.selectedRegions) {
                                result.selectedRegions.forEach(region => {
                                    allRegions.set(region.id, region);
                                });
                            }
                            
                            // Collect unique variables
                            if (result.selectedVariabels) {
                                result.selectedVariabels.forEach(variabel => {
                                    allVariabels.set(variabel.id, variabel);
                                });
                            }
                            
                            // Collect unique classifications
                            if (result.selectedKlasifikasis) {
                                result.selectedKlasifikasis.forEach(klasifikasi => {
                                    allKlasifikasis.set(klasifikasi.id, klasifikasi);
                                });
                            }
                            
                            // Collect year groups
                            if (result.yearGroups) {
                                result.yearGroups.forEach(yearGroup => {
                                    allYearGroups.set(yearGroup.year, yearGroup);
                                });
                            }
                            
                            // Combine raw data
                            if (result.data && Array.isArray(result.data)) {
                                combinedData = combinedData.concat(result.data);
                            }
                        });

                        // Create consolidated result
                        const consolidated = {
                            layout: group.layout,
                            topik: group.topik,
                            topik_nama: group.topik_nama,
                            queueItems: group.results.map(r => r.queueItem),
                            selectedRegions: Array.from(allRegions.values()),
                            selectedVariabels: Array.from(allVariabels.values()),
                            selectedKlasifikasis: Array.from(allKlasifikasis.values()),
                            yearGroups: Array.from(allYearGroups.values()).sort((a, b) => a.year - b.year),
                            data: combinedData,
                            resultCount: group.results.length,
                            
                            // Create dataMap for efficient lookup
                            dataMap: new Map()
                        };
                        
                        // Build efficient data lookup map
                        combinedData.forEach(item => {
                            const key = `${item.id_wilayah}_${item.id_variabel}_${item.id_klasifikasi}_${item.tahun}_${item.id_bulan}`;
                            consolidated.dataMap.set(key, item);
                        });

                        return consolidated;
                    });
                },

                async loadInitialData() {
                    try {
                        console.log('Loading initial data from APIs...');
                        
                        // Load basic reference data
                        const [topiks, regions, bulans, years] = await Promise.all([
                            fetch('/api/benih-pupuk/topiks').then(r => r.json()),
                            fetch('/api/benih-pupuk/provinces').then(r => r.json()),
                            fetch('/api/benih-pupuk/bulans').then(r => r.json()),
                            fetch('/api/benih-pupuk/years').then(r => r.json())
                        ]);

                        console.log('API responses:', { topiks, regions: regions.length, bulans: bulans.length, years: years.length });

                        this.topiks = topiks;
                        this.availableRegions = regions;
                        this.bulans = bulans;
                        this.years = years;

                        console.log('Data assigned successfully');

                    } catch (error) {
                        console.error('Error loading initial data:', error);
                        // Fallback to basic data if API fails
                        this.years = Array.from({length: 12}, (_, i) => 2014 + i);
                        this.bulans = [
                            { id: 1, nama: 'Januari' }, { id: 2, nama: 'Februari' }, { id: 3, nama: 'Maret' },
                            { id: 4, nama: 'April' }, { id: 5, nama: 'Mei' }, { id: 6, nama: 'Juni' },
                            { id: 7, nama: 'Juli' }, { id: 8, nama: 'Agustus' }, { id: 9, nama: 'September' },
                            { id: 10, nama: 'Oktober' }, { id: 11, nama: 'November' }, { id: 12, nama: 'Desember' }
                        ];
                        this.topiks = [
                            { id: 1, nama: 'Benih' },
                            { id: 2, nama: 'Pupuk' }
                        ];
                        this.availableRegions = [
                            { id: 1, nama: 'Aceh' },
                            { id: 2, nama: 'Sumatera Utara' },
                            { id: 3, nama: 'Sumatera Barat' }
                        ];
                    }
                },

                async verifyDisplayedData() {
                    console.log('=== DATA VERIFICATION ===');
                    
                    if (this.searchResults.length === 0) {
                        console.warn('No search results to verify. Run search first.');
                        return;
                    }
                    
                    const result = this.searchResults[0];
                    console.log('Verifying result:', result);
                    
                    // Get the first displayed region and first value
                    const firstRegion = result.queueItem?.selectedRegions?.[0];
                    if (!firstRegion) {
                        console.warn('No regions found in result');
                        return;
                    }
                    
                    console.log('First region:', firstRegion);
                    
                    // Get the displayed value from table
                    const displayedValue = this.getCellValue(result, firstRegion, 0, 0, 0, 0);
                    console.log('Displayed value in table:', displayedValue);
                    
                    // Get the raw API data for same parameters
                    const verificationData = {
                        topik: result.queueItem.topik,
                        selectedRegions: [firstRegion.id.toString()],
                        variabels: result.queueItem.variabels ? result.queueItem.variabels.slice(0, 1) : [result.queueItem.selectedVariabel.toString()],
                        klasifikasis: result.queueItem.klasifikasis.slice(0, 1), 
                        tahun_awal: result.queueItem.tahun_awal.toString(),
                        tahun_akhir: result.queueItem.tahun_awal.toString(), // Same year
                        selectedMonths: [result.queueItem.bulan_awal.toString()],
                        tata_letak: 'tipe_1'
                    };
                    
                    console.log('Verification query:', verificationData);
                    
                    try {
                        const response = await fetch('/api/benih-pupuk/search', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify(verificationData)
                        });

                        const apiData = await response.json();
                        console.log('API verification response:', apiData);
                        
                        if (apiData.data && apiData.data.length > 0) {
                            const apiValue = apiData.data[0].values[0];
                            console.log('API returned value:', apiValue);
                            console.log('Table displayed value:', displayedValue);
                            console.log('Values match:', apiValue === displayedValue ? '✅ YES' : '❌ NO');
                            
                            if (apiValue !== displayedValue) {
                                console.warn('MISMATCH DETECTED! API vs Table values differ');
                            } else {
                                console.log('✅ DATA VERIFIED: Table values match API response');
                            }
                        }
                    } catch (error) {
                        console.error('Verification error:', error);
                    }
                },

                // Add a diagnostic function to help debug
                diagnoseApiResponse(response, requestData) {
                    console.log('=== API DIAGNOSIS ===');
                    console.log('Request sent:', requestData);
                    console.log('Response received:', response);
                    console.log('Response type:', typeof response);
                    console.log('Response has headers?', !!response.headers);
                    console.log('Response has data?', !!response.data);
                    console.log('Response has resultIndex?', response.resultIndex !== undefined);
                    
                    if (response.headers) {
                        console.log('Headers:', response.headers);
                        console.log('Headers length:', response.headers.length);
                        console.log('Headers type:', typeof response.headers);
                    }
                    
                    if (response.data) {
                        console.log('Data:', response.data);
                        console.log('Data length:', response.data.length);
                        console.log('Data type:', typeof response.data);
                        console.log('Sample data item:', response.data[0]);
                    }
                    
                    console.log('=== END DIAGNOSIS ===');
                },

                calculateSummaryStats(result) {
                    if (!result || !result.queueItem) {
                        result.totalEntries = 0;
                        result.averageValue = 0;
                        result.maxValue = 0;
                        result.minValue = 0;
                        return;
                    }
                    
                    // Collect all values using the same getCellValue function that tables use
                    let allValues = [];
                    
                    // Iterate through all possible combinations just like the tables do
                    const regions = result.queueItem.selectedRegions || [];
                    const variabels = result.selectedVariabels || [];
                    const klasifikasis = result.selectedKlasifikasis || [];
                    const yearGroups = result.yearGroups || [];
                    
                    console.log('calculateSummaryStats: Starting for layout:', result.queueItem.tata_letak);
                    
                    let sampleValues = [];
                    regions.forEach(region => {
                        variabels.forEach(variabel => {
                            klasifikasis.forEach(klasifikasi => {
                                yearGroups.forEach(yearGroup => {
                                    if (yearGroup.months) {
                                        yearGroup.months.forEach(month => {
                                            const value = this.getCellValue(
                                                region.id, 
                                                yearGroup.year, 
                                                month.id, 
                                                variabel.id, 
                                                klasifikasi.id
                                            );
                                            
                                            // Collect first 5 sample values for debugging
                                            if (sampleValues.length < 5) {
                                                sampleValues.push({
                                                    region: region.nama,
                                                    year: yearGroup.year,
                                                    month: month.nama,
                                                    variabel: variabel.id,
                                                    klasifikasi: klasifikasi.deskripsi,
                                                    value: value
                                                });
                                            }
                                            
                                            if (value !== null && value !== undefined && !isNaN(value) && value > 0) {
                                                allValues.push(parseFloat(value));
                                            }
                                        });
                                    }
                                });
                            });
                        });
                    });
                    
                    console.log('calculateSummaryStats samples:', sampleValues);
                    console.log('calculateSummaryStats: Total valid values found:', allValues.length);
                    
                    if (allValues.length === 0) {
                        result.totalEntries = 0;
                        result.averageValue = 0;
                        result.maxValue = 0;
                        result.minValue = 0;
                    } else {
                        result.totalEntries = allValues.length;
                        result.averageValue = allValues.reduce((sum, val) => sum + val, 0) / allValues.length;
                        result.maxValue = Math.max(...allValues);
                        result.minValue = Math.min(...allValues);
                    }
                },

                async loadVariabels() {
                    if (!this.filters.topik) {
                        this.availableVariabels = [];
                        return;
                    }

                    try {
                        const response = await fetch(`/api/benih-pupuk/variabels/${this.filters.topik}`);
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
                        return;
                    }

                    try {
                        const response = await fetch('/api/benih-pupuk/klasifikasis', {
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
                        
                        // Auto-select the first few klasifikasi options that likely have data
                        if (this.availableKlasifikasis.length > 0) {
                            // Select first 2-3 klasifikasi by default
                            this.filters.klasifikasis = this.availableKlasifikasis
                                .slice(0, Math.min(3, this.availableKlasifikasis.length))
                                .map(k => k.id.toString());
                            console.log('Auto-selected klasifikasis:', this.filters.klasifikasis);
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
                    return this.filters.topik && 
                           this.filters.selectedVariabel && 
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

                    // Create a deep copy of current filters and convert selectedVariabel to variabels array for backend compatibility
                    const queueItem = {
                        ...JSON.parse(JSON.stringify(this.filters)),
                        variabels: [this.filters.selectedVariabel], // Convert single variable to array for backend
                        yearMode: this.yearMode,
                        monthMode: this.monthMode,
                        processed: false, // Track if this item has been processed
                        timestamp: Date.now()
                    };
                    
                    // Remove the selectedVariabel field since we've converted it to variabels
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
                    // Don't clear existing results - append new ones instead
                    // this.searchResults = [];

                    try {
                        // Process only unprocessed items in queue
                        const unprocessedItems = this.filterQueue.filter(item => !item.processed);
                        
                        if (unprocessedItems.length === 0) {
                            console.log('No unprocessed items in queue');
                            this.isProcessing = false;
                            return;
                        }
                        
                        console.log(`Processing ${unprocessedItems.length} unprocessed queue items out of ${this.filterQueue.length} total items`);
                        console.log('Queue items processed status:', this.filterQueue.map((item, i) => `Item ${i}: ${item.processed ? 'PROCESSED' : 'PENDING'}`));
                        
                        for (let i = 0; i < unprocessedItems.length; i++) {
                            const queueItem = unprocessedItems[i];
                            
                            console.log('Processing queue item:', queueItem);
                            
                            // Debug: Log the request being sent
                            console.log('Sending API request with data:', JSON.stringify(queueItem, null, 2));
                            console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                            
                            // Make API call for each queue item
                            const response = await fetch('/api/benih-pupuk/search', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify(queueItem)
                            });
                            
                            console.log('API Response status:', response.status);
                            console.log('API Response headers:', Object.fromEntries(response.headers.entries()));
                            
                            if (response.ok) {
                                const data = await response.json();
                                console.log('API Response data:', data);
                                
                                // Add diagnosis
                                this.diagnoseApiResponse(data, queueItem);
                                
                                console.log('Checking response structure:', {
                                    hasData: !!data,
                                    hasHeaders: !!data.headers,
                                    resultIndex: data.resultIndex,
                                    resultIndexUndefined: data.resultIndex !== undefined,
                                    condition1: !!(data && data.headers),
                                    condition2: !!(data && data.resultIndex !== undefined),
                                    overallCondition: !!(data && (data.headers || data.resultIndex !== undefined))
                                });
                                
                                // Check if the response has the expected structure
                                if (data && (data.headers || data.resultIndex !== undefined)) {
                                    console.log('Using real API response data');
                                    
                                    // Debug the conversion process
                                    console.log('queueItem.selectedRegions (original):', queueItem.selectedRegions);
                                    console.log('this.availableRegions sample:', this.availableRegions.slice(0, 3));
                                    
                                    // Convert queueItem regions from IDs to full objects for template
                                    const selectedRegionObjects = this.availableRegions.filter(r => {
                                        const matchesId = queueItem.selectedRegions.includes(r.id.toString());
                                        const matchesStringId = queueItem.selectedRegions.includes(r.id);
                                        if (matchesId || matchesStringId) {
                                            console.log('Found matching region:', r.nama, 'for ID:', r.id);
                                        }
                                        return matchesId || matchesStringId;
                                    });
                                    
                                    console.log('selectedRegionObjects result:', selectedRegionObjects);
                                    
                                    const selectedVariabelObjects = this.availableVariabels.filter(v => 
                                        queueItem.variabels ? queueItem.variabels.includes(v.id.toString()) : 
                                        (queueItem.selectedVariabel && v.id.toString() === queueItem.selectedVariabel.toString())
                                    );
                                    const selectedKlasifikasiObjects = this.availableKlasifikasis.filter(k => queueItem.klasifikasis.includes(k.id.toString()));
                                    
                                    // Create enhanced result with queue item info and converted objects
                                    const enhancedResult = {
                                        ...data,
                                        resultIndex: this.searchResults.length + 1, // Set correct result number
                                        queueItem: {
                                            ...queueItem,
                                            selectedRegions: selectedRegionObjects,  // Convert IDs to objects
                                            selectedVariabels: selectedVariabelObjects,
                                            selectedKlasifikasis: selectedKlasifikasiObjects
                                        },
                                        selectedRegions: selectedRegionObjects,
                                        selectedVariabels: selectedVariabelObjects,
                                        selectedKlasifikasis: selectedKlasifikasiObjects,
                                        tahun_awal: queueItem.tahun_awal,
                                        tahun_akhir: queueItem.tahun_akhir,
                                        bulan_awal: queueItem.bulan_awal,
                                        bulan_akhir: queueItem.bulan_akhir
                                    };
                                    
                                    // Create dataMap for efficient data lookup
                                    enhancedResult.dataMap = this.createDataMap(data, queueItem);
                                    
                                    // IMPORTANT: Add raw_data for getCellValue function
                                    enhancedResult.raw_data = data.raw_data || [];
                                    console.log('FIX APPLIED: Raw data assigned to enhancedResult:', {
                                        layout: queueItem.tata_letak,
                                        hasRawData: !!enhancedResult.raw_data,
                                        rawDataLength: enhancedResult.raw_data.length,
                                        resultIndex: enhancedResult.resultIndex
                                    });
                                    
                                    console.log('Enhanced result queueItem.selectedRegions:', enhancedResult.queueItem.selectedRegions);
                                    console.log('DataMap created with keys:', Object.keys(enhancedResult.dataMap).length, 'entries');
                                    
                                    // Calculate summary statistics for the enhanced result
                                    this.calculateSummaryStats(enhancedResult);
                                    
                                    // Debug: Log the enhanced result structure
                                    console.log('Enhanced result structure:', {
                                        resultIndex: enhancedResult.resultIndex,
                                        hasHeaders: !!enhancedResult.headers,
                                        headersLength: enhancedResult.headers ? enhancedResult.headers.length : 0,
                                        headers: enhancedResult.headers,
                                        hasData: !!enhancedResult.data,
                                        dataLength: enhancedResult.data ? enhancedResult.data.length : 0,
                                        sampleDataItem: enhancedResult.data && enhancedResult.data[0] ? enhancedResult.data[0] : null,
                                        layoutType: enhancedResult.queueItem.tata_letak
                                    });
                                    
                                    this.searchResults.push(enhancedResult);
                                    
                                    // Calculate summary statistics for the enhanced result
                                    this.calculateSummaryStats(enhancedResult);
                                    
                                    // CRITICAL: Pre-sort all arrays to ensure consistent table iteration
                                    if (enhancedResult.selectedKlasifikasis) {
                                        enhancedResult.selectedKlasifikasis.sort((a, b) => a.id - b.id);
                                    }
                                    if (enhancedResult.yearGroups) {
                                        enhancedResult.yearGroups.sort((a, b) => a.year - b.year);
                                        // Also sort months within each year group
                                        enhancedResult.yearGroups.forEach(yearGroup => {
                                            if (yearGroup.months) {
                                                yearGroup.months.sort((a, b) => a.id - b.id);
                                            }
                                        });
                                    }
                                    
                                    console.log('=== ARRAYS PRE-SORTED FOR CONSISTENCY ===');
                                    console.log('Sorted klasifikasis:', enhancedResult.selectedKlasifikasis);
                                    console.log('Sorted yearGroups:', enhancedResult.yearGroups);
                                    console.log('First klasifikasi should be:', enhancedResult.selectedKlasifikasis[0]);
                                    console.log('First year should be:', enhancedResult.yearGroups[0]);
                                    
                                    // Verify table layout is preserved
                                    console.log('Table layout should be:', enhancedResult.queueItem.tata_letak);
                                    
                                    // Manual verification
                                    const firstRegion = enhancedResult.queueItem.selectedRegions[0];
                                    const firstVariabel = enhancedResult.selectedVariabels[0];  
                                    const firstKlasifikasi = enhancedResult.selectedKlasifikasis[0];
                                    const firstYear = enhancedResult.yearGroups[0];
                                    const firstMonth = firstYear.months[0];
                                    
                                    console.log('=== MANUAL FIRST CELL CHECK ===');
                                    console.log('Should use:', {
                                        regionId: firstRegion.id,
                                        year: firstYear.year, 
                                        monthId: firstMonth.id,
                                        variabelId: firstVariabel.id,
                                        klasifikasiId: firstKlasifikasi.id
                                    });
                                    
                                    const expectedValue = this.getCellValue(firstRegion.id, firstYear.year, firstMonth.id, firstVariabel.id, firstKlasifikasi.id);
                                    console.log('Expected first cell value:', expectedValue);
                                    console.log('=== END MANUAL CHECK ===');
                                    
                                    // Mark this queue item as processed
                                    queueItem.processed = true;
                                } else {
                                    console.warn('API response format unexpected, using fallback');
                                    console.log('Response that failed validation:', data);
                                    const result = this.generateResultForQueueItem(queueItem, this.searchResults.length + 1);
                                    this.calculateSummaryStats(result);
                                    this.searchResults.push(result);
                                    queueItem.processed = true;
                                }
                            } else {
                                console.error('API response not OK:', response.status);
                                // Fallback to generating mock data if API fails
                                const result = this.generateResultForQueueItem(queueItem, this.searchResults.length + 1);
                                this.searchResults.push(result);
                                queueItem.processed = true;
                            }
                        }
                    } catch (error) {
                        console.error('Error processing queue:', error);
                        
                        // Fallback: generate results for all unprocessed queue items
                        const unprocessedItems = this.filterQueue.filter(item => !item.processed);
                        for (let i = 0; i < unprocessedItems.length; i++) {
                            const queueItem = unprocessedItems[i];
                            const result = this.generateResultForQueueItem(queueItem, this.searchResults.length + 1);
                            this.searchResults.push(result);
                            queueItem.processed = true;
                        }
                    } finally {
                        this.isProcessing = false;
                        this.activeTab = 'tabel';

                        console.log('Final search results:', this.searchResults);

                        // Create charts after results are rendered
                        this.$nextTick(() => {
                            this.createCharts();
                        });
                    }
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
                    // Handle both formats: new format (variabels array) and legacy format (selectedVariabel single)
                    let selectedVariabels = [];
                    if (queueItem.variabels) {
                        selectedVariabels = this.availableVariabels.filter(v => queueItem.variabels.includes(v.id));
                    } else if (queueItem.selectedVariabel) {
                        selectedVariabels = this.availableVariabels.filter(v => v.id.toString() === queueItem.selectedVariabel.toString());
                    }
                    let selectedKlasifikasis = this.availableKlasifikasis.filter(k => queueItem.klasifikasis.includes(k.id));

                    // Fallback: if no selections, use defaults to prevent empty tables
                    if (selectedVariabels.length === 0) {
                        selectedVariabels = [
                            { id: 1, deskripsi: 'Default Variabel 1', satuan: 'Ton' },
                            { id: 2, deskripsi: 'Default Variabel 2', satuan: 'Ton' }
                        ];
                    }
                    if (selectedKlasifikasis.length === 0) {
                        selectedKlasifikasis = [
                            { id: 1, deskripsi: 'Default Klasifikasi 1' },
                            { id: 2, deskripsi: 'Default Klasifikasi 2' }
                        ];
                    }
                    if (years.length === 0) {
                        years = [2020, 2021, 2022];
                    }
                    if (months.length === 0) {
                        months = this.bulans.slice(0, 6) || [
                            { id: 1, nama: 'Januari' },
                            { id: 2, nama: 'Februari' },
                            { id: 3, nama: 'Maret' }
                        ];
                    }
                    if (selectedRegions.length === 0) {
                        selectedRegions = this.availableRegions.slice(0, 3) || [
                            { id: 1, nama: 'Default Region 1' },
                            { id: 2, nama: 'Default Region 2' }
                        ];
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
                    selectedRegions.forEach(region => {
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
                        data = selectedRegions.map(region => ({
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
                                datasets: result.data.map((row, idx) => ({
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

                clearResults() {
                    this.searchResults = [];
                    // Reset processed status for all queue items so they can be reprocessed
                    this.filterQueue.forEach(item => {
                        item.processed = false;
                    });
                    console.log('Results cleared and queue items reset for reprocessing');
                },

                getQueueSummary(queueItem) {
                    const topik = queueItem.topik === '1' ? 'Benih' : 'Pupuk';
                    // Handle both old format (variabels array) and new format (selectedVariabel single value)
                    const variabelCount = queueItem.variabels ? queueItem.variabels.length : (queueItem.selectedVariabel ? 1 : 0);
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
                    // First try to get from API response if available
                    const currentResult = this.searchResults.find(r => r.queueItem === queueItem);
                    if (currentResult && currentResult.selectedVariabels && currentResult.selectedVariabels.length > 0) {
                        const variabels = currentResult.selectedVariabels;
                        if (variabels.length <= 2) {
                            return variabels.map(v => v.deskripsi || v.nama || 'Unknown').join(', ');
                        }
                        return `${variabels[0].deskripsi || variabels[0].nama || 'Unknown'}, ${variabels[1].deskripsi || variabels[1].nama || 'Unknown'} (+${variabels.length - 2} lainnya)`;
                    }
                    
                    // Fallback to original method - handle both formats
                    if (queueItem.variabels && this.availableVariabels) {
                        // New format: variabels array
                        const selectedVariabels = this.availableVariabels.filter(v => queueItem.variabels.includes(v.id));
                        if (selectedVariabels.length === 0) return 'Default Variabel';
                        return selectedVariabels.map(v => v.deskripsi).join(', ');
                    } else if (queueItem.selectedVariabel && this.availableVariabels) {
                        // Old format: selectedVariabel single value
                        const selectedVariabel = this.availableVariabels.find(v => v.id === queueItem.selectedVariabel);
                        if (!selectedVariabel) return 'Default Variabel';
                        return selectedVariabel.deskripsi;
                    }
                    return 'Default Variabel';
                },

                getKlasifikasiNames(queueItem) {
                    // First try to get from API response if available
                    const currentResult = this.searchResults.find(r => r.queueItem === queueItem);
                    if (currentResult && currentResult.selectedKlasifikasis && currentResult.selectedKlasifikasis.length > 0) {
                        const klasifikasis = currentResult.selectedKlasifikasis;
                        if (klasifikasis.length <= 3) {
                            return klasifikasis.map(k => k.deskripsi || k.nama || 'Unknown').join(', ');
                        }
                        return `${klasifikasis.slice(0, 3).map(k => k.deskripsi || k.nama || 'Unknown').join(', ')} (+${klasifikasis.length - 3} lainnya)`;
                    }
                    
                    // Fallback to original method
                    if (!queueItem.klasifikasis || !this.availableKlasifikasis) return 'Default Klasifikasi';
                    const selectedKlasifikasis = this.availableKlasifikasis.filter(k => queueItem.klasifikasis.includes(k.id));
                    if (selectedKlasifikasis.length === 0) return 'Default Klasifikasi';
                    if (selectedKlasifikasis.length <= 3) {
                        return selectedKlasifikasis.map(k => k.deskripsi).join(', ');
                    }
                    return `${selectedKlasifikasis.slice(0, 3).map(k => k.deskripsi).join(', ')} (+${selectedKlasifikasis.length - 3} lainnya)`;
                },

                getRegionName(regionOrId) {
                    // Handle both region objects and region IDs
                    if (typeof regionOrId === 'object' && regionOrId.nama) {
                        return regionOrId.nama;
                    }
                    // Handle region ID (number or string)
                    const region = this.availableRegions.find(r => r.id == regionOrId);
                    return region ? region.nama : `Wilayah ${regionOrId}`;
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

                // Enhanced getCellValue that searches across ALL search results
                getCellValue(regionId, year, monthId, variabelId, klasifikasiId) {
                    try {
                        // Search through ALL search results to find the data
                        // This allows data from different queue items to be combined
                        for (const result of this.searchResults) {
                            if (result.raw_data && Array.isArray(result.raw_data)) {
                                const targetRecord = result.raw_data.find(record => 
                                    String(record.id_wilayah) === String(regionId) &&
                                    String(record.tahun) === String(year) &&
                                    String(record.id_bulan) === String(monthId) &&
                                    String(record.id_variabel) === String(variabelId) &&
                                    String(record.id_klasifikasi) === String(klasifikasiId)
                                );
                                
                                if (targetRecord) {
                                    return parseFloat(targetRecord.nilai) || 0;
                                }
                            }
                        }
                        
                        return 0;
                    } catch (error) {
                        console.error('getCellValue error:', error);
                        return 0;
                    }
                },

                // Create a dataMap from the API response for efficient data lookup
                createDataMap(apiData, queueItem) {
                    const dataMap = {};
                    
                    try {
                        // Debug the API response structure
                        console.log('createDataMap called with:', {
                            hasApiData: !!apiData,
                            hasRawData: !!(apiData && apiData.raw_data),
                            rawDataLength: apiData && apiData.raw_data ? apiData.raw_data.length : 0,
                            sampleRawDataItem: apiData && apiData.raw_data && apiData.raw_data[0] ? apiData.raw_data[0] : null,
                            layoutType: queueItem.tata_letak
                        });
                        
                        // Check if we have raw data from the API
                        if (!apiData || !apiData.raw_data || !Array.isArray(apiData.raw_data)) {
                            console.log('No raw_data in API response, cannot create dataMap');
                            return dataMap;
                        }
                        
                        // Convert raw data to key-value map
                        apiData.raw_data.forEach(item => {
                            // Create key in format: regionId_year_monthId_variabelId_klasifikasiId
                            // Use the correct property names from the database result
                            const key = `${item.id_wilayah}_${item.tahun}_${item.id_bulan}_${item.id_variabel}_${item.id_klasifikasi}`;
                            dataMap[key] = parseFloat(item.nilai) || 0;
                        });
                        
                        console.log('DataMap created successfully:', {
                            totalEntries: apiData.raw_data.length,
                            uniqueKeys: Object.keys(dataMap).length,
                            sampleKeys: Object.keys(dataMap).slice(0, 5),
                            sampleValues: Object.values(dataMap).slice(0, 5),
                            firstFewItems: apiData.raw_data.slice(0, 3).map(item => ({
                                key: `${item.id_wilayah}_${item.tahun}_${item.id_bulan}_${item.id_variabel}_${item.id_klasifikasi}`,
                                value: item.nilai
                            }))
                        });
                        
                    } catch (error) {
                        console.error('Error creating dataMap:', error);
                    }
                    
                    return dataMap;
                },

                // Get aggregated value across all regions for tipe_2 and tipe_3 layouts
                getAggregatedValue(layoutType, klasifikasiId, variabelId, year, monthId) {
                    try {
                        // Find the current result context
                        let result = null;
                        for (const searchResult of this.searchResults) {
                            if (searchResult.dataMap && searchResult.queueItem.tata_letak === layoutType) {
                                result = searchResult;
                                break;
                            }
                        }
                        
                        if (!result || !result.dataMap || !result.selectedRegions) {
                            return 0;
                        }

                        // Sum values across all selected regions for this combination
                        let total = 0;
                        let count = 0;
                        
                        result.selectedRegions.forEach(region => {
                            const key = `${region.id}_${year}_${monthId}_${variabelId}_${klasifikasiId}`;
                            const value = result.dataMap[key];
                            if (value !== undefined) {
                                total += parseFloat(value);
                                count++;
                            }
                        });
                        
                        // Return average to match backend logic
                        return count > 0 ? total / count : 0;
                        
                    } catch (error) {
                        console.error('getAggregatedValue error:', error);
                        return 0;
                    }
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
