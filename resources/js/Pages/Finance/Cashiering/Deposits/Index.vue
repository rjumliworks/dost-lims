<template>
    <Head title="Deposits"/>
    <PageHeader title="Bank Deposits" pageTitle="Cashier" />
    <BRow>
        <div class="col-md-12">
            <div class="card bg-light-subtle shadow-none border">
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height:2.5rem;width:2.5rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-bank-fill text-primary fs-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-14"><span class="text-body">Bank Deposit Records</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">Groups of official receipts that have been deposited to the bank.</p>
                        </div>
                    </div>
                </div>
                <div class="car-body bg-white border-bottom shadow-none">
                    <b-row class="mb-2 ms-1 me-1" style="margin-top: 12px;">
                        <b-col lg>
                            <div class="input-group mb-1">
                                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                                <input type="text" v-model="filter.keyword" placeholder="Search OR Range" class="form-control" style="width: 40%;">
                                <span @click="fetch()" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;">
                                    <i class="bx bx-refresh search-icon"></i>
                                </span>
                            </div>
                        </b-col>
                    </b-row>
                </div>
                <div class="card-body bg-white rounded-bottom">
                    <div class="table-responsive table-card" style="margin-top: -10px; height: calc(100vh - 465px); overflow: auto;">
                        <table class="table table-nowrap align-middle mb-0">
                            <thead class="table-light">
                                <tr class="fs-11">
                                    <th style="width: 3%;"></th>
                                    <th style="width: 15%;" class="text-center">Date Deposited</th>
                                    <th style="width: 20%;" class="text-center">OR Range</th>
                                    <th style="width: 15%;" class="text-center">Deposit Type</th>
                                    <th style="width: 10%;" class="text-center">No. of OR</th>
                                    <th style="width: 15%;" class="text-center">Total</th>
                                    <th style="width: 7%;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(list,index) in lists" v-bind:key="index">
                                    <td class="text-center">
                                        {{ (meta.current_page - 1) * meta.per_page + index + 1 }}.
                                    </td>
                                    <td class="text-center fs-12">{{ list.date }}</td>
                                    <td class="text-center fs-12">{{ list.start }} - {{ list.end }}</td>
                                    <td class="text-center fs-12">{{ list.type }}</td>
                                    <td class="text-center fs-12">{{ list.count }}</td>
                                    <td class="text-center fs-12">{{ list.total }}</td>
                                    <td class="text-end">
                                        <b-button @click="openView(list)" variant="info" class="me-1" v-b-tooltip.hover title="View" size="sm">
                                            <i class="ri-eye-fill align-bottom"></i>
                                        </b-button>
                                        <b-button @click="openPrint(list)" variant="success" v-b-tooltip.hover title="Print" size="sm">
                                            <i class="ri-printer-fill align-bottom"></i>
                                        </b-button>
                                    </td>
                                </tr>
                                <tr v-if="lists.length === 0">
                                    <td colspan="7" class="text-center text-muted py-4">No deposit records found.</td>
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
    <View ref="view"/>
</template>
<script>
import _ from 'lodash';
import View from './Modals/View.vue';
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { PageHeader, Pagination, View },
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            filter: {
                keyword: null
            }
        }
    },
    watch: {
        "filter.keyword"(newVal){
            this.checkSearchStr(newVal);
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
            page_url = page_url || '/cashiering';
            axios.get(page_url,{
                params : {
                    keyword: this.filter.keyword,
                    count: 10,
                    option: 'depositslist'
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
        openPrint(data){
            window.open(this.currentUrl + '/cashiering?option=depositprint&id='+data.id);
        }
    }
}
</script>
