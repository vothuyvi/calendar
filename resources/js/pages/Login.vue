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
            </div>

            <div class="login-body__bot">
                <button @click="Login()">Sign In</button>
                <div class="login-body-bot__signup">
                    <router-link :to="{ name: 'ResisgerView' }"
                        ><span>Create your account?</span>
                    </router-link>
                </div>
            </div>
            <loading v-if="loading" />
        </div>
    </div>
</template>
<script>
import { reactive, toRefs } from 'vue';
import { useRouter } from 'vue-router';
import { TOKEN_LOGIN } from '@/const';
import Api from '@/utils/api';
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
            show: false,
            error: '',
            loading: false,
        });
        const Login = () => {
            //  lay data tu 2 input email va pass
            // goi axios gui data len api login
            // lay du lieu tra ve tu axios

            state.loading = true;
            Api.post('api/login', {
                email: state.email,
                password: state.password,
            })
                .then((response) => {
                    const {
                        data: { data: user }, //detrutorstring
                    } = response;
                    console.log(user.token.accessToken); //lay token ra
                    // luu token vao localstorage
                    localStorage.setItem(TOKEN_LOGIN, user.token.accessToken);
                    state.error = null; //loi = null-> login thanh cong
                    //chuyen den giao dien calender
                    router.push({
                        name: 'CalendarView',
                    });
                    state.loading = false;
                })
                .catch((error) => {
                    console.log(error);
                    console.log(error.response.data);
                    state.error = error.response.data.message;
                    state.loading = false;
                });
        };

        return { ...toRefs(state), Login };
    },
};
</script>
<style lang="scss" scoped>
@import '@/style/login.scss';
</style>
