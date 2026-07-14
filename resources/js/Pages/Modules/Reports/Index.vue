<template>
    <Head title="Reports"/>
    <PageHeader title="Reports" pageTitle="List" />
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

        <b-col lg="6"  class="mt-n2">
            <b-card no-body class="border shadow-none bg-light-subtle" style="cursor: pointer;" @click="openExcel('reconciliation')">
                <b-card-body>
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height: 2.5rem; width: 2.5rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-file-text-fill text-primary fs-20"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-14"><span class="text-body">Reconciliation of RSTL and Finance</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">Identifying and resolving discrepancies</p>
                        </div>
                        <div class="flex-shrink-0 text-end mt-1">
                            <i class="ri-download-cloud-fill fs-18 text-warning"></i>
                        </div>
                    </div>
                </b-card-body>
            </b-card>
        </b-col>
        <b-col lg="6" class="mt-n2">
            <b-card no-body class="border shadow-none bg-light-subtle" style="cursor: pointer;"  @click="openExcel('opandor')">
                <b-card-body>
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height: 2.5rem; width: 2.5rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-newspaper-fill text-primary fs-20"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-14"><span class="text-body">List of OP and OR</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">Data Combined from OP and OR</p>
                        </div>
                        <div class="flex-shrink-0 text-end mt-1">
                            <i class="ri-download-cloud-fill fs-18 text-primary"></i>
                        </div>
                    </div>
                </b-card-body>
            </b-card>
        </b-col>

        <div class="col-md-3 mt-2">
            <Link :href="`/insights/location`" >
                <div class="card overflow-hidden shadow-none mt-n3" style="cursor: pointer;">
                    <div class="card-body bg-warning-subtle">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <div class="avatar-title bg-warning bg-opacity-10 text-warning rounded-circle fs-17">
                                        <i class="ri-group-2-fill fs-24"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="fs-12 text-warning mb-1">Customer Classification Summary</h6>
                                <p class="fs-11 text-muted mb-0">Shows customer breakdown and classification for monitoring and reporting purposes.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </Link>
        </div>
        <div class="col-md-3 mt-2">
            <Link :href="`/insights/discounts`" target="_blank">
                <div class="card overflow-hidden shadow-none mt-n3" style="cursor: pointer;">
                    <div class="card-body bg-secondary-subtle">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <div class="avatar-title bg-purple bg-opacity-10 text-purple rounded-circle fs-17">
                                        <i class="ri-hand-coin-fill fs-24"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="fs-12 text-purple mb-1">Customer Financial Summary</h6>
                                <p class="fs-11 text-muted mb-0">Shows TSR financial details including services, payments, gratis, and discount classifications.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </Link>
        </div>
        <div class="col-md-3 mt-2">
            <Link :href="`/insights/discount`" target="_blank">
                <div class="card overflow-hidden shadow-none mt-n3" style="cursor: pointer;">
                    <div class="card-body bg-danger-subtle">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <div class="avatar-title bg-danger bg-opacity-10 text-danger rounded-circle fs-17">
                                        <i class="ri-gift-line fs-24"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="fs-12 text-danger mb-1">Customer Discount Summary</h6>
                                <p class="fs-11 text-muted mb-0">Shows TSR transactions with applied discounts and gross amount for monitoring and reporting.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </Link>
        </div>
            <div class="col-md-3 mt-2">
            <Link :href="`/accomplishments`" target="_blank">
                <div class="card overflow-hidden shadow-none mt-n3" style="cursor: pointer;">
                    <div class="card-body bg-success-subtle">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <div class="avatar-title bg-success bg-opacity-10 text-success rounded-circle fs-17">
                                        <i class="ri-checkbox-circle-fill fs-24"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="fs-12 text-success mb-1">Annual Target vs Accomplishment Report</h6>
                                <p class="fs-11 text-muted mb-0">Shows yearly target and actual accomplishment data for evaluation and reporting.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </Link>
        </div>
        

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
        

    </b-row>
   
    <!-- <b-row class="g-2 mb-2 mt-n2">
        <b-col lg>
            <div class="input-group mb-1">
                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                <input type="text" placeholder="Search Request" class="form-control" style="width: 40%;">
                <Multiselect class="white" style="width: 15%;" :options="types" v-model="laboratory" label="name" :allow-empty="false" :searchable="true" placeholder="Select Laboratory" />
                <Multiselect class="white" style="width: 15%;" :options="months" v-model="month" label="name" :allow-empty="false" :searchable="true" placeholder="Select Month" />
                <Multiselect class="white" style="width: 15%;" :options="years" v-model="year" label="name" :searchable="true" placeholder="Select Year" />
               
                <b-button @click="openReport()" type="button" variant="primary">
                    Reports
                </b-button>
            </div>
        </b-col>
    </b-row>
    <hr class="text-muted"/>
    <div class="row">
        <div class="col-md-3">
            <div class="card bg-light-subtle shadow-none border">
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height: 2.5rem; width: 2.5rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="bx bxs-calendar-week text-primary fs-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-14"><span class="text-body">List of TSR's, Samples and Analyses</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">Extract all TSR data
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-body bg-white">
                    <div class="d-flex flex-column">
                        <div class="mt-auto">
                            <div class="d-flex mb-0">
                                <div class="flex-grow-1">
                                    <div class="text-muted fs-13"><i class="ri-calendar-event-fill me-1 align-bottom"></i>{{month}} {{year}}</div>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="mb-n1 mt-n1">
                                        <b-button @click="openExcel('tsr')" variant="soft-success" class="me-1" v-b-tooltip.hover title="View Excel" size="sm">
                                            <i class="ri-file-excel-fill align-bottom"></i>
                                        </b-button>
                                        <b-button @click="openView('tsr')" variant="soft-info" v-b-tooltip.hover title="View PDF" size="sm">
                                            <i class="ri-printer-fill align-bottom"></i>
                                        </b-button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light-subtle shadow-none border">
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height: 2.5rem; width: 2.5rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="bx bxs-calendar-week text-primary fs-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-14"><span class="text-body">List of OP and OR</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">Data Combined from OP and OR
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-body bg-white">
                    <div class="d-flex flex-column">
                        <div class="mt-auto">
                            <div class="d-flex mb-0">
                                <div class="flex-grow-1">
                                    <div class="text-muted fs-13"><i class="ri-calendar-event-fill me-1 align-bottom"></i>{{info.month}} {{info.year}}</div>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="mb-n1 mt-n1">
                                         <b-button @click="openExcel('paymenttype')" variant="soft-success" class="me-1" v-b-tooltip.hover title="Payment Type" size="sm">
                                            <i class="ri-file-excel-fill align-bottom"></i>
                                        </b-button>
                                        <b-button @click="openExcel('op')" variant="soft-success" class="me-1" v-b-tooltip.hover title="View Excel" size="sm">
                                            <i class="ri-file-excel-fill align-bottom"></i>
                                        </b-button>
                                        <b-button @click="openView('op')" variant="soft-info" v-b-tooltip.hover title="View PDF" size="sm">
                                            <i class="ri-printer-fill align-bottom"></i>
                                        </b-button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-light-subtle shadow-none border">
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height: 2.5rem; width: 2.5rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="bx bxs-calendar-week text-primary fs-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-14"><span class="text-body">RSTL Data</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">A document confirming payment received
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-body bg-white">
                    <div class="d-flex flex-column">
                        <div class="mt-auto">
                            <div class="d-flex mb-0">
                                <div class="flex-grow-1">
                                    <div class="text-muted fs-13"><i class="ri-calendar-event-fill me-1 align-bottom"></i>{{month}} {{year}}</div>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="mb-n1 mt-n1">
                                        <b-button @click="openExcel('womens')" variant="soft-success" class="me-1" v-b-tooltip.hover title="View Women's" size="sm">
                                            <i class="ri-file-excel-fill align-bottom"></i>
                                        </b-button>
                                        <b-button @click="openExcel('rstl')" variant="soft-success" class="me-1" v-b-tooltip.hover title="View Excel" size="sm">
                                            <i class="ri-file-excel-fill align-bottom"></i>
                                        </b-button>
                                        <b-button @click="openView('rstl')" variant="soft-info" v-b-tooltip.hover title="View PDF" size="sm">
                                            <i class="ri-printer-fill align-bottom"></i>
                                        </b-button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-light-subtle shadow-none border">
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height: 2.5rem; width: 2.5rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="bx bxs-calendar-week text-primary fs-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-14"><span class="text-body">Reconciliation of RSTL and Finance</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">Identifying and resolving discrepancies
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-body bg-white">
                    <div class="d-flex flex-column">
                        <div class="mt-auto">
                            <div class="d-flex mb-0">
                                <div class="flex-grow-1">
                                    <div class="text-muted fs-13"><i class="ri-calendar-event-fill me-1 align-bottom"></i>{{month}} {{year}}</div>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="mb-n1 mt-n1">
                                        <b-button @click="openExcel('recon')" variant="soft-success" class="me-1" v-b-tooltip.hover title="View Excel" size="sm">
                                            <i class="ri-file-excel-fill align-bottom"></i>
                                        </b-button>
                                        <b-button @click="openView('recon')" variant="soft-info" v-b-tooltip.hover title="View PDF" size="sm">
                                            <i class="ri-printer-fill align-bottom"></i>
                                        </b-button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 mt-n4">
            <hr class="text-muted"/>
        </div>

        <div class="col-md-12">
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
                <div class="card-body bg-white border-bottom">
                    <div class="d-flex flex-column">
                        <div class="mt-auto">
                            <div class="d-flex mb-0">
                                <div class="flex-grow-1">
                                    <div class="text-muted fs-13">
                                        <i class="ri-calendar-event-fill me-1 align-bottom"></i>{{ month }} {{ year }}
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="mb-n1 mt-n1">
                                        <button @click="openTop('samples')" class="btn btn-sm btn-soft-success me-1" type="button" data-original-title="View Excel">
                                            <i class="ri-file-list-2-fill align-bottom"></i> Samples
                                        </button>
                                        <a href="/accomplishments?option=customer" target="_blank">
                                            <button class="btn btn-sm btn-soft-info me-1" type="button" data-original-title="View Excel">
                                                <i class="ri-file-list-2-fill align-bottom"></i> Customer Address
                                            </button>
                                        </a>
                                        <a href="/accomplishments?option=customer2" target="_blank">
                                        <button class="btn btn-sm btn-soft-danger me-1" type="button" data-original-title="View Excel">
                                            <i class="ri-file-list-2-fill align-bottom"></i> Customer Discount
                                        </button>
                                        </a>
                                         <a href="/accomplishments?option=customer3" target="_blank">
                                        <button class="btn btn-sm btn-soft-warning me-1" type="button" data-original-title="View Excel">
                                            <i class="ri-file-list-2-fill align-bottom"></i> Discounts
                                        </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
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
                                        <b-button @click="openAccomplishmentView(list[8])" variant="soft-info" v-b-tooltip.hover title="View PDF" size="sm">
                                            <i class="ri-printer-fill align-bottom"></i>
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

        

    </div> -->
</template>
<script>
import _ from 'lodash';
import Multiselect from "@vueform/multiselect";
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { PageHeader, Pagination, Multiselect },
    props:['years'],
    data(){
        return {
            monthName: new Date().toLocaleString('default', { month: 'long' }),
            filter: {
                keyword: null,
                type: 'Monthly',
                laboratory: null,
                date: null,
                month: new Date().toLocaleString('default', { month: 'long' }),
                year: new Date().getFullYear()
            },
            months: ['January','February','March','April','May','June','July','August','September','October','November','December'],
            laboratories: [],
            total: []
        }
    },
    created(){
        this.fetch();
    },
    watch: {
        'filter.month'(val) {
            if (this.filter.type === 'Monthly') {
                this.fetch();
            }
        },
        'filter.type'(val) {
            this.fetch();
        },
        'monthName'(val) {
            this.fetch();
        },
    },
    methods: {
        fetch(){
             axios.get('/accomplishments',{
                params : {
                    month: this.monthName,
                    year: this.filter.year,
                    laboratory: this.filter.laboratory,
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
        openAccomplishmentExcel(id){
            window.open('/reports?option=excel&month='+this.monthName+'&year='+this.filter.year+'&laboratory='+id);
        },
        openExcel(type) {
            const params = new URLSearchParams();

            params.append('type', type);
            if (this.monthName) {
                params.append('month', this.monthName);
            }
            if (this.filter.year) {
                params.append('year', this.filter.year);
            }
            if (this.laboratory) {
                params.append('laboratory', this.laboratory);
            }
            window.open('/reports/excel?' + params.toString());
        },
    }
}
</script>