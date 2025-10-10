import { createRouter, createWebHistory } from "vue-router";
import Home from "./Pages/Home.vue";
import Shop from "./Pages/Shop.vue";
import About from "./Pages/About.vue";
import Contact from "./Pages/Contact.vue";

const routes = [
  { path: "/", component: Home },
  { path: "/shop", component: Shop },
  { path: "/about", component: About },
  { path: "/contact", component: Contact },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
