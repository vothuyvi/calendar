<template>
    <div class="container">
        <div class="container__header">
            <div class="container__header--left">
                <label for="menu" @click="render()">
                    <i class="fa-solid fa-bars"></i>
                </label>
                <label for="menu">
                    <img src="@/img/calendar_20_2x.png" alt="" />
                </label>
                <span class="container-header-left__title">Lịch</span>
                <button @click="goToDay()">Hôm nay</button>
                <i class="fa-solid fa-angle-left" @click="preMonth()"></i>
                <i class="fa-solid fa-angle-right" @click="nextMonth()"></i>
                <span class="container-header-left__today">
                    {{ renderTitle(state.presentMonth) }}
                </span>
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
                            <button @click="chosewek()">Tuần</button>
                        </div>
                        <div class="container-header-right-list__item">
                            <button @click="chosemonth()">Tháng</button>
                        </div>
                        <div class="container-header-right-list__item">
                            <button @click="choseyear()">Năm</button>
                        </div>
                    </div>
                </div>
                <div class="container-header-right__name-user">
                    <span>{{ state.user.email }}</span>
                </div>
                <div class="container-header-right__group-user">
                    <label for="logout">
                        <div class="container-header-right__icon-user">
                            <span><i class="fa-solid fa-user"></i></span>
                        </div>
                    </label>

                    <input type="checkbox" id="logout" />
                    <div
                        @click="logout()"
                        class="container-header-right__logout"
                    >
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
                        @click="createNew(true)"
                    >
                        <span>Sự kiện</span>
                    </div>
                    <div
                        class="container-body-left_drop-insert--item"
                        @click="createNew(false)"
                    >
                        <span>Lời nhắc</span>
                    </div>
                </div>

                <div class="container-body-left__canlendar">
                    <div class="container-body-left__canlendar--title">
                        <span class="container-header-left__today">
                            {{ renderTitle(state.presentMonthSmall) }}
                        </span>
                        <div>
                            <i
                                class="fa-solid fa-angle-left"
                                @click="preMonthSmall()"
                            ></i>
                            <i
                                class="fa-solid fa-angle-right"
                                @click="nextMonthSmall()"
                            ></i>
                        </div>
                    </div>
                    <div class="container-body-right__header">
                        <table>
                            <tr>
                                <th>CN</th>
                                <th>T2</th>
                                <th>T3</th>
                                <th>T4</th>
                                <th>T5</th>
                                <th>T6</th>
                                <th>T7</th>
                            </tr>
                        </table>
                    </div>
                    <FullCalender
                        v-bind:options="optionCalendarSmall"
                        ref="calendarSmall"
                    />
                </div>
                <div class="container-body-left__list-event">
                    <div class="list-event__title list-event__input">
                        <span> Lịch của tôi</span>
                        <i class="fa-solid fa-chevron-up"></i>
                    </div>

                    <div class="list-event__input">
                        <input
                            type="checkbox"
                            name=""
                            id=""
                            v-model="state.filter.event"
                        />
                        <span>Sự kiện</span>
                    </div>
                    <div class="list-event__input check_reminder">
                        <input
                            type="checkbox"
                            name=""
                            id=""
                            v-model="state.filter.reminder"
                        />
                        <span>Lời nhắc</span>
                    </div>
                </div>
            </div>
            <div class="container-body__right">
                <div class="container-body-right__header">
                    <table>
                        <tr>
                            <th>CN</th>
                            <th>TH 2</th>
                            <th>TH 3</th>
                            <th>TH 4</th>
                            <th>TH 5</th>
                            <th>TH 6</th>
                            <th>TH 7</th>
                        </tr>
                    </table>
                </div>

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
            @get-all-event="selectEvent()"
        />
        <loading v-if="state.loading" />
    </div>
</template>

<style lang="scss" scoped>
@import '@/style/calender.scss';
</style>

<script setup>
import { ref, reactive, onMounted, watch } from 'vue';
import '@fullcalendar/core';
import FullCalender from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listGridPlugin from '@fullcalendar/list';
import multiMonthPlugin from '@fullcalendar/multimonth';
import interactionPlugin from '@fullcalendar/interaction';
import EventModel from '@/components/EventModel.vue';
import Loading from '@/components/Loading.vue';
import { useRouter } from 'vue-router';
import Api from '@/utils/api';
import { TOKEN_LOGIN, COLOR } from '@/const/index.js';

const id = ref(10);
const calendar = ref(null);
const calendarSmall = ref(null);
const options = reactive({
    events: [],
    title: '',
    datetime_start: '',
    datetime_end: '',
    description: '',
    color: '',
    isEvent: true,
    plugins: [
        dayGridPlugin,
        timeGridPlugin,
        listGridPlugin,
        multiMonthPlugin,
        interactionPlugin,
    ],
    timeZone: 'UTC',
    initialView: 'dayGridMonth',
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
        state.itemEvent = {
            id: info.event.extendedProps.event_id,
            title: info.event.title,
            is_event: info.event.extendedProps.is_event,
            description: info.event.extendedProps.description,
            datetime_start: info.event.extendedProps.start_date,
            datetime_end: info.event.extendedProps.end_date,
            color: info.event?.backgroundColor,
        };
        state.isOpenPopupCreate = true;
    },

    dateClick: function (info) {
        state.itemEvent = {
            id: null,
            title: '',
            is_event: true,
            description: '',
            datetime_start: info.dateStr + 'T00:00',
            datetime_end: info.dateStr + 'T00:00',
            color: '',
        };
        state.isOpenPopupCreate = true;
    },

    eventDidMount: function (info) {
        if (!info.event.extendedProps.is_event) {
            info.el.classList.add('reminder');
            const title = info.el.querySelector('.fc-event-title');
            title.innerHTML = `<i class="fa-regular fa-hand-pointer"></i></i><span class="name_remider">${info.event.title}</span>`;
        } else {
            info.el.style.backgroundColor = info.event.backgroundColor;
            const title = info.el.querySelector('.fc-event-title');
            title.innerHTML = `<i class="fa-regular fa-calendar"></i></i></i><span class="name_remider">${info.event.title}</span>`;
        }
        //fix bug create
        let events = document.querySelectorAll('.fc-event-title');
        //duyet qua event, kiem tra lenght = 3 moi xu ly
        events.forEach((item) => {
            if (item.childNodes.length == 3) {
                item.childNodes[2].textContent = '';
            }
        });
        // console.log(events[0].childNodes);
    },

    datesSet: function (dateInfo) {
        console.log(dateInfo);
        const numberOfDayToAdd = 10;
        const nextDay = new Date(dateInfo.start.getTime());
        nextDay.setDate(dateInfo.start.getDate() + numberOfDayToAdd);
        state.presentMonth = nextDay;
        state.presentMonthSmall = nextDay;
        calendarSmall.value.getApi().gotoDate(nextDay);
    },
});
const optionCalendarSmall = reactive({
    events: [],
    plugins: [
        dayGridPlugin,
        timeGridPlugin,
        listGridPlugin,
        multiMonthPlugin,
        interactionPlugin,
    ],
    timeZone: 'UTC',
    initialView: 'dayGridMonth',
    editable: true,
    selectable: true,
    weekends: true,

    datesSet: function (dateInfo) {
        const numberOfDayToAdd = 10;
        const nextDay = new Date(dateInfo.start.getTime());
        nextDay.setDate(dateInfo.start.getDate() + numberOfDayToAdd);
        state.presentMonthSmall = nextDay;
    },

    dateClick: function (info) {
        console.log(info);
        calendar.value.getApi().gotoDate(info.dateStr);
        setTimeout(() => {
            //fix bug create
            let events = document.querySelectorAll('.fc-event-title');
            //duyet qua event, kiem tra lenght = 3 moi xu ly
            events.forEach((item) => {
                if (item.childNodes.length == 3) {
                    item.childNodes[2].textContent = '';
                }
            });
        }, 0);
    },
});

const router = useRouter();
const state = reactive({
    isOpenPopupCreate: false,
    isCloseDrop: false,
    is_event: false,
    itemEvent: {},
    presentMonth: '',
    presentMonthSmall: '',
    filter: {
        event: true,
        reminder: true,
    },
    loading: false,
    user: [],
});

/**
 * format month header title
 * @author: Vi
 */
const renderTitle = (presentDate) => {
    if (presentDate) {
        const monthNames = [
            'Tháng 1',
            'Tháng 2',
            'Tháng 3',
            'Tháng 4',
            'Tháng 5',
            'Tháng 6',
            'Tháng 7',
            'Tháng 8',
            'Tháng 9',
            'Tháng 10',
            'Tháng 11',
            'Tháng 12',
        ];
        const d = new Date(presentDate);
        return monthNames[d.getMonth()] + ', ' + d.getFullYear();
    }
    return '';
};
/**
 * create new
 * @author Vi :3
 */
const createNew = (isEvent) => {
    state.isOpenPopupCreate = true;
    state.itemEvent = {
        id: null,
        title: '',
        is_event: isEvent,
        description: '',
        datetime_start: '',
        datetime_end: '',
        color: '',
    };
};
/**
 * select event
 * @author Vii
 */
const selectEvent = async () => {
    state.loading = true;
    await Api.get('api/select-event?type=' + getTypeFilter()).then(
        (response) => {
            const events = [];
            const eventDatas = response.data.data;
            eventDatas.forEach((item) => {
                events.push({
                    ...item, //copy item
                    start: item.start_date,
                    end: item.end_date ? item.end_date : item.start_date,
                    color: item.is_event ? item.color : COLOR,
                    event_id: item.id,
                });
            });
            state.loading = false;
            console.log(events);
            options.events = events;

            setTimeout(() => {
                //fix bug create
                let events = document.querySelectorAll('.fc-event-title');
                //duyet qua event, kiem tra lenght = 3 moi xu ly
                events.forEach((item) => {
                    if (item.childNodes.length == 3) {
                        item.childNodes[2].textContent = '';
                    }
                });
            }, 10);
        }
    );
};

watch(() => state.filter.event, selectEvent);
watch(() => state.filter.reminder, selectEvent);

/**
 * get type check event & check reminder
 * @author Vi
 */
const getTypeFilter = () => {
    if (state.filter.event && state.filter.reminder) {
        return 2;
    }
    if (state.filter.event) {
        return 1;
    }
    if (state.filter.reminder) {
        return 0;
    }
    return 3;
};
/**
 * logout
 * @author Vi
 */
const logout = () => {
    Api.post('api/logout').then(() => {
        localStorage.removeItem(TOKEN_LOGIN);
        state.error = null;
        router.push({
            name: 'LoginView',
        });
    });
};

/**
 * get info user
 * @author Vii :3
 */
const getInfo = async () => {
    await Api.get('api/get-info').then((response) => {
        const userData = response.data.data;
        state.user = userData;
    });
};

const goToDay = () => {
    calendar.value.getApi().today();
    calendarSmall.value.getApi().today();
    setTimeout(() => {
        //fix bug create
        let events = document.querySelectorAll('.fc-event-title');
        //duyet qua event, kiem tra lenght = 3 moi xu ly
        events.forEach((item) => {
            if (item.childNodes.length == 3) {
                item.childNodes[2].textContent = ''; // chinh dong text thừa
            }
        });
    }, 5);
};
const nextMonth = () => {
    calendar.value.getApi().next();
};
const preMonth = () => {
    calendar.value.getApi().prev();
};
const nextMonthSmall = () => {
    calendarSmall.value.getApi().next();
};
const preMonthSmall = () => {
    calendarSmall.value.getApi().prev();
};

const choseday = () => {
    calendar.value.getApi().changeView('timeGridDay');
};
const chosewek = () => {
    calendar.value.getApi().changeView('timeGridWeek');
};
const chosemonth = () => {
    calendar.value.getApi().changeView('dayGridMonth');
};
const choseyear = () => {
    calendar.value.getApi().changeView('multiMonthYear');
};
const render = () => {
    console.log('render');
    calendar.value.getApi().destroy();
    setTimeout(() => {
        calendar.value.getApi().render();
    }, 0);
};
onMounted(async () => {
    await getInfo();
    await selectEvent();
});
</script>
