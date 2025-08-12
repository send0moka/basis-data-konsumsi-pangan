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
                            <span class="ml-1 text-gray-500">Konsumsi</span>
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
                    Konsep dan Metode Konsumsi Pangan
                </h1>
                <p class="text-xl text-gray-600">
                    Pemahaman konsep dan metodologi pengumpulan data konsumsi pangan melalui Survei Sosial Ekonomi Nasional (Susenas)
                </p>
            </div>

            <!-- Content -->
            <div class="prose prose-lg max-w-none">
                <h2>Pengertian Susenas Konsumsi</h2>
                <p>
                    Survei Sosial Ekonomi Nasional (Susenas) Konsumsi adalah survei yang dilakukan oleh Badan Pusat Statistik (BPS) 
                    untuk mengumpulkan data konsumsi pangan dan non-pangan rumah tangga di Indonesia. Data ini digunakan untuk 
                    mengukur tingkat konsumsi dan pola makan masyarakat Indonesia.
                </p>

                <h2>Tujuan Susenas Konsumsi</h2>
                <ul>
                    <li>Menyediakan data konsumsi pangan untuk perhitungan tingkat ketahanan pangan</li>
                    <li>Mengukur kecukupan gizi masyarakat Indonesia</li>
                    <li>Menyediakan data untuk perencanaan program pangan dan gizi</li>
                    <li>Monitoring pencapaian target Sustainable Development Goals (SDGs)</li>
                    <li>Evaluasi efektivitas program pembangunan pangan</li>
                </ul>

                <h2>Metodologi Pengumpulan Data</h2>
                <h3>Desain Survei</h3>
                <ul>
                    <li><strong>Jenis Survei:</strong> Survei sampel dengan desain two-stage stratified sampling</li>
                    <li><strong>Unit Observasi:</strong> Rumah tangga</li>
                    <li><strong>Unit Sampling:</strong> Blok sensus</li>
                    <li><strong>Periode Referensi:</strong> Seminggu yang lalu (7 hari)</li>
                </ul>

                <h3>Cakupan Wilayah dan Waktu</h3>
                <ul>
                    <li><strong>Cakupan Wilayah:</strong> Seluruh Indonesia (34 provinsi)</li>
                    <li><strong>Klasifikasi Daerah:</strong> Perkotaan dan perdesaan</li>
                    <li><strong>Frekuensi:</strong> Triwulanan (Maret, Juni, September, Desember)</li>
                    <li><strong>Periode Data:</strong> Tersedia mulai tahun 1993</li>
                </ul>

                <h2>Jenis Data yang Dikumpulkan</h2>
                <h3>Data Konsumsi Pangan</h3>
                <ul>
                    <li><strong>Konsumsi Kalori:</strong> Jumlah energi yang dikonsumsi per kapita per hari</li>
                    <li><strong>Konsumsi Protein:</strong> Jumlah protein yang dikonsumsi per kapita per hari</li>
                    <li><strong>Konsumsi per Komoditas:</strong> Kuantitas konsumsi untuk setiap jenis pangan</li>
                    <li><strong>Pengeluaran Pangan:</strong> Nilai pengeluaran rumah tangga untuk konsumsi pangan</li>
                </ul>

                <h3>Kelompok Pangan yang Diamati</h3>
                <div class="bg-blue-50 p-6 rounded-lg">
                    <ol>
                        <li>Padi-padian (beras, jagung, terigu, dll.)</li>
                        <li>Umbi-umbian (ubi kayu, ubi jalar, kentang, dll.)</li>
                        <li>Ikan/udang/cumi/kerang</li>
                        <li>Daging</li>
                        <li>Telur dan susu</li>
                        <li>Sayur-sayuran</li>
                        <li>Kacang-kacangan</li>
                        <li>Buah-buahan</li>
                        <li>Minyak dan lemak</li>
                        <li>Bahan minuman</li>
                        <li>Bumbu-bumbuan</li>
                        <li>Konsumsi lainnya</li>
                        <li>Makanan dan minuman jadi</li>
                        <li>Tembakau dan sirih</li>
                    </ol>
                </div>

                <h2>Metode Pengukuran Konsumsi</h2>
                <h3>Pendekatan Kuantitas</h3>
                <ul>
                    <li><strong>Satuan:</strong> Gram, kilogram, liter, dll.</li>
                    <li><strong>Konversi:</strong> Penyeragaman ke dalam gram per kapita per hari</li>
                    <li><strong>Recall Period:</strong> Konsumsi dalam 7 hari terakhir</li>
                </ul>

                <h3>Konversi ke Nilai Gizi</h3>
                <ul>
                    <li><strong>Tabel Komposisi Pangan Indonesia (TKPI)</strong></li>
                    <li><strong>Konversi Energi:</strong> Kkal per 100 gram bahan pangan</li>
                    <li><strong>Konversi Protein:</strong> Gram protein per 100 gram bahan pangan</li>
                </ul>

                <h2>Indikator Utama</h2>
                <h3>Konsumsi Energi</h3>
                <ul>
                    <li><strong>Konsumsi Energi per Kapita:</strong> Kkal/kapita/hari</li>
                    <li><strong>Tingkat Kecukupan Energi:</strong> Persentase terhadap Angka Kecukupan Gizi (AKG)</li>
                    <li><strong>Prevalensi Kurang Energi:</strong> Persentase penduduk dengan konsumsi < 70% AKG</li>
                </ul>

                <h3>Konsumsi Protein</h3>
                <ul>
                    <li><strong>Konsumsi Protein per Kapita:</strong> Gram/kapita/hari</li>
                    <li><strong>Tingkat Kecukupan Protein:</strong> Persentase terhadap AKG</li>
                    <li><strong>Prevalensi Kurang Protein:</strong> Persentase penduduk dengan konsumsi < 80% AKG</li>
                </ul>

                <h2>Pengolahan dan Analisis Data</h2>
                <ol>
                    <li><strong>Cleaning Data:</strong> Pemeriksaan konsistensi dan outlier</li>
                    <li><strong>Konversi Satuan:</strong> Penyeragaman ke gram per kapita per hari</li>
                    <li><strong>Konversi Gizi:</strong> Menggunakan TKPI untuk mendapat nilai kalori dan protein</li>
                    <li><strong>Agregasi:</strong> Penghitungan rata-rata nasional, provinsi, dan kelompok sosek</li>
                    <li><strong>Validasi:</strong> Pengecekan dengan sumber data lain</li>
                </ol>

                <h2>Kegunaan Data Susenas Konsumsi</h2>
                <ul>
                    <li>Penyusunan peta ketahanan dan kerentanan pangan</li>
                    <li>Monitoring pencapaian target konsumsi energi dan protein</li>
                    <li>Evaluasi program fortifikasi pangan</li>
                    <li>Perencanaan program diversifikasi konsumsi pangan</li>
                    <li>Penelitian pola konsumsi dan gizi masyarakat</li>
                    <li>Pelaporan indikator gizi nasional dan internasional</li>
                </ul>

                <h2>Keterbatasan Data</h2>
                <ul>
                    <li>Data konsumsi di luar rumah tangga belum tercakup secara detail</li>
                    <li>Recall bias pada pengisian kuesioner</li>
                    <li>Seasonal variation belum dapat ditangkap dengan baik</li>
                    <li>Data mikronutrien masih terbatas</li>
                </ul>
            </div>

            <!-- Related Links -->
            <div class="mt-12 bg-gray-50 p-6 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Halaman Terkait</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('konsumsi.laporan-susenas') }}" 
                       class="block p-4 bg-white rounded border hover:shadow-md transition duration-200">
                        <h4 class="font-medium text-blue-600">Laporan Data Susenas</h4>
                        <p class="text-sm text-gray-600 mt-1">Akses data dan laporan konsumsi pangan dari Susenas</p>
                    </a>
                    <a href="{{ route('konsumsi.per-kapita-seminggu') }}" 
                       class="block p-4 bg-white rounded border hover:shadow-md transition duration-200">
                        <h4 class="font-medium text-blue-600">Konsumsi Per Kapita Seminggu</h4>
                        <p class="text-sm text-gray-600 mt-1">Data konsumsi pangan per kapita dalam periode seminggu</p>
                    </a>
                    <a href="{{ route('konsumsi.per-kapita-setahun') }}" 
                       class="block p-4 bg-white rounded border hover:shadow-md transition duration-200">
                        <h4 class="font-medium text-blue-600">Konsumsi Per Kapita Setahun</h4>
                        <p class="text-sm text-gray-600 mt-1">Data konsumsi pangan per kapita dalam periode setahun</p>
                    </a>
                    <a href="{{ route('login') }}" 
                       class="block p-4 bg-white rounded border hover:shadow-md transition duration-200">
                        <h4 class="font-medium text-blue-600">Manajemen Data</h4>
                        <p class="text-sm text-gray-600 mt-1">Login untuk mengakses dan mengelola data konsumsi</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.landing>
