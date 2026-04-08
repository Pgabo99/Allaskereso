<script setup lang="ts">
import {ref, onMounted} from 'vue';
import {useRoute} from 'vue-router';
import axiosInstance from '../../../lib/axios';

interface Employee {
    id: string;
    user_id: string;
    rights: string[];
    user?: { name: string; email: string; username: string };
}

const rightsOptions = [
    {value: 'CREATE_JOB_OFFER', label: 'Álláshirdetés létrehozása'},
    {value: 'HANDLE_APPLICATIONS', label: 'Jelentkezések kezelése'},
    {value: 'EDIT_COMPANY_DATA', label: 'Cégadatok szerkesztése'},
];

const route = useRoute();
const employees = ref<Employee[]>([]);
const showForm = ref(false);
const canEditCompany = ref(false);
const ownerId = ref('');
const showRegisterForm = ref(false);
const generalError = ref('');
const registerGeneralError = ref('');
const errors = ref<Record<string, string[]>>({});
const registerErrors = ref<Record<string, string[]>>({});

const form = ref({
    identifier: '',
    rights: [] as string[],
});

const registerForm = ref({
    name: '',
    username: '',
    email: '',
    password: '',
    password_confirmation: '',
    birth_date: '',
    rights: [] as string[],
});

const cancel = () => {
    showForm.value = false;
    generalError.value = '';
    errors.value = {};
    form.value = {identifier: '', rights: []};
};

const cancelRegister = () => {
    showRegisterForm.value = false;
    registerGeneralError.value = '';
    registerErrors.value = {};
    registerForm.value = {
        name: '',
        username: '',
        email: '',
        password: '',
        password_confirmation: '',
        birth_date: '',
        rights: []
    };
};

const fetchEmployees = async () => {
    try {
        const response = await axiosInstance.get(`company/${route.params.id}/employees`);
        employees.value = response.data.employees;
        canEditCompany.value = response.data.canEditCompany;
        ownerId.value = response.data.ownerId;
    } catch (e) {
        console.error(e);
    }
};

const submit = async () => {
    errors.value = {};
    generalError.value = '';
    try {
        await axiosInstance.get('/sanctum/csrf-cookie');
        await axiosInstance.post(`company/${route.params.id}/employees`, form.value);
        cancel();
        await fetchEmployees();
    } catch (e: any) {
        if (e.response?.status === 422) {
            errors.value = e.response.data.errors ?? {};
            if (e.response.data.message) generalError.value = e.response.data.message;
        } else if (e.response?.status === 404) {
            generalError.value = e.response.data.message;
        }
    }
};

const submitRegister = async () => {
    registerErrors.value = {};
    registerGeneralError.value = '';
    try {
        await axiosInstance.get('/sanctum/csrf-cookie');
        await axiosInstance.post(`company/${route.params.id}/employees/register`, registerForm.value);
        cancelRegister();
        await fetchEmployees();
    } catch (e: any) {
        if (e.response?.status === 422) {
            registerErrors.value = e.response.data.errors ?? {};
        }
    }
};

const editingEmployeeId = ref<string | null>(null);
const editingRights = ref<string[]>([]);

const startEditRights = (employee: Employee) => {
    editingEmployeeId.value = employee.id;
    editingRights.value = [...employee.rights];
};

const cancelEditRights = () => {
    editingEmployeeId.value = null;
    editingRights.value = [];
};

const saveRights = async (employeeId: string) => {
    await axiosInstance.get('/sanctum/csrf-cookie');
    await axiosInstance.put(`company/${route.params.id}/employees/${employeeId}`, {rights: editingRights.value});
    cancelEditRights();
    await fetchEmployees();
};

const removeEmployee = async (employeeId: string) => {
    if (!confirm('Biztosan el szeretnéd távolítani ezt az alkalmazottat?')) return;
    await axiosInstance.get('/sanctum/csrf-cookie');
    await axiosInstance.delete(`company/${route.params.id}/employees/${employeeId}`);
    await fetchEmployees();
};

onMounted(fetchEmployees);
</script>

<template>
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center justify-between p-4">
            <div class="flex items-center gap-3">
                <router-link to="/company/create" class="text-sm text-gray-600 hover:text-gray-900">← Vissza
                </router-link>
                <h1 class="text-3xl text-slate-800">Alkalmazottak</h1>
            </div>
            <div v-if="!showForm && !showRegisterForm && canEditCompany" class="flex gap-2">
                <button @click="showForm = true"
                        class="text-white bg-gray-800 box-border border border-transparent hover:bg-black hover:cursor-pointer focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-full text-sm px-4 py-2.5 focus:outline-none">
                    + Hozzáadás
                </button>
                <button @click="showRegisterForm = true"
                        class="box-border border border-gray-300 text-gray-700 hover:bg-gray-100 hover:cursor-pointer focus:ring-4 focus:ring-gray-200 shadow-xs font-medium leading-5 rounded-full text-sm px-4 py-2.5 focus:outline-none">
                    + Új felhasználó
                </button>
            </div>
        </div>

        <form v-if="showForm && canEditCompany" class="mx-4 p-4 bg-white rounded-lg shadow-md dark:bg-gray-800 mb-6"
              @submit.prevent="submit">

            <div v-if="generalError" class="mb-5 p-3 bg-red-100 text-red-800 rounded text-sm">
                {{ generalError }}
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <input id="form_identifier" v-model="form.identifier" type="text" placeholder=" " required
                       class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"/>
                <label for="form_identifier"
                       class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email
                    cím vagy felhasználónév</label>
                <p v-if="errors.identifier" class="text-red-500 text-xs mt-1">{{ errors.identifier[0] }}</p>
            </div>

            <div class="mb-5">
                <p class="text-sm text-body mb-2">Jogosultságok</p>
                <div class="flex flex-col gap-2">
                    <label v-for="option in rightsOptions" :key="option.value"
                           class="flex items-center gap-2 text-sm text-heading cursor-pointer">
                        <input type="checkbox" :value="option.value" v-model="form.rights"
                               class="w-4 h-4 text-gray-800 border-gray-300 rounded focus:ring-gray-700"/>
                        {{ option.label }}
                    </label>
                </div>
                <p v-if="errors.rights" class="text-red-500 text-xs mt-1">{{ errors.rights[0] }}</p>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="text-white bg-gray-800 box-border border border-transparent hover:bg-black hover:cursor-pointer focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-full text-sm px-4 py-2.5 focus:outline-none">
                    Hozzáadás
                </button>
                <button type="button" @click="cancel"
                        class="box-border border border-gray-300 text-gray-700 hover:bg-gray-100 hover:cursor-pointer focus:ring-4 focus:ring-gray-200 shadow-xs font-medium leading-5 rounded-full text-sm px-4 py-2.5 focus:outline-none">
                    Mégse
                </button>
            </div>
        </form>

        <form v-if="showRegisterForm" class="mx-4 p-4 bg-white rounded-lg shadow-md dark:bg-gray-800 mb-6"
              @submit.prevent="submitRegister">
            <h2 class="text-lg font-semibold text-heading mb-4">Új felhasználó regisztrálása</h2>

            <div v-if="registerGeneralError" class="mb-5 p-3 bg-red-100 text-red-800 rounded text-sm">
                {{ registerGeneralError }}
            </div>

            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-5 group">
                    <input id="reg_name" v-model="registerForm.name" type="text" placeholder=" " required
                           class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"/>
                    <label for="reg_name"
                           class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Teljes
                        név</label>
                    <p v-if="registerErrors.name" class="text-red-500 text-xs mt-1">{{ registerErrors.name[0] }}</p>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input id="reg_username" v-model="registerForm.username" type="text" placeholder=" " required
                           class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"/>
                    <label for="reg_username"
                           class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Felhasználónév</label>
                    <p v-if="registerErrors.username" class="text-red-500 text-xs mt-1">{{
                            registerErrors.username[0]
                        }}</p>
                </div>
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <input id="reg_email" v-model="registerForm.email" type="email" placeholder=" " required
                       class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"/>
                <label for="reg_email"
                       class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email
                    cím</label>
                <p v-if="registerErrors.email" class="text-red-500 text-xs mt-1">{{ registerErrors.email[0] }}</p>
            </div>

            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-5 group">
                    <input id="reg_password" v-model="registerForm.password" type="password" placeholder=" " required
                           class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"/>
                    <label for="reg_password"
                           class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Jelszó</label>
                    <p v-if="registerErrors.password" class="text-red-500 text-xs mt-1">{{
                            registerErrors.password[0]
                        }}</p>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input id="reg_password_confirmation" v-model="registerForm.password_confirmation" type="password"
                           placeholder=" " required
                           class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"/>
                    <label for="reg_password_confirmation"
                           class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Jelszó
                        megerősítése</label>
                </div>
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <input id="reg_birth_date" v-model="registerForm.birth_date" type="date" placeholder=" " required
                       class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"/>
                <label for="reg_birth_date"
                       class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Születési
                    dátum</label>
                <p v-if="registerErrors.birth_date" class="text-red-500 text-xs mt-1">{{
                        registerErrors.birth_date[0]
                    }}</p>
            </div>

            <div class="mb-5">
                <p class="text-sm text-body mb-2">Jogosultságok</p>
                <div class="flex flex-col gap-2">
                    <label v-for="option in rightsOptions" :key="option.value"
                           class="flex items-center gap-2 text-sm text-heading cursor-pointer">
                        <input type="checkbox" :value="option.value" v-model="registerForm.rights"
                               class="w-4 h-4 text-gray-800 border-gray-300 rounded focus:ring-gray-700"/>
                        {{ option.label }}
                    </label>
                </div>
                <p v-if="registerErrors.rights" class="text-red-500 text-xs mt-1">{{ registerErrors.rights[0] }}</p>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="text-white bg-gray-800 box-border border border-transparent hover:bg-black hover:cursor-pointer focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-full text-sm px-4 py-2.5 focus:outline-none">
                    Regisztráció és hozzáadás
                </button>
                <button type="button" @click="cancelRegister"
                        class="box-border border border-gray-300 text-gray-700 hover:bg-gray-100 hover:cursor-pointer focus:ring-4 focus:ring-gray-200 shadow-xs font-medium leading-5 rounded-full text-sm px-4 py-2.5 focus:outline-none">
                    Mégse
                </button>
            </div>
        </form>

        <div class="mx-4 p-4">
            <table class="w-full text-sm text-left">
                <thead>
                <tr class="border-b border-gray-200">
                    <th class="pb-2 font-semibold text-heading">Név</th>
                    <th class="pb-2 font-semibold text-heading">Email</th>
                    <th class="pb-2 font-semibold text-heading">Felhasználónév</th>
                    <th class="pb-2 font-semibold text-heading">Jogosultságok</th>
                    <th v-if="canEditCompany" class="pb-2"></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="employee in employees" :key="employee.id" class="border-b border-gray-100">
                    <td class="py-2 pr-4">{{ employee.user?.name ?? '—' }}</td>
                    <td class="py-2 pr-4">{{ employee.user?.email ?? '—' }}</td>
                    <td class="py-2 pr-4">{{ employee.user?.username ?? '—' }}</td>
                    <td class="py-2">
                        <div v-if="canEditCompany && editingEmployeeId === employee.id" class="flex flex-col gap-1">
                            <label v-for="option in rightsOptions" :key="option.value"
                                   class="flex items-center gap-2 text-sm text-heading cursor-pointer">
                                <input type="checkbox" :value="option.value" v-model="editingRights"
                                       class="w-4 h-4 text-gray-800 border-gray-300 rounded focus:ring-gray-700"/>
                                {{ option.label }}
                            </label>
                            <div class="flex gap-2 mt-2">
                                <button type="button" @click="saveRights(employee.id)"
                                        class="text-white bg-gray-800 hover:bg-black hover:cursor-pointer rounded-full text-xs px-3 py-1 focus:outline-none">
                                    Mentés
                                </button>
                                <button type="button" @click="cancelEditRights"
                                        class="border border-gray-300 text-gray-700 hover:bg-gray-100 hover:cursor-pointer rounded-full text-xs px-3 py-1 focus:outline-none">
                                    Mégse
                                </button>
                            </div>
                        </div>
                        <div v-else class="flex items-center gap-2 flex-wrap">
                            <span v-for="right in employee.rights" :key="right"
                                  class="inline-block px-2 py-0.5 rounded-full text-xs bg-gray-100 text-gray-700">
                                {{ rightsOptions.find(o => o.value === right)?.label ?? right }}
                            </span>
                            <span v-if="employee.user_id === ownerId" class="inline-block px-2 py-0.5 rounded-full text-xs bg-gray-100 text-gray-700">
                                Tulaj
                            </span>
                            <span v-if="!employee.rights?.length && employee.user_id !== ownerId" class="text-gray-400">–</span>
                            <button v-if="canEditCompany && employee.user_id !== ownerId" type="button" @click="startEditRights(employee)"
                                    class="text-gray-400 hover:text-gray-700 hover:cursor-pointer focus:outline-none text-xs ml-1"
                                    title="Jogosultságok szerkesztése">
                                ✎
                            </button>
                        </div>
                    </td>
                    <td v-if="canEditCompany && employee.user_id !== ownerId" class="py-2 text-right">
                        <button @click="removeEmployee(employee.id)"
                                class="text-gray-400 hover:text-red-600 hover:cursor-pointer focus:outline-none"
                                title="Eltávolítás">
                            ✕
                        </button>
                    </td>
                </tr>
                <tr v-if="employees.length === 0">
                    <td :colspan="canEditCompany ? 5 : 4" class="py-4 text-body text-center">Nincs még alkalmazott.</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
