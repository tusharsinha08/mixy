<template>
  <div class="min-h-screen bg-gray-50 py-10">
    <!-- Scroll to top -->
    <button v-show="showScrollTop" id="scroll-top" @click="scrollToTop"
      class="fixed bottom-5 right-5 p-3 bg-green-600 text-white rounded-full shadow-lg hover:bg-green-700 transition-colors z-50">
      <i class="icon-rt-arrow-up"></i>
    </button>

    <div class="max-w-7xl mx-auto px-4">
      <!-- Header -->
      <div>
        <h1 class="text-2xl font-bold text-gray-800 mb-4 sm:mb-0">
          Shop
          <span v-if="searchQuery" class="text-green-600">— "{{ searchQuery }}"</span>
          <span v-if="selectedCategory" class="text-green-600">— {{ selectedCategory }}</span>
        </h1>
        <p class="mb-4 sm:mb-0">Home > Shop</p>
      </div>

      <div class="flex flex-col md:justify-end sm:flex-row sm:items-center sm:justify-between mb-8 mt-6">
        <!-- Search + Filter -->
        <div class="flex flex-col sm:flex-row gap-3">
          <input v-model="searchQuery" type="text" placeholder="Search products..."
            class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent w-full sm:w-64"
            @input="handleSearchInput" />

          <select v-model="selectedCategory"
            class="border border-gray-300 rounded-lg px-4 py-2 text-gray-700 focus:ring-2 focus:ring-green-500 focus:border-transparent"
            @change="handleCategoryChange">
            <option value="">All Categories</option>
            <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
          </select>
        </div>
      </div>

      <!-- Results count with category info -->
      <div class="mb-6 text-gray-600">
        <span v-if="selectedCategory"
          class="inline-flex items-center gap-2 bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm mb-2">
          <span>Category: {{ selectedCategory }}</span>
          <button @click="clearCategory" class="text-green-600 hover:text-green-800">✕</button>
        </span>
        <div>
          Showing {{ filteredProducts.length }} of {{ products.length }} products
          <span v-if="searchQuery || selectedCategory">(filtered)</span>
        </div>
      </div>

      <!-- Products Grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6" v-if="filteredProducts.length">
        <ProductCard v-for="product in filteredProducts" :key="product.id" :product="product"
          @add-to-cart="handleAddToCart" />
      </div>

      <!-- Empty state -->
      <div v-else class="text-center text-gray-500 mt-20 py-10">
        <div class="text-6xl mb-4">😕</div>
        <p class="text-xl font-medium mb-2">No products found</p>
        <p class="text-gray-600 mb-4">
          <span v-if="selectedCategory">No products found in "{{ selectedCategory }}" category.</span>
          <span v-else>Try adjusting your search or filter criteria</span>
        </p>
        <button @click="clearFilters"
          class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors">
          Clear Filters
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue'
import { router } from '@inertiajs/vue3'
import ProductCard from '@/Components/ProductCard.vue'
import AppLayout from '@/Layouts/AppLayout.vue'

defineOptions({
  layout: AppLayout,
})

// Props from Laravel/Inertia
const props = defineProps({
  products: {
    type: Array,
    required: true,
  },
  category: {
    type: String,
    default: '',
  },
  search: {
    type: String,
    default: '',
  },
  allCategories: {
    type: Array,
    default: () => [],
  },
  filters: {
    type: Object,
    default: () => ({}),
  }
})

// Reactive states
const searchQuery = ref(props.search || '')
const selectedCategory = ref(props.category || '')
const showScrollTop = ref(false)
const products = ref(props.products || [])

// Debug on mount
onMounted(() => {
  console.log('=== SHOP PAGE DEBUG ===')
  console.log('Initial props:', props)
  console.log('Initial category:', props.category)
  console.log('Initial search:', props.search)
  console.log('All categories:', props.allCategories)
  console.log('Products count:', props.products.length)
  console.log('First product categories:', props.products[0]?.categories)
  
  window.addEventListener('scroll', handleScroll)
})

// Compute unique categories safely
const categories = computed(() => {
  if (props.allCategories && props.allCategories.length) {
    return props.allCategories;
  }
  
  // Fallback: extract from products
  const allCats = products.value.flatMap(p => p.categories || [])
  const uniqueCats = [...new Set(allCats)].sort()
  console.log('Computed categories from products:', uniqueCats)
  return uniqueCats
})

  console.log("categories-----", categories);
// Filter logic
const filteredProducts = computed(() => {
  const filtered = products.value.filter(p => {
    const name = p.name?.toLowerCase() || ''
    const desc = p.description?.toLowerCase() || ''
    const productCategories = p.categories || []

    const matchesSearch = !searchQuery.value || 
      name.includes(searchQuery.value.toLowerCase()) || 
      desc.includes(searchQuery.value.toLowerCase())
    
    const matchesCategory = !selectedCategory.value || 
      productCategories.includes(selectedCategory.value)

    return matchesSearch && matchesCategory
  })

  console.log('Filtered products:', {
    total: products.value.length,
    filtered: filtered.length,
    selectedCategory: selectedCategory.value,
    searchQuery: searchQuery.value
  })

  return filtered
})

// Update URL when filters change
const updateUrl = () => {
  const query = {}
  if (searchQuery.value) query.search = searchQuery.value
  if (selectedCategory.value) query.category = selectedCategory.value

  console.log('Updating URL with query:', query)
  
  router.get('/shop', query, {
    preserveState: true,
    replace: true
  })
}

// Debounced search to avoid too many requests
let searchTimeout = null
const handleSearchInput = () => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(updateUrl, 500)
}

const handleCategoryChange = () => {
  console.log('Category changed to:', selectedCategory.value)
  updateUrl()
}

function handleAddToCart(product) {
  console.log('Adding to cart:', product.name)
  alert(`🛒 Added "${product.name}" to cart!`)
}

function clearFilters() {
  console.log('Clearing all filters')
  searchQuery.value = ''
  selectedCategory.value = ''
  router.get('/shop', {}, {
    preserveState: true,
    replace: true
  })
}

function clearCategory() {
  console.log('Clearing category filter')
  selectedCategory.value = ''
  router.get('/shop', { 
    search: searchQuery.value 
  }, {
    preserveState: true,
    replace: true
  })
}

function scrollToTop() {
  window.scrollTo({ top: 0, behavior: 'smooth' })
}

function handleScroll() {
  showScrollTop.value = window.scrollY > 300
}

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
  clearTimeout(searchTimeout)
})
</script>