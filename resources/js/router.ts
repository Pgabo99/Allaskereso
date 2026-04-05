import { createRouter, createWebHistory } from 'vue-router'

import Dashboard from './pages/Dashboard.vue'
import Register from "./pages/auth/Register.vue";
import Login from "./pages/auth/Login.vue";
import JobCreate from "./pages/Jobs/JobCreate.vue";

const routes = [
    { path: '/', component: Dashboard },
    { path: '/register', component: Register },
    { path: '/login', component: Login },
    { path: '/job_create', component: JobCreate },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router
