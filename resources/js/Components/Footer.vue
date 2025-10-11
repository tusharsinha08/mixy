<template>
    <footer class="bg-white pt-14 pb-6 text-gray-700">
        <!-- Top Grid -->
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-10 border-b pb-10">

            <!-- Logo + Social -->
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <img src="/assets/images/logo.png" alt="Mixy" class="h-10 object-contain" />
                </div>
                <div class="flex gap-3 mt-4">
                    <a href="#" class="text-blue-600 hover:text-blue-800 text-xl"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-sky-400 hover:text-sky-600 text-xl"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-pink-500 hover:text-pink-700 text-xl"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-red-500 hover:text-red-700 text-xl"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <!-- Information -->
            <div>
                <h5 class="font-semibold text-gray-900 mb-4">INFORMATION</h5>
                <ul class="space-y-2 text-sm">
                    <li>
                        <Link href="/contact" class="hover:text-green-600">Contact Us</Link>
                    </li>
                    <li>
                        <Link href="/about" class="hover:text-green-600">About Us</Link>
                    </li>
                    <li>
                        <Link href="/privacy" class="hover:text-green-600">Privacy Policy</Link>
                    </li>
                    <li>
                        <Link href="/wishlist" class="hover:text-green-600">Wishlist</Link>
                    </li>
                    <li>
                        <Link href="/checkout" class="hover:text-green-600">Checkout</Link>
                    </li>
                </ul>
            </div>

            <!-- My Account -->
            <div>
                <h5 class="font-semibold text-gray-900 mb-4">MY ACCOUNT</h5>
                <ul class="space-y-2 text-sm">
                    <li>
                        <Link href="/orders" class="hover:text-green-600">Orders</Link>
                    </li>
                    <li>
                        <Link href="/downloads" class="hover:text-green-600">Downloads</Link>
                    </li>
                    <li>
                        <Link href="/addresses" class="hover:text-green-600">Addresses</Link>
                    </li>
                    <li>
                        <Link href="/account" class="hover:text-green-600">Account Details</Link>
                    </li>
                    <li>
                        <Link href="/forgot-password" class="hover:text-green-600">Lost Password</Link>
                    </li>
                </ul>
            </div>

            <!-- Download App -->
            <div>
                <h5 class="font-semibold text-gray-900 mb-4">DOWNLOAD OUR APP</h5>
                <p class="text-sm text-gray-500 mb-3">Fast & Convenient Access</p>
                <div class="flex items-center gap-3">
                    <img src="/assets/images/others/apple_store.png" alt="App Store" class="h-10 object-contain" />
                    <img src="/assets/images/others/google_play.png" alt="Google Play" class="h-10 object-contain" />
                </div>
            </div>

        </div>

        <!-- Copyright -->
        <div class="max-w-7xl mx-auto px-6 mt-6 text-sm text-gray-500 text-center">
            <div class="flex flex-col md:flex-row items-center justify-between gap-3">
                <p>Copyright © HasThemes. All Rights Reserved.</p>
                <img src="/assets/images/others/payment.png" alt="Visa" class="h-6" />
            </div>
        </div>
    </footer>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<style scoped>
footer {
    font-family: 'Inter', sans-serif;
}
</style>
