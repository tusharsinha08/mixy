<template>
  <div>
    <Head :title="contact?.page_title || 'Contact Us'" />

    <!-- Hero Section -->
    <section
      class="relative bg-cover bg-center bg-no-repeat"
      style="background-image: url('/assets/images/others/breadcrumb.jpg')"
    >
      <div
        class="relative z-10 flex flex-col items-center justify-center py-20 text-center text-black"
      >
        <h1 class="text-4xl font-bold md:text-5xl">{{ contact?.page_title }}</h1>
        <p class="mt-3 text-gray-700">{{ contact?.breadcrumb_title }}</p>
        <ul class="flex justify-center mt-4 space-x-2 text-sm text-gray-700">
          <li><Link href="/" class="hover:text-white">Home</Link></li>
          <li>/</li>
          <li>{{ contact?.page_title }}</li>
        </ul>
      </div>
    </section>

    <!-- Main Section -->
    <div class="min-h-screen bg-gray-50">
      <div class="px-4 py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-12 lg:grid-cols-2">
          <!-- Contact Info -->
          <div class="p-8 bg-white rounded-lg shadow-md">
            <h2 class="mb-6 text-2xl font-bold text-gray-900">
              {{ contact?.breadcrumb_title }}
            </h2>

            <div class="space-y-8">
              <!-- Office -->
              <div class="flex items-start space-x-4">
                <div class="flex-shrink-0 p-3 bg-green-500 rounded-full">
                  <i class="text-lg text-white fas fa-map-marker-alt"></i>
                </div>
                <div>
                  <h3 class="mb-2 text-lg font-semibold text-gray-900">
                    Office Location
                  </h3>
                  <p class="text-gray-600">
                    {{ contact?.office_location }}
                  </p>
                </div>
              </div>

              <!-- Phones -->
              <div class="flex items-start space-x-4" v-if="contact?.phone_numbers?.length">
                <div class="flex-shrink-0 p-3 bg-blue-500 rounded-full">
                  <i class="text-lg text-white fas fa-phone"></i>
                </div>
                <div>
                  <h3 class="mb-2 text-lg font-semibold text-gray-900">
                    Call us anytime
                  </h3>
                  <p class="text-gray-600">
                    <span
                      v-for="(phone, index) in contact.phone_numbers"
                      :key="index"
                    >
                      <strong>{{ phone }}</strong>
                      <span v-if="index < contact.phone_numbers.length - 1"> or </span>
                    </span>
                  </p>
                </div>
              </div>

              <!-- Emails -->
              <div class="flex items-start space-x-4" v-if="contact?.emails?.length">
                <div class="flex-shrink-0 p-3 bg-purple-500 rounded-full">
                  <i class="text-lg text-white fas fa-envelope"></i>
                </div>
                <div>
                  <h3 class="mb-2 text-lg font-semibold text-gray-900">
                    Send Mail
                  </h3>
                  <p class="text-gray-600">
                    <a
                      v-for="(email, index) in contact.emails"
                      :key="index"
                      :href="`mailto:${email}`"
                      class="text-blue-600 hover:text-blue-800 hover:underline block"
                    >
                      {{ email }}
                    </a>
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Contact Form -->
          <div class="p-8 bg-white rounded-lg shadow-md">
            <h2 class="mb-6 text-2xl font-bold text-gray-900">Send Us a Message</h2>

            <form @submit.prevent="submitForm" class="space-y-6">
              <div>
                <label class="block mb-2 text-sm font-medium text-gray-700">Name *</label>
                <input
                  type="text"
                  v-model="form.name"
                  required
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                />
              </div>

              <div>
                <label class="block mb-2 text-sm font-medium text-gray-700">Email *</label>
                <input
                  type="email"
                  v-model="form.email"
                  required
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                />
              </div>

              <div>
                <label class="block mb-2 text-sm font-medium text-gray-700">Phone</label>
                <input
                  type="text"
                  v-model="form.phone"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                />
              </div>

              <div>
                <label class="block mb-2 text-sm font-medium text-gray-700">Message *</label>
                <textarea
                  v-model="form.message"
                  rows="5"
                  required
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                ></textarea>
              </div>

              <button
                type="submit"
                :disabled="processing"
                class="w-full px-6 py-3 text-lg font-semibold text-white bg-green-600 rounded-lg hover:bg-green-700 disabled:opacity-50"
              >
                <span v-if="processing">
                  <i class="mr-2 fas fa-spinner fa-spin"></i> Sending...
                </span>
                <span v-else>
                  <i class="mr-2 fas fa-paper-plane"></i> Send Message
                </span>
              </button>

              <div v-if="successMessage" class="p-4 mt-4 border border-green-200 rounded-lg bg-green-50">
                <div class="flex items-center">
                  <i class="mr-3 text-green-800 fas fa-check-circle"></i>
                  <p class="font-medium text-green-800">{{ successMessage }}</p>
                </div>
              </div>
            </form>
          </div>
        </div>

        <!-- Map -->
        <div class="my-16 overflow-hidden bg-white rounded-lg shadow-md" v-if="contact?.map_title">
          <div class="relative flex items-center justify-center bg-gray-100 h-80">
            <div class="z-10 text-center text-gray-500">
              <i class="mb-4 text-5xl text-green-800 fas fa-map-marked-alt"></i>
              <h3 class="mb-2 text-xl font-semibold">{{ contact?.map_title }}</h3>
              <p class="text-gray-600">{{ contact?.map_address }}</p>
            </div>
          </div>
        </div>

        <!-- Newsletter -->
        <section v-if="contact?.newsletter_title" class="bg-[#0D4C3A] py-10 text-white">
          <div class="flex flex-col items-center justify-between gap-6 px-6 mx-auto max-w-7xl md:flex-row">
            <div class="flex items-center gap-4">
              <div class="flex items-center justify-center w-14 h-14 bg-white/10 rounded-full">
                <i class="text-2xl fas fa-envelope"></i>
              </div>
              <div>
                <h3 class="text-xl font-semibold">{{ contact.newsletter_title }}</h3>
                <p class="text-sm opacity-80">{{ contact.newsletter_subtitle }}</p>
              </div>
            </div>

            <div class="flex items-center gap-3 px-6 py-3 bg-green-700 rounded-full whitespace-nowrap">
              <i class="text-4xl fab fa-whatsapp"></i>
              <div>
                <p class="text-xs opacity-80">{{ contact.call_us_text }}</p>
                <p class="text-lg font-semibold">{{ contact.call_us_number }}</p>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Head, useForm, Link } from '@inertiajs/vue3'
import { ref } from 'vue'

defineOptions({ layout: AppLayout })

defineProps({
  contact: Object,
})

const processing = ref(false)
const successMessage = ref('')

const form = useForm({
  name: '',
  email: '',
  phone: '',
  message: '',
})

function submitForm() {
  processing.value = true
  setTimeout(() => {
    successMessage.value = ' Thank you! We’ll get back to you soon.'
    form.reset()
    processing.value = false
    setTimeout(() => (successMessage.value = ''), 5000)
  }, 2000)
}
</script>

<style scoped>
@import 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css';
</style>
