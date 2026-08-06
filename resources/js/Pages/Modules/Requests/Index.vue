<template>
<Head title="Update Requests"/>
    <PageHeader title="Update Requests" pageTitle="Laboratory" />
    <BRow>
        <div class="col-md-12">
            <div class="card bg-light-subtle shadow-none border">
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height:2.5rem;width:2.5rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-quill-pen-fill text-primary fs-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-14"><span class="text-body">List of Sample Update Requests</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">Technical Service Requests with sample description updates awaiting your review.</p>
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
                                <input type="text" v-model="filter.keyword" placeholder="Search TSR Code" class="form-control" style="width: 20%;">
                                <span @click="refresh()" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;">
                                    <i class="bx bx-refresh search-icon"></i>
                                </span>
                            </div>
                        </b-col>
                    </b-row>
                </div>
                <div class="card bg-white border-bottom shadow-none" no-body>
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <ul class="nav nav-tabs nav-tabs-custom nav-primary fs-12" role="tablist">
                                <li class="nav-item" v-for="(list,index) in dropdowns.statuses" v-bind:key="index">
                                    <BLink @click="viewStatus(index,list.value)" class="nav-link py-3" :class="(this.index == index) ? list.others+' active' : ''" data-bs-toggle="tab" role="tab" aria-selected="false">
                                        <i :class="icons[index]" class="me-1 align-bottom"></i>
                                        {{ list.name }} <BBadge v-if="counts[index] > 0" :class="list.color" class="align-middle ms-1">{{counts[index]}}</BBadge>
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
                                    <th>TSR / Customer</th>
                                    <th style="width: 15%;">Laboratory</th>
                                    <th style="width: 12%;" class="text-center">Requested Items</th>
                                    <th style="width: 18%;" class="text-center">Last Requested</th>
                                    <th style="width: 10%;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="lists.length == 0" style="height: calc(100vh - 506px);">
                                    <td colspan="6" class="text-center">
                                        <div class="d-flex flex-column align-items-center py-4">
                                            <div class="avatar-lg mb-3">
                                                <div class="avatar-title bg-light rounded-circle text-muted">
                                                    <i class="ri-file-list-3-line fs-24"></i>
                                                </div>
                                            </div>
                                            <h5 class="mb-1">No update requests found</h5>
                                            <p class="text-muted mb-0">Try adjusting your search or filter to find what you're looking for.</p>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-for="(list,index) in lists" v-bind:key="index">
                                    <td class="text-center">{{ (meta.current_page - 1) * meta.per_page + index + 1 }}.</td>
                                    <td>
                                        <h5 v-if="list.code" class="fs-13 mb-0 fw-semibold text-primary">{{list.code}}</h5>
                                        <h5 v-else class="fs-13 mb-0 text-muted">Not yet available</h5>
                                        <p class="fs-12 text-muted mb-0">{{list.customer?.fullname}}</p>
                                    </td>
                                    <td class="fs-12">{{list.laboratory?.name}}</td>
                                    <td class="text-center">
                                        <BBadge class="bg-primary-subtle text-primary">{{ itemCount(list) }} sample(s)</BBadge>
                                    </td>
                                    <td class="text-center fs-12">{{ list.latest_request_at ?? '-' }}</td>
                                    <td class="text-end">
                                        <b-button @click="openView(list)" variant="soft-info" v-b-tooltip.hover title="View & Review" size="sm">
                                            <i class="ri-eye-fill align-bottom"></i>
                                        </b-button>
                                    </td>
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
    <ViewRequest ref="view" @updated="fetch()"/>
</template>
<script>
import _ from 'lodash';
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
import ViewRequest from './Modals/View.vue';
export default {
    components: { PageHeader, Pagination, ViewRequest },
    props: ['dropdowns'],
    data(){
        return {
            lists: [],
            meta: {},
            links: {},
            counts: [],
            index: 0,
            filter: {
                keyword: null,
                status: null,
            },
            icons: ['ri-time-line','ri-checkbox-circle-line','ri-close-circle-line'],
        }
    },
    watch: {
        "filter.keyword"(){
            this.checkSearchStr();
        }
    },
    created(){
        this.viewStatus(0, this.dropdowns.statuses[0]?.value);
    },
    methods: {
        checkSearchStr: _.debounce(function() {
            this.fetch();
        }, 300),
        fetch(page_url){
            page_url = page_url || '/requests';
            axios.get(page_url,{
                params : {
                    keyword: this.filter.keyword,
                    status: this.filter.status,
                    count: 10,
                    option: 'lists'
                }
            })
            .then(response => {
                if(response){
                    this.lists = response.data.data;
                    this.meta = response.data.meta;
                    this.links = response.data.links;
                    this.counts = response.data.summary;
                }
            })
            .catch(err => console.log(err));
        },
        viewStatus(index,status){
            this.index = index;
            this.filter.status = status;
            this.fetch();
        },
        itemCount(list){
            return (list.samples || []).reduce((total,sample) => total + (sample.amendments?.length || 0), 0);
        },
        openView(list){
            this.$refs.view.show(list);
        },
        refresh(){
            this.filter.keyword = null;
            this.viewStatus(0, this.dropdowns.statuses[0]?.value);
        }
    }
}
</script>
