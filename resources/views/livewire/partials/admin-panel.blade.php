<!-- Admin Panel Content -->
<div>
    <!-- Quick Navigation -->
    <div class="mb-6">
        <div class="bg-white dark:!bg-neutral-800 overflow-hidden shadow rounded-lg border border-neutral-200 dark:border-neutral-700">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-neutral-900 dark:text-white mb-4">
                    Menu Susenas
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Kelompok BPS -->
                    <a href="{{ route('admin.kelompok-bps') }}" class="group block p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-700 hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-blue-900 dark:text-blue-100 group-hover:text-blue-900">
                                    Kelompok BPS
                                </p>
                                <p class="text-sm text-blue-700 dark:text-blue-300">
                                    {{ $totalKelompokbps ?? 0 }} kelompok
                                </p>
                            </div>
                        </div>
                    </a>

                    <!-- Komoditi BPS -->
                    <a href="{{ route('admin.komoditi-bps') }}" class="group block p-4 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-700 hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-900 dark:text-green-100 group-hover:text-green-900">
                                    Komoditi BPS
                                </p>
                                <p class="text-sm text-green-700 dark:text-green-300">
                                    {{ $totalKomoditibps ?? 0 }} komoditi
                                </p>
                            </div>
                        </div>
                    </a>

                    <!-- Data Susenas -->
                    <a href="{{ route('admin.susenas') }}" class="group block p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg border border-purple-200 dark:border-purple-700 hover:bg-purple-100 dark:hover:bg-purple-900/30 transition-colors">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-purple-900 dark:text-purple-100 group-hover:text-purple-900">
                                    Data Susenas
                                </p>
                                <p class="text-sm text-purple-700 dark:text-purple-300">
                                    {{ $totalSusenas ?? 0 }} data
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
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

        <!-- Total Roles -->
    <div class="bg-white dark:!bg-neutral-800 overflow-hidden shadow rounded-lg border border-neutral-200 dark:border-neutral-700 transition-colors">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400 truncate">
                                Total Roles
                            </dt>
                            <dd class="text-lg font-medium text-neutral-900 dark:text-white">
                                {{ $totalRoles }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current User Role -->
    <div class="bg-white dark:!bg-neutral-800 overflow-hidden shadow rounded-lg border border-neutral-200 dark:border-neutral-700 transition-colors">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
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

    <!-- Recent Users -->
    <div class="bg-white dark:!bg-neutral-800 overflow-hidden shadow rounded-lg border border-neutral-200 dark:border-neutral-700 mb-6">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-neutral-900 dark:text-white mb-4">
                User Terbaru
            </h3>
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

    <!-- Recent Susenas Data -->
    @if(isset($recentSusenas))
    <div class="bg-white dark:!bg-neutral-800 overflow-hidden shadow rounded-lg border border-neutral-200 dark:border-neutral-700">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-neutral-900 dark:text-white mb-4">
                Data Susenas Terbaru
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-neutral-500 dark:text-neutral-400">
                    <thead class="text-xs text-neutral-700 uppercase bg-neutral-50 dark:bg-neutral-700 dark:text-neutral-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Tahun</th>
                            <th scope="col" class="px-6 py-3">Kelompok BPS</th>
                            <th scope="col" class="px-6 py-3">Komoditi BPS</th>
                            <th scope="col" class="px-6 py-3">Konsumsi</th>
                            <th scope="col" class="px-6 py-3">Ditambahkan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentSusenas as $susenas)
                        <tr class="bg-white border-b dark:!bg-neutral-800 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:!bg-neutral-700 transition-colors">
                            <td class="px-6 py-4 font-medium text-neutral-900 dark:text-white">
                                {{ $susenas->tahun }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-neutral-900 dark:text-white">
                                    {{ $susenas->kelompokbps->nm_kelompokbps ?? '-' }}
                                </div>
                                <div class="text-xs text-neutral-500">
                                    {{ $susenas->kd_kelompokbps }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-neutral-900 dark:text-white">
                                    {{ $susenas->komoditibps->nm_komoditibps ?? '-' }}
                                </div>
                                <div class="text-xs text-neutral-500">
                                    {{ $susenas->kd_komoditibps }}
                                </div>
                            </td>
                            <td class="px-6 py-4 font-medium text-neutral-900 dark:text-white">
                                {{ number_format($susenas->konsumsi_kuantity, 2) }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $susenas->created_at->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-neutral-500">
                                Belum ada data susenas
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
