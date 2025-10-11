<template>
  <div>
    <Navbar />
    <main>
      <slot /> <!-- Page content will render here -->
    </main>
    <Footer />
  </div>
</template>

<script>
import Navbar from '@/Components/Navbar.vue'
import Footer from '@/Components/Footer.vue'

export default {
  components: {
    Navbar,
    Footer
  }
}
</script>

<style scoped>
main {
  min-height: 100vh;
}
</style>
