import { createRouter, createWebHistory } from 'vue-router';
import Login from './components/Login.vue';
import Dashboard from './components/Dashboard.vue';
import { requireAuth } from './auth.js'; // Import the requireAuth function

const routes = [
    { path: '/', component: Login, name: 'Login' },
    { path: '/dashboard', component: Dashboard, name: 'Dashboard', beforeEnter: requireAuth },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;