<template>
    <!-- <PageHeader title="Workforce" pageTitle="DOST-IX" /> -->
    <div class="card shadow-none border">
        <div class="card-body">
            <div class="d-flex flex-wrap" style="cursor: pointer;">
                <div class="avatar-sm">
                    <div
                        class="avatar-title bg-light rounded-circle fs-20 text-purple">
                        <i class="ri-bar-chart-2-fill"></i>
                    </div>
                </div>
                <div class="ms-3 mt-1">
                    <p class="fw-semibold fs-15 text-purple text-truncated mb-0">DOSTIX RSTL Workforce Data</p>
                    <h5 class="mb-0 text-muted fs-13">View and manage employee information and staffing data for RSTL operations.</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4" v-for="(item, index) of gender_names" :key="index">
            
            <div class="card shadow-none border" :class="(index == 2) ? 'bg-info-subtle' : ''">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                                <i :class="`bx ${gender_icons[index]} align-middle`"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">
                                {{ item }}
                            </p>
                            <h4 class="mb-0">
                                <span class="counter-value">{{gender_counts[index]}}</span>
                            </h4>
                        </div>
                        <div class="flex-shrink-0 align-self-end" v-if="index != 2">
                            <!-- <apexchart class="apex-charts" height="40" width="100" type="area" dir="ltr" :series="item.info.series" :options="chartOptions"></apexchart> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card bg-light-subtle shadow-none border">
                 <div class="card-header bg-purplealign-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1 fw-semibold text-purple fs-14">Age Group</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10">
                            <apexchart 
                            ref="realtimeChart" 
                            class="apex-charts" 
                            type="bar" 
                            height="300" 
                            :series="barSeries"
                            :options="chartOptions4" 
                            >
                            </apexchart>
                        </div>
                        <div class="col-md-2">
                            <table class="table table-striped fs-10 mt-n1">
                                <thead>
                                    <tr>
                                        <th>Group</th>
                                        <th class="text-end">#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(list,index) in labels" v-bind:key="index">
                                        <td>{{list}} :</td>
                                        <td class="text-end">{{ age[index] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card bg-light-subtle shadow-none border">
                <div class="card-header bg-purplealign-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1 fw-semibold text-purple fs-14">Role Distribution</h4>
                </div>

                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h6 class="text-muted text-uppercase fw-semibold text-truncate fs-12 mb-3">Total Workforce</h6>
                            <h4 class="mb-0">20</h4>
                            <!-- <p class="mb-0 mt-2 text-muted"><span class="badge bg-success-subtle text-success mb-0"> <i class="ri-arrow-up-line align-middle"></i> 15.72 % </span> vs. previous month</p> -->
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <img src="assets/images/illustrator-1.png" class="img-fluid" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 pt-2">
                        <div class="progress progress-lg rounded-pill">
                            <div
                                v-for="(role, index) in roles"
                                :key="index"
                                class="progress-bar"
                                :class="role_bgs[index]"
                                role="progressbar"
                                :style="{ width: getRolePercentage(index) + '%' }"
                                :aria-valuenow="roles[index]"
                                aria-valuemin="0"
                                :aria-valuemax="totalRoles"
                            ></div>
                        </div>
                    </div>
                    <div class="mt-3 pt-2">
                        <div class="d-flex mb-2" v-for="(list,index) in role_labels" :key="index">
                            <div class="flex-grow-1">
                                <p class="text-truncate text-muted fs-14 mb-0"><i class="mdi mdi-circle align-middle me-2" :class="role_colors[index]"></i>{{ list }}</p>
                            </div>
                            <div class="flex-shrink-0">
                                <p class="mb-0">{{ roles[index] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card bg-light-subtle shadow-none border">
                <div class="card-header bg-purplealign-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1 fw-semibold text-purple fs-14">Employment Status</h4>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-7">
                            <apexchart ref="realtimeChart" class="apex-charts" type="pie" height="160" :series="employment"
                                :options="chartOptions2" style="float: left;">
                            </apexchart>
                        </div>
                        <div class="col-md-5">
                            <table class="table table-sm table-striped fs-10 mt-n1">
                                <tbody>
                                    <tr v-for="(list,index) in chartOptions1.labels" v-bind:key="index">
                                        <td>{{list}} :</td>
                                        <td class="text-end">{{ employment[index] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card bg-light-subtle shadow-none border">
                <div class="card-header bg-purplealign-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1 fw-semibold text-purple fs-14">Civil Status</h4>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-7">
                            <apexchart ref="realtimeChart" class="apex-charts" type="pie" height="160" :series="civil_status"
                                :options="chartOptions3" style="float: left;">
                            </apexchart>
                        </div>
                        <div class="col-md-5">
                            <table class="table table-sm table-striped fs-10 mt-n1">
                                <tbody>
                                    <tr v-for="(list,index) in chartOptions2.labels" v-bind:key="index">
                                        <td>{{list}} :</td>
                                        <td class="text-end">{{ civil_status[index] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card bg-light-subtle shadow-none border">
                <div class="card-header bg-purplealign-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1 fw-semibold text-purple fs-14">Education Attainment</h4>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-7">
                            <apexchart ref="realtimeChart" class="apex-charts" type="pie" height="160" :series="age"
                                :options="chartOptions4" style="float: left;">
                            </apexchart>
                        </div>
                        <div class="col-md-5">
                            <table class="table table-sm table-striped fs-10 mt-n1">
                                <tbody>
                                    <tr v-for="(list,index) in chartOptions3.labels" v-bind:key="index">
                                        <td>{{list}} :</td>
                                        <td class="text-end">{{ age[index] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import PageHeader from '@/Shared/Components/PageHeader.vue';
export default {
    components: {
        PageHeader
    },
    data() {
        return {
            labels: ['15-24','25-34','35-44','45-54','55-64','65+'],
            gender_icons: [' ri-men-fill', ' ri-women-fill', ' ri-group-fill'],
            gender_names: ['Male','Female','Total Workforce'],
            gender_counts: [11,9,20],
            employment: [2,19],
            civil_status: [14,7,0],
            age: [0,13,5,1,2,0],
            edu: [15,3,4],
            roles: [3,9,1,2,4,1],
            role_labels: ['Technical Manager','Analyst','IT','Staff','Laboratory Aide','Utility'],
            role_colors: ['text-pink','text-purple','text-success','text-warning','text-danger','text-info'],
            role_bgs: ['bg-pink','bg-purple','bg-success','bg-warning','bg-danger','bg-info'],
            barSeries: [
                {
                    name: "Age Groups",
                    data: [0, 13, 5, 1, 2, 0] // example numbers for each age group
                }
            ],
            chartOptions4: {
                chart: {
                    type: 'bar',
                },
                xaxis: {
                    categories: ['15-24','25-34','35-44','45-54','55-64','65+']
                },
                colors: ['#39a6c6','#d86885','#65b089','#f5c136','#9824e9','#318f78'],
                legend: { show: false },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '70%',
                        distributed: true
                    }
                }
            },
            chartOptions1: {
                chart: {type: 'pie',height: 50,},
                labels: ['Regular', 'COS'],
                colors: ['#39a6c6', '#d86885'],
                legend: {show: false}
            },
            chartOptions2: {
                chart: {type: 'pie',height: 50,},
                labels: ['Single', 'Married','Widowed'],
                colors: ['#39a6c6', '#d86885'],
                legend: {show: false}
            },
            chartOptions3: {
                chart: {type: 'pie',height: 50,},
                labels: ['College Graduate','Masters','College Level'],
                colors: ['#39a6c6','#d86885','#65b089','#f5c136','#9824e9','#318f78'],
                legend: {show: false}
            },
        }
    },
    methods: {
        getRolePercentage(index) {
            const total = this.roles.reduce((sum, val) => sum + val, 0);
            return ((this.roles[index] / total) * 100).toFixed(2);
        }
    }
}
</script>
