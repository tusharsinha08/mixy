<template>
  <div class="about-us-page">
    <!-- Breadcrumb Start -->
    <section class="py-8 breadcrumb-section bg-gray-50">
      <div class="container px-4 mx-auto">
        <div class="row">
          <div class="w-full col-12">
            <div class="text-center breadcrumb-content">
              <h1 class="mb-4 text-3xl font-bold text-gray-900 page-title">About us</h1>
              <ul class="flex justify-center space-x-2 text-sm breadcrumb-page-list">
                <li class="breadcrumb-item">
                  <a href="/" class="text-green-600 transition-colors hover:text-green-800">Home</a>
                </li>
                <li class="text-gray-500 breadcrumb-item">About us</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Page Section Content Start -->
    <section class="py-16 page-section-wrapper">
      <div class="container px-4 mx-auto">
        <div class="space-y-12">
          <!-- Main Title Section -->
          <div class="max-w-4xl mx-auto text-center">
            <h2 class="mb-6 text-4xl font-bold text-gray-900">
              Mixy is largest <span class="text-green-600">Organic store</span>
            </h2>
            <p class="text-lg leading-relaxed text-gray-600">
              Great theme, excellent support. We had a few small issues with getting the dropdown menus to work and support fixed them and let us know which files were changed so that we could replicate from dev to production.
            </p>
          </div>

          <!-- Main Image -->
          <div class="w-full">
            <div class="mt-12 overflow-hidden rounded-lg shadow-lg image">
              <img 
                src="assets/images/others/img_about-2048x1400.jpg" 
                alt="About Mixy Organic Store"
                class="object-cover w-full h-auto"
              >
            </div>
          </div>

          <!-- Content Sections -->
          <div class="max-w-3xl mx-auto space-y-12">
            <!-- Who We Are -->
            <div class="about-us-content">
              <h2 class="mb-6 text-3xl font-bold text-gray-900">Who We Are?</h2>
              <p class="leading-relaxed text-gray-600">
                After every trip to Hawaii, I always have a few DMs asking where we stayed, our favorite beaches, etc. Especially with spring break around the corner, I wanted to share a recap of our trip a couple weeks ago. (I've shared a few recaps of where we've stayed and our favorite activities when we went as a family - this trip was more of an adult trip but I have multiple posts with guides on past Hawaii trips: a Maui Travel)
              </p>
            </div>

            <!-- Our Values -->
            <div class="single-item">
              <div class="grid grid-cols-1 gap-8 md:grid-cols-4">
                <div class="md:col-span-1">
                  <h2 class="text-2xl font-semibold text-gray-900">Our Values</h2>
                </div>
                <div class="md:col-span-3">
                  <p class="leading-relaxed text-gray-600">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lobortis faucibus scelerisque fermentum dui faucibus in. Id diam vel quam elementum pulvinar etiam non. Integer eget aliquet nibh praesent tristique pulvinar etiam. In nibh mauris cursus mattis molestie a iaculis leo.
                  </p>
                </div>
              </div>
            </div>

            <!-- Our Mission -->
            <div class="single-item">
              <div class="grid grid-cols-1 gap-8 md:grid-cols-4">
                <div class="md:col-span-1">
                  <h2 class="text-2xl font-semibold text-gray-900">Our Mission</h2>
                </div>
                <div class="md:col-span-3">
                  <p class="leading-relaxed text-gray-600">
                    Non diam phasellus vestibulum lorem sed risus ultricies tristique nulla. Lacus luct us accumsan tortor posuere. Tellus in metus vulputate eu scelerisque felis imperdiet proin. Nec tincidunt praesent semper feugiat. Quis imperdiet massa tincidunt nunc pulvinar sapien et ligula. In nibh mauris cursus mattis molestie a iaculis. Id diam vel quam elementum non.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Fun Facts Section -->
        <div class="py-16 mt-12 bg-green-100 rounded-lg fun-fact-wrapper">
          <div class="container px-4 mx-auto">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-4">
              <!-- Satisfied Clients -->
              <div class="text-center fun-fact">
                <div class="flex justify-center mb-4">
                  <div class="flex items-center justify-center w-16 h-16 bg-green-600 rounded-full">
                    <i class="text-2xl text-white">❤️</i>
                  </div>
                </div>
                <div class="fun-fact__content">
                  <h6 class="mb-2 text-4xl font-bold text-gray-900 fun-fact__count">159</h6>
                  <p class="text-gray-600 fun-fact__text">Satisfied Clients</p>
                </div>
              </div>

              <!-- Projects a Year -->
              <div class="text-center fun-fact">
                <div class="flex justify-center mb-4">
                  <div class="flex items-center justify-center w-16 h-16 bg-green-600 rounded-full">
                    <i class="text-2xl text-white">🌍</i>
                  </div>
                </div>
                <div class="fun-fact__content">
                  <h6 class="mb-2 text-4xl font-bold text-gray-900 fun-fact__count">68</h6>
                  <p class="text-gray-600 fun-fact__text">Projects a Year</p>
                </div>
              </div>

              <!-- Awards Won -->
              <div class="text-center fun-fact">
                <div class="flex justify-center mb-4">
                  <div class="flex items-center justify-center w-16 h-16 bg-green-600 rounded-full">
                    <i class="text-2xl text-white">🏆</i>
                  </div>
                </div>
                <div class="fun-fact__content">
                  <h6 class="mb-2 text-4xl font-bold text-gray-900 fun-fact__count">88</h6>
                  <p class="text-gray-600 fun-fact__text">Awards Won</p>
                </div>
              </div>

              <!-- Support Tickets -->
              <div class="text-center fun-fact">
                <div class="flex justify-center mb-4">
                  <div class="flex items-center justify-center w-16 h-16 bg-green-600 rounded-full">
                    <i class="text-2xl text-white">🚀</i>
                  </div>
                </div>
                <div class="fun-fact__content">
                  <h6 class="mb-2 text-4xl font-bold text-gray-900 fun-fact__count">668</h6>
                  <p class="text-gray-600 fun-fact__text">Support Tickets</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Team Member Section -->
        <div class="py-16 team-member-area">
          <div class="mb-12 text-center">
            <h2 class="text-4xl font-bold text-gray-900">Meet Our Team</h2>
          </div>
          <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-4">
            <!-- Team Member 1 -->
            <div class="text-center single-team-card">
              <div class="mb-4 team-image">
                <img 
                  src="assets/images/teams/leader1-about2-1.jpg" 
                  alt="Marcosinacioluz - Designer"
                  class="object-cover w-32 h-32 mx-auto border-4 border-green-200 rounded-full"
                >
              </div>
              <div class="team-info">
                <h5 class="mb-2 text-xl font-bold text-gray-900">Marcosinacioluz</h5>
                <p class="text-gray-600">Designer</p>
              </div>
            </div>

            <!-- Team Member 2 -->
            <div class="text-center single-team-card">
              <div class="mb-4 team-image">
                <img 
                  src="assets/images/teams/leader2-about2-1.jpg" 
                  alt="Wingcitymedia - Photographer"
                  class="object-cover w-32 h-32 mx-auto border-4 border-green-200 rounded-full"
                >
              </div>
              <div class="team-info">
                <h5 class="mb-2 text-xl font-bold text-gray-900">Wingcitymedia</h5>
                <p class="text-gray-600">Photographer</p>
              </div>
            </div>

            <!-- Team Member 3 -->
            <div class="text-center single-team-card">
              <div class="mb-4 team-image">
                <img 
                  src="assets/images/teams/leader3-about2-1.jpg" 
                  alt="Tee3sports - Designer"
                  class="object-cover w-32 h-32 mx-auto border-4 border-green-200 rounded-full"
                >
              </div>
              <div class="team-info">
                <h5 class="mb-2 text-xl font-bold text-gray-900">Tee3sports</h5>
                <p class="text-gray-600">Designer</p>
              </div>
            </div>

            <!-- Team Member 4 -->
            <div class="text-center single-team-card">
              <div class="mb-4 team-image">
                <img 
                  src="assets/images/teams/leader4-about2-1.jpg" 
                  alt="Aussiemines - C.E.O"
                  class="object-cover w-32 h-32 mx-auto border-4 border-green-200 rounded-full"
                >
              </div>
              <div class="team-info">
                <h5 class="mb-2 text-xl font-bold text-gray-900">Aussiemines</h5>
                <p class="text-gray-600">C.E.O</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="bg-[#0D4C3A] py-10 text-white">
  <div
    class="flex flex-col items-center justify-between gap-6 px-6 mx-auto max-w-7xl md:flex-row"
  >
    <!-- Left: Text -->
    <div class="flex items-center gap-4">
      <div
        class="flex items-center justify-center rounded-full w-14 h-14 bg-white/10"
      >
        <i class="text-2xl fas fa-envelope"></i>
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


    <!-- Right: Call Us -->
    <div
      class="flex items-center gap-3 px-6 py-3 bg-green-700 rounded-full whitespace-nowrap"
    >
      <i class="text-4xl fab fa-whatsapp"></i>
      <div>
        <p class="text-xs opacity-80">Call Us 24/7</p>
        <p class="text-lg font-semibold">+8 88 55 4168</p>
      </div>
    </div>
  </div>
</section>

    <section class="py-10 bg-white border-b">
  <div
    class="grid grid-cols-1 gap-6 px-6 mx-auto max-w-7xl sm:grid-cols-2 md:grid-cols-4"
  >
    <!-- Item 1 -->
    <div class="flex items-center space-x-4">
      <i class="text-3xl text-green-600 fas fa-truck"></i>
      <div>
        <h5 class="font-semibold text-gray-800">Free Shipping</h5>
        <p class="text-sm text-gray-500">Online Only. Exclusions Apply</p>
      </div>
    </div>

    <!-- Item 2 -->
    <div class="flex items-center space-x-4">
      <i class="text-3xl text-pink-400 fa-brands fa-square-font-awesome-stroke"></i>
      <div>
        <h5 class="font-semibold text-gray-800">Best Price Guarantee</h5>
        <p class="text-sm text-gray-500">If You Find a Lower Price</p>
      </div>
    </div>

    <!-- Item 3 -->
    <div class="flex items-center space-x-4">
      <i class="text-3xl text-purple-500 fas fa-shopping-basket"></i>
      <div>
        <h5 class="font-semibold text-gray-800">Free Curbside Pickup</h5>
        <p class="text-sm text-gray-500">Grab Your Gear and Go</p>
      </div>
    </div>

    <!-- Item 4 -->
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

<script>
import AppLayout from '@/Layouts/AppLayout.vue';

export default {
  name: 'AboutUs',
  layout: AppLayout,
  data() {
    return {
      email: ''
    }
  },
  methods: {
    subscribeNewsletter() {
      // Handle newsletter subscription
      console.log('Subscribing email:', this.email);
      // You can add your API call here
      this.email = ''; // Reset the email field
      
      // Show success message (you can replace this with a proper notification system)
      alert('Thank you for subscribing to our newsletter!');
    }
  },
  mounted() {
    // Initialize any components or animations if needed
  }
}
</script>

<style scoped>
/* Custom styles if needed, but most styling is handled by Tailwind */
</style>