<template>
  <header class="border-b border-gray-200">
    <!-- Topbar -->
    <div class="bg-gray-100 text-sm py-2">
      <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center px-4">
        <p v-html="topbarText"></p>
        <p class="mt-1 md:mt-0">
          {{ topbarHelpText }}
          <a :href="`tel:${topbarPhoneRaw}`" class="text-green-600 font-medium hover:underline">
            {{ topbarPhoneDisplay }}
          </a>
        </p>
      </div>
    </div>

    <!-- Main Navbar -->
    <div class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between px-6 py-4 gap-4">
        <!-- Logo -->
        <Link :href="logoUrl" class="flex items-center gap-2">
        <img :src="logoSrc" alt="Logo" class="h-10" />
        </Link>

        <!-- Search Bar -->
        <form @submit.prevent="handleSearch" class="flex-grow max-w-2xl w-full relative">
          <input v-model="searchQuery" type="text" :placeholder="searchPlaceholder"
            class="w-full px-6 py-3 rounded-full bg-gray-100 text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-600 placeholder-gray-400" />
          <button type="submit"
            class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-green-600">
            <i :class="icons.search || 'fas fa-search'"></i>
          </button>
        </form>

        <!-- Icons -->
        <div class="flex items-center gap-4">

          <Dropdown align="right" width="48">
            <template #trigger>
              <span class="inline-flex rounded-md">
                <button type="button"
                  class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none">
                  <button
                    class="relative w-10 h-10 flex items-center justify-center rounded-full border border-gray-200 text-gray-700 hover:text-green-600">
                    <i :class="icons.user || 'fas fa-user'"></i>
                  </button>
                </button>
              </span>
            </template>

            <template #content>
              <DropdownLink :href="route('profile.edit')">
                Profile
              </DropdownLink>
              <DropdownLink :href="route('logout')" method="post" as="button">
                Log Out
              </DropdownLink>
            </template>
          </Dropdown>

          <button
            class="relative w-10 h-10 flex items-center justify-center rounded-full border border-gray-200 text-gray-700 hover:text-green-600">
            <i :class="icons.wishlist || 'fas fa-heart'"></i>
            <span
              class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
              {{ wishlistCount }}
            </span>
          </button>

          <button
            class="relative w-10 h-10 flex items-center justify-center rounded-full border border-gray-200 text-gray-700 hover:text-green-600">
            <i :class="icons.cart || 'fas fa-shopping-bag'"></i>
            <span
              class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
              {{ cartCount }}
            </span>
          </button>
        </div>
      </div>

      <!-- Nav Links -->
      <nav
        class="hidden md:flex justify-center space-x-8 py-3 text-white font-medium border-t bg-emerald-800 border-gray-100">
        <template v-for="(link, index) in navLinks" :key="index">
          <Link :href="link.url || '#'" class="hover:text-green-600" v-html="link.label">
          </Link>
        </template>
      </nav>
    </div>
  </header>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import Dropdown from './Dropdown.vue'
import DropdownLink from './DropdownLink.vue'

// Props
const props = defineProps({
  settings: {
    type: Object,
    default: () => ({})
  }
})

const searchQuery = ref('')

// Computed fields
const icons = computed(() => props.settings?.icons || {})
const topbarText = computed(() => props.settings?.topbar_text || 'Free shipping on orders over $25.')
const topbarPhoneRaw = computed(() => props.settings?.topbar_phone || '888554168')
const topbarPhoneDisplay = computed(() => props.settings?.topbar_phone_display || '+8 88 55 4168')
const topbarHelpText = computed(() => props.settings?.topbar_help_text || 'Need help? Call Us:')
const logoSrc = computed(() => props.settings?.logo || '/assets/images/logo.png')
const logoUrl = computed(() => props.settings?.logo_url || '/')
const searchPlaceholder = computed(() => props.settings?.search_placeholder || 'Search product...')
const navLinks = computed(() => props.settings?.nav_links?.length ? props.settings.nav_links : [
  { label: 'Home', url: '/' },
  { label: 'Shop', url: '/shop' },
  { label: 'About Us', url: '/about-us' },
  { label: 'Contact Us', url: '/contact-us' }
])
const cartCount = computed(() => props.settings?.cart_count ?? 0)
const wishlistCount = computed(() => props.settings?.wishlist_count ?? 0)

const handleSearch = () => {
  if (searchQuery.value.trim()) {
    const keyword = encodeURIComponent(searchQuery.value.trim())
    router.visit(`/shop?search=${keyword}`)
  }
}
</script>
