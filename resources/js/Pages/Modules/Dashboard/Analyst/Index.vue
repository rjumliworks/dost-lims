<template>
    <Head title="Dashboard"/>
    <PageHeader title="Dashboard" pageTitle="Menu" />
    <b-row class="g-3">
        <div class="col-md-3">
            <div class="card shadow-none border">
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height:2.5rem;width:2.5rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-account-circle-fill text-primary fs-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-14"><span class="text-body">My Task & Reminders</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">Highlights urgency and updates</p>
                        </div>
                        <div class="flex-shrink-0"></div>
                    </div>
                </div>
                <div class="card-body border-bottom bg-white" style="cursor: pointer;" @click="openPerformance()">
                    <p class="mb-0 text-primary fs-12 fw-semibold">Analyst Performance Summary</p>
                </div>
                <div class="card bg-white border-bottom shadow-none mb-0" style="height: calc(100vh - 343px); overflow: auto;">
                    <ul class="list-group list-group-flush border-dashed mb-n3 mt-n1 p-3">
                        <li class="list-group-item px-0" v-for="(list,index) in tasks" v-bind:key="index">
                            <div class="d-flex">
                                <div class="flex-shrink-0 avatar-xs">
                                    <span class="avatar-title bg-light p-1 rounded-circle">
                                        <i :class="list.icon+' '+list.color"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-0 fs-12">{{list.name}}</h6>
                                    <p class="fs-11 mb-0 text-muted">{{ list.description }}</p>
                                </div>
                                <div class="flex-shrink-0 text-end">
                                    <h6 class="mt-2">{{list.count}}</h6>
                                </div>
                            </div>
                        </li>
                    </ul>

                    <hr class="text-muted"/>
                        <p class="ms-3 mb-0 text-primary fs-12 fw-semibold">Task Monitoring Summary</p>
                    <hr class="text-muted"/>

                    <ul class="list-group list-group-flush border-dashed mb-n3 mt-n3 p-3">
                        <li class="list-group-item px-0" @click="filterReminder(list)" v-for="(list,index) in reminders" v-bind:key="index" style="cursor: pointer;">
                            <div class="d-flex">
                                <div class="flex-shrink-0 avatar-xs">
                                    <span class="avatar-title bg-light p-1 rounded-circle">
                                        <i :class="list.icon+' '+list.color"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-0 fs-12" :class="(isActive(list.name)) ? 'text-primary fw-semibold' : ''">{{list.name}}</h6>
                                    <p class="fs-11 mb-0 text-muted">{{ list.description }}</p>
                                </div>
                                <div class="flex-shrink-0 text-end">
                                    <h6 class="mt-2">{{list.count}}</h6>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <Main :laboratories="laboratories" :years="years" ref="main"/>
        </div>
    </b-row>
    <Performance ref="performance"/>
</template>
<script>
import _ from 'lodash';
import Main from './Components/Main.vue';
import Performance from './Modals/Performance.vue';
import PageHeader from '@/Shared/Components/PageHeader.vue';
export default {
    components: { PageHeader, Performance, Main },
    props: ['tasks','reminders','laboratories','years'],
    data(){
        return {
            activeReminder: null,
            activeList: null,
            month: null,
            keyword: null,
            months: [
                { value: '1', name: 'January' },
                { value: '2', name: 'February' },
                { value: '3', name: 'March' },
                { value: '4', name: 'April' },
                { value: '5', name: 'May' },
                { value: '6', name: 'June' },
                { value: '7', name: 'July' },
                { value: '8', name: 'August' },
                { value: '9', name: 'September' },
                { value: '10', name: 'October' },
                { value: '11', name: 'November' },
                { value: '12', name: 'December' }
            ]
        }
    },
    watch: {
        month(newVal){
            this.$refs.sample.setMonth(newVal);
        },
        keyword(newVal){
            this.checkSearchStr(newVal);
        },
    },
    methods: {
        checkSearchStr: _.debounce(function(string) {
            this.$refs.sample.setKeyword(this.keyword);
        }, 300),
        filterReminder(data){
            if(data.name == this.activeList){
                this.activeList = null;
            }else{
                this.activeList = data.name;
            }
            this.$refs.main.filterReminder(data,this.activeList);
        },
        isActive(name) {
            return this.activeList === name;
        },
        openPerformance(){
            this.$refs.performance.show();
        }
    }
    
}
</script>