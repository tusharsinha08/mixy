<template>
  <AdminLayout>
    <div class="p-6 max-w-2xl mx-auto">
      <h1 class="text-2xl font-bold mb-4">Add New Product</h1>

      <form @submit.prevent="submit" class="space-y-4" enctype="multipart/form-data">

        <!-- Name -->
        <div>
          <label class="block mb-1 font-semibold">Product Name</label>
          <input type="text" v-model="form.name" @input="generateSlug" class="w-full border px-2 py-1 rounded" />
          <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</div>
        </div>

        <!-- Slug -->
        <div>
          <label class="block mb-1 font-semibold">Slug</label>
          <input type="text" v-model="form.slug" class="w-full border px-2 py-1 rounded" />
          <div v-if="form.errors.slug" class="text-red-500 text-sm mt-1">{{ form.errors.slug }}</div>
        </div>

        <!-- Price Range -->
        <div>
          <label class="block mb-1 font-semibold">Price Range</label>
          <input type="text" v-model="form.price_range" class="w-full border px-2 py-1 rounded" />
          <div v-if="form.errors.price_range" class="text-red-500 text-sm mt-1">{{ form.errors.price_range }}</div>
        </div>

        <!-- Primary Image Upload -->
        <div>
          <label class="block mb-1 font-semibold">Primary Image</label>
          <input type="file" @change="handlePrimaryImage" accept="image/*" class="w-full border px-2 py-1 rounded" />
          <div v-if="form.errors.image_primary" class="text-red-500 text-sm mt-1">{{ form.errors.image_primary }}</div>

          <!-- Image Preview -->
          <div v-if="primaryImagePreview" class="mt-2">
            <p class="text-sm text-gray-600 mb-1">Preview:</p>
            <img :src="primaryImagePreview" class="h-32 object-cover rounded border" />
          </div>
        </div>

        <!-- Thumbnails Upload -->
        <div>
          <label class="block mb-1 font-semibold">Thumbnails</label>
          <input type="file" multiple @change="handleThumbnails" accept="image/*"
            class="w-full border px-2 py-1 rounded" />
          <div v-if="form.errors.thumbnails" class="text-red-500 text-sm mt-1">{{ form.errors.thumbnails }}</div>

          <!-- Thumbnails Preview -->
          <div v-if="thumbnailsPreviews.length" class="mt-2">
            <p class="text-sm text-gray-600 mb-1">Thumbnails Preview:</p>
            <div class="flex flex-wrap gap-2">
              <div v-for="(thumb, index) in thumbnailsPreviews" :key="index" class="relative">
                <img :src="thumb" class="h-20 w-20 object-cover rounded border" />
                <button type="button" @click="removeThumbnail(index)"
                  class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 text-xs flex items-center justify-center">
                  ×
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Rating -->
        <div>
          <label class="block mb-1 font-semibold">Rating (0-5)</label>
          <input type="number" v-model.number="form.rating" min="0" max="5" class="w-full border px-2 py-1 rounded" />
          <div v-if="form.errors.rating" class="text-red-500 text-sm mt-1">{{ form.errors.rating }}</div>
        </div>

        <!-- Short Description -->
        <div>
          <label class="block mb-1 font-semibold">Short Description</label>
          <textarea v-model="form.description_short" class="w-full border px-2 py-1 rounded"></textarea>
          <div v-if="form.errors.description_short" class="text-red-500 text-sm mt-1">{{ form.errors.description_short
            }}</div>
        </div>

        <!-- Long Description -->
        <div>
          <label class="block mb-1 font-semibold">Long Description</label>
          <textarea v-model="form.description_long" class="w-full border px-2 py-1 rounded"></textarea>
          <div v-if="form.errors.description_long" class="text-red-500 text-sm mt-1">{{ form.errors.description_long }}
          </div>
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
          <input type="text" v-model="categoriesInput" @blur="parseCategories" placeholder="Fruits,Snacks"
            class="w-full border px-2 py-1 rounded" />
          <div v-if="form.errors.categories" class="text-red-500 text-sm mt-1">{{ form.errors.categories }}</div>
        </div>

        <!-- Categories for homepage -->
        <div>
          <label class="block mb-1 font-semibold">Categories For Homepage (comma separated)</label>
          <input type="text" v-model="categoriesForHomepageInput" @blur="parseCategoriesForHomepage"
            placeholder="new_arrival,popular" class="w-full border px-2 py-1 rounded" />
          <div v-if="form.errors.categories_for_homepage" class="text-red-500 text-sm mt-1">{{
            form.errors.categories_for_homepage }}</div>
        </div>

        <!-- Tags -->
        <div>
          <label class="block mb-1 font-semibold">Tags (comma separated)</label>
          <input type="text" v-model="tagsInput" @blur="parseTags" placeholder="Organic,Healthy"
            class="w-full border px-2 py-1 rounded" />
          <div v-if="form.errors.tags" class="text-red-500 text-sm mt-1">{{ form.errors.tags }}</div>
        </div>

        <!-- Sizes -->
        <div>
          <label class="block mb-1 font-semibold">Sizes (comma separated)</label>
          <input type="text" v-model="sizesInput" @blur="parseSizes" placeholder="S,M,L"
            class="w-full border px-2 py-1 rounded" />
          <div v-if="form.errors.sizes" class="text-red-500 text-sm mt-1">{{ form.errors.sizes }}</div>
        </div>

        <!-- Submit Button -->
        <div>
          <button type="submit" :disabled="form.processing"
            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 disabled:bg-green-400 disabled:cursor-not-allowed">
            <span v-if="form.processing">Saving...</span>
            <span v-else>Save Product</span>
          </button>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const form = useForm({
  name: '',
  slug: '',
  price_range: '',
  image_primary: null, // Changed from string to null for file
  thumbnails: [], // Will store files
  rating: 0,
  description_short: '',
  description_long: '',
  additional_info: {
    size: '',
    brand: '',
    dietary_and_lifestyle: ''
  },
  categories: [],
  categories_for_homepage: [],
  tags: [],
  sizes: [],
})

// Preview images
const primaryImagePreview = ref('')
const thumbnailsPreviews = ref([])

// Temporary inputs for comma-separated fields
const categoriesInput = ref('')
const categoriesForHomepageInput = ref('')
const tagsInput = ref('')
const sizesInput = ref('')

// Handle primary image selection
const handlePrimaryImage = (event) => {
  const file = event.target.files[0]
  if (file) {
    form.image_primary = file

    // Create preview
    const reader = new FileReader()
    reader.onload = (e) => {
      primaryImagePreview.value = e.target.result
    }
    reader.readAsDataURL(file)
  }
}

// Handle multiple thumbnails selection
const handleThumbnails = (event) => {
  const files = Array.from(event.target.files)
  files.forEach(file => {
    if (file) {
      // Add to form data
      if (!form.thumbnails) form.thumbnails = []
      form.thumbnails.push(file)

      // Create preview
      const reader = new FileReader()
      reader.onload = (e) => {
        thumbnailsPreviews.value.push(e.target.result)
      }
      reader.readAsDataURL(file)
    }
  })
}

// Remove thumbnail
const removeThumbnail = (index) => {
  form.thumbnails.splice(index, 1)
  thumbnailsPreviews.value.splice(index, 1)
}

// Parse comma-separated fields
const parseCategories = () => {
  form.categories = categoriesInput.value.split(',').map(s => s.trim()).filter(Boolean)
}

const parseCategoriesForHomepage = () => {
  form.categories_for_homepage = categoriesForHomepageInput.value.split(',').map(s => s.trim()).filter(Boolean)
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

// Submit form
const submit = () => {
  // Use form data for file uploads
  const formData = new FormData()

  // Append all form fields
  Object.keys(form.data()).forEach(key => {
    if (key === 'image_primary' && form.image_primary) {
      formData.append('image_primary', form.image_primary)
    } else if (key === 'thumbnails' && form.thumbnails.length) {
      form.thumbnails.forEach((thumb, index) => {
        formData.append(`thumbnails[${index}]`, thumb)
      })
    } else if (key === 'additional_info') {
      formData.append('additional_info[size]', form.additional_info.size)
      formData.append('additional_info[brand]', form.additional_info.brand)
      formData.append('additional_info[dietary_and_lifestyle]', form.additional_info.dietary_and_lifestyle)
    } else if (Array.isArray(form[key])) {
      form[key].forEach((item, index) => {
        formData.append(`${key}[${index}]`, item)
      })
    } else {
      formData.append(key, form[key])
    }
  })

  // Submit using Inertia
  form.transform((data) => formData).post('/admin/products', {
    onSuccess: () => {
      form.reset()
      primaryImagePreview.value = ''
      thumbnailsPreviews.value = []
      categoriesInput.value = ''
      categoriesForHomepageInput.value = ''
      tagsInput.value = ''
      sizesInput.value = ''
    }
  })
}
</script>