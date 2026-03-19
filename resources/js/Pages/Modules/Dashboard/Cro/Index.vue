<template>
    <Head title="Dashboard"/>
    <PageHeader title="Dashboard" pageTitle="Menu" />
    <b-row class="g-3">
        <div class="col-12 mb-3 mt-2">
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
                                    <select v-model="laboratory" class="form-select" aria-label="Default select example">
                                        <option :value="null">All Laboratories</option>
                                        <option :value="list" v-for="list in dropdowns.laboratories" v-bind:key="list.value">{{list.name}}</option>
                                    </select>
                                    <select class="form-select" aria-label="Default select example">
                                        <option :value="null">All Year</option>
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
        <div class="col-md-12 mt-0">
            <div class="row g-3">
                <b-col lg="3" md="4" v-for="(item, index) of counts" :key="index">
                    <b-card no-body :class="item.color" >
                        <b-card-body>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                                        <i :class="`bx ${item.icon} align-middle`"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">
                                        {{ item.name }}
                                    </p>
                                    <h4 class="mb-0">
                                        <span class="counter-value">{{item.total}}</span>
                                    </h4>
                                </div>
                                <div class="flex-shrink-0 align-self-end" v-if="index != 0">
                                    <apexchart class="apex-charts" height="40" width="100" type="area" dir="ltr" :series="item.series" :options="chartOptions"></apexchart>
                                </div>
                            </div>
                        </b-card-body>
                    </b-card>
                </b-col>
            </div>
        </div>
        <div class="col-md-3 mt-n2">
            <div class="card shadow-none border">
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height:2.5rem;width:2.5rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-spy-fill text-primary fs-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-14"><span class="text-body">Request Monitoring & Alerts</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">Highlights urgency and updates</p>
                        </div>
                        <div class="flex-shrink-0">
                            <!-- <div class="mt-1">
                                <button @click="openView()" class="btn btn-sm btn-soft-success me-1" type="button" data-original-title="View All">
                                    <i class="ri-eye-fill align-bottom"></i>
                                </button>
                                <button class="btn btn-sm btn-soft-info" type="button" data-original-title="View PDF">
                                    <i class="ri-printer-fill align-bottom"></i>
                                </button>
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="card bg-white border-bottom shadow-none" no-body>
                    <!-- <b-list-group flush>
                        <BListGroupItem @click="filterReminder(list.name)" v-for="(list,index) in dropdowns.reminders" v-bind:key="index" style="cursor: pointer;" :class="(isActive(list.name)) ? 'bg-info-subtle' : ''">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="avatar-xs">
                                        <div class="avatar-title rounded" :class="list.color">
                                        <i class="fs-15" :class="list.icon"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-0 fs-12">{{list.name}}</h5>
                                    <p class="mb-0 fs-11 text-muted">{{list.description}}</p>
                                </div>
                                <span class="text-muted fs-12">{{reminder(index)}} </span>
                            </div>
                        </BListGroupItem>
                    </b-list-group> -->
                </div>
                <div class="card bg-white shadow-none" no-body style="height: calc(100vh - 762px)">

                </div>
            </div>
        </div>
        <div class="col-md-9 mt-n2">
            <div class="card bg-light-subtle shadow-none border">
               
            </div>
        </div>
    </b-row>
</template>
<script>
import Multiselect from "@vueform/multiselect";
import PageHeader from '@/Shared/Components/PageHeader.vue';
export default {
    components: { PageHeader, Multiselect },
    props: ['dropdowns','counts','years'],
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
            activeList: null,
            laboratory: null
        }
    },
    watch: {
        laboratory(newId) {
            this.updateLaboratoryTotal(newId);
            this.$refs.lists.updateData(newId);
        },
    },
    computed: {
        total() {
            // if (this.laboratory === null) {
            //     const selectedLab = this.counts[0].total.reduce((sum, lab) => sum + lab.total, 0);
            //     return this.formatMoney(selectedLab);
            // } else {
            //     const selectedLab = this.counts[0].total.find(lab => lab.id === this.laboratory.value);
              
            //     return this.formatMoney(selectedLab.total);
            // }\
            return 0;
        },
    },
    methods: {
      
        // formatMoney(value) {
        //     let val = (value / 1).toFixed(2).replace(',', '.');
        //     return '₱' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        // },
    }
}
</script>