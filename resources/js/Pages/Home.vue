<template>
  <div class="bg-white text-gray-800">
    <!-- Scroll to top -->
    <button id="scroll-top" @click="scrollToTop"
      class="fixed bottom-5 right-5 p-3 bg-green-600 text-white rounded-full shadow-lg hover:bg-green-700">
      <i :class="icons.scroll || 'icon-rt-arrow-up'"></i>
    </button>

    <!-- HEADER -->


    <!-- HERO -->
    <section class="relative h-[450px] bg-cover bg-center flex items-center"
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
      <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-6 px-4">
        <div v-for="(banner, i) in offerBanners" :key="i"
          class="relative h-[220px] rounded-2xl overflow-hidden bg-cover bg-center flex items-center"
          :style="{ backgroundImage: `url(${banner.image || placeholderImage('banner')})` }">
          <div class="relative z-10 p-8">
            <h3 class="text-2xl font-semibold text-gray-800 leading-snug" v-html="banner.title"></h3>
            <p class="text-red-500 mt-3 font-medium" v-html="banner.discount"></p>
            <div v-if="banner.button_text" class="mt-3">
              <a :href="banner.button_url || '#'"
                class="inline-flex items-center gap-2 bg-white text-gray-800 px-4 py-2 rounded-full shadow">
                <span v-html="banner.button_text"></span>
                <i :class="banner.button_icon || 'fas fa-arrow-right'"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- BEST SELLERS -->
     <section class="py-12 bg-white" v-if="bestSellersList && bestSellersList.length">
     <div class="max-w-7xl mx-auto px-4">
       <h2 class="text-2xl font-extrabold text-gray-900" v-html="settings?.best_sellers_title || 'Best Sellers'"></h2>
       <p class="text-gray-500 mb-8" v-html="settings?.best_sellers_subtitle || 'Our most popular products'"></p>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-6">
          <div v-for="(product, index) in bestSellersList" :key="index"
            class="border rounded-xl p-6 hover:shadow-md transition relative flex flex-col items-center text-center">
            <img :src="product.image || placeholderImage('product')" :alt="product.name" class="object-contain mb-3" />
            <div class="flex justify-center space-x-1 text-yellow-400 mb-2">
              <i v-for="n in (product.rating || 4)" :key="n" class="fas fa-star"></i>
              <i class="far fa-star"></i>
            </div>
            <h4 class="font-semibold text-gray-800 text-sm mb-1" v-html="product.name"></h4>
            <p class="text-red-600 font-semibold text-sm" v-html="product.priceRange"></p>
            <button @click="addToCart(product)"
              class="absolute bottom-4 right-4 bg-green-600 text-white w-8 h-8 rounded-full flex items-center justify-center hover:bg-green-700 transition"
              :title="product.button_text || 'Add to cart'">
              <i :class="product.button_icon || 'fas fa-shopping-bag'"></i>
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- SUPER DEALS -->
    <section class="py-12 bg-gray-50" v-if="dealsList.length">
      <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-2xl font-extrabold text-gray-900" v-html="dealsTitle"></h2>
        <p class="text-gray-500 mb-10" v-html="dealsSubtitle"></p>

        <div class="grid md:grid-cols-2 gap-6">
          <div v-for="(deal, index) in dealsList" :key="index"
            class="border-2 border-red-500 rounded-2xl p-10 flex flex-col md:flex-row items-center gap-6 bg-white">
            <div class="flex flex-col items-center">
              <img :src="deal.image || placeholderImage('product')" :alt="deal.name" class="h-60 object-contain" />

              <!--  Progress Bar  -->
              <div class="mt-5 w-full">
                <div class="flex justify-between text-xs text-gray-500">
                  <span>Sold: {{ deal.sold || 0 }}</span>
                  <span>Available: {{ deal.available || 0 }}</span>
                </div>
                <div class="h-3 w-full bg-gray-200 rounded-full mt-1 overflow-hidden">
                  <div class="h-full bg-gradient-to-r from-orange-500 to-red-500"
                    :style="{ width: (deal.progress || 0) + '%' }"></div>
                </div>
              </div>
            </div>

            <div class="text-center md:text-left mb-2">
              <div class="flex justify-center md:justify-start mb-1 text-yellow-400">
                <i v-for="n in (deal.rating || 4)" :key="n" class="fas fa-star"></i>
                <i class="far fa-star"></i>
              </div>
              <h4 class="font-semibold text-gray-800" v-html="deal.name"></h4>
              <p class="text-red-600 font-bold text-sm mt-1" v-html="deal.priceRange"></p>
              <p class="text-sm text-gray-500 mt-2" v-html="deal.timer_text || 'Hurry up! Offer ends in:'"></p>

              <div class="flex justify-center md:justify-start gap-2 mt-3">
                <div v-for="(unit, i) in deal.timer_units || ['Hours', 'Mins', 'Secs']" :key="i"
                  class="bg-gray-100 px-3 py-2 rounded-md text-center text-sm">
                  <div class="font-bold">{{ (deal.timer_values && deal.timer_values[i]) || '00' }}</div>
                  <div class="text-gray-500">{{ unit }}</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- 3 CARDS (Fresh Fruit Kiwis etc.) -->
    <section class="py-12 bg-white">
      <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div v-for="(card, idx) in threeCards" :key="idx"
            class="relative rounded-2xl overflow-hidden h-[250px] flex flex-col justify-center px-8"
            :style="cardStyle(card)">
            <div class="relative z-10">
              <h3 class="text-2xl font-bold text-black mb-2" v-html="card.title"></h3>
              <p class="text-red-600 text-xl font-semibold mb-4" v-html="card.price"></p>
              <a :href="card.button_url || '#'"
                class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-full font-medium transition">
                <span v-html="card.button_text || 'Shop Now'"></span>
                <i :class="card.button_icon || 'fas fa-arrow-right'"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- NEW ARRIVALS -->
    <section class="py-12 bg-white" v-if="newArrivalsList.length">
      <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-2xl font-extrabold text-gray-900" v-html="newArrivalsTitle"></h2>
        <p class="text-gray-500 mb-8" v-html="newArrivalsSubtitle"></p>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-6">
          <div v-for="(product, index) in newArrivalsList" :key="index"
            class="border rounded-xl p-6 hover:shadow-md transition relative flex flex-col items-center text-center">
            <img :src="product.image || placeholderImage('product')" :alt="product.name" class="object-contain mb-3" />
            <div class="flex justify-center space-x-1 text-yellow-400 mb-2">
              <i v-for="n in (product.rating || 4)" :key="n" class="fas fa-star"></i>
              <i class="far fa-star"></i>
            </div>
            <h4 class="font-semibold text-gray-800 text-sm mb-1" v-html="product.name"></h4>
            <p class="text-red-600 font-semibold text-sm" v-html="product.priceRange"></p>
            <button @click="addToCart(product)"
              class="absolute bottom-4 right-4 bg-green-600 text-white w-8 h-8 rounded-full flex items-center justify-center hover:bg-green-700 transition">
              <i :class="product.button_icon || 'fas fa-shopping-bag'"></i>
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- NATURAL PRODUCT BANNERS -->
    <section class="bg-gray-50 py-6">
      <div class="max-w-7xl mx-auto flex flex-col md:flex-row gap-6 px-4">
        <div class="relative flex-1 h-[200px] rounded-2xl overflow-hidden bg-cover bg-center flex items-center"
          :style="{ backgroundImage: `url(${cardsLeftImage})` }">
          <div class="relative z-10 p-6 md:p-8">
            <h5 class="text-sm font-medium text-gray-800 uppercase" v-html="naturalLeft.subtitle"></h5>
            <h3 class="text-2xl font-semibold text-gray-900 mt-1" v-html="naturalLeft.title"></h3>
            <p class="text-red-600 text-xl font-bold mt-3" v-html="naturalLeft.price"></p>
          </div>
        </div>

        <div
          class="relative w-full md:w-[400px] h-[200px] rounded-2xl overflow-hidden bg-cover bg-center flex items-center justify-start"
          :style="{ backgroundImage: `url(${cardsRightImage})` }">
          <div class="relative z-10 p-6 md:p-8">
            <h3 class="text-2xl font-semibold text-gray-900 leading-snug" v-html="naturalRight.title"></h3>
            <p class="text-red-600 text-xl font-bold mt-3" v-html="naturalRight.price"></p>
          </div>
        </div>
      </div>
    </section>

    <!-- POPULAR CATEGORIES -->
    <section class="py-16 bg-white">
      <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-2xl font-extrabold text-gray-900" v-html="categoriesTitle"></h2>
        <p class="text-gray-500 mb-10" v-html="categoriesSubtitle"></p>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 ">
          <div
            class="col-span-1 md:col-span-1 lg:col-span-1 bg-white border p-6 flex flex-col justify-between text-white">
            <img :src="featuredCategory.image || placeholderImage('category')" :alt="featuredCategory.name"
              class="mt-4 w-full rounded-lg object-contain" />
          </div>

          <div class="md:col-span-2 lg:col-span-3 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 ">
            <div v-for="(category, index) in categoriesList" :key="index"
              class="border p-6 text-center hover:shadow-md transition-all bg-white">
              <div class="w-20 h-20 mx-auto rounded-full flex items-center justify-center bg-gray-50 mb-3">
                <img :src="category.image || placeholderImage('category')" :alt="category.name" class="w-15 h-15" />
              </div>
              <h4 class="text-sm font-semibold text-gray-900" v-html="category.name"></h4>
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

    <!-- SERVICES -->
    <section class="bg-white py-10 border-b">
      <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        <div v-for="(service, idx) in services" :key="idx" class="flex items-center space-x-4">
          <i :class="service.icon || 'fas fa-truck'" class="text-3xl" :style="{ color: service.color || '' }"></i>
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



export default {
  name: "Home",
  layout: AppLayout,
  props: {
    settings: {
      type: Object,
      default: () => ({})
    },
    bestSellers: {
      type: Array,
      default: () => []
    },
    deals: {
      type: Array,
      default: () => []
    },
    cards: {
      type: Array,
      default: () => []
    },
    newArrivals: {
      type: Array,
      default: () => []
    },
    banners: {
      type: Array,
      default: () => []
    },
    categories: {
      type: Array,
      default: () => []
    }
  },

  data() {
    return {
      defaultLogo: '/assets/images/logo.png',
      defaultHeroImage: '/assets/images/hero/slider1_mixy1.webp',
      defaultBanner: '/assets/images/banners/img1_banner1_mixy1.webp',
      placeholderProduct: '/assets/images/products/product-image-1-1.jpg',
      cartCountLocal: 2,
      newsletterEmail: ''
    };
  },
  computed: {
    // ICONS
    icons() {
      return this.settings?.icons || {};
    },

    

    

    

    

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
      if (Array.isArray(this.settings?.offer_banners) && this.settings.offer_banners.length) {
        return this.settings.offer_banners;
      }
      return [
        { image: '/assets/images/banners/img1_banner1_mixy1.webp', title: 'Chocolate Cookies<br />Best Sweets In Town', discount: 'FROM 20% OFF' },
        { image: '/assets/images/banners/img1_banner1_mixy2.webp', title: 'Capture The<br />Delicious Moments', discount: 'FROM 30% OFF' }
      ];
    },

    // BEST SELLERS
    bestSellersList() {
      if (Array.isArray(this.settings?.best_sellers) && this.settings.best_sellers.length) return this.settings.best_sellers;
      return [
        { name: "Fresh organic kiwi", priceRange: "$10.00 - $70.00", image: "/assets/images/products/product-image-2-1.jpg", button_icon: "fas fa-shopping-bag" },
        { name: "Dried mango", priceRange: "$10.00 - $70.00", image: "/assets/images/products/product-image-1-1.jpg", button_icon: "fas fa-shopping-bag" },
        { name: "Dried banana", priceRange: "$60.00 - $80.00", image: "/assets/images/products/product-image-3-1.jpg", button_icon: "fas fa-shopping-bag" },
        { name: "Crunchy crisps", priceRange: "$50.00 - $90.00", image: "/assets/images/products/product-image-4-1.jpg", button_icon: "fas fa-shopping-bag" },
        { name: "Jewel cranberries", priceRange: "$60.00 - $67.00", image: "/assets/images/products/product-image-5-1.jpg", button_icon: "fas fa-shopping-bag" }
      ];
    },
    bestSellersTitle() {
      return this.settings?.best_sellers_title || 'Best Sellers';
    },
    bestSellersSubtitle() {
      return this.settings?.best_sellers_subtitle || 'Add bestselling products to weekly line up';
    },
   

    // DEALS
    dealsList() {
      if (Array.isArray(this.settings?.deals) && this.settings.deals.length) return this.settings.deals;
      return [
        { name: "Organic coconut", priceRange: "$10.00 - $70.00", image: "/assets/images/products/product-image-7-1.jpg", sold: 365, available: 634, progress: 40 },
        { name: "Almond organic", priceRange: "$10.00 - $70.00", image: "/assets/images/products/product-image-8-1.jpg", sold: 365, available: 634, progress: 60 }
      ];
    },
    dealsTitle() {
      return this.settings?.deals_title || 'Super Deals Of The Week';
    },
    dealsSubtitle() {
      return this.settings?.deals_subtitle || 'Don’t miss this opportunity at a special discount just for this week';
    },

    // CARDS (3)
    threeCards() {
      if (Array.isArray(this.settings?.cards) && this.settings.cards.length) return this.settings.cards;
      return [
        { title: 'Fresh Fruit Kiwis', price: '$39.99', image: '/assets/images/banners/img1_banner2_mixy1.webp', button_text: 'Shop Now' },
        { title: 'Fresh Fruit Kiwis', price: '$39.99', image: '/assets/images/banners/img2_banner2_mixy1.webp', button_text: 'Shop Now' },
        { title: 'Fresh Fruit Kiwis', price: '$39.99', image: '/assets/images/banners/img3_banner2_mixy1.webp', button_text: 'Shop Now' },
      ];
    },

    // NEW ARRIVALS
    newArrivalsList() {
      if (Array.isArray(this.settings?.new_arrivals) && this.settings.new_arrivals.length) return this.settings.new_arrivals;
      return [
        { name: "Fresh organic kiwi", priceRange: "$10.00 - $70.00", image: "/assets/images/products/product-image-2-1.jpg" },
        { name: "Dried mango", priceRange: "$10.00 - $70.00", image: "/assets/images/products/product-image-1-1.jpg" },
        { name: "Dried banana", priceRange: "$60.00 - $80.00", image: "/assets/images/products/product-image-3-1.jpg" },
        { name: "Crunchy crisps", priceRange: "$50.00 - $90.00", image: "/assets/images/products/product-image-4-1.jpg" },
        { name: "Jewel cranberries", priceRange: "$60.00 - $67.00", image: "/assets/images/products/product-image-5-1.jpg" }
      ];
    },
    newArrivalsTitle() {
      return this.settings?.new_arrivals_title || 'New Arrivals';
    },
    newArrivalsSubtitle() {
      return this.settings?.new_arrivals_subtitle || 'Add new products to weekly line up';
    },

    // NATURAL banners
    naturalLeft() {
      return this.settings?.natural_left || { subtitle: '100% Natural Organic', title: 'Strawberry Velvet Cake', price: '$30.66' };
    },
    naturalRight() {
      return this.settings?.natural_right || { title: 'Organic <br> Nuts', price: '$26.88' };
    },
    cardsLeftImage() {
      return this.settings?.natural_left?.image || '/assets/images/banners/img1_banner3_mixy1.webp';
    },
    cardsRightImage() {
      return this.settings?.natural_right?.image || '/assets/images/banners/img2_banner3_mixy1.webp';
    },

    // CATEGORIES
    categoriesList() {
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
    featuredCategory() {
      return this.settings?.featured_category || { name: 'Healthy Dried Nuts', image: '/assets/images/banners/img_banner4_mixy1.webp' };
    },
    categoriesTitle() {
      return this.settings?.categories_title || 'Popular Categories';
    },
    categoriesSubtitle() {
      return this.settings?.categories_subtitle || 'Some of our popular categories include grocery';
    },

    // NEWSLETTER
    newsletter() {
      return this.settings?.newsletter || { title: 'Sign up to Newsletter', subtitle: '...and receive $20 coupon for first shopping', placeholder: 'Your Email Address...', button_text: 'Subscribe' };
    },
    callUsText() {
      return this.settings?.call_us_text || 'Call Us 24/7';
    },

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

    
  },
  methods: {
    scrollToTop() {
      window.scrollTo({ top: 0, behavior: "smooth" });
    },
    placeholderImage(type = 'product') {
      if (type === 'banner') return this.defaultBanner;
      if (type === 'payment') return '/assets/images/others/payment.png';
      if (type === 'category') return '/assets/images/categories/fresh_fruits.webp';
      return this.placeholderProduct;
    },
    cardStyle(card) {
      const bg = card.image || this.placeholderImage('banner');
      const bgColor = card.bg_color || 'transparent';
      return { backgroundColor: bgColor, backgroundImage: `url(${bg})`, backgroundSize: 'cover', backgroundPosition: 'center' };
    },
    addToCart(product) {
      this.cartCountLocal++;
      // Optional: post to API or emit event via Inertia/Axios
    },
    onSearchClick() { },
    onUserClick() { },
    onSubscribe() {
      if (!this.newsletterEmail) return;
      // Example: Inertia.post('/newsletter-subscribe', { email: this.newsletterEmail })
      this.newsletterEmail = '';
      // show UI toast if you want
    }
  }
};

</script>
