<template>
  <div class="bg-white text-gray-800">
    <!-- Scroll to top -->
    <button
      id="scroll-top"
      @click="scrollToTop"
      class="fixed bottom-5 right-5 p-3 bg-green-600 text-white rounded-full shadow-lg hover:bg-green-700"
    >
      <i class="icon-rt-arrow-up"></i>
    </button>

    <!-- HERO -->
    <section
      class="relative h-[500px] bg-cover bg-center flex items-center justify-center text-center"
      style="background-image: url('/assets/images/preview.webp')"
    >
      <div class="bg-black/50 absolute inset-0"></div>
      <div class="relative z-10 text-white px-4">
        <h5 class="text-lg uppercase tracking-widest">100% ORGANIC POTATO</h5>
        <h1 class="text-4xl md:text-5xl font-bold mt-2">Potato Chips & Pepper With Onion</h1>
        <p class="mt-4 text-lg">Starting At <b>$18.36</b></p>
        <a
          href="#"
          class="inline-block mt-6 px-6 py-3 bg-green-600 text-white rounded-md hover:bg-green-700"
          >Shop Now</a
        >
      </div>
    </section>

    <!-- SERVICES -->
    <section class="py-16 bg-gray-50">
      <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 px-4 text-center">
        <div>
          <i class="icon-rt-rocket text-4xl text-green-600"></i>
          <h5 class="font-semibold mt-3 text-lg">Free Delivery</h5>
          <p class="text-sm text-gray-600">Free shipping on all US order</p>
        </div>
        <div>
          <i class="icon-rt-headphone text-4xl text-green-600"></i>
          <h5 class="font-semibold mt-3 text-lg">24/7 Support</h5>
          <p class="text-sm text-gray-600">Dedicated support team</p>
        </div>
        <div>
          <i class="icon-rt-shield text-4xl text-green-600"></i>
          <h5 class="font-semibold mt-3 text-lg">Secure Payment</h5>
          <p class="text-sm text-gray-600">100% secure payment</p>
        </div>
      </div>
    </section>

    <!-- PRODUCTS -->
    <section class="py-16">
      <div class="max-w-7xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold">Featured Products</h2>
        <p class="text-gray-500 mt-1 mb-8">Browse Our Best Seller Products</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
          <div
            v-for="(product, index) in products"
            :key="index"
            class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition"
          >
            <img :src="product.image" :alt="product.name" class="w-full h-56 object-cover" />
            <div class="p-4">
              <h4 class="font-semibold text-lg">{{ product.name }}</h4>
              <p class="text-green-600 font-bold mt-1">{{ product.price }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- BLOG -->
    <section class="py-16 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold">Latest News</h2>
        <p class="text-gray-500 mt-1 mb-8">From our blog and news</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <article
            v-for="(blog, index) in blogs"
            :key="index"
            class="bg-white border rounded-lg overflow-hidden shadow-sm hover:shadow-md"
          >
            <img :src="blog.image" :alt="blog.title" class="w-full h-52 object-cover" />
            <div class="p-4 text-left">
              <h4 class="text-lg font-semibold mb-1">{{ blog.title }}</h4>
              <p class="text-xs text-gray-500 mb-2">{{ blog.date }}</p>
              <p class="text-gray-600 text-sm">{{ blog.excerpt }}</p>
              <a href="#" class="text-green-600 text-sm mt-3 inline-block hover:underline"
                >Read more →</a
              >
            </div>
          </article>
        </div>
      </div>
    </section>

    <!-- SUBSCRIBE -->
    <section class="py-16">
      <div
        class="max-w-5xl mx-auto bg-green-600 text-white rounded-lg flex flex-col md:flex-row items-center justify-between p-8 gap-6"
      >
        <div>
          <h2 class="text-2xl font-bold">Subscribe to get updates</h2>
          <p class="opacity-80">Get 10% off your first order</p>
        </div>
        <form class="flex w-full md:w-auto">
          <input
            type="email"
            placeholder="Enter your email"
            class="px-4 py-2 rounded-l-md text-gray-800 w-full md:w-64"
          />
          <button
            type="submit"
            class="px-5 py-2 bg-gray-900 rounded-r-md hover:bg-gray-800 transition"
          >
            Subscribe
          </button>
        </form>
      </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-gray-300 pt-16 pb-8">
      <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-8">
        <div>
          <img src="/assets/images/logo/logo-footer.png" alt="logo" class="h-10 mb-4" />
          <p>Organic food store — fresh and healthy.</p>
          <ul class="mt-3 space-y-1 text-sm">
            <li><i class="icon-rt-call-outline"></i> +8 88 55 4168</li>
            <li><i class="icon-rt-mail-open"></i> support@mixy.com</li>
          </ul>
        </div>

        <div>
          <h5 class="font-semibold mb-3">Information</h5>
          <ul class="space-y-1 text-sm">
            <li><a href="#" class="hover:text-white">About Us</a></li>
            <li><a href="#" class="hover:text-white">Contact</a></li>
            <li><a href="#" class="hover:text-white">Privacy Policy</a></li>
            <li><a href="#" class="hover:text-white">Terms & Conditions</a></li>
          </ul>
        </div>

        <div>
          <h5 class="font-semibold mb-3">Customer Service</h5>
          <ul class="space-y-1 text-sm">
            <li><a href="#" class="hover:text-white">Returns</a></li>
            <li><a href="#" class="hover:text-white">Shipping</a></li>
            <li><a href="#" class="hover:text-white">Track Order</a></li>
            <li><a href="#" class="hover:text-white">FAQs</a></li>
          </ul>
        </div>

        <div>
          <h5 class="font-semibold mb-3">Follow Us</h5>
          <div class="flex gap-3 text-xl">
            <a href="#" class="hover:text-white"><i class="icon-rt-facebook"></i></a>
            <a href="#" class="hover:text-white"><i class="icon-rt-twitter"></i></a>
            <a href="#" class="hover:text-white"><i class="icon-rt-instagram"></i></a>
            <a href="#" class="hover:text-white"><i class="icon-rt-linkedin"></i></a>
          </div>
          <img
            src="/assets/images/payment/payment.png"
            alt="payment"
            class="mt-4 h-6 opacity-90"
          />
        </div>
      </div>

      <div class="border-t border-gray-700 mt-12 pt-4 text-sm text-center">
        <p>© 2024 Mixy. All Rights Reserved.</p>
      </div>
    </footer>
  </div>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'

export default {
  name: "Home",
  layout: AppLayout,
  data() {
    return {
      products: [
        {
          name: "Organic Apple",
          price: "$30.00",
          image: "/assets/images/product/product-1.jpg",
        },
        {
          name: "Organic Orange",
          price: "$25.00",
          image: "/assets/images/product/product-2.jpg",
        },
        {
          name: "Organic Mango",
          price: "$22.00",
          image: "/assets/images/product/product-3.jpg",
        },
        {
          name: "Organic Banana",
          price: "$15.00",
          image: "/assets/images/product/product-4.jpg",
        },
      ],
      blogs: [
        {
          title: "Healthy Food for Everyone",
          date: "Oct 12, 2024",
          excerpt: "Discover healthy recipes and food news.",
          image: "/assets/images/blog/blog-1.jpg",
        },
        {
          title: "Tips for Organic Farming",
          date: "Nov 05, 2024",
          excerpt: "Tips and guides for modern organic farming.",
          image: "/assets/images/blog/blog-2.jpg",
        },
        {
          title: "Natural Snacks You Must Try",
          date: "Dec 21, 2024",
          excerpt: "Our recommended snacks for daily diet.",
          image: "/assets/images/blog/blog-3.jpg",
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
