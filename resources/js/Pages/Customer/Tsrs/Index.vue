<template>
<Head title="TSRs"/>
<PageHeader title="TSR Management" pageTitle="List" />
    <BRow>
        <div class="col-md-12">
            <div class="card bg-light-subtle shadow-none border">
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height:2.5rem;width:2.5rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-folder-2-line text-primary fs-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-14"><span class="text-body">My Requests</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">Keep track of your personal and shared folders, organized for quick access and easy management.</p>
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
                                <input type="text" v-model="filter.keyword" placeholder="Search Folder" class="form-control" style="width: 20%;">
                                <span @click="refresh()" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;"> 
                                    <i class="bx bx-refresh search-icon"></i>
                                </span>
                                <b-button type="button" variant="primary" @click="openCreate">
                                    <i class="ri-add-circle-fill align-bottom me-1"></i> New Quotation
                                </b-button>
                            </div>
                        </b-col>
                    </b-row>
                </div>
              
                <div class="card-body bg-white rounded-bottom">
                    <div class="table-responsive table-card" style="margin-top: -17px; height: calc(100vh - 465px); overflow: auto;">
                        <table class="table align-middle table-centered table-striped mb-0">
                             <thead class="table-light thead-fixed">
                                <tr class="fs-10">
                                    <th style="width: 4%;"></th>
                                    <th style="width: 20%;">Code</th>
                                    <th style="width: 25%;" class="text-center">Request At</th>
                                    <th style="width: 16%;" class="text-center">Status</th>
                                    <th style="width: 15%;" class="text-center">Total</th>
                                    <th style="width: 10%;" class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody v-if="lists.length > 0">
                                <tr v-for="(list,index) in lists" v-bind:key="index" class="fs-12">
                                    <td>{{ (meta.current_page - 1) * meta.per_page + index + 1 }}.</td>
                                    <td>{{list.code}}</td>
                                    <td class="text-center">{{list.created_at}}</td>
                                    <td class="text-center"><span :class="'badge '+list.status.color">{{list.status.name}}</span></td>
                                    <td class="text-center">{{list.payment.total}}</td>
                                    <td class="text-center">
                                        -
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No records found.</td>
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
</template>
<script>
import _ from 'lodash';
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { PageHeader, Pagination },
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            filter: {
                keyword: null
            },
            type: null,
            index: null,
            selectedRow: null
        }
    },
    watch: {
        "type"(newVal) {
            if(newVal){
                if(newVal != 'all'){
                    this.type = newVal;
                }else{
                    this.type = null;
                }
                this.fetch();
            }
        },
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
                    type: this.type,
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
        openCreate(){
            this.$refs.create.show();
        },
        openUpdate(data,index){
            this.index = index;
            this.$refs.create.edit(data);
        },
        openDelete(list,index){
            this.$refs.delete.show(list);
            this.index = index;
        },
        selectView(data){
            this.type = data;
        },
        selectRow(index) {
            this.selectedRow = index;
        },
         deleteItem(data) {
            this.lists.splice(this.index, 1);
            this.index = null;
        },
        updateRow(data){
            this.lists[this.index] = data;
        }
    }
}
</script>