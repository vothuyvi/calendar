import axios from 'axios';

function setup(instance) {
    instance.interceptors.request.use(
        function (config) {
            const token = localStorage.getItem('tokenlogin');
            if (token) {
                config.headers.Authorization = `Bearer ${token}`;
            }
            return config;
        },
        function (err) {
            return Promise.reject(err);
        }
    );
}

const Api = axios.create({
    baseURL: import.meta.env.VITE_API_PUBLIC_KEY,
    withCredentials: false,
    headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
    },
    timeout: 5000, // request timeout
});

setup(Api);

export default Api;
