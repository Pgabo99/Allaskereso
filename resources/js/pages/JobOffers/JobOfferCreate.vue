<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axiosInstance from '../../../lib/axios';

const route = useRoute();

interface Company {
    id: string;
    name: string;
}

interface Job {
    id: string;
    title: string;
    children: { id: string; title: string }[];
}

interface JobOffer {
    id: string;
    title: string;
    salary_min: number;
    salary_max: number;
    location: string;
    work_mode: string;
    company?: { id: string; name: string };
}

const workModes = [
    { value: 'ON_SITE', label: 'Irodai' },
    { value: 'REMOTE', label: 'Távoli' },
    { value: 'HYBRID', label: 'Hibrid' },
];

const companies = ref<Company[]>([]);
const jobs = ref<Job[]>([]);
const jobOffers = ref<JobOffer[]>([]);
const showForm = ref(false);
const errors = ref<Record<string, string[]>>({});

const companyId = route.query.company_id as string | undefined;

const form = ref({
    title: '',
    description: '',
    salary_min: 350000,
    salary_max: 500000,
    location: '',
    work_mode: 'ON_SITE',
    job_id: '',
    company_id: companyId ?? '',
});

const cancel = () => {
    showForm.value = false;
    errors.value = {};
    form.value = { title: '', description: '', salary_min: 350000, salary_max: 500000, location: '', work_mode: 'ON_SITE', job_id: '', company_id: companyId ?? '' };
};

const fetchJobOffers = async () => {
    try {
        const response = await axiosInstance.get('job-offer');
        jobOffers.value = response.data;
    } catch (e) {
        console.error(e);
    }
};

const submit = async () => {
    errors.value = {};
    try {
        await axiosInstance.get('/sanctum/csrf-cookie');
        await axiosInstance.post('job-offer', form.value);
        cancel();
        await fetchJobOffers();
    } catch (e: any) {
        if (e.response?.status === 422) {
            errors.value = e.response.data.errors;
        }
    }
};

onMounted(async () => {
    if (companyId) {
        showForm.value = true;
    }
    await fetchJobOffers();
    const [companiesRes, jobsRes] = await Promise.all([
        axiosInstance.get('company'),
        axiosInstance.get('job/list'),
    ]);
    companies.value = companiesRes.data;
    jobs.value = jobsRes.data;
});
</script>

<template>
    <div class="max-w-5xl mx-auto">
        <div class="flex items-center justify-between p-4">
            <h1 class="text-3xl text-slate-800">Álláshirdetések kezelése</h1>
            <button v-if="!showForm" @click="showForm = true"
                class="text-white bg-gray-800 box-border border border-transparent hover:bg-black hover:cursor-pointer focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-full text-sm px-4 py-2.5 focus:outline-none">
                + Létrehozás
            </button>
        </div>

        <form v-if="showForm" class="mx-4 p-4 bg-white rounded-lg shadow-md dark:bg-gray-800 mb-6" @submit.prevent="submit">

            <div class="relative z-0 w-full mb-5 group">
                <label for="form_company_id" class="sr-only">Cég</label>
                <select id="form_company_id" v-model="form.company_id" required
                    class="block py-2.5 ps-0 w-full text-sm text-body bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer">
                    <option value="" disabled>Cég kiválasztása</option>
                    <option v-for="company in companies" :key="company.id" :value="company.id">{{ company.name }}</option>
                </select>
                <p v-if="errors.company_id" class="text-red-500 text-xs mt-1">{{ errors.company_id[0] }}</p>
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <input id="form_title" v-model="form.title" type="text" placeholder=" " required
                    class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer" />
                <label for="form_title" class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Pozíció neve</label>
                <p v-if="errors.title" class="text-red-500 text-xs mt-1">{{ errors.title[0] }}</p>
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <label for="form_job_id" class="sr-only">Munkakör</label>
                <select id="form_job_id" v-model="form.job_id" required
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
                <input id="form_location" v-model="form.location" type="text" placeholder=" " required
                    class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer" />
                <label for="form_location" class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Helyszín</label>
                <p v-if="errors.location" class="text-red-500 text-xs mt-1">{{ errors.location[0] }}</p>
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <label for="form_work_mode" class="sr-only">Munkavégzés módja</label>
                <select id="form_work_mode" v-model="form.work_mode"
                    class="block py-2.5 ps-0 w-full text-sm text-body bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer">
                    <option v-for="mode in workModes" :key="mode.value" :value="mode.value">{{ mode.label }}</option>
                </select>
                <p v-if="errors.work_mode" class="text-red-500 text-xs mt-1">{{ errors.work_mode[0] }}</p>
            </div>

            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-5 group">
                    <input id="form_salary_min" v-model="form.salary_min" type="number" min="0" placeholder=" " required step="10000"
                        class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer" />
                    <label for="form_salary_min" class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Min. fizetés (Ft)</label>
                    <p v-if="errors.salary_min" class="text-red-500 text-xs mt-1">{{ errors.salary_min[0] }}</p>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input id="form_salary_max" v-model="form.salary_max" type="number" min="0" placeholder=" " required step="10000"
                        class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer" />
                    <label for="form_salary_max" class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Max. fizetés (Ft)</label>
                    <p v-if="errors.salary_max" class="text-red-500 text-xs mt-1">{{ errors.salary_max[0] }}</p>
                </div>
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <textarea id="form_description" v-model="form.description" placeholder=" " rows="4"
                    class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"></textarea>
                <label for="form_description" class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Leírás</label>
                <p v-if="errors.description" class="text-red-500 text-xs mt-1">{{ errors.description[0] }}</p>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                    class="text-white bg-gray-800 box-border border border-transparent hover:bg-black hover:cursor-pointer focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-full text-sm px-4 py-2.5 focus:outline-none">
                    Létrehozás
                </button>
                <button type="button" @click="cancel"
                    class="box-border border border-gray-300 text-gray-700 hover:bg-gray-100 hover:cursor-pointer focus:ring-4 focus:ring-gray-200 shadow-xs font-medium leading-5 rounded-full text-sm px-4 py-2.5 focus:outline-none">
                    Mégse
                </button>
            </div>
        </form>

        <div class="mx-4 p-4">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="pb-2 font-semibold text-heading">Cég</th>
                        <th class="pb-2 font-semibold text-heading">Pozíció</th>
                        <th class="pb-2 font-semibold text-heading">Helyszín</th>
                        <th class="pb-2 font-semibold text-heading">Munkavégzés</th>
                        <th class="pb-2 font-semibold text-heading">Fizetés (Ft)</th>
                        <th class="pb-2"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="offer in jobOffers" :key="offer.id" class="border-b border-gray-100">
                        <td class="py-2 pr-4">{{ offer.company?.name ?? '–' }}</td>
                        <td class="py-2 pr-4">{{ offer.title }}</td>
                        <td class="py-2 pr-4">{{ offer.location }}</td>
                        <td class="py-2 pr-4">{{ workModes.find(m => m.value === offer.work_mode)?.label ?? offer.work_mode }}</td>
                        <td class="py-2 pr-4">{{ offer.salary_min.toLocaleString() }} – {{ offer.salary_max.toLocaleString() }}</td>
                        <td class="py-2">
                            <router-link :to="`/job-offer/${offer.id}`"
                                class="text-white bg-gray-800 box-border border border-transparent hover:bg-black hover:cursor-pointer focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-full text-xs px-3 py-1.5 focus:outline-none whitespace-nowrap">
                                Részletek
                            </router-link>
                        </td>
                    </tr>
                    <tr v-if="jobOffers.length === 0">
                        <td colspan="6" class="py-4 text-body text-center">Nincs még álláshirdetés.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
