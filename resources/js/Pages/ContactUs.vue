<template>
    <Head title="Contact Us" />
    
    <div class="min-h-screen bg-gray-50">
        <!-- Header/Breadcrumb -->
        <div class="bg-white shadow">
            <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-4">
                        <li>
                            <div>
                                <Link href="/" class="text-gray-400 hover:text-gray-500">
                                    <i class="fas fa-home"></i>
                                    <span class="sr-only">Home</span>
                                </Link>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="text-xs text-gray-400 fas fa-chevron-right"></i>
                                <span class="ml-4 text-sm font-medium text-gray-500">Contact Us</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="mt-2 text-3xl font-bold text-gray-900">Contact Us</h1>
            </div>
        </div>

        <!-- Main Content -->
        <div class="px-4 py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-12 lg:grid-cols-2">
                <!-- Contact Information -->
                <div class="p-8 bg-white rounded-lg shadow-md">
                    <h2 class="mb-6 text-2xl font-bold text-gray-900">Let us know how we can help</h2>
                    <p class="mb-8 text-gray-600">
                        Please contact us using the options below. For fastest reply, please include your name, 
                        organization, appropriate contact information and a brief summary of your inquiry.
                    </p>

                    <div class="space-y-8">
                        <!-- Office Location -->
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 p-3 bg-green-500 rounded-full">
                                <i class="text-lg text-white fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h3 class="mb-2 text-lg font-semibold text-gray-900">Office Location</h3>
                                <p class="text-gray-600">Riverside Building, County Hall, London SE1 7PB, United Kingdom</p>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 p-3 bg-blue-500 rounded-full">
                                <i class="text-lg text-white fas fa-phone"></i>
                            </div>
                            <div>
                                <h3 class="mb-2 text-lg font-semibold text-gray-900">Call us anytime</h3>
                                <p class="text-gray-600">
                                    For immediate help please call:<br>
                                    <strong>1.800.440.0680</strong> or <strong>1.612.696.3400</strong>
                                </p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 p-3 bg-purple-500 rounded-full">
                                <i class="text-lg text-white fas fa-envelope"></i>
                            </div>
                            <div>
                                <h3 class="mb-2 text-lg font-semibold text-gray-900">Send Mail</h3>
                                <p class="text-gray-600">
                                    <a href="mailto:support@mixy.com" class="text-blue-600 hover:text-blue-800 hover:underline">support@mixy.com</a><br>
                                    <a href="mailto:info@mixy.com" class="text-blue-600 hover:text-blue-800 hover:underline">info@mixy.com</a>
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
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Name *</label>
                            <input 
                                type="text" 
                                id="name" 
                                v-model="form.name"
                                required
                                class="w-full px-4 py-3 transition duration-200 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                placeholder="Your full name"
                            >
                        </div>

                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Email *</label>
                            <input 
                                type="email" 
                                id="email" 
                                v-model="form.email"
                                required
                                class="w-full px-4 py-3 transition duration-200 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                placeholder="your.email@example.com"
                            >
                        </div>

                        <div>
                            <label for="phone" class="block mb-2 text-sm font-medium text-gray-700">Phone</label>
                            <input 
                                type="text" 
                                id="phone" 
                                v-model="form.phone"
                                class="w-full px-4 py-3 transition duration-200 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                placeholder="Your phone number"
                            >
                        </div>

                        <div>
                            <label for="message" class="block mb-2 text-sm font-medium text-gray-700">Message *</label>
                            <textarea 
                                id="message" 
                                v-model="form.message"
                                rows="5"
                                required
                                class="w-full px-4 py-3 transition duration-200 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                placeholder="Tell us how we can help you..."
                            ></textarea>
                        </div>

                        <button 
                            type="submit" 
                            :disabled="processing"
                            class="w-full px-6 py-3 text-lg font-semibold text-white transition duration-200 bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span v-if="processing">
                                <i class="mr-2 fas fa-spinner fa-spin"></i>
                                Sending...
                            </span>
                            <span v-else>
                                <i class="mr-2 fas fa-paper-plane"></i>
                                Send Message
                            </span>
                        </button>

                        <div v-if="successMessage" class="p-4 mt-4 border border-green-200 rounded-lg bg-green-50">
                            <div class="flex items-center">
                                <i class="mr-3 text-green-500 fas fa-check-circle"></i>
                                <p class="font-medium text-green-800">{{ successMessage }}</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Map Section -->
            <div class="mt-16 overflow-hidden bg-white rounded-lg shadow-md">
                <div class="relative flex items-center justify-center bg-gray-100 h-80">
                    <div class="z-10 text-center text-gray-500">
                        <i class="mb-4 text-5xl text-green-500 fas fa-map-marked-alt"></i>
                        <h3 class="mb-2 text-xl font-semibold">Our Location</h3>
                        <p class="text-gray-600">Riverside Building, County Hall, London</p>
                    </div>
                    <!-- Simple map placeholder with grid -->
                    <div class="absolute inset-0 opacity-20 bg-gradient-to-br from-green-400 to-blue-400"></div>
                    <div class="absolute inset-0 bg-grid-slate-100 [mask-image:linear-gradient(0deg,#fff,rgba(255,255,255,0.6))]"></div>
                </div>
            </div>

            <!-- Features Section -->
            <div class="grid grid-cols-1 gap-8 mt-16 md:grid-cols-3">
                <div class="p-8 text-center transition duration-300 bg-white rounded-lg shadow-md hover:shadow-lg">
                    <div class="inline-flex p-4 mb-4 bg-green-100 rounded-full">
                        <i class="text-2xl text-green-600 fas fa-shipping-fast"></i>
                    </div>
                    <h3 class="mb-3 text-xl font-bold text-gray-900">Free Shipping</h3>
                    <p class="text-gray-600">Free shipping on orders over $25. Online only. Some exclusions apply.</p>
                </div>

                <div class="p-8 text-center transition duration-300 bg-white rounded-lg shadow-md hover:shadow-lg">
                    <div class="inline-flex p-4 mb-4 bg-blue-100 rounded-full">
                        <i class="text-2xl text-blue-600 fas fa-hand-holding-usd"></i>
                    </div>
                    <h3 class="mb-3 text-xl font-bold text-gray-900">Best Price Guarantee</h3>
                    <p class="text-gray-600">Found a lower price? We'll match it to ensure you get the best deal available.</p>
                </div>

                <div class="p-8 text-center transition duration-300 bg-white rounded-lg shadow-md hover:shadow-lg">
                    <div class="inline-flex p-4 mb-4 bg-purple-100 rounded-full">
                        <i class="text-2xl text-purple-600 fas fa-headset"></i>
                    </div>
                    <h3 class="mb-3 text-xl font-bold text-gray-900">Support 24/7</h3>
                    <p class="text-gray-600">Our dedicated customer service team is available 24 hours a day, 7 days a week.</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const processing = ref(false);
const successMessage = ref('');

const form = useForm({
    name: '',
    email: '',
    phone: '',
    message: ''
});

const submitForm = () => {
    processing.value = true;
    
    // Simulate API call
    setTimeout(() => {
        // In a real app, you would use:
        // form.post('/contact', {
        //     onSuccess: () => {
        //         successMessage.value = 'Thank you for your message! We will get back to you soon.';
        //         form.reset();
        //     }
        // });
        
        successMessage.value = 'Thank you for your message! We will get back to you soon.';
        form.reset();
        processing.value = false;
        
        // Clear success message after 5 seconds
        setTimeout(() => {
            successMessage.value = '';
        }, 5000);
    }, 2000);
};
</script>

<style scoped>
@import 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css';

.bg-grid-slate-100 {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32' width='32' height='32' fill='none' stroke='rgb(148 163 184 / 0.05)'%3e%3cpath d='M0 .5H31.5V32'/%3e%3c/svg%3e");
}
</style>