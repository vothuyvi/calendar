<template>
    <div class="body-create-event">
        <div class="create__event">
            <div class="create-event__top">
                <i class="fa-solid fa-grip-lines"></i>
                <i class="fa-solid fa-xmark" @click="hideModel()"></i>
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
                        maxlength="192"
                        placeholder="Thêm tiêu đề và thời gian"
                    />
                </div>
                <div class="create-event__center--btn">
                    <button
                        v-if="state.form.is_event || !state.form.id"
                        :class="`${state.form.is_event ? 'btn_event' : ''}`"
                        @click="state.form.is_event = 1"
                    >
                        Sự kiện
                    </button>
                    <button
                        v-if="!state.form.is_event || !state.form.id"
                        :class="`${!state.form.is_event ? 'btn_event' : ''}`"
                        @click="state.form.is_event = 0"
                    >
                        Lời nhắc
                    </button>
                </div>

                <div class="create-event__center--datetime">
                    <i class="fa-regular fa-clock"></i>
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
                <div
                    class="create-event__center--note"
                    v-if="state.form.is_event"
                >
                    <img src="@/img/hamburger.png" alt="" />
                    <textarea
                        v-model="state.form.description"
                        maxlength="192"
                        placeholder="Thêm mô tả"
                        rows="1"
                        cols="30"
                    ></textarea>
                </div>
                <hr v-if="state.form.is_event" />
                <div
                    class="create-event__center--color"
                    v-if="state.form.is_event"
                >
                    <i class="fa-regular fa-calendar"></i>
                    <div class="create-event-center-color__chose">
                        <label for="input-color">
                            <input
                                v-model="state.form.color"
                                type="color"
                                class="color"
                                id="input-color"
                                :style="{
                                    backgroundColor: state.form.color,
                                }"
                            />
                            <i class="fa-solid fa-caret-down"></i>
                        </label>
                    </div>
                </div>
                <hr v-if="state.form.is_event" />
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
            <Loading v-if="state.loading" />
        </div>
    </div>
</template>

<script setup>
import { reactive, onMounted } from 'vue';
import Loading from '@/components/Loading.vue';
import Api from '@/utils/api';
const emit = defineEmits(['closePopup', 'getAllEvent']); //con truyền qua cha dùng emit

/**
 * hideModel: close Popup
 * @author Vi :3
 */
const hideModel = () => {
    emit('closePopup');
};

const props = defineProps({
    // khi muốn nhận dữ liệu từ cha từ bên con tạo 1 props.
    options: {
        type: Object,
        required: true,
    },
    eventGet: {
        type: Object,
        required: true,
        default: '',
    },
});

onMounted(() => {
    //lay all trong props
    state.form = props.eventGet;
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
    loading: false,
});

/**
 *check Validator trên font end
 * @author Vi :3
 */
const checkValidator = () => {
    let check = true;
    const error = {};
    if (state.form.title == '') {
        check = false;
        //duyệt qua key = title  in ra msg lỗi!
        error.title = ['Tiêu đề không được để trống!'];
    }
    if (state.form.is_event) {
        if (state.form.datetime_start >= state.form.datetime_end) {
            check = false;
            error.end_date = ['Ngày kết thúc phải lớn hơn ngày bắt đầu!'];
        }
    }
    state.error = error;
    return check;
};

/**
 * add event
 * @author Vi
 */
const addEvent = () => {
    if (!checkValidator()) {
        return false;
    } else {
        state.loading = true;
        Api.post('api/add-event', state.form)
            .then((response) => {
                const {
                    data: { events },
                } = response;
                console.log(events);
                state.error = null;
                emit('getAllEvent'); // cập nhật lại event trên calendar
                emit('closePopup'); // popup eventmodel
                state.loading = false;
            })
            .catch((error) => {
                state.loading = false;
                console.log(error.response.data);
                state.error = error.response.data.errors;
            });
    }
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
