<template>
  <div class="min-h-screen bg-gray-50 py-10">
    <!-- Scroll to top -->
    <button
      v-show="showScrollTop"
      id="scroll-top"
      @click="scrollToTop"
      class="fixed bottom-5 right-5 p-3 bg-green-600 text-white rounded-full shadow-lg hover:bg-green-700 transition-colors z-50"
    >
      <i class="icon-rt-arrow-up"></i>
    </button>
    
    <div class="max-w-7xl mx-auto px-4">
      <!-- Header -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 mt-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4 sm:mb-0">🛍️ Shop</h1>

        <!-- Search + Filter -->
        <div class="flex flex-col sm:flex-row gap-3">
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Search products..."
            class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent w-full sm:w-64"
          />

          <select
            v-model="selectedCategory"
            class="border border-gray-300 rounded-lg px-4 py-2 text-gray-700 focus:ring-2 focus:ring-green-500 focus:border-transparent"
          >
            <option value="">All Categories</option>
            <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
          </select>
        </div>
      </div>

      <!-- Results count -->
      <div class="mb-6 text-gray-600">
        Showing {{ filteredProducts.length }} of {{ products.length }} products
        <span v-if="searchQuery || selectedCategory">
          (filtered)
        </span>
      </div>

      <!-- Products Grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <ProductCard
          v-for="product in filteredProducts"
          :key="product.id"
          :product="product"
          @add-to-cart="handleAddToCart"
        />
      </div>

      <!-- Empty state -->
      <div v-if="filteredProducts.length === 0" class="text-center text-gray-500 mt-20 py-10">
        <div class="text-6xl mb-4">😕</div>
        <p class="text-xl font-medium mb-2">No products found</p>
        <p class="text-gray-600 mb-4">Try adjusting your search or filter criteria</p>
        <button 
          @click="clearFilters"
          class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors"
        >
          Clear Filters
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import ProductCard from '@/Components/ProductCard.vue'
import Navbar from '@/Components/Navbar.vue'

const products = ref([
  {
    id: 1,
    name: 'Wireless Headphones',
    price: 99,
    category: 'Electronics',
    image: 'https://images.unsplash.com/photo-1585386959984-a41552231693?auto=format&fit=crop&w=500&q=60',
  },
  {
    id: 2,
    name: 'Sneakers',
    price: 79,
    category: 'Fashion',
    image: 'https://images.unsplash.com/photo-1589187155479-3e8a721b52a8?auto=format&fit=crop&w=500&q=60',
  },
  {
    id: 3,
    name: 'Smart Watch',
    price: 129,
    category: 'Electronics',
    image: 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=500&q=60',
  },
  {
    id: 4,
    name: 'T-shirt',
    price: 25,
    category: 'Fashion',
    image: 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?auto=format&fit=crop&w=500&q=60',
  },
  {
    id: 5,
    name: 'Sunglasses',
    price: 45,
    category: 'Accessories',
    image: 'https://images.unsplash.com/photo-1581291519195-ef11498d1cf5?auto=format&fit=crop&w=500&q=60',
  },
])

const searchQuery = ref('')
const selectedCategory = ref('')
const showScrollTop = ref(false)

const categories = computed(() =>
  [...new Set(products.value.map(p => p.category))].sort()
)

const filteredProducts = computed(() => {
  return products.value.filter(p => {
    const matchesSearch = p.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    const matchesCategory = !selectedCategory.value || p.category === selectedCategory.value
    return matchesSearch && matchesCategory
  })
})

function handleAddToCart(product) {
  // You can integrate with your cart store here
  alert(`Added "${product.name}" to cart!`)
}

function clearFilters() {
  searchQuery.value = ''
  selectedCategory.value = ''
}

function scrollToTop() {
  window.scrollTo({ top: 0, behavior: 'smooth' })
}

function handleScroll() {
  showScrollTop.value = window.scrollY > 300
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll)
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
})
</script>