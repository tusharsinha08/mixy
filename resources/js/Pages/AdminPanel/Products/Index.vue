<template>
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-bold">Products</h2>
      <Link
        href="/admin/products/create"
        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
      >
        Add Product
      </Link>
    </div>

    <!-- Success Message -->
    <div v-if="$page.props.flash.success" class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
      {{ $page.props.flash.success }}
    </div>

    <!-- Error Message -->
    <div v-if="$page.props.flash.error" class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
      {{ $page.props.flash.error }}
    </div>

    <table class="min-w-full bg-white border rounded-lg">
      <thead>
        <tr class="bg-gray-100 text-left">
          <th class="p-3">#</th>
          <th class="p-3">Name</th>
          <th class="p-3">Price</th>
          <th class="p-3">Rating</th>
          <th class="p-3">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(product, index) in products"
          :key="product.id"
          class="border-t hover:bg-gray-50"
        >
          <td class="p-3">{{ index + 1 }}</td>
          <td class="p-3">{{ product.name }}</td>
          <td class="p-3">{{ product.price_range }}</td>
          <td class="p-3">{{ product.rating }}</td>
          <td class="p-3 flex space-x-2">
            <Link
              :href="`/admin/products/${product.id}/edit`"
              class="text-blue-600 hover:underline mr-2"
            >
              Edit
            </Link>
            <button
              @click="deleteProduct(product.id)"
              class="text-red-600 hover:underline"
              :disabled="isDeleting === product.id"
            >
              <span v-if="isDeleting === product.id">Deleting...</span>
              <span v-else>Delete</span>
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Confirmation Modal -->
    <div v-if="showDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
      <div class="bg-white p-6 rounded-lg max-w-sm mx-auto">
        <h3 class="text-lg font-bold mb-4">Confirm Delete</h3>
        <p class="mb-6">Are you sure you want to delete this product? This action cannot be undone.</p>
        <div class="flex justify-end space-x-3">
          <button
            @click="showDeleteModal = false; productToDelete = null"
            class="px-4 py-2 border border-gray-300 rounded hover:bg-gray-50"
          >
            Cancel
          </button>
          <button
            @click="confirmDelete"
            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
            :disabled="isDeleting"
          >
            <span v-if="isDeleting">Deleting...</span>
            <span v-else>Delete</span>
          </button>
        </div>
      </div>
    </div>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, router } from '@inertiajs/vue3';
import { ref } from 'vue'

defineOptions({
    layout: AdminLayout
})

defineProps({ products: Array })

// Delete functionality
const showDeleteModal = ref(false)
const productToDelete = ref(null)
const isDeleting = ref(null)

const deleteProduct = (productId) => {
  productToDelete.value = productId
  showDeleteModal.value = true
}

const confirmDelete = async () => {
  if (!productToDelete.value) return
  
  isDeleting.value = productToDelete.value
  
  try {
    await router.delete(`/admin/products/${productToDelete.value}`, {
      onSuccess: () => {
        // Success message will be shown via flash message
        showDeleteModal.value = false
        productToDelete.value = null
        isDeleting.value = null
      },
      onError: () => {
        alert('Error deleting product. Please try again.')
        isDeleting.value = null
      }
    })
  } catch (error) {
    alert('Error deleting product. Please try again.')
    isDeleting.value = null
  }
}
</script>