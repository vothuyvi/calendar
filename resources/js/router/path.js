import Layout from '@/layouts/index.vue';
import login from '@/pages/Login.vue';
import Calender from '@/pages/Calendar.vue';
import Register from '@/pages/Register.vue';
import EventModel from '@/components/eventModel.vue';
import Error404 from '@/pages/Error404.vue';
const path = [
    {
        path: '/',
        component: Layout,
        children: [
            {
                path: '',
                name: 'LoginView',
                component: login,
            },
            {
                path: 'calendar',
                name: 'CalendarView',
                component: Calender,
            },
            {
                path: 'register',
                name: 'RegisterView',
                component: Register,
            },
            {
                path: 'event-model',
                name: 'EventModelView',
                component: EventModel,
            },
            {
                path: '404',
                name: '404',
                component: Error404,
            },
        ],
    },
];

export default path;
