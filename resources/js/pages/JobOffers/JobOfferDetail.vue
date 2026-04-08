<script setup lang="ts">
import {ref, computed, onMounted} from 'vue';
import {useRoute, useRouter} from 'vue-router';
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
    has_right_to_edit: boolean
}

interface Job {
    id: string;
    title: string;
    children: { id: string; title: string }[];
}

const workModeLabels: Record<string, string> = {
    ON_SITE: 'Irodai',
    REMOTE: 'Távoli',
    HYBRID: 'Hibrid',
};

const workModes = [
    {value: 'ON_SITE', label: 'Irodai'},
    {value: 'REMOTE', label: 'Távoli'},
    {value: 'HYBRID', label: 'Hibrid'},
];

const route = useRoute();
const router = useRouter();
const jobOffer = ref<JobOffer | null>(null);
const notFound = ref(false);
const editing = ref(false);
const jobs = ref<Job[]>([]);
const errors = ref<Record<string, string[]>>({});

const backLink = computed(() => {
    const companyId = route.query.company_id;
    return companyId ? `/job-offer/create?company_id=${companyId}` : '/job-offers';
});

const form = ref({
    title: '',
    description: '',
    salary_min: 0,
    salary_max: 0,
    location: '',
    work_mode: 'ON_SITE',
    job_id: '',
    company_id: '',
});

const startEdit = () => {
    if (!jobOffer.value) return;
    form.value = {
        title: jobOffer.value.title,
        description: jobOffer.value.description,
        salary_min: jobOffer.value.salary_min,
        salary_max: jobOffer.value.salary_max,
        location: jobOffer.value.location,
        work_mode: jobOffer.value.work_mode,
        job_id: jobOffer.value.job_id,
        company_id: jobOffer.value.company?.id ?? '',
    };
    editing.value = true;
};

const cancelEdit = () => {
    editing.value = false;
    errors.value = {};
};

const submitEdit = async () => {
    errors.value = {};
    try {
        await axiosInstance.get('/sanctum/csrf-cookie');
        const response = await axiosInstance.put(`job-offer/${route.params.id}`, form.value);
        jobOffer.value = {...jobOffer.value, ...response.data.job_offer};
        editing.value = false;
    } catch (e: any) {
        if (e.response?.status === 422) {
            errors.value = e.response.data.errors;
        }
    }
};

const deleteOffer = async () => {
    if (!confirm('Biztosan törölni szeretnéd ezt az álláshirdetést?')) return;
    await axiosInstance.get('/sanctum/csrf-cookie');
    await axiosInstance.delete(`job-offer/${route.params.id}`);
    router.push(backLink.value);
};

onMounted(async () => {
    try {
        const [offerRes, jobsRes] = await Promise.all([
            axiosInstance.get(`job-offer/${route.params.id}`),
            axiosInstance.get('job/list'),
        ]);
        jobOffer.value = offerRes.data;
        jobs.value = jobsRes.data;
    } catch (e: any) {
        if (e.response?.status === 404) {
            notFound.value = true;
        }
    }
});
</script>

<template>
    <div class="max-w-2xl mx-auto p-6">
        <router-link :to="backLink"
                     class="inline-flex items-center gap-1 text-sm text-gray-600 hover:text-gray-900 mb-4">
            ← Vissza az álláshirdetésekhez
        </router-link>

        <div v-if="notFound" class="p-3 bg-red-100 text-red-800 rounded text-sm">
            Az álláshirdetés nem található.
        </div>

        <div v-else-if="jobOffer">
            <!-- Edit form -->
            <form v-if="editing" class="bg-white border border-default rounded-lg shadow-xs p-8"
                  @submit.prevent="submitEdit">

                <div class="relative z-0 w-full mb-5 group">
                    <input id="edit_title" v-model="form.title" type="text" placeholder=" " required
                           class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"/>
                    <label for="edit_title"
                           class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Pozíció neve</label>
                    <p v-if="errors.title" class="text-red-500 text-xs mt-1">{{ errors.title[0] }}</p>
                </div>

                <div class="relative z-0 w-full mb-5 group">
                    <label for="edit_job_id" class="sr-only">Munkakör</label>
                    <select id="edit_job_id" v-model="form.job_id" required
                            class="block py-2.5 ps-0 w-full text-sm text-body bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer">
                        <option value="" disabled>Munkakör</option>
                        <template v-for="job in jobs" :key="job.id">
                            <option :value="job.id">{{ job.title }}</option>
                            <option v-for="child in job.children" :key="child.id" :value="child.id">&nbsp;&nbsp;↳ {{ child.title }}</option>
                        </template>
                    </select>
                    <p v-if="errors.job_id" class="text-red-500 text-xs mt-1">{{ errors.job_id[0] }}</p>
                </div>

                <div class="relative z-0 w-full mb-5 group">
                    <input id="edit_location" v-model="form.location" type="text" placeholder=" " required
                           class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"/>
                    <label for="edit_location"
                           class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Helyszín</label>
                    <p v-if="errors.location" class="text-red-500 text-xs mt-1">{{ errors.location[0] }}</p>
                </div>

                <div class="relative z-0 w-full mb-5 group">
                    <label for="edit_work_mode" class="sr-only">Munkavégzés módja</label>
                    <select id="edit_work_mode" v-model="form.work_mode"
                            class="block py-2.5 ps-0 w-full text-sm text-body bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer">
                        <option v-for="mode in workModes" :key="mode.value" :value="mode.value">{{ mode.label }}</option>
                    </select>
                </div>

                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-5 group">
                        <input id="edit_salary_min" v-model="form.salary_min" type="number" min="0" step="10000" placeholder=" " required
                               class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"/>
                        <label for="edit_salary_min"
                               class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Min. fizetés (Ft)</label>
                        <p v-if="errors.salary_min" class="text-red-500 text-xs mt-1">{{ errors.salary_min[0] }}</p>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <input id="edit_salary_max" v-model="form.salary_max" type="number" min="0" step="10000" placeholder=" " required
                               class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"/>
                        <label for="edit_salary_max"
                               class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Max. fizetés (Ft)</label>
                        <p v-if="errors.salary_max" class="text-red-500 text-xs mt-1">{{ errors.salary_max[0] }}</p>
                    </div>
                </div>

                <div class="relative z-0 w-full mb-5 group">
                    <textarea id="edit_description" v-model="form.description" placeholder=" " rows="4"
                              class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"></textarea>
                    <label for="edit_description"
                           class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Leírás</label>
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                            class="text-white bg-gray-800 box-border border border-transparent hover:bg-black hover:cursor-pointer focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-full text-sm px-4 py-2.5 focus:outline-none">
                        Mentés
                    </button>
                    <button type="button" @click="cancelEdit"
                            class="box-border border border-gray-300 text-gray-700 hover:bg-gray-100 hover:cursor-pointer focus:ring-4 focus:ring-gray-200 shadow-xs font-medium leading-5 rounded-full text-sm px-4 py-2.5 focus:outline-none">
                        Mégse
                    </button>
                </div>
            </form>

            <!-- Detail card -->
            <div v-else class="bg-white border border-default rounded-lg shadow-xs p-8">
                <div class="flex items-start justify-between mb-1">
                    <h1 class="text-3xl font-semibold tracking-tight text-heading leading-8">{{ jobOffer.title }}</h1>
                    <div v-if="jobOffer.has_right_to_edit" class="flex gap-2 ml-4 shrink-0">
                        <button @click="startEdit"
                                class="text-white bg-gray-800 box-border border border-transparent hover:bg-black hover:cursor-pointer focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-full text-sm px-4 py-2.5 focus:outline-none">
                            Szerkesztés
                        </button>
                        <button @click="deleteOffer"
                                class="box-border border border-red-300 text-red-600 hover:bg-red-50 hover:cursor-pointer focus:ring-4 focus:ring-red-200 shadow-xs font-medium leading-5 rounded-full text-sm px-4 py-2.5 focus:outline-none">
                            Törlés
                        </button>
                    </div>
                </div>

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
        </div>

        <div v-else class="text-body">Betöltés...</div>
    </div>
</template>
