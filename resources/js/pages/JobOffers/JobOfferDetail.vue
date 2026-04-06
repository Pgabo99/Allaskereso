<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axiosInstance from '../../../lib/axios';

interface JobOffer {
    id: string;
    title: string;
    description: string;
    salary_min: number;
    salary_max: number;
    location: string;
    work_mode: string;
    job_id: string;
    company?: { id: string; name: string };
}

const workModeLabels: Record<string, string> = {
    ON_SITE: 'Irodai',
    REMOTE: 'Távoli',
    HYBRID: 'Hibrid',
};

const route = useRoute();
const jobOffer = ref<JobOffer | null>(null);
const notFound = ref(false);

onMounted(async () => {
    try {
        const response = await axiosInstance.get(`job-offer/${route.params.id}`);
        jobOffer.value = response.data;
    } catch (e: any) {
        if (e.response?.status === 404) {
            notFound.value = true;
        }
    }
});
</script>

<template>
    <div class="max-w-2xl mx-auto p-6">
        <router-link to="/job-offers" class="inline-flex items-center gap-1 text-sm text-gray-600 hover:text-gray-900 mb-4">
            ← Vissza az álláshirdetésekhez
        </router-link>
        <div v-if="notFound" class="p-3 bg-red-100 text-red-800 rounded text-sm">
            Az álláshirdetés nem található.
        </div>

        <div v-else-if="jobOffer" class="bg-white border border-default rounded-lg shadow-xs p-8">
            <h1 class="text-3xl font-semibold tracking-tight text-heading leading-8 mb-1">{{ jobOffer.title }}</h1>
            <p v-if="jobOffer.company" class="text-gray-500 mb-6">{{ jobOffer.company.name }}</p>

            <div class="flex flex-wrap gap-3 mb-6">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-gray-100 text-gray-700">
                    📍 {{ jobOffer.location }}
                </span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-gray-100 text-gray-700">
                    💼 {{ workModeLabels[jobOffer.work_mode] ?? jobOffer.work_mode }}
                </span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-gray-100 text-gray-700">
                    💰 {{ jobOffer.salary_min.toLocaleString() }} – {{ jobOffer.salary_max.toLocaleString() }} Ft
                </span>
            </div>

            <p class="text-body leading-relaxed whitespace-pre-line">{{ jobOffer.description }}</p>
        </div>

        <div v-else class="text-body">Betöltés...</div>
    </div>
</template>
