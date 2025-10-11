<template>
  <div class="bg-white text-gray-800">
    <!-- Scroll to top -->
    <button id="scroll-top" @click="scrollToTop"
      class="fixed bottom-5 right-5 p-3 bg-green-600 text-white rounded-full shadow-lg hover:bg-green-700">
      <i class="icon-rt-arrow-up"></i>
    </button>

    <!-- HEADER -->


    <!-- Hero Section -->
    <section class="relative h-[450px] bg-cover bg-center flex items-center"
      style="background-image: url('/assets/images/hero/slider1_mixy1.webp');">

      <div class="relative z-10 w-full">
        <div class="max-w-7xl mx-auto px-6 md:px-10">
          <div class="max-w-xl text-left">
            <h5 class="text-gray-700 uppercase tracking-widest font-medium">
              100% ORGANIC POTATO
            </h5>
            <h1 class="text-5xl md:text-6xl font-extrabold text-gray-900 leading-tight mt-3">
              Potato Chips &<br />Pepper With Onion
            </h1>
            <p class="mt-6 text-lg text-gray-800">
              Starting At
              <span class="text-red-600 font-bold text-3xl">$18.36</span>
            </p>
            <Link href="/shop"
              class="inline-flex items-center gap-2 mt-8 bg-emerald-800 text-white font-semibold px-8 py-3 rounded-full hover:bg-emerald-900 transition-all duration-300 cursor-pointer">
            Shop Now
            <i class="fas fa-arrow-right text-sm"></i>
            </Link>
          </div>
        </div>
      </div>
    </section>

    <!-- Offer Banners -->
    <section class="bg-gray-50 py-12">
      <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-6 px-4">
        <!-- Banner 1 -->
        <div class="relative h-[220px] rounded-2xl overflow-hidden bg-cover bg-center flex items-center"
          style="background-image: url('/assets/images/banners/img1_banner1_mixy1.webp');">
          <div class="relative z-10 p-8">
            <h3 class="text-2xl font-semibold text-gray-800 leading-snug">
              Chocolate Cookies<br />Best Sweets In Town
            </h3>
            <p class="text-red-500 mt-3 font-medium">FROM 20% OFF</p>
          </div>
        </div>

        <!-- Banner 2 -->
        <div class="relative h-[220px] rounded-2xl overflow-hidden bg-cover bg-center flex items-center"
          style="background-image: url('/assets/images/banners/img1_banner1_mixy2.webp');">
          <div class="relative z-10 p-8">
            <h3 class="text-2xl font-semibold text-gray-800 leading-snug">
              Capture The<br />Delicious Moments
            </h3>
            <p class="text-red-500 mt-3 font-medium">FROM 30% OFF</p>
          </div>
        </div>
      </div>
    </section>

    <!-- PRODUCTS -->
    <section class="py-12 bg-white">
      <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-2xl font-extrabold text-gray-900">Best Sellers</h2>
        <p class="text-gray-500 mb-8">Add bestselling products to weekly line up</p>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 ">
          <div v-for="(product, index) in bestSellers" :key="index"
            class="border rounded-xl p-6 hover:shadow-md transition relative flex flex-col items-center text-center">
            <img :src="product.image" :alt="product.name" class=" object-contain mb-3" />
            <div class="flex justify-center space-x-1 text-yellow-400 mb-2">
              <i class="fas fa-star" v-for="n in 4" :key="n"></i>
              <i class="far fa-star"></i>
            </div>
            <h4 class="font-semibold text-gray-800 text-sm mb-1">
              {{ product.name }}
            </h4>
            <p class="text-red-600 font-semibold text-sm">
              {{ product.priceRange }}
            </p>
            <button
              class="absolute bottom-4 right-4 bg-green-600 text-white w-8 h-8 rounded-full flex items-center justify-center hover:bg-green-700 transition">
              <i class="fas fa-shopping-bag text-sm"></i>
            </button>
          </div>
        </div>
      </div>
    </section>

    <!--  Super Deals Of The Week -->
    <section class="py-12 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-2xl font-extrabold text-gray-900">
          Super Deals Of The Week
        </h2>
        <p class="text-gray-500 mb-10">
          Don’t miss this opportunity at a special discount just for this week
        </p>

        <div class="grid md:grid-cols-2 gap-6">
          <div v-for="(deal, index) in deals" :key="index"
            class="border-2 border-red-500 rounded-2xl p-10 flex flex-col md:flex-row items-center gap-6 bg-white">
            <!-- Product Image -->
            <div class="flex flex-col items-center">
              <img :src="deal.image" :alt="deal.name" class="h-60 object-contain" />

              <!--  Progress Bar  -->
              <div class="mt-5 w-full">
                <div class="flex justify-between text-xs text-gray-500">
                  <span>Sold: {{ deal.sold }}</span>
                  <span>Available: {{ deal.available }}</span>
                </div>
                <div class="h-3 w-full bg-gray-200 rounded-full mt-1 overflow-hidden">
                  <div class="h-full bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600"
                    :style="{ width: deal.progress + '%' }"></div>
                </div>
              </div>
            </div>

            <!-- Product Info -->
            <div class="text-center md:text-left mb-2">
              <div class="flex justify-center md:justify-start mb-1 text-yellow-400">
                <i class="fas fa-star" v-for="n in 4" :key="n"></i>
                <i class="far fa-star"></i>
              </div>
              <h4 class="font-semibold text-gray-800">{{ deal.name }}</h4>
              <p class="text-red-600 font-bold text-sm mt-1">
                {{ deal.priceRange }}
              </p>
              <p class="text-sm text-gray-500 mt-2">Hurry up! Offer ends in:</p>

              <div class="flex justify-center md:justify-start gap-2 mt-3">
                <div v-for="(unit, i) in ['Hours', 'Mins', 'Secs']" :key="i"
                  class="bg-gray-100 px-3 py-2 rounded-md text-center text-sm">
                  <div class="font-bold">00</div>
                  <div class="text-gray-500">{{ unit }}</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="py-12 bg-white">
      <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <!-- Card 1 -->
          <div class="relative rounded-2xl overflow-hidden h-[250px] flex flex-col justify-center px-8"
            style="background-color: #fbd5d5; background-image: url('/assets/images/banners/img1_banner2_mixy1.webp'); background-size: cover; background-position: center;">
            <div class="relative z-10">
              <h3 class="text-2xl font-bold text-black mb-2">Fresh Fruit Kiwis</h3>
              <p class="text-red-600 text-xl font-semibold mb-4">$39.99</p>
              <a href="#"
                class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-full font-medium transition">
                Shop Now <i class="fas fa-arrow-right ml-2"></i>
              </a>
            </div>
          </div>

          <!-- Card 2 -->
          <div class="relative rounded-2xl overflow-hidden h-[250px] flex flex-col justify-center px-8"
            style="background-color: #f2b3a2; background-image: url('/assets/images/banners/img2_banner2_mixy1.webp'); background-size: cover; background-position: center;">
            <div class="relative z-10">
              <h3 class="text-2xl font-bold text-black mb-2">Fresh Fruit Kiwis</h3>
              <p class="text-red-600 text-xl font-semibold mb-4">$39.99</p>
              <a href="#"
                class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-full font-medium transition">
                Shop Now <i class="fas fa-arrow-right ml-2"></i>
              </a>
            </div>
          </div>

          <!-- Card 3 -->
          <div class="relative rounded-2xl overflow-hidden h-[250px] flex flex-col justify-center px-8"
            style="background-color: #c8e7db; background-image: url('/assets/images/banners/img3_banner2_mixy1.webp'); background-size: cover; background-position: center;">
            <div class="relative z-10">
              <h3 class="text-2xl font-bold text-black mb-2">Fresh Fruit Kiwis</h3>
              <p class="text-red-600 text-xl font-semibold mb-4">$39.99</p>
              <a href="#"
                class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-full font-medium transition">
                Shop Now <i class="fas fa-arrow-right ml-2"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- New Arrivals -->
    <section class="py-12 bg-white">
      <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-2xl font-extrabold text-gray-900">New Arrivals</h2>
        <p class="text-gray-500 mb-8">Add new products to weekly line up</p>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 ">
          <div v-for="(product, index) in newArrival" :key="index"
            class="border rounded-xl p-6 hover:shadow-md transition relative flex flex-col items-center text-center">
            <img :src="product.image" :alt="product.name" class=" object-contain mb-3" />
            <div class="flex justify-center space-x-1 text-yellow-400 mb-2">
              <i class="fas fa-star" v-for="n in 4" :key="n"></i>
              <i class="far fa-star"></i>
            </div>
            <h4 class="font-semibold text-gray-800 text-sm mb-1">
              {{ product.name }}
            </h4>
            <p class="text-red-600 font-semibold text-sm">
              {{ product.priceRange }}
            </p>
            <button
              class="absolute bottom-4 right-4 bg-green-600 text-white w-8 h-8 rounded-full flex items-center justify-center hover:bg-green-700 transition">
              <i class="fas fa-shopping-bag text-sm"></i>
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- natural product banner -->
    <section class="bg-gray-50 py-6">
      <div class="max-w-7xl mx-auto flex flex-col md:flex-row gap-6 px-4">

        <!-- Left Banner -->
        <div class="relative flex-1 h-[200px] rounded-2xl overflow-hidden bg-cover bg-center flex items-center"
          style="background-image: url('/assets/images/banners/img1_banner3_mixy1.webp');">
          <div class="relative z-10 p-6 md:p-8">
            <h5 class="text-sm font-medium text-gray-800 uppercase">
              100% Natural Organic
            </h5>
            <h3 class="text-2xl font-semibold text-gray-900 mt-1">
              Strawberry Velvet Cake
            </h3>
            <p class="text-red-600 text-xl font-bold mt-3">$30.66</p>
          </div>
        </div>

        <!-- Right Banner -->
        <div
          class="relative w-full md:w-[400px] h-[200px] rounded-2xl overflow-hidden bg-cover bg-center flex items-center justify-start"
          style="background-image: url('/assets/images/banners/img2_banner3_mixy1.webp');">
          <div class="relative z-10 p-6 md:p-8">
            <h3 class="text-2xl font-semibold text-gray-900 leading-snug">
              Organic <br> Nuts
            </h3>
            <p class="text-red-600 text-xl font-bold mt-3">$26.88</p>
          </div>
        </div>

      </div>
    </section>

    <!-- Popular Categories -->
    <section class="py-16 bg-white">
      <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-2xl font-extrabold text-gray-900">Popular Categories</h2>
        <p class="text-gray-500 mb-10">
          Some of our popular categories include grocery
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 ">
          <!-- Left Featured Card -->
          <div
            class="col-span-1 md:col-span-1 lg:col-span-1 bg-white border p-6 flex flex-col justify-between text-white">
            <img src="/assets/images/banners/img_banner4_mixy1.webp" alt="Healthy Dried Nuts"
              class="mt-4 w-full rounded-lg object-contain" />
          </div>

          <!-- Right Categories Grid -->
          <div class="md:col-span-2 lg:col-span-3 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 ">
            <div v-for="(category, index) in [
              { name: 'Fresh Vegetables', products: 8, image: '/assets/images/categories/fresh_vegetables.webp' },
              { name: 'Canned Goods', products: 10, image: '/assets/images/categories/canned_goods.webp' },
              { name: 'Meats & Seafood', products: 8, image: '/assets/images/categories/meats_seafood.webp' },
              { name: 'Fresh Fruits', products: 8, image: '/assets/images/categories/fresh_fruits.webp' },
              { name: 'Bread & Bakery', products: 9, image: '/assets/images/categories/bread_bakery.webp' },
              { name: 'Eggs & Dairy', products: 18, image: '/assets/images/categories/eggs_dairy.webp' },
              { name: 'Soft Drinks', products: 8, image: '/assets/images/categories/soft_drinks.webp' },
              { name: 'Organic Snacks', products: 8, image: '/assets/images/categories/fresh_fruits.webp' }
            ]" :key="index" class="border p-6 text-center hover:shadow-md transition-all bg-white">
              <div class="w-20 h-20 mx-auto rounded-full flex items-center justify-center bg-gray-50 mb-3">
                <img :src="category.image" :alt="category.name" class="w-15 h-15" />
              </div>
              <h4 class="text-sm font-semibold text-gray-900">{{ category.name }}</h4>
              <p class="text-xs text-gray-500 mt-1">
                {{ category.products }} Products
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Newsletter Section -->
    <section class="bg-[#0D4C3A] py-10 text-white">
      <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-6">
        <!-- Left: Text -->
        <div class="flex items-center gap-4">
          <div class="flex items-center justify-center w-14 h-14 rounded-full bg-white/10">
            <i class="fas fa-envelope text-2xl"></i>
          </div>
          <div>
            <h3 class="text-xl font-semibold">Sign up to Newsletter</h3>
            <p class="text-sm opacity-80">
              ...and receive $20 coupon for first shopping
            </p>
          </div>
        </div>

        <!-- Center: Email Form -->
        <form
          class="flex items-center w-full md:w-[500px] bg-white rounded-full overflow-hidden border border-white/20 focus-within:ring-2 focus-within:ring-green-500 transition-all">
          <input type="email" placeholder="Your Email Address..."
            class="flex-1 px-5 py-3 text-gray-800 outline-none rounded-l-full" />
          <button type="submit"
            class="bg-green-600 hover:bg-green-700 text-white font-semibold px-8 py-3 rounded-r-full transition-all whitespace-nowrap">
            Subscribe
          </button>
        </form>


        <!-- Right: Call Us -->
        <div class="flex items-center gap-3 bg-green-700 px-6 py-3 rounded-full whitespace-nowrap">
          <i class="fab fa-whatsapp text-4xl"></i>
          <div>
            <p class="text-xs opacity-80">Call Us 24/7</p>
            <p class="font-semibold text-lg">+8 88 55 4168</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Services Section -->
    <section class="bg-white py-10 border-b">
      <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        <!-- Item 1 -->
        <div class="flex items-center space-x-4">
          <i class="fas fa-truck text-3xl text-green-600"></i>
          <div>
            <h5 class="font-semibold text-gray-800">Free Shipping</h5>
            <p class="text-sm text-gray-500">Online Only. Exclusions Apply</p>
          </div>
        </div>

        <!-- Item 2 -->
        <div class="flex items-center space-x-4">
          <i class="fa-brands fa-square-font-awesome-stroke text-3xl text-pink-400"></i>
          <div>
            <h5 class="font-semibold text-gray-800">Best Price Guarantee</h5>
            <p class="text-sm text-gray-500">If You Find a Lower Price</p>
          </div>
        </div>

        <!-- Item 3 -->
        <div class="flex items-center space-x-4">
          <i class="fas fa-shopping-basket text-3xl text-purple-500"></i>
          <div>
            <h5 class="font-semibold text-gray-800">Free Curbside Pickup</h5>
            <p class="text-sm text-gray-500">Grab Your Gear and Go</p>
          </div>
        </div>

        <!-- Item 4 -->
        <div class="flex items-center space-x-4">
          <i class="fas fa-headset text-3xl text-yellow-500"></i>
          <div>
            <h5 class="font-semibold text-gray-800">Support 24/7</h5>
            <p class="text-sm text-gray-500">Contact us 24 hours a day</p>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';


export default {
  name: "Home",
  data() {
    return {
      bestSellers: [
        {
          name: "Fresh organic kiwi",
          priceRange: "$10.00 - $70.00",
          image: "/assets/images/products/product-image-2-1.jpg",
        },
        {
          name: "Dried mango",
          priceRange: "$10.00 - $70.00",
          image: "/assets/images/products/product-image-1-1.jpg",
        },
        {
          name: "Dried banana",
          priceRange: "$60.00 - $80.00",
          image: "/assets/images/products/product-image-3-1.jpg",
        },
        {
          name: "Crunchy crisps",
          priceRange: "$50.00 - $90.00",
          image: "/assets/images/products/product-image-4-1.jpg",
        },
        {
          name: "Jewel cranberries",
          priceRange: "$60.00 - $67.00",
          image: "/assets/images/products/product-image-5-1.jpg",
        },
      ],
      deals: [
        {
          name: "Organic coconut",
          priceRange: "$10.00 - $70.00",
          image: "/assets/images/products/product-image-7-1.jpg",
          sold: 365,
          available: 634,
          progress: 40,
        },
        {
          name: "Almond organic",
          priceRange: "$10.00 - $70.00",
          image: "/assets/images/products/product-image-8-1.jpg",
          sold: 365,
          available: 634,
          progress: 60,
        },
      ],
      newArrival: [
        {
          name: "Fresh organic kiwi",
          priceRange: "$10.00 - $70.00",
          image: "/assets/images/products/product-image-2-1.jpg",
        },
        {
          name: "Dried mango",
          priceRange: "$10.00 - $70.00",
          image: "/assets/images/products/product-image-1-1.jpg",
        },
        {
          name: "Dried banana",
          priceRange: "$60.00 - $80.00",
          image: "/assets/images/products/product-image-3-1.jpg",
        },
        {
          name: "Crunchy crisps",
          priceRange: "$50.00 - $90.00",
          image: "/assets/images/products/product-image-4-1.jpg",
        },
        {
          name: "Jewel cranberries",
          priceRange: "$60.00 - $67.00",
          image: "/assets/images/products/product-image-5-1.jpg",
        },
        {
          name: "Jewel cranberries",
          priceRange: "$60.00 - $67.00",
          image: "/assets/images/products/product-image-11-1.jpg",
        },
        {
          name: "Jewel cranberries",
          priceRange: "$60.00 - $67.00",
          image: "/assets/images/products/product-image-13-1.jpg",
        },
        {
          name: "Fresh Broccoli",
          priceRange: "$60.00 - $67.00",
          image: "/assets/images/products/product-image-6-1.jpg",
        },
        {
          name: "Dried mango",
          priceRange: "$60.00 - $67.00",
          image: "/assets/images/products/product-image-7-1.jpg",
        },
        {
          name: "Dried mango",
          priceRange: "$60.00 - $67.00",
          image: "/assets/images/products/product-image-9-1.jpg",
        },
      ],
    };
  },

  methods: {
    scrollToTop() {
      window.scrollTo({ top: 0, behavior: "smooth" });
    },
  },
};
</script>
