import "./bootstrap";
import { createApp } from "vue";
import router from "@/router/index.js";
import App from "@/App.vue";

// import fullCalendar from "vue-fullcalendar";
// app.component("full-calendar", fullCalendar);
// app.config.productionTip = false;
import "@/style/common.scss";

const app = createApp(App);
app.use(router);
app.mount("#app");
