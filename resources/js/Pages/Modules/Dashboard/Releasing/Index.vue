<template>
    <Head title="Dashboard"/>
    <PageHeader title="Dashboard" pageTitle="Menu" />
    <b-row class="g-3">
        
        <div class="col-md-12">
            <b-card no-body class="bg-white-subtle border shadow-none">
                <b-card-body>
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex flex-lg-row flex-column">
                                <div class="flex-grow-1">
                                    <h4 class="fs-14 mb-0">{{monthName}} Summary View</h4>
                                    <p class="text-muted mb-0">Here's what's happening with the laboratory for month of {{monthName}}.</p>
                                </div>
                                <div class="mt-3 mt-lg-0">
                                    <form action="javascript:void(0);">
                                        <div class="row g-3 mb-0 align-items-center">
                                            <div class="col-sm-auto">
                                                <div class="input-group">
                                                    <select style="width: 250px;" v-model="filter.laboratory" class="form-select" aria-label="Default select example">
                                                        <option :value="null">All Laboratories</option>
                                                        <option :value="list.value" v-for="list in dropdowns.laboratories" v-bind:key="list.value">{{list.name}}</option>
                                                    </select>
                                                    <select style="width: 160px;" v-model="monthName" class="form-select" aria-label="Default select example">
                                                        <option :value="null">All Months</option>
                                                        <option :value="list" v-for="list in months" v-bind:key="list">{{list}}</option>
                                                    </select>
                                                    <select style="width: 100px;" v-model="filter.year" class="form-select" aria-label="Default select example">
                                                        <option :value="null">All Years</option>
                                                        <option :value="list" v-for="list in years" v-bind:key="list">{{list}}</option>
                                                    </select>
                                                    <div class="input-group-text bg-primary border-primary text-white">
                                                        <i class="ri-calendar-2-line"></i> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </b-card-body>
            </b-card>
        </div>
       
        <div class="col-md-3 mt-n1">
            <b-col lg="12">
                <b-card no-body class="bg-info-subtle border shadow-none">
                    <b-card-body>
                        <div class="d-flex align-items-center">
                            <div class="avatar-xs flex-shrink-0">
                                <span class="avatar-title bg-light text-primary rounded-circle fs-4">
                                    <i class="ri-loader-2-line align-middle`"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-uppercase text-truncate fw-semibold fs-10 text-muted mb-1">
                                Test
                                </p>
                                <h4 class="mb-0">
                                    <span class="counter-value">{{ formatMoney(0) }}</span>
                                </h4>
                            </div>
                        </div>
                    </b-card-body>
                </b-card>
            </b-col>
            <b-col lg="12" class="mt-n2">
                <div class="card shadow-none border">
                    <div class="card-header bg-light-subtle">
                        <div class="d-flex mb-n3">
                            <div class="flex-shrink-0 me-3 mt-1">
                                <div style="height:2rem;width:2rem;">
                                    <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                        <i class="ri-secure-payment-fill text-primary fs-20"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-0 mt-0 fs-13"><span class="text-body">TSR Release Summary</span></h5>
                                <p class="text-muted text-truncate-two-lines fs-11">Highlights urgency and updates</p>
                            </div>
                        </div>
                    </div>
                    <div class="shadow-none" no-body style="height: calc(100vh - 470px);">
                       
                        <ul class="list-group list-group-flush border-dashed mb-n4 p-3 mt-n2">
                            <li class="list-group-item px-0" v-for="(list,index) in releasing_summary" v-bind:key="index">
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
                                        <h6 class="mt-2 fs-12">{{list.count}}</h6>
                                    </div>
                                </div>
                            </li>
                        </ul>
                       
                    </div>
                </div>
            </b-col>
        </div>
        
        <div class="col-md-6 mt-n1">
            <div class="row g-3">
                <b-col lg="4" v-for="(item, index) of counts" :key="index" style="cursor: pointer;" @click="filterStatus(item.status)">
                    <b-card no-body :class="item.color" class="border shadow-none">
                        <b-card-body>
                            <div class="d-flex align-items-center">
                                <!-- <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                                        <i :class="`${item.icon} align-middle`"></i>
                                    </span>
                                </div> -->
                                <div class="flex-grow-1">
                                    <p class="text-uppercase text-truncate fw-semibold fs-10 text-muted mb-1">
                                        {{ item.name }}
                                    </p>
                                    <h4 class="mb-0">
                                        <span class="counter-value">{{item.total}}</span>
                                    </h4>
                                </div>
                                <div class="flex-shrink-0 align-self-end">
                                    <!-- <apexchart class="apex-charts" height="40" width="100" type="area" dir="ltr" :series="item.series" :options="chartOptions"></apexchart> -->
                                </div>
                            </div>
                        </b-card-body>
                    </b-card>
                </b-col>
                <b-col lg="12" class="mt-n2">
                    <div class="card bg-light-subtle shadow-none border">
                        <div class="card-header bg-light-subtle">
                            <div class="d-flex mb-n3">
                                <div class="flex-shrink-0 me-3 mt-1">
                                    <div style="height:2rem;width:2rem;">
                                        <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                            <i class="ri-secure-payment-fill text-primary fs-20"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-0 mt-0 fs-13"><span class="text-body">Pending TSRs for Release</span></h5>
                                    <p class="text-muted text-truncate-two-lines fs-11">Completed and approved TSRs currently awaiting release to customers.</p>
                                </div>
                            </div>
                        </div>
                        <div class="car-body bg-white border-bottom shadow-none">
                            <b-row class="mb-2 ms-1 me-1" style="margin-top: 12px;">
                                <b-col lg>
                                    <div class="input-group mb-1" style="margin-top: -3px;">
                                        <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                                        <input type="text" v-model="filter.keyword" placeholder="Search Code" class="form-control" style="width: 20%;">
                                        <Multiselect class="white" style="width: 25%;" :options="['Local','Referral']" v-model="filter.referral" label="name" :allow-empty="false" :searchable="true" placeholder="Select Type" />
                                        <b-button type="button" variant="primary" @click="openCreate">
                                            <i class="ri-add-circle-fill align-bottom me-1"></i> Create
                                        </b-button>
                                    </div>
                                </b-col>
                            </b-row>
                        </div>
                        <div class="card bg-white border-bottom shadow-none" no-body>
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <ul class="nav nav-tabs nav-tabs-custom nav-primary fs-12" role="tablist">
                                        <li class="nav-item">
                                            <BLink @click="viewMode(null,null)" class="nav-link py-3 active" data-bs-toggle="tab" role="tab" aria-selected="true">
                                            <i class="ri-apps-2-fill me-1 align-bottom"></i> All TSR's
                                            </BLink>
                                        </li>
                                        <li class="nav-item" v-for="(list,index) in dropdowns.modes" v-bind:key="index">
                                            <BLink @click="viewMode(index,list.value)" class="nav-link py-3" :class="(this.index == index) ? list.others+' active' : ''" data-bs-toggle="tab" role="tab" aria-selected="false">
                                                <i :class="icons[index]" class="me-1 align-bottom"></i>
                                                {{ list.name }} <BBadge v-if="modes[index] > 0" :class="list.color" class="align-middle ms-1">{{modes[index]}}</BBadge> 
                                            </BLink>
                                        </li>
                                    </ul>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="d-flex flex-wrap gap-2 mt-3">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body bg-white rounded-bottom">
                            <div class="table-responsive table-card" style="margin-top: -39px; height: calc(100vh - 637px)" v-if="filter.reminder != 'For Release' && filter.reminder != 'Unclaimed Reports'">
                                <table class="table align-middle table-striped table-centered mb-0">
                                    <thead class="table-light thead-fixed">
                                        <tr class="fs-11">
                                            <th style="width: 4%;"></th>
                                            <th>Customer</th>
                                            <th style="width: 20%;" class="text-center">Mode</th>
                                            <th style="width: 15%;" class="text-center">Due Date</th>
                                            <th style="width: 15%;" ></th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-white">
                                        <tr v-for="(list,index) in lists" v-bind:key="index">
                                            <td class="text-center"> 
                                                {{ (meta.current_page - 1) * meta.per_page + index + 1 }}.
                                            </td>
                                            <td>
                                                <h5 class="fs-12 mb-0 fw-semibold text-primary">{{list.code}}</h5>
                                                <p class="fs-12 text-muted mb-0">{{list.customer}}</p>
                                            </td>
                                             <td class="text-center fs-12">{{ list.mode.name }}</td>
                                            <td class="text-center fs-12"> {{ list.due_at }}
                                                <!-- <span :class="'badge '+list.status.color">{{list.status.name}}</span> -->
                                            </td>
                                            <td class="text-end" >
                                                <b-button v-if="list.status.name == 'Pending' || list.status.name == 'Mailed'" @click="openUpdate(list,index)" variant="soft-danger" v-b-tooltip.hover title="Release" size="sm">
                                                    <i class="bx bxs-hand"></i>
                                                </b-button>
                                                 <b-button v-if="list.status.name == 'Pending'" class="ms-1" @click="openMail(list,index)" variant="soft-success" v-b-tooltip.hover title="Release" size="sm">
                                                    <i class="ri-mail-fill"></i>
                                                </b-button>
                                                <span v-if="list.status.name == 'Completed'" class="badge bg-success">Released</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <Pagination class="ms-2 me-2 mt-n1" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
                        </div>
                    </div>
                </b-col>
            </div>
            
        </div>

        <div class="col-md-3 mt-n1">
            <b-col lg="12">
                <b-card no-body class="bg-success-subtle border shadow-none">
                    <b-card-body>
                        <div class="d-flex align-items-center">
                            <div class="avatar-xs flex-shrink-0">
                                <span class="avatar-title bg-light text-primary rounded-circle fs-4">
                                    <i class="ri-loader-2-line align-middle`"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-uppercase text-truncate fw-semibold fs-10 text-muted mb-1">
                               sad
                                </p>
                                <h4 class="mb-0">
                                    <span class="counter-value">2</span>
                                </h4>
                            </div>
                        </div>
                    </b-card-body>
                </b-card>
            </b-col>
            <b-col lg="12" class="mt-n2">
                <div class="card bg-light-subtle shadow-none border">
                    
                    <div class="card-header bg-light-subtle">
                        <div class="d-flex mb-n3">
                            <div class="flex-shrink-0 me-3 mt-1">
                                <div style="height:2rem;width:2rem;">
                                    <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                        <i class="ri-group-2-fill text-primary fs-24"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-0 fs-13"><span class="text-body">Release Progress by Age</span></h5>
                                <p class="text-muted text-truncate-two-lines fs-11">A summary of tasks completed</p>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-circle shadow-none" no-body style="height: calc(100vh - 470px);">
                         <ul class="list-group list-group-flush border-dashed mb-n4 p-3 mt-n2">
                            <li class="list-group-item px-0" v-for="(list,index) in releasing_age" v-bind:key="index">
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
                                        <h6 class="mt-2 fs-12">{{list.count}}</h6>
                                    </div>
                                </div>
                            </li>
                        </ul>
                       
                    </div>

                </div>
            </b-col>
        </div>
       
    </b-row>
    <Mail @update="updateData" ref="mail"/>
    <Create @success="fetch()" ref="create"/>
    <Update @update="updateData" ref="update"/>
</template>
<script>
import _ from 'lodash';
import Mail from './Modals/Mail.vue';
import Create from './Modals/Create.vue';
import Update from './Modals/Update.vue';
import flatPickr from "vue-flatpickr-component";
import Multiselect from "@vueform/multiselect";
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { PageHeader, Pagination, Multiselect, flatPickr, Create, Update, Mail },
    props: ['dropdowns','years'],
    data(){
        return {
            lists: [],
            meta: {},
            links: {},
            month: new Date().getMonth() + 1,
            monthName: null, //new Date().toLocaleString('default', { month: 'long' })
            config: { mode: "range"},
            activeList: null,
            months: ['January','February','March','April','May','June','July','August','September','October','November','December'],
            laboratories: [],
            total: [],
            filter: {
                keyword: null,
                type: 'Daily',
                laboratory: null,
                date: null,
                mode: null,
                status: 26,
                referral: null,
                month: new Date().toLocaleString('default', { month: 'long' }),
                year: new Date().getFullYear()
            },
            counts: [],
            modes: [],
            releasing_age: [],
            releasing_summary: [],
            icons: ['ri-walk-fill','ri-mail-fill','ri-indeterminate-circle-line',' ri-mail-send-fill'],
        }
    },
    watch: {
        'filter.date'(val) {
            if (this.filter.type === 'Daily') {
                this.fetchDaily();
            }
        },
        'filter.month'(val) {
            if (this.filter.type === 'Monthly') {
                this.fetchDaily();
            }
        },
        'filter.type'(val) {
            this.fetchDaily();
        },
        'monthName'(val) {
            this.fetch();
        },
        'filter.referral'(val) {
            this.fetch();
        },
        'filter.laboratory'(val) {
            this.fetch();
        },
        'filter.year'(val) {
            this.fetch();
            this.fetchDaily();
        },
        "filter.keyword"(newVal){
            this.checkSearchStr(newVal)
        },
    },
    created(){
        this.fetch();
        this.fetchDaily();
    },
    methods: {
        fetchDaily(){
            axios.get('/fetch',{
                params : {
                    year: this.filter.year,
                    month: this.monthName,
                    laboratory: this.filter.laboratory,
                    option: 'releasing',
                }
            })
            .then(response => {
                this.modes = response.data.modes;
                this.counts = response.data.counts; 
                this.releasing_age = response.data.releasing_age;
                this.releasing_summary = response.data.releasing_summary;
            })
            .catch(err => console.log(err));
        },
        checkSearchStr: _.debounce(function(string) {
            this.fetch();
        }, 300),
        fetch(page_url){
            page_url = page_url || '/releasing';
            axios.get(page_url,{
                params : {
                    keyword: this.filter.keyword,
                    year: this.filter.year,
                    mode: this.filter.mode,
                    status: this.filter.status,
                    referral: this.filter.referral,
                    count: 15, //Math.floor((window.innerHeight-500)/58)
                    laboratory: this.filter.laboratory,
                    option: 'lists'
                }
            })
            .then(response => {
                if(response){
                    this.lists = response.data.data;
                    this.meta = response.data.meta;
                    this.links = response.data.links;          
                }
            })
            .catch(err => console.log(err));
        },
        filterStatus(status){
            this.filter.status = status;
            this.fetch();
        },
        openCreate(){
            this.$refs.create.show();
        },
        openUpdate(data,index){
            this.index = index;
            this.$refs.update.show(data);
        },
        openMail(data,index){
            this.index = index;
            this.$refs.mail.show(data);
        },
        viewMode(index,status){
            this.index = index;
            this.filter.mode = status;
            this.fetch();
        },
        formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return '₱'+val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        isActive(name) {
            return this.activeList === name;
        }
    }
}
</script>