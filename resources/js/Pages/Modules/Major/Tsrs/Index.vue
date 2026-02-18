<template>
<Head title="Technical Service Requests"/>
    <PageHeader title="TSR Management" pageTitle="Laboratory" />
    <BRow>
        <div class="col-md-12">
            <div class="card bg-light-subtle shadow-none border">
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height:2.5rem;width:2.5rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-hand-coin-fill text-primary fs-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-14"><span class="text-body">List of Technical Service Requests</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">Generate and track quotations for lab services requested by customers.</p>
                        </div>
                        <div class="flex-shrink-0" style="width: 45%;">
                            
                        </div>
                    </div>
                </div>
                <div class="car-body bg-white border-bottom shadow-none">
                    <b-row class="mb-2 ms-1 me-1" style="margin-top: 12px;">
                        <b-col lg>
                            <div class="input-group mb-1">
                                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                                <input type="text" v-model="filter.keyword" placeholder="Search Request" class="form-control" style="width: 20%;">
                                <input v-if="filter.datetype" type="date" v-model="filter.date" placeholder="Search Request" class="form-control" style="width: 100px;">
                                <Multiselect class="white" style="width: 15%;" :options="dates" v-model="filter.datetype" label="name" :allow-empty="false" :searchable="true" placeholder="Filter by date" />
                                <Multiselect class="white" style="width: 15%;" :options="dropdowns.laboratories" v-model="filter.laboratory" label="name" :allow-empty="false" :searchable="true" placeholder="Select Laboratory" />
                                <Multiselect class="white" style="width: 10%;" :options="['Local','Referral']" v-model="filter.type" label="name" :allow-empty="false" :searchable="true" placeholder="Select Type" />
                                <span @click="filterAddress()" class="input-group-text" v-b-tooltip.hover title="Filter by Address" style="cursor: pointer;"> 
                                    <i class="bx bxs-map search-icon" :class="{'bx-tada text-danger': hasAddressFilter}"></i>
                                </span>
                                <span @click="refresh()" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;"> 
                                    <i class="bx bx-refresh search-icon"></i>
                                </span>
                                <b-button type="button" variant="primary" @click="openCreate">
                                    <i class="ri-add-circle-fill align-bottom me-1"></i> Create
                                </b-button>
                            </div>
                        </b-col>
                    </b-row>
                </div>
                <div class="card bg-white border-bottom shadow-none" no-body>
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <ul class="nav nav-tabs nav-tabs-custom nav-primary fs-12" role="tablist">
                                <li class="nav-item">
                                    <BLink @click="viewStatus(null,null)" class="nav-link py-3 active" data-bs-toggle="tab" role="tab" aria-selected="true">
                                    <i class="ri-apps-2-fill me-1 align-bottom"></i> All Requests
                                    </BLink>
                                </li>
                                <li class="nav-item" v-for="(list,index) in dropdowns.statuses" v-bind:key="index">
                                    <BLink @click="viewStatus(index,list.value)" class="nav-link py-3" :class="(this.index == index) ? list.others+' active' : ''" data-bs-toggle="tab" role="tab" aria-selected="false">
                                        <i :class="icons[index]" class="me-1 align-bottom"></i>
                                        {{ list.name }} <BBadge v-if="counts[index] > 0" :class="list.color" class="align-middle ms-1">{{counts[index]}}</BBadge>
                                    </BLink>
                                </li>
                            </ul>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="d-flex flex-wrap gap-2 mt-3">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body bg-white rounded-bottom">
                    <div class="table-responsive table-card" style="margin-top: -39px; height: calc(100vh - 465px); overflow: auto;">
                        <table class="table align-middle table-centered table-striped mb-0">
                            <thead class="table-light thead-fixed">
                                <tr class="fs-11">
                                    <th style="width: 4%;"></th>
                                    <th>Customer</th>
                                    <!-- <th style="width: 7%;" class="text-center">Progress</th> -->
                                    <th style="width: 10%;" class="text-center">Total</th>
                                    <th style="width: 7%;" class="text-center">Payment</th>
                                    <th style="width: 15%;" class="text-center">Date Request</th>
                                    <th style="width: 13%;" class="text-center">Due Date</th>
                                    <th style="width: 7%;" class="text-center">Status</th>
                                    <th style="width: 4%;"></th>
                                </tr>
                            </thead>
                              <!-- :class="{
                                        'bg-dark-subtle': selectedRow === index && list.status.name !== 'Completed' && !isDueApproaching(list.due_at, list.status.name) && !isOverdue(list.due_at),
                                        'bg-success-subtle': list.status.name === 'Completed',
                                        'bg-warning-subtle': isDueApproaching(list.due_at, list.status.name),
                                        'bg-danger-subtle': isOverdue(list.due_at,list.status.name)
                                }" -->
                            <tbody>
                             
                                <tr class="ribbon-box" v-for="(list,index) in lists" v-bind:key="index" @click="selectRow(index)" 
                                    :class="filter.status === null ? {
                                        'bg-success-subtle': list.status.name === 'Completed',
                                        'bg-info-subtle': list.status.name === 'Ongoing',
                                        'bg-warning-subtle': list.status.name === 'Payment',
                                        'bg-danger-subtle': list.status.name === 'Cancelled'
                                    } : ''">
                                     
                                    <td class="text-center"> 
                                        <div v-if="list.is_referral" class="ribbon-two ribbon-two-primary"><span style="font-size: 8px;">Referral</span></div>
                                        {{ (meta.current_page - 1) * meta.per_page + index + 1 }}.
                                    </td>
                                    <td>
                                        <h5 v-if="list.code" class="fs-13 mb-0 fw-semibold text-primary">{{list.code}}</h5>
                                        <h5 v-else class="fs-13 mb-0 text-muted">Not yet available</h5>
                                        <p class="fs-12 text-muted mb-0">{{list.customer}}</p>
                                    </td>
                                    <!-- <td>
                                        <apexchart v-b-tooltip.hover :title="list.analyses+'%'" class="apex-charts" height="30" dir="ltr" :series="[list.analyses]" :options="{ ...chartOptions }"></apexchart>
                                    </td> -->
                                    <td class="text-center">{{list.payment.total}}</td>
                                    <td class="text-center">
                                        <i v-if="list.payment.is_paid" class="ri-checkbox-circle-fill text-success fs-18" v-b-tooltip.hover :title="list.payment.status.name"></i>
                                        <i v-else-if="list.payment.is_free" class="ri-checkbox-circle-fill text-info fs-18" v-b-tooltip.hover title="Gratis"></i>
                                        <i v-else-if="list.payment.status.name == 'Contract'" class="ri-information-fill text-warning fs-18" v-b-tooltip.hover title="Contract w/ MOA"></i>
                                        <i v-else class="ri-close-circle-fill text-danger fs-18" v-b-tooltip.hover :title="list.payment.status.name"></i>
                                    </td>
                                    <td class="text-center fs-12">{{list.created_at}}</td>
                                    <td class="text-center fs-12">
                                        <span v-if="list.due_at">{{list.due_at}}</span>
                                        <span class="text-muted" v-else>Not yet set</span>
                                    </td>
                                    <td class="text-center">
                                        <span :class="'badge '+list.status.color">{{list.status.name}}</span>
                                    </td>
                                    <td class="text-end">
                                        <!-- <a :href="`/tsrs/${list.qr}`" target="_blank">
                                            <b-button :variant="(filter.status) ? 'soft-info' : 'info'"  class="me-1" v-b-tooltip.hover title="View" size="sm">
                                                <i class="ri-eye-fill align-bottom"></i>
                                            </b-button>
                                        </a>
                                        <b-button @click="openPrint(list.qr)" v-if="list.status.name != 'Pending'" :variant="(filter.status) ? 'soft-success' : 'success'" class="me-1" v-b-tooltip.hover title="Print" size="sm">
                                            <i class="ri-printer-fill align-bottom"></i>
                                        </b-button> -->
                                        <div class="d-flex gap-3 justify-content-center">
                                            <div class="dropdown">
                                                <BDropdown variant="link" toggle-class="btn btn-light btn-sm dropdown"  strategy="fixed" no-caret menu-class="dropdown-menu-end" :offset="{ alignmentAxis: -130, crossAxis: 0, mainAxis: 10 }"> 
                                                    <template #button-content> 
                                                        <i class="ri-more-fill"></i>
                                                    </template>
                                                    <li>
                                                         <a :href="`/tsrs/${list.reference}`" target="_blank" class="dropdown-item d-flex align-items-center" role="button">
                                                            <i class="ri-eye-line me-2"></i> View
                                                         </a>
                                                    </li>
                                                    <li>
                                                        <a @click="openPrint(list.reference)" class="dropdown-item d-flex align-items-center" role="button">
                                                            <i class="ri-printer-line me-2"></i>Print
                                                        </a>
                                                    </li>
                                                    <!-- <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <a @click="openRole(list,index)" class="dropdown-item d-flex align-items-center" role="button">
                                                            <i class="ri-calendar-fill me-2"></i>Update Date
                                                        </a>
                                                    </li> -->
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <a @click="openActivation('activation',list,index)" class="dropdown-item d-flex align-items-center" :class="(list.is_active) ? 'text-danger' : 'text-success'" href="#removeFileItemModal" data-id="1" data-bs-toggle="modal" role="button">
                                                            <span v-if="list.is_active"><i class="ri-lock-2-fill me-2"></i> Deactivate</span>
                                                            <span v-else><i class="ri-lock-unlock-line me-2"></i> Activate</span>
                                                        </a>
                                                    </li>
                                                </BDropdown>
                                            </div>
                                        </div>
                                    </td>
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
    </BRow>
    <Filter @submit="handleSubmit" :regions="dropdowns.regions" :region="region" ref="filter"/>
    <Edit @update="updateData" :dropdowns="dropdowns" ref="edit"/>
    <Cancel @update="updateData" ref="cancel"/>
    <Create :dropdowns="dropdowns" :facility="facility" @success="moveTo" ref="create"/>
</template>
<script>
import _ from 'lodash';
import Edit from './Modals/Edit.vue';
import Cancel from './Modals/Cancel.vue';
import Create from './Modals/Create.vue';
import Filter from './Modals/Filter.vue';
import Multiselect from "@vueform/multiselect";
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { PageHeader, Pagination, Multiselect, Create, Cancel, Edit, Filter },
    props: ['counts','dropdowns','region','facility'],
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            index: null,
            filter: {
                keyword: null,
                status: null,
                laboratory: null,
                sortby: 'Requested At',
                sort: 'desc',
                datetype: null,
                date: null,
                type: null
            },
            location: {
                region: null,
                province: null,
                municipality: null,
                province: null
            },
            dates: [
                {'value' : 'due_at', 'name' : 'Due Date'},
                {'value' : 'created_at', 'name' : 'Request Date'},
            ],
            icons: ['ri-information-line','ri-wallet-3-line','ri-indeterminate-circle-line','ri-checkbox-circle-line','ri-close-circle-line','ri-pin-distance-fill'],
            chartOptions: {
                chart: {
                type: "radialBar",
                    sparkline: {
                        enabled: true,
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                plotOptions: {
                    radialBar: {
                        hollow: {
                            margin: 0,
                            size: "30%",
                        },
                        track: {
                            margin: 1,
                        },
                        dataLabels: {
                            show: false,
                        },
                    },
                },
                colors: ["#099885"],
            },
            selectedRow: null,
        }
    },
    watch: {
        "filter.keyword"(newVal){
            this.checkSearchStr(newVal)
        },
        "filter.date"(newVal){
            this.fetch();
        },
        "filter.datetype"(newVal){
            if(this.filter.date){
                this.fetch();
            }
        },
        "filter.laboratory"(newVal){
            this.fetch();
        },
        "filter.type"(newVal){
            this.fetch();
        }
    },
    computed: {
        hasAddressFilter() {
            return ['province', 'municipality', 'barangay']
            .some(key => this.location[key] && this.location[key] !== '');
        }
    },
    created(){
        this.fetch();
    },
    methods: {
        checkSearchStr: _.debounce(function(string) {
            this.fetch();
        }, 300),
        fetch(page_url){
            page_url = page_url || '/tsrs';
            axios.get(page_url,{
                params : {
                    keyword: this.filter.keyword,
                    status: this.filter.status,
                    sortby: this.filter.sortby,
                    sort: this.filter.sort,
                    date: this.filter.date,
                    datetype: this.filter.datetype,
                    laboratory: this.filter.laboratory,
                    region: this.location.region,
                    province: this.location.province,
                    municipality: this.location.municipality,
                    barangay: this.location.barangay,
                    type: this.filter.type,
                    count: 10,
                    option: 'lists'
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
        viewStatus(index,status){
            this.index = index;
            this.filter.status = status;
            this.fetch();
        },
        selectRow(index) {
            this.selectedRow = index;
        },
        isDueApproaching(dueDate, status) {
            if (!dueDate || status !== 'Ongoing') return false; // Only check if status is 'Ongoing'
            const today = new Date();
            const due = new Date(dueDate);
            const diffTime = due - today;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            return diffDays <= 5 && diffDays >= 0; // True if due date is within 5 days
        },
        isOverdue(dueDate,status) {
            if(status != 'Completed'){
                if (!dueDate) return false; // If no due date, return false
                const today = new Date();
                const due = new Date(dueDate);
                return due <= today; // True if the due date is today or earlier (overdue)
            }
        },
        openCreate(){
            this.$refs.create.show(this.region);
        },
        openCancel(data,index){
            this.index = index;
            this.$refs.cancel.show(data);
        },
        openEdit(data,index){
            this.index = index;
            this.$refs.edit.show(data);
        },
        openPrint(id){
            window.open('/tsrs?option=print&id='+id);
        },
        updateData(data){
            this.lists[this.index] = data;
        },
        filterAddress(){
            this.$refs.filter.show();
        },
        moveTo(data){
            this.fetch();
            window.open(`/tsrs/${data}`, '_blank');
        },
        handleSubmit(data) {
            this.location.region       = data?.form?.region       ?? null;
            this.location.province     = data?.form?.province?.value     ?? null;
            this.location.municipality = data?.form?.municipality?.value ?? null;
            this.location.barangay     = data?.form?.barangay?.value     ?? null;
            this.fetch();
        },
       refresh() {
            this.location.region       = null;
            this.location.province     = null;
            this.location.municipality = null;
            this.location.barangay     = null; 

            this.filter = {
                keyword: null,
                status: null,
                laboratory: null,
                sortby: 'Requested At',
                sort: 'desc',
                datetype: null,
                date: null
            };
        }
    }
}
</script>