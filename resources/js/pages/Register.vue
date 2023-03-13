<template>
    <div class="container__login">
        <div class="container__login-body">
            <div class="login-body__header">
                <span> Register</span>
            </div>
            <div class="login-body__center">
                <div v-if="error" class="error">
                    <div v-for="(key, value) in error" :key="key">
                        <div v-for="(item, index) in error[value]" :key="index">
                            {{ item }}
                        </div>
                    </div>
                </div>
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
                    type="password"
                    class="fontAwesome"
                    placeholder=" &#xf023;  Enter your password"
                />
                <input
                    v-model="passwordconfirmation"
                    type="password"
                    class="fontAwesome"
                    placeholder=" &#xf023;  Enter password confirmation"
                />
            </div>
            <div class="login-body__bot">
                <button @click="Register()">Sign Up</button>
                <div class="login-body-bot__signup"></div>
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
            passwordconfirmation: "",
            error: "",
        });
        const Register = () => {
            axios
                .post(import.meta.env.VITE_API_PUBLIC_KEY + "api/register", {
                    email: state.email,
                    password: state.password,
                    passwordconfirmation: state.passwordconfirmation,
                })
                .then((response) => {
                    const {
                        data: { data: user },
                    } = response;
                    console.log(user);
                    state.error = null;
                    router.push({
                        name: "LoginView",
                    });
                })
                .catch((error) => {
                    console.log(error);
                    console.log(error.response.data);
                    state.error = error.response.data.errors;
                });
        };
        return { ...toRefs(state), Register };
    },
};
</script>
<style lang="scss" scoped>
@import "@/style/login.scss";
</style>
