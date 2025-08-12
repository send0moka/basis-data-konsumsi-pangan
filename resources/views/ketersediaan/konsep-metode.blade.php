<x-layouts.landing>
    <div class="py-12 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
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
                            <span class="ml-1 text-blue-600 font-medium">Konsep dan Metode</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Header -->
            <div class="mb-12">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Konsep dan Metode Ketersediaan Pangan
                </h1>
                <p class="text-xl text-gray-600">
                    Pemahaman konsep dan metodologi dalam penyusunan data ketersediaan pangan melalui Neraca Bahan Makanan (NBM)
                </p>
            </div>

            <!-- Content -->
            <div class="prose prose-lg max-w-none">
                <h2>Pengertian Neraca Bahan Makanan (NBM)</h2>
                <p>
                    Neraca Bahan Makanan (NBM) adalah suatu metode untuk mengukur ketersediaan pangan dari sisi supply dan demand. 
                    NBM menggambarkan posisi keseimbangan antara produksi, impor, ekspor, perubahan stok, dan penggunaan pangan 
                    dalam suatu wilayah dan periode tertentu.
                </p>

                <h2>Komponen NBM</h2>
                <h3>Sisi Penyediaan (Supply)</h3>
                <ul>
                    <li><strong>Produksi:</strong> Hasil produksi dalam negeri dari sektor pertanian, peternakan, perikanan, dan industri pangan</li>
                    <li><strong>Impor:</strong> Masuknya komoditas pangan dari luar negeri</li>
                    <li><strong>Perubahan Stok:</strong> Pengurangan atau penambahan stok komoditas pangan</li>
                </ul>

                <h3>Sisi Penggunaan (Demand)</h3>
                <ul>
                    <li><strong>Ekspor:</strong> Keluarnya komoditas pangan ke luar negeri</li>
                    <li><strong>Pakan:</strong> Penggunaan untuk makanan ternak</li>
                    <li><strong>Bibit:</strong> Penggunaan untuk benih atau bibit tanaman</li>
                    <li><strong>Industri Non-Pangan:</strong> Penggunaan untuk keperluan industri selain makanan</li>
                    <li><strong>Tercecer:</strong> Kehilangan selama proses penanganan, penyimpanan, dan distribusi</li>
                    <li><strong>Makanan:</strong> Konsumsi untuk kebutuhan pangan manusia</li>
                </ul>

                <h2>Rumus Keseimbangan NBM</h2>
                <div class="bg-blue-50 p-6 rounded-lg border-l-4 border-blue-500">
                    <p class="font-mono text-center">
                        <strong>Produksi + Impor ± Perubahan Stok = Ekspor + Pakan + Bibit + Industri + Tercecer + Makanan</strong>
                    </p>
                </div>

                <h2>Metodologi Penyusunan</h2>
                <ol>
                    <li><strong>Pengumpulan Data:</strong> Data diperoleh dari berbagai sumber seperti BPS, Kementerian Pertanian, dan instansi terkait</li>
                    <li><strong>Klasifikasi Komoditas:</strong> Pengelompokan komoditas berdasarkan jenis dan karakteristiknya</li>
                    <li><strong>Konversi Satuan:</strong> Penyeragaman satuan ke dalam ton atau kilogram</li>
                    <li><strong>Perhitungan Keseimbangan:</strong> Aplikasi rumus keseimbangan NBM</li>
                    <li><strong>Validasi Data:</strong> Pengecekan konsistensi dan kewajaran data</li>
                </ol>

                <h2>Periode dan Cakupan</h2>
                <ul>
                    <li><strong>Periode:</strong> Data disusun dalam periode tahunan</li>
                    <li><strong>Cakupan Wilayah:</strong> Nasional dan provinsi</li>
                    <li><strong>Jenis Komoditas:</strong> Meliputi 10 kelompok pangan utama dengan lebih dari 200 jenis komoditas</li>
                </ul>

                <h2>Kegunaan Data NBM</h2>
                <ul>
                    <li>Perencanaan ketahanan pangan nasional</li>
                    <li>Monitoring ketersediaan pangan</li>
                    <li>Evaluasi kebijakan pangan</li>
                    <li>Penelitian dan analisis pangan</li>
                    <li>Pelaporan internasional (FAO, dll.)</li>
                </ul>

                <h2>Sumber Data</h2>
                <ul>
                    <li>Badan Pusat Statistik (BPS)</li>
                    <li>Kementerian Pertanian</li>
                    <li>Kementerian Kelautan dan Perikanan</li>
                    <li>Kementerian Perindustrian</li>
                    <li>Badan Ketahanan Pangan</li>
                    <li>Gabungan Pengusaha Makanan dan Minuman Indonesia (GAPMMI)</li>
                </ul>
            </div>

            <!-- Related Links -->
            <div class="mt-12 bg-gray-50 p-6 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Halaman Terkait</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('ketersediaan.laporan-nbm') }}" 
                       class="block p-4 bg-white rounded border hover:shadow-md transition duration-200">
                        <h4 class="font-medium text-blue-600">Laporan Data NBM</h4>
                        <p class="text-sm text-gray-600 mt-1">Akses data dan laporan Neraca Bahan Makanan terbaru</p>
                    </a>
                    <a href="{{ route('login') }}" 
                       class="block p-4 bg-white rounded border hover:shadow-md transition duration-200">
                        <h4 class="font-medium text-blue-600">Manajemen Data</h4>
                        <p class="text-sm text-gray-600 mt-1">Login untuk mengakses dan mengelola data NBM</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.landing>
