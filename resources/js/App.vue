<script setup lang="ts">
import Sidebar from './components/Sidebar.vue'
import { onMounted } from 'vue';
import { loadUser } from './services/auth';

onMounted(() => {
    loadUser();
});
</script>

<template>
    <div class="layout">
        <Sidebar />

        <main class="content">
            <router-view />
        </main>
    </div>
</template>

<style scoped>
    .layout {
        display: flex;
        min-height: 100vh;
    }

    .content {
        padding: 20px;
        flex: 1;
        min-width: 0;
    }
</style>
