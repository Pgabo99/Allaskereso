<script setup lang="ts">
import axiosInstance from "../../../lib/axios";
import {reactive, ref} from "vue";
import {isAuthenticated, user, isAdmin} from '../../services/auth';
import router from "../../router";

interface LoginForm {
    email: string,
    password: string,
}

const form = reactive<LoginForm>({
    email: "",
    password: "",
});

const errors = ref<Record<string, string[]>>({});
const generalError = ref('');

const login = async (payload: LoginForm) => {
    errors.value = {};
    generalError.value = '';
    await axiosInstance.get("/sanctum/csrf-cookie", {
        baseURL: "http://localhost:8000",
    });
    try {
        const response = await axiosInstance.post("user/login", payload);
        if (response.data.success === true) {
            user.value = response.data.user;
            isAuthenticated.value = true;
            isAdmin.value = user.value.is_admin;
            await router.push('/job-offers');
        } else {
            generalError.value = response.data.message || 'Hiba történt';
        }
    } catch (error: any) {
        if (error?.response?.status === 422) {
            errors.value = error.response.data.errors;
        } else {
            generalError.value = error?.response?.data?.message || 'Hiba történt';
        }
    }
}
</script>

<template>
    <div class="max-w-md mx-auto">
        <h1 class="text-3xl text-slate-800 p-4">Bejelentkezés</h1>
        <form class="max-w-md mx-auto p-4 bg-white rounded-lg shadow-md dark:bg-gray-800" @submit.prevent="login(form)">

            <div v-if="generalError" class="mb-5 p-3 bg-red-100 text-red-800 rounded text-sm">
                {{ generalError }}
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <input id="floating_email"
                       class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"
                       name="floating_email" placeholder=" " required type="email" v-model="form.email"/>
                <label
                    class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto"
                    for="floating_email">Email cím</label>
                <p v-if="errors.email" class="text-red-500 text-xs mt-1">{{ errors.email[0] }}</p>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input id="floating_password"
                       class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer"
                       name="floating_password" placeholder=" " required type="password" v-model="form.password"/>
                <label
                    class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 peer-focus:z-10 peer-[&:not(:placeholder-shown)]:z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto"
                    for="floating_password">Jelszó</label>
                <p v-if="errors.password" class="text-red-500 text-xs mt-1">{{ errors.password[0] }}</p>
            </div>
            <button
                class="text-white bg-gray-800 box-border border border-transparent hover:bg-black hover:cursor-pointer focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-full text-sm px-4 py-2.5 focus:outline-none"
                type="submit">Bejelentkezés
            </button>
        </form>
    </div>
</template>
