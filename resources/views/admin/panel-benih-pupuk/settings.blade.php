@extends('layouts.benih-pupuk')

@section('header')
    <h2 class="font-semibold text-xl text-neutral-800 dark:text-neutral-200">
        {{ __('Pengaturan Benih & Pupuk') }}
    </h2>
    <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">
        Kelola pengaturan modul Benih & Pupuk
    </p>
@endsection

@section('content')
<div class="py-6">
    <div class="max-w-3xl mx-auto">
        <div class="space-y-6">
            <!-- General Settings -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-medium">Pengaturan Umum</h3>
                </div>
                <div class="card-body space-y-4">
                    <div>
                        <label class="form-label">Nama Modul</label>
                        <input type="text" class="form-input" value="Benih & Pupuk" disabled>
                    </div>
                    <div>
                        <label class="form-label">Status Modul</label>
                        <div class="mt-1">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Aktif</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Notifikasi Stok Minimum</label>
                        <input type="number" class="form-input w-32" value="10">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Kirim notifikasi saat stok di bawah jumlah ini</p>
                    </div>
                </div>
            </div>

            <!-- Unit Settings -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-medium">Satuan & Kategori</h3>
                </div>
                <div class="card-body space-y-4">
                    <div>
                        <label class="form-label">Satuan Stok Default</label>
                        <select class="form-select">
                            <option>Kilogram (kg)</option>
                            <option>Gram (g)</option>
                            <option>Ton</option>
                            <option>Kantong</option>
                            <option>Karung</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Kategori Benih</label>
                        <div class="mt-2 space-y-2">
                            <div class="flex items-center space-x-2">
                                <input type="text" class="form-input flex-1" value="Padi">
                                <button type="button" class="btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <div class="flex items-center space-x-2">
                                <input type="text" class="form-input flex-1" value="Jagung">
                                <button type="button" class="btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <div class="flex items-center space-x-2">
                                <input type="text" class="form-input flex-1" placeholder="Tambah kategori baru">
                                <button type="button" class="btn btn-primary">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Backup & Export -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-medium">Cadangan & Ekspor</h3>
                </div>
                <div class="card-body space-y-4">
                    <div>
                        <label class="form-label">Cadangan Data</label>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Buat cadangan data benih dan pupuk</p>
                        <button type="button" class="btn btn-outline">
                            <i class="fas fa-database mr-2"></i>Buat Cadangan
                        </button>
                    </div>
                    <div>
                        <label class="form-label">Ekspor Data</label>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Ekspor data ke format yang didukung</p>
                        <div class="flex space-x-2">
                            <button type="button" class="btn btn-outline">
                                <i class="fas fa-file-excel mr-2"></i>Excel
                            </button>
                            <button type="button" class="btn btn-outline">
                                <i class="fas fa-file-pdf mr-2"></i>PDF
                            </button>
                            <button type="button" class="btn btn-outline">
                                <i class="fas fa-file-csv mr-2"></i>CSV
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="card border-red-500">
                <div class="card-header bg-red-50 dark:bg-red-900/20 border-b border-red-200 dark:border-red-800">
                    <h3 class="text-lg font-medium text-red-700 dark:text-red-400">Zona Berbahaya</h3>
                </div>
                <div class="card-body">
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-medium text-gray-900 dark:text-white">Hapus Data Uji Coba</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Hapus semua data uji coba yang sudah tidak digunakan</p>
                            <button type="button" class="mt-2 btn btn-danger">
                                <i class="fas fa-trash mr-2"></i>Hapus Data Uji Coba
                            </button>
                        </div>
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                            <h4 class="font-medium text-red-700 dark:text-red-400">Reset Semua Data</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Tindakan ini akan menghapus semua data benih dan pupuk. Tindakan ini tidak dapat dibatalkan.</p>
                            <button type="button" class="btn btn-danger" onclick="if(confirm('Apakah Anda yakin ingin mereset semua data? Tindakan ini tidak dapat dibatalkan.')) { /* Reset action */ }">
                                <i class="fas fa-exclamation-triangle mr-2"></i>Reset Semua Data
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="flex justify-end">
                <button type="button" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Initialize any settings page specific scripts here
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Settings page loaded');
    });
</script>
@endpush
@endsection
