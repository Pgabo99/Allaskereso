<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axiosInstance from '../../../lib/axios';

const router = useRouter();

interface User {
    id: string;
    name: string;
    email: string;
    username: string;
    role: string;
    birth_date: string;
    create_date: string;
}

const users = ref<User[]>([]);
const loading = ref(true);
const generalError = ref('');

onMounted(async () => {
    try {
        const res = await axiosInstance.get('/admin/users');
        users.value = res.data.users;
    } catch (e: any) {
        generalError.value = e?.response?.data?.message || 'Hiba történt a felhasználók betöltésekor.';
    } finally {
        loading.value = false;
    }
});

const editUser = (id: string) => {
    router.push(`/admin/users/${id}`);
};
</script>

<template>
    <div class="max-w-5xl mx-auto">
        <div class="flex items-center p-4">
            <h1 class="text-3xl text-slate-800">Felhasználók</h1>
        </div>

        <div class="mx-4 p-4 bg-white rounded-lg shadow-md mb-6">
            <div v-if="generalError" class="mb-5 p-3 bg-red-100 text-red-800 rounded text-sm">
                {{ generalError }}
            </div>

            <div v-if="loading" class="text-sm text-gray-500">Betöltés...</div>

            <table v-else class="w-full text-sm text-left">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="py-3 pr-4 font-semibold text-gray-700">Név</th>
                        <th class="py-3 pr-4 font-semibold text-gray-700">Email</th>
                        <th class="py-3 pr-4 font-semibold text-gray-700">Felhasználónév</th>
                        <th class="py-3 pr-4 font-semibold text-gray-700">Jogosultság</th>
                        <th class="py-3 font-semibold text-gray-700"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="u in users" :key="u.id" class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-3 pr-4">{{ u.name }}</td>
                        <td class="py-3 pr-4">{{ u.email }}</td>
                        <td class="py-3 pr-4">{{ u.username }}</td>
                        <td class="py-3 pr-4">
                            <span class="bg-gray-100 text-gray-700 rounded-full px-2 py-0.5 text-xs">{{ u.role }}</span>
                        </td>
                        <td class="py-3 text-right">
                            <button @click="editUser(u.id)"
                                    class="text-white bg-gray-800 hover:bg-black hover:cursor-pointer focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-full text-sm px-4 py-1.5 focus:outline-none">
                                Szerkesztés
                            </button>
                        </td>
                    </tr>
                    <tr v-if="users.length === 0">
                        <td colspan="5" class="py-6 text-center text-gray-400 text-sm">Nincsenek felhasználók.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
