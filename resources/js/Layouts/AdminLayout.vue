<template>
  <div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md hidden md:block">
      <div class="p-4 font-bold text-lg border-b">Admin Panel</div>

      <nav class="p-4 space-y-2">

        <Link
          href="/admin-dashboard"
          class="block py-2 px-3 rounded hover:bg-gray-200"
        >
          Dashboard
        </Link>
         <!-- 🏠 Home Link -->
      <Link
  href="/admin/home-settings"
  class="block py-2 px-3 rounded hover:bg-gray-200"
>
  Home Settings
</Link>

        <Link
          href="/products"
          class="block py-2 px-3 rounded hover:bg-gray-200"
        >
          Products
        </Link>
        <Link
          href="/orders"
          class="block py-2 px-3 rounded hover:bg-gray-200"
        >
          Orders
        </Link>
        <Link
          href="/users"
          class="block py-2 px-3 rounded hover:bg-gray-200"
        >
          Users
        </Link>
      </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
      <!-- Header -->
      <header class="bg-white shadow-md p-4 flex justify-between items-center">
        <h1 class="font-semibold text-lg">Admin Dashboard</h1>
        <div class="flex items-center space-x-4">
          <span class="text-sm text-gray-600">Hello, Admin</span>
        </div>
      </header>

      <!-- Page Content -->
      <main class="flex-1 overflow-y-auto p-6">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'


</script>
