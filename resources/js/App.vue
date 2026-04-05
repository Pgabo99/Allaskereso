<script setup lang="ts">
import Sidebar from './components/Sidebar.vue'
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
    }

    .content {
        padding: 20px;
        flex: 1;
    }
</style>
