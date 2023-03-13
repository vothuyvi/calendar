<template>
    <div class="container">
        <div class="container__header">
            <div class="container__header--left">
                <label for="menu">
                    <i class="fa-solid fa-bars"></i>
                </label>
                <label for="menu">
                    <img src="@/img/calendar_20_2x.png" alt="" />
                </label>
                <span class="container-header-left__title">Lịch</span>
                <button>Hôm nay</button>
                <i class="fa-solid fa-angle-left"></i>
                <i class="fa-solid fa-angle-right"></i>
                <span class="container-header-left__today">Tháng 2, 2023</span>
            </div>
            <div class="container__header--right">
                <div class="container-header-right__icon">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <i class="fa-solid fa-gear"></i>
                </div>
                <div class="container-header-right__btn-select">
                    <label for="select">
                        <div class="btn-select">
                            Tháng <i class="fa-solid fa-caret-down"></i>
                        </div>
                    </label>
                    <input type="checkbox" id="select" />
                    <div class="container-header-right__list">
                        <div class="header-right-list__triangle"></div>
                        <div class="container-header-right-list__item">
                            <button @click="choseday()">Ngày</button>
                        </div>
                        <div class="container-header-right-list__item">
                            <button @click="chosewwek()">Tuần</button>
                        </div>
                        <div class="container-header-right-list__item">
                            <button @click="chosemonth()">Tháng</button>
                        </div>
                        <div class="container-header-right-list__item">
                            <button @click="choseyear()">Năm</button>
                        </div>
                    </div>
                </div>

                <div class="container-header-right__group-user">
                    <label for="logout">
                        <div class="container-header-right__user">
                            <span>Vi</span>
                        </div>
                    </label>

                    <input type="checkbox" id="logout" />
                    <div class="container-header-right__logout">
                        <div class="container-header-right__triangle"></div>
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Đăng xuất</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="container__body">
            <input type="checkbox" id="menu" class="menu" />
            <div class="container-body__left">
                <label for="insert">
                    <div class="container-boy-left__create">
                        <svg width="36" height="36" viewBox="0 0 36 36">
                            <path fill="#34A853" d="M16 16v14h4V20z"></path>
                            <path fill="#4285F4" d="M30 16H20l-4 4h14z"></path>
                            <path fill="#FBBC05" d="M6 16v4h10l4-4z"></path>
                            <path fill="#EA4335" d="M20 16V6h-4v14z"></path>
                            <path fill="none" d="M0 0h36v36H0z"></path>
                        </svg>
                        <span>Tạo</span>
                        <i class="fa-solid fa-caret-down"></i>
                    </div>
                </label>
                <input type="checkbox" name="" id="insert" class="insert" />
                <div class="container-body-left__drop-insert">
                    <div
                        class="container-body-left_drop-insert--item"
                        @click="state.isOpenPopupCreate = true"
                    >
                        <span>Sự kiện</span>
                    </div>

                    <div
                        class="container-body-left_drop-insert--item"
                        @click="state.isOpenPopupCreate = true"
                    >
                        <span>Lời nhắc</span>
                    </div>
                </div>

                <div class="container-body-left__canlendar">
                    <FullCalender v-bind:options="options" />
                </div>
                <div class="container-body-left__list-event">
                    <div class="list-event__title list-event__input">
                        <span> Lịch của tôi</span>
                        <i class="fa-solid fa-chevron-up"></i>
                    </div>
                    <div class="list-event__input">
                        <input type="checkbox" name="" id="" />
                        <span> Võ Thúy Vi </span>
                    </div>
                    <div class="list-event__input check_reminder">
                        <input type="checkbox" name="" id="" />
                        <span>Lời nhắc</span>
                    </div>
                    <div class="list-event__input">
                        <input type="checkbox" name="" id="" />
                        <span>Sự kiện</span>
                    </div>
                </div>
            </div>
            <div class="container-body__right">
                <FullCalender
                    ref="calendar"
                    v-bind:options="options"
                    id="calender"
                    :events="options.events"
                />
            </div>
        </div>
        <event-model
            v-if="state.isOpenPopupCreate"
            :options="options"
            :eventget="state.itemEvent"
            @close-popup="state.isOpenPopupCreate = false"
        />
    </div>
</template>

<style lang="scss" scoped>
@import "@/style/calender.scss";
</style>

<script setup>
import { ref, reactive, onMounted } from "vue";
import axios from "axios";
import "@fullcalendar/core";
import FullCalender from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listGridPlugin from "@fullcalendar/list";
import multiMonthPlugin from "@fullcalendar/multimonth";
import interactionPlugin from "@fullcalendar/interaction";
import EventModel from "@/components/EventModel.vue";
import { useInsertionEffect } from "preact/compat";
const id = ref(10);
const fullcalendar = ref(null);

const options = reactive({
    events: [],
    title: "",
    datetime_start: "",
    datetime_end: "",
    description: "",
    color: "",
    isEvent: true,
    plugins: [
        dayGridPlugin,
        timeGridPlugin,
        listGridPlugin,
        multiMonthPlugin,
        interactionPlugin,
    ],
    initialView: "dayGridMonth",

    editable: true,
    selectable: true,
    weekends: true,
    select: (arg) => {
        id.value = id.value + 1;

        const cal = arg.view.calendar;
        cal.unselect();
        cal.addEvent({
            id: `${id.value}`,
            title: `New event ${id.value}`,
            datetime_start: arg.datetime_start,
            datetime_end: arg.datetime_end,
            allDay: false,
        });
    },
    eventClick: function (info) {
        state.isOpenPopupCreate = true;
        console.log(info);
        // console.log(info.event.backgroundColor);
        // console.log(info.event.extendedProps.end_date);
        state.itemEvent = {
            title: info.event.title,
            is_event: info.event.extendedProps.is_event,
            description: info.event.extendedProps.description,
            datetime_start: info.event.extendedProps.start_date,
            datetime_end: info.event.extendedProps.end_date,
            color: info.event?.backgroundColor,
        };
    },
    dateClick: function (info) {
        state.itemEvent = {
            title: "",
            is_event: true,
            description: "",
            datetime_start: info.dateStr + "T00:00",
            datetime_end: info.dateStr + "T00:00",
            color: "",
        };
        state.isOpenPopupCreate = true;
        console.log(info);
    },
    eventDidMount: function (info) {
        if (!info.event.extendedProps.is_event) {
            info.el.classList.add("reminder");
            const title = info.el.querySelector(".fc-event-title");
            title.innerHTML = `<i class="fa-regular fa-hand-pointer"></i></i><span class="name_remider">${info.event.title}</span>`;
        } else {
            info.el.style.backgroundColor = info.event.backgroundColor;
            const title = info.el.querySelector(".fc-event-title");
            title.innerHTML = `<i class="fa-regular fa-calendar"></i></i></i><span class="name_remider">${info.event.title}</span>`;
        }
        console.log(info);
    },
});

const state = reactive({
    isOpenPopupCreate: false,
    is_event: false,
    itemEvent: {},
});

const selectEvent = () => {
    axios
        .get(import.meta.env.VITE_API_PUBLIC_KEY + "api/select-event", {})
        .then((response) => {
            const events = [];
            const eventDatas = response.data.data;
            eventDatas.forEach((item) => {
                events.push({
                    ...item, //copy item
                    start: item.start_date,
                    end: item.end_date ? item.end_date : item.start_date,
                    color: item.is_event ? item.color : "#3F51B5",
                });
            });
            console.log(events);
            options.events = events;
        });
};
const choseday = () => {
    fullcalendar.value.getApi().changeView("timeGridDay");
};
const chosewwek = () => {
    fullcalendar.value.getApi().changeView("timeGridWeek");
};
const chosemonth = () => {
    fullcalendar.value.getApi().changeView("dayGridMonth");
};
const choseyear = () => {
    fullcalendar.value.getApi().changeView("multiMonthYear");
};

onMounted(() => {
    selectEvent();
});
</script>
