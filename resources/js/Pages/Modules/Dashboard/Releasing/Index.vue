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
                    </div>
                </b-card-body>
            </b-card>
        </div>
       
        <div class="col-md-3 mt-n1">
            <b-col lg="12">
                <b-card no-body class="bg-info-subtle border shadow-none">
                    <b-card-body>
                        <div class="d-flex align-items-center" v-if="fee">
                            <div class="avatar-xs flex-shrink-0">
                                <span class="avatar-title bg-light text-primary rounded-circle fs-4">
                                    <i class="ri-loader-2-line align-middle`"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-uppercase text-truncate fw-semibold fs-10 text-muted mb-1">
                                {{ fee.name }}
                                </p>
                                <h4 class="mb-0">
                                    <span class="counter-value">{{ formatMoney(fee.total) }}</span>
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
                                <h5 class="mb-0 mt-0 fs-13"><span class="text-body">Collection Summary</span></h5>
                                <p class="text-muted text-truncate-two-lines fs-11">Highlights urgency and updates</p>
                            </div>
                        </div>
                    </div>
                    <div class="card border-bottom shadow-none" no-body style="height: 330px;">
                       
                        <ul class="list-group list-group-flush border-dashed mb-n4 p-3 mt-n2">
                            <li class="list-group-item px-0" v-for="(list,index) in collection" v-bind:key="index">
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
                                        <h6 class="mt-2 fs-12">{{formatMoney(list.total)}}</h6>
                                        <!-- <p class="text-success fs-12 mb-0">$19,405.12</p> -->
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <hr class="text-muted"/>
                        <ul class="list-group list-group-flush border-dashed mb-0 mt-n4 p-3">
                            <li class="list-group-item px-0" v-for="(list,index) in collection_summary" v-bind:key="index">
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
                                        <h6 class="mb-1 fs-12">{{formatMoney(list.total)}}</h6>
                                        <!-- <p class="text-success fs-12 mb-0">$19,405.12</p> -->
                                    </div>
                                </div>
                            </li>
                        </ul>
                       
                        <!-- <ul class="list-group list-group-flush border-dashed mb-n4 mt-n2 p-3">
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
                        </ul> -->
                    </div>
                </div>
            </b-col>
        </div>
        
        <div class="col-md-6 mt-n1">
            <div class="row g-3">
                <b-col lg="4" v-for="(item, index) of counts" :key="index">
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
                                    <apexchart class="apex-charts" height="40" width="100" type="area" dir="ltr" :series="item.series" :options="chartOptions"></apexchart>
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
                                            <i class="ri-trophy-fill text-primary fs-20"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-0 fs-13"><span class="text-body">Daily Accomplishment Insights</span></h5>
                                    <p class="text-muted text-truncate-two-lines fs-11">A summary of tasks completed, analyses conducted, and milestones achieved within a specific reporting period</p>
                                </div>
                            </div>
                        </div>
                        <div class="card border-bottom shadow-none" no-body style="height: 330px;">
                            <apexchart ref="realtimeChart" class="apex-charts" type="area" style="padding: 20px;" dir="ltr" :series="series"
                                :options="chartOptions1">
                            </apexchart>
                        </div>
                    </div>
                </b-col>
            </div>
            
        </div>

        <div class="col-md-3 mt-n1">
            <b-col lg="12">
                <b-card no-body class="bg-success-subtle border shadow-none">
                    <b-card-body>
                        <div class="d-flex align-items-center" v-if="target">
                            <div class="avatar-xs flex-shrink-0">
                                <span class="avatar-title bg-light text-primary rounded-circle fs-4">
                                    <i class="ri-loader-2-line align-middle`"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-uppercase text-truncate fw-semibold fs-10 text-muted mb-1">
                                {{ target.name }}
                                </p>
                                <h4 class="mb-0">
                                    <span class="counter-value">{{ target.percentage }}</span>
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
                                <h5 class="mb-0 fs-13"><span class="text-body">Customer Summary</span></h5>
                                <p class="text-muted text-truncate-two-lines fs-11">A summary of tasks completed</p>
                            </div>
                        </div>
                    </div>
                    <div class="card border-bottom shadow-none" no-body style="height: 330px;">
                    <!-- <ul class="list-group list-group-flush border-dashed mb-n4 mt-n2 p-3">
                            <li class="list-group-item px-0" v-for="(list,index) in statuses" v-bind:key="index">
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
                        </ul> -->
                         <ul class="list-group list-group-flush border-dashed mb-n4 p-3 mt-n2">
                            <li class="list-group-item px-0" v-for="(list,index) in customer" v-bind:key="index">
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
                                        <h6 class="mt-2 fs-12">{{list.total}}</h6>
                                        <!-- <p class="text-success fs-12 mb-0">$19,405.12</p> -->
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <hr class="text-muted"/>
                        <ul class="list-group list-group-flush border-dashed mb-0 mt-n4 p-3">
                            <li class="list-group-item px-0" v-for="(list,index) in customer_summary" v-bind:key="index">
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
                                        <h6 class="mb-1 fs-12">{{list.total}}</h6>
                                        <!-- <p class="text-success fs-12 mb-0">$19,405.12</p> -->
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                </div>
            </b-col>
        </div>

      
        
       
    </b-row>
</template>
<script>
import flatPickr from "vue-flatpickr-component";
import Multiselect from "@vueform/multiselect";
import PageHeader from '@/Shared/Components/PageHeader.vue';
export default {
    components: { PageHeader, Multiselect, flatPickr },
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
            series: [],
            chartOptions1: {
                chart: {height: 300,toolbar: {show: false,},},
                // stroke: {curve: "straight", dashArray: [0, 0, 8],width: [2, 0, 2.2]},
                // fill: {opacity: [0.1, 0.9, 1]},
                markers: {
                    size: [0, 0, 0],
                    strokeWidth: 2,
                    hover: { size: 4},
                },
                xaxis: {
                    categories: [],
                    axisTicks: {show: false},
                    axisBorder: {show: false},
                },
                grid: {
                    show: true,
                    xaxis: {lines: {show: true}},
                    yaxis: {lines: { show: false}},
                    padding: { top: 0,right: -2,bottom: 15,left: 10,},
                },
                legend: {
                    show: true,
                    horizontalAlign: "center",
                    offsetX: 0,
                    offsetY: -5,
                    markers: {width: 9,height: 9,radius: 6},
                    itemMargin: { horizontal: 10, vertical: 0},
                },
                 dataLabels: {
                    enabled: false, 
                },
                plotOptions: {
                bar: {
                    columnWidth: "50%",
                    barHeight: "70%",
                },
                },
                colors: ["#34c38f", "#ea6868", "#f1b44c", "#f1b44c", "#a20cce", " #713d3d"],
                // tooltip: {
                //     y: {
                //         formatter: function (val) {
                //             return "₱" + val.toLocaleString(); 
                //         }
                //     }
                // },
                // yaxis: {
                //     labels: {
                //         formatter: function (val) {
                //             // Format y-axis labels as currency (e.g., $1,000)
                //             return "₱" + val.toLocaleString();
                //         }
                //     }
                // }
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
            statuses: [],
            schedules: [],
            personnels: [],
            equipments: [],
            inventory: [],
            collection: [],
            collection_summary: [],
            customer: [],
            customer_summary: [],
            fee: null,
            target: null
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
                    option: 'labhead',
                }
            })
            .then(response => {
                this.fee = response.data.fee;
                this.target = response.data.target;
                this.counts = response.data.counts; 
                this.reminders = response.data.reminders; 
                this.statuses = response.data.statuses;   
                this.schedules = response.data.schedules; 
                this.personnels = response.data.personnels;
                this.equipments = response.data.equipments;
                this.inventory = response.data.inventory;
                this.collection = response.data.collection;
                this.collection_summary = response.data.collection_summary;
                this.customer = response.data.customer;
                this.customer_summary =response.data.customer_summary;
                this.chartOptions1 = {
                    ...this.chartOptions1,
                    ...{
                        xaxis: {
                            categories: response.data.charts.categories
                        }
                    }
                };
                this.series = response.data.charts.lists;     
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