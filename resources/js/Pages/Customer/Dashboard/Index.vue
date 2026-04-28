<template>
    <PageHeader title="Dashboard" pageTitle="Customer" />
    <b-row class="g-3">
        <div class="col-md-12">
            <b-card no-body class="bg-white-subtle border shadow-none">
                <b-card-body>

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
                                Actual Fees Collected
                                </p>
                                <h4 class="mb-0">
                                    <span class="counter-value">₱3,440.00</span>
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
                                <h5 class="mb-0 mt-0 fs-13"><span class="text-body">Public</span></h5>
                                <p class="text-muted text-truncate-two-lines fs-11">Highlights urgency and updates</p>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow-none" no-body style="height: 330px;">
                        <div class="p-3 d-flex flex-wrap border-bottom">
                                <div class="avatar-sm">
                                    <div class="avatar-title bg-light rounded-circle fs-20 text-success">
                                        <i class="ri-checkbox-circle-fill"></i>
                                    </div>
                                </div>
                                <div class="ms-3 mt-1">
                                    <p class="fw-semibold fs-12 text-success mb-0">Currently Receiving Samples</p>
                                    <h5 class="mb-0 fs-11 text-muted">
                                        Please check operating hours before visiting.
                                    </h5>
                                </div>
                            </div>
                            <div class="p-3">
                                <div class="d-flex align-middle">
                                    <div class="flex-shrink-0">
                                        <img src="images/avatars/avatar.jpg" class="rounded img-fluid material-shadow" style="height: 60px;" alt="">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 lh-base fs-12"><a href="#" class="text-reset">There will be no cashier available for today. All payment transactions will resume on the next working day.</a></h6>
                                        <p class="text-muted fs-12 mb-0">April 10, 2026 <i class="mdi mdi-circle-medium align-middle mx-1"></i>09:22 AM</p>
                                    </div>
                                </div>
                                <div class="d-flex align-middle mt-3">
                                    <div class="flex-shrink-0">
                                        <img src="images/avatars/avatar.jpg" class="rounded img-fluid material-shadow" style="height: 60px;" alt="">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 lh-base fs-12"><a href="#" class="text-reset">Laboratory operations are temporarily suspended for today due to maintenance. Regular services will resume as scheduled.</a></h6>
                                        <p class="text-muted fs-12 mb-0">April 12, 2026 <i class="mdi mdi-circle-medium align-middle mx-1"></i>09:22 AM</p>
                                    </div>
                                </div>
                                <!-- <div class="d-flex align-middle mt-3">
                                    <div class="flex-shrink-0">
                                        <img src="images/avatars/avatar.jpg" class="rounded img-fluid material-shadow" style="height: 60px;" alt="">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 lh-base fs-12"><a href="#" class="text-reset">Release of laboratory results may be delayed today due to system updates. We appreciate your understanding.</a></h6>
                                        <p class="text-muted fs-12 mb-0">Dec 12, 2021 <i class="mdi mdi-circle-medium align-middle mx-1"></i>09:22 AM</p>
                                    </div>
                                </div> -->
                            </div>
                            
                       <!-- <ul class="list-group list-group-flush border-dashed mb-n4 p-3 mt-n2">
                        <li class="list-group-item px-0">
                            <div class="d-flex">
                                <div class="flex-shrink-0 avatar-xs"><span class="avatar-title bg-light p-1 rounded-circle"><i
                                            class="ri-checkbox-circle-fill fs-20 text-success"></i></span></div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-0 fs-12">Chemical Laboratory</h6>
                                    <p class="fs-11 mb-0 text-muted">Successfully collected and receipted</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex">
                                <div class="flex-shrink-0 avatar-xs"><span class="avatar-title bg-light p-1 rounded-circle"><i
                                            class="ri-close-circle-fill fs-20 text-danger"></i></span></div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-0 fs-12">Microbiology Laboratory</h6>
                                    <p class="fs-11 mb-0 text-muted">Pending payments not yet received</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex">
                               <div class="flex-shrink-0 avatar-xs"><span class="avatar-title bg-light p-1 rounded-circle"><i
                                            class="ri-checkbox-circle-fill fs-20 text-success"></i></span></div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-0 fs-12">Metrology Laboratory</h6>
                                    <p class="fs-11 mb-0 text-muted">Total monetary value of all transactions</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex">
                               <div class="flex-shrink-0 avatar-xs"><span class="avatar-title bg-light p-1 rounded-circle"><i
                                            class="ri-checkbox-circle-fill fs-20 text-success"></i></span></div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-0 fs-12">Rubber Laboratory</h6>
                                    <p class="fs-11 mb-0 text-muted">Total monetary value of all transactions</p>
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
                                <div class="avatar-xs flex-shrink-0">
                                    <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                                        <i :class="`${item.icon} ${item.color} align-middle`"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
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
                                <h5 class="mb-0 mt-0 fs-13"><span class="text-body">Technical Service Request</span></h5>
                                <p class="text-muted text-truncate-two-lines fs-11">Highlights urgency and updates</p>
                            </div>
                        </div>
                    </div>
                    <div class="car-body border-bottom shadow-none">
                    <b-row class="mb-2 ms-1 me-1" style="margin-top: 12px;">
                        <b-col lg>
                            <div class="input-group mb-1">
                                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                                <input type="text" placeholder="Search Request" class="form-control" style="width: 40%;">
                                <!-- <input v-if="filter.type == 'Daily'" type="date" v-model="filter.date" placeholder="Search Request" class="form-control" style="width: 100px;">
                               
                                <Multiselect v-if="filter.type == 'Monthly'" class="white" style="width: 15%;" :options="months" v-model="filter.month" label="name" :allow-empty="false" :searchable="true" placeholder="Select Month" />
                                <Multiselect class="white" style="width: 15%;" :options="['Daily','Monthly']" v-model="filter.type" label="name" :allow-empty="false" :searchable="true" placeholder="Select Type" /> 
                                <span @click="refresh()" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;"> 
                                    <i class="bx bx-refresh search-icon"></i>
                                </span> -->
                                <b-button type="button" variant="primary" @click="openCreate">
                                    <i class="ri-add-circle-fill align-bottom me-1"></i> Create
                                </b-button>
                            </div>
                        </b-col>
                    </b-row>
                </div>
                <div class="card-body border-bottom">
                    <div class="table-responsive table-card" style="height: calc(100vh - 543px); overflow: auto;">
                        <table class="table table-nowrap table-bordered table-bordered align-middle mb-0">
                            <thead class="table-light thead-fixed">
                                <tr class="fs-10">
                                    <th>Code</th>
                                    <th style="width: 15%;" class="text-center">Samples</th>
                                    <th style="width: 15%;" class="text-center">Analysis</th>
                                    <th style="width: 15%;" class="text-center">Reports</th>
                                    <th style="width: 20%;" class="text-center">Status</th>
                                </tr>
                            </thead>
                             <tbody class="fs-10">
                                <tr v-for="(list,index) in tsrs" v-bind:key="index" >
                                    <td> {{ list.code }}</td>
                                    <td class="text-center"> {{ list.samples.length }}</td>
                                    <td class="text-center">
                                             <i 
                                                v-if="list.samples.every(sample => 
                                                sample.analyses && sample.analyses.length > 0 &&
                                                sample.analyses.every(a => a.status_id === 12)
                                                )"
                                                class="text-success ri-checkbox-circle-fill fs-16"
                                            ></i>
                                            <i 
                                                v-else
                                                class="text-danger ri-close-circle-fill fs-16"
                                            ></i>
                                    </td>
                                    <td class="text-center">
                                          <i 
                                                  v-if="list.samples.every(sample => 
      sample.report &&
      sample.report.signatory &&
      sample.report.signatory.status_id === 42
    )"
                                                class="text-success ri-checkbox-circle-fill fs-16"
                                            ></i>

                                            <i 
                                                v-else
                                                class="text-danger ri-close-circle-fill fs-16"
                                            ></i>
                                    </td>
                                    <td class="text-center"> 
                                        <span :class="'badge '+list.status.color">{{list.status.name}}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>
            </b-col>
            </div>
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
                                No. of Requests
                                </p>
                                <h4 class="mb-0">
                                    <span class="counter-value">4</span>
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
                                        <i class="ri-hand-coin-fill text-primary fs-20"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-0 mt-0 fs-13"><span class="text-body">For Pick-up</span></h5>
                                <p class="text-muted text-truncate-two-lines fs-11">Highlights urgency and updates</p>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow-none" no-body style="height: calc(100vh - 724px);">
                         <ul class="list-group list-group-flush border-dashed mb-n4 p-3 mt-n2">
                            <li class="list-group-item px-0" v-for="(list,index) in pickups" v-bind:key="index">
                                <div class="d-flex">
                                    <!-- <div class="flex-shrink-0 avatar-xs">
                                        <span class="avatar-title bg-light p-1 rounded-circle">
                                            <i :class="list.icon+' '+list.color"></i>
                                        </span>
                                    </div> -->
                                    <div class="flex-grow-1 ms-2">
                                        <h6 class="mb-0 fw-semibold text-primary fs-12">{{list.code}}</h6>
                                        <p class="fs-11 mb-0 text-muted">{{list.due_at}}</p>
                                    </div>
                                    <div class="flex-shrink-0 text-end">
                                        <h6 class="mt-2 fs-12">
                                             <span class="badge bg-success">Available</span>
                                        </h6>
                                    </div>
                                </div>
                            </li>
                        </ul>
                       
                    </div>
                </div>
            </b-col>
            <b-col lg="12" class="mt-n2">
                <div class="card shadow-none border">
                    <div class="card-header bg-light-subtle">
                        <div class="d-flex mb-n3">
                            <div class="flex-shrink-0 me-3 mt-1">
                                <div style="height:2rem;width:2rem;">
                                    <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                        <i class="ri-calendar-fill text-primary fs-20"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-0 mt-0 fs-13"><span class="text-body">Schedules</span></h5>
                                <p class="text-muted text-truncate-two-lines fs-11">Highlights urgency and updates</p>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow-none" no-body style="height: calc(100vh - 724px);">
                        <div class="card-body">
                        <ul class="list-group list-group-flush border-dashed mt-n2">
                                <li class="list-group-item ps-0" v-for="(list,index) in schedules" v-bind:key="index">
                                    <div class="row align-items-center g-3">
                                        <div class="col-auto">
                                            <div class="avatar-sm p-1 py-2 h-auto rounded-3 material-shadow" :class="list.event.bg">
                                                <div class="text-center" >
                                                    <h5 class="mb-0 fs-12" :class="list.event.color">{{ list.day }}</h5>
                                                    <div class="fs-10" :class="list.event.color">{{ list.day_name }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <h5 class=" fw-normal mt-0 mb-0 fs-11">{{list.event.name}}</h5>
                                            <p class="text-primary text-truncate fw-semibold fs-12 mb-0">{{list.start_date}}</p>
                                            <h5 class="text-muted fw-normal mt-0 mb-0 fs-11">{{list.event.type}}</h5>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div v-if="schedules.list?.length == 0">
                                <div class="alert alert-warning alert-dismissible alert-label-icon label-arrow fade show material-shadow fs-12 mt-2" role="alert">
                                    <i class="ri-alert-line label-icon"></i>No upcoming schedules for this week
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </b-col>
        </div>

    </b-row>
</template>
<script>
import PageHeader from '@/Shared/Components/PageHeader.vue';
export default {
    components: { PageHeader },
    data() {
        return {
            filter: {
                keyword: null,
                type: 'Daily',
                laboratory: null,
                date: null,
                month: new Date().toLocaleString('default', { month: 'long' }),
                year: new Date().getFullYear()
            },
            counts: [],
            schedules: [],
            pickups: [],
            tsrs: []
        }
    },
    created(){
        this.fetch();
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
                this.counts = response.data.counts;
                this.schedules = response.data.schedules; 
                this.pickups = response.data.pickups;
                this.tsrs = response.data.tsrs;
            })
            .catch(err => console.log(err));
        },
    },
}
</script>