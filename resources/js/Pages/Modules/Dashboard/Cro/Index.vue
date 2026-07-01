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


        <div class="col-md-12 mt-n2" style="height: calc(100vh - 310px); overflow-y: auto; overflow-x: hidden;">
            <div class="row g-3">


                <div class="col-md-3">
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

                <div class="col-md-6">
                    <div class="row g-3">
                        <template v-if="counts.length > 0">
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
                </div>

                <div class="col-md-3">
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



                <div class="col-md-3 mt-n2">
                    <div class="card shadow-none border">
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
                        <div class="card border-bottom shadow-none" no-body style="height: 340px;">
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
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mt-n2">
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
                        <div class="card border-bottom shadow-none" no-body style="height: 340px;">
                            <apexchart  ref="realtimeChart" class="apex-charts" type="area" style="padding: 20px;" dir="ltr" :series="series"
                                :options="chartOptions1">
                            </apexchart> 
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mt-n2">
                    <div class="card bg-light-subtle shadow-none border">
                        <div class="card-header bg-light-subtle">
                            <div class="d-flex mb-n3">
                                <div class="flex-shrink-0 me-3 mt-1">
                                    <div style="height:2rem;width:2rem;">
                                        <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                            <i class="ri-spy-fill text-primary fs-24"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-0 fs-13"><span class="text-body">Request Status Monitoring</span></h5>
                                    <p class="text-muted text-truncate-two-lines fs-11">A summary of tasks completed</p>
                                </div>
                            </div>
                        </div>
                        <div class="card border-bottom shadow-none" no-body style="height: 340px;">
                            <ul class="list-group list-group-flush border-dashed mb-n4 mt-n2 p-3">
                                <li class="list-group-item px-0" v-for="(list,index) in statuses" v-bind:key="index">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-2">
                                            <span class="avatar-title bg-light rounded-circle"
                                                style="width:32px;height:32px;">
                                                <i :class="list.icon + ' ' + list.color"></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <h6 class="mb-0 fs-12">{{list.name}} </h6>
                                            
                                            <div class="mt-auto">
                                                <div class="d-flex mb-1">
                                                    <div class="flex-grow-1">
                                                        <p class="fs-11 mb-0 text-muted">{{ list.description }}</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <div class="fs-12">
                                                            <i class="ri-list-check align-bottom me-1 text-muted"></i>
                                                            {{ list.count }}/{{ list.year_count }} <span class="text-muted">({{ list.percentage }}%)</span>
                                                            <!-- ({{ list.percentage }}%) -->
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="progress progress-sm animated-progress">
                                                    <div
                                                        class="progress-bar"
                                                        :class="list.color.replace('text-', 'bg-')"
                                                        role="progressbar"
                                                        :aria-valuenow="list.percentage"
                                                        aria-valuemin="0"
                                                        aria-valuemax="100"
                                                        :style="{ width: list.percentage + '%' }"
                                                    ></div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="flex-shrink-0 text-end">
                                            <h6 v-if="monthName" class="mt-0 mb-n2 me-2 fs-12">
                                                <div class="donut-chart mx-auto" :style="{background: `conic-gradient(#0ab39c ${list.percentage}%, #e9ebec 0)`}">
                                                    <div class="donut-inner">
                                                        {{ list.percentage }}%
                                                    </div>
                                                </div>
                                            </h6>
                                            <h6 v-else class="mt-2 me-2 fs-12">{{list.count}}</h6>
                                        </div> -->
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

               
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
                    <Link :href="`/accomplishments`" >
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
                



                <div class="col-md-3 mt-n1">
                    <div class="card bg-light-subtle shadow-none border">
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
                                    <h5 class="mb-0 fs-13"><span class="text-body">Upcoming Schedules</span></h5>
                                    <p class="text-muted text-truncate-two-lines fs-11">Schedules only within the week.</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <!-- <input type="date" v-model="date" placeholder="Search Request" class="form-control"> -->
                                </div>
                            </div>
                        </div>
                        <div class="card-header p-0 border-0 bg-light-subtle">
                            <div class="row g-0 text-center">
                                <div class="col-6 col-sm-4">
                                    <div class="p-3 border border-dashed border-start-0">
                                        <h5 class="mb-1 fs-12">{{schedules.calibration}}</h5>
                                        <p class="text-muted mb-0 fs-12">Calibration</p>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-4">
                                    <div class="p-3 border border-dashed border-start-0">
                                        <h5 class="mb-1 fs-12">{{schedules.testing}}</h5>
                                        <p class="text-muted mb-0 fs-12">Testing</p>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-4">
                                    <div class="p-3 border border-dashed border-start-0 border-end-0">
                                        <h5 class="mb-1 fs-12">{{schedules.others}}</h5>
                                        <p class="text-muted mb-0 fs-12">Others</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card border-bottom shadow-none" style="height: 300px; overflow: auto;">
                            <div class="card-body">
                                <ul class="list-group list-group-flush border-dashed mt-n2">
                                    <li class="list-group-item ps-0" v-for="(list,index) in schedules.list" v-bind:key="index">
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
                                                <p class="text-primary text-truncate fw-semibold fs-12 mb-0">{{list.title}}</p>
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
                </div>

                <div class="col-md-3 mt-n1">
                    <div class="card bg-light-subtle shadow-none border">
                        <div class="card-header bg-light-subtle">
                            <div class="d-flex mb-n3">
                                <div class="flex-shrink-0 me-3 mt-1">
                                    <div style="height:2rem;width:2rem;">
                                        <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                            <i class="ri-account-circle-fill text-primary fs-20"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-0 fs-13"><span class="text-body">Personnel Status Monitoring</span></h5>
                                    <p class="text-muted text-truncate-two-lines fs-11"> Monitor personnel availability.</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <!-- <input type="date" v-model="date" placeholder="Search Request" class="form-control"> -->
                                </div>
                            </div>
                        </div>
                        <div class="card-header p-0 border-0 bg-light-subtle">
                            <div class="row g-0 text-center">
                                
                                <div class="col-12 col-sm-6">
                                    <div class="p-3 border border-dashed border-start-0">
                                        <h5 class="mb-1 fs-12">{{personnels.out}}</h5>
                                        <p class="text-muted mb-0 fs-12">Out of Laboratory</p>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-6">
                                    <div class="p-3 border border-dashed border-start-0">
                                        <h5 class="mb-1 fs-12">{{personnels.in}}</h5>
                                        <p class="text-muted mb-0 fs-12">In Laboratory</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card border-bottom shadow-none" style="height: 300px; overflow: auto;">
                            <div class="card-body">
                                <ul class="list-group list-group-flush border-dashed mt-n2">
                                    <li class="list-group-item ps-0" v-for="(list,index) in personnels.list" v-bind:key="index">
                                        <div class="row align-items-center g-3">
                                            <div class="col-auto">
                                                <!-- <div class="avatar-sm p-1 py-2 h-auto rounded-3 material-shadow">
                                                    <div class="text-center" >
                                                        
                                                        <h5 class="mb-0 fs-12" :class="list.event.color">{{ list.day }}</h5>
                                                        <div class="fs-10" :class="list.event.color">{{ list.day_name }}</div>
                                                    </div>
                                                </div> -->
                                                <img :src="list.avatar" alt="" class="rounded-circle avatar-xs material-shadow">
                                            </div>
                                            <div class="col">
                                                <h5 class="fw-semibold text-primary mt-0 mb-0 fs-12">{{list.name}}</h5>
                                                <p class="text-truncate fs-11 mb-0">{{list.schedules[0].event.name }} <span class="text-muted">({{ list.schedules[0].event.type }})</span></p>
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
                </div>

                <div class="col-md-3 mt-n1">
                    <div class="card bg-light-subtle shadow-none border">
                        <div class="card-header bg-light-subtle">
                            <div class="d-flex mb-n3">
                                <div class="flex-shrink-0 me-3 mt-1">
                                    <div style="height:2rem;width:2rem;">
                                        <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                            <i class="ri-wallet-3-fill text-primary fs-20"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-0 fs-13"><span class="text-body">Customer Wallet</span></h5>
                                    <p class="text-muted text-truncate-two-lines fs-11"> View customer wallet balances and funds.</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <!-- <input type="date" v-model="date" placeholder="Search Request" class="form-control"> -->
                                </div>
                            </div>
                        </div>
                        <div class="card-header p-0 border-0 bg-light-subtle">
                            <div class="row g-0 text-center">
                                <div class="col-12">
                                    <div class="p-3 border border-dashed border-start-0">
                                        <h5 class="mb-1 fs-12">{{totalAvailable}}</h5>
                                        <p class="text-muted mb-0 fs-12">Total Wallet Amount</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card border-bottom shadow-none" style="height: 300px; overflow: auto;">
                            <div class="card-body">
                                <ul class="list-group list-group-flush border-dashed mt-n2">
                                    <li class="list-group-item ps-0" v-for="(list,index) in wallets" v-bind:key="index">
                                        <div class="d-flex">
                                            <!-- <div class="flex-shrink-0">
                                                <p class="fs-11">{{ index+1 }}.</p>
                                            </div> -->
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="text-primary fw-semibold mb-0 fs-12">{{list.name}}</h6>
                                            </div>
                                            <div class="flex-shrink-0 text-end">
                                                <h6 class="fs-11 fw-semibold">{{list.available}}</h6>
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
                </div>

                <div class="col-md-3 mt-2">
                    <Link :href="`/insights/request`" target="_blank">
                        <div class="card overflow-hidden shadow-none mt-n3" style="cursor: pointer;">
                            <div class="card-body bg-danger-subtle">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-sm">
                                            <div class="avatar-title bg-danger bg-opacity-10 text-danger rounded-circle fs-17">
                                                <i class="ri-file-line fs-24"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="fs-12 text-danger mb-1">Customers Requesting Laboratory</h6>
                                        <p class="fs-11 text-muted mb-0">Shows TSR transactions with applied discounts and gross amount for monitoring and reporting.</p>
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

            </div>
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
            collection: [],
            collection_summary: [],
            wallets: [],
            fee: null,
            target: null,
            laboratory: null,
            total: [],
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
        'filter.laboratory'(val){
            this.fetch();
            this.fetchDaily();
        },
        'monthName'(val) {
            this.fetch();
        },
        'filter.year'(val) {
            this.fetch();
        },
    },
    created(){
        this.fetch();
        this.fetchDaily();
    },
    computed: {
        totalAvailable() {
            const total = this.wallets.reduce((sum, item) => {
                const cleanValue = String(item.available)
                    .replace(/₱/g, '')
                    .replace(/,/g, '')
                    .trim();

                return sum + Number(cleanValue || 0);
            }, 0);

            return new Intl.NumberFormat('en-PH', {
                style: 'currency',
                currency: 'PHP'
            }).format(total);
        }
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
                this.laboratories = response.data.laboratories.lists; 
                this.total = response.data.laboratories.footer;         
                this.fee = response.data.fee;
                this.target = response.data.target;
                this.counts = response.data.counts; 
                this.reminders = response.data.reminders; 
                this.statuses = response.data.statuses;   
                this.schedules = response.data.schedules; 
                this.personnels = response.data.personnels;
                this.collection = response.data.collection;
                this.collection_summary = response.data.collection_summary;
                this.wallets = response.data.wallets;
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
<style scoped>
.donut-chart {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    position: relative;
}

.donut-inner {
    position: absolute;
    inset: 4px;
    background: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 7px;
}</style>