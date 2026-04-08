import axiosInstance from "../../lib/axios";
import { ref } from 'vue';

axiosInstance.defaults.withCredentials = true;

export const user = ref<any>(null);
export const isAuthenticated = ref(false);
export const isAdmin = ref(false);
export const authInitialized = ref(false);

export const loadUser = async () => {
    try {
        const res = await axiosInstance.get('user/get-logged-in-user');
        if (res.data) {
            user.value = res.data;
            isAuthenticated.value = true;
            isAdmin.value = user.value.is_admin;
        } else {
            user.value = null;
            isAuthenticated.value = false;
            isAdmin.value = false;
        }
    } catch (e) {
        user.value = null;
        isAuthenticated.value = false;
        isAdmin.value = false;
    } finally {
        authInitialized.value = true;
    }
};

export const logout = async () => {
    if (!isAuthenticated.value) return;
    await axiosInstance.post('user/logout');

    user.value = null;
    isAuthenticated.value = false;
    isAdmin.value = false;
};
