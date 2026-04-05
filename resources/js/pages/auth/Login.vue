<script setup lang="ts">
import axiosInstance from "../../../lib/axios";
import {reactive} from "vue";
import {isAuthenticated, user} from '../../services/auth';
import router from "../../router";

interface LoginForm {
    email: string,
    password: string,
}

const form = reactive<LoginForm>({
    email: "",
    password: "",
});

const login = async(payload: LoginForm) => {
    await axiosInstance.get("/sanctum/csrf-cookie", {
        baseURL: "http://localhost:8000",
    });
    try {
        const response = await  axiosInstance.post("user/login", payload);
        if (response.data.success === true) {
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
        <h1 class="text-3xl text-slate-800 p-4">Bejelentkezés</h1>
        <form class="max-w-md mx-auto p-4 bg-white rounded-lg shadow-md dark:bg-gray-800" @submit.prevent="login(form)">
            <div class="relative z-0 w-full mb-5 group">
                <input id="floating_email" class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer" name="floating_email" placeholder=" " required type="email" v-model="form.email" />
                <label class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto" for="floating_email">Email cím</label>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input id="floating_password" class="block py-2.5 px-0 w-full text-sm text-heading bg-transparent border-0 border-b-2 border-default-medium appearance-none focus:outline-none focus:ring-0 focus:border-brand peer" name="floating_password" placeholder=" " required type="password" v-model="form.password" />
                <label class="absolute text-sm text-body duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-fg-brand peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto" for="floating_password">Jelszó</label>
            </div>
            <button class="text-white bg-gray-800 box-border border border-transparent hover:bg-black hover:cursor-pointer focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none" type="submit">Bejelentkezés</button>
        </form>
    </div>
</template>

<style scoped>

</style>
