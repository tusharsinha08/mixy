<template>
  <div
    class="border rounded-xl p-2 hover:shadow-md transition relative flex flex-col items-center text-center"
  >
    <!-- Make the whole card clickable except the button -->
    <Link
      :href="`/product-details/${product.id}`"
      class="flex flex-col items-center text-center w-full cursor-pointer"
    >
      <!-- Product Image -->
      <img
        :src="product.image"
        :alt="product.name"
        class="object-contain mb-3 w-32 h-32"
      />

      <!-- Rating -->
      <div class="flex justify-center space-x-1 text-yellow-400 mb-2">
        <i class="fas fa-star" v-for="n in 4" :key="n"></i>
        <i class="far fa-star"></i>
      </div>

      <!-- Product Name -->
      <h4 class="font-semibold text-gray-800 text-sm mb-1">
        {{ product.name }}
      </h4>

      <!-- Product Price -->
      <p class="text-red-600 font-semibold text-sm">
        {{ product.priceRange || ('$' + product.price) }}
      </p>
    </Link>

    <!-- Add to Cart Button -->
    <button
      @click.stop="$emit('add-to-cart', product)"
      class="absolute bottom-4 right-4 bg-green-600 text-white w-8 h-8 rounded-full flex items-center justify-center hover:bg-green-700 transition"
    >
      <i class="fas fa-shopping-bag text-sm"></i>
    </button>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  product: {
    type: Object,
    required: true,
  },
})

defineEmits(['add-to-cart'])
</script>
