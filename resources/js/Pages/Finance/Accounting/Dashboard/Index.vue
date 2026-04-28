<template>
    <Head title="Dashboard"/>
    <PageHeader title="Dashboard" pageTitle="Accountant" />
    <b-row class="g-3">

        <div class="col-md-3">
            <b-row class="g-3">
                <div class="col-md-12">
                    <b-card no-body class="border bg-danger-subtle shadow-none" style="cursor: pointer;" @click="openCreate()">
                        <b-card-body>
                            <div class="d-flex mb-n3">
                                <div class="flex-shrink-0 me-3">
                                    <div style="height: 2.5rem; width: 2.5rem;">
                                        <span class="avatar-title bg-danger rounded-circle p-2 mt-n1">
                                            <i class="ri-add-circle-fill text-white fs-20"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-0 fs-14"><span class="text-danger">Create Order of Payment</span></h5>
                                    <p class="text-muted text-truncate-two-lines fs-12">Identifying and resolving discrepancies</p>
                                </div>
                            </div>
                        </b-card-body>
                    </b-card>
                </div>
                <div class="col-md-12 mt-n2">
                    <div class="card shadow-none border">
                        <div class="card-header bg-light-subtle">
                            <div class="d-flex mb-n3">
                                <div class="flex-shrink-0 me-3">
                                    <div style="height:2.5rem;width:2.5rem;">
                                        <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                            <i class="ri-bank-card-fill text-primary fs-24"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-0 fs-14"><span class="text-body">Collection Summary</span></h5>
                                    <p class="text-muted text-truncate-two-lines fs-12">Highlights urgency and updates</p>
                                </div>
                                <div class="flex-shrink-0"></div>
                            </div>
                        </div>
                
                        <div class="card border-bottom shadow-none mb-0 mt-3" style="height: calc(100vh - 390px); overflow: auto;">
                            <ul class="list-group list-group-flush border-dashed mb-n4 p-3 mt-n4">
                                <li class="list-group-item px-0" v-for="(list,index) in dropdowns.reminders" v-bind:key="index">
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
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <hr class="text-muted"/>
                            <ul class="list-group list-group-flush border-dashed mb-n4 p-3 mt-n4">
                                <li class="list-group-item px-0" v-for="(list,index) in dropdowns.collection" v-bind:key="index">
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
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <hr class="text-muted"/>
                            <ul class="list-group list-group-flush border-dashed mb-0 mt-n4 p-3">
                                <li class="list-group-item px-0" v-for="(list,index) in dropdowns.collection_summary" v-bind:key="index">
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
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </b-row>
        </div>

        <div class="col-md-6">
            <div class="row g-3">
                <b-col lg="6">
                    <b-card no-body class="border shadow-none bg-warning-subtle" style="cursor: pointer;" @click="openExcel('reconciliation')">
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
                <b-col lg="6">
                    <b-card no-body class="border shadow-none bg-info-subtle" style="cursor: pointer;"  @click="openExcel('opandor')">
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
                <div class="col-md-12 mt-n2">
                    <Lists :dropdowns="dropdowns" :counts="counts" ref="list"/>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="row">
                <div class="col-md-12">
                    <b-card no-body class="border bg-danger-subtle shadow-none" style="cursor: pointer;" @click="openCreate()">
                        <b-card-body>
                            <div class="d-flex mb-n3">
                                <div class="flex-shrink-0 me-3">
                                    <div style="height: 2.5rem; width: 2.5rem;">
                                        <span class="avatar-title bg-danger rounded-circle p-2 mt-n1">
                                            <i class="ri-add-circle-fill text-white fs-20"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-0 fs-14"><span class="text-danger">Create Order of Payment</span></h5>
                                    <p class="text-muted text-truncate-two-lines fs-12">Identifying and resolving discrepancies</p>
                                </div>
                            </div>
                        </b-card-body>
                    </b-card>
                </div>
                <div class="col-md-12 mt-n2">
                    <div class="card shadow-none border">
                        <div class="card-header bg-light-subtle">
                            <div class="d-flex mb-n3">
                                <div class="flex-shrink-0 me-3">
                                    <div style="height:2.5rem;width:2.5rem;">
                                        <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                            <i class="ri-bank-card-fill text-primary fs-24"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-0 fs-14"><span class="text-body">Accounting Reports</span></h5>
                                    <p class="text-muted text-truncate-two-lines fs-12">Highlights urgency and updates</p>
                                </div>
                                <div class="flex-shrink-0"></div>
                            </div>
                        </div>
                        <div class="card border-bottom shadow-none mb-0" style="height: calc(100vh - 373px); overflow: auto;">
                             <b-list-group flush class="mt-5"  style="height: 300px; overflow: auto;" v-if="dropdowns.tsrs.data.length > 0">
                        <BListGroupItem v-for="(list,index) in dropdowns.tsrs.data" v-bind:key="index">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                
                                    <h5 class="mb-0 fs-12">{{list.code}}</h5>
                                    <p class="mb-0 fs-11 text-muted">{{list.customer.name}}</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="text-dark fs-12">{{list.payment.total}} </span>
                                </div>
                            
                            </div>
                        </BListGroupItem>
                    </b-list-group>
                    <b-list-group flush class="mt-n3" v-else>
                        <BListGroupItem>
                                <p class="text-muted fs-11 text-center">Nothing found.</p>
                        </BListGroupItem>
                    </b-list-group> 
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </b-row>
</template>
<script>
import Lists from './Components/Lists.vue';
import Unpaid from './Components/Unpaid.vue';
import PageHeader from '@/Shared/Components/PageHeader.vue';
export default {
    props: ['dropdowns','counts'],
    components: { PageHeader, Lists, Unpaid },
    data(){
        return {
            month : null,
            year: null,
            laboratory: 1
        }
    },
    methods: {
        formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return '₱'+val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        openExcel(type) {
            const params = new URLSearchParams();

            params.append('type', type);
            if (this.month) {
                params.append('month', this.month);
            }
            if (this.year) {
                params.append('year', this.year);
            }
            if (this.laboratory) {
                params.append('laboratory', this.laboratory);
            }
            window.open('/reports/excel?' + params.toString());
        },
        openCreate(){
            this.$refs.list.openCreate();
        }
    }
}
</script>