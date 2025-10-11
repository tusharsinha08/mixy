<template>
  <div>
    <Navbar />
    <main>
      <slot /> <!-- Page content will render here -->
    </main>
  </div>
</template>

<script>
import Navbar from '@/Components/Navbar.vue'

export default {
  components: {
    Navbar
  }
}
</script>

<style scoped>
main {
  min-height: 100vh;
}
</style>
