import { createRouter, createWebHistory } from "vue-router";
import path from "@/router/path.js";
import { whileList } from "@/const";
const routes = [...path];
const router = createRouter({
    history: createWebHistory(),
    routes,
});
router.beforeEach((to, from, next) => {
    if (whileList.includes(to.name)) {
        next();
    } else {
        if (localStorage.getItem("tokenlogin")) {
            next();
        } else {
            next("/");
        }
    }
});
export default router;
