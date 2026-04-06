<script setup lang="ts">
defineProps<{
    id: string;
    title: string;
    description: string;
    company_name?: string;
}>();
</script>

<template>
    <div class="bg-neutral-primary-soft block p-6 border border-default rounded-base shadow-xs rounded-lg">
        <h5 class="mb-3 text-2xl font-semibold tracking-tight text-heading leading-8">{{ title }}</h5>
        <p v-if="company_name" class="text-sm text-gray-500 mb-2">{{ company_name }}</p>
        <p class="text-body mb-6 line-clamp-5">{{ description }}</p>
        <router-link :to="`/job-offer/${id}`" class="inline-flex items-center text-white bg-gray-800 box-border border border-transparent hover:bg-black hover:cursor-pointer focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-full text-sm px-4 py-2.5 focus:outline-none">
            Továbbiak
            <svg class="w-4 h-4 ms-1.5 rtl:rotate-180 -me-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4"/></svg>
        </router-link>
    </div>
</template>

<style scoped>

</style>
