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
                            <p class="text-muted text-truncate-two-lines fs-12">Monitor TSRs across all agencies and facilities, filterable by region.</p>
                        </div>
                    </div>
                </div>
                <div class="car-body bg-white border-bottom shadow-none">
                    <b-row class="mb-2 ms-1 me-1" style="margin-top: 12px;">
                        <b-col lg>
                            <div class="input-group mb-1">
                                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                                <input type="text" v-model="filter.keyword" placeholder="Search TSR code or customer" class="form-control" style="width: 25%;">
                                <Multiselect class="white" style="width: 20%;" :options="dropdowns.regions" v-model="filter.region" label="name" :searchable="true" placeholder="Select Region" />
                                <Multiselect class="white" style="width: 20%;" :options="dropdowns.statuses" v-model="filter.status" label="name" :searchable="true" placeholder="Select Status" />
                                <Multiselect class="white" style="width: 12%;" :options="dropdowns.years" v-model="filter.year" label="name" :searchable="true" placeholder="Select Year" />
                                <span @click="refresh()" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;">
                                    <i class="bx bx-refresh search-icon"></i>
                                </span>
                            </div>
                        </b-col>
                    </b-row>
                </div>
                <div class="card-body bg-white rounded-bottom">
                    <div class="table-responsive table-card" style="height: calc(100vh - 430px); overflow: auto;">
                        <table class="table align-middle table-centered table-striped mb-0">
                            <thead class="table-light thead-fixed">
                                <tr class="fs-11">
                                    <th style="width: 3%;"></th>
                                    <th style="width: 12%;">TSR Code</th>
                                    <th>Customer</th>
                                    <th style="width: 14%;">Agency / Facility</th>
                                    <th style="width: 10%;" class="text-center">Region</th>
                                    <th style="width: 12%;" class="text-center">Date Requested</th>
                                    <th style="width: 12%;" class="text-center">Due Date</th>
                                    <th style="width: 9%;" class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="table-white fs-12" v-if="lists.length > 0">
                                <tr v-for="(list,index) in lists" v-bind:key="list.id">
                                    <td>{{ (meta.current_page - 1) * meta.per_page + index + 1 }}.</td>
                                    <td class="fw-semibold">{{ list.code }}</td>
                                    <td>{{ list.customer }}</td>
                                    <td>
                                        <span class="d-block">{{ list.agency?.name || '-' }}</span>
                                        <span class="d-block text-muted fs-11">{{ list.facility?.name || '-' }}</span>
                                    </td>
                                    <td class="text-center">{{ list.facility?.region?.region || '-' }}</td>
                                    <td class="text-center">{{ list.created_at }}</td>
                                    <td class="text-center">{{ list.due_at || '-' }}</td>
                                    <td class="text-center">
                                        <span class="badge" :class="list.status?.color">{{ list.status?.name }}</span>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="8" class="text-center text-muted">No TSRs found.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <Pagination class="ms-2 me-2 mt-n1" v-if="meta.total" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
                </div>
            </div>
        </div>
    </BRow>
</template>
<script>
import _ from 'lodash';
import Multiselect from "@vueform/multiselect";
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { PageHeader, Pagination, Multiselect },
    props: ['dropdowns'],
    data(){
        return {
            lists: [],
            meta: {},
            links: {},
            filter: {
                keyword: null,
                region: null,
                status: null,
                year: null,
            },
        }
    },
    watch: {
        "filter.region"(){ this.fetch(); },
        "filter.status"(){ this.fetch(); },
        "filter.year"(){ this.fetch(); },
        "filter.keyword"(newVal){ this.checkSearchStr(newVal); }
    },
    created(){
        this.fetch();
    },
    methods: {
        checkSearchStr: _.debounce(function(){
            this.fetch();
        }, 300),
        fetch(page_url){
            page_url = page_url || '/tsrs-overview';
            axios.get(page_url,{
                params : {
                    option: 'list',
                    keyword: this.filter.keyword,
                    region: this.filter.region,
                    status: this.filter.status,
                    year: this.filter.year,
                    count: 20
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
        refresh(){
            this.filter.keyword = null;
            this.filter.region = null;
            this.filter.status = null;
            this.filter.year = null;
            this.fetch();
        }
    }
}
</script>
