<!-- <template>
    <Head title="Order of Payment"/>
    <PageHeader title="Order of Payments" pageTitle="List" />
    <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
        <div class="file-manager-content w-100 p-4 pb-0" style="height: calc(100vh - 180px); overflow: auto;" ref="box">
            <b-row class="g-2 mb-2 mt-n2">
                <b-col lg>
                    <div class="input-group mb-1">
                        <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                        <input type="text" v-model="filter.keyword" placeholder="Search Receipt" class="form-control" style="width: 40%;">
                        <Multiselect class="white" style="width: 15%;" :options="dropdowns.payments" v-model="filter.mode" label="name" :searchable="true" placeholder="Select Payment mode" />
                        <Multiselect class="white" style="width: 15%;" :options="dropdowns.statuses" v-model="filter.status" label="name" :searchable="true" placeholder="Select Status" />
                        <b-button @click="refresh()" type="button" variant="primary">
                            <i class="bx bx-refresh"></i> 
                        </b-button>
                    </div>
                </b-col>
            </b-row>
            <div class="table-responsive">
                <table class="table table-nowrap align-middle mb-0">
                    <thead class="table-light">
                        <tr class="fs-11">
                            <th></th>
                            <th style="width: 25%;">Customer</th>
                            <th style="width: 13%;" class="text-center">Collection</th>
                            <th style="width: 13%;" class="text-center">Payment</th>
                            <th style="width: 10%;" class="text-center">Total</th>
                            <th style="width: 15%;" class="text-center">User</th>
                            <th style="width: 10%;" class="text-center">Date</th>
                            <th style="width: 7%;" class="text-center">Status</th>
                            <th style="width: 7%;" ></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(list,index) in lists" v-bind:key="index">
                            <td class="text-center"> 
                                {{ (meta.current_page - 1) * meta.per_page + index + 1 }}.
                            </td>
                            <td>
                                <h5 class="fs-13 mb-0 text-dark" v-if="list.or">{{list.code}} <span class="text-muted">(OR# : {{list.or.number}})</span></h5>
                                <h5 class="fs-13 mb-0 text-dark" v-else>{{list.code}}</h5>
                                <p class="fs-13 text-muted mb-0">{{list.payorable.name}}</p>
                            </td>
                            <td class="text-center fs-13">{{list.collection}}</td>
                            <td class="text-center fs-13">{{list.payment.name}}</td>
                            <td class="text-center fs-13">{{list.total}}</td>
                            <td class="text-center fs-13">{{list.user}}</td>
                            <td class="text-center fs-13">{{list.date}}</td>
                            <td class="text-center">
                                <span :class="'badge '+list.status.color+' '+list.status.others">{{list.status.name}}</span>
                            </td>
                            <td class="text-end">
                                <b-button @click="openView(list)" variant="soft-info" class="me-1" v-b-tooltip.hover title="View" size="sm">
                                    <i class="ri-eye-fill align-bottom"></i>
                                </b-button>
                                <b-button @click="openPrint(list.id)" variant="soft-success" class="me-1" v-b-tooltip.hover title="Print" size="sm">
                                    <i class="ri-printer-fill align-bottom"></i>
                                </b-button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <Pagination class="ms-2 me-2" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
            </div>
        </div>
    </div>
    <View @update="fetch()" ref="view"/>
</template>
<script>
import _ from 'lodash';
import View from './Modals/View.vue';
import Multiselect from "@vueform/multiselect";
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { PageHeader, Pagination, Multiselect, View },
    props: ['dropdowns'],
    data(){
        return {
            lists: [],
            meta: {},
            links: {},
            filter: {
                keyword: null,
                mode: null,
                status: null
            },
            index: null
        }
    },
    watch: {
        "filter.keyword"(newVal){
            this.checkSearchStr(newVal);
        },
        "filter.mode"(newVal){
            this.fetch();
        },
        "filter.status"(newVal){
            this.fetch();
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
            page_url = page_url || '/orderofpayments';
            axios.get(page_url,{
                params : {
                    keyword: this.filter.keyword,
                    status: this.filter.status,
                    mode: this.filter.mode,
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
        openView(data){
            this.$refs.view.show(data);
        },
        openPrint(id){
            window.open(this.currentUrl + '/orderofpayments?option=print&id='+id);
        },
    }
}
</script> -->
<template>
    <Head title="Order of Payment"/>
        <PageHeader title="Order of Payments" pageTitle="Laboratory" />
        <BRow>
            <div class="col-md-12">
                <div class="card bg-light-subtle shadow-none border">
                    <div class="card-header bg-light-subtle">
                        <div class="d-flex mb-n3">
                            <div class="flex-shrink-0 me-3">
                                <div style="height:2.5rem;width:2.5rem;">
                                    <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                        <i class="ri-price-tag-2-fill text-primary fs-24"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-0 fs-14"><span class="text-body">List of Order of Payments</span></h5>
                                <p class="text-muted text-truncate-two-lines fs-12">Manage and view all receipt records for laboratory transactions</p>
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
                                    <input type="text" v-model="filter.keyword" placeholder="Search Request" class="form-control" style="width: 40%;">
                                    <input v-if="filter.datetype" type="date" v-model="filter.date" placeholder="Search Request" class="form-control" style="width: 100px;">
                                    <Multiselect class="white" style="width: 15%;" :options="dropdowns.payments" v-model="filter.mode" label="name" :searchable="true" placeholder="Select Payment mode" />
                                    <Multiselect class="white" style="width: 15%;" :options="dropdowns.statuses" v-model="filter.status" label="name" :searchable="true" placeholder="Select Status" />
                                    <span @click="refresh()" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;"> 
                                        <i class="bx bx-refresh search-icon"></i>
                                    </span>
                                    <b-button type="button" variant="primary" @click="openCreate">
                                        <i class="ri-eye-2-line align-bottom"></i>
                                    </b-button>
                                </div>
                            </b-col>
                        </b-row>
                    </div>
                    <div class="card bg-white border-bottom shadow-none" no-body>
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <ul class="nav nav-tabs nav-tabs-custom nav-info fs-12" role="tablist">
                                    <li class="nav-item">
                                        <BLink @click="viewPayment(null,null)" class="nav-link py-3 active" data-bs-toggle="tab" role="tab" aria-selected="true">
                                        <i class="ri-apps-2-fill me-1 align-bottom"></i> All Receipts
                                        </BLink>
                                    </li>
                                    <li class="nav-item" v-for="(list,index) in dropdowns.payments" v-bind:key="index">
                                        <BLink @click="viewPayment(index,list.value)" class="nav-link py-3" :class="(this.index == index) ? list.others+' active' : ''" data-bs-toggle="tab" role="tab" aria-selected="false">
                                            <i :class="icons[index]" class="me-1 align-bottom"></i>
                                            {{ list.name }} 
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
                            <table class="table table-nowrap align-middle mb-0">
                                <thead class="table-light">
                                    <tr class="fs-11">
                                        <th style="width: 3%;"></th>
                                        <th>Customer</th>
                                        <th style="width: 10%;" class="text-center">Collection</th>
                                        <th style="width: 10%;" class="text-center">Payment</th>
                                        <th style="width: 10%;" class="text-center">Total</th>
                                        <th style="width: 15%;" class="text-center">User</th>
                                        <th style="width: 10%;" class="text-center">Date</th>
                                        <th style="width: 7%;" class="text-center">Status</th>
                                        <th style="width: 5%;" ></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(list,index) in lists" v-bind:key="index">
                                        <td class="text-center"> 
                                            {{ (meta.current_page - 1) * meta.per_page + index + 1 }}.
                                        </td>
                                        <td>
                                            <h5 class="fs-13 mb-0 text-dark" v-if="list.or">{{list.code}} <span class="text-muted">(OR# : {{list.or.number}})</span></h5>
                                            <h5 class="fs-13 mb-0 text-dark" v-else>{{list.code}}</h5>
                                            <p class="fs-13 text-muted mb-0">{{list.payorable.name}}</p>
                                        </td>
                                        <td class="text-center fs-13">{{list.collection}}</td>
                                        <td class="text-center fs-13">{{list.payment.name}}</td>
                                        <td class="text-center fs-13">{{list.total}}</td>
                                        <td class="text-center fs-13">{{list.user}}</td>
                                        <td class="text-center fs-13">{{list.date}}</td>
                                        <td class="text-center">
                                            <span :class="'badge '+list.status.color+' '+list.status.others">{{list.status.name}}</span>
                                        </td>
                                        <td class="text-end">
                                            <b-button @click="openView(list)" variant="soft-info" class="me-1" v-b-tooltip.hover title="View" size="sm">
                                                <i class="ri-eye-fill align-bottom"></i>
                                            </b-button>
                                            <b-button @click="openPrint(list.reference)" variant="soft-success" class="me-1" v-b-tooltip.hover title="Print" size="sm">
                                                <i class="ri-printer-fill align-bottom"></i>
                                            </b-button>
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
        <View  :dropdowns="dropdowns" @update="fetch()" ref="view"/>
    </template>
<script>
import _ from 'lodash';
import View from './Modals/View.vue';
import Multiselect from "@vueform/multiselect";
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { PageHeader, Pagination, Multiselect, View },
    props: ['dropdowns'],
    data(){
        return {
            lists: [],
            meta: {},
            links: {},
            filter: {
                keyword: null,
                mode: null,
                status: null
            },
            icons: ['ri-hand-coin-line','ri-wallet-3-line','ri-indeterminate-circle-line','ri-bank-line','ri-cloud-line'],
            index: null
        }
    },
    watch: {
        "filter.keyword"(newVal){
            this.checkSearchStr(newVal);
        },
        "filter.mode"(newVal){
            this.fetch();
        },
        "filter.status"(newVal){
            this.fetch();
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
            page_url = page_url || '/orderofpayments';
            axios.get(page_url,{
                params : {
                    keyword: this.filter.keyword,
                    status: this.filter.status,
                    mode: this.filter.mode,
                    count: 10,
                    option: 'list'
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
        openView(data){
            this.$refs.view.show(data);
        },
        openPrint(id){
            window.open('/orderofpayments?option=print&id='+id);
        },
    }
}
</script>