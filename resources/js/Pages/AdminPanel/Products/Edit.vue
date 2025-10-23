<template>
  <AdminLayout>
    <div class="p-6 max-w-2xl mx-auto">
      <h1 class="text-2xl font-bold mb-4">Edit Product</h1>

      <form @submit.prevent="submit" class="space-y-4">

        <!-- Name -->
        <div>
          <label class="block mb-1 font-semibold">Product Name</label>
          <input type="text" v-model="form.name" @input="generateSlug" class="w-full border px-2 py-1 rounded" />
        </div>

        <!-- Slug -->
        <div>
          <label class="block mb-1 font-semibold">Slug</label>
          <input type="text" v-model="form.slug" class="w-full border px-2 py-1 rounded" />
        </div>

        <!-- Price Range -->
        <div>
          <label class="block mb-1 font-semibold">Price Range</label>
          <input type="text" v-model="form.price_range" class="w-full border px-2 py-1 rounded" />
        </div>

        <!-- Primary Image Upload -->
        <div>
          <label class="block mb-1 font-semibold">Primary Image</label>
          <input type="file" @change="handlePrimaryImage" accept="image/*" class="w-full border px-2 py-1 rounded" />
          <div v-if="currentPrimaryImage" class="mt-2">
            <p class="text-sm text-gray-600">Current:</p>
            <img :src="currentPrimaryImage" class="h-32 object-cover rounded border" />
          </div>
        </div>

        <!-- Thumbnails Upload -->
        <div>
          <label class="block mb-1 font-semibold">Thumbnails</label>
          <input type="file" multiple @change="handleThumbnails" accept="image/*"
            class="w-full border px-2 py-1 rounded" />
          <div v-if="currentThumbnails.length" class="mt-2">
            <p class="text-sm text-gray-600">Current:</p>
            <div class="flex flex-wrap gap-2">
              <img v-for="thumb in currentThumbnails" :key="thumb" :src="thumb"
                class="h-20 w-20 object-cover rounded border" />
            </div>
          </div>
        </div>

        <!-- Rating -->
        <div>
          <label class="block mb-1 font-semibold">Rating (0-5)</label>
          <input type="number" v-model.number="form.rating" min="0" max="5" class="w-full border px-2 py-1 rounded" />
        </div>

        <!-- Short Description -->
        <div>
          <label class="block mb-1 font-semibold">Short Description</label>
          <textarea v-model="form.description_short" class="w-full border px-2 py-1 rounded"></textarea>
        </div>

        <!-- Long Description -->
        <div>
          <label class="block mb-1 font-semibold">Long Description</label>
          <textarea v-model="form.description_long" class="w-full border px-2 py-1 rounded"></textarea>
        </div>

        <!-- Additional Info -->
        <div class="space-y-1">
          <label class="block mb-1 font-semibold">Additional Info</label>
          <input v-model="form.additional_info.size" placeholder="Size" class="w-full border px-2 py-1 rounded mb-1" />
          <input v-model="form.additional_info.brand" placeholder="Brand"
            class="w-full border px-2 py-1 rounded mb-1" />
          <input v-model="form.additional_info.dietary_and_lifestyle" placeholder="Dietary & Lifestyle"
            class="w-full border px-2 py-1 rounded" />
        </div>

        <!-- Categories -->
        <div>
          <label class="block mb-1 font-semibold">Categories (comma separated)</label>
          <input type="text" v-model="categoriesInput" @blur="parseCategories"
            class="w-full border px-2 py-1 rounded" />
        </div>

        <!-- Tags -->
        <div>
          <label class="block mb-1 font-semibold">Tags (comma separated)</label>
          <input type="text" v-model="tagsInput" @blur="parseTags" class="w-full border px-2 py-1 rounded" />
        </div>

        <!-- Sizes -->
        <div>
          <label class="block mb-1 font-semibold">Sizes (comma separated)</label>
          <input type="text" v-model="sizesInput" @blur="parseSizes" class="w-full border px-2 py-1 rounded" />
        </div>

        <!-- Submit -->
        <div>
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Update Product
          </button>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { ref, reactive } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  product: Object
})

// Helper to ensure array
const safeArray = (value) => {
  if (!value) return []
  if (Array.isArray(value)) return value
  if (typeof value === 'string') {
    try {
      const parsed = JSON.parse(value)
      return Array.isArray(parsed) ? parsed : []
    } catch {
      return value.split(',').map(s => s.trim()).filter(Boolean)
    }
  }
  return []
}

// Form data - using reactive instead of useForm for simplicity
const form = reactive({
  name: props.product.name || '',
  slug: props.product.slug || '',
  price_range: props.product.price_range || '',
  image_primary: null,
  thumbnails: [],
  rating: props.product.rating || 0,
  description_short: props.product.description_short || '',
  description_long: props.product.description_long || '',
  additional_info: props.product.additional_info || {
    size: '',
    brand: '',
    dietary_and_lifestyle: ''
  },
  categories: safeArray(props.product.categories),
  tags: safeArray(props.product.tags),
  sizes: safeArray(props.product.sizes),
})

// Current images for display
const currentPrimaryImage = ref(props.product.image_primary || '')
const currentThumbnails = ref(safeArray(props.product.thumbnails))

// Inputs for comma-separated values
const categoriesInput = ref(form.categories.join(', '))
const tagsInput = ref(form.tags.join(', '))
const sizesInput = ref(form.sizes.join(', '))

// File handlers
const handlePrimaryImage = (event) => {
  const file = event.target.files[0]
  if (file) {
    form.image_primary = file
  }
}

const handleThumbnails = (event) => {
  const files = Array.from(event.target.files)
  if (files.length > 0) {
    form.thumbnails = files
  }
}

// Parsers for comma-separated inputs
const parseCategories = () => {
  form.categories = categoriesInput.value.split(',').map(s => s.trim()).filter(Boolean)
}

const parseTags = () => {
  form.tags = tagsInput.value.split(',').map(s => s.trim()).filter(Boolean)
}

const parseSizes = () => {
  form.sizes = sizesInput.value.split(',').map(s => s.trim()).filter(Boolean)
}

// Auto-generate slug
const generateSlug = () => {
  form.slug = form.name.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '')
}

// Submit function
const submit = () => {
  // Parse the comma-separated inputs
  parseCategories()
  parseTags()
  parseSizes()

  // Create FormData for file upload
  const formData = new FormData()

  // Append all fields
  formData.append('name', form.name)
  formData.append('slug', form.slug)
  formData.append('price_range', form.price_range)
  formData.append('rating', form.rating)
  formData.append('description_short', form.description_short)
  formData.append('description_long', form.description_long)

  // Handle additional_info
  formData.append('additional_info[size]', form.additional_info.size || '')
  formData.append('additional_info[brand]', form.additional_info.brand || '')
  formData.append('additional_info[dietary_and_lifestyle]', form.additional_info.dietary_and_lifestyle || '')

  // Handle arrays
  form.categories.forEach((cat, index) => {
    formData.append(`categories[${index}]`, cat)
  })

  form.tags.forEach((tag, index) => {
    formData.append(`tags[${index}]`, tag)
  })

  form.sizes.forEach((size, index) => {
    formData.append(`sizes[${index}]`, size)
  })

  // Handle files - only if new ones are selected
  if (form.image_primary) {
    formData.append('image_primary', form.image_primary)
  }

  if (form.thumbnails.length > 0) {
    form.thumbnails.forEach((thumb, index) => {
      formData.append(`thumbnails[${index}]`, thumb)
    })
  }

  // Use POST with _method=PUT for file uploads
  router.post(`/admin/products/${props.product.id}`, {
    _method: 'PUT',
    ...Object.fromEntries(formData)
  }, {
    forceFormData: true
  })
}
</script>