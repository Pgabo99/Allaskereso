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
    has_right_to_edit: boolean;
    application_id: string | null;
    application_status: 'PENDING' | 'APPROVED' | 'DECLINED' | null;
    can_handle_applications: boolean;
}

interface ApplicantRow {
    id: string;
    status: 'PENDING' | 'APPROVED' | 'DECLINED';
    cv_url: string;
    applicant: { name: string; email: string; birth_date: string } | null;
}

interface Job {
    id: string;
    title: string;
    children: { id: string; title: string }[];
}

const statusConfig: Record<string, { label: string; classes: string }> = {
    PENDING:  { label: 'Folyamatban', classes: 'bg-yellow-100 text-yellow-800' },
    APPROVED: { label: 'Elfogadva',   classes: 'bg-green-100 text-green-800' },
    DECLINED: { label: 'Elutasítva',  classes: 'bg-red-100 text-red-800' },
};

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
const applying = ref(false);
const applySuccess = ref(false);
const jobs = ref<Job[]>([]);
const errors = ref<Record<string, string[]>>({});
const applyErrors = ref<Record<string, string[]>>({});
const cvFile = ref<File | null>(null);
const applicants = ref<ApplicantRow[]>([]);

const backLink = computed(() => {
    if (route.query.from === 'my-applications') return '/my-applications';
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

const startApply = () => {
    applying.value = true;
    applySuccess.value = false;
    applyErrors.value = {};
    cvFile.value = null;
};

const cancelApply = () => {
    applying.value = false;
    applyErrors.value = {};
    cvFile.value = null;
};

const onCvChange = (e: Event) => {
    const input = e.target as HTMLInputElement;
    cvFile.value = input.files?.[0] ?? null;
};

const submitApply = async () => {
    applyErrors.value = {};
    if (!cvFile.value) {
        applyErrors.value = { cv: ['Az önéletrajz feltöltése kötelező.'] };
        return;
    }
    try {
        const formData = new FormData();
        formData.append('job_offer_id', route.params.id as string);
        formData.append('cv', cvFile.value);
        await axiosInstance.get('/sanctum/csrf-cookie');
        const res = await axiosInstance.post('application', formData, {
            headers: { 'Content-Type': 'multipart/form-data' },
        });
        applySuccess.value = true;
        applying.value = false;
        if (jobOffer.value) {
            jobOffer.value.application_status = 'PENDING';
            jobOffer.value.application_id = res.data.application_id;
        }
    } catch (e: any) {
        if (e.response?.status === 422) {
            applyErrors.value = e.response.data.errors;
        }
    }
};

const updateApplicationStatus = async (row: ApplicantRow, status: 'APPROVED' | 'DECLINED') => {
    await axiosInstance.get('/sanctum/csrf-cookie');
    const res = await axiosInstance.patch(`application/${row.id}/status`, { status });
    row.status = res.data.status;
};

const deleteApplication = async () => {
    if (!jobOffer.value?.application_id) return;
    if (!confirm('Biztosan visszavonod a jelentkezésedet?')) return;
    await axiosInstance.get('/sanctum/csrf-cookie');
    await axiosInstance.delete(`application/${jobOffer.value.application_id}`);
    jobOffer.value.application_id = null;
    jobOffer.value.application_status = null;
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

        if (offerRes.data.can_handle_applications) {
            const appRes = await axiosInstance.get(`job-offer/${route.params.id}/applications`);
            applicants.value = appRes.data;
        }
    } catch (e: any) {
        if (e.response?.status === 404) {
            notFound.value = true;
        }
    }
});
</script>

<template>
    <div :class="jobOffer?.can_handle_applications ? 'max-w-4xl' : 'max-w-2xl'" class="mx-auto p-6">
        <router-link :to="backLink"
                     class="inline-flex items-center gap-1 text-sm text-gray-600 hover:text-gray-900 mb-4">
            ← {{ route.query.from === 'my-applications' ? 'Vissza a jelentkezéseimhez' : 'Vissza az álláshirdetésekhez' }}
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
                    <div v-else class="flex gap-2 ml-4 shrink-0">
                        <template v-if="jobOffer.application_status">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium"
                                :class="statusConfig[jobOffer.application_status]?.classes"
                            >
                                {{ statusConfig[jobOffer.application_status]?.label }}
                            </span>
                            <button v-if="jobOffer.application_status === 'PENDING'" @click="deleteApplication"
                                    class="box-border border border-red-300 text-red-600 hover:bg-red-50 hover:cursor-pointer focus:ring-4 focus:ring-red-200 shadow-xs font-medium leading-5 rounded-full text-sm px-4 py-2.5 focus:outline-none">
                                Visszavonás
                            </button>
                        </template>
                        <button v-else @click="startApply"
                                class="text-white bg-gray-800 box-border border border-transparent hover:bg-black hover:cursor-pointer focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-full text-sm px-4 py-2.5 focus:outline-none">
                            Jelentkezés
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

                <!-- Apply success message -->
                <div v-if="applySuccess" class="mt-6 p-3 bg-green-100 text-green-800 rounded text-sm">
                    Sikeresen jelentkeztél az állásra!
                </div>

                <!-- Apply form -->
                <form v-if="applying" class="mt-6 border-t border-default pt-6" @submit.prevent="submitApply">
                    <h2 class="text-lg font-semibold text-heading mb-4">Jelentkezés</h2>
                    <div class="relative z-0 w-full mb-5 group">
                        <label for="cv_file" class="block text-sm text-body mb-1">Önéletrajz (PDF, DOC, DOCX – max. 5 MB)</label>
                        <input id="cv_file" type="file" accept=".pdf,.doc,.docx" @change="onCvChange"
                               class="block w-full text-sm text-body border border-default-medium rounded-lg cursor-pointer focus:outline-none"/>
                        <p v-if="applyErrors.cv" class="text-red-500 text-xs mt-1">{{ applyErrors.cv[0] }}</p>
                    </div>
                    <div class="flex gap-3">
                        <button type="submit"
                                class="text-white bg-gray-800 box-border border border-transparent hover:bg-black hover:cursor-pointer focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-full text-sm px-4 py-2.5 focus:outline-none">
                            Jelentkezés beküldése
                        </button>
                        <button type="button" @click="cancelApply"
                                class="box-border border border-gray-300 text-gray-700 hover:bg-gray-100 hover:cursor-pointer focus:ring-4 focus:ring-gray-200 shadow-xs font-medium leading-5 rounded-full text-sm px-4 py-2.5 focus:outline-none">
                            Mégse
                        </button>
                    </div>
                </form>
            </div>

            <!-- Applicants table -->
            <div v-if="jobOffer.can_handle_applications" class="mt-6 bg-white border border-default rounded-lg shadow-xs p-6">
            <h2 class="text-xl font-semibold text-heading mb-4">Jelentkezők</h2>
            <p v-if="applicants.length === 0" class="text-body text-sm">Még nincs jelentkező.</p>
            <div v-else class="overflow-x-auto">
                <table class="w-full text-sm text-left text-body">
                    <thead class="text-xs text-gray-500 uppercase border-b border-default">
                        <tr>
                            <th class="py-3 pr-4">Név</th>
                            <th class="py-3 pr-4">Email</th>
                            <th class="py-3 pr-4">Születési dátum</th>
                            <th class="py-3 pr-4">Önéletrajz</th>
                            <th class="py-3 pr-4">Státusz</th>
                            <th class="py-3">Műveletek</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="row in applicants" :key="row.id" class="border-b border-default last:border-0">
                            <td class="py-3 pr-4 font-medium text-heading">{{ row.applicant?.name ?? '–' }}</td>
                            <td class="py-3 pr-4">{{ row.applicant?.email ?? '–' }}</td>
                            <td class="py-3 pr-4">{{ row.applicant?.birth_date ?? '–' }}</td>
                            <td class="py-3 pr-4">
                                <a :href="row.cv_url" target="_blank"
                                   class="inline-flex items-center gap-1 text-gray-700 hover:text-black underline underline-offset-2">
                                    Megnyitás
                                </a>
                            </td>
                            <td class="py-3 pr-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                    :class="statusConfig[row.status]?.classes"
                                >
                                    {{ statusConfig[row.status]?.label }}
                                </span>
                            </td>
                            <td class="py-3">
                                <div v-if="row.status === 'PENDING'" class="flex gap-2">
                                    <button @click="updateApplicationStatus(row, 'APPROVED')"
                                            class="text-white bg-green-600 hover:bg-green-700 hover:cursor-pointer focus:ring-4 focus:ring-green-300 font-medium rounded-full text-xs px-3 py-1.5 focus:outline-none">
                                        Elfogadás
                                    </button>
                                    <button @click="updateApplicationStatus(row, 'DECLINED')"
                                            class="box-border border border-red-300 text-red-600 hover:bg-red-50 hover:cursor-pointer focus:ring-4 focus:ring-red-200 font-medium rounded-full text-xs px-3 py-1.5 focus:outline-none">
                                        Elutasítás
                                    </button>
                                </div>
                                <span v-else class="text-xs text-gray-400">–</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        </div>

        <div v-else class="text-body">Betöltés...</div>
    </div>
</template>

