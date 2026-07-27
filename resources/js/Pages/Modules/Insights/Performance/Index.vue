<template>
    <Head title="Performance Insights"/>
    <PageHeader title="Performance Insights" pageTitle="List" />
    <b-row class="g-3">

        <div class="col-md-12">
            <b-card no-body class="bg-white-subtle border shadow-none">
                <b-card-body>
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex flex-lg-row flex-column align-items-lg-center">
                                <div class="flex-grow-1">
                                    <h4 class="fs-14 mb-0">{{periodLabel}} Summary View</h4>
                                    <p class="text-muted mb-0">Here's what's happening with the laboratory for {{periodLabel}}.</p>
                                </div>
                                <div class="mt-3 mt-lg-0">
                                    <div class="input-group flex-nowrap performance-filter-bar">
                                        <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                                        <Multiselect class="white" style="width: 220px;" :options="types" v-model="laboratory" label="name" :allow-empty="false" :searchable="true" placeholder="Select Laboratory" />
                                        <Multiselect v-if="by == 'By Semester'" class="white" style="width: 170px;" :options="semesters" v-model="semester" label="name" :allow-empty="false" :searchable="true" placeholder="Select Month" />
                                        <Multiselect v-if="by == 'By Quarter'" class="white" style="width: 170px;" :options="quarters" v-model="quarter" label="name" :allow-empty="false" :searchable="true" placeholder="Select Month" />
                                        <Multiselect v-if="by == 'By Month'" class="white" style="width: 170px;" :options="months" v-model="month" label="name" :allow-empty="false" :searchable="true" placeholder="Select Month" />
                                        <Multiselect class="white" style="width: 170px;" :options="['By Month','By Quarter','By Semester']" v-model="by" label="name" :allow-empty="false" :searchable="true" placeholder="Filter By" />
                                        <Multiselect class="white" style="width: 200px;" :options="['External','Internal']" v-model="customer" label="name" :allow-empty="false" :searchable="true" placeholder="Filter Customer" />
                                        <Multiselect class="white" style="width: 150px;" :options="years" v-model="year" label="name" :searchable="true" placeholder="Select Year" />
                                        <b-button @click="refresh()" type="button" variant="primary">
                                            <i class="bx bx-refresh"></i>
                                        </b-button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </b-card-body>
            </b-card>
        </div>
    </b-row>
        
    <b-row class="g-3 mt-0" style="height: calc(100vh - 320px); overflow: auto;">
        <div class="col-md-12 mt-n2">
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
                            <h5 class="mb-0 fs-14"><span class="text-body">Accomplishment Report</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">A summary of tasks completed, analyses conducted, and milestones achieved within a specific reporting period, showcasing productivity, efficiency, and performance metrics</p>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-nowrap table-bordered align-middle mb-3">
                            <thead class="table-light thead-fixed">
                                <tr class="fs-11">
                                    <th style="width: 20%;">Laboratory</th>
                                    <th style="width: 8%;" class="text-center">No. of Requests</th>
                                    <th style="width: 8%;" class="text-center">No. of Samples</th>
                                    <th style="width: 8%;" class="text-center">No. of Analyses</th>
                                    <th style="width: 15%;" class="text-center">Actual Fees Collected</th>
                                    <th style="width: 12%;" class="text-center">Gratis</th>
                                    <th style="width: 12%;" class="text-center">Discount</th>
                                    <th style="width: 12%;" class="text-center">Gross</th>
                                    <th style="width: 4%;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(list,index) in laboratories" v-bind:key="index" >
                                    <td> {{ list[0] }}</td>
                                    <td class="text-center"> {{ list[1] }}</td>
                                    <td class="text-center"> {{ list[2] }}</td>
                                    <td class="text-center"> {{ list[3] }}</td>
                                    <td class="text-center"> {{ list[4] }}</td>
                                    <td class="text-center"> {{ list[5] }}</td>
                                    <td class="text-center"> {{ list[6] }}</td>
                                    <td class="text-center"> {{ list[7] }}</td>
                                    <td class="text-center">
                                        <b-button @click="openAccomplishmentExcel(list[8])" variant="soft-success" class="me-1" v-b-tooltip.hover title="View Excel" size="sm">
                                            <i class="ri-file-excel-fill align-bottom"></i>
                                        </b-button>
                                    </td>
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
                                    <th class="text-center"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
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
                            <h5 class="mb-0 fs-14"><span class="text-body">Top {{ samplesOldRange }} Samples (Old)</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">Showcasing our top cumulative samples recorded before sample names were tagged!</p>
                        </div>
                    </div>
                </div>
                <div class="card-body bg-white border-bottom">
                    <div class="d-flex flex-column">
                        <div class="mt-auto">
                            <div class="d-flex mb-0">
                                <div class="flex-grow-1">
                                    <div class="text-muted fs-13">
                                        <i class="ri-calendar-event-fill me-1 align-bottom"></i>{{ periodLabel }} {{ year }}
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="mb-n1 mt-n1">
                                        <button @click="openExcel('samples_old')" class="btn btn-sm btn-soft-success me-1" type="button" data-original-title="View Excel">
                                            <i class="ri-file-excel-fill align-bottom"></i>
                                        </button>
                                        <button @click="openPrint('samples_old')" class="btn btn-sm btn-soft-info" type="button" data-original-title="View PDF">
                                            <i class="ri-printer-fill align-bottom"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table align-middle table-centered table-nowrap mb-0">
                            <thead class="text-muted table-light fs-11">
                                <tr>
                                    <th width="5%;"> #</th>
                                    <th width="80%;">Name</th>
                                    <th width="15%;" class="text-center" scope="col">Count</th>
                                    <th width="10%;" class="text-center" scope="col">%</th>
                                </tr>
                            </thead>
                            <tbody class="fs-12">
                                <tr v-for="(list,index) in samplesOldPaged" v-bind:key="index">
                                    <td>{{ (pages.samplesOld - 1) * perPage + index + 1 }}</td>
                                    <td style="white-space: normal; word-break: break-word;">{{list.name }}</td>
                                    <td class="text-center">{{list.count}}</td>
                                    <td class="text-center">{{ percentage(list.count,totalSampleOld) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
                <div class="card-footer">
                    <div class="align-items-center justify-content-between d-flex">
                        <div class="flex-shrink-0">
                            <div class="text-muted fs-12">Showing <span class="fw-semibold">{{ samplesOldRange }}</span> of <span class="fw-semibold">{{ samplesOld.length }}</span> Results</div>
                        </div>
                        <ul class="pagination pagination-separated pagination-sm mb-0">
                            <li class="page-item" :class="{disabled: pages.samplesOld <= 1}"><a class="page-link" href="#/" @click.prevent="setPage('samplesOld', 1)" target="_self">first</a></li>
                            <li class="page-item" :class="{disabled: pages.samplesOld <= 1}"><a class="page-link" href="#/" @click.prevent="prevPage('samplesOld')" target="_self">←</a></li>
                            <li class="page-item" :class="{disabled: pages.samplesOld >= totalPages(samplesOld)}"><a class="page-link" href="#/" @click.prevent="nextPage('samplesOld', samplesOld)" target="_self">→</a></li>
                            <li class="page-item" :class="{disabled: pages.samplesOld >= totalPages(samplesOld)}"><a class="page-link" href="#/" @click.prevent="setPage('samplesOld', totalPages(samplesOld))" target="_self">last</a></li>
                        </ul>
                    </div>
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
                            <h5 class="mb-0 fs-14"><span class="text-body">Top {{ samplesNewRange }} Samples (New)</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">Showcasing our top cumulative samples!</p>
                        </div>
                    </div>
                </div>
                <div class="card-body bg-white border-bottom">
                    <div class="d-flex flex-column">
                        <div class="mt-auto">
                            <div class="d-flex mb-0">
                                <div class="flex-grow-1">
                                    <div class="text-muted fs-13">
                                        <i class="ri-calendar-event-fill me-1 align-bottom"></i>{{ periodLabel }} {{ year }}
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="mb-n1 mt-n1">
                                        <button @click="openExcel('samples_new')" class="btn btn-sm btn-soft-success me-1" type="button" data-original-title="View Excel">
                                            <i class="ri-file-excel-fill align-bottom"></i>
                                        </button>
                                        <button @click="openPrint('samples_new')" class="btn btn-sm btn-soft-info" type="button" data-original-title="View PDF">
                                            <i class="ri-printer-fill align-bottom"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table align-middle table-centered table-nowrap mb-0">
                            <thead class="text-muted table-light fs-11">
                                <tr>
                                    <th width="5%;"> #</th>
                                    <th width="80%;">Name</th>
                                    <th width="15%;" class="text-center" scope="col">Count</th>
                                    <th width="10%;" class="text-center" scope="col">%</th>
                                </tr>
                            </thead>
                            <tbody class="fs-12">
                                <tr v-for="(list,index) in samplesNewPaged" v-bind:key="index">
                                    <td>{{ (pages.samplesNew - 1) * perPage + index + 1 }}</td>
                                    <td style="white-space: normal; word-break: break-word;">{{list.name }}</td>
                                    <td class="text-center">{{list.count}}</td>
                                    <td class="text-center">{{ percentage(list.count,totalSampleNew) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="align-items-center justify-content-between d-flex">
                        <div class="flex-shrink-0">
                            <div class="text-muted fs-12">Showing <span class="fw-semibold">{{ samplesNewRange }}</span> of <span class="fw-semibold">{{ samplesNew.length }}</span> Results</div>
                        </div>
                        <ul class="pagination pagination-separated pagination-sm mb-0">
                            <li class="page-item" :class="{disabled: pages.samplesNew <= 1}"><a class="page-link" href="#/" @click.prevent="setPage('samplesNew', 1)" target="_self">first</a></li>
                            <li class="page-item" :class="{disabled: pages.samplesNew <= 1}"><a class="page-link" href="#/" @click.prevent="prevPage('samplesNew')" target="_self">←</a></li>
                            <li class="page-item" :class="{disabled: pages.samplesNew >= totalPages(samplesNew)}"><a class="page-link" href="#/" @click.prevent="nextPage('samplesNew', samplesNew)" target="_self">→</a></li>
                            <li class="page-item" :class="{disabled: pages.samplesNew >= totalPages(samplesNew)}"><a class="page-link" href="#/" @click.prevent="setPage('samplesNew', totalPages(samplesNew))" target="_self">last</a></li>
                        </ul>
                    </div>
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
                            <h5 class="mb-0 fs-14"><span class="text-body">Top {{ analysesRange }} Analysis</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">Showcasing our top cumulative analyses!</p>
                        </div>
                    </div>
                </div>
                <div class="card-body bg-white border-bottom">
                    <div class="d-flex flex-column">
                        <div class="mt-auto">
                            <div class="d-flex mb-0">
                                <div class="flex-grow-1">
                                    <div class="text-muted fs-13">
                                        <i class="ri-calendar-event-fill me-1 align-bottom"></i>{{ periodLabel }} {{ year }}
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="mb-n1 mt-n1">
                                        <button @click="openExcel('analyses')" class="btn btn-sm btn-soft-success me-1" type="button" data-original-title="View Excel">
                                            <i class="ri-file-excel-fill align-bottom"></i>
                                        </button>
                                        <button @click="openPrint('analyses')" class="btn btn-sm btn-soft-info" type="button" data-original-title="View PDF">
                                            <i class="ri-printer-fill align-bottom"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table align-middle table-centered table-nowrap mb-0">
                            <thead class="text-muted table-light fs-11">
                                <tr>
                                    <th width="5%;"> #</th>
                                    <th width="80%;">Name</th>
                                    <th width="15%;" class="text-center" scope="col">Count</th>
                                </tr>
                            </thead>
                            <tbody class="fs-12">
                                <tr v-for="(list,index) in analysesPaged" v-bind:key="index">
                                    <td>{{ (pages.analyses - 1) * perPage + index + 1 }}</td>
                                    <td style="white-space: normal; word-break: break-word;">{{list.name  }}</td>
                                    <td class="text-center">{{list.count}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="align-items-center justify-content-between d-flex">
                        <div class="flex-shrink-0">
                            <div class="text-muted fs-12">Showing <span class="fw-semibold">{{ analysesRange }}</span> of <span class="fw-semibold">{{ analyses.length }}</span> Results</div>
                        </div>
                        <ul class="pagination pagination-separated pagination-sm mb-0">
                            <li class="page-item" :class="{disabled: pages.analyses <= 1}"><a class="page-link" href="#/" @click.prevent="setPage('analyses', 1)" target="_self">first</a></li>
                            <li class="page-item" :class="{disabled: pages.analyses <= 1}"><a class="page-link" href="#/" @click.prevent="prevPage('analyses')" target="_self">←</a></li>
                            <li class="page-item" :class="{disabled: pages.analyses >= totalPages(analyses)}"><a class="page-link" href="#/" @click.prevent="nextPage('analyses', analyses)" target="_self">→</a></li>
                            <li class="page-item" :class="{disabled: pages.analyses >= totalPages(analyses)}"><a class="page-link" href="#/" @click.prevent="setPage('analyses', totalPages(analyses))" target="_self">last</a></li>
                        </ul>
                    </div>
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
                            <h5 class="mb-0 fs-14"><span class="text-body">Top {{ customersRange }} Customer Served</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">Showcasing our top cumulative customer served!</p>
                        </div>
                    </div>
                </div>
                <div class="card-body bg-white border-bottom">
                    <div class="d-flex flex-column">
                        <div class="mt-auto">
                            <div class="d-flex mb-0">
                                <div class="flex-grow-1">
                                    <div class="text-muted fs-13">
                                        <i class="ri-calendar-event-fill me-1 align-bottom"></i>{{ periodLabel }} {{ year }}
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="mb-n1 mt-n1">
                                        <button @click="openExcel('customers')" class="btn btn-sm btn-soft-success me-1" type="button" data-original-title="View Excel">
                                            <i class="ri-file-excel-fill align-bottom"></i>
                                        </button>
                                        <button @click="openPrint('customers')" class="btn btn-sm btn-soft-info" type="button" data-original-title="View PDF">
                                            <i class="ri-printer-fill align-bottom"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table align-middle table-centered table-nowrap mb-0">
                            <thead class="text-muted table-light fs-11">
                                <tr>
                                    <th width="5%;"> #</th>
                                    <th width="80%;">Name</th>
                                    <th width="15%;" class="text-center" scope="col">Count</th>
                                </tr>
                            </thead>
                            <tbody class="fs-12">
                                <tr v-for="(list,index) in customersPaged" v-bind:key="index">
                                    <td>{{ (pages.customers - 1) * perPage + index + 1 }}</td>
                                    <td style="white-space: normal; word-break: break-word;">{{list.customer_name.name}} {{ (list.name == 'Main') ? '' : ' - '+list.name }}</td>
                                    <td class="text-center">{{list.tsrs_count}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="align-items-center justify-content-between d-flex">
                        <div class="flex-shrink-0">
                            <div class="text-muted fs-12">Showing <span class="fw-semibold">{{ customersRange }}</span> of <span class="fw-semibold">{{ customers.length }}</span> Results</div>
                        </div>
                        <ul class="pagination pagination-separated pagination-sm mb-0">
                            <li class="page-item" :class="{disabled: pages.customers <= 1}"><a class="page-link" href="#/" @click.prevent="setPage('customers', 1)" target="_self">first</a></li>
                            <li class="page-item" :class="{disabled: pages.customers <= 1}"><a class="page-link" href="#/" @click.prevent="prevPage('customers')" target="_self">←</a></li>
                            <li class="page-item" :class="{disabled: pages.customers >= totalPages(customers)}"><a class="page-link" href="#/" @click.prevent="nextPage('customers', customers)" target="_self">→</a></li>
                            <li class="page-item" :class="{disabled: pages.customers >= totalPages(customers)}"><a class="page-link" href="#/" @click.prevent="setPage('customers', totalPages(customers))" target="_self">last</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </b-row>
   
   
</template>
<script>
import _ from 'lodash';
import Multiselect from "@vueform/multiselect";
import "@vueform/multiselect/themes/default.css";
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { PageHeader, Pagination, Multiselect },
    props:['years','types'],
    data(){
        return {
            laboratory: null,
            by: null,
            month: null,
            quarter: null,
            semester: null,
            customer: null,
            year: new Date().getFullYear(),
            months: ['January','February','March','April','May','June','July','August','September','October','November','December'],
            quarters: ['1st Quarter','2nd Quarter','3rd Quarter','4th Quarter'],
            semesters: ['1st Semester','2nd Semester'],
            laboratories: [],
            total: [],
            samplesNew: [],
            samplesOld: [],
            analyses: [],
            customers: [],
            totalSampleNew: 0,
            totalSampleOld: 0,
            perPage: 10,
            pages: {
                samplesOld: 1,
                samplesNew: 1,
                analyses: 1,
                customers: 1
            }
        }
    },
    computed: {
        periodLabel(){
            if(this.by == 'By Month' && this.month) return this.month;
            if(this.by == 'By Quarter' && this.quarter) return this.quarter;
            if(this.by == 'By Semester' && this.semester) return this.semester;
            return 'All Months';
        },
        samplesOldPaged(){ return this.paginate(this.samplesOld, this.pages.samplesOld); },
        samplesNewPaged(){ return this.paginate(this.samplesNew, this.pages.samplesNew); },
        analysesPaged(){ return this.paginate(this.analyses, this.pages.analyses); },
        customersPaged(){ return this.paginate(this.customers, this.pages.customers); },
        samplesOldRange(){ return this.range(this.samplesOld, this.pages.samplesOld); },
        samplesNewRange(){ return this.range(this.samplesNew, this.pages.samplesNew); },
        analysesRange(){ return this.range(this.analyses, this.pages.analyses); },
        customersRange(){ return this.range(this.customers, this.pages.customers); },
    },
    created(){
        this.fetch();
        this.fetchTop();
    },
    watch: {
        laboratory(){
            this.fetch();
            this.fetchTop();
        },
        by(){
            this.fetch();
            this.fetchTop();
        },
        month(){
            this.fetch();
            this.fetchTop();
        },
        quarter(){
            this.fetch();
            this.fetchTop();
        },
        semester(){
            this.fetch();
            this.fetchTop();
        },
        customer(){
            this.fetch();
            this.fetchTop();
        },
        year(){
            this.fetch();
            this.fetchTop();
        },
    },
    methods: {
        topQuery(type, option){
            const params = new URLSearchParams();
            params.set('option', option);
            params.set('type', type);
            if(this.laboratory) params.set('laboratory', this.laboratory);
            if(this.by) params.set('by', this.by);
            if(this.month) params.set('month', this.month);
            if(this.quarter) params.set('quarter', this.quarter);
            if(this.semester) params.set('semester', this.semester);
            if(this.customer) params.set('customer', this.customer);
            if(this.year) params.set('year', this.year);
            return '/insights/performance?'+params.toString();
        },
        openExcel(type){
            window.open(this.topQuery(type, 'excel'));
        },
        openPrint(type){
            window.open(this.topQuery(type, 'print'));
        },
        fetch(){
             axios.get('/insights/performance',{
                params : {
                    month: (this.by == 'By Month') ? this.month : null,
                    year: this.year,
                    laboratory: this.laboratory,
                    type: 'monthly',
                    option: 'accomplishment',
                }
            })
            .then(response => {
                this.laboratories = response.data.lists;
                this.total = response.data.footer;
            })
            .catch(err => console.log(err));
        },
         fetchTop(){
            axios.get('/insights/performance',{
                params : {
                    laboratory: this.laboratory,
                    month: this.month,
                    year: this.year,
                    semester: this.semester,
                    quarter: this.quarter,
                    by: this.by,
                    customer: this.customer,
                    option: 'top'
                }
            })
            .then(response => {
                this.samplesNew = response.data.samples_new;
                this.samplesOld = response.data.samples_old;
                this.analyses = response.data.analyses;
                this.customers = response.data.customers;
                this.totalSampleNew = response.data.total_sample_new;
                this.totalSampleOld = response.data.total_sample_old;
                this.pages = { samplesOld: 1, samplesNew: 1, analyses: 1, customers: 1 };
            })
            .catch(err => console.log(err));
        },
        percentage(data,total){
            return (_.divide(data, total)*100).toFixed(2)+'%';
        },
        paginate(list, page){
            const start = (page - 1) * this.perPage;
            return list.slice(start, start + this.perPage);
        },
        totalPages(list){
            return Math.max(1, Math.ceil(list.length / this.perPage));
        },
        range(list, page){
            if(!list.length) return '0-0';
            const start = (page - 1) * this.perPage + 1;
            const end = Math.min(page * this.perPage, list.length);
            return start+'-'+end;
        },
        prevPage(key){
            if(this.pages[key] > 1) this.pages[key]--;
        },
        nextPage(key, list){
            if(this.pages[key] < this.totalPages(list)) this.pages[key]++;
        },
        setPage(key, page){
            this.pages[key] = page;
        },
        refresh(){
            this.fetch();
            this.fetchTop();
        },
        openAccomplishmentExcel(id){
            const params = new URLSearchParams();
            params.set('option', 'excel');
            if(this.month) params.set('month', this.month);
            if(this.year) params.set('year', this.year);
            params.set('laboratory', id);
            window.open('/reports?'+params.toString());
        },
    }
}
</script>
<style scoped>
.performance-filter-bar :deep(.multiselect) {
    flex: 0 0 auto;
}
.performance-filter-bar :deep(.multiselect):not(:last-child) {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}
.performance-filter-bar :deep(.multiselect):not(:first-child) {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
    margin-left: -1px;
}
.performance-filter-bar > .btn {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
    margin-left: -1px;
}
</style>