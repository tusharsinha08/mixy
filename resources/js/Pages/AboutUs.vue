<template>
  <div class="about-us-page">
    <!-- Breadcrumb Start -->
    <section class="py-8 breadcrumb-section" 
    bg-gray-50 style="background-image: url('assets/images/others/breadcrumb.jpg')">
      <div class="container px-4 mx-auto">
        <div class="text-center">
          <h1 class="mb-4 text-3xl font-bold text-gray-900">About Us</h1>
          <ul class="flex justify-center space-x-2 text-sm">
            <li>
              <a href="/" class="text-green-600 hover:text-green-800">Home</a>
            </li>
            <li class="text-gray-500">About Us</li>
          </ul>
        </div>
      </div>
    </section>

    <!-- Main Content -->
    <section class="py-16">
      <div class="container px-4 mx-auto space-y-12">

        <!-- Hero Section -->
        <div class="max-w-4xl mx-auto text-center">
          <h2 class="mb-6 text-4xl font-bold text-gray-900">
            {{ props.aboutUs.hero.title }}
          </h2>
          <p class="text-lg leading-relaxed text-gray-600">
            {{ props.aboutUs.hero.subtitle }}
          </p>
          <div v-if="props.aboutUs.hero.buttonText" class="mt-6">
            <a
              href="/shop"
              class="px-6 py-3 font-semibold text-white transition-all bg-green-600 rounded-full hover:bg-green-700"
            >
              {{ props.aboutUs.hero.buttonText }}
            </a>
          </div>
        </div>

        <!-- Hero Image -->
        <div class="overflow-hidden rounded-lg shadow-lg">
          <img
            src="assets/images/others/img_about-2048x1400.jpg"
            alt="About Mixy Organic Store"
            class="object-cover w-full h-auto"
          />
        </div>

        <!-- Who We Are -->
        <div class="max-w-3xl mx-auto space-y-12">
          <div>
            <h2 class="mb-6 text-3xl font-bold text-gray-900">Who We Are?</h2>
            <p class="leading-relaxed text-gray-600">
              {{ props.aboutUs.whoWeAre.text }}
            </p>
          </div>

          <!-- Our Values -->
          <div class="grid grid-cols-1 gap-8 md:grid-cols-4">
            <div class="md:col-span-1">
              <h2 class="text-2xl font-semibold text-gray-900">Our Values</h2>
            </div>
            <div class="md:col-span-3">
              <p class="leading-relaxed text-gray-600">
                {{ props.aboutUs.ourValues.text }}
              </p>
            </div>
          </div>

          <!-- Our Mission -->
          <div class="grid grid-cols-1 gap-8 md:grid-cols-4">
            <div class="md:col-span-1">
              <h2 class="text-2xl font-semibold text-gray-900">Our Mission</h2>
            </div>
            <div class="md:col-span-3">
              <p class="leading-relaxed text-gray-600">
                {{ props.aboutUs.ourMission.text }}
              </p>
            </div>
          </div>
        </div>

        <!-- Fun Facts -->
        <div
          v-if="props.aboutUs.funFacts.length"
          class="py-16 mt-12 bg-green-100 rounded-lg"
        >
          <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-4">
            <div
              v-for="(fact, i) in props.aboutUs.funFacts"
              :key="i"
              class="text-center"
            >
              <div class="flex justify-center mb-4">
                <div class="flex items-center justify-center w-16 h-16 bg-green-600 rounded-full">
                  <i class="text-2xl text-white">{{ fact.icon }}</i>
                </div>
              </div>
              <h6 class="mb-2 text-4xl font-bold text-gray-900">
                {{ fact.count }}
              </h6>
              <p class="text-gray-600">{{ fact.label }}</p>
            </div>
          </div>
        </div>

        <!-- Team Members -->
        <div
          v-if="props.aboutUs.teamMembers.length"
          class="py-16 team-member-area"
        >
          <div class="mb-12 text-center">
            <h2 class="text-4xl font-bold text-gray-900">Meet Our Team</h2>
          </div>

          <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-4">
            <div
              v-for="(member, i) in props.aboutUs.teamMembers"
              :key="i"
              class="text-center single-team-card"
            >
              <div class="mb-4">
                <img
                  :src="member.image"
                  :alt="member.name"
                  class="object-cover w-32 h-32 mx-auto border-4 border-green-200 rounded-full"
                />
              </div>
              <div>
                <h5 class="mb-2 text-xl font-bold text-gray-900">
                  {{ member.name }}
                </h5>
                <p class="text-gray-600">{{ member.role }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Newsletter Section -->
    <section class="bg-[#0D4C3A] py-10 text-white">
      <div class="flex flex-col items-center justify-between gap-6 px-6 mx-auto max-w-7xl md:flex-row">
        <!-- Left -->
        <div class="flex items-center gap-4">
          <div class="flex items-center justify-center rounded-full w-14 h-14 bg-white/10">
            <i class="text-2xl fas fa-envelope"></i>
          </div>
          <div>
            <h3 class="text-xl font-semibold">Sign up to Newsletter</h3>
            <p class="text-sm opacity-80">
              ...and receive $20 coupon for first shopping
            </p>
          </div>
        </div>

        <!-- Center -->
        <form
          class="flex items-center w-full md:w-[500px] bg-white rounded-full overflow-hidden border border-white/20 focus-within:ring-2 focus-within:ring-green-500 transition-all"
        >
          <input
            type="email"
            placeholder="Your Email Address..."
            class="flex-1 px-5 py-3 text-gray-800 rounded-l-full outline-none"
          />
          <button
            type="submit"
            class="px-8 py-3 font-semibold text-white transition-all bg-green-600 rounded-r-full hover:bg-green-700 whitespace-nowrap"
          >
            Subscribe
          </button>
        </form>

        <!-- Right -->
        <div class="flex items-center gap-3 px-6 py-3 bg-green-700 rounded-full whitespace-nowrap">
          <i class="text-4xl fab fa-whatsapp"></i>
          <div>
            <p class="text-xs opacity-80">Call Us 24/7</p>
            <p class="text-lg font-semibold">+8 88 55 4168</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Bottom Info -->
    <section class="py-10 bg-white border-b">
      <div class="grid grid-cols-1 gap-6 px-6 mx-auto max-w-7xl sm:grid-cols-2 md:grid-cols-4">
        <div class="flex items-center space-x-4">
          <i class="text-3xl text-green-600 fas fa-truck"></i>
          <div>
            <h5 class="font-semibold text-gray-800">Free Shipping</h5>
            <p class="text-sm text-gray-500">Online Only. Exclusions Apply</p>
          </div>
        </div>
        <div class="flex items-center space-x-4">
          <i class="text-3xl text-pink-400 fa-brands fa-square-font-awesome-stroke"></i>
          <div>
            <h5 class="font-semibold text-gray-800">Best Price Guarantee</h5>
            <p class="text-sm text-gray-500">If You Find a Lower Price</p>
          </div>
        </div>
        <div class="flex items-center space-x-4">
          <i class="text-3xl text-purple-500 fas fa-shopping-basket"></i>
          <div>
            <h5 class="font-semibold text-gray-800">Free Curbside Pickup</h5>
            <p class="text-sm text-gray-500">Grab Your Gear and Go</p>
          </div>
        </div>
        <div class="flex items-center space-x-4">
          <i class="text-3xl text-yellow-500 fas fa-headset"></i>
          <div>
            <h5 class="font-semibold text-gray-800">Support 24/7</h5>
            <p class="text-sm text-gray-500">Contact us 24 hours a day</p>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'

defineOptions({ layout: AppLayout })

const props = defineProps({
  aboutUs: {
    type: Object,
    default: () => ({
      hero: { title: '', subtitle: '', buttonText: '' },
      whoWeAre: { text: '' },
      ourValues: { text: '' },
      ourMission: { text: '' },
      funFacts: [],
      teamMembers: []
    })
  }
})
</script>

<style scoped>    

</style>
