<template>
    <b-modal style="--vz-modal-width: 700px;" v-model="showModal" hide-footer title="Calendar" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="modal-body mt-n4">
            <FullCalendar ref="fullCalendar" :options="calendarOptions" />
        </div>
    </b-modal>
</template>
<script>
import "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import FullCalendar from "@fullcalendar/vue3";
import bootstrapPlugin from "@fullcalendar/bootstrap";
import interactionPlugin, { Draggable } from "@fullcalendar/interaction";
export default {
    components: { FullCalendar },
    data(){
        return {
            showModal: false,
            currentEvents: [],
            showDue: false,
            calendarOptions: {
                timeZone: "Asia/Manila",
                plugins: [
                    dayGridPlugin,
                    interactionPlugin,
                    bootstrapPlugin
                ],
                themeSystem: "bootstrap",
                headerToolbar: {
                    left: "prev,next today",
                    center: "",
                    right: "title",
                },
                initialView: "dayGridMonth",
                height: 'auto',
                contentHeight: 'auto',
                expandRows: true,
                showNonCurrentDates: false,
                fixedWeekCount: false,
                events: [],
            }
        }
    },
    watch: {
        showModal(val) {
            if (val) {
                this.$nextTick(() => {
                    const calendarApi = this.$refs.fullCalendar?.getApi();
                    calendarApi?.updateSize();
                });
            }
        }
    },
    methods: { 
        show(){
            this.fetch();
            this.showModal = true;
        },
        fetch(){
            axios.get('/schedules',{
                params : {
                    option: 'dues' 
                }
            })
            .then(response => {
                this.calendarOptions.events = response.data;        
            })
            .catch(err => console.log(err));
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>