import './bootstrap';
import '../css/app.css';
import '@fortawesome/fontawesome-free/css/all.min.css';
import '@vueup/vue-quill/dist/vue-quill.snow.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import AppLayout from '@/Layouts/AppLayout.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
  title: (title) => `${title} - ${appName}`,

  resolve: (name) => {
    const pages = import.meta.glob('./Pages/**/*.vue');
    const page = resolvePageComponent(`./Pages/${name}.vue`, pages);

    page.then((module) => {
      // ✅ If the page is inside "Admin/", use AdminLayout
      if (name.startsWith('Admin/')) {
        module.default.layout = module.default.layout || AdminLayout;
      } else {
        // ✅ Otherwise, use AppLayout
        module.default.layout = module.default.layout || AppLayout;
      }
    });

    return page;
  },

  setup({ el, App, props, plugin }) {
    const vueApp = createApp({ render: () => h(App, props) });

    vueApp.use(plugin);
    vueApp.use(ZiggyVue);

    vueApp.mount(el);
    return vueApp;
  },

  progress: {
    color: '#4B5563',
  },
});
