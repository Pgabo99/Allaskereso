<script setup lang="ts">
import { isAuthenticated, logout } from '../services/auth';
</script>

<template>
    <aside class="w-56 h-screen bg-gray-800 text-white p-4">
        <h2 class="text-xl font-bold mb-4">Menu</h2>

        <nav class="space-y-2">
            <router-link v-if="!isAuthenticated" to="/login" class="block hover:bg-gray-700 p-2 rounded">Bejelentkezés</router-link>
            <router-link v-if="!isAuthenticated" to="/register" class="block hover:bg-gray-700 p-2 rounded">Regisztráció</router-link>
            <router-link v-if="isAuthenticated" to="/job_create" class="block hover:bg-gray-700 p-2 rounded">Új munka hozzáadása</router-link>
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
