<template>
  <div class="bg-white rounded-lg shadow p-4 flex items-center space-x-4">
    <div class="text-3xl">{{ icon }}</div>
    <div>
      <p class="text-gray-500 text-sm">{{ title }}</p>
      <p class="text-xl font-semibold">{{ value }}</p>
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: String,
  value: String,
  icon: String
})
</script>
