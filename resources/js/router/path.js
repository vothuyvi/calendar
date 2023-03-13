import Layout from "@/layouts/index.vue";
import login from "@/pages/Login.vue";
import Calender from "@/pages/Calendar.vue";
import Register from "@/pages/Register.vue";
import EventModel from "@/components/eventModel.vue";
const path = [
    {
        path: "/",
        component: Layout,
        children: [
            {
                path: "",
                name: "LoginView",
                component: login,
                
            },
            {
                path: "calendar",
                name: "CalendarView",
                component: Calender,
            },
            {
                path: "register",
                name: "ResisgerView",
                component: Register,
            },
            {
                path: "event-model",
                name: "EventModelView",
                component: EventModel,
            }
        ],
    },
];

export default path;
