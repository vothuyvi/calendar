<template>
    <div class="create__event">
        <div class="create-event__top">
            <i class="fa-solid fa-grip-lines"></i>
            <i class="fa-solid fa-xmark" @click="hiheModel()"></i>
        </div>
        <div class="create-event__center">
            <div class="create-event__center--title">
                <div v-if="state.success" class="success"></div>
                <div v-if="state.error" class="error">
                    <div v-for="(key, value) in state.error" :key="key">
                        <div
                            v-for="(item, index) in state.error[value]"
                            :key="index"
                        >
                            {{ item }}
                        </div>
                    </div>
                </div>
                <input
                    v-model="state.form.title"
                    type="text"
                    name=""
                    id=""
                    placeholder="Thêm tiêu đề và thời gian"
                />
            </div>
            <div class="create-event__center--btn">
                <button
                    :class="`${state.form.is_event ? 'btn_event' : ''}`"
                    @click="state.form.is_event = 1"
                >
                    Sự kiện
                </button>
                <button
                    :class="`${!state.form.is_event ? 'btn_event' : ''}`"
                    @click="state.form.is_event = 0"
                >
                    Lời nhắc
                </button>
            </div>
            <div class="create-event__center--datetime">
                <input
                    type="datetime-local"
                    id="start"
                    v-model="state.form.datetime_start"
                />
                <input
                    v-model="state.form.datetime_end"
                    v-if="state.form.is_event"
                    type="datetime-local"
                    id="end"
                />
            </div>
            <div class="create-event__center--note" v-if="state.form.is_event">
                <img src="@/img/hamburger.png" alt="" />
                <textarea
                    v-model="state.form.description"
                    placeholder="Thêm mô tả"
                    rows="1"
                    cols="30"
                ></textarea>
            </div>
            <hr />
            <div class="create-event__center--color" v-if="state.form.is_event">
                <i class="fa-regular fa-calendar"></i>
                <div class="create-event-center-color__chose">
                    <input
                        v-model="state.form.color"
                        class="color fontAwesome"
                        type="color"
                    />
                    <i class="fa-solid fa-caret-down"></i>
                </div>
            </div>
            <hr />
        </div>
        <div class="create-event__bot">
            <button
                v-if="state.form.id"
                @click="deleteEvent(state.form.id)"
                class="create-event__bot--btnDelete"
            >
                Xóa
            </button>
            <button @click="addEvent()">Lưu</button>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios';
import { reactive, onMounted } from 'vue';
import Api from '@/utils/api';
const emit = defineEmits(['closePopup', 'getAllEvent']); //con truyền qua cha dùng emit
const hiheModel = () => {
    emit('closePopup');
};

const props = defineProps({
    // khi muốn nhận dữ liệu từ cha từ bên con tạo 1 props.
    options: {
        type: Object,
        required: true,
    },
    eventget: {
        type: Object,
        required: true,
        default: '',
    },
});
onMounted(() => {
    //lay all trong props
    state.form = props.eventget;
});
const state = reactive({
    form: {
        id: '',
        title: '',
        is_event: 1,
        datetime_start: '',
        datetime_end: '',
        description: '',
        color: '',
    },
    error: '',
    success: '',
});
/**
 * add event
 * @author Vi
 */
const addEvent = () => {
    Api.post('api/add-event', state.form)
        .then((response) => {
            const {
                data: { events },
            } = response;
            console.log(events);
            state.error = null;
            emit('getAllEvent');
            emit('closePopup');
        })
        .catch((error) => {
            console.log(error);
            console.log(error.response.data);
            state.error = error.response.data.errors;
        });
};

/**
 * delete Event
 * @author Vi
 */
const deleteEvent = (id) => {
    Api.post('api/delete-event', {
        id: id,
    }).then(() => {
        emit('getAllEvent');
        emit('closePopup');
    });
};
</script>

<style lang="scss" scoped>
@import '@/style/event.scss';
</style>
