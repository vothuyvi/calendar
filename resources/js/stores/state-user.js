import { defineStore } from 'pinia';
export const useUser = defineStore('userId', {
    state: () => ({
        user: {},
    }),
    actions: {
        onUsers(data) {
            this.user = data;
        },
    },
});
