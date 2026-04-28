<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import axiosInstance from '../../../lib/axios';
import JobCard from '../JobOffers/JobCard.vue';

interface Application {
    id: string;
    status: 'PENDING' | 'APPROVED' | 'DECLINED';
    job_offer: {
        id: string;
        title: string;
        description: string;
        salary_min: number;
        salary_max: number;
        location: string;
        work_mode: string;
        company?: { id: string; name: string };
    };
}

const applications = ref<Application[]>([]);

const statusCounts = computed(() => ({
    pending:  applications.value.filter(a => a.status === 'PENDING').length,
    approved: applications.value.filter(a => a.status === 'APPROVED').length,
    declined: applications.value.filter(a => a.status === 'DECLINED').length,
}));

const statusFilter = ref<'PENDING' | 'APPROVED' | 'DECLINED' | null>(null);

const toggleFilter = (status: 'PENDING' | 'APPROVED' | 'DECLINED') => {
    statusFilter.value = statusFilter.value === status ? null : status;
};

const filteredApplications = computed(() =>
    statusFilter.value
        ? applications.value.filter(a => a.status === statusFilter.value)
        : applications.value
);

const withdraw = async (applicationId: string) => {
    if (!confirm('Biztosan visszavonod a jelentkezésedet?')) return;
    await axiosInstance.get('/sanctum/csrf-cookie');
    await axiosInstance.delete(`application/${applicationId}`);
    applications.value = applications.value.filter(a => a.id !== applicationId);
};

onMounted(async () => {
    try {
        const response = await axiosInstance.get('application');
        applications.value = response.data;
    } catch (e) {
        console.error(e);
    }
});
</script>

<template>
    <div class="p-6">
        <h1 class="text-3xl text-slate-800 mb-6">Jelentkezéseim</h1>

        <div v-if="applications.length > 0" class="flex gap-4 mb-6">
            <button @click="toggleFilter('PENDING')"
                    :class="statusFilter === 'PENDING'
                        ? 'bg-yellow-200 border-yellow-400 ring-2 ring-yellow-300'
                        : 'bg-yellow-50 border-yellow-200 hover:bg-yellow-100'"
                    class="flex items-center gap-2 border rounded-lg px-4 py-3 cursor-pointer transition-all">
                <span class="text-2xl font-bold text-yellow-600">{{ statusCounts.pending }}</span>
                <span class="text-sm text-yellow-700">Folyamatban</span>
            </button>
            <button @click="toggleFilter('APPROVED')"
                    :class="statusFilter === 'APPROVED'
                        ? 'bg-green-200 border-green-400 ring-2 ring-green-300'
                        : 'bg-green-50 border-green-200 hover:bg-green-100'"
                    class="flex items-center gap-2 border rounded-lg px-4 py-3 cursor-pointer transition-all">
                <span class="text-2xl font-bold text-green-600">{{ statusCounts.approved }}</span>
                <span class="text-sm text-green-700">Elfogadva</span>
            </button>
            <button @click="toggleFilter('DECLINED')"
                    :class="statusFilter === 'DECLINED'
                        ? 'bg-red-200 border-red-400 ring-2 ring-red-300'
                        : 'bg-red-50 border-red-200 hover:bg-red-100'"
                    class="flex items-center gap-2 border rounded-lg px-4 py-3 cursor-pointer transition-all">
                <span class="text-2xl font-bold text-red-600">{{ statusCounts.declined }}</span>
                <span class="text-sm text-red-700">Elutasítva</span>
            </button>
        </div>

        <div v-if="applications.length === 0" class="text-body">
            Még nem jelentkeztél egyetlen állásra sem.
        </div>

        <div v-else class="grid gap-4 [grid-template-columns:repeat(auto-fill,400px)]">
            <JobCard
                v-for="app in filteredApplications"
                :key="app.id"
                :id="app.job_offer.id"
                :title="app.job_offer.title"
                :description="app.job_offer.description || app.job_offer.location + ' · ' + app.job_offer.salary_min.toLocaleString() + ' – ' + app.job_offer.salary_max.toLocaleString() + ' Ft'"
                :company_name="app.job_offer.company?.name"
                :status="app.status"
                :application-id="app.id"
                :link-to="`/job-offer/${app.job_offer.id}?from=my-applications`"
                @withdraw="withdraw"
            />
        </div>
    </div>
</template>
