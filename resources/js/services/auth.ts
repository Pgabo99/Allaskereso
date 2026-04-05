import axiosInstance from "../../lib/axios";
import { ref } from 'vue';
import router from "../router";

axiosInstance.defaults.withCredentials = true;

export const user = ref<any>(null);
export const isAuthenticated = ref(false);

export const loadUser = async () => {
    try {
        const res = await axiosInstance.get('user/get-logged-in-user');
        console.log(res.data)
        if (res.data) {
            user.value = res.data;
            isAuthenticated.value = true;
        } else {
            user.value = null;
            isAuthenticated.value = false;
        }
    } catch (e) {
        console.log(e)
        user.value = null;
        isAuthenticated.value = false;
    }
};

export const logout = async () => {
    if (!isAuthenticated.value) return;
    await axiosInstance.post('user/logout');

    user.value = null;
    isAuthenticated.value = false;
};
