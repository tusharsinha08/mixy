<template>
  <div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <div class="text-sm text-gray-500 mb-4">
      Home > Single Product
    </div>

    <!-- Product Info -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <!-- Left: Images -->
      <div>
        <img :src="product.image_primary" alt="" class="w-full h-64 sm:h-80 md:h-96 object-contain mb-4 rounded-lg" />

        <!-- Thumbnails -->
        <div class="flex space-x-2 overflow-x-auto">
          <img v-for="(img, index) in parsedThumbnails" :key="index" :src="img" alt=""
            class="w-16 h-16 sm:w-20 sm:h-20 object-contain border rounded cursor-pointer hover:border-green-600 flex-shrink-0"
            @click="product.image_primary = img" />
        </div>
      </div>

      <!-- Right: Details -->
      <div>
        <h1 class="text-xl sm:text-2xl font-bold mb-2">{{ product.name }}</h1>

        <!-- Rating -->
        <div class="flex items-center space-x-1 text-yellow-400 mb-2 text-sm sm:text-base">
          <i v-for="n in product.rating" :key="n" class="fas fa-star"></i>
          <i v-for="n in 5 - product.rating" :key="'empty' + n" class="far fa-star"></i>
          <span class="text-gray-500 ml-2 text-xs sm:text-sm">({{ product.rating || 0 }} customer
            review)</span>
        </div>

        <p class="text-gray-600 mb-4 text-sm sm:text-base">{{ product.description_short }}</p>

        <!-- Price -->
        <p class="text-lg sm:text-xl text-red-600 font-bold mb-4">
          {{ product.price_range }}
        </p>

        <!-- Sizes -->
        <div class="flex flex-wrap items-center gap-2 mb-4">
          <span class="font-semibold text-sm sm:text-base">Size:</span>
          <button v-for="(size, index) in parsedSizes" :key="index"
            class="border px-2 py-1 rounded hover:border-green-600 text-sm sm:text-base">
            {{ size }}
          </button>
        </div>

        <!-- Quantity & Add to Cart -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 mb-4">
          <div class="flex items-center border rounded">
            <button class="px-3" @click="decreaseQty">-</button>
            <input type="text" class="w-12 text-center" v-model="quantity" />
            <button class="px-3" @click="increaseQty">+</button>
          </div>
          <button class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition w-full sm:w-auto"
            @click="addToCart(product)">
            Add to Cart
          </button>
        </div>

        <!-- Wishlist -->
        <div class="mb-4">
          <input type="checkbox" id="wishlist" class="mr-2" />
          <label for="wishlist" class="text-gray-600 text-sm sm:text-base">Add to Wishlist</label>
        </div>

        <!-- Categories & Tags -->
        <p class="text-sm sm:text-base text-gray-500">
          <span class="font-semibold">Categories:</span>
          {{ parsedCategories.length ? parsedCategories.join(', ') : '-' }}
        </p>
        <p class="text-sm sm:text-base text-gray-500">
          <span class="font-semibold">Tags:</span>
          {{ parsedTags.length ? parsedTags.join(', ') : '-' }}
        </p>

        <!-- Social Share -->
        <div class="flex space-x-2 mt-2 text-sm sm:text-base">
          <span class="font-semibold">Share:</span>
          <i class="fab fa-facebook text-gray-500 hover:text-blue-600 cursor-pointer"></i>
          <i class="fab fa-twitter text-gray-500 hover:text-blue-400 cursor-pointer"></i>
          <i class="fab fa-instagram text-gray-500 hover:text-pink-500 cursor-pointer"></i>
        </div>
      </div>
    </div>

    <!-- Tabs: Description, Info, Reviews -->
    <div class="flex justify-center">
      <div class="mt-8 border-t pt-4">
        <div class="flex flex-wrap justify-center sm:justify-start space-x-2 sm:space-x-4 border-b mb-4">
          <button v-for="tab in tabs" :key="tab" @click="activeTab = tab"
            :class="activeTab === tab ? 'border-b-2 border-green-600 text-green-600' : 'text-gray-500'"
            class="pb-2 font-semibold text-sm sm:text-base">
            {{ tab }}
          </button>
        </div>

        <div v-if="activeTab === 'Description'" class="text-gray-700 text-sm sm:text-base">
          {{ product.description_long }}
        </div>
        <div v-else-if="activeTab === 'Additional Information'" class="text-gray-700 text-sm sm:text-base">
          <p>Size : {{ parsedAdditionalInfo?.size || '-' }}</p>
          <p>Brand : {{ parsedAdditionalInfo?.brand || '-' }}</p>
          <p>Dietary & Lifestyle : {{ parsedAdditionalInfo?.dietary_and_lifestyle || '-' }}</p>
        </div>
        <div v-else-if="activeTab === 'Reviews'" class="text-gray-700 text-sm sm:text-base space-y-4">
          <div v-for="(review, index) in parsedReviews" :key="index" class="mb-4 border-b pb-2">
            <p class="font-semibold">{{ review.name }} - <span class="text-yellow-400">{{ '★'.repeat(review.rating || 5) }}</span></p>
            <p class="text-gray-500 text-xs sm:text-sm">{{ review.date || 'Recently' }}</p>
            <p>{{ review.text || review.comment }}</p>
          </div>

          <!-- Add Review Form -->
          <div class="mt-4">
            <h3 class="font-semibold mb-2 text-sm sm:text-base">Add a Review</h3>
            <input type="text" placeholder="Your Name"
              class="w-full mb-2 border rounded px-2 py-1 text-sm sm:text-base" />
            <input type="email" placeholder="Your Email"
              class="w-full mb-2 border rounded px-2 py-1 text-sm sm:text-base" />
            <textarea placeholder="Your Review"
              class="w-full mb-2 border rounded px-2 py-1 text-sm sm:text-base"></textarea>
            <button
              class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm sm:text-base">Submit</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Related Products -->
    <div class="mt-8">
      <h2 class="text-xl sm:text-2xl font-bold mb-4">Related Products</h2>
      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
        <!-- Note: You'll need to fetch related products from your backend -->
        <div class="border rounded-xl p-4 hover:shadow-md transition flex flex-col items-center text-center">
          <p class="text-gray-500">Related products feature coming soon</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { ref, computed } from 'vue'

defineOptions({
  layout: AppLayout,
})

const props = defineProps({
  product: Object,
})

// Create reactive product copy
const product = ref({ ...props.product })

console.log("Full product data:", props.product)

// Parse JSON data with error handling
const parsedThumbnails = computed(() => {
  try {
    if (Array.isArray(product.value.thumbnails)) return product.value.thumbnails
    return product.value.thumbnails ? JSON.parse(product.value.thumbnails) : []
  } catch {
    return []
  }
})

const parsedSizes = computed(() => {
  try {
    if (Array.isArray(product.value.sizes)) return product.value.sizes
    return product.value.sizes ? JSON.parse(product.value.sizes) : []
  } catch {
    return []
  }
})

const parsedCategories = computed(() => {
  try {
    if (Array.isArray(product.value.categories)) return product.value.categories
    return product.value.categories ? JSON.parse(product.value.categories) : []
  } catch {
    return []
  }
})

const parsedTags = computed(() => {
  try {
    if (Array.isArray(product.value.tags)) return product.value.tags
    return product.value.tags ? JSON.parse(product.value.tags) : []
  } catch {
    return []
  }
})

const parsedAdditionalInfo = computed(() => {
  try {
    if (typeof product.value.additional_info === 'object') return product.value.additional_info
    return product.value.additional_info ? JSON.parse(product.value.additional_info) : {}
  } catch {
    return {}
  }
})

const parsedReviews = computed(() => {
  try {
    if (Array.isArray(product.value.reviews)) return product.value.reviews
    return product.value.reviews ? JSON.parse(product.value.reviews) : []
  } catch {
    return []
  }
})

// Tabs and quantity
const quantity = ref(1)
const tabs = ['Description', 'Additional Information', 'Reviews']
const activeTab = ref('Description')

// Quantity handlers
function increaseQty() { quantity.value++ }
function decreaseQty() { if (quantity.value > 1) quantity.value-- }

// Add to cart
function addToCart(item) {
  console.log('Add to cart:', item)
}
</script>