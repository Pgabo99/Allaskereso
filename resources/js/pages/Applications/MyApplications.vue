<script setup lang="ts">
import { ref, onMounted } from 'vue';
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

        <div v-if="applications.length === 0" class="text-body">
            Még nem jelentkeztél egyetlen állásra sem.
        </div>

        <div v-else class="grid gap-4 [grid-template-columns:repeat(auto-fill,400px)]">
            <JobCard
                v-for="app in applications"
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
