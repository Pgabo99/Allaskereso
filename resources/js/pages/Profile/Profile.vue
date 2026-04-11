<script setup lang="ts">
import { ref, onMounted, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axiosInstance from '../../../lib/axios';
import { user, loadUser, isAdmin } from '../../services/auth';

const route = useRoute();
const router = useRouter();

const editUserId = route.params.id as string | undefined;
const isEditingOther = computed(() => isAdmin.value && !!editUserId);

const form = ref({
    name: '',
    email: '',
    username: '',
    birth_date: '',
    role: '',
    password: '',
    password_confirmation: '',
});

const errors = ref<Record<string, string[]>>({});
const generalError = ref('');
const success = ref(false);
const showDeleteConfirm = ref(false);
const deleteError = ref('');

onMounted(async () => {
    if (isEditingOther.value) {
        try {
            const res = await axiosInstance.get(`/admin/users/${editUserId}`);
            const u = res.data.user;
            form.value.name = u.name ?? '';
            form.value.email = u.email ?? '';
            form.value.username = u.username ?? '';
            form.value.birth_date = u.birth_date ?? '';
            form.value.role = u.role ?? 'USER';
        } catch (e: any) {
            generalError.value = e?.response?.data?.message || 'Hiba történt a felhasználó betöltésekor.';
        }
    } else if (user.value) {
        form.value.name = user.value.name ?? '';
        form.value.email = user.value.email ?? '';
        form.value.username = user.value.username ?? '';
        form.value.birth_date = user.value.birth_date ?? '';
        form.value.role = user.value.role ?? 'USER';
    }
});

const submit = async () => {
    errors.value = {};
    generalError.value = '';
    success.value = false;

    try {
        await axiosInstance.get('/sanctum/csrf-cookie');
        if (isEditingOther.value) {
            await axiosInstance.put(`/admin/users/${editUserId}`, form.value);
        } else {
            await axiosInstance.put('user/profile', form.value);
            await loadUser();
        }
        success.value = true;
        form.value.password = '';
        form.value.password_confirmation = '';
    } catch (e: any) {
        if (e.response?.status === 422) {
            errors.value = e.response.data.errors;
        } else {
            generalError.value = e?.response?.data?.message || 'Hiba történt';
        }
    }
};

const deleteUser = async () => {
    deleteError.value = '';
    try {
        let deleteUserId = editUserId;
        if (!deleteUserId) {
            deleteUserId = user.value.id;
        }
        await axiosInstance.get('/sanctum/csrf-cookie');
        await axiosInstance.delete(`/user/${deleteUserId}`);
        if (isAdmin.value && editUserId && editUserId !== user.value?.id) {
            router.push('/admin/users');
        } else {
            await loadUser();
            router.push('/login');
        }
    } catch (e: any) {
        deleteError.value = e?.response?.data?.message || 'Hiba történt a törlés során.';
        showDeleteConfirm.value = false;
    }
};
</script>

<template>
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center p-4 gap-3">
            <button v-if="isEditingOther" @click="router.push('/admin/users')"
                    class="text-gray-500 hover:text-gray-800 text-sm hover:cursor-pointer">
                ← Vissza
            </button>
            <h1 class="text-3xl text-slate-800">{{ isEditingOther ? 'Felhasználó szerkesztése' : 'Profilom' }}</h1>
        </div>

        <form class="mx-4 p-4 bg-white rounded-lg shadow-md mb-6" @submit.prevent="submit">

            <div v-if="success" class="mb-5 p-3 bg-green-100 text-green-800 rounded text-sm">
                {{ isEditingOther ? 'A felhasználó adatai sikeresen frissítve.' : 'A profil sikeresen frissítve.' }}
            </div>

            <div v-if="generalError" class="mb-5 p-3 bg-red-100 text-red-800 rounded text-sm">
                {{ generalError }}
            </div>

            <div v-if="deleteError" class="mb-5 p-3 bg-red-100 text-red-800 rounded text-sm">
                {{ deleteError }}
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <input id="profile_name" v-model="form.name" type="text" placeholder=" " required
                       class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"/>
                <label for="profile_name"
                       class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                    Teljes név
                </label>
                <p v-if="errors.name" class="text-red-500 text-xs mt-1">{{ errors.name[0] }}</p>
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <input id="profile_email" v-model="form.email" type="email" placeholder=" " required
                       class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"/>
                <label for="profile_email"
                       class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                    Email cím
                </label>
                <p v-if="errors.email" class="text-red-500 text-xs mt-1">{{ errors.email[0] }}</p>
            </div>

            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-5 group">
                    <input id="profile_username" v-model="form.username" type="text" placeholder=" " required
                           class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"/>
                    <label for="profile_username"
                           class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                        Felhasználónév
                    </label>
                    <p v-if="errors.username" class="text-red-500 text-xs mt-1">{{ errors.username[0] }}</p>
                </div>

                <div class="relative z-0 w-full mb-5 group">
                    <input id="profile_birth_date" v-model="form.birth_date" type="date" placeholder=" " required
                           class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"/>
                    <label for="profile_birth_date"
                           class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                        Születési dátum
                    </label>
                    <p v-if="errors.birth_date" class="text-red-500 text-xs mt-1">{{ errors.birth_date[0] }}</p>
                </div>
            </div>

            <div v-if="isAdmin" class="relative z-0 w-full mb-5 group">
                <select id="profile_role" v-model="form.role"
                        class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand">
                    <option value="USER">USER</option>
                    <option value="ADMIN">ADMIN</option>
                </select>
                <label for="profile_role"
                       class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 z-10 origin-[0]">
                    Jogosultság
                </label>
                <p v-if="errors.role" class="text-red-500 text-xs mt-1">{{ errors.role[0] }}</p>
            </div>

            <hr class="my-6 border-gray-200"/>

            <p class="text-sm text-body mb-4">Jelszó módosítása (hagyja üresen, ha nem kívánja megváltoztatni)</p>

            <div class="relative z-0 w-full mb-5 group">
                <input id="profile_password" v-model="form.password" type="password" placeholder=" "
                       class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"/>
                <label for="profile_password"
                       class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                    Új jelszó
                </label>
                <p v-if="errors.password" class="text-red-500 text-xs mt-1">{{ errors.password[0] }}</p>
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <input id="profile_password_confirmation" v-model="form.password_confirmation" type="password" placeholder=" "
                       class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"/>
                <label for="profile_password_confirmation"
                       class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                    Új jelszó megerősítése
                </label>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit"
                        class="text-white bg-gray-800 box-border border border-transparent hover:bg-black hover:cursor-pointer focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-full text-sm px-4 py-2.5 focus:outline-none">
                    Mentés
                </button>
                <button type="button" @click="showDeleteConfirm = true"
                        class="text-white bg-red-600 box-border border border-transparent hover:bg-red-700 hover:cursor-pointer focus:ring-4 focus:ring-red-300 shadow-xs font-medium leading-5 rounded-full text-sm px-4 py-2.5 focus:outline-none">
                    {{ isEditingOther ? 'Felhasználó törlése' : 'Profilom törlése' }}
                </button>
            </div>
        </form>

        <div v-if="showDeleteConfirm" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-xl p-6 max-w-sm w-full mx-4">
                <h2 class="text-lg font-semibold text-slate-800 mb-2">Felhasználó törlése</h2>
                <p class="text-sm text-gray-600 mb-6">Biztosan törölni szeretnéd ezt a felhasználót? Ez a művelet nem visszavonható.</p>
                <div class="flex gap-3 justify-end">
                    <button @click="showDeleteConfirm = false"
                            class="px-4 py-2 text-sm rounded-full border border-gray-300 hover:bg-gray-50 hover:cursor-pointer">
                        Mégsem
                    </button>
                    <button @click="deleteUser"
                            class="px-4 py-2 text-sm text-white bg-red-600 rounded-full hover:bg-red-700 hover:cursor-pointer">
                        Törlés
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
