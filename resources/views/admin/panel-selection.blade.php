<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Basis Data Konsumsi Pangan') }} - Pilih Admin Panel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- @fluxStyles --}}
</head>
<body class="bg-gradient-to-br from-neutral-900 via-neutral-800 to-black min-h-screen">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-6xl">
            <!-- Header -->
            <div class="text-center mb-12">
                <div class="flex items-center justify-between mb-8">
                    <a href="/">
                        <flux:button variant="primary" class="text-white hover:text-red-500">
                            ← Kembali
                        </flux:button>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <flux:button type="submit" variant="primary" class="text-white hover:text-red-500">
                            Keluar
                        </flux:button>
                    </form>
                </div>
                <h1 class="text-white text-4xl font-light mb-4">Pilih Panel Admin</h1>
                <p class="text-neutral-400 text-lg">
            </div>

            <!-- Panel Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6">
                <!-- Panel Konsumsi Pangan -->
                <div class="group cursor-pointer" onclick="window.location.href='/admin/konsumsi-pangan'">
                    <div class="relative rounded-lg overflow-hidden transition-all">
                        <div class="aspect-square bg-gradient-to-br from-blue-600 to-blue-800 p-6 flex flex-col items-center justify-center text-white">
                            <div class="text-4xl mb-4">🍽️</div>
                            <div class="text-center">
                                <h3 class="font-semibold text-lg mb-1">Konsumsi Pangan</h3>
                                <p class="text-sm opacity-80">Data & Analisis</p>
                            </div>
                        </div>
                        <div class="absolute inset-0 bg-opacity-0 group-hover:bg-opacity-20 transition-all">
                            <img src="{{ asset('konsumsi-pangan.jpg') }}" alt="Konsumsi Pangan" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <p class="text-center text-neutral-400 mt-3 group-hover:text-white transition-colors">Konsumsi Pangan</p>
                </div>

                <!-- Panel Lahan -->
                <div class="group cursor-pointer" onclick="window.location.href='/admin/lahan'">
                    <div class="relative rounded-lg overflow-hidden transition-all">
                        <div class="aspect-square bg-gradient-to-br from-green-600 to-green-800 p-6 flex flex-col items-center justify-center text-white">
                            <div class="text-4xl mb-4">🌾</div>
                            <div class="text-center">
                                <h3 class="font-semibold text-lg mb-1">Lahan</h3>
                                <p class="text-sm opacity-80">Data & Analisis</p>
                            </div>
                        </div>
                        <div class="absolute inset-0 bg-opacity-0 group-hover:bg-opacity-20 transition-all">
                            <img src="{{ asset('lahan.jpg') }}" alt="Lahan" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <p class="text-center text-neutral-400 mt-3 group-hover:text-white transition-colors">Lahan</p>
                </div>

                <!-- Panel C -->
                <div class="group cursor-pointer" onclick="window.location.href='{{ route('admin.panel-c.dashboard') }}'">
                    <div class="relative rounded-lg overflow-hidden transition-all">
                        <div class="aspect-square bg-gradient-to-br from-purple-600 to-purple-800 p-6 flex flex-col items-center justify-center text-white">
                            <div class="text-4xl mb-4">📈</div>
                            <div class="text-center">
                                <h3 class="font-semibold text-lg mb-1">Iklim OPT DPI</h3>
                                <p class="text-sm opacity-80">Iklim OPT DPI</p>
                            </div>
                        </div>
                        <div class="absolute inset-0 bg-opacity-0 group-hover:bg-opacity-20 transition-all">
                            <img src="{{ asset('iklim-opt-dpi.jpg') }}" alt="Iklim OPT DPI" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <p class="text-center text-neutral-400 mt-3 group-hover:text-white transition-colors">Iklim OPT DPI</p>
                </div>

                <!-- Panel D -->
                <div class="group cursor-pointer" onclick="window.location.href='{{ route('admin.panel-d.dashboard') }}'">
                    <div class="relative rounded-lg overflow-hidden transition-all">
                        <div class="aspect-square bg-gradient-to-br from-orange-600 to-orange-800 p-6 flex flex-col items-center justify-center text-white">
                            <div class="text-4xl mb-4">🔍</div>
                            <div class="text-center">
                                <h3 class="font-semibold text-lg mb-1">Daftar Alamat</h3>
                                <p class="text-sm opacity-80">Daftar Alamat</p>
                            </div>
                        </div>
                        <div class="absolute inset-0 bg-opacity-0 group-hover:bg-opacity-20 transition-all">
                            <img src="{{ asset('daftar-alamat.jpg') }}" alt="Daftar Alamat" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <p class="text-center text-neutral-400 mt-3 group-hover:text-white transition-colors">Daftar Alamat</p>
                </div>

                <!-- Panel E -->
                <div class="group cursor-pointer" onclick="window.location.href='{{ route('admin.panel-e.dashboard') }}'">
                    <div class="relative rounded-lg overflow-hidden transition-all">
                        <div class="aspect-square bg-gradient-to-br from-red-600 to-red-800 p-6 flex flex-col items-center justify-center text-white">
                            <div class="text-4xl mb-4">⚙️</div>
                            <div class="text-center">
                                <h3 class="font-semibold text-lg mb-1">Benih Pupuk</h3>
                                <p class="text-sm opacity-80">Benih Pupuk</p>
                            </div>
                        </div>
                        <div class="absolute inset-0 bg-opacity-0 group-hover:bg-opacity-20 transition-all">
                            <img src="{{ asset('benih-pupuk.jpg') }}" alt="Benih Pupuk" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <p class="text-center text-neutral-400 mt-3 group-hover:text-white transition-colors">Benih Pupuk</p>
                </div>
            </div>

            <!-- User Info -->
            <div class="text-center mt-12">
                <div class="inline-flex items-center space-x-3 text-neutral-400">
                    <div class="w-8 h-8 bg-neutral-600 rounded-full flex items-center justify-center">
                        <span class="text-sm font-semibold text-white">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>
                    </div>
                    <div class="text-left">
                        <p class="text-white font-medium">{{ auth()->user()->name }}</p>
                        <p class="text-sm text-neutral-400">
                            {{ auth()->user()->roles->first()?->name ?? 'No Role' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom CSS for Netflix-like hover effects -->
    <style>
        @media (min-width: 768px) {
            .group:hover {
                transform: scale(1.1);
                transition: all 0.3s ease;
            }
            
            .group:hover::after {
                content: '';
                position: absolute;
                top: -10px;
                left: -10px;
                right: -10px;
                bottom: -10px;
                background: rgba(0, 0, 0, 0.3);
                border-radius: 12px;
                z-index: -1;
            }
        }
    </style>

    @fluxScripts
</body>
</html>