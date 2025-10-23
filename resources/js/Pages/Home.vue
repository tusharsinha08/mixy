<template>
  <div class="bg-white text-gray-800">
    <!-- Scroll to top -->
    <button id="scroll-top" @click="scrollToTop"
      class="fixed bottom-5 right-5 p-3 bg-green-600 text-white rounded-full shadow-lg hover:bg-green-700">
      <i :class="icons.scroll || 'fas fa-arrow-up'"></i>
    </button>

    <!-- HERO -->
    <section class="relative h-[470px] bg-cover bg-center flex items-center"
      :style="{ backgroundImage: `url(${heroImage})` }">
      <div class="relative z-10 w-full">
        <div class="max-w-7xl mx-auto px-6 md:px-10">
          <div class="max-w-xl text-left">
            <h5 class="text-gray-700 uppercase tracking-widest font-medium" v-html="heroSubtitle"></h5>
            <h1 class="text-5xl md:text-6xl font-extrabold text-gray-900 leading-tight mt-3" v-html="heroTitle"></h1>
            <p class="mt-6 text-lg text-gray-800">
              {{ heroStartingText }}
              <span class="text-red-600 font-bold text-3xl" v-html="heroPrice"></span>
            </p>
            <a :href="heroButtonUrl"
              class="inline-flex items-center gap-2 mt-8 bg-emerald-800 text-white font-semibold px-8 py-3 rounded-full hover:bg-emerald-900 transition-all duration-300">
              <span v-html="heroButtonText"></span>
              <i :class="heroButtonIcon"></i>
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- OFFER BANNERS -->
    <section class="bg-gray-50 py-12" v-if="offerBanners.length">
      <a href="/shop">
        <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-6 px-4">
          <div v-for="(banner, i) in offerBanners" :key="i"
            class="relative h-[220px] rounded-2xl overflow-hidden bg-cover bg-center flex items-center"
            :style="{ backgroundImage: `url(${banner.image || placeholderImage('banner')})` }">
            <div class="relative z-10 p-8">
              <h3 class="text-2xl font-semibold text-gray-800 leading-snug" v-html="banner.title"></h3>
              <p class="text-red-500 mt-3 font-medium" v-html="banner.subtitle"></p>
            </div>
          </div>
        </div>
      </a>
    </section>

    <!-- BEST SELLERS -->
    <section class="py-12 bg-white" v-if="bestSellersWithProducts && bestSellersWithProducts.length">
      <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-2xl font-extrabold text-gray-900" v-html="settings?.best_sellers_title || 'Best Sellers'"></h2>
        <p class="text-gray-500 mb-8" v-html="settings?.best_sellers_subtitle || 'Our most popular products'"></p>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-6">
          <div v-for="(bestSeller, index) in bestSellersWithProducts" :key="bestSeller.id"
            class="border rounded-xl hover:shadow-md transition relative flex flex-col items-center text-center overflow-hidden group">
            <!-- Check if product data exists -->
            <template v-if="bestSeller.product">
              <!-- Clickable link wrapper -->
              <a :href="`/product-details/${bestSeller.product.id}`" class="block w-full h-full p-6">
                <!-- Use product image or placeholder -->
                <img :src="bestSeller.product.image_primary || bestSeller.product.image || placeholderImage('product')"
                  :alt="bestSeller.product.name"
                  class="object-contain mb-3 h-28 w-full group-hover:scale-105 transition-transform duration-300" />
                <div class="flex justify-center space-x-1 text-yellow-400 mb-2">
                  <i v-for="n in 5" :key="n"
                    :class="n <= (bestSeller.product.rating || 4) ? 'fas fa-star' : 'far fa-star'"></i>
                </div>
                <h4 class="font-semibold text-gray-800 text-sm mb-1">
                  {{ bestSeller.product.name }}
                </h4>
                <p class="text-red-600 font-semibold text-sm">
                  ${{ bestSeller.product.price_range || bestSeller.product.price }}
                </p>
              </a>

              <!-- Add to Cart Button -->
              <button @click.stop="addToCart(bestSeller.product)"
                class="absolute bottom-4 right-4 bg-green-600 text-white w-8 h-8 rounded-full flex items-center justify-center hover:bg-green-700 transition"
                title="Add to cart">
                <i class="fas fa-shopping-bag"></i>
              </button>
            </template>

            <!-- Fallback if product data is missing -->
            <template v-else>
              <div class="block w-full h-full p-6">
                <img :src="placeholderImage('product')" alt="Product not found"
                  class="object-contain mb-3 h-28 w-full group-hover:scale-105 transition-transform duration-300" />
                <div class="flex justify-center space-x-1 text-yellow-400 mb-2">
                  <i v-for="n in 4" :key="n" class="fas fa-star"></i>
                </div>
                <h4 class="font-semibold text-gray-800 text-sm mb-1">
                  Product Not Available
                </h4>
                <p class="text-red-600 font-semibold text-sm">
                  $0.00
                </p>
              </div>
            </template>
          </div>
        </div>
      </div>
    </section>

    <!-- Show message if no active best sellers -->
    <section v-else class="py-12 bg-white">
      <div class="max-w-7xl mx-auto px-4 text-center">
        <h2 class="text-2xl font-extrabold text-gray-900">🏆 Best Sellers</h2>
        <p class="text-gray-500 mt-4">No active best sellers found.</p>
      </div>
    </section>

    <!-- SUPER DEALS -->
   
    <section class="py-8 bg-gray-50" v-if="dealsList.length">
      <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-2xl font-extrabold text-gray-900 mb-2">
          {{ 'Super Deals' }}
        </h2>
        <p class="text-gray-500 mb-8">
          {{ 'Limited time offers you can\'t miss!' }}
        </p>

        <div class="grid md:grid-cols-2 gap-6">
          <div v-for="(deal, index) in dealsList" :key="index"
            class="border-2 border-red-500 rounded-2xl p-10 flex flex-col md:flex-row items-center gap-6 bg-white">
            <div class="flex flex-col items-center">
              <a :href="`/product-details/${deal.product_id}`">
                <img :src="deal.image || placeholderImage('product')" :alt="deal.name"
                  class="h-60 object-contain cursor-pointer hover:opacity-90 transition-opacity" />
              </a>

              <!-- Progress Bar -->
              <div class="mt-5 w-full">
                <div class="flex justify-between text-xs text-gray-500">
                  <span>Sold: {{ deal.sold || 0 }}</span>
                  <span>Available: {{ deal.available || 0 }}</span>
                </div>
                <div class="h-3 w-full bg-gray-200 rounded-full mt-1 overflow-hidden">
                  <div class="h-full bg-gradient-to-r from-orange-500 to-red-500"
                    :style="{ width: calculateProgress(deal) + '%' }"></div>
                </div>
              </div>
            </div>

            <div class="text-center md:text-left mb-2">
              <!-- Rating Stars -->
              <div class="flex justify-center md:justify-start mb-1 text-yellow-400">
                <i v-for="n in 5" :key="n" :class="n <= (deal.rating || 4) ? 'fas fa-star' : 'far fa-star'"></i>
              </div>

              <h4 class="font-semibold text-gray-800" v-html="deal.name || deal.title"></h4>
              <p class="text-red-600 font-bold text-sm mt-1" v-html="deal.price_range || deal.price || '$0.00'"></p>
              <p class="text-sm text-gray-500 mt-2" v-html="deal.timer_text || 'Hurry up! Offer ends in:'"></p>

              <!-- Timer with Live Countdown -->
              <div v-if="deal.countdown && !deal.countdown.expired && !deal.countdown.upcoming" class="flex justify-center md:justify-start gap-2 mt-3">
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
              <div v-else-if="deal.countdown && deal.countdown.expired" class="text-center text-red-600 font-bold mt-3">
                Offer Expired!
              </div>
              
              <!-- Not Started Yet -->
              <div v-else-if="deal.countdown && deal.countdown.upcoming" class="text-center text-blue-600 font-bold mt-3">
                Starting soon!
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- 3 CARDS SECTION -->
    <section class="py-12 bg-white">
      <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div v-for="(card, idx) in threeCards" :key="idx"
            class="relative rounded-2xl overflow-hidden h-[250px] flex items-center bg-cover bg-center"
            :style="{ backgroundImage: `url(${card.image || placeholderImage('banner')})` }">
            <div class="absolute inset-0 bg-gradient-to-r from-black/10 to-transparent"></div>
            <div class="relative z-10 px-8 w-full">
              <h3 class="text-2xl font-bold text-gray-900 mb-2" v-html="card.title"></h3>
              <p v-if="card.price" class="text-red-600 text-xl font-semibold mb-4" v-html="card.price"></p>
              <p v-if="card.subtitle" class="text-gray-600 text-sm mb-4" v-html="card.subtitle"></p>
              <a :href="card.button_url || '#'"
                class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-full font-medium transition">
                <span v-html="card.button_text || 'Shop Now'"></span>
                <i :class="card.button_icon || 'fas fa-arrow-right'"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- NEW ARRIVALS -->
    <section class="py-6 bg-white" v-if="newArrivalsWithProducts && newArrivalsWithProducts.length">
      <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-2xl font-extrabold text-gray-900 mb-2">
          {{ 'New Arrivals' }}
        </h2>
        <p class="text-gray-500 mb-8">
          {{ 'Add new products to weekly line up' }}
        </p>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-6">
          <div v-for="(product, index) in newArrivalsWithProducts" :key="index"
            class="border rounded-xl p-6 hover:shadow-md transition relative flex flex-col items-center text-center">
            <a :href="product.url" class="block w-full h-full">
              <img :src="product.image" :alt="product.name" class="object-contain mb-3 h-32 w-full" />
              <div class="flex justify-center space-x-1 text-yellow-400 mb-2">
                <i v-for="n in 5" :key="n" :class="n <= product.rating ? 'fas fa-star' : 'far fa-star'"></i>
              </div>
              <h4 class="font-semibold text-gray-800 text-sm mb-1">{{ product.name }}</h4>
              <p class="text-red-600 font-semibold text-sm">{{ product.price_range }}</p>
              <button @click="addToCart(product)"
                class="absolute bottom-4 right-4 bg-green-600 text-white w-8 h-8 rounded-full flex items-center justify-center hover:bg-green-700 transition">
                <i :class="product.button_icon"></i>
              </button>
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- Show message if no new arrivals -->
    <section v-else class="py-12 bg-white">
      <div class="max-w-7xl mx-auto px-4 text-center">
        <h2 class="text-2xl font-extrabold text-gray-900">🆕 New Arrivals</h2>
        <p class="text-gray-500 mt-4">No new arrivals found.</p>
      </div>
    </section>

    <!-- NATURAL PRODUCT BANNERS -->
    <section class="bg-gray-50 py-8">
      <a href="/shop">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-6">
          <!-- LEFT BANNER -->
          <div
            class="relative md:col-span-2 h-[220px] rounded-2xl overflow-hidden bg-cover bg-center flex items-center justify-start"
            :style="{ backgroundImage: `url(${natural_banners.left.image})` }">
            <div class="relative z-10 px-10">
              <p class="text-sm text-black uppercase tracking-wider" v-html="natural_banners.left.subtitle"></p>
              <h3 class="text-3xl font-semibold text-black mt-1 leading-snug" v-html="natural_banners.left.title"></h3>
              <p class="text-red-700 text-lg font-bold mt-3" v-html="natural_banners.left.price"></p>
            </div>
          </div>

          <!-- RIGHT BANNER -->
          <div class="relative h-[220px] rounded-2xl overflow-hidden bg-cover bg-center flex items-center justify-start"
            :style="{ backgroundImage: `url(${natural_banners.right.image})` }">
            <div class="relative z-10 px-8">
              <h3 class="text-2xl font-semibold text-black leading-snug" v-html="natural_banners.right.title"></h3>
              <p class="text-red-700 text-lg font-bold mt-3" v-html="natural_banners.right.price"></p>
            </div>
          </div>
        </div>
      </a>
    </section>

    <!-- POPULAR CATEGORIES -->
    <section class="py-16 bg-white" v-if="categoriesList && categoriesList.length">
      <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-2xl font-extrabold text-gray-900" v-html="categoriesTitle"></h2>
        <p class="text-gray-500 mb-10" v-html="categoriesSubtitle"></p>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4">
          <div class="col-span-1 md:col-span-1 lg:col-span-1 bg-white border p-6 flex flex-col justify-between">
            <img :src="featuredCategory.image || '/assets/images/banners/img_banner4_mixy1.webp'"
              :alt="featuredCategory.name" class="mt-4 w-full rounded-lg object-contain" />
          </div>

          <div class="md:col-span-2 lg:col-span-3 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            <div v-for="(category, index) in categoriesList" :key="index"
              class="border p-6 text-center hover:shadow-md transition-all bg-white cursor-pointer group"
              @click="navigateToCategory(category)">
              <div
                class="w-20 h-20 mx-auto rounded-full flex items-center justify-center bg-gray-50 mb-3 group-hover:bg-green-50 transition-colors">
                <img :src="category.image || placeholderImage('category')" :alt="category.name"
                  class="w-15 h-15 object-contain" />
              </div>
              <h4 class="text-sm font-semibold text-gray-900 group-hover:text-green-600 transition-colors">{{
                category.name
              }}</h4>
              <p class="text-xs text-gray-500 mt-1">
                {{ category.products || 0 }} Products
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- NEWSLETTER -->
    <section class="bg-[#0D4C3A] py-10 text-white">
      <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-4">
          <div class="flex items-center justify-center w-14 h-14 rounded-full bg-white/10">
            <i :class="icons.newsletter || 'fas fa-envelope'"></i>
          </div>
          <div>
            <h3 class="text-xl font-semibold" v-html="newsletter.title"></h3>
            <p class="text-sm opacity-80" v-html="newsletter.subtitle"></p>
          </div>
        </div>

        <form @submit.prevent="onSubscribe"
          class="flex items-center w-full md:w-[500px] bg-white rounded-full overflow-hidden border border-white/20 focus-within:ring-2 focus-within:ring-green-500 transition-all">
          <input v-model="newsletterEmail" :placeholder="newsletter.placeholder || 'Your Email Address...'" type="email"
            class="flex-1 px-5 py-3 text-gray-800 outline-none rounded-l-full" />
          <button type="submit"
            class="bg-green-600 hover:bg-green-700 text-white font-semibold px-8 py-3 rounded-r-full transition-all whitespace-nowrap">
            <span v-html="newsletter.button_text || 'Subscribe'"></span>
          </button>
        </form>

        <div class="flex items-center gap-3 bg-green-700 px-6 py-3 rounded-full whitespace-nowrap">
          <i :class="icons.whatsapp || 'fab fa-whatsapp'"></i>
          <div>
            <p class="text-xs opacity-80" v-html="callUsText"></p>
            <p class="font-semibold text-lg" v-html="topbarPhoneDisplay"></p>
          </div>
        </div>
      </div>
    </section>


  <!-- Services Section -->
<section class="bg-white py-10 border-b" v-if="services && services.length">
  <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
    <div 
      v-for="(service, idx) in services" 
      :key="idx" 
      class="flex items-center space-x-4"
      v-show="service.status"
    >
      <i 
        :class="service.icon || 'fas fa-truck'" 
        class="text-3xl" 
        :style="{ color: service.color && service.color.startsWith('#') ? service.color : '' }"
      ></i>
      <div>
        <h5 class="font-semibold text-gray-800" v-html="service.title"></h5>
        <p class="text-sm text-gray-500" v-html="service.subtitle"></p>
      </div>
    </div>
  </div>
</section>
  </div>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3'

export default {
  name: "Home",
  layout: AppLayout,
  props: {
    settings: { type: Object, default: () => ({}) },
    bestSellers: { type: Array, default: () => [] },
    offerBanners: { type: Array, default: () => [] },
    deals: { type: Array, default: () => [] },
    cards: { type: Array, default: () => [] },
    products: { type: Array, default: () => [] },
    newArrivals: { type: Array, default: () => [] },
    banners: { type: Array, default: () => [] },
    categories: { type: Array, default: () => [] }
  },
  data() {
    return {
      defaultLogo: '/assets/images/logo.png',
      defaultHeroImage: '/assets/images/hero/slider1_mixy1.webp',
      defaultBanner: '/assets/images/banners/img1_banner1_mixy1.webp',
      placeholderProduct: '/assets/images/products/product-image-1-1.jpg',
      cartCountLocal: 2,
      newsletterEmail: '',
      dealsList: [],
      countdownInterval: null
    };
  },
  computed: {
    // ICONS
    icons() { return this.settings?.icons || {}; },

    // TOPBAR
    topbarText() { return this.settings?.topbar_text || 'Free shipping on orders over $25.'; },
    topbarPhoneRaw() { return this.settings?.topbar_phone || '888554168'; },
    topbarPhoneDisplay() { return this.settings?.topbar_phone_display || this.settings?.topbar_phone || '+8 88 55 4168'; },
    topbarHelpText() { return this.settings?.topbar_help_text || 'Need help? Call Us:'; },

    // LOGO
    logoSrc() { return this.settings?.logo || this.defaultLogo; },
    logoUrl() { return this.settings?.logo_url || '/'; },

    // NAV
    navLinks() {
      if (Array.isArray(this.settings?.nav_links) && this.settings.nav_links.length) return this.settings.nav_links;
      return [
        { label: 'Home', url: '/', icon: null },
        { label: 'Shop', url: '/shop', icon: null },
        { label: 'About', url: '/about', icon: null },
        { label: 'Contact', url: '/contact', icon: null }
      ];
    },

    cartCount() { return (typeof this.settings?.cart_count === 'number') ? this.settings.cart_count : this.cartCountLocal; },

    // HERO
    heroImage() {
      return this.settings?.hero_image || this.defaultHeroImage;
    },
    heroTitle() {
      return this.settings?.hero_title || 'Potato Chips & Pepper With Onion';
    },
    heroSubtitle() {
      return this.settings?.hero_subtitle || '100% ORGANIC POTATO';
    },
    heroPrice() {
      return this.settings?.hero_price || '$18.36';
    },
    heroStartingText() {
      return this.settings?.hero_starting_text || 'Starting At';
    },
    heroButtonText() {
      return this.settings?.hero_button_text || 'Shop Now';
    },
    heroButtonUrl() {
      return this.settings?.hero_button_url || '/shop';
    },
    heroButtonIcon() {
      return this.settings?.hero_button_icon || 'fas fa-arrow-right';
    },

    // OFFER BANNERS
    offerBanners() {
      if (this.offerBanners && this.offerBanners.length) return this.offerBanners;
      if (Array.isArray(this.settings?.offer_banners) && this.settings.offer_banners.length) return this.settings.offer_banners;
      return [
        { image: '/assets/images/banners/img1_banner1_mixy1.webp', title: 'Chocolate Cookies<br />Best Cookies In Town', subtitle: 'FROM 20% OFF' },
        { image: '/assets/images/banners/img1_banner1_mixy2.webp', title: 'Capture The<br />Delicious Moments', subtitle: 'FROM 30% OFF' }
      ];
    },

    // BEST SELLERS - WITH STATUS FILTER
    bestSellersWithProducts() {
      if (!this.bestSellers || !Array.isArray(this.bestSellers)) return [];

      return this.bestSellers
        .filter(bestSeller => bestSeller.status === 1) // Only active best sellers (status = 1)
        .map(bestSeller => {
          // Check if product relation exists and has data
          if (bestSeller.product && bestSeller.product.id) {
            return {
              id: bestSeller.id,
              product: {
                id: bestSeller.product.id,
                name: bestSeller.product.name,
                price_range: bestSeller.product.price_range,
                price: bestSeller.product.price,
                image_primary: bestSeller.product.image_primary,
                image: bestSeller.product.image,
                rating: bestSeller.product.rating || 4,
                slug: bestSeller.product.slug
              },
              bs_title: bestSeller.bs_title,
              bs_subtitle: bestSeller.bs_subtitle,
              status: bestSeller.status
            };
          }

          // If product relation doesn't exist but product_id does, try to find in products array
          if (bestSeller.product_id && this.products && Array.isArray(this.products)) {
            const product = this.products.find(p => p.id === bestSeller.product_id);
            if (product) {
              return {
                id: bestSeller.id,
                product: {
                  id: product.id,
                  name: product.name,
                  price_range: product.price_range,
                  price: product.price,
                  image_primary: product.image_primary,
                  image: product.image,
                  rating: product.rating || 4,
                  slug: product.slug
                },
                bs_title: bestSeller.bs_title,
                bs_subtitle: bestSeller.bs_subtitle,
                status: bestSeller.status
              };
            }
          }

          return null;
        })
        .filter(item => item !== null && item.product);
    },

    bestSellersTitle() { return this.settings?.best_sellers_title || 'Best Sellers'; },
    bestSellersSubtitle() { return this.settings?.best_sellers_subtitle || 'Our most popular products'; },

    // DEALS
    // dealsList() {
    //   if (this.deals && this.deals.length) {
    //     return this.deals.map(deal => ({
    //       id: deal.id,
    //       product_id: deal.product_id,
    //       name: deal.name || deal.title,
    //       price_range: deal.price_range || deal.price,
    //       image: deal.image,
    //       sold: deal.sold || 0,
    //       available: deal.available || 0,
    //       progress: deal.progress,
    //       rating: deal.rating || 4,
    //       timer_text: deal.timer_text,
    //       timer_values: deal.timer_values || ['00', '00', '00'],
    //     }));
    //   }
    //   if (Array.isArray(this.settings?.deals) && this.settings.deals.length) return this.settings.deals;
    //   return [
    //     {
    //       product_id: 1,
    //       name: "Organic coconut",
    //       price_range: "$10.00 - $70.00",
    //       image: "/assets/images/products/product-image-7-1.jpg",
    //       sold: 365,
    //       available: 634,
    //       progress: 40,
    //       rating: 4,
    //       timer_values: ['00', '00', '00']
    //     },
    //     {
    //       product_id: 2,
    //       name: "Almond organic",
    //       price_range: "$10.00 - $70.00",
    //       image: "/assets/images/products/product-image-8-1.jpg",
    //       sold: 365,
    //       available: 634,
    //       progress: 60,
    //       rating: 4,
    //       timer_values: ['00', '00', '00']
    //     }
    //   ];
    // },
  mounted() {
    console.log('=== DEBUG DATA ===');
    console.log('Best Sellers prop:', this.bestSellers);
    console.log('Best Sellers with products:', this.bestSellersWithProducts);
    console.log('New Arrivals prop:', this.newArrivals);
    console.log('New Arrivals with products:', this.newArrivalsWithProducts);
    console.log('Products prop:', this.products);
    
    // INITIALIZE DEALS WITH LIVE COUNTDOWN
    this.initializeDeals();
    
    // START COUNTDOWN INTERVAL
    this.countdownInterval = setInterval(() => {
      this.updateCountdowns();
    }, 1000);
  },
  beforeUnmount() {
    // CLEAN UP INTERVAL
    if (this.countdownInterval) {
      clearInterval(this.countdownInterval);
    }
  },
  methods: {
    // ADD LIVE COUNTDOWN METHODS
    
    // Initialize deals with countdown data
    initializeDeals() {
      let dealsData = [];
      
      // Use deals from props if available
      if (this.deals && this.deals.length) {
        dealsData = this.deals;
      } else if (Array.isArray(this.settings?.deals) && this.settings.deals.length) {
        dealsData = this.settings.deals;
      } else {
        // Fallback deals with proper dates
        const now = new Date();
        const tomorrow = new Date(now.getTime() + 24 * 60 * 60 * 1000);
        const dayAfterTomorrow = new Date(now.getTime() + 48 * 60 * 60 * 1000);
        
        dealsData = [
          {
            product_id: 1,
            name: "Organic coconut",
            price_range: "$10.00 - $70.00",
            image: "/assets/images/products/product-image-7-1.jpg",
            sold: 365,
            available: 634,
            progress: 40,
            rating: 4,
            start_date: now.toISOString().slice(0, 16),
            end_date: tomorrow.toISOString().slice(0, 16),
            timer_text: "Hurry up! Offer ends in:",
            is_active: true
          },
          {
            product_id: 2,
            name: "Almond organic", 
            price_range: "$10.00 - $70.00",
            image: "/assets/images/products/product-image-8-1.jpg",
            sold: 365,
            available: 634,
            progress: 60,
            rating: 4,
            start_date: now.toISOString().slice(0, 16),
            end_date: dayAfterTomorrow.toISOString().slice(0, 16),
            timer_text: "Hurry up! Offer ends in:",
            is_active: true
          }
        ];
      }
      
      // Initialize deals with countdown
      this.dealsList = dealsData.map(deal => ({
        ...deal,
        countdown: this.calculateCountdown(deal)
      }));
    },
    
    // Update all countdowns
    updateCountdowns() {
      this.dealsList = this.dealsList.map(deal => ({
        ...deal,
        countdown: this.calculateCountdown(deal)
      }));
    },
    
    // Calculate countdown for a single deal
    calculateCountdown(deal) {
      if (!deal.end_date) return null;
      
      const now = new Date().getTime();
      const endDate = new Date(deal.end_date).getTime();
      const startDate = new Date(deal.start_date).getTime();
      
      // If deal hasn't started yet
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
    },
    
    // Progress calculation
    calculateProgress(deal) {
      if (deal.progress !== undefined) return deal.progress;
      if (deal.sold && deal.available) return Math.round((deal.sold / (deal.sold + deal.available)) * 100);
      return 0;
    },
  },
    // CARDS (3)
    threeCards() {
      if (this.cards && this.cards.length) return this.cards;
      if (this.settings?.cards && Array.isArray(this.settings.cards) && this.settings.cards.length) return this.settings.cards;
      return [
        { title: 'Fresh Fruit Kiwis', price: '$39.99', image: '/assets/images/banners/img1_banner2_mixy1.webp', button_text: 'Shop Now', button_icon: 'fas fa-arrow-right', button_url: '/shop' },
        { title: 'Fresh Fruit Kiwis', price: '$39.99', image: '/assets/images/banners/img2_banner2_mixy1.webp', button_text: 'Shop Now', button_icon: 'fas fa-arrow-right', button_url: '/shop' },
        { title: 'Fresh Fruit Kiwis', price: '$39.99', image: '/assets/images/banners/img3_banner2_mixy1.webp', button_text: 'Shop Now', button_icon: 'fas fa-arrow-right', button_url: '/shop' },
      ];
    },

    // NEW ARRIVALS - WITH PRODUCT MAPPING
    newArrivalsWithProducts() {
      if (!this.newArrivals || !Array.isArray(this.newArrivals)) return [];

      return this.newArrivals.map(item => {
        // Check if product relation exists and has data
        if (item.product && item.product.id) {
          return {
            id: item.product.id,
            name: item.product.name,
            price_range: item.product.price_range,
            image: item.product.image_primary || '/fallback-image.jpg',
            rating: item.product.rating || 4,
            button_icon: 'fas fa-shopping-bag',
            url: `/product-details/${item.product.id}`
          };
        }

        // If product relation doesn't exist but product_id does, try to find in products array
        if (item.product_id && this.products && Array.isArray(this.products)) {
          const product = this.products.find(p => p.id === item.product_id);
          if (product) {
            return {
              id: product.id,
              name: product.name,
              price_range: product.price_range,
              image: product.image_primary || '/fallback-image.jpg',
              rating: product.rating || 4,
              button_icon: 'fas fa-shopping-bag',
              url: `/product-details/${product.id}`
            };
          }
        }

        return null;
      }).filter(p => p !== null);
    },

    // NATURAL BANNERS
    natural_banners() {
      if (this.settings?.natural_banners) return this.settings.natural_banners;
      const bannersArray = this.banners || [];
      const structuredBanners = {
        left: { image: '/assets/images/banners/img1_banner3_mixy1.webp', subtitle: '100% Natural Organic', title: 'Strawberry Velvet Cake', price: '$70.00' },
        right: { image: '/assets/images/banners/img2_banner3_mixy1.webp', title: 'Organic Nuts', price: 'SAVE 20%' },
      };
      bannersArray.forEach(banner => {
        if (banner.position === 'left') structuredBanners.left = { ...structuredBanners.left, ...banner };
        else if (banner.position === 'right') structuredBanners.right = { ...structuredBanners.right, ...banner };
      });
      return structuredBanners;
    },

    // CATEGORIES
    categoriesList() {
      if (this.categories && this.categories.length) return this.categories;
      if (Array.isArray(this.settings?.categories) && this.settings.categories.length) return this.settings.categories;
      return [
        { name: 'Fresh Vegetables', products: 8, image: '/assets/images/categories/fresh_vegetables.webp' },
        { name: 'Canned Goods', products: 10, image: '/assets/images/categories/canned_goods.webp' },
        { name: 'Meats & Seafood', products: 8, image: '/assets/images/categories/meats_seafood.webp' },
        { name: 'Fresh Fruits', products: 8, image: '/assets/images/categories/fresh_fruits.webp' },
        { name: 'Bread & Bakery', products: 9, image: '/assets/images/categories/bread_bakery.webp' },
        { name: 'Eggs & Dairy', products: 18, image: '/assets/images/categories/eggs_dairy.webp' },
        { name: 'Soft Drinks', products: 8, image: '/assets/images/categories/soft_drinks.webp' },
        { name: 'Organic Snacks', products: 8, image: '/assets/images/categories/fresh_fruits.webp' }
      ];
    },

    featuredCategory() { return this.settings?.featured_category || { name: 'Healthy Dried Nuts', image: '/assets/images/banners/img_banner4_mixy1.webp' }; },
    categoriesTitle() { return this.settings?.categories_title || 'Popular Categories'; },
    categoriesSubtitle() { return this.settings?.categories_subtitle || 'Some of our popular categories include grocery'; },

    // NEWSLETTER
    newsletter() { return this.settings?.newsletter || { title: 'Sign up to Newsletter', subtitle: '...and receive $20 coupon for first shopping', placeholder: 'Your Email Address...', button_text: 'Subscribe' }; },
    callUsText() { return this.settings?.call_us_text || 'Call Us 24/7'; },

    // SERVICES
    services() {
      if (Array.isArray(this.settings?.services) && this.settings.services.length) return this.settings.services;
      return [
        { icon: 'fas fa-truck text-green-600', title: 'Free Shipping', subtitle: 'Online Only. Exclusions Apply' },
        { icon: 'fa-brands fa-square-font-awesome-stroke text-pink-400', title: 'Best Price Guarantee', subtitle: 'If You Find a Lower Price' },
        { icon: 'fas fa-shopping-basket text-purple-500', title: 'Free Curbside Pickup', subtitle: 'Grab Your Gear and Go' },
        { icon: 'fas fa-headset text-yellow-500', title: 'Support 24/7', subtitle: 'Contact us 24 hours a day' }
      ];
    },

    // FOOTER
    footer() {
      return this.settings?.footer || {
        logo: null,
        text: 'Thanks for visiting our organic store!',
        socials: [
          { icon: 'fab fa-facebook', url: '#', class: 'text-blue-600' },
          { icon: 'fab fa-twitter', url: '#', class: 'text-sky-400' },
          { icon: 'fab fa-instagram', url: '#', class: 'text-pink-500' },
          { icon: 'fab fa-youtube', url: '#', class: 'text-red-500' }
        ],
        blocks: [
          { title: 'INFORMATION', links: [{ label: 'Contact Us', url: '#' }, { label: 'About Us', url: '#' }, { label: 'Privacy Policy', url: '#' }, { label: 'Wishlist', url: '#' }, { label: 'Checkout', url: '#' }] },
          { title: 'MY ACCOUNT', links: [{ label: 'Orders', url: '#' }, { label: 'Downloads', url: '#' }, { label: 'Addresses', url: '#' }, { label: 'Account details', url: '#' }, { label: 'Lost password', url: '#' }] },
          { title: 'DOWNLOAD OUR APP', links: [{ label: 'App Store', url: '#' }, { label: 'Google Play', url: '#' }] }
        ],
        copy_text: 'Copyright © HasThemes. All Rights Reserved.',
        payment_image: '/assets/images/others/payment.png'
      };
    }
  },
   mounted() {
    console.log('=== DEBUG DATA ===');
    console.log('Best Sellers prop:', this.bestSellers);
    console.log('Best Sellers with products:', this.bestSellersWithProducts);
    console.log('New Arrivals prop:', this.newArrivals);
    console.log('New Arrivals with products:', this.newArrivalsWithProducts);
    console.log('Products prop:', this.products);
    console.log('Deals prop:', this.deals);
    
    // INITIALIZE DEALS WITH LIVE COUNTDOWN
    this.initializeDeals();
    
    // START COUNTDOWN INTERVAL
    this.countdownInterval = setInterval(() => {
      this.updateCountdowns();
    }, 1000);
  },
  beforeUnmount() {
    // CLEAN UP INTERVAL
    if (this.countdownInterval) {
      clearInterval(this.countdownInterval);
    }
  },
  methods: {
    initializeDeals() {
      let dealsData = [];
      
      // Use deals from props if available
      if (this.deals && this.deals.length) {
        dealsData = this.deals;
      } else if (Array.isArray(this.settings?.deals) && this.settings.deals.length) {
        dealsData = this.settings.deals;
      } else {
        // Fallback deals with proper dates
        const now = new Date();
        const tomorrow = new Date(now.getTime() + 24 * 60 * 60 * 1000);
        const dayAfterTomorrow = new Date(now.getTime() + 48 * 60 * 60 * 1000);
        
        dealsData = [
          {
            product_id: 1,
            name: "Organic coconut",
            price_range: "$10.00 - $70.00",
            image: "/assets/images/products/product-image-7-1.jpg",
            sold: 365,
            available: 634,
            progress: 40,
            rating: 4,
            start_date: now.toISOString().slice(0, 16),
            end_date: tomorrow.toISOString().slice(0, 16),
            timer_text: "Hurry up! Offer ends in:",
            is_active: true
          },
          {
            product_id: 2,
            name: "Almond organic", 
            price_range: "$10.00 - $70.00",
            image: "/assets/images/products/product-image-8-1.jpg",
            sold: 365,
            available: 634,
            progress: 60,
            rating: 4,
            start_date: now.toISOString().slice(0, 16),
            end_date: dayAfterTomorrow.toISOString().slice(0, 16),
            timer_text: "Hurry up! Offer ends in:",
            is_active: true
          }
        ];
      }
      
      // Initialize deals with countdown
      this.dealsList = dealsData.map(deal => ({
        ...deal,
        countdown: this.calculateCountdown(deal)
      }));
      
      console.log('Initialized deals:', this.dealsList);
    },
    
    // Update all countdowns
    updateCountdowns() {
      this.dealsList = this.dealsList.map(deal => ({
        ...deal,
        countdown: this.calculateCountdown(deal)
      }));
    },
    
    // Calculate countdown for a single deal
    calculateCountdown(deal) {
      if (!deal.end_date) {
        return {
          expired: false,
          upcoming: false,
          hours: '00',
          minutes: '00', 
          seconds: '00'
        };
      }
      
      const now = new Date().getTime();
      const endDate = new Date(deal.end_date).getTime();
      const startDate = deal.start_date ? new Date(deal.start_date).getTime() : now;
      
      // If deal hasn't started yet
      if (now < startDate) {
        const timeLeft = startDate - now;
        return {
          upcoming: true,
          expired: false,
          hours: Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)).toString().padStart(2, '0'),
          minutes: Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60)).toString().padStart(2, '0'),
          seconds: Math.floor((timeLeft % (1000 * 60)) / 1000).toString().padStart(2, '0')
        };
      }
      
      // If deal has expired
      if (now > endDate) {
        return { 
          expired: true, 
          upcoming: false,
          hours: '00',
          minutes: '00',
          seconds: '00'
        };
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
    },
    
    // Progress calculation
    calculateProgress(deal) {
      if (deal.progress !== undefined) return deal.progress;
      if (deal.sold && deal.available) {
        const total = deal.sold + deal.available;
        return Math.round((deal.sold / total) * 100);
      }
      return 0;
    },

    scrollToTop() { window.scrollTo({ top: 0, behavior: "smooth" }); },
    placeholderImage(type = 'product') {
      if (type === 'banner') return this.defaultBanner;
      if (type === 'payment') return '/assets/images/others/payment.png';
      if (type === 'category') return '/assets/images/categories/fresh_fruits.webp';
      return this.placeholderProduct;
    },
    calculateProgress(deal) {
      if (deal.progress !== undefined) return deal.progress;
      if (deal.sold && deal.available) return Math.round((deal.sold / (deal.sold + deal.available)) * 100);
      return 0;
    },
    getTimerValue(deal, index) { return deal.timer_values?.[index] || '00'; },
    addToCart(product) {
      this.cartCountLocal++;
      console.log('Added to cart:', product.name);
    },
    onSearchClick() { },
    onUserClick() { },
    onCartClick() { },
    onSubscribe() {
      if (!this.newsletterEmail) return;
      console.log('Subscribed with:', this.newsletterEmail);
      this.newsletterEmail = '';
    },
    // FIXED: Moved navigateToCategory from computed to methods
    navigateToCategory(category) {
      console.log('=== HOME PAGE NAVIGATION DEBUG ===');
      console.log('Category object:', category);
      console.log('Category name:', category.name);
      console.log('Category type:', typeof category.name);

      // Navigate to shop page with category filter
      router.get('/shop', {
        category: category.name
      }, {
        preserveState: true,
        replace: false
      });

      console.log('Navigation triggered to /shop with category:', category.name);
    }
  }
};
</script>

<style scoped>
/* Custom styles if needed */
</style>