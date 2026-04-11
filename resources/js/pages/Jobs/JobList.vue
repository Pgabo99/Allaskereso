<script setup lang="ts">
import axiosInstance from "../../../lib/axios";
import {ref, onMounted} from "vue";
import JobCreate from "./JobCreate.vue";

interface Job {
    id: string;
    title: string;
    parent_job: string | null;
    children: Job[];
}

const jobs = ref<Job[]>([]);
const expanded = ref<string[]>([]);
const editingId = ref<string | null>(null);
const editTitle = ref('');

const toggle = (id: string) => {
    if (editingId.value === id) return;
    const idx = expanded.value.indexOf(id);
    if (idx === -1) {
        expanded.value.push(id);
    } else {
        expanded.value.splice(idx, 1);
    }
};

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

const startEdit = (job: Job) => {
    editingId.value = job.id;
    editTitle.value = job.title;
};

const cancelEdit = () => {
    editingId.value = null;
    editTitle.value = '';
};

const saveEdit = async (id: string) => {
    try {
        await axiosInstance.put(`job/${id}`, {title: editTitle.value});
        await fetchJobs();
        cancelEdit();
    } catch (e) {
        console.error(e);
    }
};

onMounted(() => {
    fetchJobs();
});
</script>

<template>
    <JobCreate @jobCreated="fetchJobs"/>
    <div class="max-w-md mx-auto p-4">
        <div class="table w-full">
            <div class="table-header-group">
                <div class="table-row font-semibold">
                    <div class="table-cell text-left pb-2">Munkakörök</div>
                </div>
            </div>
            <div class="table-row-group">
                <template v-for="job in jobs" :key="job.id">
                    <div class="table-row cursor-pointer hover:bg-gray-50" @click="toggle(job.id)">
                        <div class="table-cell py-1 font-medium">
                            <div class="flex items-center gap-2">
                                <svg v-if="job.children.length"
                                     class="w-4 h-4 text-gray-400 transition-transform duration-200 shrink-0"
                                     :class="{ 'rotate-90': expanded.includes(job.id) }"
                                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                                <span v-else class="w-4 shrink-0"></span>
                                <template v-if="editingId === job.id">
                                    <input
                                        v-model="editTitle"
                                        @click.stop
                                        @keyup.enter="saveEdit(job.id)"
                                        @keyup.escape="cancelEdit"
                                        class="border rounded px-1 py-0.5 text-sm w-full"
                                        autofocus
                                    />
                                    <button @click.stop="saveEdit(job.id)" class="text-green-600 hover:text-green-800 font-bold ml-1">✓</button>
                                    <button @click.stop="cancelEdit" class="text-gray-400 hover:text-gray-600 font-bold ml-1">✕</button>
                                </template>
                                <template v-else>
                                    <span class="flex-1">{{ job.title }}</span>
                                    <button
                                        @click.stop="startEdit(job)"
                                        class="text-blue-400 hover:text-blue-600 text-xs ml-2"
                                    >✎</button>
                                </template>
                            </div>
                        </div>
                    </div>
                    <template v-if="expanded.includes(job.id)">
                        <div
                            v-for="child in job.children"
                            :key="child.id"
                            class="table-row"
                        >
                            <div class="table-cell py-1 pl-10 text-gray-600">
                                <div class="flex items-center justify-between">
                                    <template v-if="editingId === child.id">
                                        <input
                                            v-model="editTitle"
                                            @keyup.enter="saveEdit(child.id)"
                                            @keyup.escape="cancelEdit"
                                            class="border rounded px-1 py-0.5 text-sm flex-1"
                                            autofocus
                                        />
                                        <button @click.stop="saveEdit(child.id)" class="text-green-600 hover:text-green-800 font-bold ml-1">✓</button>
                                        <button @click.stop="cancelEdit" class="text-gray-400 hover:text-gray-600 font-bold ml-1">✕</button>
                                    </template>
                                    <template v-else>
                                        <span>↳ {{ child.title }}</span>
                                        <div class="flex items-center gap-2 ml-4">
                                            <button
                                                @click.stop="startEdit(child)"
                                                class="text-blue-400 hover:text-blue-600 text-xs"
                                            >✎</button>
                                            <button
                                                @click.stop="deleteJob(child.id)"
                                                class="text-red-500 hover:text-red-700 font-bold"
                                            >✕</button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                </template>
            </div>
            <p v-if="jobs.length === 0" class="text-body">Üres a munkakörök listája.</p>
        </div>
    </div>
</template>

<style scoped>

</style>
