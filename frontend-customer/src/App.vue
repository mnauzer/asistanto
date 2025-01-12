<!-- App.vue -->
<template>
  <div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <div class="w-64 bg-slate-800 hidden md:block">
      <div class="flex flex-col h-full">
        <!-- Logo -->
        <div class="flex items-center justify-between px-4 py-4">
          <div class="flex items-center">
            <img src="logo.svg" width="32" height="32" alt="Logo">
            <span class="text-sm font-semibold text-white ml-3">Mosaic</span>
          </div>
        </div>

        <!-- Sidebar Navigation -->
        <nav class="px-3 py-4 space-y-1">
          <router-link to="/"
            class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-white bg-slate-900 group">
            <svg class="w-5 h-5 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Dashboard
          </router-link>
          <!-- Ďalšie menu položky -->
        </nav>
      </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
      <!-- Top Header -->
      <header class="bg-white border-b border-slate-200">
        <div class="px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between h-16">
            <!-- Mobile menu button -->
            <button class="md:hidden text-slate-500 hover:text-slate-600">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
              </svg>
            </button>

            <!-- Search -->
            <div class="flex-1 px-4 flex justify-center lg:justify-end">
              <div class="w-full max-w-lg lg:max-w-xs">
                <label for="search" class="sr-only">Search</label>
                <div class="relative">
                  <input id="search"
                         class="block w-full bg-white border border-slate-300 rounded-md py-2 pl-10 pr-3 text-sm placeholder-slate-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                         placeholder="Search..."
                         type="search">
                </div>
              </div>
            </div>

            <!-- Right section -->
            <div class="flex items-center gap-3">
              <button class="p-2 text-slate-400 hover:text-slate-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
              </button>

              <button class="flex items-center gap-2">
                <img class="h-8 w-8 rounded-full" src="avatar.jpg" alt="User avatar">
                <span class="text-sm font-medium text-slate-700">Tom Cook</span>
              </button>
            </div>
          </div>
        </div>
      </header>

      <!-- Main Content Area -->
      <main class="flex-1 overflow-y-auto bg-slate-50">
        <div class="py-6">
          <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Banner -->
            <div class="bg-white rounded-lg shadow p-4 sm:p-6">
              <div class="flex items-center justify-between">
                <div>
                  <h2 class="text-lg font-semibold text-slate-900">Good afternoon, Tom 👋</h2>
                  <p class="text-sm text-slate-500">Here's what's happening with your projects today:</p>
                </div>
                <div>
                  <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                    Add View
                  </button>
                </div>
              </div>
            </div>

            <!-- Stats Grid -->
            <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
              <!-- Stat Card -->
              <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                  <div class="flex-shrink-0">
                    <span class="text-2xl sm:text-3xl font-bold text-slate-900">$24,780</span>
                    <h3 class="text-sm font-medium text-slate-500 truncate">Total Revenue</h3>
                  </div>
                  <div class="ml-5 w-0 flex-1">
                    <dl>
                      <dd>
                        <div class="text-sm font-medium text-green-500">+2.5%</div>
                      </dd>
                    </dl>
                  </div>
                </div>
              </div>
              <!-- Ďalšie stat karty -->
            </div>

            <!-- Charts Grid -->
            <div class="mt-8 grid grid-cols-1 gap-4 lg:grid-cols-2">
              <!-- Chart Card -->
              <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center justify-between mb-4">
                  <h3 class="text-lg font-medium text-slate-900">Performance Over Time</h3>
                </div>
                <!-- Tu príde chart component -->
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>
