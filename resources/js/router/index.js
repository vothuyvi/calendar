import { createRouter, createWebHistory } from 'vue-router';
import path from '@/router/path.js';
import { WHITE_LIST, TOKEN_LOGIN } from '@/const';
const routes = [...path];
const router = createRouter({
    history: createWebHistory(),
    routes,
});
router.beforeEach((to, from, next) => {
    if (to.name == '404') {
        next();
    }
    if (!to.name) {
        next('/404');
    }
    if (localStorage.getItem(TOKEN_LOGIN)) {
        if (WHITE_LIST.includes(to.name)) {
            next('/calendar');
        } else {
            next();
        }
    } else {
        if (WHITE_LIST.includes(to.name)) {
            next();
        } else {
            next('/');
        }
    }
});
export default router;
