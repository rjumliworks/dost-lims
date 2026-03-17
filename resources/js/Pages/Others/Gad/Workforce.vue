<template>
    <PageHeader title="Workforce" pageTitle="DOST-IX" />
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
        <div class="col-lg-8">
            <div class="card bg-light-subtle shadow-none border">
                        <div class="card-header bg-light-subtle">
                            <div class="d-flex mb-n3">
                               <h5 class="mb-3 fs-12 fw-semibold"><span class="text-purple">Age Group</span></h5>
                            </div>
                        </div>
                        <div class="card-body bg-white">
                           <div class="row">
                                <div class="col-md-8">
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
                                <div class="col-md-4">
                                    <table class="table table-sm table-striped fs-10 mt-n1">
                                        <tbody>
                                            <tr v-for="(list,index) in barSeries.data" v-bind:key="index">
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
            <div class="card card-height-100">
                <div class="card-header bg-purplealign-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1 fs-14">Role Distribution</h4>
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
                        <div class="d-flex mb-2" v-for="(list,index) in role_labels">
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
            gender: [12,9],
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
                    }
                }
            }
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
