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
                            <span class="ml-1 text-blue-600 font-medium">Konsumsi Per Kapita Setahun</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Header -->
            <div class="mb-12">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Konsumsi Pangan Per Kapita Setahun
                </h1>
                <p class="text-xl text-gray-600">
                    Data konsumsi pangan rata-rata per kapita dalam periode setahun berdasarkan agregasi data Susenas
                </p>
            </div>

            <!-- Login Notice -->
            <div class="bg-purple-50 border border-purple-200 rounded-lg p-6 mb-8">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="text-lg font-medium text-purple-900">Akses Data Lengkap</h3>
                        <p class="text-purple-700 mt-1">
                            Untuk mengakses data konsumsi per kapita setahun lengkap, silakan login ke sistem.
                        </p>
                        <a href="{{ route('login') }}" 
                           class="inline-block mt-3 bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 transition duration-200">
                            Login Sekarang
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sample Data -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Contoh Data Konsumsi Setahun (2023)</h2>
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kelompok Pangan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Konsumsi (kg/kap/thn)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Energi (kkal/hari)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Protein (g/hari)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">% AKG Energi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Padi-padian</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">104.1</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">1,042</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">22.4</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-medium">48.6%</td>
                                </tr>
                                <tr class="bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Umbi-umbian</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">4.1</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">18</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">0.4</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">0.8%</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Ikan/Udang/Cumi</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">10.4</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">31</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">5.8</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">1.4%</td>
                                </tr>
                                <tr class="bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Daging</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">2.9</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">21</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">1.7</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">1.0%</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Telur dan Susu</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">4.4</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">22</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">1.2</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">1.0%</td>
                                </tr>
                                <tr class="bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Sayur-sayuran</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">15.6</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">12</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">1.2</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">0.6%</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Buah-buahan</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">12.8</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">28</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">0.7</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">1.3%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="bg-gray-50 px-6 py-3">
                        <p class="text-sm text-gray-600">
                            <em>AKG = Angka Kecukupan Gizi. Data lengkap tersedia setelah login ke sistem.</em>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Key Insights -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                <div class="bg-blue-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-blue-900 mb-4">Kegunaan Data Tahunan</h3>
                    <ul class="text-blue-800 space-y-2">
                        <li>• Perencanaan ketahanan pangan jangka panjang</li>
                        <li>• Monitoring pencapaian target gizi nasional</li>
                        <li>• Evaluasi tren konsumsi multi-tahun</li>
                        <li>• Benchmarking dengan standar internasional</li>
                        <li>• Basis perhitungan proyeksi kebutuhan pangan</li>
                    </ul>
                </div>
                <div class="bg-green-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-green-900 mb-4">Indikator Utama (2023)</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-green-800">Total Energi:</span>
                            <span class="font-semibold text-green-900">2,147 kkal/hari</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-green-800">Total Protein:</span>
                            <span class="font-semibold text-green-900">57.2 g/hari</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-green-800">% AKG Energi:</span>
                            <span class="font-semibold text-green-900">95.4%</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-green-800">% AKG Protein:</span>
                            <span class="font-semibold text-green-900">102.1%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trend Analysis -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Tren Konsumsi (2018-2023)</h2>
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">Konsumsi Energi</h4>
                            <div class="text-3xl font-bold text-blue-600 mb-1">+2.3%</div>
                            <p class="text-sm text-gray-600">Pertumbuhan per tahun</p>
                        </div>
                        <div class="text-center">
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">Konsumsi Protein</h4>
                            <div class="text-3xl font-bold text-green-600 mb-1">+3.1%</div>
                            <p class="text-sm text-gray-600">Pertumbuhan per tahun</p>
                        </div>
                        <div class="text-center">
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">Diversifikasi Pangan</h4>
                            <div class="text-3xl font-bold text-purple-600 mb-1">85.2</div>
                            <p class="text-sm text-gray-600">Skor PPH (2023)</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Links -->
            <div class="bg-gray-50 p-6 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Halaman Terkait</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('konsumsi.per-kapita-seminggu') }}" class="block p-4 bg-white rounded border hover:shadow-md transition duration-200">
                        <h4 class="font-medium text-blue-600">Per Kapita Seminggu</h4>
                        <p class="text-sm text-gray-600 mt-1">Data konsumsi mingguan</p>
                    </a>
                    <a href="{{ route('ketersediaan.laporan-nbm') }}" class="block p-4 bg-white rounded border hover:shadow-md transition duration-200">
                        <h4 class="font-medium text-blue-600">Data Ketersediaan</h4>
                        <p class="text-sm text-gray-600 mt-1">Bandingkan dengan data NBM</p>
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
