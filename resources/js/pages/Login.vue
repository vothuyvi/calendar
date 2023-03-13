<template>
    <div class="container__login">
        <div class="container__login-body">
            <div class="login-body__header">
                <span> Login</span>
            </div>
            <div class="login-body__center">
                <div v-if="error" class="error">{{ error }}</div>
                <input
                    v-model="email"
                    type="mail"
                    name=""
                    id=""
                    class="fontAwesome"
                    placeholder=" &#xf0e0;  Enter your email"
                />
                <input
                    v-model="password"
                    :type="show === true ? 'text' : 'password'"
                    class="fontAwesome"
                    placeholder=" &#xf023;  Enter your password"
                />
                <div class="show-hide__icon">
                    <i
                        class="fa-solid fa-eye show-icon"
                        v-if="show"
                        @click="show = !show"
                    ></i>
                    <i
                        class="fa-solid fa-eye-slash hide-icon"
                        v-else
                        @click="show = !show"
                    ></i>
                </div>
            </div>
            <div class="login-body__bot">
                <button @click="Login()">Sign In</button>
                <div class="login-body-bot__signup">
                    <router-link :to="{ name: 'ResisgerView' }"
                        ><span>Create your account?</span></router-link
                    >
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { reactive, toRefs } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
export default {
    setup() {
        const router = useRouter();
        const state = reactive({
            email: "",
            password: "",
            show: false,
            error: "",
        });

        const Login = () => {
            //  lay data tu 2 input email va pass
            // goi axios gui data len api login
            // lay du lieu tra ve tu axios
            axios
                //http://127.0.0.1:8000/api/login
                .post(import.meta.env.VITE_API_PUBLIC_KEY + "api/login", {
                    email: state.email,
                    password: state.password,
                })
                .then((response) => {
                    const {
                        data: { data: user }, //detrutorstring
                    } = response;
                    console.log(user.token.accessToken); //lay token ra
                    // luu token vao localstorage
                    localStorage.setItem("tokenlogin", user.token.accessToken);
                    state.error = null; //loi = null-> login thanh cong
                    //chuyen den giao dien calender
                    router.push({
                        name: "CalendarView",
                    });
                })
                .catch((error) => {
                    console.log(error);
                    console.log(error.response.data);
                    state.error = error.response.data.message;
                });
        };

        return { ...toRefs(state), Login };
    },
};
</script>
<style lang="scss" scoped>
@import "@/style/login.scss";
</style>
