<div>
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-neutral-900 dark:text-white">Dashboard Admin</h1>
        <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">
            Selamat datang di panel admin
        </p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Total Users -->
        <div class="bg-white dark:bg-neutral-800 overflow-hidden shadow rounded-lg">
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
        <div class="bg-white dark:bg-neutral-800 overflow-hidden shadow rounded-lg">
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
        <div class="bg-white dark:bg-neutral-800 overflow-hidden shadow rounded-lg">
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
    <div class="bg-white dark:bg-neutral-800 overflow-hidden shadow rounded-lg">
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
                        <tr class="bg-white border-b dark:bg-neutral-800 dark:border-neutral-700">
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
</div>
