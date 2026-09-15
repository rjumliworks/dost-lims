<template>
<Head title="TSRs by Region"/>
    <PageHeader title="TSR Overview" pageTitle="TSRs by Region" />
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
                            <p class="text-muted text-truncate-two-lines fs-12">Monitor TSRs across all agencies and facilities, filterable and sortable by region or agency.</p>
                        </div>
                    </div>
                </div>
                <div class="car-body bg-white border-bottom shadow-none">
                    <b-row class="mb-2 ms-1 me-1" style="margin-top: 12px;">
                        <b-col lg>
                            <div class="input-group mb-1">
                                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                                <input type="text" v-model="filter.keyword" placeholder="Search TSR, sample code or customer" class="form-control" style="width: 10%;">
                                <input v-if="filter.datetype" type="date" v-model="filter.date" placeholder="Search Request" class="form-control" style="width: 100px;">
                                <Multiselect class="white" style="width: 13%;" :options="dates" v-model="filter.datetype" label="name" :allow-empty="false" :searchable="true" placeholder="Filter by date" />
                                <Multiselect v-if="filter.laboratory == 3" class="white" style="width: 13%;" :options="['In-house','On-site']" v-model="filter.subtype" label="name" :allow-empty="false" :searchable="true" placeholder="Select Location" />
                                <Multiselect class="white" style="width: 13%;" :options="dropdowns.laboratories" v-model="filter.laboratory" label="name" :allow-empty="false" :searchable="true" placeholder="Select Laboratory" />
                                <Multiselect class="white" style="width: 13%;" :options="dropdowns.agencies" v-model="filter.agency" label="name" object :allow-empty="false" :searchable="true" placeholder="Select Agency" />
                                <Multiselect v-if="facilities.length > 0" class="white" style="width: 13%;" :options="facilities" v-model="filter.facility" label="name" :allow-empty="false" :searchable="true" placeholder="Select Facility" />
                                <Multiselect class="white" style="width: 7%;" :options="dropdowns.years" v-model="filter.year" :allow-empty="false" :searchable="true" placeholder="Select Year" />
                                <Multiselect class="white" style="width: 12%;" :options="sortOptions" v-model="filter.sortby" label="name" :allow-empty="false" :searchable="false" placeholder="Sort By" />
                                <span @click="toggleSort()" class="input-group-text" v-b-tooltip.hover :title="filter.sort === 'asc' ? 'Ascending' : 'Descending'" style="cursor: pointer;">
                                    <i class="bx" :class="filter.sort === 'asc' ? 'bx-sort-up' : 'bx-sort-down'"></i>
                                </span>
                                <span @click="refresh()" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;">
                                    <i class="bx bx-refresh search-icon"></i>
                                </span>
                                <b-button @click="$refs.syncModal.show()" variant="primary" v-b-tooltip.hover title="Sync a range of TSRs to refresh their printed version">
                                    <i class="ri-refresh-line align-bottom me-1"></i> Sync Printed TSRs
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
                                <li class="nav-item" v-for="(list,statusIndex) in dropdowns.statuses" v-bind:key="statusIndex">
                                    <BLink @click="viewStatus(statusIndex,list.value)" class="nav-link py-3" :class="(this.index == statusIndex) ? list.others+' active' : ''" data-bs-toggle="tab" role="tab" aria-selected="false">
                                        <i :class="icons[statusIndex]" class="me-1 align-bottom"></i>
                                        {{ list.name }} <BBadge v-if="counts[statusIndex] > 0" :class="list.color" class="align-middle ms-1">{{counts[statusIndex]}}</BBadge>
                                    </BLink>
                                </li>
                                <li class="nav-item ms-auto">
                                    <BLink href="javascript:void(0)" @click="viewType('Local')" class="nav-link py-3" :class="filter.type === 'Local' ? 'active' : ''" role="button" aria-selected="false">
                                        <i class="ri-map-pin-line me-1 align-bottom"></i> Local <BBadge v-if="typeCounts.Local > 0" class="bg-primary-subtle text-primary align-middle ms-1">{{ typeCounts.Local }}</BBadge>
                                    </BLink>
                                </li>
                                <li class="nav-item">
                                    <BLink href="javascript:void(0)" @click="viewType('Referral')" class="nav-link py-3" :class="filter.type === 'Referral' ? 'active' : ''" role="button" aria-selected="false">
                                        <i class="ri-share-forward-line me-1 align-bottom"></i> Referral <BBadge v-if="typeCounts.Referral > 0" class="bg-primary-subtle text-primary align-middle ms-1">{{ typeCounts.Referral }}</BBadge>
                                    </BLink>
                                </li>
                            </ul>
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
                                    <th style="width: 16%;">Agency / Facility</th>
                                    <th style="width: 10%;" class="text-center">Total</th>
                                    <th style="width: 6%;" class="text-center">Payment</th>
                                    <th style="width: 13%;" class="text-center">Date Request</th>
                                    <th style="width: 12%;" class="text-center">Due Date</th>
                                    <th style="width: 7%;" class="text-center">Status</th>
                                    <th style="width: 6%;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="lists.length == 0" style="height: calc(100vh - 506px);">
                                    <td colspan="9" class="text-center">
                                        <div class="d-flex flex-column align-items-center py-4">
                                            <div class="avatar-lg mb-3">
                                                <div class="avatar-title bg-light rounded-circle text-muted">
                                                    <i class="ri-file-list-3-line fs-24"></i>
                                                </div>
                                            </div>
                                            <h5 class="mb-1">No TSRs found</h5>
                                            <p class="text-muted mb-0">Try adjusting your search or filter to find what you're looking for.</p>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="ribbon-box" v-for="(list,index) in lists" v-bind:key="list.id" @click="selectRow(index)"
                                    :class="filter.status === null ? {
                                        'bg-success-subtle': list.status.name === 'Completed',
                                        'bg-info-subtle': list.status.name === 'Ongoing',
                                        'bg-warning-subtle': list.status.name === 'Payment',
                                        'bg-danger-subtle': list.status.name === 'Cancelled',
                                        'bg-dark-subtle fw-semibold': selectedRow === index
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
                                    <td>
                                        <span class="d-block">{{ list.agency?.name || '-' }}</span>
                                        <span class="d-block text-muted fs-11">{{ list.facility?.name || '-' }}</span>
                                    </td>
                                    <td class="text-center">{{list.payment.total}}</td>
                                    <td class="text-center">
                                        <i v-if="list.payment.is_paid" class="ri-checkbox-circle-fill text-success fs-18" v-b-tooltip.hover :title="list.payment.status.name"></i>
                                        <i v-else-if="list.payment.is_free" class="ri-checkbox-circle-fill text-info fs-18" v-b-tooltip.hover title="Gratis"></i>
                                        <i v-else-if="list.payment.status.name == 'Contract'" class="ri-information-fill text-warning fs-18" v-b-tooltip.hover title="Contract w/ MOA"></i>
                                        <i v-else-if="list.payment.status.name == 'Online'" class="ri-information-fill text-warning fs-18" v-b-tooltip.hover title="Online Payment"></i>
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
                                        <a :href="`/tsrs/${list.reference}`" target="_blank">
                                            <b-button :variant="(filter.status) ? 'soft-info' : 'info'" class="me-1" v-b-tooltip.hover title="View" size="sm">
                                                <i class="ri-eye-fill align-bottom"></i>
                                            </b-button>
                                        </a>
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
    <Sync ref="syncModal" @success="fetch()"/>
</template>
<script>
import _ from 'lodash';
import Multiselect from "@vueform/multiselect";
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
import Sync from './Modals/Sync.vue';
export default {
    components: { PageHeader, Pagination, Multiselect, Sync },
    props: ['dropdowns'],
    data(){
        return {
            lists: [],
            meta: {},
            links: {},
            counts: [],
            typeCounts: {},
            index: null,
            selectedRow: null,
            filter: {
                keyword: null,
                status: null,
                laboratory: null,
                agency: null,
                facility: null,
                sortby: 'Requested At',
                sort: 'desc',
                datetype: null,
                date: null,
                type: null,
                subtype: null,
                year: new Date().getFullYear()
            },
            dates: [
                {'value' : 'due_at', 'name' : 'Due Date'},
                {'value' : 'created_at', 'name' : 'Request Date'},
            ],
            sortOptions: [
                {'value' : 'Requested At', 'name' : 'Requested At'},
                {'value' : 'Due Date', 'name' : 'Due Date'},
                {'value' : 'Region', 'name' : 'Region'},
                {'value' : 'Agency', 'name' : 'Agency'},
            ],
            icons: ['ri-information-line','ri-wallet-3-line','ri-indeterminate-circle-line','ri-checkbox-circle-line','ri-close-circle-line','ri-hand-coin-fill'],
        }
    },
    computed: {
        facilities(){
            return this.filter.agency?.facilities || [];
        }
    },
    watch: {
        "filter.keyword"(newVal){
            this.checkSearchStr(newVal)
        },
        "filter.date"(newVal){ this.fetch(); },
        "filter.datetype"(newVal){
            if(this.filter.date){
                this.fetch();
            }
        },
        "filter.subtype"(newVal){ this.fetch(); },
        "filter.laboratory"(newVal){ this.fetch(); },
        "filter.agency"(newVal){
            this.filter.facility = null;
            this.fetch();
        },
        "filter.facility"(newVal){ this.fetch(); },
        "filter.year"(newVal){ this.fetch(); },
        "filter.type"(newVal){ this.fetch(); },
        "filter.sortby"(newVal){ this.fetch(); },
        "filter.sort"(newVal){ this.fetch(); }
    },
    created(){
        this.fetch();
    },
    methods: {
        checkSearchStr: _.debounce(function(string) {
            this.fetch();
        }, 300),
        fetch(page_url){
            page_url = page_url || '/tsrs-overview';
            axios.get(page_url,{
                params : {
                    keyword: this.filter.keyword,
                    status: this.filter.status,
                    sortby: this.filter.sortby,
                    sort: this.filter.sort,
                    date: this.filter.date,
                    datetype: this.filter.datetype,
                    laboratory: this.filter.laboratory,
                    agency: this.filter.agency?.value,
                    facility: this.filter.facility,
                    type: this.filter.type,
                    year: this.filter.year,
                    subtype: this.filter.subtype,
                    count: 10,
                    option: 'list'
                }
            })
            .then(response => {
                if(response){
                    this.lists = response.data.data;
                    this.meta = response.data.meta;
                    this.links = response.data.links;
                    this.counts = response.data.summary;
                    this.typeCounts = response.data.typeCounts;
                }
            })
            .catch(err => console.log(err));
        },
        viewStatus(index,status){
            this.index = index;
            this.filter.status = status;
            this.fetch();
        },
        viewType(type){
            this.filter.type = (this.filter.type === type) ? null : type;
        },
        toggleSort(){
            this.filter.sort = this.filter.sort === 'asc' ? 'desc' : 'asc';
        },
        selectRow(index) {
            this.selectedRow = index;
        },
        refresh(){
            this.index = null;
            this.selectedRow = null;
            this.filter = {
                keyword: null,
                status: null,
                laboratory: null,
                agency: null,
                facility: null,
                sortby: 'Requested At',
                sort: 'desc',
                datetype: null,
                date: null,
                type: null,
                subtype: null,
                year: new Date().getFullYear()
            };
            this.fetch();
        }
    }
}
</script>
