<template>
    <Head title="Dashboard"/>
    <PageHeader title="Dashboard" pageTitle="Menu" />
    <b-row class="g-3">
        <div class="col-12 mb-3 mt-2">
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
                                        <option :value="list" v-for="list in dropdowns.laboratories" v-bind:key="list.value">{{list.name}}</option>
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
        <div class="col-md-12 mt-0">
            <div class="row g-3">
                <b-col lg="3" md="4" v-for="(item, index) of counts" :key="index">
                    <b-card no-body :class="item.color" class="border shadow-none">
                        <b-card-body>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                                        <i :class="`${item.icon} align-middle`"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">
                                        {{ item.name }}
                                    </p>
                                    <h4 class="mb-0">
                                        <span class="counter-value">{{item.total}}</span>
                                    </h4>
                                </div>
                                <div class="flex-shrink-0 align-self-end">
                                    <apexchart class="apex-charts" height="40" width="100" type="area" dir="ltr" :series="item.series" :options="chartOptions"></apexchart>
                                </div>
                            </div>
                        </b-card-body>
                    </b-card>
                </b-col>
            </div>
        </div>
        <div class="col-md-3 mt-n2">
            <div class="card shadow-none border">
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height:2.5rem;width:2.5rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-alarm-warning-fill text-primary fs-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-14"><span class="text-body">Request Monitoring & Alerts</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">Highlights urgency and updates</p>
                        </div>
                        <div class="flex-shrink-0">
                            <!-- <div class="mt-1">
                                <button @click="openView()" class="btn btn-sm btn-soft-success me-1" type="button" data-original-title="View All">
                                    <i class="ri-eye-fill align-bottom"></i>
                                </button>
                                <button class="btn btn-sm btn-soft-info" type="button" data-original-title="View PDF">
                                    <i class="ri-printer-fill align-bottom"></i>
                                </button>
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="card bg-white border-bottom shadow-none" no-body style="height: calc(100vh - 540px)">
                    <ul class="list-group list-group-flush border-dashed mb-n4 mt-n2 p-3">
                        <li class="list-group-item px-0" v-for="(list,index) in reminders" v-bind:key="index">
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
                                    <h6 class="mt-2 me-2 fs-12">{{list.count}}</h6>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
         <div class="col-md-6 mt-n2">
            <div class="card bg-light-subtle shadow-none border">
                
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height:2.5rem;width:2.5rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-trophy-fill text-primary fs-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-14"><span class="text-body">Daily Accomplishment Insights</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">A summary of tasks completed, analyses conducted, and milestones achieved within a specific reporting period</p>
                        </div>
                    </div>
                </div>
                <div class="card bg-white border-bottom shadow-none" no-body style="height: calc(100vh - 540px)">
                    <div class="table-responsive table-card">
                        
                    </div>
                </div>

            </div>
        </div>
        <div class="col-md-3 mt-n2">
            <div class="card bg-light-subtle shadow-none border">
                
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height:2.5rem;width:2.5rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-spy-fill text-primary fs-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-14"><span class="text-body">Request Status Monitoring</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">A summary of tasks completed</p>
                        </div>
                    </div>
                </div>
                <div class="card bg-white border-bottom shadow-none" no-body style="height: calc(100vh - 540px)">
                    <div class="table-responsive table-card">
                        
                    </div>
                </div>

            </div>
        </div>
        <div class="col-md-12 mt-n1">
            <div class="card bg-light-subtle shadow-none border">
                
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height:2.5rem;width:2.5rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-trophy-fill text-primary fs-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-14"><span class="text-body">Daily Accomplishment Insights</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">A summary of tasks completed, analyses conducted, and milestones achieved within a specific reporting period</p>
                        </div>
                        <div class="flex-shrink-0">
                            <!-- <input type="date" v-model="date" placeholder="Search Request" class="form-control"> -->
                        </div>
                    </div>
                </div>
                 <div class="car-body bg-white border-bottom shadow-none">
                    <b-row class="mb-2 ms-1 me-1" style="margin-top: 12px;">
                        <b-col lg>
                            <div class="input-group mb-1">
                                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                                <input type="text" v-model="filter.keyword" placeholder="Search Request" class="form-control" style="width: 40%;">
                                <input v-if="filter.type == 'Daily'" type="date" v-model="filter.date" placeholder="Search Request" class="form-control" style="width: 100px;">
                                <!-- <Multiselect class="white" style="width: 15%;" :options="dates" v-model="filter.datetype" label="name" :allow-empty="false" :searchable="true" placeholder="Filter by date" />-->
                                <Multiselect v-if="filter.type == 'Monthly'" class="white" style="width: 15%;" :options="months" v-model="filter.month" label="name" :allow-empty="false" :searchable="true" placeholder="Select Month" />
                                <Multiselect class="white" style="width: 15%;" :options="['Daily','Monthly']" v-model="filter.type" label="name" :allow-empty="false" :searchable="true" placeholder="Select Type" /> 
                                <span @click="refresh()" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;"> 
                                    <i class="bx bx-refresh search-icon"></i>
                                </span>
                                <b-button type="button" variant="primary" @click="openCreate">
                                    <i class="ri-add-circle-fill align-bottom me-1"></i> Create
                                </b-button>
                            </div>
                        </b-col>
                    </b-row>
                </div>
                <div class="card-body bg-white border-bottom">
                    <div class="table-responsive table-card">
                        <table class="table table-nowrap table-bordered align-middle mb-0">
                            <thead class="table-light thead-fixed">
                                <tr class="fs-11">
                                    <th style="width: 20%;">Laboratory</th>
                                    <th style="width: 9%;" class="text-center">No. of Requests</th>
                                    <th style="width: 9%;" class="text-center">No. of Samples</th>
                                    <th style="width: 9%;" class="text-center">No. of Analyses</th>
                                    <th style="width: 15%;" class="text-center">Actual Fees Collected</th>
                                    <th style="width: 12%;" class="text-center">Gratis</th>
                                    <th style="width: 12%;" class="text-center">Discount</th>
                                    <th style="width: 13%;" class="text-center">Gross</th>
                                </tr>
                            </thead>
                            <tbody class="fs-11">
                                <tr v-for="(list,index) in laboratories" v-bind:key="index" >
                                    <td> {{ list[0] }}</td>
                                    <td class="text-center"> {{ list[1] }}</td>
                                    <td class="text-center"> {{ list[2] }}</td>
                                    <td class="text-center"> {{ list[3] }}</td>
                                    <td class="text-center"> {{ list[4] }}</td>
                                    <td class="text-center"> {{ list[5] }}</td>
                                    <td class="text-center"> {{ list[6] }}</td>
                                    <td class="text-center"> {{ list[7] }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="table-light fs-12" v-for="(list,index) in total" v-bind:key="index" >
                                    <th> {{ list[0] }}</th>
                                    <th class="text-center"> {{ list[1] }}</th>
                                    <th class="text-center"> {{ list[2] }}</th>
                                    <th class="text-center"> {{ list[3] }}</th>
                                    <th class="text-center"> {{ list[4] }}</th>
                                    <th class="text-center"> {{ list[5] }}</th>
                                    <th class="text-center"> {{ list[6] }}</th>
                                    <th class="text-center"> {{ list[7] }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </b-row>
</template>
<script>
import Multiselect from "@vueform/multiselect";
import PageHeader from '@/Shared/Components/PageHeader.vue';
export default {
    components: { PageHeader, Multiselect },
    props: ['dropdowns','years'],
    data(){
        return {
            month: new Date().getMonth() + 1,
            monthName: new Date().toLocaleString('default', { month: 'long' }),
            config: { mode: "range"},
            chartOptions: {
                chart: { type: 'area', height: 40, sparkline: {enabled: true}},
                stroke: { curve: 'smooth', width: 2, },
                dataLabels: {  enabled: false },
                colors: ['#03114B'],
                fill: { type: 'gradient',gradient: {shadeIntensity: 1,inverseColors: false,opacityFrom: 0.45, opacityTo: 0.05,stops: [25, 100, 100, 100] }, },
                tooltip: { fixed: { enabled: false }, x: { show: true },marker: { show: false } }
            },
            activeList: null,
            months: ['January','February','March','April','May','June','July','August','September','October','November','December'],
            laboratories: [],
            total: [],
            filter: {
                keyword: null,
                type: 'Daily',
                laboratory: null,
                date: null,
                month: new Date().toLocaleString('default', { month: 'long' }),
                year: new Date().getFullYear()
            },
            counts: [],
            reminders: [],
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
    },
    created(){
        this.fetch();
        this.fetchDaily();
    },
    methods: {
        fetch(){
            axios.get('/fetch',{
                params : {
                    year: this.filter.year,
                    month: this.monthName,
                    laboratory: this.filter.laboratory,
                    option: 'cro',
                }
            })
            .then(response => {
                this.counts = response.data.counts; 
                this.reminders = response.data.reminders;         
            })
            .catch(err => console.log(err));
        },
        fetchDaily(){
            axios.get('/accomplishments',{
                params : {
                    date: this.filter.date,
                    month: this.filter.month,
                    year: this.filter.year,
                    type: this.filter.type.toLowerCase(),
                    option: 'accomplishment',
                }
            })
            .then(response => {
                this.laboratories = response.data.lists; 
                this.total = response.data.footer;         
            })
            .catch(err => console.log(err));
        },
        filterReminder(data){
            if(data == this.activeList){
                this.activeList = null;
            }else{
                this.activeList = data;
            }
            this.$refs.lists.filterReminder(data,this.activeList);
        },
        isActive(name) {
            return this.activeList === name;
        }
    }
}
</script>