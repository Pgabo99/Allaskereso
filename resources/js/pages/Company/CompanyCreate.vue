<script setup lang="ts">
import { ref, onMounted } from 'vue';
import axiosInstance from '../../../lib/axios';

interface Company {
    id: string;
    name: string;
    contact_email: string;
    location: string;
    tax_id: string;
}

const companies = ref<Company[]>([]);

const form = ref({
    name: '',
    contact_email: '',
    location: '',
    tax_id: '',
});

const errors = ref<Record<string, string[]>>({});
const generalError = ref('');
const success = ref(false);

const fetchCompanies = async () => {
    try {
        const response = await axiosInstance.get('company');
        companies.value = response.data;
    } catch (e) {
        console.error(e);
    }
};

const submit = async () => {
    errors.value = {};
    generalError.value = '';
    success.value = false;
    try {
        await axiosInstance.get('/sanctum/csrf-cookie');
        await axiosInstance.post('company', form.value);
        success.value = true;
        form.value = { name: '', contact_email: '', location: '', tax_id: '' };
        await fetchCompanies();
    } catch (e: any) {
        if (e.response?.status === 422) {
            errors.value = e.response.data.errors;
        } else {
            generalError.value = e?.response?.data?.message || 'Hiba történt';
        }
    }
};

onMounted(fetchCompanies);
</script>

<template>
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl text-slate-800 p-4">Cégek</h1>

        <form class="mx-4 p-4 bg-white rounded-lg shadow-md dark:bg-gray-800 mb-6" @submit.prevent="submit">

            <div v-if="success" class="mb-5 p-3 bg-green-100 text-green-800 rounded text-sm">
                A cég sikeresen létrehozva.
            </div>

            <div v-if="generalError" class="mb-5 p-3 bg-red-100 text-red-800 rounded text-sm">
                {{ generalError }}
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <input id="floating_name" v-model="form.name" type="text" name="floating_name" placeholder=" " required
                    class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer" />
                <label for="floating_name" class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Cég neve</label>
                <p v-if="errors.name" class="text-red-500 text-xs mt-1">{{ errors.name[0] }}</p>
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <input id="floating_contact_email" v-model="form.contact_email" type="email" name="floating_contact_email" placeholder=" " required
                    class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer" />
                <label for="floating_contact_email" class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Kapcsolattartó email</label>
                <p v-if="errors.contact_email" class="text-red-500 text-xs mt-1">{{ errors.contact_email[0] }}</p>
            </div>

            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-5 group">
                    <input id="floating_location" v-model="form.location" type="text" name="floating_location" placeholder=" " required
                        class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer" />
                    <label for="floating_location" class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Székhely</label>
                    <p v-if="errors.location" class="text-red-500 text-xs mt-1">{{ errors.location[0] }}</p>
                </div>

                <div class="relative z-0 w-full mb-5 group">
                    <input id="floating_tax_id" v-model="form.tax_id" type="text" name="floating_tax_id" placeholder=" " required
                        class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer" />
                    <label for="floating_tax_id" class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Adószám</label>
                    <p v-if="errors.tax_id" class="text-red-500 text-xs mt-1">{{ errors.tax_id[0] }}</p>
                </div>
            </div>

            <button type="submit"
                class="text-white bg-gray-800 box-border border border-transparent hover:bg-black hover:cursor-pointer focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-full text-sm px-4 py-2.5 focus:outline-none">
                Létrehozás
            </button>
        </form>

        <div class="mx-4 p-4">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="pb-2 font-semibold text-heading">Cég neve</th>
                        <th class="pb-2 font-semibold text-heading">Email</th>
                        <th class="pb-2 font-semibold text-heading">Székhely</th>
                        <th class="pb-2 font-semibold text-heading">Adószám</th>
                        <th class="pb-2"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="company in companies" :key="company.id" class="border-b border-gray-100">
                        <td class="py-2 pr-4">{{ company.name }}</td>
                        <td class="py-2 pr-4">{{ company.contact_email }}</td>
                        <td class="py-2 pr-4">{{ company.location }}</td>
                        <td class="py-2 pr-4">{{ company.tax_id }}</td>
                        <td class="py-2">
                            <div class="flex gap-2">
                                <router-link :to="`/company/${company.id}/employees`"
                                    class="text-white bg-gray-800 box-border border border-transparent hover:bg-black hover:cursor-pointer focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-full text-xs px-3 py-1.5 focus:outline-none whitespace-nowrap">
                                    Alkalmazottak
                                </router-link>
                                <router-link :to="`/job-offer/create?company_id=${company.id}`"
                                    class="text-white bg-gray-800 box-border border border-transparent hover:bg-black hover:cursor-pointer focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-full text-xs px-3 py-1.5 focus:outline-none whitespace-nowrap">
                                    Álláshirdetés
                                </router-link>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="companies.length === 0">
                        <td colspan="5" class="py-4 text-body text-center">Nincs még létrehozott cég.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
