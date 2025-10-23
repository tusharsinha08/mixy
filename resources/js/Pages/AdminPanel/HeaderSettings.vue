<template>
  <div v-if="formData" class="p-6 space-y-6">
    <h1 class="text-3xl font-bold">Header Settings</h1>

    <!-- Topbar Section -->
    <section class="p-6 bg-white rounded-lg shadow">
      <h2 class="mb-4 text-xl font-semibold">Topbar Settings</h2>
      
      <div class="space-y-4">
        <div>
          <label class="block mb-2 font-medium text-gray-700">Topbar Text</label>
          <textarea
            v-model="formData.topbar_text"
            placeholder="Free shipping on orders over $25."
            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
            rows="2"
          ></textarea>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
          <div>
            <label class="block mb-2 font-medium text-gray-700">Help Text</label>
            <input
              v-model="formData.topbar_help_text"
              placeholder="Need help? Call Us:"
              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
            />
          </div>

          <div>
            <label class="block mb-2 font-medium text-gray-700">Phone Number</label>
            <input
              v-model="formData.topbar_phone"
              placeholder="888554168"
              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
            />
          </div>
        </div>
      </div>
    </section>

    <!-- Logo Section -->
    <section class="p-6 bg-white rounded-lg shadow">
      <h2 class="mb-4 text-xl font-semibold">Logo Settings</h2>
      
      <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <div>
          <label class="block mb-2 font-medium text-gray-700">Logo Image</label>
          <input
            type="file"
            accept="image/*"
            @change="onLogoUpload"
            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
          />
          <p class="mt-1 text-sm text-gray-500">Choose a logo image file</p>
          <div v-if="formData.logo" class="mt-2">
            <p class="mb-2 text-sm text-gray-600">Preview:</p>
            <img :src="formData.logo" alt="Logo Preview" class="h-12">
          </div>
        </div>

        <div>
          <label class="block mb-2 font-medium text-gray-700">Logo URL</label>
          <input
            v-model="formData.logo_url"
            placeholder="/"
            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
          />
        </div>
      </div>
    </section>

    <!-- Search Section -->
    <section class="p-6 bg-white rounded-lg shadow">
      <h2 class="mb-4 text-xl font-semibold">Search Settings</h2>
      
      <div>
        <label class="block mb-2 font-medium text-gray-700">Search Placeholder</label>
        <input
          v-model="formData.search_placeholder"
          placeholder="Search product..."
          class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
        />
      </div>
    </section>

    <!-- Icons Section -->
    <section class="p-6 bg-white rounded-lg shadow">
      <h2 class="mb-4 text-xl font-semibold">Icon Settings</h2>
      
      <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        <div>
          <label class="block mb-2 font-medium text-gray-700">User Icon</label>
          <div class="flex gap-2">
            <input
              v-model="formData.icon_user"
              placeholder="fas fa-user"
              class="flex-1 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
            />
            <button
              @click="openIconHelper('user')"
              class="px-4 py-3 text-white bg-blue-600 rounded-lg hover:bg-blue-700"
              type="button"
              title="Icon Helper"
            >
              <i class="fas fa-question"></i>
            </button>
          </div>
          <div v-if="formData.icon_user" class="mt-2 flex items-center gap-2">
            <span class="text-sm text-gray-600">Preview:</span>
            <i :class="formData.icon_user" class="text-lg text-gray-700"></i>
          </div>
        </div>

        <div>
          <label class="block mb-2 font-medium text-gray-700">Wishlist Icon</label>
          <div class="flex gap-2">
            <input
              v-model="formData.icon_wishlist"
              placeholder="fas fa-heart"
              class="flex-1 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
            />
            <button
              @click="openIconHelper('wishlist')"
              class="px-4 py-3 text-white bg-blue-600 rounded-lg hover:bg-blue-700"
              type="button"
              title="Icon Helper"
            >
              <i class="fas fa-question"></i>
            </button>
          </div>
          <div v-if="formData.icon_wishlist" class="mt-2 flex items-center gap-2">
            <span class="text-sm text-gray-600">Preview:</span>
            <i :class="formData.icon_wishlist" class="text-lg text-gray-700"></i>
          </div>
        </div>

        <div>
          <label class="block mb-2 font-medium text-gray-700">Cart Icon</label>
          <div class="flex gap-2">
            <input
              v-model="formData.icon_cart"
              placeholder="fas fa-shopping-bag"
              class="flex-1 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
            />
            <button
              @click="openIconHelper('cart')"
              class="px-4 py-3 text-white bg-blue-600 rounded-lg hover:bg-blue-700"
              type="button"
              title="Icon Helper"
            >
              <i class="fas fa-question"></i>
            </button>
          </div>
          <div v-if="formData.icon_cart" class="mt-2 flex items-center gap-2">
            <span class="text-sm text-gray-600">Preview:</span>
            <i :class="formData.icon_cart" class="text-lg text-gray-700"></i>
          </div>
        </div>
      </div>
      

    </section>

    <!-- Navigation Links -->
    <section class="p-6 bg-white rounded-lg shadow">
      <h2 class="mb-4 text-xl font-semibold">Navigation Links</h2>
      
      <div v-for="(link, index) in formData.nav_links" :key="index" class="p-4 mb-4 border border-gray-200 rounded-lg">
        <div class="flex items-center justify-between mb-3">
          <h3 class="font-medium text-gray-700">Link {{ index + 1 }}</h3>
          <button
            @click="removeNavLink(index)"
            class="p-2 text-red-600 hover:text-red-800"
            type="button"
          >
            <i class="fas fa-trash"></i>
          </button>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
          <div>
            <label class="block mb-2 text-sm font-medium text-gray-700">Label</label>
            <input
              v-model="link.label"
              placeholder="Home"
              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
            />
          </div>

          <div>
            <label class="block mb-2 text-sm font-medium text-gray-700">URL</label>
            <input
              v-model="link.url"
              placeholder="/"
              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
            />
          </div>
        </div>
      </div>

      <button
        @click="addNavLink"
        class="px-4 py-2 text-white bg-green-600 rounded-lg hover:bg-green-700"
        type="button"
      >
        + Add Navigation Link
      </button>
    </section>

    <!-- Save Button -->
    <div class="flex justify-end pt-6 mt-6 border-t">
      <button
        @click="saveHeaderSettings"
        class="px-6 py-3 text-white bg-green-600 rounded-lg hover:bg-green-700"
      >
        Save Header Settings
      </button>
    </div>

    <!-- Icon Helper Modal -->
    <div v-if="showIconHelper" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
      <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-96 overflow-hidden">
        <div class="flex items-center justify-between p-4 border-b">
          <h3 class="text-lg font-semibold">Icon Helper</h3>
          <button @click="closeIconHelper" class="text-gray-500 hover:text-gray-700">
            <i class="fas fa-times"></i>
          </button>
        </div>
        
        <div class="p-4">
          <div class="mb-4">
            <h4 class="font-medium text-gray-700 mb-2">Common Icon Examples:</h4>
            <div class="grid grid-cols-3 gap-2 text-sm">
              <button
                v-for="icon in commonIcons"
                :key="icon.class"
                @click="selectCommonIcon(icon.class)"
                class="p-2 text-left border border-gray-200 rounded hover:bg-gray-50"
              >
                <i :class="icon.class" class="mr-2"></i>
                {{ icon.name }}
              </button>
            </div>
          </div>
          
         
        </div>
        
        <div class="flex justify-between p-4 border-t">
          <div class="text-sm text-gray-600">
            Enter any valid CSS class in the input field
          </div>
          <button
            @click="closeIconHelper"
            class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700"
          >
            Got it
          </button>
        </div>
      </div>
    </div>
  </div>

  <div v-else class="p-6 text-center text-gray-500">Loading...</div>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'

defineOptions({ layout: AdminLayout })

const props = defineProps({
  headerSettings: {
    type: Object,
    default: () => ({})
  }
})

const formData = ref({
  topbar_text: props.headerSettings?.topbar_text || 'Free shipping on orders over $25.',
  topbar_help_text: props.headerSettings?.topbar_help_text || 'Need help? Call Us:',
  topbar_phone: props.headerSettings?.topbar_phone || '888554168',
  logo: props.headerSettings?.logo || '/assets/images/logo.png',
  logo_url: props.headerSettings?.logo_url || '/',
  search_placeholder: props.headerSettings?.search_placeholder || 'Search product...',
  icon_user: props.headerSettings?.icon_user || 'fas fa-user',
  icon_wishlist: props.headerSettings?.icon_wishlist || 'fas fa-heart',
  icon_cart: props.headerSettings?.icon_cart || 'fas fa-shopping-bag',
  nav_links: props.headerSettings?.nav_links || [
    { label: 'Home', url: '/' },
    { label: 'Shop', url: '/shop' },
    { label: 'About Us', url: '/about-us' },
    { label: 'Contact Us', url: '/contact-us' }
  ]
})

// Icon helper state
const showIconHelper = ref(false)
const currentIconField = ref('')

// Just a few common examples for guidance
const commonIcons = [
  { class: 'fas fa-user', name: 'User' },
  { class: 'fas fa-heart', name: 'Heart' },
  { class: 'fas fa-shopping-cart', name: 'Cart' },
  { class: 'fas fa-search', name: 'Search' },
  { class: 'fas fa-home', name: 'Home' },
  { class: 'fas fa-star', name: 'Star' },
  { class: 'fas fa-envelope', name: 'Envelope' },
  { class: 'fas fa-phone', name: 'Phone' },
  { class: 'fas fa-shopping-bag', name: 'Bag' },
  { class: 'fas fa-bell', name: 'Bell' },
  { class: 'fas fa-cog', name: 'Settings' },
  { class: 'fas fa-info-circle', name: 'Info' }
]

const addNavLink = () => {
  formData.value.nav_links.push({ label: '', url: '' })
}

const removeNavLink = (index) => {
  formData.value.nav_links.splice(index, 1)
}

const onLogoUpload = (event) => {
  const file = event.target.files[0]
  if (file) {
    const reader = new FileReader()
    reader.onload = e => {
      formData.value.logo = e.target.result
    }
    reader.readAsDataURL(file)
  }
}

const openIconHelper = (field) => {
  currentIconField.value = field
  showIconHelper.value = true
}

const closeIconHelper = () => {
  showIconHelper.value = false
  currentIconField.value = ''
}

const selectCommonIcon = (iconClass) => {
  formData.value[`icon_${currentIconField.value}`] = iconClass
}
const saveHeaderSettings = () => {
    router.post('/admin/header-settings/update', formData.value, {
        onSuccess: () => {
            alert('Header settings updated successfully!')
            router.reload() 
        }
    })
}

</script>