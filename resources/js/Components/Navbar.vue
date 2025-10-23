<template>
  <header class="border-b border-gray-200">
    <!-- Topbar -->
    <div class="bg-gray-100 text-sm py-2">
      <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center px-4">
        <p v-html="topbarText"></p>
        <p class="mt-1 md:mt-0">
          {{ topbarHelpText }}
          <a :href="`tel:${topbarPhone}`" class="text-green-600 font-medium hover:underline">
            {{ formattedPhone }}
          </a>
        </p>
      </div>
    </div>

    <!-- Main Navbar -->
    <div class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto flex items-center justify-between px-4 py-4 gap-4">
        <!-- Mobile Menu Button with Dropdown -->
        <div class="md:hidden">
          <Dropdown align="left" width="80">
            <template #trigger>
              <button
                class="w-10 h-10 flex items-center justify-center rounded-full border border-gray-200 text-gray-700 hover:text-green-600">
                <i :class="isMobileMenuOpen ? 'fas fa-times' : 'fas fa-bars'"></i>
              </button>
            </template>

            <template #content>
              <!-- Navigation Links -->
              <div class="border-b border-gray-100">
                <template v-for="(link, index) in navLinks" :key="index">
                  <DropdownLink :href="link.url || '#'" class="text-gray-800 hover:text-green-600 text-base py-3 px-4"
                    @click="closeMobileMenu">
                    <span v-html="link.label"></span>
                  </DropdownLink>
                </template>
              </div>

              <!-- User Menu -->
              <DropdownLink :href="route('profile.edit')" class="text-gray-800 hover:text-green-600 text-base py-3 px-4"
                @click="closeMobileMenu">
                Profile
              </DropdownLink>
              <DropdownLink :href="route('logout')" method="post" as="button"
                class="w-full text-left text-gray-800 hover:text-green-600 text-base py-3 px-4"
                @click="closeMobileMenu">
                Log Out
              </DropdownLink>
            </template>
          </Dropdown>
        </div>

        <!-- Logo -->
        <Link :href="logoUrl" class="flex items-center gap-2 flex-1 md:flex-none justify-center md:justify-start">
        <img :src="logoSrc" alt="Logo" class="h-10" />
        </Link>

        <!-- Search Bar - Hidden on mobile, visible on tablet and up -->
        <form @submit.prevent="handleSearch" class="hidden md:flex flex-grow max-w-2xl mx-4 relative">
          <input v-model="searchQuery" type="text" :placeholder="searchPlaceholder"
            class="w-full px-6 py-3 rounded-full bg-gray-100 text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-600 placeholder-gray-400" />
          <button type="submit"
            class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-green-600">
            <i :class="iconSearch"></i>
          </button>
        </form>

        <!-- Icons -->
        <div class="flex items-center gap-4">
          <button v-if="!$page.props.auth.user" class="text-white bg-green-600 font-bold p-2 rounded-md"><Link href='/login'>Login/Register</Link></button>
          <span v-else> </span>
          <!-- User Dropdown -->
          <Dropdown align="right" width="48" class="hidden md:block">
            <template #trigger>
              <button
                class="relative w-10 h-10 flex items-center justify-center rounded-full border border-gray-200 text-gray-700 hover:text-green-600">
                <i :class="iconUser"></i>
              </button>
            </template>

            <template #content>
              <DropdownLink :href="route('profile.edit')">
                Profile
              </DropdownLink>
            <!-- </template>

            <template #content> -->
              <DropdownLink v-if="$page.props.auth.user" :href="route('logout')" method="post" as="button">
                Log Out
              </DropdownLink>
              <template v-else>
                <DropdownLink :href="route('login')">
                  Log In
                </DropdownLink>
                <DropdownLink :href="route('register')">
                  Register
                </DropdownLink>
              </template>
            </template>
          </Dropdown>


          <!-- Mobile User Icon (non-dropdown) -->
          <Link :href="route('profile.edit')"
            class="md:hidden w-10 h-10 flex items-center justify-center rounded-full border border-gray-200 text-gray-700 hover:text-green-600">
          <i :class="iconUser"></i>
          </Link>

          <button
            class="relative w-10 h-10 flex items-center justify-center rounded-full border border-gray-200 text-gray-700 hover:text-green-600">
            <i :class="iconWishlist"></i>
          </button>

          <button
            class="relative w-10 h-10 flex items-center justify-center rounded-full border border-gray-200 text-gray-700 hover:text-green-600">
            <i :class="iconCart"></i>
          </button>
        </div>
      </div>

      <!-- Mobile Search Bar - Visible only on mobile -->
      <div class="md:hidden px-4 pb-4">
        <form @submit.prevent="handleSearch" class="relative">
          <input v-model="searchQuery" type="text" :placeholder="searchPlaceholder"
            class="w-full px-4 py-3 rounded-full bg-gray-100 text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-600 placeholder-gray-400" />
          <button type="submit"
            class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-green-600">
            <i :class="iconSearch"></i>
          </button>
        </form>
      </div>

      <!-- Desktop Nav Links -->
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

const props = defineProps({
  settings: Object
})

const searchQuery = ref('')
const isMobileMenuOpen = ref(false)

// Use reactive computed props
const topbarText = computed(() => props.settings?.topbar_text || 'Free shipping on orders over $25.')
const topbarHelpText = computed(() => props.settings?.topbar_help_text || 'Need help? Call Us:')
const topbarPhone = computed(() => props.settings?.topbar_phone || '888554168')
const formattedPhone = computed(() => {
  const phone = topbarPhone.value
  return phone.length === 10 ? `+1 (${phone.slice(0, 3)}) ${phone.slice(3, 6)}-${phone.slice(6)}` : phone
})
const logoSrc = computed(() => props.settings?.logo || '/assets/images/logo.png')
const logoUrl = computed(() => props.settings?.logo_url || '/')
const searchPlaceholder = computed(() => props.settings?.search_placeholder || 'Search product...')
const iconSearch = computed(() => props.settings?.icon_search || 'fas fa-search')
const iconUser = computed(() => props.settings?.icon_user || 'fas fa-user')
const iconWishlist = computed(() => props.settings?.icon_wishlist || 'fas fa-heart')
const iconCart = computed(() => props.settings?.icon_cart || 'fas fa-shopping-bag')
const navLinks = computed(() => props.settings?.nav_links || [
  { label: 'Home', url: '/' },
  { label: 'Shop', url: '/shop' },
  { label: 'About Us', url: '/about-us' },
  { label: 'Contact Us', url: '/contact-us' }
])

const closeMobileMenu = () => {
  // The dropdown should close automatically when clicking on links
  // due to the Dropdown component's internal functionality
}

const handleSearch = () => {
  if (searchQuery.value.trim()) {
    router.visit('/shop?search=' + encodeURIComponent(searchQuery.value.trim()))
  }
}
</script>