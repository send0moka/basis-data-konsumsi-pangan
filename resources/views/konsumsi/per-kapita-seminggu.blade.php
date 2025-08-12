<x-layouts.landing>
    <div class="py-12 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600">Home</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-gray-500">Konsumsi</span>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-blue-600 font-medium">Konsumsi Per Kapita Seminggu</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Header -->
            <div class="mb-12">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Konsumsi Pangan Per Kapita Seminggu
                </h1>
                <p class="text-xl text-gray-600">
                    Data konsumsi pangan rata-rata per kapita dalam periode seminggu berdasarkan Susenas
                </p>
            </div>

            <!-- Login Notice -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-8">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="text-lg font-medium text-yellow-900">Akses Data Lengkap</h3>
                        <p class="text-yellow-700 mt-1">
                            Untuk mengakses data konsumsi per kapita seminggu lengkap, silakan login ke sistem.
                        </p>
                        <a href="{{ route('login') }}" 
                           class="inline-block mt-3 bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700 transition duration-200">
                            Login Sekarang
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sample Data -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Contoh Data Konsumsi Seminggu (2023)</h2>
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kelompok Pangan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Konsumsi (g/kap/minggu)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Energi (kkal/minggu)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Protein (g/minggu)</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Padi-padian</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">1,996.4</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">7,294</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">156.8</td>
                                </tr>
                                <tr class="bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Umbi-umbian</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">78.4</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">126</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">2.8</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Ikan/Udang/Cumi</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">200.2</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">217</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">40.6</td>
                                </tr>
                                <tr class="bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Daging</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">56.7</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">147</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">11.9</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Telur dan Susu</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">84.0</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">154</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">8.4</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="bg-gray-50 px-6 py-3">
                        <p class="text-sm text-gray-600">
                            <em>Data di atas adalah contoh. Data lengkap tersedia setelah login ke sistem.</em>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Info Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                <div class="bg-blue-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-blue-900 mb-3">Kegunaan Data Mingguan</h3>
                    <ul class="text-blue-800 space-y-2">
                        <li>• Monitoring pola konsumsi jangka pendek</li>
                        <li>• Evaluasi program intervensi gizi</li>
                        <li>• Perencanaan kebutuhan pangan harian</li>
                        <li>• Analisis variasi konsumsi musiman</li>
                    </ul>
                </div>
                <div class="bg-green-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-green-900 mb-3">Cakupan Data</h3>
                    <ul class="text-green-800 space-y-2">
                        <li>• Seluruh provinsi di Indonesia</li>
                        <li>• Perkotaan dan perdesaan</li>
                        <li>• Berbagai tingkat sosial ekonomi</li>
                        <li>• Data triwulanan sejak 1993</li>
                    </ul>
                </div>
            </div>

            <!-- Related Links -->
            <div class="bg-gray-50 p-6 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Halaman Terkait</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('konsumsi.per-kapita-setahun') }}" class="block p-4 bg-white rounded border hover:shadow-md transition duration-200">
                        <h4 class="font-medium text-blue-600">Per Kapita Setahun</h4>
                        <p class="text-sm text-gray-600 mt-1">Data konsumsi tahunan</p>
                    </a>
                    <a href="{{ route('konsumsi.laporan-susenas') }}" class="block p-4 bg-white rounded border hover:shadow-md transition duration-200">
                        <h4 class="font-medium text-blue-600">Laporan Susenas</h4>
                        <p class="text-sm text-gray-600 mt-1">Data lengkap Susenas konsumsi</p>
                    </a>
                    <a href="{{ route('login') }}" class="block p-4 bg-white rounded border hover:shadow-md transition duration-200">
                        <h4 class="font-medium text-blue-600">Manajemen Data</h4>
                        <p class="text-sm text-gray-600 mt-1">Login untuk akses data lengkap</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.landing>
