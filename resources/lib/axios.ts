import axios from "axios";

const axiosInstance = axios.create({
   baseURL:"https://localhost:8000/api",
    withCredentials: true,
    withXSRFToken: true,
});

export default axiosInstance;
