<template>
  <div class="relative max-w-5xl p-8 mx-auto bg-white rounded-2xl shadow-lg border border-gray-100">
    <!-- Blink overlay -->
    <transition name="fade">
      <div
        v-if="blink"
        class="fixed inset-0 bg-white opacity-70 z-[9999]"
      ></div>
    </transition>

    <h1 class="text-3xl font-bold mb-8 text-gray-800 flex items-center gap-2">
      <span>📞</span> Contact Page Setting
    </h1>

    <form @submit.prevent="save" class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Left Column -->
      <div class="space-y-6">
        <!-- Page Title -->
        <div>
          <label class="block mb-2 text-sm font-semibold text-gray-700">Page Title</label>
          <input
            v-model="form.page_title"
            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500"
          />
        </div>

        <!-- Breadcrumb Title -->
        <div>
          <label class="block mb-2 text-sm font-semibold text-gray-700">Breadcrumb Title</label>
          <input
            v-model="form.breadcrumb_title"
            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500"
          />
        </div>

        <!-- Office Location -->
        <div>
          <label class="block mb-2 text-sm font-semibold text-gray-700">Office Location</label>
          <textarea
            v-model="form.office_location"
            rows="3"
            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500"
          ></textarea>
        </div>

      <!-- Right Column -->
      <div class="space-y-6">
        <!-- Phones -->
        <div>
          <label class="block mb-2 text-sm font-semibold text-gray-700">Phones (comma separated)</label>
          <input
            v-model="form.phone_numbers"
            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500"
          />
        </div>

        <!-- Emails -->
        <div>
          <label class="block mb-2 text-sm font-semibold text-gray-700">Emails (comma separated)</label>
          <input
            v-model="form.emails"
            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500"
          />
        </div>

        <!-- Newsletter Title -->
        <div>
          <label class="block mb-2 text-sm font-semibold text-gray-700">Newsletter Title</label>
          <input
            v-model="form.newsletter_title"
            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500"
          />
        </div>

        <!-- Newsletter Subtitle -->
        <div>
          <label class="block mb-2 text-sm font-semibold text-gray-700">Newsletter Subtitle</label>
          <input
            v-model="form.newsletter_subtitle"
            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500"
          />
        </div>

         <!-- Call Us Text -->
        <div>
          <label class="block mb-2 text-sm font-semibold text-gray-700">Call Us Text</label>
          <input
            v-model="form.call_us_text"
            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500"
          />
        </div>
      </div>


        <!-- Call Us Number -->
        <div>
          <label class="block mb-2 text-sm font-semibold text-gray-700">Call Us Number</label>
          <input
            v-model="form.call_us_number"
            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500"
          />
        </div>
      </div>

      <!-- Submit -->
      <div class="md:col-span-2 flex justify-end mt-6">
        <button
          type="submit"
          :disabled="form.processing"
          class="flex items-center gap-2 px-8 py-3 text-white bg-green-600 rounded-lg shadow hover:bg-green-700 transition-all disabled:opacity-50"
        >
          <i v-if="form.processing" class="fas fa-spinner fa-spin"></i>
          <i v-else class="fas fa-save"></i>
          <span>{{ form.processing ? 'Saving...' : 'Save Changes' }}</span>
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { useForm } from '@inertiajs/vue3'
import { ref, defineProps } from 'vue'

defineOptions({ layout: AdminLayout })

const props = defineProps({
  contact: Object,
})

const blink = ref(false)

const form = useForm({
  page_title: props.contact?.page_title || '',
  breadcrumb_title: props.contact?.breadcrumb_title || '',
  office_location: props.contact?.office_location || '',
  phone_numbers: (props.contact?.phone_numbers || []).join(', '),
  emails: (props.contact?.emails || []).join(', '),
  newsletter_title: props.contact?.newsletter_title || '',
  newsletter_subtitle: props.contact?.newsletter_subtitle || '',
  call_us_text: props.contact?.call_us_text || '',
  call_us_number: props.contact?.call_us_number || '',
})

const save = () => {
  const payload = {
    ...form.data(),
    phone_numbers: form.phone_numbers.split(',').map(s => s.trim()),
    emails: form.emails.split(',').map(s => s.trim()),
  }

  blink.value = true

  form.post(route('admin.contact-us.update'), {
    preserveScroll: true,
    data: payload,
    onFinish: () => {
      setTimeout(() => (blink.value = false), 400)
    },
  })
}
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>

<style>
@import 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css';
</style>
