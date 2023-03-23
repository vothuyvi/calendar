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
                <div class="input-pass">
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

                <div class="input-pass">
                    <input
                        v-model="password_confirmation"
                        :type="showConirm === true ? 'text' : 'password'"
                        class="fontAwesome"
                        placeholder=" &#xf023;  Enter password confirmation"
                    />
                    <div class="show-hide__icon">
                        <i
                            class="fa-solid fa-eye show-icon"
                            v-if="showConirm"
                            @click="showConirm = !showConirm"
                        ></i>
                        <i
                            class="fa-solid fa-eye-slash hide-icon"
                            v-else
                            @click="showConirm = !showConirm"
                        ></i>
                    </div>
                </div>
            </div>
            <div class="login-body__bot">
                <button @click="register()">Sign Up</button>
                <div class="login-body-bot__signup"></div>
            </div>
        </div>
        <loading v-if="loading" />
    </div>
</template>
<script>
import { reactive, toRefs } from 'vue';
import Api from '@/utils/api';
import { useRouter } from 'vue-router';
import Loading from '@/components/Loading.vue';

export default {
    components: {
        Loading,
    },
    setup() {
        const router = useRouter();
        const state = reactive({
            email: '',
            password: '',
            password_confirmation: '',
            error: '',
            loading: false,
            show: false,
            showConirm: false,
            error: '',
        });
        /**
         * register
         * @author Vi :3
         */
        const register = () => {
            state.loading = true;
            Api.post('api/register', {
                email: state.email,
                password: state.password,
                password_confirmation: state.password_confirmation,
            })
                .then((response) => {
                    const {
                        data: { data: user },
                    } = response;
                    console.log(user);
                    state.error = null;
                    router.push({
                        name: 'LoginView',
                    });
                    state.loading = false;
                })
                .catch((error) => {
                    console.log(error);
                    console.log(error.response.data);
                    state.error = error.response.data.errors;
                    state.loading = false;
                });
        };
        return { ...toRefs(state), register };
    },
};
</script>
<style lang="scss" scoped>
@import '@/style/login.scss';
</style>
