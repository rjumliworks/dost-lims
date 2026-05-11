<template lang="">
    <Head title="Target vs Accomplishment"/>
    <PageHeader title="Dashboard" pageTitle="Menu" />
    <b-row class="g-3">

        <div class="col-md-12">
            <b-card no-body class="bg-white-subtle border shadow-none">
                <b-card-body>
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex flex-lg-row flex-column">
                                <div class="flex-grow-1">
                                    <h4 class="fs-14 mb-0">Summary View</h4>
                                    <p class="text-muted mb-0">Here's what's happening with the laboratory for month of</p>
                                </div>
                                <div class="mt-3 mt-lg-0" style="width: 60%;">
                                    <div class="input-group mb-1">
                                        <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                                        <input type="text" placeholder="Accomplishments" class="form-control" style="width: 20%;">
                                        <Multiselect class="white" style="width: 15%;" :options="types" v-model="type" label="name" :allow-empty="false" :searchable="true" placeholder="Select Type" />
                                        <Multiselect class="white" style="width: 15%;" :options="years" v-model="year" label="name" :allow-empty="false" :searchable="true" placeholder="Select Year" />
                                        <b-button type="button" variant="primary" @click="openCreate">
                                            <i class="ri-search-eye-fill align-bottom"></i>
                                        </b-button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </b-card-body>
            </b-card>
        </div>

        <div class="col-md-6 mt-n1">
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
                            <h5 class="mb-0 mt-0 fs-13"><span class="text-body">No. of Samples Received</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-11">Highlights urgency and updates</p>
                        </div>
                    </div>
                </div>
                <div class="card border-bottom shadow-none" no-body style="height: 350px;">
                    <div class="row g-3 mt-1">
                        <div class="col-md-12">
                            
                        </div>
                        <div class="col-md-6 ms-3 me-n3 mt-4">
                            <apexchart
                                type="bar"
                                height="280"
                                :series="getChartData('OneLab KPI - Objective 1', 0).series"
                                :options="getChartData('OneLab KPI - Objective 1', 0).options"/>
                        </div>
                       
                        <div class="col-md-6 mt-5" v-if="kpis['OneLab KPI - Objective 1']">
                            <div class="d-flex align-items-center pb-2 pe-4 mb-3 mt-2" v-for="(list,index) in kpis?.['OneLab KPI - Objective 1']?.[0]?.lists" :key="index">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-xs">
                                        <div class="avatar-title bg-light rounded-circle text-muted fs-16 mt-n2">
                                            <i class="ri-checkbox-circle-fill" :style="{ color: getProgressColor(kpis['OneLab KPI - Objective 1'][0].breakdown[index].percentage)}"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="progress animated-progress custom-progress progress-label">
                                        <div class="progress-bar" role="progressbar" 
                                        :style="{ width: kpis['OneLab KPI - Objective 1'][0].breakdown[index].percentage, backgroundColor: colors[index]}" 
                                        aria-valuemin="0" aria-valuemax="100">
                                            <div class="label">
                                                {{ kpis['OneLab KPI - Objective 1'][0].breakdown[index].percentage }}
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mb-1 mt-1 ms-1 text-muted fs-12">
                                        {{ list.laboratory.name }} ({{ kpis['OneLab KPI - Objective 1'][0].breakdown[index].accomplish }})
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                       
                </div>
            </div>
        </div>

         <div class="col-md-6 mt-n1">
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
                            <h5 class="mb-0 mt-0 fs-13"><span class="text-body">No. of Tests/Calibration Services Conducted</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-11">Highlights urgency and updates</p>
                        </div>
                    </div>
                </div>
                <div class="card border-bottom shadow-none" no-body style="height: 350px;">
                    
                    <div class="row g-3 mt-1">
                        <div class="col-md-6 ms-3 me-n3 mt-4">
                            <apexchart
                                type="bar"
                                height="280"
                                :series="getChartData('OneLab KPI - Objective 1', 1).series"
                                :options="getChartData('OneLab KPI - Objective 1', 1).options"
                            />
                        </div>
                       
                        <div class="col-md-6 mt-5" v-if="kpis['OneLab KPI - Objective 1']">
                            <div class="d-flex align-items-center pb-2 pe-4 mb-3 mt-2" v-for="(list,index) in kpis?.['OneLab KPI - Objective 1']?.[1]?.lists" :key="index">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-xs">
                                        <div class="avatar-title bg-light rounded-circle text-muted fs-16 mt-n2">
                                            <i class="ri-checkbox-circle-fill" :style="{ color: getProgressColor(kpis['OneLab KPI - Objective 1'][1].breakdown[index].percentage)}"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="progress animated-progress custom-progress progress-label">
                                        <div class="progress-bar" role="progressbar" 
                                        :style="{ width: kpis['OneLab KPI - Objective 1'][1].breakdown[index].percentage, backgroundColor: colors[index]}" 
                                        aria-valuemin="0" aria-valuemax="100">
                                            <div class="label">
                                                {{ kpis['OneLab KPI - Objective 1'][1].breakdown[index].percentage }}
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mb-1 mt-1 ms-1 text-muted fs-12">
                                        {{ list.laboratory.name }} ({{ kpis['OneLab KPI - Objective 1'][1].breakdown[index].accomplish }})
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-6 mt-n1">
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
                            <h5 class="mb-0 mt-0 fs-13"><span class="text-body">No. of Customers Served</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-11">Highlights urgency and updates</p>
                        </div>
                    </div>
                </div>
                <div class="card border-bottom shadow-none" no-body style="height: 350px;">
                    
                    <div class="row g-3 mt-1">
                        <div class="col-md-6 ms-3 me-n3 mt-4">
                            <apexchart
                                type="bar"
                                height="280"
                                :series="getChartData('OneLab KPI - Objective 1', 2).series"
                                :options="getChartData('OneLab KPI - Objective 1', 2).options"
                            />
                        </div>
                       
                        <div class="col-md-6 mt-5" v-if="kpis['OneLab KPI - Objective 1']">
                            <div class="d-flex align-items-center pb-2 pe-4 mb-3 mt-2" v-for="(list,index) in kpis?.['OneLab KPI - Objective 1']?.[2]?.lists" :key="index">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-xs">
                                        <div class="avatar-title bg-light rounded-circle text-muted fs-16 mt-n2">
                                            <i class="ri-checkbox-circle-fill" :style="{ color: getProgressColor(kpis['OneLab KPI - Objective 1'][2].breakdown[index].percentage)}"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="progress animated-progress custom-progress progress-label">
                                        <div class="progress-bar" role="progressbar" 
                                        :style="{ width: kpis['OneLab KPI - Objective 1'][2].breakdown[index].percentage, backgroundColor: colors[index]}" 
                                        aria-valuemin="0" aria-valuemax="100">
                                            <div class="label">
                                                {{ kpis['OneLab KPI - Objective 1'][2].breakdown[index].percentage }}
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mb-1 mt-1 ms-1 text-muted fs-12">
                                        {{ list.laboratory.name }} ({{ kpis['OneLab KPI - Objective 1'][2].breakdown[index].accomplish }})
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-6 mt-n1">
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
                            <h5 class="mb-0 mt-0 fs-13"><span class="text-body">No. of New Customers Served</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-11">Highlights urgency and updates</p>
                        </div>
                    </div>
                </div>
                <div class="card border-bottom shadow-none" no-body style="height: 350px;">
                    
                    <div class="row g-3 mt-1">
                        <div class="col-md-6 ms-3 me-n3 mt-4">
                            <apexchart
                                type="bar"
                                height="280"
                                :series="getChartData('OneLab KPI - Objective 1', 3).series"
                                :options="getChartData('OneLab KPI - Objective 1', 3).options"
                            />
                        </div>
                       
                        <div class="col-md-6 mt-5" v-if="kpis['OneLab KPI - Objective 1']">
                            <div class="d-flex align-items-center pb-2 pe-4 mb-3 mt-2" v-for="(list,index) in kpis?.['OneLab KPI - Objective 1']?.[3]?.lists" :key="index">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-xs">
                                        <div class="avatar-title bg-light rounded-circle text-muted fs-16 mt-n2" v-if=" kpis['OneLab KPI - Objective 1'][3].breakdown.length > 0">
                                            <i class="ri-checkbox-circle-fill" :style="{ color: getProgressColor(kpis['OneLab KPI - Objective 1'][3].breakdown[index].percentage)}"></i>
                                        </div>
                                        <div class="avatar-title bg-light rounded-circle text-muted fs-16 mt-n2" v-else>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1" v-if=" kpis['OneLab KPI - Objective 1'][3].breakdown.length > 0">
                                    <div class="progress animated-progress custom-progress progress-label">
                                        <div class="progress-bar" role="progressbar" 
                                        :style="{ width: kpis['OneLab KPI - Objective 1'][3].breakdown[index].percentage, backgroundColor: colors[index]}" 
                                        aria-valuemin="0" aria-valuemax="100">
                                            <div class="label">
                                                {{ kpis['OneLab KPI - Objective 1'][3].breakdown[index].percentage }}
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mb-1 mt-1 ms-1 text-muted fs-12">
                                        {{ list.laboratory.name }} ({{ kpis['OneLab KPI - Objective 1'][3].breakdown[index].accomplish }})
                                    </p>
                                </div>
                                <div class="flex-grow-1" v-else>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-6 mt-n1">
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
                            <h5 class="mb-0 mt-0 fs-13"><span class="text-body">No. of Firms Served</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-11">Highlights urgency and updates</p>
                        </div>
                    </div>
                </div>
                <div class="card border-bottom shadow-none" no-body style="height: 350px;">
                    
                    <div class="row g-3 mt-1">
                        <div class="col-md-6 ms-3 me-n3 mt-4">
                            <apexchart
                                type="bar"
                                height="280"
                                :series="getChartData('OneLab KPI - Objective 1', 4).series"
                                :options="getChartData('OneLab KPI - Objective 1', 4).options"
                            />
                        </div>
                       
                        <div class="col-md-6 mt-5" v-if="kpis['OneLab KPI - Objective 1']">
                            <div class="d-flex align-items-center pb-2 pe-4 mb-3 mt-2" v-for="(list,index) in kpis?.['OneLab KPI - Objective 1']?.[4]?.lists" :key="index">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-xs">
                                        <div class="avatar-title bg-light rounded-circle text-muted fs-16 mt-n2">
                                            <i class="ri-checkbox-circle-fill" :style="{ color: getProgressColor(kpis['OneLab KPI - Objective 1'][4].breakdown[index].percentage)}"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="progress animated-progress custom-progress progress-label">
                                        <div class="progress-bar" role="progressbar" 
                                        :style="{ width: kpis['OneLab KPI - Objective 1'][4].breakdown[index].percentage, backgroundColor: colors[index]}" 
                                        aria-valuemin="0" aria-valuemax="100">
                                            <div class="label">
                                                {{ kpis['OneLab KPI - Objective 1'][4].breakdown[index].percentage }}
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mb-1 mt-1 ms-1 text-muted fs-12">
                                        {{ list.laboratory.name }} ({{ kpis['OneLab KPI - Objective 1'][4].breakdown[index].accomplish }})
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-6 mt-n1">
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
                            <h5 class="mb-0 mt-0 fs-13"><span class="text-body">Actual Fees Collected</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-11">Highlights urgency and updates</p>
                        </div>
                    </div>
                </div>
                <div class="card border-bottom shadow-none" no-body style="height: 350px;">
                    
                    <div class="row g-3 mt-1">
                        <div class="col-md-6 ms-3 me-n3 mt-4">
                            <apexchart
                                type="bar"
                                height="280"
                                :series="getChartData('OneLab KPI - Objective 1', 5).series"
                                :options="getChartData('OneLab KPI - Objective 1', 5).options"
                            />
                        </div>
                       
                        <div class="col-md-6 mt-5" v-if="kpis['OneLab KPI - Objective 1']">
                            <div class="d-flex align-items-center pb-2 pe-4 mb-3 mt-2" v-for="(list,index) in kpis?.['OneLab KPI - Objective 1']?.[5]?.lists" :key="index">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-xs">
                                        <div class="avatar-title bg-light rounded-circle text-muted fs-16 mt-n2">
                                            <i class="ri-checkbox-circle-fill" :style="{ color: getProgressColor(kpis['OneLab KPI - Objective 1'][5].breakdown[index].percentage)}"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="progress animated-progress custom-progress progress-label">
                                        <div class="progress-bar" role="progressbar" 
                                        :style="{ width: kpis['OneLab KPI - Objective 1'][5].breakdown[index].percentage, backgroundColor: colors[index]}" 
                                        aria-valuemin="0" aria-valuemax="100">
                                            <div class="label">
                                                {{ kpis['OneLab KPI - Objective 1'][5].breakdown[index].percentage }}
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mb-1 mt-1 ms-1 text-muted fs-12">
                                        {{ list.laboratory.name }} ({{ formatMoney(kpis['OneLab KPI - Objective 1'][5].breakdown[index].accomplish) }})
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-6 mt-n1">
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
                            <h5 class="mb-0 mt-0 fs-13"><span class="text-body">Value of Assistance Rendered</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-11">Highlights urgency and updates</p>
                        </div>
                    </div>
                </div>
                <div class="card border-bottom shadow-none" no-body style="height: 350px;">
                    
                    <div class="row g-3 mt-1">
                        <div class="col-md-6 ms-3 me-n3 mt-4">
                            <apexchart
                                type="bar"
                                height="280"
                                :series="getChartData('OneLab KPI - Objective 1', 6).series"
                                :options="getChartData('OneLab KPI - Objective 1', 6).options"
                            />
                        </div>
                       
                        <div class="col-md-6 mt-5" v-if="kpis['OneLab KPI - Objective 1']">
                            <div class="d-flex align-items-center pb-2 pe-4 mb-3 mt-2" v-for="(list,index) in kpis?.['OneLab KPI - Objective 1']?.[6]?.lists" :key="index">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-xs">
                                        <div class="avatar-title bg-light rounded-circle text-muted fs-16 mt-n2">
                                            <i class="ri-checkbox-circle-fill" :style="{ color: getProgressColor(kpis['OneLab KPI - Objective 1'][6].breakdown[index].percentage)}"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="progress animated-progress custom-progress progress-label">
                                        <div class="progress-bar" role="progressbar" 
                                        :style="{ width: kpis['OneLab KPI - Objective 1'][6].breakdown[index].percentage, backgroundColor: colors[index]}" 
                                        aria-valuemin="0" aria-valuemax="100">
                                            <div class="label">
                                                {{ kpis['OneLab KPI - Objective 1'][6].breakdown[index].percentage }}
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mb-1 mt-1 ms-1 text-muted fs-12">
                                        {{ list.laboratory.name }} ({{ formatMoney(kpis['OneLab KPI - Objective 1'][6].breakdown[index].accomplish) }})
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-6 mt-n1">
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
                            <h5 class="mb-0 mt-0 fs-13"><span class="text-body">Number of Samples Referred from PSTOs</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-11">Highlights urgency and updates</p>
                        </div>
                    </div>
                </div>
                <div class="card border-bottom shadow-none" no-body style="height: 350px;">
                    
                    <div class="row g-3 mt-1">
                        <div class="col-md-6 ms-3 me-n3 mt-4">
                            <apexchart
                                type="bar"
                                height="280"
                                :series="getChartData('OneLab KPI - Objective 1', 9).series"
                                :options="getChartData('OneLab KPI - Objective 1', 9).options"
                            />
                        </div>
                       
                        <div class="col-md-6 mt-5" v-if="kpis['OneLab KPI - Objective 1']">
                            <div class="d-flex align-items-center pb-2 pe-4 mb-3 mt-2" v-for="(list,index) in kpis?.['OneLab KPI - Objective 1']?.[9]?.lists" :key="index">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-xs">
                                        <div class="avatar-title bg-light rounded-circle text-muted fs-16 mt-n2">
                                            <i class="ri-checkbox-circle-fill" :style="{ color: getProgressColor(kpis['OneLab KPI - Objective 1'][9].breakdown[index].percentage)}"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="progress animated-progress custom-progress progress-label">
                                        <div class="progress-bar" role="progressbar" 
                                        :style="{ width: kpis['OneLab KPI - Objective 1'][9].breakdown[index].percentage, backgroundColor: colors[index]}" 
                                        aria-valuemin="0" aria-valuemax="100">
                                            <div class="label">
                                                {{ kpis['OneLab KPI - Objective 1'][9].breakdown[index].percentage }}
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mb-1 mt-1 ms-1 text-muted fs-12">
                                        {{ list.laboratory.name }} ({{ formatMoney(kpis['OneLab KPI - Objective 1'][9].breakdown[index].accomplish) }})
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-6 mt-n1">
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
                            <h5 class="mb-0 mt-0 fs-13"><span class="text-body">Number of Services Referred from PSTOs</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-11">Highlights urgency and updates</p>
                        </div>
                    </div>
                </div>
                <div class="card border-bottom shadow-none" no-body style="height: 350px;">
                    
                    <div class="row g-3 mt-1">
                        <div class="col-md-6 ms-3 me-n3 mt-4">
                            <apexchart
                                type="bar"
                                height="280"
                                :series="getChartData('OneLab KPI - Objective 1', 10).series"
                                :options="getChartData('OneLab KPI - Objective 1', 10).options"
                            />
                        </div>
                       
                        <div class="col-md-6 mt-5" v-if="kpis['OneLab KPI - Objective 1']">
                            <div class="d-flex align-items-center pb-2 pe-4 mb-3 mt-2" v-for="(list,index) in kpis?.['OneLab KPI - Objective 1']?.[10]?.lists" :key="index">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-xs">
                                        <div class="avatar-title bg-light rounded-circle text-muted fs-16 mt-n2">
                                            <i class="ri-checkbox-circle-fill" :style="{ color: getProgressColor(kpis['OneLab KPI - Objective 1'][10].breakdown[index].percentage)}"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="progress animated-progress custom-progress progress-label">
                                        <div class="progress-bar" role="progressbar" 
                                        :style="{ width: kpis['OneLab KPI - Objective 1'][10].breakdown[index].percentage, backgroundColor: colors[index]}" 
                                        aria-valuemin="0" aria-valuemax="100">
                                            <div class="label">
                                                {{ kpis['OneLab KPI - Objective 1'][10].breakdown[index].percentage }}
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mb-1 mt-1 ms-1 text-muted fs-12">
                                        {{ list.laboratory.name }} ({{ formatMoney(kpis['OneLab KPI - Objective 1'][10].breakdown[index].accomplish) }})
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-6 mt-n1">
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
                            <h5 class="mb-0 mt-0 fs-13"><span class="text-body">Number of Referred Samples Received from other Laboratories</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-11">Highlights urgency and updates</p>
                        </div>
                    </div>
                </div>
                <div class="card border-bottom shadow-none" no-body style="height: 350px;">
                    
                    <div class="row g-3 mt-1">
                        <div class="col-md-6 ms-3 me-n3 mt-4">
                            <apexchart
                                type="bar"
                                height="280"
                                :series="getChartData('OneLab KPI - Objective 1', 11).series"
                                :options="getChartData('OneLab KPI - Objective 1', 11).options"
                            />
                        </div>
                       
                        <div class="col-md-6 mt-5" v-if="kpis['OneLab KPI - Objective 1']">
                            <div class="d-flex align-items-center pb-2 pe-4 mb-3 mt-2" v-for="(list,index) in kpis?.['OneLab KPI - Objective 1']?.[11]?.lists" :key="index">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-xs">
                                        <div class="avatar-title bg-light rounded-circle text-muted fs-16 mt-n2">
                                            <i class="ri-checkbox-circle-fill" :style="{ color: getProgressColor(kpis['OneLab KPI - Objective 1'][11].breakdown[index].percentage)}"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="progress animated-progress custom-progress progress-label">
                                        <div class="progress-bar" role="progressbar" 
                                        :style="{ width: kpis['OneLab KPI - Objective 1'][11].breakdown[index].percentage, backgroundColor: colors[index]}" 
                                        aria-valuemin="0" aria-valuemax="100">
                                            <div class="label">
                                                {{ kpis['OneLab KPI - Objective 1'][11].breakdown[index].percentage }}
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mb-1 mt-1 ms-1 text-muted fs-12">
                                        {{ list.laboratory.name }} ({{ formatMoney(kpis['OneLab KPI - Objective 1'][11].breakdown[index].accomplish) }})
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-6 mt-n1">
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
                            <h5 class="mb-0 mt-0 fs-13"><span class="text-body">Number of Referred Services Conducted from other Laboratories</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-11">Highlights urgency and updates</p>
                        </div>
                    </div>
                </div>
                <div class="card border-bottom shadow-none" no-body style="height: 350px;">
                    
                    <div class="row g-3 mt-1">
                        <div class="col-md-6 ms-3 me-n3 mt-4">
                            <apexchart
                                type="bar"
                                height="280"
                                :series="getChartData('OneLab KPI - Objective 1', 12).series"
                                :options="getChartData('OneLab KPI - Objective 1', 12).options"
                            />
                        </div>
                       
                        <div class="col-md-6 mt-5" v-if="kpis['OneLab KPI - Objective 1']">
                            <div class="d-flex align-items-center pb-2 pe-4 mb-3 mt-2" v-for="(list,index) in kpis?.['OneLab KPI - Objective 1']?.[12]?.lists" :key="index">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-xs">
                                        <div class="avatar-title bg-light rounded-circle text-muted fs-16 mt-n2">
                                            <i class="ri-checkbox-circle-fill" :style="{ color: getProgressColor(kpis['OneLab KPI - Objective 1'][12].breakdown[index].percentage)}"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="progress animated-progress custom-progress progress-label">
                                        <div class="progress-bar" role="progressbar" 
                                        :style="{ width: kpis['OneLab KPI - Objective 1'][12].breakdown[index].percentage, backgroundColor: colors[index]}" 
                                        aria-valuemin="0" aria-valuemax="100">
                                            <div class="label">
                                                {{ kpis['OneLab KPI - Objective 1'][12].breakdown[index].percentage }}
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mb-1 mt-1 ms-1 text-muted fs-12">
                                        {{ list.laboratory.name }} ({{ formatMoney(kpis['OneLab KPI - Objective 1'][12].breakdown[index].accomplish) }})
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </b-row>
</template>
<script>
import Multiselect from "@vueform/multiselect";
export default {
    components: { Multiselect },
    props: ['years'],
data(){
        return {
            colors: [
                "#83aff0",
                "#4779c4",
                "#3c649f",
                "#D7E5FF"
            ],
            loading: false,
            year: new Date().getFullYear(),
            selectedRow: null,
            months: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            quarters: ['1st Quarter','2nd Quarter','3rd Quarter','4th Quarter'],
            types: ['Months','Quarters'],
            type: 'Months',
            selectedRow: null, 
            selectedColumn: null,
            expandedRows: {},
            kpis: [],
        }
    },
    watch: {
        'year'(val) {
            this.fetch();
        },
    },
    created(){
        this.fetch();
    },
    methods: {
        getChartData(kpiKey, index = 0) {
    // 1. Return empty state if data hasn't loaded yet
    if (!this.kpis || !this.kpis[kpiKey] || !this.kpis[kpiKey][index]) {
        return { series: [], options: {} };
    }

    // 2. Extract Data First
    const kpiData = this.kpis[kpiKey][index];
    const targetValue = kpiData.target || 0;
    const breakdowns = kpiData.breakdown || [];
    const lists = kpiData.lists || [];

    // 3. Check if it's an amount
    const isAmount = kpiData.is_amount == 1; 
    const isConsolidated = kpiData.is_consolidated == 1; 

    // Capture your format method so ApexCharts can use it without losing 'this' context
    const formatCurrency = this.formatMoney; 

    // 4. Base configuration for the chart
    const baseOptions = {
        chart: { type: "bar", stacked: true, toolbar: { show: false } },
        grid: { 
            show: false 
        },
        legend: { show: false },
        xaxis: { categories: ["Target", "Accomplishment"] },
        yaxis: { 
            title: { text: "Target vs Accomplishment" },
            labels: { show: false }
        },
        plotOptions: { 
            bar: { 
                columnWidth: "80%", 
                dataLabels: { hideOverflowingLabels: false } 
            } 
        },
        dataLabels: { 
            enabled: true, 
            style: {
                fontSize: '10px',
                fontWeight: 'bold',
            },
            background: {
                enabled: true,
                foreColor: '#000000',
                padding: 4,
                borderRadius: 2,
                borderWidth: 1,
                borderColor: '#ffffff',
                opacity: 0.9,
            },
            formatter: function (val) {
                // FIX: Use Number() to catch string "0" and return undefined to completely hide the label & background
                if (!val || Number(val) === 0) return undefined;
                return isAmount ? formatCurrency(val) : val;
            } 
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return isAmount ? formatCurrency(val) : val;
                }
            }
        }
    };

    // 5. Setup Target Series (First column)
    let generatedSeries = [
        {
            name: "Target",
            data: [targetValue, 0]
        }
    ];

    // 6. Setup Accomplishment Breakdown Series (Second column stacked)
    if(isConsolidated){
        generatedSeries.push({
            name: "Total Accomplishment", 
            data: [0, kpiData.accomplish || 0] 
        });
    } else {
        for (let i = breakdowns.length - 1; i >= 0; i--) {
            const item = breakdowns[i];
            const labName = lists[i]?.laboratory?.name || `Accomplishment ${i + 1}`;
            
            generatedSeries.push({
                name: labName,
                data: [0, item.accomplish || 0] 
            });
        }
    }
    
    const chartColors = [
        "#2c456b", 
        ...this.colors 
    ];

    return {
        series: generatedSeries,
        options: {
            ...baseOptions,
            colors: chartColors
        }
    };
},
        fetch() {
            this.loading = true;
            axios.get('/accomplishments', {
                params: {
                    year: this.year,
                    option: 'targets',
                }
            })
            .then(response => {
                let data = response.data;
                
                // Loop through each group (e.g., 'OneLab KPI - Objective 1')
                for (let key in data) {
                    // Make sure it's actually an array of items
                    if (Array.isArray(data[key])) {
                        data[key] = data[key].map(kpiObj => {
                            
                            // Check if this specific KPI has breakdowns and lists
                            if (Array.isArray(kpiObj.breakdown) && Array.isArray(kpiObj.lists)) {
                                
                                // 1. Combine the parallel arrays into one temporary array
                                let combined = kpiObj.breakdown.map((breakdownItem, i) => {
                                    return {
                                        bItem: breakdownItem,
                                        lItem: kpiObj.lists[i]
                                    };
                                });
                                
                                // 2. Sort safely by PERCENTAGE (Lowest to Highest)
                                combined.sort((a, b) => {
                                    // Remove the '%' sign and safely convert to a decimal number
                                    let valA = parseFloat(String(a.bItem.percentage).replace(/%/g, '').trim()) || 0;
                                    let valB = parseFloat(String(b.bItem.percentage).replace(/%/g, '').trim()) || 0;
                                    
                                    return valA - valB;
                                });
                                
                                // 3. Separate them back in their new sorted order
                                kpiObj.breakdown = combined.map(c => c.bItem);
                                kpiObj.lists = combined.map(c => c.lItem);
                            }
                            
                            return kpiObj;
                        });
                    }
                }
                
                // Force Vue to detect the deep changes by assigning a brand new object
                this.kpis = { ...data };         
            })
            .catch(err => console.log(err))
            .finally(() => {
                this.loading = false;
            });
        },
        formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return '₱'+val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        formatNumber(value) {
            if (!value) return '0';
            return Number(value).toLocaleString(undefined, {
            minimumFractionDigits: 0,
            maximumFractionDigits: 2
            });
        },
        getProgressColor(value) {
            const percent = Number(String(value).replace('%', '')) || 0;

            if (percent <= 35) {
                return "#E16A54"; // pastel red
            } 
            else if (percent > 25 && percent < 50) {
                return "#F39E60"; // pastel orange
            } 
            else if (percent >= 50 && percent < 80) {
                return "#295F98"; // pastel blue
            } 
            else if (percent >= 80 && percent <= 99) {
                return "#79AC78"; // pastel green
            }

            return "#79AC78"; // default gray
        },
    }
}
</script>