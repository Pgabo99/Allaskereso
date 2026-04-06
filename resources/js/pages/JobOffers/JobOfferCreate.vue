<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axiosInstance from '../../../lib/axios';

const route = useRoute();
const router = useRouter();

interface Job {
    id: string;
    title: string;
    children: { id: string; title: string }[];
}

const jobs = ref<Job[]>([]);
const success = ref(false);
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

const workModes = [
    { value: 'ON_SITE', label: 'Irodai' },
    { value: 'REMOTE', label: 'Távoli' },
    { value: 'HYBRID', label: 'Hibrid' },
];

const fetchJobs = async () => {
    try {
        const response = await axiosInstance.get('job/list');
        jobs.value = response.data;
    } catch (e) {
        console.error(e);
    }
};

const submit = async () => {
    errors.value = {};
    success.value = false;
    try {
        await axiosInstance.get('/sanctum/csrf-cookie');
        await axiosInstance.post('job-offer', form.value);
        router.push('/company/create');
    } catch (e: any) {
        if (e.response?.status === 422) {
            errors.value = e.response.data.errors;
        }
    }
};

onMounted(fetchJobs);
</script>

<template>
    <div class="max-w-md mx-auto">
        <h1 class="text-3xl text-slate-800 p-4">Új álláshirdetés</h1>

        <form class="max-w-md mx-auto p-4 bg-white rounded-lg shadow-md dark:bg-gray-800" @submit.prevent="submit">

            <div v-if="success" class="mb-5 p-3 bg-green-100 text-green-800 rounded text-sm">
                A pozíció sikeresen létrehozva.
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <input id="floating_title" v-model="form.title" type="text" name="floating_title" placeholder=" " required
                    class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer" />
                <label for="floating_title" class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Pozíció neve</label>
                <p v-if="errors.title" class="text-red-500 text-xs mt-1">{{ errors.title[0] }}</p>
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <label for="floating_job_id" class="sr-only">Munkakör</label>
                <select id="floating_job_id" v-model="form.job_id" required
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
                <input id="floating_location" v-model="form.location" type="text" name="floating_location" placeholder=" " required
                    class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer" />
                <label for="floating_location" class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Helyszín</label>
                <p v-if="errors.location" class="text-red-500 text-xs mt-1">{{ errors.location[0] }}</p>
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <label for="floating_work_mode" class="sr-only">Munkavégzés módja</label>
                <select id="floating_work_mode" v-model="form.work_mode"
                    class="block py-2.5 ps-0 w-full text-sm text-body bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer">
                    <option v-for="mode in workModes" :key="mode.value" :value="mode.value">{{ mode.label }}</option>
                </select>
                <p v-if="errors.work_mode" class="text-red-500 text-xs mt-1">{{ errors.work_mode[0] }}</p>
            </div>

            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-5 group">
                    <input id="floating_salary_min" v-model="form.salary_min" type="number" min="0" name="floating_salary_min" placeholder=" " required step="10000"
                        class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer" />
                    <label for="floating_salary_min" class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Min. fizetés (Ft)</label>
                    <p v-if="errors.salary_min" class="text-red-500 text-xs mt-1">{{ errors.salary_min[0] }}</p>
                </div>

                <div class="relative z-0 w-full mb-5 group">
                    <input id="floating_salary_max" v-model="form.salary_max" type="number" min="0" name="floating_salary_max" placeholder=" " required step="10000"
                        class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer" />
                    <label for="floating_salary_max" class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Max. fizetés (Ft)</label>
                    <p v-if="errors.salary_max" class="text-red-500 text-xs mt-1">{{ errors.salary_max[0] }}</p>
                </div>
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <textarea id="floating_description" v-model="form.description" name="floating_description" placeholder=" " rows="4"
                    class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"></textarea>
                <label for="floating_description" class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Leírás</label>
                <p v-if="errors.description" class="text-red-500 text-xs mt-1">{{ errors.description[0] }}</p>
            </div>

            <button type="submit"
                class="text-white bg-gray-800 box-border border border-transparent hover:bg-black hover:cursor-pointer focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-full text-sm px-4 py-2.5 focus:outline-none">
                Hirdetés feladása
            </button>

        </form>
    </div>
</template>
