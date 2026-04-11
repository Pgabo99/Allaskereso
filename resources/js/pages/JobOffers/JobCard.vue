<script setup lang="ts">
defineProps<{
    id: string;
    title: string;
    description: string;
    company_name?: string;
    linkTo?: string;
    status?: 'PENDING' | 'APPROVED' | 'DECLINED';
    applicationId?: string;
}>();

const emit = defineEmits<{
    withdraw: [applicationId: string];
}>();

const statusConfig: Record<string, { label: string; classes: string }> = {
    PENDING:  { label: 'Folyamatban', classes: 'bg-yellow-100 text-yellow-800' },
    APPROVED: { label: 'Elfogadva',   classes: 'bg-green-100 text-green-800' },
    DECLINED: { label: 'Elutasítva',  classes: 'bg-red-100 text-red-800' },
};
</script>

<template>
    <div class="bg-neutral-primary-soft flex flex-col p-6 border border-default rounded-base shadow-xs rounded-lg min-w-0">
        <div class="flex items-start justify-between mb-3 gap-2">
            <h5 class="text-2xl font-semibold tracking-tight text-heading leading-8 truncate">{{ title }}</h5>
            <span
                v-if="status"
                class="shrink-0 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                :class="statusConfig[status]?.classes"
            >
                {{ statusConfig[status]?.label }}
            </span>
        </div>
        <p v-if="company_name" class="text-sm text-gray-500 mb-2">{{ company_name }}</p>
        <p class="text-body mb-6 line-clamp-5">{{ description }}</p>
        <div class="mt-auto flex gap-2">
            <button
                v-if="status === 'PENDING' && applicationId"
                @click="emit('withdraw', applicationId)"
                class="box-border border border-red-300 text-red-600 hover:bg-red-50 hover:cursor-pointer focus:ring-4 focus:ring-red-200 shadow-xs font-medium leading-5 rounded-full text-sm px-4 py-2.5 focus:outline-none"
            >
                Visszavonás
            </button>
            <router-link
                :to="linkTo ?? `/job-offer/${id}`"
                class="inline-flex items-center text-white bg-gray-800 box-border border border-transparent hover:bg-black hover:cursor-pointer focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-full text-sm px-4 py-2.5 focus:outline-none"
            >
                Továbbiak
                <svg class="w-4 h-4 ms-1.5 rtl:rotate-180 -me-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                     width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 12H5m14 0-4 4m4-4-4-4"/>
                </svg>
            </router-link>
        </div>
    </div>
</template>
