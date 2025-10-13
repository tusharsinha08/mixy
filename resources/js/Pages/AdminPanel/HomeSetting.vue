<template>
  <div class="max-w-7xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">🏠 Home Settings</h1>

    <form @submit.prevent="save" class="space-y-8">
      <!-- TOPBAR -->
      <section class="bg-white shadow rounded-xl p-6">
        <h2 class="text-lg font-semibold mb-4">🔝 Top Bar</h2>
        <div class="grid md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium mb-1">Topbar Text</label>
            <input v-model="form.topbar_text" type="text" class="input" />
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Topbar Phone</label>
            <input v-model="form.topbar_phone" type="text" class="input" />
          </div>
        </div>
      </section>

      <!-- LOGO & HERO IMAGE -->
      <section class="bg-white shadow rounded-xl p-6">
        <h2 class="text-lg font-semibold mb-4">🖼️ Images</h2>
        <div class="grid md:grid-cols-3 gap-4 items-center">
          <div>
            <label class="block text-sm font-medium mb-1">Logo</label>
            <input type="file" @change="onFileChange($event, 'logo')" />
            <img v-if="preview.logo || form.logo" :src="preview.logo || form.logo" class="h-16 mt-3 rounded" />
          </div>

          <div>
            <label class="block text-sm font-medium mb-1">Hero Image</label>
            <input type="file" @change="onFileChange($event, 'hero_image')" />
            <img v-if="preview.hero_image || form.hero_image" :src="preview.hero_image || form.hero_image"
              class="h-24 mt-3 rounded" />
          </div>

          <div>
            <label class="block text-sm font-medium mb-1">Hero Price</label>
            <input v-model="form.hero_price" type="text" class="input" />

            <label class="block text-sm font-medium mt-3 mb-1">Hero Title</label>
            <input v-model="form.hero_title" type="text" class="input" />

            <label class="block text-sm font-medium mt-3 mb-1">Hero Subtitle</label>
            <input v-model="form.hero_subtitle" type="text" class="input" />

            <label class="block text-sm font-medium mt-3 mb-1">Hero Button Text</label>
            <input v-model="form.hero_button_text" type="text" class="input" />
          </div>
        </div>
      </section>

      <!-- NAV LINKS -->
      <section class="bg-white shadow rounded-xl p-6">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-lg font-semibold">🔗 Navigation Links</h2>
          <button @click.prevent="addNav" class="btn-green">+ Add Link</button>
        </div>

        <draggable v-model="form.nav_links" handle=".drag-handle" item-key="id" class="space-y-3">
          <template #item="{ element, index }">
            <div class="relative border rounded p-3">
              <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                  <span class="drag-handle cursor-move text-gray-400">☰</span>
                  <div>
                    <label class="text-xs text-gray-600">Label</label>
                    <input v-model="element.label" class="input" />
                  </div>
                </div>
                <button @click.prevent="removeNav(index)" class="text-red-500">✕</button>
              </div>
              <label class="text-xs text-gray-600 mt-2">URL</label>
              <input v-model="element.url" class="input" />
            </div>
          </template>
        </draggable>
      </section>

      <!-- OFFER BANNERS -->
      <section class="bg-white shadow rounded-xl p-6">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-lg font-semibold">🎁 Offer Banners</h2>
          <button @click.prevent="addOfferBanner" class="btn-green">+ Add Banner</button>
        </div>

        <draggable v-model="form.offer_banners" handle=".drag-handle" item-key="id" class="space-y-3">
          <template #item="{ element, index }">
            <div class="relative border rounded p-3">
              <button @click.prevent="removeOfferBanner(index)" class="absolute top-2 right-2 text-red-500">✕</button>

              <div class="flex items-center gap-2 mb-2">
                <span class="drag-handle cursor-move text-gray-400">☰</span>
                <h3 class="font-medium text-gray-700">Banner {{ index + 1 }}</h3>
              </div>

              <label class="text-xs text-gray-600">Title</label>
              <input v-model="element.title" class="input" />

              <label class="text-xs text-gray-600 mt-2">Subtitle</label>
              <input v-model="element.subtitle" class="input" />

              <label class="text-xs text-gray-600 mt-2">Image URL</label>
              <input v-model="element.image" class="input" placeholder="/assets/images/banner.webp" />
            </div>
          </template>
        </draggable>
      </section>

      <!-- BEST SELLERS -->
      <section class="bg-white shadow rounded-xl p-6">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-lg font-semibold">🔥 Best Sellers</h2>
          <button @click.prevent="addBestSeller" class="btn-green">+ Add Product</button>
        </div>

        <draggable v-model="form.best_sellers" handle=".drag-handle" item-key="id" class="space-y-3">
          <template #item="{ element, index }">
            <div class="relative border rounded p-3">
              <button @click.prevent="removeBestSeller(index)" class="absolute top-2 right-2 text-red-500">✕</button>

              <div class="flex items-center gap-2 mb-2">
                <span class="drag-handle cursor-move text-gray-400">☰</span>
                <h3 class="font-medium text-gray-700">Product {{ index + 1 }}</h3>
              </div>

              <div class="grid md:grid-cols-2 gap-3">
                <div>
                  <label class="text-xs text-gray-600">Name</label>
                  <input v-model="element.name" class="input" />

                  <label class="text-xs text-gray-600 mt-2">Price Range</label>
                  <input v-model="element.price_range" class="input" />

                  <label class="text-xs text-gray-600 mt-2">Rating (1–5)</label>
                  <input v-model.number="element.rating" type="number" min="1" max="5" class="input" />
                </div>

                <div>
                  <label class="text-xs text-gray-600">Image URL</label>
                  <input v-model="element.image" class="input" placeholder="/uploads/bestsellers/honey.webp" />

                  <label class="text-xs text-gray-600 mt-2">Button Icon</label>
                  <input v-model="element.button_icon" class="input" placeholder="fas fa-shopping-bag" />
                </div>
              </div>
            </div>
          </template>
        </draggable>
      </section>

      <!-- DEALS SECTION -->
      <section class="bg-white shadow rounded-xl p-6">
        <h2 class="text-lg font-semibold mb-4">🔥 Super Deals</h2>
        <div v-for="(deal, index) in form.deals" :key="index" class="border rounded-lg p-4 mb-4 bg-gray-50">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="font-semibold text-sm">Name</label>
              <input v-model="deal.name" type="text" class="w-full border rounded p-2" />
            </div>
            <div>
              <label class="font-semibold text-sm">Price Range</label>
              <input v-model="deal.price_range" type="text" class="w-full border rounded p-2" />
            </div>
            <div>
              <label class="font-semibold text-sm">Sold</label>
              <input v-model="deal.sold" type="number" class="w-full border rounded p-2" />
            </div>
            <div>
              <label class="font-semibold text-sm">Available</label>
              <input v-model="deal.available" type="number" class="w-full border rounded p-2" />
            </div>
            <div>
              <label class="font-semibold text-sm">Progress (%)</label>
              <input v-model="deal.progress" type="number" class="w-full border rounded p-2" />
            </div>
            <div>
              <label class="font-semibold text-sm">Rating (1–5)</label>
              <input v-model="deal.rating" type="number" class="w-full border rounded p-2" />
            </div>
            <div class="col-span-2">
              <label class="font-semibold text-sm">Image URL</label>
              <input v-model="deal.image" type="text" class="w-full border rounded p-2" />
            </div>
          </div>
          <button @click="removeDeal(index)" class="mt-3 bg-red-500 text-white px-4 py-1 rounded">Remove</button>
        </div>
        <button @click="addDeal" class="bg-green-600 text-white px-4 py-2 rounded">+ Add Deal</button>
      </section>

      <!-- CARDS SECTION -->
      <section class="bg-white shadow rounded-xl p-6">
        <h2 class="text-lg font-semibold mb-4">🃏 3 Cards Section</h2>
        <div v-for="(card, index) in form.cards" :key="index" class="border rounded-lg p-4 mb-4 bg-gray-50">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="font-semibold text-sm">Title</label>
              <input v-model="card.title" type="text" class="w-full border rounded p-2" />
            </div>
            <div>
              <label class="font-semibold text-sm">Price</label>
              <input v-model="card.price" type="text" class="w-full border rounded p-2" />
            </div>
            <div>
              <label class="font-semibold text-sm">Image URL</label>
              <input v-model="card.image" type="text" class="w-full border rounded p-2" />
            </div>
            <div>
              <label class="font-semibold text-sm">Button Text</label>
              <input v-model="card.button_text" type="text" class="w-full border rounded p-2" />
            </div>
            <div>
              <label class="font-semibold text-sm">Button Icon</label>
              <input v-model="card.button_icon" type="text" class="w-full border rounded p-2" />
            </div>
          </div>
          <button @click="removeCard(index)" class="mt-3 bg-red-500 text-white px-4 py-1 rounded">Remove</button>
        </div>
        <button @click="addCard" class="bg-green-600 text-white px-4 py-2 rounded">+ Add Card</button>
      </section>

      <!-- SAVE BUTTON -->
      <div class="flex justify-end">
        <button type="submit" class="btn-primary">💾 Save Settings</button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useForm } from '@inertiajs/vue3'
import Draggable from 'vuedraggable'
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css'
import AdminLayout from '@/Layouts/AdminLayout.vue'

defineOptions({ layout: AdminLayout })

const props = defineProps({
  settings: Object,
  bestSellers: Array,
  deals: Array,
  cards: Array,
  newArrivals: Array,
  banners: Array,
  categories: Array
})

function normalizeItem(item = {}) {
  return { id: item.id || Math.random().toString(36).substr(2, 9), ...item }
}

function safeParseJSON(value) {
  if (!value) return value
  if (typeof value === 'string') {
    try { return JSON.parse(value) } catch { return value }
  }
  return value
}

const defaultSettings = (s = {}) => {
  const nav_links = safeParseJSON(s.nav_links) || []
  const offer_banners = safeParseJSON(s.offer_banners) || []
  const new_arrivals = safeParseJSON(s.new_arrivals) || []
  const cards = safeParseJSON(s.cards) || []
  const banners = safeParseJSON(s.banners) || []
  const categories = safeParseJSON(s.categories) || []
  const newsletter = safeParseJSON(s.newsletter) || { title: '', subtitle: '', placeholder: '', button_text: 'Subscribe' }
  const footer = safeParseJSON(s.footer) || { text: '', blocks: [] }
  const icons = safeParseJSON(s.icons) || {}

  return {
    topbar_text: s.topbar_text || '',
    topbar_phone: s.topbar_phone || '',
    logo: s.logo || '',
    hero_title: s.hero_title || '',
    hero_subtitle: s.hero_subtitle || '',
    hero_price: s.hero_price || '',
    hero_image: s.hero_image || '',
    hero_button_text: s.hero_button_text || 'Shop Now',
    nav_links: nav_links.map(normalizeItem),
    offer_banners: offer_banners.map(normalizeItem),
    new_arrivals: new_arrivals.map(normalizeItem),
    cards: cards.map(normalizeItem),
    banners: banners.map(normalizeItem),
    categories: categories.map(normalizeItem),
    newsletter,
    footer,
    icons,
  }
}

const initial = defaultSettings(props.settings || {})
initial.footer.blocks = (initial.footer.blocks || []).map(b => ({
  title: b.title || '',
  links_json: JSON.stringify(safeParseJSON(b.links) || [], null, 2),
}))

const form = useForm({
  ...initial,
  best_sellers: props.bestSellers || [],
  deals: props.deals || [],
  cards: props.cards || [],
  new_arrivals: props.newArrivals || [],
  banners: props.banners || [],
})

const preview = ref({ logo: null, hero_image: null })
const onFileChange = (e, field) => {
  const file = e.target.files?.[0]; if (!file) return
  form[field] = file
  preview.value[field] = URL.createObjectURL(file)
}

/* Add/Remove Helpers */
const addNav = () => form.nav_links.push(normalizeItem({ label: '', url: '' }))
const removeNav = i => form.nav_links.splice(i, 1)

const addOfferBanner = () => form.offer_banners.push(normalizeItem({ title: '', subtitle: '', image: '' }))
const removeOfferBanner = i => form.offer_banners.splice(i, 1)

const addBestSeller = () => form.best_sellers.push(normalizeItem({ name: '', price_range: '', image: '', rating: 5, button_icon: 'fas fa-shopping-bag' }))
const removeBestSeller = i => form.best_sellers.splice(i, 1)

const addDeal = () => form.deals.push(normalizeItem({ name: '', price_range: '', image: '', sold: 0, available: 0, progress: 0, rating: 5 }))
const removeDeal = i => form.deals.splice(i, 1)

const addCard = () => form.cards.push(normalizeItem({ title: '', price: '', image: '', button_text: 'Shop Now', button_icon: 'fas fa-arrow-right' }))
const removeCard = i => form.cards.splice(i, 1)

/* ICONS JSON */
const iconsText = ref(JSON.stringify(form.icons || {}, null, 2))
watch(iconsText, v => { try { form.icons = JSON.parse(v) } catch {} })

/* Save */
const save = () => {
  try { JSON.parse(iconsText.value) } catch { alert('Icons JSON is invalid.'); return }
  const payload = { ...form }
  form.post(route('admin.home-settings.update'), { forceFormData: true, preserveScroll: true, onBefore: () => Object.assign(form, payload) })
}
</script>

<style scoped>
.input { @apply w-full border rounded px-3 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-emerald-500; }
.btn-primary { @apply bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-6 py-2 rounded shadow; }
.btn-green { @apply bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded; }
</style>
