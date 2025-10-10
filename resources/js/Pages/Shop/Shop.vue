<!-- src/pages/ShopPage.vue -->
<template>
  <div class="min-h-screen bg-gray-50 py-10">
    <!-- Scroll to top -->
    <button
      id="scroll-top"
      @click="scrollToTop"
      class="fixed bottom-5 right-5 p-3 bg-green-600 text-white rounded-full shadow-lg hover:bg-green-700"
    >
      <i class="icon-rt-arrow-up"></i>
    </button>

    <!-- HEADER -->
    <header class="border-b border-gray-200">
      <!-- Topbar -->
      <div class="bg-gray-100 text-sm py-2">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center px-4">
          <p>Free shipping on orders over $25.</p>
          <p class="mt-1 md:mt-0">
            Need help? Call Us:
            <a href="tel:888554168" class="text-green-600 font-medium hover:underline"
              >+8 88 55 4168</a
            >
          </p>
        </div>
      </div>

      <!-- Navbar -->
      <div class="max-w-7xl mx-auto flex justify-between items-center py-4 px-4">
        <a href="/" class="flex items-center gap-2">
          <img src="/assets/images/logo/logo.png" alt="logo" class="h-10" />
        </a>

        <nav class="hidden md:flex space-x-8 text-gray-700 font-medium">
          <a href="#" class="hover:text-green-600">Home</a>
          <a href="#" class="hover:text-green-600">Shop</a>
          <a href="#" class="hover:text-green-600">About</a>
          <a href="#" class="hover:text-green-600">Contact</a>
        </nav>

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
        </div>
      </div>
    </header>

    <div class="container mx-auto px-4">
      <!-- Header -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-4 sm:mb-0">🛍️ Shop</h1>

        <!-- Search + Filter -->
        <div class="flex flex-col sm:flex-row gap-3">
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Search products..."
            class="border rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500"
          />

          <select
            v-model="selectedCategory"
            class="border rounded-xl px-4 py-2 text-gray-700 focus:ring-2 focus:ring-blue-500"
          >
            <option value="">All Categories</option>
            <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
          </select>
        </div>
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
      <div v-if="filteredProducts.length === 0" class="text-center text-gray-500 mt-10">
        No products found 😕
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import ProductCard from '@/Components/ProductCard.vue'

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
  alert(`Added "${product.name}" to cart!`)
}
</script>
