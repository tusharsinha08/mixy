<template>
  <div>
    <Navbar :settings="$page.props.headerSettings" />
    <main>
      <slot /> <!-- Page content will render here -->
    </main>
    <Footer :settings="headerSettings" />
  </div>
</template>

<script>
import Navbar from '@/Components/Navbar.vue'
import Footer from '@/Components/Footer.vue'

export default {
  name: "AppLayout",
  components: {
    Navbar,
    Footer
  },
  props: {
    settings: {
      type: Object,
      default: () => ({})
    }
  }
}
</script>

<style scoped>
main {
  min-height: 100vh;
}
</style>
