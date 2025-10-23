<template>
  <div v-if="blink" class="fixed inset-0 bg-white opacity-80 z-[9999] animate-fade"></div>

  <div class="max-w-7xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">🏠 Home Settings</h1>

    <form @submit.prevent="save" class="space-y-8">
      <!-- 🖼️ IMAGES -->
      <section class="bg-white shadow rounded-xl p-6">
        <h2 class="text-lg font-semibold mb-4">🖼️ Hero Images</h2>
        <div class="grid md:grid-cols-2 gap-4 items-center">
          

          <div>
            <label class="block text-sm font-medium mb-1">Hero Image</label>
            <input type="file" @change="onFileChange($event, 'hero_image')" />
            <img v-if="preview.hero_image || form.hero_image" :src="preview.hero_image || form.hero_image"
              class="h-20 mt-3 rounded" />
          </div>

          <div>
            <label class="block text-sm font-medium mt-3 mb-1">Hero Price</label>
            <input v-model="form.hero_price" type="text" class="input" />

            <label class="block text-sm font-medium mt-3 mb-1">Hero Title</label>
            <input v-model="form.hero_title" type="text" class="input" />

            <label class="block text-sm font-medium mt-3 mb-1">Hero Subtitle</label>
            <input v-model="form.hero_subtitle" type="text" class="input" />

            <label class="block text-sm font-medium mt-3 mb-1">Hero Button Text</label>
            <input v-model="form.hero_button_text" type="text" class="input" />
          </div>
        </div>

        <div class="flex justify-end mt-4">
          <button type="button" @click="saveSection('images')" class="btn-primary" :disabled="form.processing">
            <span v-if="form.processing">Saving...</span><span v-else>Save Hero Section</span>
          </button>
        </div>
      </section>



      <!-- BEST SELLERS SECTION -->
      <section class="bg-white shadow rounded-xl p-4">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-lg font-semibold">🏆 Best Sellers</h2>
          <button @click.prevent="addBestSeller" class="btn-green">+ Add Product</button>
        </div>

        <draggable v-model="form.best_sellers" handle=".drag-handle" item-key="id"
          class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <template #item="{ element, index }">
            <div class="relative border rounded-xl p-3 flex flex-col bg-gray-50">
              <button @click.prevent="removeBestSeller(index)"
                class="absolute top-2 right-2 text-red-500 font-bold">✕</button>

              <div class="flex items-center gap-2 mb-2">
                <span class="drag-handle cursor-move text-gray-400">☰</span>
                <h3 class="font-medium text-gray-700">Product {{ index + 1 }}</h3>
              </div>

              <!-- Product Selection -->
              <label class="text-xs text-gray-600 mb-1">Select Product</label>
              <select v-model="element.product_id" class="border p-2 rounded w-full">
                <option value="">Select Product</option>
                <option v-for="product in props.products" :key="product.id" :value="product.id">
                  {{ product.name }} - ${{ product.price_range }}
                </option>
              </select>

              <!-- Show selected product info -->
              <div v-if="element.product_id" class="mt-2 p-2 bg-green-50 rounded text-xs">
                <p class="text-green-700 font-semibold">Selected: {{ getProductName(element.product_id) }}</p>
                <p class="text-gray-600">Price: ${{ getProductPrice(element.product_id) }}</p>
              </div>

              <!-- Custom Title -->
              <label class="text-xs text-gray-600 mt-3 mb-1">Custom Title (optional)</label>
              <input v-model="element.bs_title" type="text" class="input" placeholder="Override product title" />

              <!-- Custom Subtitle -->
              <label class="text-xs text-gray-600 mt-2 mb-1">Custom Subtitle (optional)</label>
              <input v-model="element.bs_subtitle" type="text" class="input" placeholder="Override product subtitle" />

              <!-- Status Toggle -->
              <div class="flex items-center mt-3">
                <label class="flex items-center cursor-pointer">
                  <div class="relative">
                    <input type="checkbox" v-model="element.status" class="sr-only" />
                    <div class="block bg-gray-600 w-10 h-6 rounded-full"></div>
                    <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition transform"
                      :class="{ 'translate-x-4 bg-green-400': element.status }"></div>
                  </div>
                  <div class="ml-3 text-xs font-medium text-gray-700">
                    {{ element.status ? 'Active' : 'Inactive' }}
                  </div>
                </label>
              </div>

              <!-- Debug info -->
              <div v-if="element.product_id" class="mt-2 p-2 bg-blue-50 rounded text-xs">
                <p><strong>Product ID:</strong> {{ element.product_id }}</p>
                <p><strong>Product Name:</strong> {{ getProductName(element.product_id) }}</p>
                <p><strong>Custom Title:</strong> {{ element.bs_title || 'Not set' }}</p>
                <p><strong>Status:</strong> {{ element.status ? 'Active' : 'Inactive' }}</p>
              </div>
            </div>
          </template>
        </draggable>

        <div class="flex justify-end mt-4">
          <button type="button" @click="saveSection('best_sellers')" class="btn-primary" :disabled="form.processing">
            <span v-if="form.processing">Saving...</span>
            <span v-else>Save Best Sellers</span>
          </button>
        </div>
      </section>

      <!-- New Arrivals SECTION -->
      <section class="bg-white shadow rounded-xl p-4">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-lg font-semibold">🆕 New Arrivals</h2>
          <button @click.prevent="addNewArrival" class="btn-green">+ Add Product</button>
        </div>

        <draggable v-model="form.new_arrivals" handle=".drag-handle" item-key="id"
          class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <template #item="{ element, index }">
            <div class="relative border rounded-xl p-3 flex flex-col bg-gray-50">
              <button @click.prevent="removeNewArrival(index)"
                class="absolute top-2 right-2 text-red-500 font-bold">✕</button>

              <div class="flex items-center gap-2 mb-2">
                <span class="drag-handle cursor-move text-gray-400">☰</span>
                <h3 class="font-medium text-gray-700">Product {{ index + 1 }}</h3>
              </div>

              <!-- Dropdown per item -->
              <label class="text-xs text-gray-600 mb-1">Select Product</label>
              <select v-model="element.product_id" class="border p-2 rounded w-full">
                <option value="">Select Product</option>
                <option v-for="product in props.products" :key="product.id" :value="product.id">
                  {{ product.name }} - {{ product.price_range }}
                </option>
              </select>

              <p v-if="element.product_id" class="text-green-600 text-sm mt-1">
                Selected: {{ getProductName(element.product_id) }}
              </p>

              <!-- Debug info -->
              <div v-if="element.product_id" class="mt-2 p-2 bg-blue-50 rounded text-xs">
                <p>Product ID: {{ element.product_id }}</p>
                <p>Product Name: {{ getProductName(element.product_id) }}</p>
              </div>
            </div>
          </template>
        </draggable>

        <div class="flex justify-end mt-4">
          <button type="button" @click="saveSection('new_arrivals')" class="btn-primary" :disabled="form.processing">
            <span v-if="form.processing">Saving...</span>
            <span v-else>Save New Arrivals</span>
          </button>
        </div>
      </section>

      <!-- 🎁 OFFER BANNERS -->
      <section class="bg-white shadow rounded-xl p-6">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-lg font-semibold">🎁 Offer Banners</h2>
          <button @click.prevent="addOfferBanner" class="btn-green">+ Add Banner</button>
        </div>

        <draggable v-model="form.offer_banners" handle=".drag-handle" item-key="id" class="space-y-3">
          <template #item="{ element, index }">
            <div class="relative border rounded p-3 bg-gray-50">
              <button @click.prevent="removeOfferBanner(index)"
                class="absolute top-2 right-2 text-red-500 text-lg leading-none">✕</button>
              <div class="flex items-center gap-2 mb-2">
                <span class="drag-handle cursor-move text-gray-400">☰</span>
                <h3 class="font-medium text-gray-700">Banner {{ index + 1 }}</h3>
              </div>
              <label class="text-xs text-gray-600">Title</label>
              <input v-model="element.title" class="input" />
              <label class="text-xs text-gray-600 mt-2">Subtitle</label>
              <input v-model="element.subtitle" class="input" />
              <label class="block text-sm font-medium mb-1">Image</label>
              <input type="file" @change="onFileChange($event, 'offer_banners', element.id)" class="input" />
              <img v-if="element && (preview.offer_banners[element.id] || element.image)"
                :src="preview.offer_banners[element.id] || element.image" class="h-20 mt-3 rounded" />

            </div>
          </template>
        </draggable>

        <div class="flex justify-end mt-4">
          <button type="button" @click="saveSection('offer_banners')" class="btn-primary" :disabled="form.processing">
            <span v-if="form.processing">Saving...</span><span v-else>Save Offer Banners</span>
          </button>
        </div>
      </section>

      <!-- Super deals -->
      <!-- Super deals -->
      <section class="bg-white shadow rounded-xl p-6">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-lg font-semibold">🔥 Super Deals</h2>
          <button @click="addDeal" class="btn-green">+ Add Deal</button>
        </div>

        <div v-for="(deal, index) in form.deals" :key="index" class="relative border rounded-lg p-4 mb-4 bg-gray-50">
          <button @click="removeDeal(index)" class="absolute top-2 right-2 text-red-500 text-lg leading-none">✕</button>

          <div class="flex items-center gap-2 mb-2">
            <span class="drag-handle cursor-move text-gray-400">☰</span>
            <h3 class="font-medium text-gray-700">Deal {{ index + 1 }}</h3>
          </div>

          <!-- Product Selection Dropdown -->
          <div class="mb-4">
            <label class="font-semibold text-sm">Select Product</label>
            <select v-model="deal.product_id" @change="onProductSelect(deal)" class="input">
              <option value="">Select a product</option>
              <option v-for="product in props.products" :key="product.id" :value="product.id">
                {{ product.name }} - {{ product.price_range }}
              </option>
            </select>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <!-- Auto-filled from product -->
            <div>
              <label class="font-semibold text-sm">Title (from product)</label>
              <input v-model="deal.name" type="text" class="input bg-gray-100" readonly />
            </div>
            <div>
              <label class="font-semibold text-sm">Price (from product)</label>
              <input v-model="deal.price_range" type="text" class="input bg-gray-100" readonly />
            </div>
            <div>
              <label class="font-semibold text-sm">Rating (from product)</label>
              <input v-model="deal.rating" type="number" class="input bg-gray-100" readonly />
            </div>
            <div class="col-span-2">
              <label class="font-semibold text-sm">Image (from product)</label>
              <img v-if="deal.image" :src="deal.image" class="h-20 mt-3 rounded" />
              <div v-else class="h-20 mt-3 bg-gray-200 rounded flex items-center justify-center text-gray-500">
                Select a product to show image
              </div>
            </div>

            <!-- Editable fields -->
            <div>
              <label class="font-semibold text-sm">Sold</label>
              <input v-model="deal.sold" type="number" class="input" />
            </div>
            <div>
              <label class="font-semibold text-sm">Available</label>
              <input v-model="deal.available" type="number" class="input" />
            </div>
            <div>
              <label class="font-semibold text-sm">Progress (%)</label>
              <input v-model="deal.progress" type="number" class="input" />
            </div>

            <!-- Simple Date Range Settings -->
            <div class="col-span-2 mt-4 p-4 bg-green-50 rounded-lg border border-green-200">
              <h4 class="font-bold text-green-800 mb-3">📅 Deal Date Range</h4>

              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label class="font-semibold text-sm text-green-700">Start Date & Time</label>
                  <input v-model="deal.start_date" type="datetime-local" class="input border-green-200" />
                  <p class="text-xs text-gray-500 mt-1">When the deal becomes active</p>
                </div>
                <div>
                  <label class="font-semibold text-sm text-green-700">End Date & Time</label>
                  <input v-model="deal.end_date" type="datetime-local" class="input border-green-200" />
                  <p class="text-xs text-gray-500 mt-1">When the deal expires</p>
                </div>
              </div>

              <!-- Status Toggle -->
              <div class="flex items-center justify-between mt-4">
                <div>
                  <label class="flex items-center cursor-pointer">
                    <div class="relative">
                      <input type="checkbox" v-model="deal.is_active" class="sr-only" />
                      <div class="block bg-gray-600 w-10 h-6 rounded-full"></div>
                      <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition transform"
                        :class="{ 'translate-x-4 bg-green-400': deal.is_active }"></div>
                    </div>
                    <div class="ml-3 text-sm font-medium text-gray-700">
                      {{ deal.is_active ? 'Deal Active' : 'Deal Inactive' }}
                    </div>
                  </label>
                </div>
              </div>

              <!-- LIVE COUNTDOWN PREVIEW IN ADMIN -->
              <div class="mt-3 p-3 bg-white rounded border">
                <label class="font-semibold text-sm text-gray-600 mb-2 block">Live Countdown Preview:</label>
                <div class="text-center">
                  <!-- Active Countdown -->
                  <div v-if="deal.countdown && !deal.countdown.expired && !deal.countdown.upcoming"
                    class="flex justify-center gap-2">
                    <div class="bg-gray-100 px-3 py-2 rounded-md text-center text-sm min-w-[60px]">
                      <div class="font-bold text-gray-900">{{ deal.countdown.hours }}</div>
                      <div class="text-gray-500 text-xs">Hours</div>
                    </div>
                    <div class="bg-gray-100 px-3 py-2 rounded-md text-center text-sm min-w-[60px]">
                      <div class="font-bold text-gray-900">{{ deal.countdown.minutes }}</div>
                      <div class="text-gray-500 text-xs">Mins</div>
                    </div>
                    <div class="bg-gray-100 px-3 py-2 rounded-md text-center text-sm min-w-[60px]">
                      <div class="font-bold text-gray-900">{{ deal.countdown.seconds }}</div>
                      <div class="text-gray-500 text-xs">Secs</div>
                    </div>
                  </div>

                  <!-- Expired Message -->
                  <div v-else-if="deal.countdown && deal.countdown.expired" class="text-center text-red-600 font-bold">
                    Offer Expired!
                  </div>

                  <!-- Not Started Yet -->
                  <div v-else-if="deal.countdown && deal.countdown.upcoming"
                    class="text-center text-blue-600 font-bold">
                    Starting soon!
                  </div>

                  <!-- No Dates Set -->
                  <div v-else class="text-center text-gray-500">
                    Set dates to see countdown preview
                  </div>
                </div>
              </div>

              <!-- Deal Status Preview -->
              <div class="mt-3 p-3 bg-white rounded border">
                <label class="font-semibold text-sm text-gray-600 mb-2 block">Deal Status:</label>
                <div class="text-center">
                  <div class="text-sm font-medium" :class="getDealStatus(deal).color">
                    {{ getDealStatus(deal).text }}
                  </div>
                  <div v-if="getDealStatus(deal).remaining" class="text-xs text-gray-500 mt-1">
                    {{ getDealStatus(deal).remaining }}
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Timer Text -->
          <div class="col-span-2 mt-4">
            <label class="font-semibold text-sm">Timer Display Text</label>
            <input v-model="deal.timer_text" type="text" class="input" placeholder="Hurry up! Offer ends in:" />
          </div>

          <!-- Debug Info -->
          <div class="mt-4 p-3 bg-gray-100 rounded text-xs text-gray-600">
            <p><strong>Product ID:</strong> {{ deal.product_id }}</p>
            <p><strong>Start:</strong> {{ deal.start_date || 'Not set' }}</p>
            <p><strong>End:</strong> {{ deal.end_date || 'Not set' }}</p>
            <p><strong>Status:</strong> {{ getDealStatus(deal).text }}</p>
            <p><strong>Active:</strong> {{ deal.is_active ? 'Yes' : 'No' }}</p>
          </div>
        </div>

        <div class="flex justify-end">
          <button type="button" @click="saveSection('deals')" class="btn-primary" :disabled="form.processing">
            <span v-if="form.processing">Saving...</span><span v-else>Save Deals</span>
          </button>
        </div>
      </section>

      <!-- CARDS SECTION -->
      <section class="bg-white shadow rounded-xl p-6">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-lg font-semibold">🃏 3 Cards Section</h2>
          <button @click.prevent="addCard" class="btn-green">+ Add Card</button>
        </div>

        <draggable v-model="form.cards" handle=".drag-handle" item-key="id" class="space-y-3">
          <template #item="{ element, index }">
            <div class="relative border rounded p-3 bg-gray-50">
              <button @click.prevent="removeCard(index)" class="absolute top-2 right-2 text-red-500">✕</button>

              <div class="flex items-center gap-2 mb-3">
                <span class="drag-handle cursor-move text-gray-400">☰</span>
                <h3 class="font-medium text-gray-700">Card {{ index + 1 }}</h3>
              </div>

              <div class="grid md:grid-cols-2 gap-3">
                <div>
                  <label class="text-xs text-gray-600">Title</label>
                  <input v-model="element.title" class="input" placeholder="Fresh Fruit Kiwis" />

                  <label class="text-xs text-gray-600 mt-2">Price</label>
                  <input v-model="element.price" class="input" placeholder="$39.99" />

                  <label class="text-xs text-gray-600 mt-2">Button URL</label>
                  <input v-model="element.button_url" class="input" placeholder="#" />
                </div>

                <div>
                  <label class="text-xs text-gray-600">Image</label>
                  <img v-if="preview.cards[element.id] || element.image"
                    :src="preview.cards[element.id] || element.image" class="h-20 mt-3 rounded" />
                  <input type="file" @change="onFileChange($event, 'cards', element.id)" class="input mt-2" />

                  <label class="text-xs text-gray-600 mt-2">Button Text</label>
                  <input v-model="element.button_text" class="input" placeholder="Shop Now" />

                  <label class="text-xs text-gray-600 mt-2">Button Icon</label>
                  <input v-model="element.button_icon" class="input" placeholder="fas fa-arrow-right" />
                </div>
              </div>
            </div>
          </template>
        </draggable>

        <div class="flex justify-end mt-4">
          <button type="button" @click="saveSection('cards')" class="btn-primary" :disabled="form.processing">
            <span v-if="form.processing">Saving...</span>
            <span v-else>Save Cards</span>
          </button>
        </div>
      </section>

      <!-- BANNERS (LEFT/RIGHT) -->
      <section class="bg-white shadow rounded-xl p-6">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-lg font-semibold"> Natural Product Banners</h2>
          <button @click.prevent="addBanner" class="btn-green">+ Add Banner</button>
        </div>

        <draggable v-model="form.banners" handle=".drag-handle" item-key="id" class="space-y-3">
          <template #item="{ element, index }">
            <div class="relative border rounded p-3 bg-gray-50">
              <button @click.prevent="removeBanner(index)" class="absolute top-2 right-2 text-red-500">✕</button>
              <div class="flex items-center gap-2 mb-3">
                <span class="drag-handle cursor-move text-gray-400">☰</span>
                <h3 class="font-medium text-gray-700">Banner {{ index + 1 }}</h3>
              </div>

              <div class="grid md:grid-cols-2 gap-3">
                <div>
                  <label class="text-xs text-gray-600">Position (left/right)</label>
                  <select v-model="element.position" class="input">
                    <option value="left">Left</option>
                    <option value="right">Right</option>
                  </select>

                  <label class="text-xs text-gray-600 mt-2">Title</label>
                  <input v-model="element.title" class="input" />

                  <label class="text-xs text-gray-600 mt-2">Subtitle</label>
                  <input v-model="element.subtitle" class="input" />
                </div>

                <div>
                  <label class="text-xs text-gray-600">Price</label>
                  <input v-model="element.price" class="input" />

                  <label class="text-xs text-gray-600">Image</label>
                  <img v-if="preview.banners[element.id] || element.image"
                    :src="preview.banners[element.id] || element.image" class="h-20 mt-2 rounded" />
                  <input type="file" @change="onFileChange($event, 'banners', element.id)" class="input mt-2" />
                </div>
              </div>
            </div>
          </template>
        </draggable>

        <div class="flex justify-end mt-4">
          <button type="button" @click="saveSection('banners')" class="btn-primary" :disabled="form.processing">
            <span v-if="form.processing">Saving...</span>
            <span v-else>Save Banners</span>
          </button>
        </div>
      </section>

      <!-- POPULAR CATEGORIES -->
      <section class="bg-white shadow rounded-xl p-6">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-lg font-semibold">Popular Categories</h2>
          <button @click.prevent="addCategory" class="btn-green">+ Add Category</button>
        </div>

        <draggable v-model="form.categories" handle=".drag-handle" item-key="id" class="space-y-3">
          <template #item="{ element, index }">
            <div class="relative border rounded p-3 bg-gray-50">
              <button @click.prevent="removeCategory(index)" class="absolute top-2 right-2 text-red-500">✕</button>
              <div class="flex items-center gap-2 mb-3">
                <span class="drag-handle cursor-move text-gray-400">☰</span>
                <h3 class="font-medium text-gray-700">Category {{ index + 1 }}</h3>
              </div>

              <div class="grid md:grid-cols-2 gap-3">
                <div>
                  <label class="text-xs text-gray-600">Name</label>
                  <input v-model="element.name" class="input" />

                  <label class="text-xs text-gray-600 mt-2">Product Count</label>
                  <input v-model.number="element.products" type="number" class="input" />
                </div>

                <div>
                  <label class="text-xs text-gray-600">Image</label>
                  <img v-if="preview.categories[element.id] || element.image"
                    :src="preview.categories[element.id] || element.image" class="h-24 mt-2 rounded" />
                  <input type="file" @change="onFileChange($event, 'categories', element.id)" class="input mt-2" />
                </div>

              </div>
            </div>
          </template>
        </draggable>

        <div class="flex justify-end mt-4">
          <button type="button" @click="saveSection('categories')" class="btn-primary" :disabled="form.processing">
            <span v-if="form.processing">Saving...</span>
            <span v-else>Save Categories</span>
          </button>
        </div>
      </section>

      <!-- NEWSLETTER -->
      <section class="bg-white shadow rounded-xl p-6">
        <h2 class="text-lg font-semibold mb-3">✉️ Newsletter</h2>

        <label class="text-xs text-gray-600">Title</label>
        <input v-model="form.newsletter.title" class="input" />

        <label class="text-xs text-gray-600 mt-2">Subtitle (rich text)</label>
        <QuillEditor v-model:content="form.newsletter.subtitle" theme="snow" content-type="html" />

        <div class="grid md:grid-cols-2 gap-3 mt-3">
          <div>
            <label class="text-xs text-gray-600">Placeholder</label>
            <input v-model="form.newsletter.placeholder" class="input" />
          </div>
          <div>
            <label class="text-xs text-gray-600">Button Text</label>
            <input v-model="form.newsletter.button_text" class="input" />
          </div>
        </div>

        <div class="flex justify-end mt-4">
          <button type="button" @click="saveSection('newsletter')" class="btn-primary" :disabled="form.processing">
            <span v-if="form.processing">Saving...</span>
            <span v-else>Save Newsletter</span>
          </button>
        </div>
      </section>

      <!-- 🛠️ SERVICES SECTION -->
<section class="bg-white shadow rounded-xl p-6">
  <div class="flex justify-between items-center mb-4">
    <h2 class="text-lg font-semibold">🛠️ Services Section</h2>
    <button @click.prevent="addService" class="btn-green">+ Add Service</button>
  </div>

  <draggable v-model="form.services" handle=".drag-handle" item-key="id" class="space-y-3">
    <template #item="{ element, index }">
      <div class="relative border rounded p-3 bg-gray-50">
        <button
          @click.prevent="removeService(index)"
          class="absolute top-2 right-2 text-red-500 text-lg leading-none"
        >
          ✕
        </button>

        <div class="flex items-center gap-2 mb-3">
          <span class="drag-handle cursor-move text-gray-400">☰</span>
          <h3 class="font-medium text-gray-700">Service {{ index + 1 }}</h3>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
          <div>
            <label class="text-xs text-gray-600">Icon Class</label>
            <div class="flex gap-2">
              <input
                v-model="element.icon"
                placeholder="fas fa-truck"
                class="flex-1 p-2 border border-gray-300 rounded focus:ring-2 focus:ring-green-500 focus:border-transparent"
              />
            </div>
            <div v-if="element.icon" class="mt-2 flex items-center gap-2">
              <span class="text-sm text-gray-600">Preview:</span>
              <i :class="element.icon" class="text-lg text-gray-700"></i>
            </div>

            <label class="text-xs text-gray-600 mt-3">Icon Color</label>
            <div class="flex gap-2">
              <input
                v-model="element.color"
                type="color"
                class="h-10 w-10 p-1 border border-gray-300 rounded cursor-pointer"
              />
              <input
                v-model="element.color"
                placeholder="#000000 or tailwind class"
                class="flex-1 p-2 border border-gray-300 rounded focus:ring-2 focus:ring-green-500 focus:border-transparent"
              />
            </div>
          </div>

          <div>
            <label class="text-xs text-gray-600">Title</label>
            <input
              v-model="element.title"
              placeholder="Free Shipping"
              class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-green-500 focus:border-transparent"
            />

            <label class="text-xs text-gray-600 mt-3">Subtitle</label>
            <input
              v-model="element.subtitle"
              placeholder="Free shipping on orders over $25"
              class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-green-500 focus:border-transparent"
            />
          </div>
        </div>

        <!-- Preview -->
        <div class="mt-4 p-3 border border-green-200 rounded bg-green-50">
          <label class="text-xs font-medium text-green-700 mb-2">Preview:</label>
          <div class="flex items-center space-x-3">
            <i
              v-if="element.icon"
              :class="element.icon"
              class="text-2xl"
              :style="{ color: element.color && element.color.startsWith('#') ? element.color : '' }"
            ></i>
            <div>
              <h5 class="font-semibold text-gray-800">
                {{ element.title || 'Service Title' }}
              </h5>
              <p class="text-sm text-gray-500">
                {{ element.subtitle || 'Service description' }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </template>
  </draggable>

  <div class="flex justify-end mt-4">
    <button
      type="button"
      @click="saveSection('services')"
      class="btn-primary"
      :disabled="form.processing"
    >
      <span v-if="form.processing">Saving...</span>
      <span v-else>Save Services</span>
    </button>
  </div>
</section>




 

      <!-- FOOTER -->
      <section class="bg-white shadow rounded-xl p-6">
        <h2 class="text-lg font-semibold mb-3">📬 Footer</h2>

        <div v-for="(block, bi) in form.footer.blocks" :key="bi" class="border rounded p-3 mb-3 relative">
          <button @click.prevent="removeFooterBlock(bi)" class="absolute top-2 right-2 text-red-500">✕</button>
          <label class="text-xs text-gray-600">Title</label>
          <input v-model="block.title" class="input" />
          <label class="text-xs text-gray-600 mt-2">Links (JSON array of {label,url})</label>
          <textarea v-model="block.links_json" class="input" rows="3" />
        </div>

        <div class="mt-3">
          <label class="text-xs text-gray-600">Footer Text (rich)</label>
          <QuillEditor v-model:content="form.footer.text" theme="snow" content-type="html" />
        </div>

        <div class="flex justify-end mt-4">
          <button type="button" @click="saveSection('footer')" class="btn-primary" :disabled="form.processing">
            <span v-if="form.processing">Saving...</span>
            <span v-else>Save Footer</span>
          </button>
        </div>
      </section>

      <!-- ICONS -->
      <section class="bg-white shadow rounded-xl p-6">
        <h2 class="text-lg font-semibold mb-3">🧭 Icons / Misc</h2>
        <label class="text-xs text-gray-600">Icons (JSON)</label>
        <textarea v-model="iconsText" class="input" rows="5"></textarea>
        <p class="text-xs text-gray-500 mt-1">Edit as JSON (will be parsed on save)</p>

        <div class="flex justify-end mt-4">
          <button type="button" @click="saveSection('icons')" class="btn-primary" :disabled="form.processing">
            <span v-if="form.processing">Saving...</span>
            <span v-else>Save Icons</span>
          </button>
        </div>
      </section>

      <!-- SAVE (ALL) -->
      <div class="flex justify-end">
        <button type="submit" class="btn-primary" :disabled="form.processing">
          <span v-if="form.processing">Saving all...</span>
          <span v-else> Save Settings</span>
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, watch, onMounted, onUnmounted } from 'vue'
import { useForm } from '@inertiajs/vue3'
import Draggable from 'vuedraggable'
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css'
import AdminLayout from '@/Layouts/AdminLayout.vue'

defineOptions({ layout: AdminLayout })

// Props from backend
const props = defineProps({
  settings: Object,
  products: Array,
  bestSellers: Array,
  deals: Array,
  cards: Array,
  newArrivals: Array,
  banners: Array,
  categories: Array,
  offerBanners: Array
})

console.log('Best Sellers from backend:', props.bestSellers);
console.log('Deals from backend:', props.deals);

// ADD LIVE COUNTDOWN FOR ADMIN PREVIEW
const adminCountdownInterval = ref(null)


const calculateCountdown = (deal) => {
  if (!deal.end_date) return null;

  const now = new Date().getTime();
  const endDate = new Date(deal.end_date).getTime();
  const startDate = new Date(deal.start_date).getTime();


  if (now < startDate) {
    const timeLeft = startDate - now;
    return {
      upcoming: true,
      hours: Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)).toString().padStart(2, '0'),
      minutes: Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60)).toString().padStart(2, '0'),
      seconds: Math.floor((timeLeft % (1000 * 60)) / 1000).toString().padStart(2, '0')
    };
  }

  // If deal has expired
  if (now > endDate) {
    return { expired: true };
  }

  // Calculate remaining time
  const timeLeft = endDate - now;

  return {
    hours: Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)).toString().padStart(2, '0'),
    minutes: Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60)).toString().padStart(2, '0'),
    seconds: Math.floor((timeLeft % (1000 * 60)) / 1000).toString().padStart(2, '0'),
    expired: false,
    upcoming: false
  };
}

// Update countdowns for admin preview
const updateAdminCountdowns = () => {
  form.deals.forEach(deal => {
    deal.countdown = calculateCountdown(deal);
  });
}

// Initialize admin countdown
onMounted(() => {
 
  updateAdminCountdowns();

 
  adminCountdownInterval.value = setInterval(() => {
    updateAdminCountdowns();
  }, 1000);
});


onUnmounted(() => {
  if (adminCountdownInterval.value) {
    clearInterval(adminCountdownInterval.value);
  }
});

// Utility to safely parse JSON
const safeParseJSON = (val) => {
  if (!val) return val
  if (typeof val === 'string') {
    try {
      return JSON.parse(val)
    }
    catch {
      return val
    }
  }
  return val
}

// Normalize an item (ensure it has an id)
const normalizeItem = (item = {}) => ({
  id: item.id || Math.random().toString(36).substr(2, 9),
  product_id: item.product_id || '',
  bs_title: item.bs_title || '',
  bs_subtitle: item.bs_subtitle || '',
  status: item.status !== undefined ? item.status : true,
   icon: item.icon || 'fas fa-truck',
  title: item.title || '',
  subtitle: item.subtitle || '',
  color: item.color || '#000000',
  ...item
 
})

// Normalize deal items specifically with date support
const normalizeDealItem = (item = {}) => {
  let startDate = item.start_date || '';
  let endDate = item.end_date || '';

  if (!startDate && !endDate && item.timer_values && Array.isArray(item.timer_values)) {
    const now = new Date();
    const hours = parseInt(item.timer_values[0]) || 0;
    const minutes = parseInt(item.timer_values[1]) || 0;
    const seconds = parseInt(item.timer_values[2]) || 0;

    startDate = now.toISOString().slice(0, 16);
    endDate = new Date(now.getTime() + (hours * 3600 + minutes * 60 + seconds) * 1000).toISOString().slice(0, 16);
  }

  return {
    id: item.id || Math.random().toString(36).substr(2, 9),
    product_id: item.product_id || '',
    name: item.name || '',
    price_range: item.price_range || '',
    image: item.image || '',
    sold: item.sold || 0,
    available: item.available || 0,
    progress: item.progress || 0,
    rating: item.rating || 5,
    timer_text: item.timer_text || 'Hurry up! Offer ends in:',
    timer_units: item.timer_units || ['Hours', 'Mins', 'Secs'],
    timer_values: item.timer_values || ['00', '00', '00'],
    // New date fields
    start_date: startDate,
    end_date: endDate,
    is_active: item.is_active !== undefined ? item.is_active : true,
    // Add countdown for admin preview
    countdown: null
  }
}

// Default form values
const defaultSettings = (s = {}) => {
  return {
    topbar_text: s.topbar_text || '',
    topbar_phone: s.topbar_phone || '',
    logo: s.logo || '',
    hero_title: s.hero_title || '',
    hero_subtitle: s.hero_subtitle || '',
    hero_price: s.hero_price || '',
    hero_image: s.hero_image || '',
    hero_button_text: s.hero_button_text || 'Shop Now',
    nav_links: (safeParseJSON(s.nav_links) || []).map(normalizeItem),
    offer_banners: (safeParseJSON(s.offer_banners) || []).map(normalizeItem),
    best_sellers: (safeParseJSON(s.best_sellers) || []).map(normalizeItem),
    new_arrivals: (safeParseJSON(s.new_arrivals) || []).map(normalizeItem),
    deals: (safeParseJSON(s.deals) || []).map(normalizeDealItem),
    cards: (safeParseJSON(s.cards) || []).map(normalizeItem),
    banners: (safeParseJSON(s.banners) || []).map(normalizeItem),
    categories: (safeParseJSON(s.categories) || []).map(normalizeItem),
    services: (safeParseJSON(s.services) || []).map(normalizeItem),
    newsletter: safeParseJSON(s.newsletter) || { title: '', subtitle: '', placeholder: '', button_text: 'Subscribe' },
    footer: safeParseJSON(s.footer) || { text: '', blocks: [] },
    icons: safeParseJSON(s.icons) || {}
  }
}

const initial = defaultSettings(props.settings || {})

// Form initialization
const form = useForm({
  ...initial,
  // Ensure all arrays are properly initialized
  offer_banners: props.offerBanners ? props.offerBanners.map(normalizeItem) : initial.offer_banners,
  banners: props.banners ? props.banners.map(normalizeItem) : initial.banners,
  best_sellers: props.bestSellers ? props.bestSellers.map(normalizeItem) : initial.best_sellers,
  deals: props.deals ? props.deals.map(normalizeDealItem) : initial.deals,
  cards: props.cards ? props.cards.map(normalizeItem) : initial.cards,
  new_arrivals: props.newArrivals ? props.newArrivals.map(normalizeItem) : initial.new_arrivals,
  categories: props.categories ? props.categories.map(normalizeItem) : initial.categories,
  services: initial.services
})

console.log('Form Best Sellers:', form.best_sellers);
console.log('Form Deals:', form.deals);
console.log('Form Services:', form.services);

// Preview for images
const preview = ref({
  logo: null,
  hero_image: null,
  deals: {},
  cards: {},
  banners: {},
  categories: {},
  new_arrivals: {},
  offer_banners: {},
  best_sellers: {},
  services: {}
})

// File upload preview
const onFileChange = (e, section, id = null) => {
  const file = e.target.files?.[0]
  if (!file) return

  if (id) {
    const item = form[section].find(i => i.id === id)
    if (item) {
      item.image = file
      if (!preview.value[section]) preview.value[section] = {}
      preview.value[section][id] = URL.createObjectURL(file)
    }
  } else {
    form[section] = file
    preview.value[section] = URL.createObjectURL(file)
  }
}



// Nav Links
const addNav = () => form.nav_links.push(normalizeItem({ label: '', url: '' }))
const removeNav = i => form.nav_links.splice(i, 1)

// Offer Banners
const addOfferBanner = () => form.offer_banners.push(normalizeItem({ title: '', subtitle: '', image: '' }))
const removeOfferBanner = i => form.offer_banners.splice(i, 1)

// Deals
const onProductSelect = (deal) => {
  if (!deal.product_id) return;

  const product = props.products.find(p => p.id == deal.product_id);
  if (product) {
    deal.name = product.name;
    deal.price_range = product.price_range;
    deal.rating = product.rating || 4;
    deal.image = product.image_primary || product.image || '';
  }
}

const addDeal = () => {
  const now = new Date();
  const tomorrow = new Date(now.getTime() + 24 * 60 * 60 * 1000);

  const newDeal = normalizeDealItem({
    product_id: '',
    name: '',
    price_range: '',
    image: '',
    sold: 0,
    available: 0,
    progress: 0,
    rating: 5,
    timer_text: 'Hurry up! Offer ends in:',
    timer_units: ['Hours', 'Mins', 'Secs'],
    timer_values: ['00', '00', '00'],
    start_date: now.toISOString().slice(0, 16),
    end_date: tomorrow.toISOString().slice(0, 16),
    is_active: true,
  })

  // Calculate initial countdown
  newDeal.countdown = calculateCountdown(newDeal);

  form.deals.push(newDeal)
}

const removeDeal = i => form.deals.splice(i, 1)

// Cards
const addCard = () => form.cards.push(normalizeItem(
  { title: '', price: '', image: '', button_text: 'Shop Now', button_icon: 'fas fa-arrow-right', button_url: '/shop' }))
const removeCard = i => form.cards.splice(i, 1)

// Banners
const addBanner = () => form.banners.push(normalizeItem({
  position: 'left',
  title: '',
  subtitle: '',
  price: '',
  image: ''
}))
const removeBanner = i => form.banners.splice(i, 1)

// Categories
const addCategory = () => form.categories.push(normalizeItem({
  name: '',
  products: 0,
  image: ''
}))
const removeCategory = i => form.categories.splice(i, 1)

// --- BEST SELLERS ---
const addBestSeller = () => {
  form.best_sellers.push(normalizeItem({
    product_id: '',
    bs_title: '',
    bs_subtitle: '',
    status: true
  }))
}

const removeBestSeller = i => form.best_sellers.splice(i, 1)

// --- NEW ARRIVALS ---
const addNewArrival = () => {
  form.new_arrivals.push(normalizeItem({
    product_id: ''
  }))
}

const removeNewArrival = i => form.new_arrivals.splice(i, 1)

// Helper functions to get product details
const getProductName = (id) => {
  if (!id || !props.products || !Array.isArray(props.products)) {
    return 'Select a product'
  }
  const product = props.products.find(p => p.id == id)
  return product ? product.name : 'Product not found'
}

const getProductPrice = (id) => {
  if (!id || !props.products || !Array.isArray(props.products)) {
    return 'N/A'
  }
  const product = props.products.find(p => p.id == id)
  return product ? product.price_range : 'N/A'
}

// Add deal status helper method
const getDealStatus = (deal) => {
  if (!deal.is_active) {
    return { text: 'Deal Inactive', color: 'text-gray-500' };
  }

  if (!deal.start_date || !deal.end_date) {
    return { text: 'Dates not set', color: 'text-yellow-600' };
  }

  const now = new Date();
  const start = new Date(deal.start_date);
  const end = new Date(deal.end_date);

  if (now < start) {
    const diff = start - now;
    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
    const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    return {
      text: 'Starts Soon',
      color: 'text-blue-600',
      remaining: `Starts in ${days}d ${hours}h`
    };
  } else if (now > end) {
    return { text: 'Expired', color: 'text-red-600' };
  } else {
    const diff = end - now;
    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
    const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
    return {
      text: 'Active',
      color: 'text-green-600',
      remaining: `${days}d ${hours}h ${minutes}m remaining`
    };
  }
}

// Footer Blocks
const removeFooterBlock = (index) => {
  form.footer.blocks.splice(index, 1)
}

const addService = () => {
  form.services.push({
    id: Math.random().toString(36).substr(2, 9),
    icon: '',
    color: '#000000',
    title: '',
    subtitle: '',
  })
}

const removeService = i => form.services.splice(i, 1)

const selectServiceColor = (color) => {
  if (currentServiceIndex.value !== null) {
    form.services[currentServiceIndex.value].color = color
  }
}


// --- ICONS JSON ---
const iconsText = ref(JSON.stringify(form.icons || {}, null, 2))
watch(iconsText, v => { try { form.icons = JSON.parse(v) } catch { } })

// --- SAVE ---
const preparePayload = () => {
  const clone = {}
  for (const key in form) {
    if (typeof form[key] === 'function') continue
    const val = form[key]
    clone[key] = val instanceof File || (val && typeof val.arrayBuffer === 'function') ? val : JSON.parse(JSON.stringify(val))
  }

  // rebuild footer blocks
  clone.footer = clone.footer || {}
  clone.footer.blocks = (form.footer.blocks || []).map(b => {
    let links = []
    try { links = JSON.parse(b.links_json || '[]') } catch { }
    return { title: b.title || '', links }
  })
  return clone
}

const save = () => {
  try { JSON.parse(iconsText.value) } catch { alert('Icons JSON invalid'); return }
  const cleaned = preparePayload()
  form.post(route('admin.home-settings.update'), {
    forceFormData: true,
    preserveScroll: true,
    onBefore: () => { Object.assign(form, cleaned) },
    onSuccess: () => triggerBlink()
  })
}

const saveSection = (section) => {
  if (section === 'icons') {
    try {
      JSON.parse(iconsText.value)
    } catch {
      alert('Icons JSON invalid');
      return
    }
  }

  const payload = new FormData();

  if (section === 'all') {
    save();
    return;
  }

  if (Array.isArray(form[section])) {
    // For arrays, send as JSON string
    payload.append(section, JSON.stringify(form[section]));
  } else if (typeof form[section] === 'object' && form[section] !== null) {
    // For objects, send as JSON string
    payload.append(section, JSON.stringify(form[section]));
  } else {
    payload.append(section, form[section] ?? '');
  }

  // Also include files for this section if they exist in preview
  if (preview.value[section] && typeof preview.value[section] === 'object') {
    Object.keys(preview.value[section]).forEach(key => {
      const item = form[section].find(i => i.id === key);
      if (item && item.image instanceof File) {
        payload.append(`${section}_image_${key}`, item.image);
      }
    });
  }

  // Handle specific file uploads
  if (section === 'images') {
    if (form.logo instanceof File) {
      payload.append('logo', form.logo);
    }
    if (form.hero_image instanceof File) {
      payload.append('hero_image', form.hero_image);
    }
  }

  form.post(route('admin.home-settings.update'), {
    data: payload,
    forceFormData: true,
    preserveScroll: true,
    onSuccess: () => {
      console.log(`${section} saved successfully`);
      triggerBlink();
    },
    onError: (errors) => {
      console.error(`Error saving ${section}:`, errors);
    }
  });
}

// Blink animation
const blink = ref(false)
const triggerBlink = () => { blink.value = true; setTimeout(() => blink.value = false, 400) }

</script>

<style scoped>
.input {
  @apply w-full border rounded px-3 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-emerald-500;
}

.btn-primary {
  @apply bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-6 py-2 rounded shadow;
}

.btn-green {
  @apply bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded;
}

/* Toggle switch styles */
.toggle-checkbox:checked {
  @apply right-0 border-green-400;
}

.toggle-checkbox:checked+.toggle-label {
  @apply bg-green-400;
}

@keyframes fadeOut {
  0% {
    opacity: 0.9;
  }

  100% {
    opacity: 0;
  }
}

.animate-fade {
  animation: fadeOut 0.4s ease-out forwards;
}
</style>