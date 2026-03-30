<template>
    <Head title="Calendar"/>
    <PageHeader title="Calendars" pageTitle="Menu" />
    <b-row class="g-3">
        <div class="col-md-3">
            <div class="card shadow-none border">
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height:2.5rem;width:2.5rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-list-check-2 text-primary fs-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-14"><span class="text-body">Event Type List</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">Tracks calibration and maintenance alerts</p>
                        </div>
                        <div class="flex-shrink-0">
                        </div>
                    </div>
                </div>
                <div class="card-body border-bottom bg-white">
                    <div class="align-items-center d-flex">
                        <h5 class="card-title text-dark mb-0 fs-13 fw-semibold flex-grow-1">
                            <span v-if="!showDue">Calendar Event's</span>
                            <span v-else>Calendar Due Dates</span>
                        </h5>
                        <div class="flex-shrink-0">
                            <div class="form-check form-switch form-switch-right form-switch-md">
                                <label for="navbarscrollspy-showcode" class="form-label text-muted">
                                    <span v-if="!showDue">Other Events</span>
                                    <span v-else>Due Dates</span>
                                </label>
                                <input class="form-check-input code-switcher" v-model="showDue" type="checkbox" id="navbarscrollspy-showcode">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- {{ dropdowns.events }} -->
                <div class="card bg-white border-bottom shadow-none mb-0" style="height: calc(100vh - 343px); overflow: auto;">
                   <ul class="list-group list-group-flush border-dashed mb-n4 mt-n2 p-3">
    <li class="list-group-item px-0"
        v-for="(list,index) in dropdowns.events"
        :key="index">

        <!-- CLICKABLE HEADER -->
        <div class="d-flex cursor-pointer"
             @click="toggle(index)">

            <div class="flex-shrink-0 avatar-xs">
                <span class="avatar-title bg-light p-1 rounded-circle">
                    <i :class="icons[index]+' fs-16 '+colors[index]"></i>
                </span>
            </div>

            <div class="flex-grow-1 ms-2">
                <h6 class="mb-0 fs-12">{{list.label}}</h6>
                <p class="fs-11 mb-0 text-muted">
                    {{ activeIndex === index ? 'Hide details' : 'Show details' }}
                </p>
            </div>

            <div class="flex-shrink-0 text-end">
                <h6 class="mt-2 me-2 fs-12">{{list.count}}</h6>
            </div>
        </div>

        <!-- ACCORDION CONTENT -->
        <transition name="fade">
            <div v-if="activeIndex === index" class="mt-2">
                <div class="card-body shadow-none">
                    <div class="card-body p-2">

                        <!-- <div v-for="(opt,i) in list.options" :key="i"
                             class="d-flex justify-content-between align-items-center mb-1">

                            <span class="fs-12">
                                {{ opt.name }}
                            </span>

                            <span class="badge bg-light text-dark">
                                {{ opt.value }}
                            </span>
                        </div> -->
                        <ul class="list-group list-group-flush">
    <li  v-for="(opt,i) in list.options" :key="i" class="list-group-item fs-12">{{ opt.name }}</li>
</ul>

                    </div>
                </div>
            </div>
        </transition>

    </li>
</ul>
                    <!-- <div id="external-events" class="p-3">
                        <div v-for="(list,index) in dropdowns.events" 
                        v-bind:key="index" 
                        :class="'external-event fc-event '+list.color+' '+list.others" 
                        style="cursor: pointer;"
                        @click="openCreate(list)"
                        >
                        <i class="mdi mdi-checkbox-blank-circle me-2"></i>{{list.name}}
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card bg-light-subtle shadow-none border">
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height:2.5rem;width:2.5rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-calendar-todo-fill  text-primary fs-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-14"><span class="text-body">Laboratory Events and Schedules</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">A centralized calendar displaying official travel, meetings, audits, holidays, calibrations, BOD schedules, GAD activities, and other important events</p>
                        </div>
                    </div>
                </div>
                <div class="card-body bg-white rounded-bottom">
                    <FullCalendar ref="fullCalendar" :options="calendarOptions" />
                </div>
            </div>
        </div>
    </b-row>
    <Create @message="fetch()" ref="create"/>
    <View @message="fetch()" ref="view"/>
    <Tsr ref="tsr"/>
</template>
<script>
import Tsr from './Modals/Tsr.vue';
import View from './Modals/View.vue';
import Create from './Modals/Create.vue';
import "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";
import FullCalendar from "@fullcalendar/vue3";
import bootstrapPlugin from "@fullcalendar/bootstrap";
import interactionPlugin, { Draggable } from "@fullcalendar/interaction";
import PageHeader from '@/Shared/Components/PageHeader.vue';
export default {
    components: { PageHeader, FullCalendar, Tsr, View, Create },
    props: ['dropdowns'],
    data(){
        return {
            currentUrl: window.location.origin,
            activeIndex: null,
            icons: ['ri-flight-takeoff-fill','ri-walk-line','ri-suitcase-fill','ri-pencil-ruler-2-fill','ri-flask-fill'],
            colors: ['text-danger','text-success','text-info','text-warning','text-purple'],
            currentEvents: this.lists,
            showDue: false,
            calendarOptions: {
                timeZone: "Asia/Manila",
                droppable: true,
                navLinks: true,
                plugins: [
                    dayGridPlugin,
                    timeGridPlugin,
                    interactionPlugin,
                    bootstrapPlugin,
                    listPlugin,
                ],
                themeSystem: "bootstrap",
                headerToolbar: {
                    left: "prev,next today",
                    center: "title",
                    right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth",
                },
                windowResize: () => {
                    this.getInitialView();
                },
                initialView: this.getInitialView(),
                initialEvents: [],
                editable: true,
                showNonCurrentDates: false,
                fixedWeekCount: false,
                height: 'calc(100vh - 320px)',
                events: [],
                eventClick: this.editEvent,
            },
        }
    },   
    created(){
        this.fetch();
    },
    watch: {
        showDue(newValue) {
            this.fetch();
        },
    },
    methods: {
        toggle(index) {
            this.activeIndex = this.activeIndex === index ? null : index;
        },
        fetch(){
            axios.get('/schedules',{
                params : {
                    option: (this.showDue) ? 'dues' : 'events' 
                }
            })
            .then(response => {
                this.calendarOptions.events = response.data.data;        
            })
            .catch(err => console.log(err));
        },
        getInitialView() {
            if (window.innerWidth >= 768 && window.innerWidth < 1200) {
                return "timeGridWeek";
            } else if (window.innerWidth <= 768) {
                return "listMonth";
            } else {
                return "dayGridMonth";
            }
        },
        openCreate(data){
            this.$refs.create.show(data);
        },
        editEvent(event){
            if(this.showDue){
                this.$refs.tsr.show(event.event);
            }else{
                this.$refs.view.show(event.event);
            }
        }
    }
}
</script>
<style scoped>
.fade-enter-active, .fade-leave-active {
    transition: all 0.2s ease;
}
.fade-enter-from, .fade-leave-to {
    opacity: 0;
    transform: translateY(-5px);
}
</style>