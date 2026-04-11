import {createRouter, createWebHistory} from 'vue-router'
import {authInitialized, isAuthenticated, loadUser} from './services/auth'

import Register from "./pages/auth/Register.vue";
import Login from "./pages/auth/Login.vue";
import JobList from "./pages/Jobs/JobList.vue";
import JobOfferCreate from "./pages/JobOffers/JobOfferCreate.vue";
import CompanyCreate from "./pages/Company/CompanyCreate.vue";
import CompanyEmployees from "./pages/Company/CompanyEmployees.vue";
import JobOffers from "./pages/JobOffers/JobOffers.vue";
import JobOfferDetail from "./pages/JobOffers/JobOfferDetail.vue";
import Profile from "./pages/Profile/Profile.vue";
import MyApplications from "./pages/Applications/MyApplications.vue";
import AdminUsers from "./pages/Admin/Users.vue";

const routes = [
    {path: '/', component: Login},
    {path: '/register', component: Register},
    {path: '/login', component: Login},
    {path: '/job_list', component: JobList, meta: {requiresAuth: true}},
    {path: '/job-offers', component: JobOffers, meta: {requiresAuth: true}},
    {path: '/job-offer/create', component: JobOfferCreate, meta: {requiresAuth: true}},
    {path: '/job-offer/:id', component: JobOfferDetail, meta: {requiresAuth: true}},
    {path: '/company/create', component: CompanyCreate, meta: {requiresAuth: true}},
    {path: '/company/:id/employees', component: CompanyEmployees, meta: {requiresAuth: true}},
    {path: '/profile', component: Profile, meta: {requiresAuth: true}},
    {path: '/my-applications', component: MyApplications, meta: {requiresAuth: true}},
    {path: '/admin/users', component: AdminUsers, meta: {requiresAuth: true}},
    {path: '/admin/users/:id', component: Profile, meta: {requiresAuth: true}},
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.beforeEach(async (to) => {
    if (!authInitialized.value) {
        await loadUser();
    }

    if (to.meta.requiresAuth && !isAuthenticated.value) {
        return {path: '/login'};
    }

    if ((to.path === '/' || to.path === '/login' || to.path === '/register') && isAuthenticated.value) {
        return {path: '/job-offers'};
    }

    if (!to.matched.length) {
        return isAuthenticated.value ? {path: '/job-offers'} : {path: '/login'};
    }
});

export default router
