<template>
    <Head title="Customers by Region"/>
    <PageHeader title="Customer Overview" pageTitle="Customers by Region" />
    <BRow>
        <div class="col-md-12">
            <div class="card bg-light-subtle shadow-none border">
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height:2.5rem;width:2.5rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-team-fill text-primary fs-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-14"><span class="text-body">List of Customers</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">Monitor customers across all agencies, filterable by region.</p>
                        </div>
                    </div>
                </div>
                <div class="car-body bg-white border-bottom shadow-none">
                    <b-row class="mb-2 ms-1 me-1" style="margin-top: 12px;">
                        <b-col lg>
                            <div class="input-group mb-1">
                                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                                <input type="text" v-model="filter.keyword" placeholder="Search Customer" class="form-control" style="width: 30%;">
                                <Multiselect class="white" style="width: 20%;" :options="dropdowns.regions" v-model="filter.region" label="name" :searchable="true" placeholder="Select Region" />
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
                                    <th>Customer</th>
                                    <th style="width: 14%;">Agency</th>
                                    <th style="width: 12%;" class="text-center">Region</th>
                                    <th style="width: 14%;" class="text-center">Province</th>
                                    <th style="width: 12%;" class="text-center">Date Registered</th>
                                    <th style="width: 8%;" class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="table-white fs-12" v-if="lists.length > 0">
                                <tr v-for="(list,index) in lists" v-bind:key="list.id">
                                    <td>{{ (meta.current_page - 1) * meta.per_page + index + 1 }}.</td>
                                    <td class="fw-semibold">{{ list.name }}</td>
                                    <td>{{ list.agency?.name || '-' }}</td>
                                    <td class="text-center">{{ list.address?.region?.region || '-' }}</td>
                                    <td class="text-center">{{ list.address?.province?.name || '-' }}</td>
                                    <td class="text-center">{{ list.created_at }}</td>
                                    <td class="text-center">
                                        <span v-if="list.is_active" class="badge bg-success">Active</span>
                                        <span v-else class="badge bg-danger">Inactive</span>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No customers found.</td>
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
            },
        }
    },
    watch: {
        "filter.region"(){ this.fetch(); },
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
            page_url = page_url || '/customers-overview';
            axios.get(page_url,{
                params : {
                    option: 'list',
                    keyword: this.filter.keyword,
                    region: this.filter.region,
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
            this.fetch();
        }
    }
}
</script>
