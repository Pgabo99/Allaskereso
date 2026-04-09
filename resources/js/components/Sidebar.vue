<script setup lang="ts">
import { isAuthenticated, logout, isAdmin } from '../services/auth';
</script>

<template>
    <aside class="w-56 shrink-0 bg-gray-800 text-white p-4 sticky top-0 h-screen">
        <h2 class="text-xl font-bold mb-4">Menü</h2>

        <nav class="space-y-2">
            <router-link v-if="!isAuthenticated" to="/login" class="block hover:bg-gray-700 p-2 rounded">Bejelentkezés</router-link>
            <router-link v-if="!isAuthenticated" to="/register" class="block hover:bg-gray-700 p-2 rounded">Regisztráció</router-link>
            <router-link v-if="isAuthenticated" to="/job-offers" class="block hover:bg-gray-700 p-2 rounded">Álláshirdetések</router-link>
            <router-link v-if="isAuthenticated" to="/company/create" class="block hover:bg-gray-700 p-2 rounded">Cégek</router-link>
            <router-link v-if="isAuthenticated" to="/profile" class="block hover:bg-gray-700 p-2 rounded">Profilom</router-link>
            <router-link v-if="isAuthenticated && !isAdmin" to="/my-applications" class="block hover:bg-gray-700 p-2 rounded">Jelentkezéseim</router-link>
            <router-link v-if="isAdmin" to="/job-offer/create" class="block hover:bg-gray-700 p-2 rounded">Álláshirdetések kezelése</router-link>
            <router-link v-if="isAdmin" to="/job_list" class="block hover:bg-gray-700 p-2 rounded">Munkakörök</router-link>
            <router-link v-if="isAdmin" to="/admin/users" class="block hover:bg-gray-700 p-2 rounded">Felhasználók</router-link>
            <button v-if="isAuthenticated" @click="logout" class="block hover:bg-gray-700 p-2 rounded">Kijelentkezés</button>
        </nav>
    </aside>
</template>

<style scoped>
    .sidebar {
        width: 220px;
        height: 100vh;
        background: #1f2937;
        color: white;
        padding: 20px;
    }

    .sidebar a {
        color: white;
        text-decoration: none;
    }

    .sidebar li {
        margin: 10px 0;
    }
</style>
