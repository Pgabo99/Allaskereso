<script lang="ts" setup>
import axiosInstance from "../../../lib/axios";
import {reactive} from "vue";
import { isAuthenticated, user } from '../../services/auth';
import router from "../../router";

interface RegisterForm {
    email: string,
    username: string,
    password: string,
    password_confirmation: string,
    name: string,
    birth_date: string,
}

const form = reactive<RegisterForm>({
    email: "",
    username: "",
    password: "",
    password_confirmation: "",
    name: "",
    birth_date: "2000-01-01",
});

const today = new Date();

const maxDate = new Date(
    today.getFullYear() - 14,
    today.getMonth(),
    today.getDate()
).toISOString().split('T')[0];

const register = async(payload: RegisterForm) => {
    await axiosInstance.get("/sanctum/csrf-cookie", {
        baseURL: "http://localhost:8000"
    });
    try {
        const response = await  axiosInstance.post("user/register", payload);
        if (response.data.success) {
            user.value = response.data.user;
            isAuthenticated.value = true;
            await router.push('/');
        } else {
            alert(response.data.message || 'Hiba történt');
        }
    } catch (error: any) {
        alert(error?.response?.data?.message || 'Hiba történt');
    }
}

</script>

<template>
    <div class="max-w-md mx-auto">
        <h1 class="text-3xl text-slate-800 p-4">Reisztráció</h1>
        <form class="max-w-md mx-auto p-4 bg-white rounded-lg shadow-md dark:bg-gray-800" @submit.prevent="register(form)">
            <div class="relative z-0 w-full mb-5 group">
                <input id="floating_name" class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer" name="floating_name" placeholder=" " required type="text" v-model="form.name" />
                <label class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto" for="floating_name">Teljes név</label>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input id="floating_username" class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer" name="floating_username" placeholder=" " required type="text" v-model="form.username" />
                <label class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto" for="floating_username">Felhasználónév</label>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input id="floating_email" class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer" name="floating_email" placeholder=" " required type="email" v-model="form.email" />
                <label class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto" for="floating_email">Email cím</label>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input id="floating_password" class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer" name="floating_password" placeholder=" " required type="password" v-model="form.password" />
                <label class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto" for="floating_password">Jelszó</label>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input id="floating_password_confirmation" class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer" name="repeat_password" placeholder=" " required type="password" v-model="form.password_confirmation" />
                <label class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto" for="floating_password_confirmation">Jelszó megerősítése</label>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input id="floating_birth_date" class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer" name="floating_birth_date" placeholder=" " required type="date" :max="maxDate" v-model="form.birth_date" />
                <label class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto" for="floating_birth_date">Születési dátum</label>
            </div>
            <button class="text-white bg-gray-800 box-border border border-transparent hover:bg-black hover:cursor-pointer focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none" type="submit">Regisztráció</button>
        </form>
    </div>
</template>

<style scoped>

</style>
