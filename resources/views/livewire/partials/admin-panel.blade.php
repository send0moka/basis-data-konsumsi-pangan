<!-- Admin Panel Content -->
<div>
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Total Users -->
    <div class="bg-white dark:!bg-neutral-800 overflow-hidden shadow rounded-lg border border-neutral-200 dark:border-neutral-700 transition-colors">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400 truncate">
                                Total Users
                            </dt>
                            <dd class="text-lg font-medium text-neutral-900 dark:text-white">
                                {{ $totalUsers }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Kelompok -->
    <div class="bg-white dark:!bg-neutral-800 overflow-hidden shadow rounded-lg border border-neutral-200 dark:border-neutral-700 transition-colors">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400 truncate">
                                Total Kelompok
                            </dt>
                            <dd class="text-lg font-medium text-neutral-900 dark:text-white">
                                {{ $totalKelompok ?? 0 }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Komoditi -->
    <div class="bg-white dark:!bg-neutral-800 overflow-hidden shadow rounded-lg border border-neutral-200 dark:border-neutral-700 transition-colors">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-orange-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400 truncate">
                                Total Komoditi
                            </dt>
                            <dd class="text-lg font-medium text-neutral-900 dark:text-white">
                                {{ $totalKomoditi ?? 0 }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Roles -->
    <div class="bg-white dark:!bg-neutral-800 overflow-hidden shadow rounded-lg border border-neutral-200 dark:border-neutral-700 transition-colors">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400 truncate">
                                Role Anda
                            </dt>
                            <dd class="text-lg font-medium text-neutral-900 dark:text-white">
                                {{ ucfirst(auth()->user()->roles->first()?->name ?? 'No Role') }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(auth()->user()->hasRole('superadmin'))
        <!-- Data Tables Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Recent Kelompok -->
            <div class="bg-white dark:!bg-neutral-800 overflow-hidden shadow rounded-lg border border-neutral-200 dark:border-neutral-700">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg leading-6 font-medium text-neutral-900 dark:text-white">
                            Kelompok Terbaru
                        </h3>
                        <a href="{{ route('admin.kelompok') }}" class="text-blue-600 hover:text-blue-500 text-sm font-medium" wire:navigate>
                            Lihat Semua
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-neutral-500 dark:text-neutral-400">
                            <thead class="text-xs text-neutral-700 uppercase bg-neutral-50 dark:bg-neutral-700 dark:text-neutral-400">
                                <tr>
                                    <th scope="col" class="px-4 py-2">Kode</th>
                                    <th scope="col" class="px-4 py-2">Nama</th>
                                    <th scope="col" class="px-4 py-2">Dibuat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentKelompok ?? [] as $kelompok)
                                <tr class="bg-white border-b dark:!bg-neutral-800 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:!bg-neutral-700 transition-colors">
                                    <td class="px-4 py-2 font-medium text-neutral-900 dark:text-white">
                                        {{ $kelompok->kode }}
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ $kelompok->nama }}
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ $kelompok->created_at->format('d/m/Y') }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-4 text-center text-neutral-500">
                                        Belum ada kelompok
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Recent Komoditi -->
            <div class="bg-white dark:!bg-neutral-800 overflow-hidden shadow rounded-lg border border-neutral-200 dark:border-neutral-700">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg leading-6 font-medium text-neutral-900 dark:text-white">
                            Komoditi Terbaru
                        </h3>
                        <a href="{{ route('admin.komoditi') }}" class="text-blue-600 hover:text-blue-500 text-sm font-medium" wire:navigate>
                            Lihat Semua
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-neutral-500 dark:text-neutral-400">
                            <thead class="text-xs text-neutral-700 uppercase bg-neutral-50 dark:bg-neutral-700 dark:text-neutral-400">
                                <tr>
                                    <th scope="col" class="px-4 py-2">Kelompok</th>
                                    <th scope="col" class="px-4 py-2">Kode</th>
                                    <th scope="col" class="px-4 py-2">Nama</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentKomoditi ?? [] as $komoditi)
                                <tr class="bg-white border-b dark:!bg-neutral-800 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:!bg-neutral-700 transition-colors">
                                    <td class="px-4 py-2 font-medium text-neutral-900 dark:text-white">
                                        {{ $komoditi->kode_kelompok }}
                                    </td>
                                    <td class="px-4 py-2 font-medium text-neutral-900 dark:text-white">
                                        {{ $komoditi->kode_komoditi }}
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ $komoditi->nama }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-4 text-center text-neutral-500">
                                        Belum ada komoditi
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Users (Only for Superadmin) -->
        <div class="bg-white dark:!bg-neutral-800 overflow-hidden shadow rounded-lg border border-neutral-200 dark:border-neutral-700">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg leading-6 font-medium text-neutral-900 dark:text-white">
                        User Terbaru
                    </h3>
                    <a href="{{ route('admin.users') }}" class="text-blue-600 hover:text-blue-500 text-sm font-medium" wire:navigate>
                        Lihat Semua
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-neutral-500 dark:text-neutral-400">
                        <thead class="text-xs text-neutral-700 uppercase bg-neutral-50 dark:bg-neutral-700 dark:text-neutral-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Nama</th>
                                <th scope="col" class="px-6 py-3">Email</th>
                                <th scope="col" class="px-6 py-3">Role</th>
                                <th scope="col" class="px-6 py-3">Bergabung</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentUsers as $user)
                            <tr class="bg-white border-b dark:!bg-neutral-800 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:!bg-neutral-700 transition-colors">
                                <td class="px-6 py-4 font-medium text-neutral-900 dark:text-white">
                                    {{ $user->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $user->email }}
                                </td>
                                <td class="px-6 py-4">
                                    @foreach($user->roles as $role)
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                            {{ ucfirst($role->name) }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4">
                                    {{ $user->created_at->format('d/m/Y H:i') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-neutral-500">
                                    Belum ada user
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
