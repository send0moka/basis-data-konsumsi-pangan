<x-layouts.landing title="Daftar Alamat Pertanian">
    <!-- Leaflet.js for interactive maps -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    
    <style>
        #alamatMap { height: 350px; width: 100%; border-radius: 12px; margin-bottom: 2rem; }
        .search-input { border-radius: 8px; border: 1px solid #ccc; padding: 8px 12px; width: 100%; }
        .alamat-table th, .alamat-table td { font-size: 14px; padding: 8px 10px; }
        .alamat-table tr:hover { background: #f3f4f6; }
    </style>

    <div class="py-12 bg-white" x-data="daftarAlamat()" x-init="init()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-neutral-900 mb-2">Daftar Alamat Pertanian</h1>
                <p class="text-lg text-neutral-600">Lihat dan telusuri alamat lokasi pertanian, kantor, dan fasilitas terkait secara interaktif.</p>
            </div>

            <!-- Summary Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-green-50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-green-700" id="totalAlamat">0</div>
                    <div class="text-sm text-green-900">Total Alamat</div>
                </div>
                <div class="bg-blue-50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-blue-700" id="totalRegion">0</div>
                    <div class="text-sm text-blue-900">Wilayah Terdaftar</div>
                </div>
                <div class="bg-yellow-50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-yellow-700" id="totalJenis">0</div>
                    <div class="text-sm text-yellow-900">Jenis Lokasi</div>
                </div>
            </div>

            <!-- Search & Filter -->
            <div x-show="!isLoading" class="mb-6 flex flex-col md:flex-row gap-4 items-center">
                <input type="text" class="search-input" placeholder="Cari alamat, wilayah, atau jenis..." x-model="searchQuery" @input="filterAlamat()">
                
                <select class="search-input md:w-48" x-model="selectedRegion" @change="filterAlamat()">
                    <option value="">Semua Wilayah</option>
                    <template x-for="region in regions" :key="region">
                        <option :value="region" x-text="region"></option>
                    </template>
                </select>
                
                <select class="search-input md:w-48" x-model="selectedJenis" @change="filterAlamat()">
                    <option value="">Semua Jenis</option>
                    <template x-for="jenis in jenisLokasi" :key="jenis">
                        <option :value="jenis" x-text="jenis"></option>
                    </template>
                </select>
            </div>

            <!-- Loading State -->
            <div x-show="isLoading" class="mb-6 flex items-center justify-center py-12">
                <div class="flex items-center space-x-3">
                    <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-lg text-gray-600">Memuat data...</span>
                </div>
            </div>

            <!-- Error State -->
            <div x-show="error && !isLoading" class="mb-6 bg-red-50 border border-red-200 rounded-lg p-6">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <div>
                        <h3 class="text-lg font-medium text-red-800">Terjadi Kesalahan</h3>
                        <p class="text-red-700" x-text="error"></p>
                        <button class="mt-2 px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition-colors" @click="init()">Coba Lagi</button>
                    </div>
                </div>
            </div>

            <!-- Active Filters Info -->
            <div x-show="hasActiveFilters()" class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        <span class="text-sm text-blue-800 font-medium">Filter aktif:</span>
                        <template x-if="searchQuery">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-800">
                                Pencarian: "<span x-text="searchQuery"></span>"
                            </span>
                        </template>
                        <template x-if="selectedRegion">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-800">
                                Wilayah: <span x-text="selectedRegion"></span>
                            </span>
                        </template>
                        <template x-if="selectedJenis">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-800">
                                Jenis: <span x-text="selectedJenis"></span>
                            </span>
                        </template>
                    </div>
                    <span class="text-sm text-blue-600" x-text="filteredAlamat.length + ' hasil ditemukan'"></span>
                </div>
            </div>

            <!-- Interactive Map -->
            <div x-show="!isLoading && !error" id="alamatMap"></div>

            <!-- Loading Map -->
            <div x-show="isLoading" class="bg-gray-200 rounded-lg h-80 flex items-center justify-center mb-6">
                <div class="text-center">
                    <svg class="animate-spin h-8 w-8 text-gray-600 mx-auto mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p class="text-gray-600">Memuat peta...</p>
                </div>
            </div>

            <!-- Table of Addresses -->
            <div x-show="!isLoading && !error" class="overflow-x-auto">
                <table class="alamat-table w-full bg-white rounded-lg shadow">
                    <thead class="bg-neutral-100">
                        <tr>
                            <th>No</th>
                            <th>Nama Lokasi</th>
                            <th>Alamat</th>
                            <th>Wilayah</th>
                            <th>Jenis</th>
                            <th>Koordinat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(alamat, idx) in filteredAlamat" :key="alamat.id">
                            <tr>
                                <td x-text="idx + 1"></td>
                                <td x-text="alamat.nama"></td>
                                <td x-text="alamat.alamat"></td>
                                <td x-text="alamat.wilayah"></td>
                                <td x-text="alamat.jenis"></td>
                                <td>
                                    <span x-text="alamat.lat + ', ' + alamat.lng"></span>
                                </td>
                                <td>
                                    <button class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700" @click="focusMap(alamat)">Lihat di Peta</button>
                                </td>
                            </tr>
                        </template>
                        <template x-if="filteredAlamat.length === 0">
                            <tr>
                                <td colspan="7" class="text-center py-8 text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.467-.881-6.08-2.33"></path>
                                        </svg>
                                        <p class="text-lg font-medium">Tidak ada data ditemukan</p>
                                        <p class="text-sm">Coba ubah kriteria pencarian atau filter</p>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- Loading Table -->
            <div x-show="isLoading" class="overflow-x-auto">
                <table class="alamat-table w-full bg-white rounded-lg shadow">
                    <thead class="bg-neutral-100">
                        <tr>
                            <th>No</th>
                            <th>Nama Lokasi</th>
                            <th>Alamat</th>
                            <th>Wilayah</th>
                            <th>Jenis</th>
                            <th>Koordinat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="7" class="text-center py-12">
                                <div class="flex items-center justify-center">
                                    <svg class="animate-spin h-8 w-8 text-blue-600 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span class="text-lg text-gray-600">Memuat data tabel...</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('daftarAlamat', () => ({
                alamatList: [],
                regions: [],
                jenisLokasi: [],
                searchQuery: '',
                selectedRegion: '',
                selectedJenis: '',
                filteredAlamat: [],
                map: null,
                markers: [],
                isLoading: false,
                error: null,
                mapInitialized: false,
                dataInitialized: false,
                initPromise: null,
                searchTimeout: null,

                async init() {
                    // Prevent multiple initialization
                    if (this.dataInitialized) {
                        console.log('Data already initialized, skipping...');
                        return;
                    }

                    // Prevent concurrent initialization calls
                    if (this.initPromise) {
                        console.log('Init already in progress, waiting...');
                        await this.initPromise;
                        return;
                    }

                    this.initPromise = this._init();
                    await this.initPromise;
                    this.initPromise = null;
                },

                async _init() {
                    try {
                        this.isLoading = true;
                        console.log('Starting initialization, isLoading set to true');
                        this.error = null;

                        // Add timeout to prevent infinite loading
                        const timeoutPromise = new Promise((_, reject) => {
                            setTimeout(() => reject(new Error('Request timeout')), 10000);
                        });

                        // Fetch data from public API endpoint
                        const response = await Promise.race([
                            fetch('/api/daftar-alamat/data', {
                                method: 'GET',
                                headers: {
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json'
                                }
                            }),
                            timeoutPromise
                        ]);

                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}, message: ${response.statusText}`);
                        }

                        const data = await response.json();
                        console.log('Raw API response:', response);
                        console.log('Parsed data:', data);

                        // Validate data
                        if (!Array.isArray(data)) {
                            throw new Error('Data yang diterima bukan array');
                        }

                        if (data.length === 0) {
                            throw new Error('Data kosong diterima dari server');
                        }

                        this.alamatList = data;
                        this.regions = [...new Set(data.map(a => a.wilayah))].sort();
                        this.jenisLokasi = [...new Set(data.map(a => a.jenis))].sort();
                        this.filteredAlamat = [...data]; // Initialize filtered list

                        console.log('Processed data:');
                        console.log('- Total records:', data.length);
                        console.log('- Regions:', this.regions);
                        console.log('- Jenis Lokasi:', this.jenisLokasi);
                        console.log('- Sample record:', data[0]);

                        // Validate processed data
                        if (this.regions.length === 0) {
                            console.warn('Warning: No regions found in data');
                        }
                        if (this.jenisLokasi.length === 0) {
                            console.warn('Warning: No jenis lokasi found in data');
                        }

                        this.$nextTick(() => {
                            this.initMap();
                        });
                        this.dataInitialized = true;
                        this.updateStats();
                        console.log('Initialization complete');
                    } catch (error) {
                        console.error('Error loading data:', error);
                        this.error = error.message;

                        // Provide fallback data for development
                        console.log('Using fallback data due to error');
                        this.alamatList = [
                            {
                                id: 1,
                                nama: 'Kantor Pusat Pertanian',
                                alamat: 'Jl. Harsono RM. No. 3, Ragunan, Jakarta Selatan',
                                wilayah: 'DKI Jakarta',
                                jenis: 'Kantor Pusat',
                                lat: -6.3056,
                                lng: 106.8200
                            },
                            {
                                id: 2,
                                nama: 'Balai Penelitian Tanaman Padi',
                                alamat: 'Jl. Raya 9, Sukamandi, Subang',
                                wilayah: 'Jawa Barat',
                                jenis: 'Balai Penelitian',
                                lat: -6.5833,
                                lng: 107.5833
                            }
                        ];
                        this.regions = [...new Set(this.alamatList.map(a => a.wilayah))].sort();
                        this.jenisLokasi = [...new Set(this.alamatList.map(a => a.jenis))].sort();
                        this.filteredAlamat = [...this.alamatList];

                        this.dataInitialized = true;
                        this.updateStats();
                        this.$nextTick(() => {
                            this.initMap();
                        });
                    } finally {
                        // Small delay to ensure all operations are complete
                        setTimeout(() => {
                            this.isLoading = false;
                            console.log('Loading state set to false');
                        }, 100);
                    }
                },

                updateStats() {
                    const totalAlamat = this.filteredAlamat.length;
                    const uniqueRegions = [...new Set(this.filteredAlamat.map(a => a.wilayah))];
                    const uniqueJenis = [...new Set(this.filteredAlamat.map(a => a.jenis))];

                    console.log('Updating stats:', {
                        totalAlamat,
                        totalRegion: uniqueRegions.length,
                        totalJenis: uniqueJenis.length
                    });

                    document.getElementById('totalAlamat').textContent = totalAlamat;
                    document.getElementById('totalRegion').textContent = uniqueRegions.length;
                    document.getElementById('totalJenis').textContent = uniqueJenis.length;
                },

                filterAlamat() {
                    // Prevent filtering if data is not initialized yet
                    if (!this.dataInitialized || !this.alamatList.length) {
                        return;
                    }

                    // Clear existing timeout
                    if (this.searchTimeout) {
                        clearTimeout(this.searchTimeout);
                    }

                    // Debounce search input to avoid excessive filtering
                    this.searchTimeout = setTimeout(() => {
                        this.filteredAlamat = this.alamatList.filter(a => {
                            const matchQuery = this.searchQuery === '' ||
                                a.nama.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                                a.alamat.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                                a.wilayah.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                                a.jenis.toLowerCase().includes(this.searchQuery.toLowerCase());
                            const matchRegion = this.selectedRegion === '' || a.wilayah === this.selectedRegion;
                            const matchJenis = this.selectedJenis === '' || a.jenis === this.selectedJenis;
                            return matchQuery && matchRegion && matchJenis;
                        });

                        this.updateMapMarkers();
                        this.updateStats();
                    }, 300); // 300ms debounce
                },

                initMap() {
                    // Prevent multiple map initialization
                    if (this.mapInitialized) {
                        console.log('Map already initialized, skipping...');
                        return;
                    }

                    console.log('Initializing map...');
                    this.map = L.map('alamatMap').setView([-2.5, 118], 5.2);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(this.map);

                    this.mapInitialized = true;
                    console.log('Map initialized successfully');
                    this.updateMapMarkers();
                },

                updateMapMarkers() {
                    if (!this.map || !this.mapInitialized) {
                        console.log('Map not initialized yet, skipping marker update');
                        return;
                    }

                    console.log('Updating map markers for', this.filteredAlamat.length, 'locations');

                    // Remove old markers
                    this.markers.forEach(m => this.map.removeLayer(m));
                    this.markers = [];

                    this.filteredAlamat.forEach(alamat => {
                        if (alamat.lat && alamat.lng) {
                            const marker = L.marker([alamat.lat, alamat.lng]).addTo(this.map)
                                .bindPopup(`<strong>${alamat.nama}</strong><br>${alamat.alamat}<br><em>${alamat.wilayah}</em>`);
                            this.markers.push(marker);
                        }
                    });

                    console.log('Map markers updated:', this.markers.length, 'markers added');
                },

                focusMap(alamat) {
                    if (this.map && alamat.lat && alamat.lng) {
                        this.map.setView([alamat.lat, alamat.lng], 14);
                        this.markers.forEach(m => {
                            if (m.getLatLng().lat === alamat.lat && m.getLatLng().lng === alamat.lng) {
                                m.openPopup();
                            }
                        });
                    }
                },

                resetFilters() {
                    console.log('=== RESET FILTERS ===');
                    this.searchQuery = '';
                    this.selectedRegion = '';
                    this.selectedJenis = '';
                    this.filterAlamat();
                },

                hasActiveFilters() {
                    return this.searchQuery !== '' || this.selectedRegion !== '' || this.selectedJenis !== '';
                }
            }));
        });
    </script>
</x-layouts.landing>