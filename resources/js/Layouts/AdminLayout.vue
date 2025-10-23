<template>
  <div class="flex h-screen bg-gray-100 ">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md hidden md:block">
      <div class="p-4 font-bold text-lg border-b">Admin Panel</div>

      <nav class="p-4 space-y-2">

        <Link href="/admin/dashboard" class="block py-2 px-3 rounded hover:bg-gray-200">
        Dashboard
        </Link>
        <!-- 🏠 Home Link -->
        <Link href="/admin/header-settings" class="block py-2 px-3 rounded hover:bg-gray-200">
        Header Settings
        </Link>
        <Link href="/admin/home-settings" class="block py-2 px-3 rounded hover:bg-gray-200">
        Home Settings
        </Link>

        <Link href="/admin/products" class="block py-2 px-3 rounded hover:bg-gray-200">
        Products
        </Link>
        <Link href="/admin/about-us" class="block py-2 px-3 rounded hover:bg-gray-200">
        About Us
        </Link>
        <Link href="/admin/contact-us" class="block py-2 px-3 rounded hover:bg-gray-200">
        Contact Us
        </Link>
      </nav>
    </aside>

    <!-- Main Content -->
     <div class="flex-1 flex flex-col overflow-y-auto">
      <!-- Header -->
      <header class="bg-white shadow-md p-4 flex justify-between items-center sticky top-0 z-10">
        <h1 class="font-semibold text-lg">Admin Dashboard</h1>
        <div class="flex items-center space-x-4">
          <span class="text-sm text-gray-600">Hello, Admin</span>
        </div>
      </header>

      <!-- Page Content -->
      <main class="py-6">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <slot />
      </div>
    </main>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'


</script>
