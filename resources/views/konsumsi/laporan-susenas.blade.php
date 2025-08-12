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
                            <span class="ml-1 text-blue-600 font-medium">Laporan Data Susenas</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Header -->
            <div class="mb-12">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Laporan Data Susenas Konsumsi
                </h1>
                <p class="text-xl text-gray-600">
                    Data konsumsi pangan rumah tangga dari Survei Sosial Ekonomi Nasional (Susenas)
                </p>
            </div>

            <!-- Login Notice -->
            <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-8">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="text-lg font-medium text-green-900">Akses Data Lengkap</h3>
                        <p class="text-green-700 mt-1">
                            Untuk mengakses data Susenas konsumsi lengkap, silakan login ke sistem manajemen data.
                        </p>
                        <a href="{{ route('login') }}" 
                           class="inline-block mt-3 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition duration-200">
                            Login Sekarang
                        </a>
                    </div>
                </div>
            </div>

            <!-- Data Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-6 rounded-lg">
                    <h3 class="text-lg font-semibold mb-2">Periode Survei</h3>
                    <p class="text-3xl font-bold">Triwulanan</p>
                    <p class="text-green-100 text-sm">Mar, Jun, Sep, Des</p>
                </div>
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-lg">
                    <h3 class="text-lg font-semibold mb-2">Cakupan Wilayah</h3>
                    <p class="text-3xl font-bold">34</p>
                    <p class="text-blue-100 text-sm">Provinsi di Indonesia</p>
                </div>
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white p-6 rounded-lg">
                    <h3 class="text-lg font-semibold mb-2">Kelompok Pangan</h3>
                    <p class="text-3xl font-bold">14</p>
                    <p class="text-purple-100 text-sm">Kelompok konsumsi</p>
                </div>
            </div>

            <!-- Sample Data -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Contoh Data Konsumsi (2023)</h2>
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kelompok Pangan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Konsumsi (g/kap/hari)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Energi (kkal)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Protein (g)</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Padi-padian</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">285.2</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">1,042</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">22.4</td>
                                </tr>
                                <tr class="bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Sayur-sayuran</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">42.8</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">12</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">1.2</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Ikan/Udang/Cumi</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">28.6</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">31</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">5.8</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Related Links -->
            <div class="bg-gray-50 p-6 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Halaman Terkait</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('konsumsi.konsep-metode') }}" class="block p-4 bg-white rounded border hover:shadow-md transition duration-200">
                        <h4 class="font-medium text-blue-600">Konsep dan Metode</h4>
                        <p class="text-sm text-gray-600 mt-1">Metodologi Susenas konsumsi</p>
                    </a>
                    <a href="{{ route('konsumsi.per-kapita-seminggu') }}" class="block p-4 bg-white rounded border hover:shadow-md transition duration-200">
                        <h4 class="font-medium text-blue-600">Per Kapita Seminggu</h4>
                        <p class="text-sm text-gray-600 mt-1">Data konsumsi mingguan</p>
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
