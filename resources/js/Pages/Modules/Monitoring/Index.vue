<template>
    <Head title="Monitoring"/>
    <PageHeader title="Monitoring" pageTitle="List" />
    <BRow class="g-3">

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

        <div class="col-md-3 mt-n2">
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
                    <div v-else>
                        <p class="card-text placeholder-glow mb-1">
                            <span class="placeholder col-7"></span>
                            <span class="placeholder col-4"></span>
                            <span class="placeholder col-4"></span>
                            <span class="placeholder col-6"></span>
                        </p>
                    </div>
                </b-card-body>
            </b-card>

            <div class="card shadow-none border mt-n1">
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3 mt-1">
                            <div style="height:2rem;width:2rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-alarm-warning-fill text-primary fs-20"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 mt-0 fs-13"><span class="text-body">Request Monitoring & Alerts</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-11">Highlights urgency and updates</p>
                        </div>
                    </div>
                </div>
                <div class="card border-bottom shadow-none" no-body style="height: calc(100vh - 498px); overflow: auto;">
                    <ul class="list-group list-group-flush border-dashed mb-n4 mt-n2 p-3">
                        <li class="list-group-item px-0" v-for="(list,index) in laboratories" v-bind:key="index">
                            <div class="">
                                <div class="d-flex mb-1">
                                    <h6 class="fs-13 fw-semibold mb-0 flex-grow-1 text-truncate text-primary task-title">{{list.name}}</h6>
                                    <div class="dropdown">
                                        <a href="javascript:void(0);" class="text-muted" id="dropdownMenuLink1" data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-fill"></i></a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                                            <li><a class="dropdown-item" href="apps-tasks-details.html"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="ri-edit-2-line align-bottom me-2 text-muted"></i> Edit</a></li>
                                            <li><a class="dropdown-item" data-bs-toggle="modal" href="#deleteRecordModal"><i class="ri-delete-bin-5-line align-bottom me-2 text-muted"></i> Delete</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="d-flex mb-1">
                                        <div class="flex-grow-1">
                                            <h6 class="text-muted mb-0"><span class="text-secondary">{{list.ongoing}}</span> of {{list.overall}} </h6>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <span class="text-muted">{{list.percentage}}%</span>
                                        </div>
                                    </div>
                                    <div class="progress rounded-3 progress-sm">
                                        <div class="progress-bar bg-danger" role="progressbar" :style="{ width: list.percentage + '%' }" :aria-valuenow="list.percentage" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>


        <div class="col-md-6 mt-n2">
            <div class="row g-3">
                <template v-if="counts.length > 0">
                    <b-col lg="4" v-for="(item, index) of counts" :key="index" @click="openReminder">
                        <b-card no-body :class="item.color" class="border shadow-none">
                            <b-card-body>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                                            <i :class="`${item.icon} align-middle`"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <p class="text-uppercase text-truncate fw-semibold fs-10 text-muted mb-1">
                                            {{ item.name }}
                                        </p>
                                        <h4 class="mb-0">
                                            <span class="counter-value">{{item.count}}</span>
                                        </h4>
                                    </div>
                                    <div class="flex-shrink-0 align-self-end">
                                        <apexchart class="apex-charts" height="40" width="100" type="area" dir="ltr" :series="item.series" :options="chartOptions"></apexchart>
                                    </div>
                                </div>
                            </b-card-body>
                        </b-card>
                    </b-col>
                </template>
                <template v-else>
                    <b-col lg="4" v-for="n in 3" :key="n">
                        <b-card no-body class="border shadow-none">
                            <b-card-body>
                                <p class="card-text placeholder-glow mb-1">
                                    <span class="placeholder col-7"></span>
                                    <span class="placeholder col-4"></span>
                                    <span class="placeholder col-4"></span>
                                    <span class="placeholder col-6"></span>
                                </p>
                            </b-card-body>
                        </b-card>
                    </b-col>
                </template>
            </div>

            <div class="card shadow-none border mt-n1">
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3 mt-1">
                            <div style="height:2rem;width:2rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-alarm-warning-fill text-primary fs-20"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 mt-0 fs-13"><span class="text-body">Ongoing Technical Service Requests</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-11">Highlights urgency and updates</p>
                        </div>
                    </div>
                </div>
                <div class="cards border-bottom shadow-none" no-body>
                    <div class="card-body" style="height: calc(100vh - 535px); overflow: auto;">
                        <div class="table-responsive table-card">
                            <table class="table align-middle table-centered table-bordered table-striped mb-0">
                                <thead class="table-light thead-fixed">
                                    <tr class="fs-11">
                                        <!-- <th class="text-center" style="width: 7%;"></th> -->
                                        <th>TSR No.</th>
                                        <!-- <th style="width: 7%;" class="text-center">Progress</th> -->
                                        <th style="width: 10%;" class="text-center">Payment</th>
                                        <th style="width: 10%;" class="text-center">Analyses</th>
                                        <th style="width: 10%;" class="text-center">Report</th>
                                        <th style="width: 20%;" class="text-center">Due</th>
                                        <!-- <th style="width: 4%;"></th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="ribbon-box" v-for="(list,index) in lists" v-bind:key="index">
                                        <!-- <td class="text-center"> 
                                            <div v-if="list.is_referral" class="ribbon-two ribbon-two-primary"><span style="font-size: 8px;">Referral</span></div>
                                            {{ (meta.current_page - 1) * meta.per_page + index + 1 }}.
                                        </td> -->
                                        <td>
                                            <h5 v-if="list.code" class="fs-13 mb-0 fw-semibold text-primary">{{list.code}}</h5>
                                            <h5 v-else class="fs-13 mb-0 text-muted">Not yet available</h5>
                                            <p class="fs-12 text-muted mb-0">{{list.customer}}</p>
                                        </td>
                                        <td class="text-center">
                                            <i v-if="list.payment.is_paid" class="ri-checkbox-circle-fill text-success fs-18" v-b-tooltip.hover :title="list.payment.status.name"></i>
                                            <i v-else-if="list.payment.is_free" class="ri-checkbox-circle-fill text-info fs-18" v-b-tooltip.hover title="Gratis"></i>
                                            <i v-else-if="list.payment.status.name == 'Contract'" class="ri-information-fill text-warning fs-18" v-b-tooltip.hover title="Contract w/ MOA"></i>
                                            <i v-else class="ri-close-circle-fill text-danger fs-18" v-b-tooltip.hover :title="list.payment.status.name"></i>
                                        </td>
                                       <td class="text-center fs-12">
                                            <i v-if="list.samples.every(s => s.analyses_count === s.completed_analyses_count)" class="ri-checkbox-circle-fill text-success fs-18" v-b-tooltip.hover title="Completed"></i>
                                            <i v-else-if="list.samples.some(s => s.ongoing_analyses_count > 0 || s.completed_analyses_count > 0)" class="ri-time-fill text-info fs-18" v-b-tooltip.hover title="Ongoing"></i>
                                            <i v-else class="ri-close-circle-fill text-warning fs-18" v-b-tooltip.hover title="Pending"></i>
                                        </td>
                                        <td class="text-center fs-12">
                                            <i v-if="list.samples.every(s => s.report_exists && s.reportlist_exists)" class="ri-checkbox-circle-fill text-success fs-18" v-b-tooltip.hover title="Complete Report"></i>
                                            <i v-else-if="list.samples.some(s => s.report_exists || s.reportlist_exists)" class="ri-error-warning-fill text-warning fs-18" v-b-tooltip.hover title="Incomplete Report"></i>
                                            <i v-else class="ri-close-circle-fill text-danger fs-18" v-b-tooltip.hover title="No Report"></i>
                                        </td>
                                        <td class="text-center fs-12">
                                            {{list.due_at}}
                                        </td>
                                        <!-- <td class="text-end">
                                          
                                            <div class="d-flex gap-3 justify-content-center">
                                                <div class="dropdown">
                                                    <BDropdown variant="link" toggle-class="btn btn-light btn-sm dropdown"  strategy="fixed" no-caret menu-class="dropdown-menu-end" :offset="{ alignmentAxis: -130, crossAxis: 0, mainAxis: 10 }"> 
                                                        <template #button-content> 
                                                            <i class="ri-more-fill"></i>
                                                        </template>
                                                    </BDropdown>
                                                </div>
                                            </div>
                                        </td> -->
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <Pagination class="ms-2 me-2 mt-n1" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-3 mt-n2">
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
                    <div v-else>
                        <p class="card-text placeholder-glow mb-1">
                            <span class="placeholder col-7"></span>
                            <span class="placeholder col-4"></span>
                            <span class="placeholder col-4"></span>
                            <span class="placeholder col-6"></span>
                        </p>
                    </div>
                </b-card-body>
            </b-card>
        </div>
    </BRow>
</template>
<script>
import _ from 'lodash';
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { PageHeader, Pagination },
    props: ['dropdowns','laboratories','years'],
    data(){
        return {
            lists: [],
            meta: {},
            links: {},
            filter: {
                keyword: null,
                laboratory: null,
                month: new Date().toLocaleString('default', { month: 'long' }),
                year: new Date().getFullYear()
            },
            month: new Date().getMonth() + 1,
            counts: [],
            laboratories: [],
            index: null,
            selectedRow: null,
            months: ['January','February','March','April','May','June','July','August','September','October','November','December'],
            monthName: new Date().toLocaleString('default', { month: 'long' }),
        }
    },
    created(){
        this.fetch();
        this.fetchCounts();
    },
    watch: {
        'filter.year'(val) {
            this.fetch();
            this.fetchCounts();
        },
    },
    methods: {
        checkSearchStr: _.debounce(function(string) {
            this.fetch();
        }, 300),
        fetch(page_url){
            page_url = page_url || '/monitoring';
            axios.get(page_url,{
                params : {
                    keyword: this.filter.keyword,
                    year: this.filter.year,
                    count: 10,
                    option: 'list'
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
        fetchCounts(page_url){
            page_url = page_url || '/monitoring';
            axios.get(page_url,{
                params : {
                    keyword: this.filter.keyword,
                    year: this.filter.year,
                    count: 10,
                    option: 'counts'
                }
            })
            .then(response => {
                if(response){
                    this.laboratories = response.data.laboratories;  
                    this.counts = response.data.counts;      
                }
            })
            .catch(err => console.log(err));
        },
    }
}
</script>
