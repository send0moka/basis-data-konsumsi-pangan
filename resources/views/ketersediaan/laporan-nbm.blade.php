<x-layouts.landing>
    <div class="py-12 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600">
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-gray-500">Ketersediaan</span>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-blue-600 font-medium">Laporan Data NBM</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Header -->
            <div class="mb-12">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Laporan Data Neraca Bahan Makanan
                </h1>
                <p class="text-xl text-gray-600">
                    Akses data ketersediaan pangan Indonesia melalui Neraca Bahan Makanan (NBM)
                </p>
            </div>

            <!-- Login Notice -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="text-lg font-medium text-blue-900">Akses Data Lengkap</h3>
                        <p class="text-blue-700 mt-1">
                            Untuk mengakses data NBM lengkap, silakan login ke sistem manajemen data.
                        </p>
                        <a href="{{ route('login') }}" 
                           class="inline-block mt-3 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-200">
                            Login Sekarang
                        </a>
                    </div>
                </div>
            </div>

            <!-- Data Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-lg">
                    <h3 class="text-lg font-semibold mb-2">Total Komoditas</h3>
                    <p class="text-3xl font-bold">200+</p>
                    <p class="text-blue-100 text-sm">Jenis komoditas pangan</p>
                </div>
                <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-6 rounded-lg">
                    <h3 class="text-lg font-semibold mb-2">Periode Data</h3>
                    <p class="text-3xl font-bold">1993-2025</p>
                    <p class="text-green-100 text-sm">Tahun ketersediaan data</p>
                </div>
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white p-6 rounded-lg">
                    <h3 class="text-lg font-semibold mb-2">Kelompok Pangan</h3>
                    <p class="text-3xl font-bold">10</p>
                    <p class="text-purple-100 text-sm">Kelompok utama</p>
                </div>
            </div>

            <!-- Data Categories -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Kelompok Data NBM</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition duration-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">01 - Padi-padian</h3>
                        <p class="text-gray-600 text-sm mb-4">Gabah, beras, jagung, gandum, dan tepung gandum</p>
                        <div class="text-sm text-blue-600">6 komoditas</div>
                    </div>
                    
                    <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition duration-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">02 - Makanan Berpati</h3>
                        <p class="text-gray-600 text-sm mb-4">Ubi kayu, ubi jalar, kentang, sagu, dan produk turunannya</p>
                        <div class="text-sm text-blue-600">8 komoditas</div>
                    </div>
                    
                    <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition duration-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">03 - Gula</h3>
                        <p class="text-gray-600 text-sm mb-4">Tebu, gula pasir, gula merah, dan pemanis lainnya</p>
                        <div class="text-sm text-blue-600">4 komoditas</div>
                    </div>
                    
                    <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition duration-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">04 - Buah Biji Berminyak</h3>
                        <p class="text-gray-600 text-sm mb-4">Kelapa, kemiri, wijen, dan biji-bijian berminyak lainnya</p>
                        <div class="text-sm text-blue-600">12 komoditas</div>
                    </div>
                    
                    <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition duration-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">05 - Buah-buahan</h3>
                        <p class="text-gray-600 text-sm mb-4">Pisang, jeruk, mangga, apel, dan buah-buahan lainnya</p>
                        <div class="text-sm text-blue-600">25 komoditas</div>
                    </div>
                    
                    <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition duration-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">06 - Sayur-sayuran</h3>
                        <p class="text-gray-600 text-sm mb-4">Kacang panjang, bayam, kangkung, tomat, dan sayuran lainnya</p>
                        <div class="text-sm text-blue-600">30 komoditas</div>
                    </div>
                    
                    <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition duration-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">07 - Daging</h3>
                        <p class="text-gray-600 text-sm mb-4">Daging sapi, kerbau, kambing, ayam, dan daging lainnya</p>
                        <div class="text-sm text-blue-600">8 komoditas</div>
                    </div>
                    
                    <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition duration-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">08 - Telur</h3>
                        <p class="text-gray-600 text-sm mb-4">Telur ayam ras, ayam kampung, itik, dan telur unggas lainnya</p>
                        <div class="text-sm text-blue-600">4 komoditas</div>
                    </div>
                    
                    <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition duration-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">09 - Susu</h3>
                        <p class="text-gray-600 text-sm mb-4">Susu segar, susu bubuk, dan produk olahan susu</p>
                        <div class="text-sm text-blue-600">5 komoditas</div>
                    </div>
                    
                    <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition duration-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">10 - Minyak dan Lemak</h3>
                        <p class="text-gray-600 text-sm mb-4">Minyak kelapa, sawit, kedelai, dan lemak hewani</p>
                        <div class="text-sm text-blue-600">8 komoditas</div>
                    </div>
                </div>
            </div>

            <!-- Sample Data Preview -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Contoh Data NBM</h2>
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelompok</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Komoditas</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tahun</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produksi (ton)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ketersediaan (kg/kap/thn)</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Padi-padian</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Beras</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">2023</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">31,547,000</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">94.6</td>
                                </tr>
                                <tr class="bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Buah-buahan</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Pisang</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">2023</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">8,182,000</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">24.8</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Daging</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Ayam</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">2023</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">3,942,000</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">11.2</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="bg-gray-50 px-6 py-3">
                        <p class="text-sm text-gray-600">
                            <em>Data di atas hanya contoh. Untuk mengakses data lengkap dan terbaru, silakan login ke sistem.</em>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Related Links -->
            <div class="bg-gray-50 p-6 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Halaman Terkait</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('ketersediaan.konsep-metode') }}" 
                       class="block p-4 bg-white rounded border hover:shadow-md transition duration-200">
                        <h4 class="font-medium text-blue-600">Konsep dan Metode</h4>
                        <p class="text-sm text-gray-600 mt-1">Pelajari metodologi penyusunan NBM</p>
                    </a>
                    <a href="{{ route('konsumsi.konsep-metode') }}" 
                       class="block p-4 bg-white rounded border hover:shadow-md transition duration-200">
                        <h4 class="font-medium text-blue-600">Data Konsumsi</h4>
                        <p class="text-sm text-gray-600 mt-1">Lihat data konsumsi pangan dari Susenas</p>
                    </a>
                    <a href="{{ route('login') }}" 
                       class="block p-4 bg-white rounded border hover:shadow-md transition duration-200">
                        <h4 class="font-medium text-blue-600">Manajemen Data</h4>
                        <p class="text-sm text-gray-600 mt-1">Login untuk akses data lengkap</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.landing>
