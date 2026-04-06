<script setup lang="ts">
import axiosInstance from "../../../lib/axios";
import { ref, onMounted } from "vue";
import JobCreate from "./JobCreate.vue";

interface Job {
    id: string;
    title: string;
    parent_job: string | null;
    children: Job[];
}

const jobs = ref<Job[]>([]);

const fetchJobs = async () => {
    try {
        const response = await axiosInstance.get("job/list");
        jobs.value = response.data;
    } catch (e) {
        console.error(e);
    }
};

const deleteJob = async (id: string) => {
    try {
        await axiosInstance.delete(`job/${id}`);
        await fetchJobs();
    } catch (e) {
        console.error(e);
    }
};

onMounted(() => {
    fetchJobs();
});
</script>

<template>
    <JobCreate @jobCreated="fetchJobs" />
    <div class="max-w-md mx-auto p-4">
        <div class="table w-full">
            <div class="table-header-group">
                <div class="table-row font-semibold">
                    <div class="table-cell text-left pb-2">Munkakörök</div>
                </div>
            </div>
            <div class="table-row-group">
                <template v-for="job in jobs" :key="job.id">
                    <div class="table-row">
                        <div class="table-cell py-1 font-medium">{{ job.title }}</div>
                    </div>
                    <div
                        v-for="child in job.children"
                        :key="child.id"
                        class="table-row"
                    >
                        <div class="table-cell py-1 pl-6 text-gray-600">
                            <div class="flex items-center justify-between">
                                <span>↳ {{ child.title }}</span>
                                <button
                                    @click="deleteJob(child.id)"
                                    class="ml-4 text-red-500 hover:text-red-700 font-bold"
                                >✕</button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
