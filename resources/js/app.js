import './bootstrap';
import { createApp } from 'vue';
import router from '@/router/index.js';
import App from '@/App.vue';
import { createPinia } from 'pinia';
import '@/style/common.scss';

const pinia = createPinia();
const app = createApp(App);
app.use(router);
app.use(pinia);
app.mount('#app');
