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
<script>
    const benihPupukInitialData = {
        topiks: @json($topiks),
        variabels: @json($variabels),
        klasifikasis: @json($klasifikasis),
        tahuns: @json($tahuns),
        bulans: @json($bulans),
        wilayahs: @json($wilayahs)
    };

    function benihPupukForm() {
        return {
            init(data) {
                this.allData = data;
                this.$watch('wilayahLevel', () => {
                    // Reset selections when switching levels
                    this.selection.provinsi_ids = [];
                    this.selection.kabupaten_ids = [];
                    this.selectedProvinsiId = null;
                });
                this.$watch('selectedProvinsiId', () => {
                    // Reset kabupaten selection when province changes
                    this.selection.kabupaten_ids = [];
                });
            },
            // Data sources from Controller
            allData: {
                topiks: [],
                variabels: [],
                klasifikasis: [],
                tahuns: [],
                bulans: [],
                wilayahs: []
            },

            // Form state
            selection: {
                topik_id: null,
                variabel_id: null,
                klasifikasi_ids: [],
                tahun_ids: [],
                bulan_ids: [],
                provinsi_ids: [],
                kabupaten_ids: [],
                tata_letak: 'master-header-variabel',
                wilayah: {
                    tingkat: 'nasional',
                    provinsi: [],
                    kabupaten: [],
                    selected_provinsi: null,
                },
            },

            wilayahLevel: 'provinsi', // 'nasional' or 'provinsi'
            selectedProvinsiId: null,

            // Search inputs
            search: {
                topik: '',
                variabel: '',
                klasifikasi: '',
                tahun: '',
                bulan: '',
                wilayah: '',
            },

            // UI state
            isProcessing: false,
            activeTab: 'tabel',
            selections: [],
            selectedForRemoval: [],
            searchResults: [],

            // Methods
            selectTopik(id) {
                this.selection.topik_id = id;
                this.selection.variabel_id = null;
                this.selection.klasifikasi_ids = [];
            },

            selectVariabel(id) {
                this.selection.variabel_id = id;
                this.selection.klasifikasi_ids = [];
            },

            isSelectionValid() {
                return this.selection.topik_id && this.selection.variabel_id && this.selection.tahun_ids.length > 0 && this.selection.bulan_ids.length > 0;
            },

            addSelection() {
                if (!this.isSelectionValid()) return;

                const topik = this.allData.topiks.find(t => t.id === this.selection.topik_id);
                const variabel = this.allData.variabels.find(v => v.id === this.selection.variabel_id);
                
                const tahun_awal = Math.min(...this.selection.tahun_ids);
                const tahun_akhir = Math.max(...this.selection.tahun_ids);
                const bulan_awal = this.allData.bulans.find(b => b.id == Math.min(...this.selection.bulan_ids))?.nama || '';
                const bulan_akhir = this.allData.bulans.find(b => b.id == Math.max(...this.selection.bulan_ids))?.nama || '';

                const newSelection = {
                    id: Date.now(),
                    topik_id: this.selection.topik_id,
                    variabel_id: this.selection.variabel_id,
                    klasifikasi_ids: [...this.selection.klasifikasi_ids],
                    tahun_ids: [...this.selection.tahun_ids],
                    bulan_ids: [...this.selection.bulan_ids],
                    display: {
                        variabel_nama: variabel ? `${topik.nama} - ${variabel.nama}` : topik.nama,
                        klasifikasi_nama: this.selection.klasifikasi_ids.length > 0 ? 'Terpilih' : 'Semua',
                        tahun: this.selection.tahun_ids.length > 1 ? `${tahun_awal} - ${tahun_akhir}` : tahun_awal,
                        bulan: this.selection.bulan_ids.length > 1 ? `${bulan_awal} - ${bulan_akhir}` : bulan_awal
                    }
                };

                this.selections.push(newSelection);
                this.resetSelection();
            },

            removeSelection() {
                // Convert IDs for removal to numbers for strict comparison
                const idsToRemove = this.selectedForRemoval.map(Number);
                // Filter the array by creating a new one, which is a robust way to trigger reactivity
                this.selections = this.selections.filter(item => !idsToRemove.includes(item.id));
                // Clear the selection
                this.selectedForRemoval = [];
            },

            resetSelection() {
                this.selection.topik_id = null;
                this.selection.variabel_id = null;
                this.selection.klasifikasi_ids = [];
                this.selection.tahun_ids = [];
                this.selection.bulan_ids = [];
            },

            resetForm() {
                this.selection = {
                    topik_id: null,
                    variabel_id: null,
                    klasifikasi_ids: [],
                    tahun_ids: [],
                    bulan_ids: [],
                    provinsi_ids: [],
                    kabupaten_ids: [],
                    tata_letak: 'data-series',
                    wilayah: {
                        tingkat: 'nasional',
                        provinsi: [],
                        kabupaten: [],
                        selected_provinsi: null,
                    },
                };
                this.selections = [];
                this.searchResults = { data: [], columnOrder: [], config: {} };
                this.selectedForRemoval = [];
                this.wilayahLevel = 'nasional';
                this.selectedProvinsiId = null;
            },

            async fetchData() {
                if (this.selections.length === 0) {
                    alert('Silakan tambahkan data terlebih dahulu.');
                    return;
                }
                this.isProcessing = true;
                this.searchResults = { data: [], columnOrder: [], config: {} }; // Reset results

                try {
                    const payload = {
                        selections: this.selections.map(s => ({
                            variabel_id: s.variabel_id,
                            tahun_ids: s.tahun_ids,
                            klasifikasi_ids: s.klasifikasi_ids,
                            bulan_ids: s.bulan_ids,
                        })),
                        config: {
                            tata_letak: this.selection.tata_letak,
                            provinsi_ids: this.selection.provinsi_ids,
                            kabupaten_ids: this.selection.kabupaten_ids,
                        }
                    };

                    console.log('Sending payload:', payload);
                    console.log('Selection state:', this.selection);

                    const response = await fetch('{{ route('api.benih-pupuk.filter') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(payload)
                    });

                    if (!response.ok) {
                        const errorData = await response.json();
                        console.error('Server error:', errorData);
                        throw new Error(errorData.message || 'Network response was not ok');
                    }

                    const results = await response.json();
                    console.log('Received results:', results);
                    this.searchResults = results;
                    // Optional: render chart if you have chart data
                    // this.renderChart(results); 

                } catch (error) {
                    console.error('Fetch error:', error);
                    alert('Terjadi kesalahan saat mengambil data: ' + error.message);
                } finally {
                    this.isProcessing = false;
                }
            },

            renderChart(data) {
                const ctx = document.getElementById('chart-container').getContext('2d');
                if (window.myChart instanceof Chart) {
                    window.myChart.destroy();
                }

                if (!data || !data.chart || !data.chart.labels || !data.chart.datasets) {
                    return;
                }

                window.myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.chart.labels,
                        datasets: data.chart.datasets.map(dataset => ({
                            label: dataset.label,
                            data: dataset.data,
                            backgroundColor: dataset.backgroundColor || 'rgba(54, 162, 235, 0.6)',
                            borderColor: dataset.borderColor || 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }))
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                            }
                        }
                    }
                });
            },

            exportExcel() {
                if (this.dynamicRows.length === 0) {
                    alert('Tidak ada data untuk diekspor.');
                    return;
                }

                // Create a hidden form to submit data
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('api.benih-pupuk.export') }}';
                form.style.display = 'none';

                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                form.appendChild(csrfInput);

                const headersInput = document.createElement('input');
                headersInput.type = 'hidden';
                headersInput.name = 'headers';
                headersInput.value = JSON.stringify(this.dynamicHeaders);
                form.appendChild(headersInput);

                const rowsInput = document.createElement('input');
                rowsInput.type = 'hidden';
                rowsInput.name = 'rows';
                rowsInput.value = JSON.stringify(this.dynamicRows);
                form.appendChild(rowsInput);
                
                const titleInput = document.createElement('input');
                titleInput.type = 'hidden';
                titleInput.name = 'title';
                titleInput.value = "Laporan Benih dan Pupuk";
                form.appendChild(titleInput);

                document.body.appendChild(form);
                form.submit();
                document.body.removeChild(form);
            },

            // Dependent selection reset
            loadVariabels() {
                this.selection.variabel_id = null;
                this.selection.klasifikasi_ids = [];
            },

            loadKlasifikasis() {
                this.selection.klasifikasi_ids = [];
            },

            // Computed properties for filtering dropdowns
            get filteredTopik() {
                if (!this.search.topik) return this.allData.topiks;
                return this.allData.topiks.filter(t => t.nama.toLowerCase().includes(this.search.topik.toLowerCase()));
            },

            get filteredVariabel() {
                if (!this.selection.topik_id) return [];
                let variabels = this.allData.variabels.filter(v => v.topik_id == this.selection.topik_id);
                if (this.search.variabel) {
                    variabels = variabels.filter(v => v.nama.toLowerCase().includes(this.search.variabel.toLowerCase()));
                }
                return variabels;
            },

            get filteredKlasifikasi() {
                if (!this.selection.variabel_id) return [];
                let klasifikasis = this.allData.klasifikasis.filter(k => k.variabel_id == this.selection.variabel_id);
                if (this.search.klasifikasi) {
                    klasifikasis = klasifikasis.filter(k => k.nama.toLowerCase().includes(this.search.klasifikasi.toLowerCase()));
                }
                return klasifikasis;
            },

            get filteredTahun() {
                if (!this.search.tahun) return this.allData.tahuns;
                return this.allData.tahuns.filter(t => t.toString().includes(this.search.tahun));
            },

            get filteredBulan() {
                if (!this.search.bulan) return this.allData.bulans;
                return this.allData.bulans.filter(b => b.nama.toLowerCase().includes(this.search.bulan.toLowerCase()));
            },


            toggleKabupaten(id) {
                if (this.selection.kabupaten_ids.includes(id)) {
                    this.selection.kabupaten_ids = this.selection.kabupaten_ids.filter(kId => kId !== id);
                } else {
                    this.selection.kabupaten_ids.push(id);
                }
            },

            toggleWilayah(id) {
                if (this.selection.provinsi_ids.includes(id)) {
                    this.selection.provinsi_ids = this.selection.provinsi_ids.filter(pId => pId !== id);
                } else {
                    this.selection.provinsi_ids.push(id);
                }
            },

            get filteredWilayah() {
                const searchTerm = this.search.wilayah.toLowerCase();
                if (this.wilayahLevel === 'nasional') {
                    if (!searchTerm) return this.allData.wilayahs;
                    return this.allData.wilayahs.filter(p => p.nama.toLowerCase().includes(searchTerm));
                }

                // Tingkat Provinsi
                if (this.selectedProvinsiId) {
                    const selectedProv = this.allData.wilayahs.find(p => p.id == this.selectedProvinsiId);
                    if (!selectedProv) return [];
                    // Return an array with a single province object, containing filtered kabupaten
                    const filteredKabupaten = selectedProv.kabupaten.filter(k => k.nama.toLowerCase().includes(searchTerm));
                    return [{ ...selectedProv, kabupaten: filteredKabupaten }];
                }

                // Default view for 'provinsi' level before a province is selected
                if (!searchTerm) return this.allData.wilayahs;
                return this.allData.wilayahs.filter(provinsi => {
                    const provMatch = provinsi.nama.toLowerCase().includes(searchTerm);
                    const kabMatch = provinsi.kabupaten.some(kab => kab.nama.toLowerCase().includes(searchTerm));
                    return provMatch || kabMatch;
                });
            },

        get dynamicHeaders() {
            if (!this.searchResults || !this.searchResults.data || this.searchResults.data.length === 0) {
                return [];
            }

            const { columnOrder } = this.searchResults;
            
            // Create simple headers based on columnOrder from backend
            const headers = [];
            
            // Add main header row with column names
            const mainHeaderRow = columnOrder.map(col => ({
                name: col.charAt(0).toUpperCase() + col.slice(1), // Capitalize first letter
                span: 1
            }));
            
            headers.push([
                { name: 'Wilayah', span: 1, rowspan: 1 },
                ...mainHeaderRow
            ]);
            
            return headers;
        },

        get dynamicRows() {
            if (!this.searchResults || !this.searchResults.data || this.searchResults.data.length === 0) {
                return [];
            }
            
            // Backend already returns data in the correct format: [{wilayah: "...", values: [...]}]
            return this.searchResults.data;
        },

        // Helper function
        getColumnOrderKeys(layout) {
            if (layout === 'tipe_1') return ['variabel', 'klasifikasi', 'tahun', 'bulan'];
            if (layout === 'tipe_2') return ['klasifikasi', 'variabel', 'tahun', 'bulan'];
            if (layout === 'tipe_3') return ['tahun', 'bulan', 'variabel', 'klasifikasi'];
            return [];
        }
        };
    }
</script>


                    <div x-data="benihPupukForm()" x-init="init(benihPupukInitialData)" class="space-y-12">
                        <!-- Step 1: Select Data -->
<section class="bg-neutral-50 rounded-lg p-6 border border-neutral-200">
    <h2 class="text-2xl font-bold text-neutral-800 mb-1 flex items-center">
        <span class="bg-blue-600 text-white rounded-full h-8 w-8 flex items-center justify-center mr-3">1</span>
        Pilih Data
    </h2>
    <p class="text-neutral-600 mb-6 ml-11">Pilih Topik, Variabel dan Periode Waktu.</p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- 1.1 Topik -->
        <div class="bg-white p-4 rounded-lg border">
            <h3 class="font-semibold text-neutral-900 mb-3">1.1 Topik</h3>
            <input type="text" x-model="search.topik" placeholder="search..." class="w-full px-3 py-2 border border-neutral-300 rounded-md mb-2 text-sm">
            <div class="space-y-1 max-h-32 overflow-y-auto">
                <template x-for="topik in filteredTopik" :key="topik.id">
                    <div @click="selectTopik(topik.id)" class="flex items-center cursor-pointer hover:bg-blue-50 p-2 rounded-md" :class="{'bg-blue-100 font-semibold': selection.topik_id === topik.id}">
                        <span class="ml-2 text-sm text-neutral-700" x-text="topik.nama"></span>
                    </div>
                </template>
            </div>
        </div>

        <!-- 1.2 Variabel -->
        <div class="bg-white p-4 rounded-lg border">
            <h3 class="font-semibold text-neutral-900 mb-3">1.2 Variabel</h3>
            <div :class="!selection.topik_id ? 'opacity-50 pointer-events-none' : ''">
                <input type="text" x-model="search.variabel" placeholder="search..." class="w-full px-3 py-2 border border-neutral-300 rounded-md mb-2 text-sm">
                <div class="max-h-24 overflow-y-auto mb-3 border rounded-md p-2">
                    <template x-for="variabel in filteredVariabel" :key="variabel.id">
                        <div @click="selectVariabel(variabel.id)" class="flex items-center cursor-pointer hover:bg-blue-50 p-2 rounded-md" :class="{'bg-blue-100 font-semibold': selection.variabel_id === variabel.id}">
                            <span class="ml-2 text-sm text-neutral-700" x-text="variabel.nama"></span>
                        </div>
                    </template>
                </div>
                <h4 class="font-medium text-neutral-800 mb-2 text-sm">Klasifikasi Variabel</h4>
                <input type="text" x-model="search.klasifikasi" placeholder="search..." class="w-full px-3 py-2 border border-neutral-300 rounded-md mb-2 text-sm">
                <div class="max-h-24 overflow-y-auto border rounded-md p-2">
                    <template x-for="klasifikasi in filteredKlasifikasi" :key="klasifikasi.id">
                        <label class="flex items-center cursor-pointer hover:bg-green-50 p-2 rounded-md">
                            <input type="checkbox" :value="klasifikasi.id" x-model="selection.klasifikasi_ids">
                            <span class="ml-2 text-sm text-neutral-700" x-text="klasifikasi.nama"></span>
                        </label>
                    </template>
                </div>
            </div>
        </div>

        <!-- 1.3 Waktu -->
        <div class="bg-white p-4 rounded-lg border flex flex-col">
            <h3 class="font-semibold text-neutral-900 mb-3">1.3 Waktu</h3>
            <div class="grid grid-cols-2 gap-4 flex-grow">
                <div class="flex flex-col">
                    <label class="block text-sm font-medium text-neutral-700 mb-1">Tahun</label>
                    <div class="flex justify-between items-center mb-1">
                        <button @click="selection.tahun_ids = filteredTahun.map(t => t)" class="text-xs text-blue-600 hover:underline">Select All</button>
                        <button @click="selection.tahun_ids = []" class="text-xs text-red-600 hover:underline">Clear</button>
                    </div>
                    <input type="text" x-model="search.tahun" placeholder="search..." class="w-full px-3 py-2 border border-neutral-300 rounded-md mb-2 text-sm">
                    <div class="overflow-y-auto border rounded-md p-2 flex-grow">
                        <template x-for="year in filteredTahun" :key="year">
                            <label class="flex items-center cursor-pointer hover:bg-blue-50 p-2 rounded-md">
                                <input type="checkbox" :value="year" x-model="selection.tahun_ids">
                                <span class="ml-2 text-sm text-neutral-700" x-text="year"></span>
                            </label>
                        </template>
                    </div>
                </div>
                <div class="flex flex-col">
                    <label class="block text-sm font-medium text-neutral-700 mb-1">Bulan</label>
                     <div class="flex justify-between items-center mb-1">
                        <button @click="selection.bulan_ids = filteredBulan.map(b => b.id)" class="text-xs text-blue-600 hover:underline">Select All</button>
                        <button @click="selection.bulan_ids = []" class="text-xs text-red-600 hover:underline">Clear</button>
                    </div>
                    <input type="text" x-model="search.bulan" placeholder="search..." class="w-full px-3 py-2 border border-neutral-300 rounded-md mb-2 text-sm">
                    <div class="overflow-y-auto border rounded-md p-2 flex-grow">
                        <template x-for="bulan in filteredBulan" :key="bulan.id">
                            <label class="flex items-center cursor-pointer hover:bg-green-50 p-2 rounded-md">
                                <input type="checkbox" :value="bulan.id" x-model="selection.bulan_ids">
                                <span class="ml-2 text-sm text-neutral-700" x-text="bulan.nama"></span>
                            </label>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-2">
            <button @click="addSelection" :disabled="!isSelectionValid()" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 flex items-center disabled:opacity-50 disabled:cursor-not-allowed">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah
            </button>
            <button @click="removeSelection()" :disabled="selectedForRemoval.length === 0" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 flex items-center disabled:opacity-50 disabled:cursor-not-allowed">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path></svg>
                Hapus
            </button>
        </div>
        <button @click="resetForm" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">Set Ulang</button>
    </div>

    <!-- Data Terpilih -->
    <div class="bg-white p-4 rounded-lg border">
        <h3 class="font-semibold text-neutral-900 mb-3">Data Terpilih</h3>
        <div class="space-y-2">
            <template x-for="item in selections" :key="item.id">
                <div class="flex items-center bg-blue-50 p-2 rounded-md">
                    <input type="checkbox" :value="item.id" x-model="selectedForRemoval">
                    <span class="ml-2 text-sm text-neutral-800" x-text="`${item.display.variabel_nama} - ${item.display.klasifikasi_nama} - ${item.display.tahun} - ${item.display.bulan}`"></span>
                </div>
            </template>
            <div x-show="selections.length === 0" class="text-center text-neutral-500 py-4">
                <p>Belum ada data yang ditambahkan.</p>
            </div>
        </div>
    </div>
</section>

                <!-- Step 2: Konfigurasi Tampilan -->
<section class="bg-neutral-50 rounded-lg p-6 border border-neutral-200">
    <h2 class="text-2xl font-bold text-neutral-800 mb-1 flex items-center">
        <span class="bg-blue-600 text-white rounded-full h-8 w-8 flex items-center justify-center mr-3">2</span>
        Konfigurasi Tampilan
    </h2>
    <p class="text-neutral-600 mb-6 ml-11">Pilih wilayah dan bagaimana data akan disajikan dalam tabel.</p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- 2.1 Wilayah -->
        <div class="bg-white p-4 rounded-lg border">
            <h3 class="font-semibold text-neutral-900 mb-3">2.1 Wilayah</h3>

            <select x-model="wilayahLevel" class="w-full px-3 py-2 border border-neutral-300 rounded-md mb-3 text-sm">
                <option value="nasional">Tingkat Nasional</option>
                <option value="provinsi">Tingkat Provinsi</option>
            </select>

            <!-- Tingkat Nasional View -->
            <div x-show="wilayahLevel === 'nasional'">
                 <div class="flex justify-between items-center mb-1">
                    <button @click="selection.provinsi_ids = filteredWilayah.map(p => p.id)" class="text-xs text-blue-600 hover:underline">Select All</button>
                    <button @click="selection.provinsi_ids = []" class="text-xs text-red-600 hover:underline">Clear</button>
                </div>
                <input type="text" x-model="search.wilayah" placeholder="Cari provinsi..." class="w-full px-3 py-2 border border-neutral-300 rounded-md mb-2 text-sm">
                <div class="max-h-64 overflow-y-auto border rounded-md p-2">
                    <template x-for="provinsi in filteredWilayah" :key="provinsi.id">
                        <label class="flex items-center cursor-pointer p-2 rounded-md hover:bg-blue-50">
                            <input type="checkbox" :value="provinsi.id" :checked="selection.provinsi_ids.includes(provinsi.id)" @click="toggleWilayah(provinsi.id)">
                            <span class="ml-2 text-sm font-bold text-neutral-800" x-text="provinsi.nama"></span>
                        </label>
                    </template>
                </div>
            </div>

            <!-- Tingkat Provinsi View -->
            <div x-show="wilayahLevel === 'provinsi'">
                <select x-model="selectedProvinsiId" class="w-full px-3 py-2 border border-neutral-300 rounded-md mb-3 text-sm">
                    <option :value="null">-- Pilih Provinsi Dahulu --</option>
                    <template x-for="provinsi in allData.wilayahs" :key="provinsi.id">
                        <option :value="provinsi.id" x-text="provinsi.nama"></option>
                    </template>
                </select>

                <div x-show="selectedProvinsiId">
                     <div class="flex justify-between items-center mb-1">
                        <button @click="selection.kabupaten_ids = filteredWilayah.flatMap(p => p.kabupaten.map(k => k.id))" class="text-xs text-blue-600 hover:underline">Select All</button>
                        <button @click="selection.kabupaten_ids = []" class="text-xs text-red-600 hover:underline">Clear</button>
                    </div>
                    <input type="text" x-model="search.wilayah" placeholder="Cari kabupaten/kota..." class="w-full px-3 py-2 border border-neutral-300 rounded-md mb-2 text-sm">
                    <div class="max-h-64 overflow-y-auto border rounded-md p-2">
                        <template x-for="provinsi in filteredWilayah" :key="provinsi.id">
                            <div class="ml-6">
                                <template x-for="kabupaten in provinsi.kabupaten" :key="kabupaten.id">
                                    <label class="flex items-center cursor-pointer p-1 rounded-md hover:bg-green-50">
                                        <input type="checkbox" :value="kabupaten.id" :checked="selection.kabupaten_ids.includes(kabupaten.id)" @click="toggleKabupaten(kabupaten.id)">
                                        <span class="ml-2 text-sm text-neutral-700" x-text="kabupaten.nama"></span>
                                    </label>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
                 <div x-show="!selectedProvinsiId" class="p-4 bg-gray-50 rounded-md text-center">
                    <p class="text-sm text-neutral-500">Silakan pilih provinsi untuk menampilkan daftar kabupaten/kota.</p>
                </div>
            </div>
        </div>

        <!-- 2.2 Tata Letak Tabel -->
        <div class="bg-white p-4 rounded-lg border">
            <h3 class="font-semibold text-neutral-900 mb-3">2.2 Tata Letak Tabel</h3>
            <div class="space-y-4">
                <!-- Tipe 1 -->
                <label class="block p-4 border rounded-lg cursor-pointer hover:border-blue-500" :class="{'border-blue-500 bg-blue-50 ring-2 ring-blue-200': selection.tata_letak === 'tipe_1'}">
                    <div class="flex gap-6 items-start">
                        <input type="radio" name="tata_letak" value="tipe_1" x-model="selection.tata_letak" class="mt-1">
                        <div class="flex-1">
                            <p class="font-semibold">Tipe 1: Master Header Variabel</p>
                            <p class="text-sm text-neutral-600 mb-2">Kolom diurutkan berdasarkan: Variabel &raquo; Klasifikasi &raquo; Tahun &raquo; Bulan</p>
                            <table class="w-full border-collapse text-xs mt-2 bg-white">
                                <thead>
                                    <tr class="bg-neutral-100">
                                        <th rowspan="4" class="border p-1 font-semibold align-middle">Wilayah</th>
                                        <th colspan="4" class="border p-1 font-semibold">Variabel A</th>
                                    </tr>
                                    <tr class="bg-neutral-50">
                                        <th colspan="2" class="border p-1 font-normal">Klasifikasi X</th>
                                        <th colspan="2" class="border p-1 font-normal">Klasifikasi Y</th>
                                    </tr>
                                    <tr class="bg-neutral-50">
                                        <th colspan="1" class="border p-1 font-normal">2023</th>
                                        <th colspan="1" class="border p-1 font-normal">2024</th>
                                        <th colspan="1" class="border p-1 font-normal">2023</th>
                                        <th colspan="1" class="border p-1 font-normal">2024</th>
                                    </tr>
                                    <tr class="bg-neutral-50">
                                        <th class="border p-1 font-normal">Jan</th>
                                        <th class="border p-1 font-normal">Jan</th>
                                        <th class="border p-1 font-normal">Jan</th>
                                        <th class="border p-1 font-normal">Jan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="border p-1">Provinsi A</td>
                                        <td class="border p-1 text-center">...</td>
                                        <td class="border p-1 text-center">...</td>
                                        <td class="border p-1 text-center">...</td>
                                        <td class="border p-1 text-center">...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </label>

                <!-- Tipe 2 -->
                <label class="block p-4 border rounded-lg cursor-pointer hover:border-blue-500" :class="{'border-blue-500 bg-blue-50 ring-2 ring-blue-200': selection.tata_letak === 'tipe_2'}">
                    <div class="flex gap-6 items-start">
                        <input type="radio" name="tata_letak" value="tipe_2" x-model="selection.tata_letak" class="mt-1">
                        <div class="flex-1">
                            <p class="font-semibold">Tipe 2: Master Header Klasifikasi</p>
                            <p class="text-sm text-neutral-600 mb-2">Kolom diurutkan berdasarkan: Klasifikasi &raquo; Variabel &raquo; Tahun &raquo; Bulan</p>
                            <table class="w-full border-collapse text-xs mt-2 bg-white">
                                <thead>
                                    <tr class="bg-neutral-100">
                                        <th rowspan="4" class="border p-1 font-semibold align-middle">Wilayah</th>
                                        <th colspan="4" class="border p-1 font-semibold">Klasifikasi X</th>
                                    </tr>
                                    <tr class="bg-neutral-50">
                                        <th colspan="2" class="border p-1 font-normal">Variabel A</th>
                                        <th colspan="2" class="border p-1 font-normal">Variabel B</th>
                                    </tr>
                                    <tr class="bg-neutral-50">
                                        <th colspan="1" class="border p-1 font-normal">2023</th>
                                        <th colspan="1" class="border p-1 font-normal">2024</th>
                                        <th colspan="1" class="border p-1 font-normal">2023</th>
                                        <th colspan="1" class="border p-1 font-normal">2024</th>
                                    </tr>
                                    <tr class="bg-neutral-50">
                                        <th class="border p-1 font-normal">Jan</th>
                                        <th class="border p-1 font-normal">Jan</th>
                                        <th class="border p-1 font-normal">Jan</th>
                                        <th class="border p-1 font-normal">Jan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="border p-1">Provinsi A</td>
                                        <td class="border p-1 text-center">...</td>
                                        <td class="border p-1 text-center">...</td>
                                        <td class="border p-1 text-center">...</td>
                                        <td class="border p-1 text-center">...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </label>

                <!-- Tipe 3 -->
                <label class="block p-4 border rounded-lg cursor-pointer hover:border-blue-500" :class="{'border-blue-500 bg-blue-50 ring-2 ring-blue-200': selection.tata_letak === 'tipe_3'}">
                    <div class="flex gap-6 items-start">
                        <input type="radio" name="tata_letak" value="tipe_3" x-model="selection.tata_letak" class="mt-1">
                        <div class="flex-1">
                            <p class="font-semibold">Tipe 3: Master Header Waktu</p>
                            <p class="text-sm text-neutral-600 mb-2">Kolom diurutkan berdasarkan: Tahun &raquo; Bulan &raquo; Variabel &raquo; Klasifikasi</p>
                            <table class="w-full border-collapse text-xs mt-2 bg-white">
                                <thead>
                                    <tr class="bg-neutral-100">
                                        <th rowspan="4" class="border p-1 font-semibold align-middle">Wilayah</th>
                                        <th colspan="4" class="border p-1 font-semibold">2023</th>
                                    </tr>
                                    <tr class="bg-neutral-50">
                                        <th colspan="2" class="border p-1 font-normal">Januari</th>
                                        <th colspan="2" class="border p-1 font-normal">Februari</th>
                                    </tr>
                                    <tr class="bg-neutral-50">
                                        <th colspan="1" class="border p-1 font-normal">Variabel A</th>
                                        <th colspan="1" class="border p-1 font-normal">Variabel B</th>
                                        <th colspan="1" class="border p-1 font-normal">Variabel A</th>
                                        <th colspan="1" class="border p-1 font-normal">Variabel B</th>
                                    </tr>
                                    <tr class="bg-neutral-50">
                                        <th class="border p-1 font-normal">Klas. X</th>
                                        <th class="border p-1 font-normal">Klas. X</th>
                                        <th class="border p-1 font-normal">Klas. X</th>
                                        <th class="border p-1 font-normal">Klas. X</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="border p-1">Provinsi A</td>
                                        <td class="border p-1 text-center">...</td>
                                        <td class="border p-1 text-center">...</td>
                                        <td class="border p-1 text-center">...</td>
                                        <td class="border p-1 text-center">...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </label>
            </div>
        </div>
    </div>
</section>
<!-- Submit Button -->
<div class="flex justify-end mt-8">
    <button @click.prevent="fetchData" :disabled="isProcessing" class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-md hover:bg-blue-700 disabled:bg-blue-300 flex items-center justify-center disabled:cursor-not-allowed">
        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        Tampilkan Hasil
    </button>
</div>

<!-- Step 3: Tampilan Hasil -->
<section x-show="isProcessing || (searchResults.data && searchResults.data.length > 0)" class="bg-neutral-50 rounded-lg p-6 border border-neutral-200 mt-12">
    <h2 class="text-2xl font-bold text-neutral-800 mb-1 flex items-center">
        <span class="bg-blue-600 text-white rounded-full h-8 w-8 flex items-center justify-center mr-3">3</span>
        Tampilan Hasil
    </h2>
    <p class="text-neutral-600 mb-6 ml-11">Hasil dari data yang telah Anda pilih.</p>

    <!-- Loading/Processing State -->
    <div x-show="isProcessing" class="text-center py-12">
        <svg class="animate-spin w-12 h-12 text-blue-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <h3 class="text-lg font-medium text-neutral-900 mb-2">Memproses Data...</h3>
        <p class="text-neutral-700">Mohon tunggu, kami sedang menyiapkan laporan untuk Anda.</p>
    </div>

    <!-- Results Container -->
    <div x-show="!isProcessing && searchResults.length > 0">
        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center gap-1">
                <button @click="activeTab = 'tabel'" :class="{'bg-blue-600 text-white': activeTab === 'tabel', 'bg-neutral-200 text-neutral-700': activeTab !== 'tabel'}" class="px-4 py-2 rounded-l-md font-medium">Tabel</button>
                <button @click="activeTab = 'grafik'" :class="{'bg-blue-600 text-white': activeTab === 'grafik', 'bg-neutral-200 text-neutral-700': activeTab !== 'grafik'}" class="px-4 py-2 rounded-r-md font-medium">Grafik</button>
            </div>
            <div class="flex justify-end mb-4">
            <button @click="exportExcel()" class="px-4 py-2 bg-green-600 text-white rounded-md font-medium flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Export (.xlsx)
            </button>
        </div>

        <!-- Tabel Section -->
        <div x-show="activeTab === 'tabel'" class="overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200 border">
                                <thead>
                                    <template x-for="(headerRow, rowIndex) in dynamicHeaders" :key="rowIndex">
                                        <tr>
                                            <template x-for="(header, headerIndex) in headerRow" :key="headerIndex">
                                                <th class="px-4 py-2 border border-neutral-300 bg-neutral-100 text-center font-semibold text-neutral-700"
                                                    :colspan="header.span"
                                                    :rowspan="header.rowspan"
                                                    x-text="header.name">
                                                </th>
                                            </template>
                                        </tr>
                                    </template>
                                </thead>
                                <tbody class="bg-white divide-y divide-neutral-200">
                                    <template x-if="!dynamicRows || dynamicRows.length === 0">
                                        <tr>
                                            <td :colspan="(dynamicHeaders[0] || []).length > 0 ? (dynamicHeaders[dynamicHeaders.length - 1] || []).length + 1 : 1" class="text-center py-8 text-neutral-500">
                                                Tidak ada data yang sesuai dengan kriteria yang dipilih.
                                            </td>
                                        </tr>
                                    </template>
                                    <template x-for="row in dynamicRows" :key="row.wilayah">
                                        <tr>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-neutral-800 border" x-text="row.wilayah"></td>
                                            <template x-for="(value, valueIndex) in row.values" :key="valueIndex">
                                                <td class="px-4 py-4 whitespace-nowrap text-sm text-neutral-700 border text-right" x-text="value"></td>
                                            </template>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
        </div>

        <!-- Grafik Section -->
        <div x-show="activeTab === 'grafik'" style="height: 500px;">
            <canvas id="chart-container"></canvas>
        </div>
    </div>
    <div x-show="searchResults" class="space-y-6">
        <!-- Tabs -->
        <div class="bg-white rounded-lg shadow-sm border">
            <!-- Tab Navigation -->
            <div class="border-b border-neutral-200">
                <nav class="flex space-x-8 px-6" aria-label="Tabs">
                    <button @click="activeTab = 'tabel'" 
                            :class="activeTab === 'tabel' ? 'border-blue-500 text-blue-600' : 'border-transparent text-neutral-500 hover:text-neutral-700 hover:border-neutral-300'"
                            class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap">
                        Tabel
                    </button>
                    <button @click="activeTab = 'grafik'" 
                            :class="activeTab === 'grafik' ? 'border-blue-500 text-blue-600' : 'border-transparent text-neutral-500 hover:text-neutral-700 hover:border-neutral-300'"
                            class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap">
                        Grafik
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="p-6">
                <!-- Tabel Tab -->
                <div x-show="activeTab === 'tabel'">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-lg font-semibold text-neutral-700">Tabel Hasil</h4>
                        <template x-if="searchResults && searchResults.rows">
                            <button @click="exportToExcel()" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Ekspor ke Excel
                            </button>
                        </template>
                    </div>
                    <!-- Results Content -->
                    <div id="tabel-container" class="mt-4">
                        <template x-if="searchResults && searchResults.rows && searchResults.rows.length > 0">
                            <div>
                                <!-- Table -->
                                <div class="overflow-x-auto bg-white border border-neutral-200 rounded-lg">
                                    <table class="min-w-full divide-y divide-neutral-200">
                                        <thead class="bg-neutral-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider" x-text="config.tata_letak === 'tipe_1' ? 'Wilayah' : 'Variabel'"></th>
                                                <template x-for="header in searchResults.headers">
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider" x-text="header"></th>
                                                </template>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-neutral-200">
                                            <template x-for="row in searchResults.rows">
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-neutral-900" x-text="row.label"></td>
                                                    <template x-for="value in row.values">
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500" x-text="value !== null ? parseFloat(value).toFixed(2) : '-'"></td>
                                                    </template>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Metodologi Section -->
                                <div class="mt-8">
                                    @include('pertanian.partials.metodologi-benih-pupuk')
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
                <!-- Grafik Tab -->
                <div x-show="activeTab === 'grafik'">
                    <!-- Placeholder for Chart -->
                    <canvas id="chart-container"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>

    <script>
        const benihPupukInitialData = {
            topiks: @json($topiks),
            variabels: @json($variabels),
            klasifikasis: @json($klasifikasis),
            tahuns: @json($tahuns),
            bulans: @json($bulans),
            wilayahs: @json($wilayahs)
        };

        console.log('Global initial data:', benihPupukInitialData);

        function benihPupukForm() {
            return {
                init(data) {
                    console.log('Data received in init():', data);
                    this.allData = data;
                },
                // Data sources from Controller
                allData: {
                    topiks: [],
                    variabels: [],
                    klasifikasis: [],
                    tahuns: [],
                    bulans: [],
                    wilayahs: []
                },

                // Form state
                selection: {
                    topik_id: null,
                    variabel_id: null,
                    klasifikasi_ids: [],
                    tahun_awal: '',
                    tahun_akhir: '',
                    bulan_awal: '',
                    bulan_akhir: '',
                    wilayah_ids: [],
                    tata_letak: 'tipe_1',
                },

                search: {
                    topik: '',
                    variabel: '',
                    klasifikasi: '',
                    tahun: '',
                    bulan: '',
                    wilayah: '',
                },
                
                // UI state
                yearMode: 'range',
                monthMode: 'range',
                isProcessing: false,
                addingToQueue: false,
                activeTab: 'tabel',
                
                // Queue system
                filterQueue: [],
                searchResults: [], // Initialize searchResults to an empty array

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
                async verifyDisplayedData() {
                    console.log('=== DATA VERIFICATION ===');
                    // ... (no changes)
                },

                loadVariabels() {
                    this.selection.variabel_id = null;
                    this.selection.klasifikasi_ids = [];
                },

                loadKlasifikasis() {
                    this.selection.klasifikasi_ids = [];
                },

                get filteredTopik() {
                    if (!this.search.topik) return this.allData.topiks;
                    return this.allData.topiks.filter(t => t.nama.toLowerCase().includes(this.search.topik.toLowerCase()));
                },

                get filteredVariabel() {
                    if (!this.selection.topik_id) return [];
                    let variabels = this.allData.variabels.filter(v => v.topik_id == this.selection.topik_id);
                    if (this.search.variabel) {
                        variabels = variabels.filter(v => v.nama.toLowerCase().includes(this.search.variabel.toLowerCase()));
                    }
                    return variabels;
                },

                get filteredKlasifikasi() {
                    if (!this.selection.variabel_id) return [];
                    let klasifikasis = this.allData.klasifikasis.filter(k => k.variabel_id == this.selection.variabel_id);
                    if (this.search.klasifikasi) {
                        klasifikasis = klasifikasis.filter(k => k.nama.toLowerCase().includes(this.search.klasifikasi.toLowerCase()));
                    }
                    return klasifikasis;
                },

                get filteredTahun() {
                    if (!this.search.tahun) return this.allData.tahuns;
                    return this.allData.tahuns.filter(y => y.toString().includes(this.search.tahun));
                },

                get filteredBulan() {
                    if (!this.search.bulan) return this.allData.bulans;
                    return this.allData.bulans.filter(b => b.nama.toLowerCase().includes(this.search.bulan.toLowerCase()));
                },

                get filteredWilayah() {
                    if (!this.search.wilayah) return this.allData.wilayahs;
                    const search = this.search.wilayah.toLowerCase();
                    return this.allData.wilayahs.map(prov => {
                        const filteredKab = prov.kabupaten.filter(kab => kab.nama.toLowerCase().includes(search));
                        if (prov.nama.toLowerCase().includes(search) || filteredKab.length > 0) {
                            return { ...prov, kabupaten: prov.nama.toLowerCase().includes(search) ? prov.kabupaten : filteredKab };
                        }
                        return null;
                    }).filter(Boolean);
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

                async exportToExcel() {
                    if (!this.searchResults) return;

                    try {
                        const response = await fetch('/api/benih-pupuk/export-excel', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                headers: this.searchResults.headers,
                                rows: this.searchResults.rows,
                                config: this.config
                            })
                        });

                        if (!response.ok) {
                            throw new Error('Gagal membuat file Excel di server.');
                        }

                        const blob = await response.blob();
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.style.display = 'none';
                        a.href = url;
                        a.download = 'laporan-benih-pupuk.xlsx';
                        document.body.appendChild(a);
                        a.click();
                        window.URL.revokeObjectURL(url);
                        document.body.removeChild(a);

                    } catch (error) {
                        console.error('Error exporting to Excel:', error);
                        alert('Terjadi kesalahan saat mengekspor data. Silakan periksa konsol untuk detailnya.');
                    }
                }
            };
        }
    </div>

@push('scripts')
<script>
    // This script is intentionally left blank.
    // The benihPupukForm() function is now defined within the main component script block.
</script>
@endpush
</div>

</x-layouts.landing>
