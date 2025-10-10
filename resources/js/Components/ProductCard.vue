<!-- src/components/ProductCard.vue -->
<template>
  <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition p-4 flex flex-col">
    <img
      :src="product.image"
      :alt="product.name"
      class="w-full h-48 object-cover rounded-lg mb-3"
    />
    <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ product.name }}</h3>
    <p class="text-sm text-gray-500 mb-2">{{ product.category }}</p>
    <div class="flex items-center justify-between mt-auto">
      <p class="text-primary font-bold text-lg">${{ product.price }}</p>
      <button
        @click="$emit('add-to-cart', product)"
        class="px-3 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
      >
        Add
      </button>
    </div>
  </div>
</template>

<script setup>
defineProps({
  product: Object,
})
defineEmits(['add-to-cart'])
</script>
