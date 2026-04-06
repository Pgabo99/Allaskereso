<script setup lang="ts">
import axiosInstance from "../../../lib/axios";
import { reactive, ref, onMounted } from "vue";
import { isAuthenticated } from '../../services/auth';

const emit = defineEmits(["jobCreated"]);
const jobs = ref<any[]>([]);
const errors = ref<Record<string, string[]>>({});
const generalError = ref('');

const loadJobs = async () => {
    const res = await axiosInstance.get('job/list?only_main_jobs=true');
    jobs.value = res.data;
};

onMounted(() => {
    loadJobs();
});
interface JobCreateForm {
    parent_job: string|null,
    title: string,
}

const form = reactive<JobCreateForm>({
    parent_job: null,
    title: "",
});

const createJob = async (payload: JobCreateForm) => {
    errors.value = {};
    generalError.value = '';

    await axiosInstance.get("/sanctum/csrf-cookie");
    try {
        const response = await axiosInstance.post("job/create", payload);
        if (response.data.success) {
            form.parent_job = null;
            form.title = '';
            emit("jobCreated");
        } else {
            generalError.value = response.data.message || 'Hiba történt';
        }
    } catch (error: any) {
        if (error?.response?.status === 422) {
            errors.value = error.response.data.errors;
        } else {
            generalError.value = error?.response?.data?.message || 'Hiba történt';
        }
    }
}
</script>

<template>
    <div class="max-w-md mx-auto">
        <h1 class="text-3xl text-slate-800 p-4">Új munka hozzáadása</h1>
        <form class="max-w-md mx-auto p-4 bg-white rounded-lg shadow-md dark:bg-gray-800" @submit.prevent="createJob(form)">

            <div v-if="generalError" class="mb-5 p-3 bg-red-100 text-red-800 rounded text-sm">
                {{ generalError }}
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <label for="floating_parent_job" class="sr-only">Fő munkakör</label>
                <select id="floating_parent_job" class="block py-2.5 ps-0 w-full text-sm text-body bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer" v-model="form.parent_job">
                    <option :value="null">Fő munkakör</option>
                    <option
                        v-for="job in jobs"
                        :key="job.id"
                        :value="job.id"
                    >
                        {{ job.title }}
                    </option>
                </select>
                <p v-if="errors.parent_job" class="text-red-500 text-xs mt-1">{{ errors.parent_job[0] }}</p>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input id="floating_title" class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer" name="floating_title" placeholder=" " required type="text" v-model="form.title" />
                <label class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto" for="floating_title">Munkaneve</label>
                <p v-if="errors.title" class="text-red-500 text-xs mt-1">{{ errors.title[0] }}</p>
            </div>
            <button class="text-white bg-gray-800 box-border border border-transparent hover:bg-black hover:cursor-pointer focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-full text-sm px-4 py-2.5 focus:outline-none" type="submit">Hozzáadás</button>
        </form>
    </div>
</template>

<style scoped>

</style>
