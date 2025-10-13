<template>
  <div class="min-h-[60vh] flex flex-col justify-center items-center py-20 text-center">
    <h1 class="mb-3 text-[10rem] font-black text-black">404</h1>
    <h2 class="mb-3 text-[2.2rem] font-extrabold text-black">Oops! That page can’t be found.</h2>
    <p class="text-base text-black max-w-[500px] mx-auto mb-8 leading-relaxed">
      It looks like nothing was found at this location. Maybe try one of the links below or a search?
    </p>
    <Link href="/" class="bg-green-600 border-green-600 px-8 py-3 font-bold text-white no-underline rounded inline-block text-base transition-all duration-300 hover:bg-green-700 hover:border-green-700 hover:text-white hover:-translate-y-0.5 hover:shadow-md">
      Back to homepage
    </Link>
  </div>
</template>

<script>
import { Link } from '@inertiajs/vue3'

export default {
  name: 'Error404',
  components: {
    Link
  }
}
</script>