<template>
  <div>
    <!-- Topbar -->
    <div class="bg-gray-100 text-sm py-2">
      <div
        class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center px-4 text-center md:text-left"
      >
        <p>Free shipping on orders over $25.</p>
        <p class="mt-1 md:mt-0">
          Need help? Call Us:
          <a
            href="tel:888554168"
            class="text-green-600 font-medium hover:underline"
            >+8 88 55 4168</a
          >
        </p>
      </div>
    </div>

    <!-- Navbar -->
    <div class="max-w-7xl mx-auto flex justify-between items-center py-4 px-4">
      <!-- Logo -->
      <Link href="/" class="flex items-center gap-2">
        <img src="/assets/images/logo/logo.png" alt="logo" class="h-10" />
      </Link>

      <!-- Desktop Nav -->
      <nav
        class="hidden md:flex space-x-8 text-gray-700 font-medium"
      >
        <Link href="/" class="hover:text-green-600">Home</Link>
        <Link href="/shop" class="hover:text-green-600">Shop</Link>
        <Link href="/about" class="hover:text-green-600">About</Link>
        <Link href="/contact" class="hover:text-green-600">Contact</Link>
      </nav>

      <!-- Right Side (Icons) -->
      <div class="flex items-center gap-4">
        <button><i class="icon-rt-search text-lg"></i></button>
        <button><i class="icon-rt-user text-lg"></i></button>
        <div class="relative">
          <button>
            <i class="icon-rt-bag2 text-lg"></i>
            <span
              class="absolute -top-2 -right-2 bg-green-600 text-white text-xs w-4 h-4 flex items-center justify-center rounded-full"
              >2</span
            >
          </button>
        </div>

        <!-- Mobile Menu Toggle -->
        <button class="md:hidden" @click="menuOpen = !menuOpen">
          <i class="icon-rt-bars text-xl"></i>
        </button>

      </div>
    </div>

    <!-- Mobile Menu -->
    <transition name="fade">
      <div
        v-if="menuOpen"
        class="md:hidden bg-white border-t border-gray-200"
      >
        <nav class="flex flex-col space-y-3 py-4 px-4 text-gray-700 font-medium">
          <Link href="/" class="hover:text-green-600" @click="menuOpen = false">Home</Link>
          <Link href="/shop" class="hover:text-green-600" @click="menuOpen = false">Shop</Link>
          <Link href="/about" class="hover:text-green-600" @click="menuOpen = false">About</Link>
          <Link href="/contact" class="hover:text-green-600" @click="menuOpen = false">Contact</Link>
        </nav>
      </div>
    </transition>
  </div>
</template>

<script>
import { Link } from '@inertiajs/vue3'

export default {
  name: 'Navbar',
  components: {
    Link
  },
  data() {
    return {
      menuOpen: false
    }
  }
}
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: all 0.2s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
</style>
