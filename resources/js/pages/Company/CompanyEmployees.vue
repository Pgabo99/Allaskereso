<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axiosInstance from '../../../lib/axios';

interface Employee {
    id: string;
    user_id: string;
    rights: string[];
    user?: { name: string; email: string };
}

const rightsLabels: Record<string, string> = {
    CREATE_JOB_OFFER: 'Álláshirdetés létrehozása',
    HANDLE_APPLICATIONS: 'Jelentkezések kezelése',
    EDIT_COMPANY_DATA: 'Cégadatok szerkesztése',
};

const route = useRoute();
const employees = ref<Employee[]>([]);

onMounted(async () => {
    try {
        const response = await axiosInstance.get(`company/${route.params.id}/employees`);
        employees.value = response.data;
    } catch (e) {
        console.error(e);
    }
});
</script>

<template>
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center gap-3 p-4">
            <router-link :to="`/company/create`" class="text-sm text-gray-600 hover:text-gray-900">← Vissza</router-link>
            <h1 class="text-3xl text-slate-800">Alkalmazottak</h1>
        </div>

        <div class="mx-4 p-4 bg-white rounded-lg shadow-md">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="pb-2 font-semibold text-heading">Név</th>
                        <th class="pb-2 font-semibold text-heading">Email</th>
                        <th class="pb-2 font-semibold text-heading">Jogosultságok</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="employee in employees" :key="employee.id" class="border-b border-gray-100">
                        <td class="py-2 pr-4">{{ employee.user?.name ?? '—' }}</td>
                        <td class="py-2 pr-4">{{ employee.user?.email ?? '—' }}</td>
                        <td class="py-2">
                            <span
                                v-for="right in employee.rights" :key="right"
                                class="inline-block mr-1 mb-1 px-2 py-0.5 rounded-full text-xs bg-gray-100 text-gray-700"
                            >{{ rightsLabels[right] ?? right }}</span>
                        </td>
                    </tr>
                    <tr v-if="employees.length === 0">
                        <td colspan="3" class="py-4 text-body text-center">Nincs még alkalmazott.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
