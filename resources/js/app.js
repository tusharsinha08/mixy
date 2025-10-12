import './bootstrap'
import '../css/app.css'
import '@fortawesome/fontawesome-free/css/all.min.css'

import { createInertiaApp } from '@inertiajs/vue3'
import { createApp, h } from 'vue'
import { ZiggyVue } from '../../vendor/tightenco/ziggy'
import AppLayout from '@/Layouts/AppLayout.vue' // ✅ Import your layout

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'

createInertiaApp({
  title: (title) => `${title} - ${appName}`,

  // ✅ Move this logic into resolve()
  resolve: (name) => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    const page = pages[`./Pages/${name}.vue`]

    // ✅ Apply AppLayout by default if not set
    page.default.layout ??= AppLayout

    return page
  },

  setup({ el, App, props, plugin }) {
    const vueApp = createApp({ render: () => h(App, props) })

    vueApp.use(plugin)
    vueApp.use(ZiggyVue)

    vueApp.mount(el)
    return vueApp
  },

  progress: {
    color: '#4B5563',
  },
});
