<script setup lang="ts">
import {ref, onMounted} from 'vue';
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
const showForm = ref(false);

const editingCompany = ref<Company | null>(null);
const editForm = ref({name: '', contact_email: '', location: '', tax_id: ''});
const editErrors = ref<Record<string, string[]>>({});

const cancel = () => {
    showForm.value = false;
    errors.value = {};
    generalError.value = '';
    form.value = {name: '', contact_email: '', location: '', tax_id: ''};
};

const startEdit = (company: Company) => {
    editingCompany.value = company;
    editForm.value = {
        name: company.name,
        contact_email: company.contact_email,
        location: company.location,
        tax_id: company.tax_id
    };
    editErrors.value = {};
    showForm.value = false;
};

const cancelEdit = () => {
    editingCompany.value = null;
    editErrors.value = {};
};

const deleteCompany = async () => {
    if (!confirm(`Biztosan törölni szeretnéd a(z) "${editingCompany.value!.name}" céget?`)) return;
    try {
        await axiosInstance.get('/sanctum/csrf-cookie');
        await axiosInstance.delete(`company/${editingCompany.value!.id}`);
        cancelEdit();
        await fetchCompanies();
    } catch (e) {
        console.error(e);
    }
};

const submitEdit = async () => {
    editErrors.value = {};
    try {
        await axiosInstance.get('/sanctum/csrf-cookie');
        await axiosInstance.put(`company/${editingCompany.value!.id}`, editForm.value);
        cancelEdit();
        await fetchCompanies();
    } catch (e: any) {
        if (e.response?.status === 422) {
            editErrors.value = e.response.data.errors;
        }
    }
};

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
        form.value = {name: '', contact_email: '', location: '', tax_id: ''};
        showForm.value = false;
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
    <div class="max-w-5xl mx-auto">
        <div class="flex items-center justify-between p-4">
            <h1 class="text-3xl text-slate-800">Cégek</h1>
            <button v-if="!showForm && !editingCompany" @click="showForm = true"
                    class="text-white bg-gray-800 box-border border border-transparent hover:bg-black hover:cursor-pointer focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-full text-sm px-4 py-2.5 focus:outline-none">
                + Létrehozás
            </button>
        </div>

        <form v-if="showForm" class="mx-4 p-4 bg-white rounded-lg shadow-md dark:bg-gray-800 mb-6"
              @submit.prevent="submit">

            <div v-if="success" class="mb-5 p-3 bg-green-100 text-green-800 rounded text-sm">
                A cég sikeresen létrehozva.
            </div>

            <div v-if="generalError" class="mb-5 p-3 bg-red-100 text-red-800 rounded text-sm">
                {{ generalError }}
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <input id="floating_name" v-model="form.name" type="text" name="floating_name" placeholder=" " required
                       class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"/>
                <label for="floating_name"
                       class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Cég
                    neve</label>
                <p v-if="errors.name" class="text-red-500 text-xs mt-1">{{ errors.name[0] }}</p>
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <input id="floating_contact_email" v-model="form.contact_email" type="email"
                       name="floating_contact_email" placeholder=" " required
                       class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"/>
                <label for="floating_contact_email"
                       class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Kapcsolattartó
                    email</label>
                <p v-if="errors.contact_email" class="text-red-500 text-xs mt-1">{{ errors.contact_email[0] }}</p>
            </div>

            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-5 group">
                    <input id="floating_location" v-model="form.location" type="text" name="floating_location"
                           placeholder=" " required
                           class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"/>
                    <label for="floating_location"
                           class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Székhely</label>
                    <p v-if="errors.location" class="text-red-500 text-xs mt-1">{{ errors.location[0] }}</p>
                </div>

                <div class="relative z-0 w-full mb-5 group">
                    <input id="floating_tax_id" v-model="form.tax_id" type="text" name="floating_tax_id" placeholder=" "
                           required
                           class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"/>
                    <label for="floating_tax_id"
                           class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Adószám</label>
                    <p v-if="errors.tax_id" class="text-red-500 text-xs mt-1">{{ errors.tax_id[0] }}</p>
                </div>
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

        <form v-if="editingCompany" class="mx-4 p-4 bg-white rounded-lg shadow-md dark:bg-gray-800 mb-6"
              @submit.prevent="submitEdit">
            <h2 class="text-lg font-semibold text-heading mb-4">Cég szerkesztése</h2>

            <div class="relative z-0 w-full mb-5 group">
                <input id="edit_name" v-model="editForm.name" type="text" placeholder=" " required
                       class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"/>
                <label for="edit_name"
                       class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Cég
                    neve</label>
                <p v-if="editErrors.name" class="text-red-500 text-xs mt-1">{{ editErrors.name[0] }}</p>
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <input id="edit_contact_email" v-model="editForm.contact_email" type="email" placeholder=" " required
                       class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"/>
                <label for="edit_contact_email"
                       class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Kapcsolattartó
                    email</label>
                <p v-if="editErrors.contact_email" class="text-red-500 text-xs mt-1">{{
                        editErrors.contact_email[0]
                    }}</p>
            </div>

            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-5 group">
                    <input id="edit_location" v-model="editForm.location" type="text" placeholder=" " required
                           class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"/>
                    <label for="edit_location"
                           class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Székhely</label>
                    <p v-if="editErrors.location" class="text-red-500 text-xs mt-1">{{ editErrors.location[0] }}</p>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input id="edit_tax_id" v-model="editForm.tax_id" type="text" placeholder=" " required
                           class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"/>
                    <label for="edit_tax_id"
                           class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Adószám</label>
                    <p v-if="editErrors.tax_id" class="text-red-500 text-xs mt-1">{{ editErrors.tax_id[0] }}</p>
                </div>
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
                <button type="button" @click="deleteCompany"
                        class="text-white bg-red-600 box-border border border-transparent hover:bg-red-700 hover:cursor-pointer focus:ring-4 focus:ring-red-300 shadow-xs font-medium leading-5 rounded-full text-sm px-4 py-2.5 focus:outline-none ml-auto">
                    Törlés
                </button>
            </div>
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
                            <router-link :to="`/company/${company.id}/employees`" title="Alkalmazottak"
                                         class="text-white bg-gray-800 box-border border border-transparent hover:bg-black hover:cursor-pointer focus:ring-4 focus:ring-brand-medium shadow-xs rounded-full p-2 focus:outline-none inline-flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M17 20h5v-2a4 4 0 00-5-3.87M9 20H4v-2a4 4 0 015-3.87m6-4a4 4 0 11-8 0 4 4 0 018 0zm6-4a3 3 0 11-6 0 3 3 0 016 0zM3 8a3 3 0 116 0A3 3 0 013 8z"/>
                                </svg>
                            </router-link>
                            <router-link :to="`/job-offer/create?company_id=${company.id}`" title="Álláshirdetés"
                                         class="text-white bg-gray-800 box-border border border-transparent hover:bg-black hover:cursor-pointer focus:ring-4 focus:ring-brand-medium shadow-xs rounded-full p-2 focus:outline-none inline-flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </router-link>
                            <button @click="startEdit(company)" title="Szerkesztés"
                                    class="text-white bg-gray-800 box-border border border-transparent hover:bg-black hover:cursor-pointer focus:ring-4 focus:ring-brand-medium shadow-xs rounded-full p-2 focus:outline-none inline-flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
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
