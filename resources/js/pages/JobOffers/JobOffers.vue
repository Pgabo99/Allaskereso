<script setup lang="ts">
import {ref, computed, onMounted} from 'vue';
import axiosInstance from '../../../lib/axios';
import JobCard from './JobCard.vue';

const withdraw = async (applicationId: string) => {
    if (!confirm('Biztosan visszavonod a jelentkezésedet?')) return;
    await axiosInstance.get('/sanctum/csrf-cookie');
    await axiosInstance.delete(`application/${applicationId}`);
    const offer = jobOffers.value.find(o => o.application_id === applicationId);
    if (offer) {
        offer.application_id = undefined;
        offer.application_status = undefined;
    }
};

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
    application_id?: string;
    application_status?: 'PENDING' | 'APPROVED' | 'DECLINED';
}

const workModes = [
    {value: 'ON_SITE', label: 'Irodai'},
    {value: 'REMOTE', label: 'Távoli'},
    {value: 'HYBRID', label: 'Hibrid'},
];

const jobOffers = ref<JobOffer[]>([]);
const showFilters = ref(false);

const filters = ref({
    search: '',
    location: '',
    work_mode: '',
    salary_min: '',
});

const filteredOffers = computed(() => {
    return jobOffers.value.filter(offer => {
        if (filters.value.search && !offer.title.toLowerCase().includes(filters.value.search.toLowerCase())) {
            return false;
        }
        if (filters.value.location && !offer.location.toLowerCase().includes(filters.value.location.toLowerCase())) {
            return false;
        }
        if (filters.value.work_mode && offer.work_mode !== filters.value.work_mode) {
            return false;
        }
        if (filters.value.salary_min && offer.salary_max < Number(filters.value.salary_min)) {
            return false;
        }
        return true;
    });
});

const fetchJobOffers = async () => {
    try {
        const response = await axiosInstance.get('job-offer');
        jobOffers.value = response.data;
    } catch (e) {
        console.error(e);
    }
};

onMounted(fetchJobOffers);
</script>

<template>
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl text-slate-800">Álláshirdetések</h1>
            <button @click="showFilters = !showFilters"
                    class="text-white bg-gray-800 box-border border border-transparent hover:bg-black hover:cursor-pointer focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-full text-sm px-4 py-2.5 focus:outline-none inline-flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                </svg>
                Szűrés
            </button>
        </div>

        <form v-if="showFilters"
              class="bg-white border border-default rounded-lg shadow-xs p-4 mb-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4"
              @submit.prevent>
            <div class="relative z-0 w-full group">
                <input
                    id="filter_search" v-model="filters.search" type="text" placeholder=" "
                    class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"
                />
                <label for="filter_search"
                       class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Keresés</label>
            </div>

            <div class="relative z-0 w-full group">
                <input
                    id="filter_location" v-model="filters.location" type="text" placeholder=" "
                    class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"
                />
                <label for="filter_location"
                       class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Helyszín</label>
            </div>

            <div class="relative z-0 w-full group">
                <select
                    id="filter_work_mode" v-model="filters.work_mode"
                    class="block py-2.5 ps-0 w-full text-sm text-body bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"
                >
                    <option value="">Munkavégzés módja</option>
                    <option v-for="mode in workModes" :key="mode.value" :value="mode.value">{{ mode.label }}</option>
                </select>
            </div>

            <div class="relative z-0 w-full group">
                <input
                    id="filter_salary" v-model="filters.salary_min" type="number" min="0" placeholder=" " step="10000"
                    class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"
                />
                <label for="filter_salary"
                       class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Min.
                    fizetés (Ft)</label>
            </div>
        </form>

        <div class="grid gap-4 [grid-template-columns:repeat(auto-fill,400px)]">
            <JobCard
                v-for="offer in filteredOffers"
                :key="offer.id"
                :id="offer.id"
                :title="offer.title"
                :description="offer.description || offer.location + ' · ' + offer.salary_min.toLocaleString() + ' – ' + offer.salary_max.toLocaleString() + ' Ft'"
                :company_name="offer.company?.name"
                :status="offer.application_status"
                :application-id="offer.application_id"
                @withdraw="withdraw"
            />
        </div>
        <p v-if="filteredOffers.length === 0" class="text-body">Nincs elérhető álláshirdetés.</p>
    </div>
</template>
