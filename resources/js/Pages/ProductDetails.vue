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
        <img :src="product.imagePrimary" alt="" class="w-full h-64 sm:h-80 md:h-96 object-contain mb-4 rounded-lg" />

        <!-- Thumbnails -->
        <div class="flex space-x-2 overflow-x-auto">
          <img v-for="(img, index) in product.thumbnails" :key="index" :src="img" alt=""
            class="w-16 h-16 sm:w-20 sm:h-20 object-contain border rounded cursor-pointer hover:border-green-600 flex-shrink-0"
            @click="product.imagePrimary = img" />
        </div>
      </div>

      <!-- Right: Details -->
      <div>
        <h1 class="text-xl sm:text-2xl font-bold mb-2">{{ product.name }}</h1>

        <!-- Rating -->
        <div class="flex items-center space-x-1 text-yellow-400 mb-2 text-sm sm:text-base">
          <i v-for="n in product.rating" :key="n" class="fas fa-star"></i>
          <i v-for="n in 5 - product.rating" :key="'empty' + n" class="far fa-star"></i>
          <span class="text-gray-500 ml-2 text-xs sm:text-sm">({{ product.reviews.length }} customer review)</span>
        </div>

        <p class="text-gray-600 mb-4 text-sm sm:text-base">{{ product.descriptionShort }}</p>

        <!-- Price -->
        <p class="text-lg sm:text-xl text-red-600 font-bold mb-4">
          {{ product.priceRange }}
        </p>

        <!-- Sizes -->
        <div class="flex flex-wrap items-center gap-2 mb-4">
          <span class="font-semibold text-sm sm:text-base">Size:</span>
          <button v-for="(size, index) in product.sizes" :key="index"
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
          <span class="font-semibold">Categories:</span> {{ product.categories.join(', ') }}
        </p>
        <p class="text-sm sm:text-base text-gray-500">
          <span class="font-semibold">Tags:</span> {{ product.tags.join(', ') }}
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
          {{ product.descriptionLong }}
        </div>
        <div v-else-if="activeTab === 'Additional Information'" class="text-gray-700 text-sm sm:text-base">
          <p>Size : {{ product.additionalInfo.size }}</p>
          <p>Brand : {{ product.additionalInfo.brand }}</p>
          <p>Dietary & Lifestyle : {{ product.additionalInfo.dietary_and_lifestyle }}</p>
        </div>
        <div v-else-if="activeTab === 'Reviews'" class="text-gray-700 text-sm sm:text-base space-y-4">
          <div v-for="(review, index) in product.reviews" :key="index" class="mb-4 border-b pb-2">
            <p class="font-semibold">{{ review.name }} - <span class="text-yellow-400">{{ '★'.repeat(review.rating)
                }}</span></p>
            <p class="text-gray-500 text-xs sm:text-sm">{{ review.date }}</p>
            <p>{{ review.comment }}</p>
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
        <div v-for="item in product.relatedProducts" :key="item.id"
          class="border rounded-xl p-4 hover:shadow-md transition flex flex-col items-center text-center">
          <img :src="item.imagePrimary" alt="" class="w-full h-24 sm:h-28 md:h-28 object-contain mb-2" />
          <h6 class="font-semibold text-gray-800 text-sm sm:text-base mb-1">{{ item.name }}</h6>
          <div class="flex justify-center space-x-1 text-yellow-400 mb-1 text-xs sm:text-sm">
            <i v-for="n in item.rating" :key="n" class="fas fa-star"></i>
            <i v-for="n in 5 - item.rating" :key="'empty' + n" class="far fa-star"></i>
          </div>
          <p class="text-red-600 font-semibold text-sm sm:text-base">{{ item.priceRange }}</p>
          <button @click="addToCart(item)"
            class="mt-2 bg-green-600 w-8 h-8 sm:w-8 sm:h-8 text-white rounded-full flex items-center justify-center hover:bg-green-700 transition">
            <i class="fas fa-shopping-bag text-sm sm:text-sm"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'


defineOptions({
  layout: AdminLayout,
})

const product = ref({
  id: 1,
  name: 'Single product One',
  imagePrimary: '/assets/images/products/product-image-2-1.jpg',
  thumbnails: [
    '/assets/images/products/product-image-2-1.jpg',
    '/assets/images/products/product-image-2-2.jpg',
    '/assets/images/products/product-image-2-3.jpg'
  ],
  rating: 4,
  priceRange: '$10.00 - $20.00',
  descriptionShort: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
  descriptionLong: 'Full product description goes here. Include all details about the product.',
  additionalInfo: {
    size: '1kg, 200g, 500g',
    brand: 'Skinfood',
    dietary_and_lifestyle : 'Vegan'
  },
  reviews: [
    { name: 'Mike B', rating: 5, comment: 'Excellent product!', date: 'Nov 10, 2022' },
    { name: 'Alice W', rating: 4, comment: 'Good quality.', date: 'Nov 12, 2022' }
  ],
  categories: ['Fruits', 'Snacks'],
  tags: ['Organic', 'Healthy'],
  sizes: ['S', 'M', 'L'],
  relatedProducts: [
    { id: 2, name: 'Dried mango', imagePrimary: '/assets/images/products/product-image-1-1.jpg', rating: 4, priceRange: '$10.00 - $70.00' },
    { id: 3, name: 'Banana chips', imagePrimary: '/assets/images/products/product-image-3-1.jpg', rating: 4, priceRange: '$15.00 - $50.00' },
    { id: 4, name: 'Red Dates', imagePrimary: '/assets/images/products/product-image-4-1.jpg', rating: 4, priceRange: '$20.00 - $60.00' },
    { id: 5, name: 'Cranberries', imagePrimary: '/assets/images/products/product-image-5-1.jpg', rating: 4, priceRange: '$25.00 - $70.00' },
    { id: 6, name: 'Kiwi', imagePrimary: '/assets/images/products/product-image-6-1.jpg', rating: 4, priceRange: '$30.00 - $80.00' },
  ]
})

const quantity = ref(1)
const tabs = ['Description', 'Additional Information', 'Reviews']
const activeTab = ref('Description')

function increaseQty() { quantity.value++ }
function decreaseQty() { if (quantity.value > 1) quantity.value-- }
function addToCart(item) { console.log('Add to cart:', item) }
</script>
