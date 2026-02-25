<template>
    <div class="row g-3">
        <div class="col-md-12 mb-n4">
            <div class="card shadow-none border">
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height:2.5rem;width:2.5rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="fs-24" :class="(name) ? name.icon+' '+name.color : 'ri-gps-fill text-primary'"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-14"><span class="text-body">{{(name) ? name.name : 'Testing Progress Tracker'}}</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">{{ (name) ? name.description : 'Monitoring the status of tests from pending to completion'}}</p>
                        </div>
                        <div class="flex-shrink-0">
                          <form action="javascript:void(0);">
                        <div class="row g-3 mb-0 align-items-center">
                            <div class="col-sm-auto">
                                <div class="input-group">
                                    <select v-model="laboratory" class="form-select" aria-label="Default select example"> 
                                         <!-- :disabled="loading" -->
                                        <option :value="null">All handled Laboratory</option>
                                        <option :value="list.value" v-for="list in laboratories" :key="list.value">{{ list.name }}</option>
                                    </select>
                                    <!-- <select v-model="filter.year" class="form-select" aria-label="Default select example"> 
                                        <option :value="list" v-for="list in years" :key="list">{{ list }}</option>
                                    </select> -->
                                    <div class="input-group-text bg-primary border-primary text-white">
                                        <i class="ri-flask-fill"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                        </div>
                    </div>
                </div>
                <div class="card-body rounded bg-white">
                     <div class="input-group mb-0">
                        <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                        <input type="text" :placeholder="'Search '+filter.type" v-model="filter.keyword" class="form-control" style="width: 30%;">
                        <Multiselect class="white" style="width: 17%;" :options="months" v-model="filter.month" label="name" :allow-empty="false" :searchable="true" placeholder="Filter by Month" />
                        <Multiselect class="white" style="width: 20%;" :options="['Sample Code','Testing Parameter']" v-model="filter.type" :searchable="true" :allow-empty="false"/>
                        <Multiselect class="white" style="width: 10%;"  :can-clear="false" :can-deselect="false" :options="years" :searchable="true" v-model="filter.year" label="name" placeholder="Filter Year" />
                        <b-button type="button" variant="primary"  @click="(checked1.length > 0 || checked2.length > 0) ? openUpdate() : '' ">
                            <i class="ri-timer-line search-icon"></i> Update
                        </b-button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-none border">
                <div class="card-header bg-warning-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height:2rem;width:2rem;">
                                <span class="avatar-title bg-warning text-primary rounded-circle fs-4">
                                    <i class="ri-add-circle-fill text-light align-middle"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-14"><span class="text-body">Pending Tests</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">Tests awaiting action or completion</p>
                        </div>
                        <div class="flex-shrink-0"></div>
                    </div>
                </div>
                <div class="card-body bg-light-subtle border-bottom">
                    <p class="mb-0 text-primary text-center fw-semibold fs-12">
                        <input v-if="filter.keyword" class="form-check-input float-start fs-16 mt-0" v-model="mark1" type="checkbox" value="option" />
                         {{pendings.total}} Sample ready for test
                    </p>
                </div>
                <div class="card shadow-none" no-body style="height: calc(100vh - 522px)">
                    <simplebar data-simplebar style="height: calc(100vh - 500px);">
                        <BRow v-if="pendings.total > 0">
                            <BCol lg="12" class="project-card mb-n3" v-for="(item, index) of pendings.data" :key="index">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex align-items-center"> 
                                            <input type="checkbox" v-model="item.selected" @change="toggleChecked($event, item, index)"  class="form-check-input me-2" />
                                            <div class="flex-grow-1 text-muted" style="cursor: pointer;"  @click="openShow(item.id,'Pending')">
                                                <h6 class="card-title mb-n1 fs-14 fw-semibold"><span class="text-primary">{{(filter.type == 'Sample Code') ? item.code : item.testservice_name}}</span></h6>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div class="text-muted"><i class="ri-calendar-event-fill me-1 align-bottom"></i>{{(item.tsr) ? formatShortMonth(item.tsr.due_at) : '-'}}</div>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column h-100 mt-1" style="cursor: pointer;"  @click="openShow(item.id,'Pending')">
                                            <div class="mt-auto">
                                                <div class="d-flex mb-2">
                                                    <div class="flex-grow-1">
                                                        <div class="text-muted">{{item.name}}</div>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <div v-if="filter.type == 'Sample Code'">
                                                            <i class="ri-list-check align-bottom me-1 text-muted"></i>
                                                            {{(item.ongoing)}}/{{(item.count-item.completed)}}
                                                        </div>
                                                         <div v-else>
                                                            <i class="ri-list-check align-bottom me-1 text-muted"></i>
                                                            {{item.code}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="progress progress-sm animated-progess">
                                                    <div class="progress-bar bg-success" role="progressbar" aria-valuenow="34" aria-valuemin="0" aria-valuemax="100" :style="`width: ${item.progressBar};`"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </BCol>
                            <div v-if="pendings.next_page_url" class="text-center mt-2">
                                <button class="btn btn-sm btn-outline-primary"
                                    @click="loadMore('pendings')"
                                    :disabled="loading">
                                    Show More
                                </button>
                            </div>
                        </BRow>
                        <div v-else class="alert alert-light mb-0 text-center" role="alert"><span class="fs-12 text-muted">No test available</span></div>
                    </simplebar>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-none border">
                <div class="card-header bg-info-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height:2rem;width:2rem;">
                                <span class="avatar-title bg-info text-primary rounded-circle fs-4">
                                    <i class="ri-record-circle-fill text-light align-middle"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-14"><span class="text-body">Ongoing Tests</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">Tests currently in progress or under review</p>
                        </div>
                        <div class="flex-shrink-0"></div>
                    </div>
                </div>
                <div class="card-body bg-light-subtle border-bottom bg-white">
                     <input v-if="filter.keyword" class="form-check-input float-start fs-16 mt-0" v-model="mark2" type="checkbox" value="option" />
                    <p class="mb-0 text-primary fs-12 fw-semibold text-center">{{ongoings.total}} ongoing test</p>
                </div>
                <div class="card bg-white shadow-none" no-body style="height: calc(100vh - 522px)">
                    <simplebar data-simplebar style="height: calc(100vh - 500px);">
                        <BRow v-if="ongoings.total > 0">
                            <BCol lg="12" class="project-card mb-n3" v-for="(item, index) of ongoings.data" :key="index">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex align-items-center">
                                             <input type="checkbox" v-model="item.selected" @change="toggleChecked1($event, item, index)" class="form-check-input me-2" />    
                                            <div class="flex-grow-1 text-muted" style="cursor: pointer;" @click="openShow(item.id,'Ongoing')">
                                                <h6 class="card-title mb-n1 fs-14 fw-semibold"><span class="text-primary">{{(filter.type == 'Sample Code') ? item.code : item.testservice_name}}</span></h6>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div class="text-muted"><i class="ri-calendar-event-fill me-1 align-bottom"></i>{{(item.tsr) ? formatShortMonth(item.tsr.due_at) : '-'}}</div>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column h-100 mt-1" style="cursor: pointer;" @click="openShow(item.id,'Ongoing')">
                                            <div class="mt-auto">
                                                <div class="d-flex mb-2">
                                                    <div class="flex-grow-1">
                                                        <div class="text-muted">{{item.name}}</div>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <div v-if="filter.type == 'Sample Code'">
                                                            <i class="ri-list-check align-bottom me-1 text-muted"></i>
                                                            {{(item.ongoing)}}/{{(item.count-item.completed)}}
                                                        </div>
                                                         <div v-else>
                                                            <i class="ri-list-check align-bottom me-1 text-muted"></i>
                                                            {{item.code}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="progress progress-sm animated-progess">
                                                    <div class="progress-bar bg-success" role="progressbar" aria-valuenow="34" aria-valuemin="0" aria-valuemax="100" :style="`width: ${item.progressBar};`"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </BCol>
                            <div v-if="ongoings.next_page_url" class="text-center mt-2">
                                <button class="btn btn-sm btn-outline-primary"
                                    @click="loadMore('ongoings')"
                                    :disabled="loading">
                                    Show More
                                </button>
                            </div>
                        </BRow>
                        <div v-else class="alert alert-light mb-0 text-center" role="alert"><span class="fs-12 text-muted">No test available</span></div>
                        </simplebar>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-none border">
                <div class="card-header bg-success-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height:2rem;width:2rem;">
                                <span class="avatar-title bg-success text-primary rounded-circle fs-4">
                                    <i class="ri-checkbox-circle-fill text-light align-middle"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-14"><span class="text-body">Completed Tests</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">Tests finalized and ready for reporting</p>
                        </div>
                        <div class="flex-shrink-0"></div>
                    </div>
                </div>
                <div class="card-body bg-light-subtle border-bottom bg-white">
                    <p class="mb-0 text-primary fs-12 fw-semibold text-center">{{completeds.total}} samples completed</p>
                </div>
                <div class="card bg-white shadow-none" no-body style="height: calc(100vh - 522px)">
                    <simplebar data-simplebar style="height: calc(100vh - 500px);">
                        <BRow v-if="completeds.total > 0">
                        <BCol lg="12" class="project-card mb-n3" v-for="(item, index) of completeds.data" :key="index">
                            <div class="card" style="cursor: pointer;" @click="openShow(item.id,'Completed')">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 text-muted">
                                            <h6 class="card-title mb-n1 fs-14 fw-semibold"><span class="text-primary">{{item.code}}</span></h6>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="text-muted"><i class="ri-calendar-event-fill me-1 align-bottom"></i>{{ (item.tsr) ? formatShortMonth(item.tsr.due_at) : '-'}}</div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column h-100 mt-1">
                                        <div class="mt-auto">
                                            <div class="d-flex mb-2">
                                                <div class="flex-grow-1">
                                                    <div class="text-muted">{{item.name}}</div>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <div>
                                                        <i class="ri-list-check align-bottom me-1 text-muted"></i>{{item.completed}}/{{item.count}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="progress progress-sm animated-progess">
                                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="34" aria-valuemin="0" aria-valuemax="100" :style="`width: ${(item.completed/item.count)*100}%;`"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                            </div>
                        </BCol>
                        <div v-if="completeds.next_page_url" class="text-center mt-2">
                            <button class="btn btn-sm btn-outline-primary"
                                @click="loadMore('completeds')"
                                :disabled="loading">
                                Show More
                            </button>
                        </div>
                    </BRow>
                    <div v-else class="alert alert-light mb-0 text-center" role="alert"><span class="fs-12 text-muted">No test available</span></div>
                    </simplebar>
                </div>
            </div>
        </div>
    </div>
    <View @update="fetch()" ref="view"/>
    <Update @update="updateList" ref="update"/>
</template>
<script>
import _ from 'lodash';
import simplebar from "simplebar-vue";
import View from './Modals/View.vue';
import Update from './Modals/Update.vue';
import Multiselect from "@vueform/multiselect";
export default {
    components: { simplebar, Multiselect, Update, View },
    props: ['searchQuery','laboratories','years'],
    data() {
        return {
            pendings: [],
            ongoings: [],
            completeds: [],
            name: null,
            showSoon: false,
            showDueToday: false,
            showOverdue: false,
            filter: {
                keyword: null,
                month: null,
                type: 'Sample Code',
                year: new Date().getFullYear(),
                reminder: null
            },
            mark1: null,
            mark2: null,
            laboratory: null,
            loading: false,
            checked1: [],
            checked2: [],
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
        };
    },
    watch: {
        laboratory() {
            this.fetch();
        },
        "filter.month"(newVal){
            this.fetch();
        },
        "filter.type"(newVal){
            this.fetch();
        },
        "filter.keyword"(newVal){
            this.checkSearchStr(newVal);
        },
        "filter.year"(newVal){
            this.fetch();
        },
        "mark1"(){
            if(this.mark1){
                this.pendings.data.forEach(item => {
                    item.selected = true;
                    this.checked1.push(item);
                });
            }else{
                this.pendings.data.forEach(item => {
                    item.selected = false;
                });
                this.checked1 = [];
            }
            this.mark2 = null;
            this.checked2 = [];
        },
         "mark2"(){
            if(this.mark2){
                this.ongoings.data.forEach(item => {
                    item.selected = true;
                    this.checked2.push(item);
                });
            }else{
                this.ongoings.data.forEach(item => {
                    item.selected = false;
                });
                this.checked2 = [];
            }
            this.mark1 = null;
            this.checked1 = [];
        },
    },
    created(){
        this.fetch();
    },
    methods: {
        checkSearchStr: _.debounce(function(string) {
            this.fetch();
        }, 300),
        fetch(page_url = null, type = null){
            this.loading = true;
            page_url = page_url || '/analyses';
            axios.get(page_url,{
                params : {
                    laboratory: this.laboratory,
                    type: this.filter.type,
                    keyword: this.filter.keyword,
                    month: this.filter.month,
                    year: this.filter.year,
                    reminder: this.filter.reminder,
                    option: 'tagging'
                }
            })
            .then(response => {
                if(response){
                    if (!type) {
                        // First load (reset all)
                        this.pendings = response.data.pendings;
                        this.ongoings = response.data.ongoings;
                        this.completeds = response.data.completeds;
                    } else {
                        // Append only specific status
                        this[type].data.push(...response.data[type].data);
                        this[type].next_page_url = response.data[type].next_page_url;
                    }
                }
                this.loading = false;
            })
            .catch(err => console.log(err));
        },
        openUpdate(){
            if(this.mark1){
                this.$refs.update.show(this.checked1);
            }else{
                if(this.checked1.length > 0){
                    this.$refs.update.show(this.checked1,this.filter.type);
                }else{
                    this.$refs.update.show(this.checked2,this.filter.type);
                }
            }
        },
        openShow(data,status){
            if(status == 'Completed'){
                this.$refs.view.show(data,status,this.filter.type)
            }else{
                (this.filter.type == 'Sample Code') ? this.$refs.view.show(data,status,this.filter.type) : this.$refs.show.show2(data,status,this.filter.type);
            }
        }, 
        updateList(){
            this.fetch();
            this.checked1 = [];
            this.checked2 = [];
            this.mark1 = null;
            this.mark2 = null;
        },
        toggleChecked(event, item, index) {
            this.checked2 = [];
            this.ongoings.data.forEach(i => i.selected = false);
            const isChecked = event.target.checked;
            this.pendings.data[index].selected = isChecked;
            if (isChecked) {
                this.pendings.data[index].selected = true;
                this.checked1.push(item);
            }else{
                this.pendings.data[index].selected = false;
                this.checked1 = this.checked1.filter(i => i.id !== item.id);
            }
        },
        toggleChecked1(event, item, index) {
            this.checked1 = [];
            this.pendings.data.forEach(i => i.selected = false);
            const isChecked = event.target.checked;
            this.ongoings.data[index].selected = isChecked;
            if (isChecked) {
                this.ongoings.data[index].selected = true;
                this.checked2.push(item);
            }else{
                this.ongoings.data[index].selected = false;
                this.checked2 = this.checked2.filter(i => i.id !== item.id);
            }
        },
        filterReminder(data,status){
            if(status){
                this.name = data;
                this.filter.reminder = data.name;
                this.fetch();
            }else{
                this.name = null;
                this.refresh();
            }
        },
        refresh(){
            this.filter.reminder = null;
            this.fetch();
        },
        formatShortMonth(date) {
            return new Date(date).toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            });
        },
        loadMore(type) {
            if (!this[type].next_page_url) return;
            this.fetch(this[type].next_page_url, type);
        }
    }
}
</script>