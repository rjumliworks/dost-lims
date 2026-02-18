<template>
    <Head title="Receipts"/>
        <PageHeader title="Receipt Management" pageTitle="Laboratory" />
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
                                <h5 class="mb-0 fs-14"><span class="text-body">Laboratory Receipt Records</span></h5>
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
                                    <!-- <Multiselect class="white" style="width: 15%;" :options="dropdowns.payments" v-model="filter.mode" label="name" :searchable="true" placeholder="Select Payment mode" /> -->
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
                                        <!-- <th style="width: 10%;" class="text-center">Collection</th> -->
                                        <th style="width: 10%;" class="text-center">Payment</th>
                                        <th style="width: 9%;" class="text-center">OP Amount</th>
                                        <th style="width: 9%;" class="text-center">OR Amount</th>
                                        <th style="width: 9%;" class="text-center">Excess</th>
                                        <th style="width: 10%;" class="text-center">Date</th>
                                        <th style="width: 12%;" class="text-center">Handle By</th>
                                        <!-- <th style="width: 7%;" class="text-center">Status</th> -->
                                        <th style="width: 4%;" ></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(list,index) in lists" v-bind:key="index">
                                        <td class="text-center"> 
                                            {{ (meta.current_page - 1) * meta.per_page + index + 1 }}.
                                        </td>
                                        <td>
                                            <h5 class="fs-13 mb-0 text-dark">OR# : {{list.ornumber}}</h5>
                                            <p class="fs-12 text-muted mb-0">{{list.customer}} </p>
                                        </td>
                                        <!-- <td class="text-center fs-12">{{list.collection}}</td> -->
                                        <td class="text-center fs-12">{{list.payment}}</td>
                                        <td class="text-center fs-12">{{list.opamount}}</td>
                                        <td class="text-center fs-12">{{list.oramount}}</td>
                                        <td class="text-center fs-12">{{list.excess}}</td>
                                        <td class="text-center fs-12">{{list.date}}</td>
                                        <td class="text-center fs-12">{{list.created}}</td>
                                        <td class="text-end">
                                            <!-- <b-button @click="openView(list)" variant="info" class="me-1" v-b-tooltip.hover title="View" size="sm">
                                                <i class="ri-eye-fill align-bottom"></i>
                                            </b-button>
                                            <b-button @click="openPrint(list.or_id)" variant="success" class="me-1" v-b-tooltip.hover title="Print" size="sm">
                                                <i class="ri-printer-fill align-bottom"></i>
                                            </b-button> -->
                                            <div class="d-flex gap-3 justify-content-center">
                                            <div class="dropdown">
                                                <BDropdown variant="link"  strategy="fixed" toggle-class="btn btn-light btn-sm dropdown" no-caret menu-class="dropdown-menu-end" :offset="{ alignmentAxis: -130, crossAxis: 0, mainAxis: 10 }"> 
                                                    <template #button-content> 
                                                        <i class="ri-more-fill"></i>
                                                    </template>
                                                    <li>
                                                         <a @click="openView(list)" class="dropdown-item d-flex align-items-center" role="button">
                                                            <i class="ri-eye-line me-2"></i> View
                                                         </a>
                                                    </li>
                                                    <li>
                                                        <a @click="openEdit(list,index)" class="dropdown-item d-flex align-items-center" role="button">
                                                            <i class="ri-pencil-line me-2"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a @click="openPrint(list.or_id)" class="dropdown-item d-flex align-items-center" role="button">
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
                                                        <a @click="openCancel(list.ornumber,list.or_id)" class="dropdown-item d-flex align-items-center" href="#removeFileItemModal" data-id="1" data-bs-toggle="modal" role="button">
                                                            <span class="text-danger"><i class="ri-lock-2-fill me-2"></i> Cancel</span>
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
        <View @update="fetch()" ref="view"/>
        <Edit @update="updateList" ref="edit"/>
        <Cancel ref="cancel"/>
    </template>
<script>
import _ from 'lodash';
import Edit from './Modals/Edit.vue';
import View from './Modals/View.vue';
import Cancel from './Modals/Cancel.vue';
import Multiselect from "@vueform/multiselect";
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { PageHeader, Pagination, Multiselect, View, Edit, Cancel },
    props: ['dropdowns','counts'],
    data(){
        return {
            currentUrl: window.location.origin,
            icons: ['ri-hand-coin-line','ri-wallet-3-line','ri-indeterminate-circle-line','ri-bank-line','ri-cloud-line'],
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
            page_url = page_url || '/receipts';
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
        openEdit(data,index){
            this.index = index;
            this.$refs.edit.show(data);
        },
        openCancel(or,id){
            this.$refs.cancel.show(or,id);
        },
        viewPayment(index,mode){
            this.index = index;
            this.filter.mode = mode;
            this.fetch();
        },
        openPrint(id){
            window.open(this.currentUrl + '/receipts?option=print&id='+id);
        },
        updateList(data){
            this.lists[this.index].detail = data;
        }
    }
}
</script>