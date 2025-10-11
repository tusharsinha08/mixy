<template>
  <header class="border-b border-gray-200">
    <!-- Topbar -->
    <div class="bg-gray-100 text-sm py-2">
      <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center px-4">
        <p>Free shipping on orders over $25.</p>
        <p class="mt-1 md:mt-0">
          Need help? Call Us:
          <a href="tel:888554168" class="text-green-600 font-medium hover:underline">
            +8 88 55 4168
          </a>
        </p>
      </div>
    </div>

    <!-- Main Navbar -->
    <div class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between px-6 py-4 gap-4">
        <!-- Logo -->
        <Link href="/" class="flex items-center gap-2">
        <img src="/assets/images/logo.png" alt="Mixy Logo" class="h-10" />
        </Link>

        <!-- Search Bar -->
        <form @submit.prevent="handleSearch" class="flex-grow max-w-2xl w-full relative">
          <input v-model="searchQuery" type="text" placeholder="Search product..."
            class="w-full px-6 py-3 rounded-full bg-gray-100 text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-600 placeholder-gray-400" />
          <button type="submit"
            class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-green-600">
            <i class="fas fa-search"></i>
          </button>
        </form>

        <!-- Icons -->
        <div class="flex items-center gap-4">
          <button
            class="relative w-10 h-10 flex items-center justify-center rounded-full border border-gray-200 text-gray-700 hover:text-green-600">
            <i class="fas fa-user text-lg"></i>
          </button>

          <button
            class="relative w-10 h-10 flex items-center justify-center rounded-full border border-gray-200 text-gray-700 hover:text-green-600">
            <i class="fas fa-heart text-lg"></i>
            <span
              class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">2</span>
          </button>

          <button
            class="relative w-10 h-10 flex items-center justify-center rounded-full border border-gray-200 text-gray-700 hover:text-green-600">
            <i class="fas fa-shopping-bag text-lg"></i>
            <span
              class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">3</span>
          </button>
        </div>
      </div>

      <!-- Navigation Links -->
      <nav
        class="hidden md:flex justify-center space-x-8 py-3 text-white font-medium border-t bg-emerald-800 border-gray-100">
        <Link href="/" class="hover:text-green-600">Home</Link>
        <Link href="/shop" class="hover:text-green-600">Shop</Link>
        <Link href="/about" class="hover:text-green-600">About</Link>
        <Link href="/contact" class="hover:text-green-600">Contact</Link>
      </nav>
    </div>
  </header>
</template>

<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'

const searchQuery = ref('')

const handleSearch = () => {
  if (searchQuery.value.trim()) {
    console.log('Search for:', searchQuery.value)
  }
}
</script>

<style scoped>
/* Optional custom styling */
</style>
