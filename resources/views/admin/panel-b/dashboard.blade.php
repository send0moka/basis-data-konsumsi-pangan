<x-layouts.admin>
  <div class="space-y-6">
      <!-- Header -->
      <div class="flex items-center justify-between">
          <div>
              <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Panel Laporan</h1>
              <p class="text-neutral-600 dark:text-neutral-400">Kelola dan generate laporan sistem</p>
          </div>
          <flux:link href="{{ route('admin.panel-selection') }}" variant="ghost" class="text-sm">
              ← Kembali ke Pemilihan Panel
          </flux:link>
      </div>

      <!-- Navigation Cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <!-- Data Reports Card -->
          <flux:card class="hover:shadow-lg transition-shadow">
              <div class="p-6">
                  <div class="flex items-center space-x-4">
                      <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                          <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                          </svg>
                      </div>
                      <div>
                          <h3 class="text-lg font-semibold text-neutral-900 dark:text-white">Data Reports</h3>
                          <p class="text-neutral-600 dark:text-neutral-400">Generate various data reports</p>
                      </div>
                  </div>
                  <div class="mt-4">
                      <flux:link href="{{ route('admin.panel-b.data') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                          Akses Reports →
                      </flux:link>
                  </div>
              </div>
          </flux:card>

          <!-- System Reports Card -->
          <flux:card class="hover:shadow-lg transition-shadow">
              <div class="p-6">
                  <div class="flex items-center space-x-4">
                      <div class="p-3 bg-green-100 dark:bg-green-900 rounded-lg">
                          <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                          </svg>
                      </div>
                      <div>
                          <h3 class="text-lg font-semibold text-neutral-900 dark:text-white">System Reports</h3>
                          <p class="text-neutral-600 dark:text-neutral-400">View system performance reports</p>
                      </div>
                  </div>
                  <div class="mt-4">
                      <flux:link href="{{ route('admin.panel-b.reports') }}" class="text-green-600 hover:text-green-800 font-medium">
                          View Reports →
                      </flux:link>
                  </div>
              </div>
          </flux:card>

          <!-- Quick Stats Card -->
          <flux:card class="hover:shadow-lg transition-shadow">
              <div class="p-6">
                  <div class="flex items-center space-x-4">
                      <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-lg">
                          <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                          </svg>
                      </div>
                      <div>
                          <h3 class="text-lg font-semibold text-neutral-900 dark:text-white">Quick Stats</h3>
                          <p class="text-neutral-600 dark:text-neutral-400">View dashboard statistics</p>
                      </div>
                  </div>
                  <div class="mt-4">
                      <span class="text-purple-600 font-medium">Coming Soon</span>
                  </div>
              </div>
          </flux:card>
      </div>

      <!-- Recent Activity -->
      <flux:card>
          <div class="p-6">
              <h2 class="text-xl font-semibold text-neutral-900 dark:text-white mb-4">Recent Activity</h2>
              <div class="space-y-3">
                  <div class="flex items-center space-x-3 p-3 bg-neutral-50 dark:bg-neutral-800 rounded-lg">
                      <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                      <div>
                          <p class="text-sm font-medium text-neutral-900 dark:text-white">Report generated successfully</p>
                          <p class="text-xs text-neutral-600 dark:text-neutral-400">2 minutes ago</p>
                      </div>
                  </div>
                  <div class="flex items-center space-x-3 p-3 bg-neutral-50 dark:bg-neutral-800 rounded-lg">
                      <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                      <div>
                          <p class="text-sm font-medium text-neutral-900 dark:text-white">Data export completed</p>
                          <p class="text-xs text-neutral-600 dark:text-neutral-400">15 minutes ago</p>
                      </div>
                  </div>
                  <div class="flex items-center space-x-3 p-3 bg-neutral-50 dark:bg-neutral-800 rounded-lg">
                      <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                      <div>
                          <p class="text-sm font-medium text-neutral-900 dark:text-white">System backup in progress</p>
                          <p class="text-xs text-neutral-600 dark:text-neutral-400">1 hour ago</p>
                      </div>
                  </div>
              </div>
          </div>
      </flux:card>
  </div>
</x-layouts.admin>