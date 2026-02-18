<template>
    <Head title="OR Series"/>
    <PageHeader title="OR Series Management" pageTitle="List" />
    <BRow>
        <div class="col-md-12">
            <div class="card bg-light-subtle shadow-none border">
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height:2.5rem;width:2.5rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-coupon-fill text-primary fs-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-14"><span class="text-body">Official Receipt Series</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">Track and manage the series of official receipts issued for all transactions.</p>
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
                            <ul class="nav nav-tabs nav-tabs-custom nav-info fs-12" role="tablist">
                                <li class="nav-item">
                                    <BLink class="nav-link py-3 active" data-bs-toggle="tab" role="tab" aria-selected="true">
                                    <i class="ri-apps-2-fill me-1 align-bottom"></i> All Series
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
                                    <th class="text-center" style="width: 3%;"></th>
                                    <th>Name</th>
                                    <th style="width: 10%;" class="text-center">Start</th>
                                    <th style="width: 10%;" class="text-center">Next</th>
                                    <th style="width: 10%;" class="text-center">End</th>
                                    <th style="width: 15%;" class="text-center">Date Created</th>
                                    <th style="width: 15%;" class="text-center">Date Updated</th>
                                    <th style="width: 10%;" class="text-center">Status</th>
                                    <th style="width: 7%;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(list,index) in lists" v-bind:key="index" :class="[(list.is_active == 1 && list.user_id == $page.props.user.data.id) ? 'table-success' : '']">
                                    <td class="text-center" >
                                        {{index+1}}.
                                    </td>
                                    <td>
                                        <h5 class="fs-13 mb-0 text-dark">{{list.name}}</h5>
                                        <p class="fs-12 text-muted mb-0">{{list.user.profile.fullname}}</p>
                                    </td>
                                    <td class="text-center">{{list.start}}</td>
                                    <td class="text-center">{{list.next}}</td>
                                    <td class="text-center">{{list.end}}</td>
                                    <td class="text-center">{{list.created_at}}</td>
                                    <td class="text-center">{{list.updated_at}}</td>
                                    <td class="text-center">
                                        <span v-if="list.is_finished" class="badge bg-danger">Finished</span>
                                        <span v-else-if="list.is_active" class="badge bg-success">Active</span>
                                        <span v-else class="badge bg-warning">Inactive</span>
                                    </td>
                                    <td class="text-end">
                                        <b-button @click="openView(list)" variant="info" v-b-tooltip.hover title="View" size="sm" class="edit-list me-1">
                                            <i class="ri-eye-fill align-bottom"></i>
                                        </b-button>
                                        <b-button @click="openEdit(list)" variant="warning" v-b-tooltip.hover title="Edit" size="sm" class="edit-list">
                                            <i class="ri-pencil-fill align-bottom"></i>
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
    <View ref="view"/>
    <Create @update="fetch()" ref="create"/>
</template>
<script>
import _ from 'lodash';
import View from './Modals/View.vue';
import Create from './Modals/Create.vue';
import Multiselect from "@vueform/multiselect";
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { PageHeader, Pagination, Multiselect, Create, View },
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            filter: {
                keyword: null,
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
            page_url = page_url || '/cashiering';
            axios.get(page_url,{
                params : {
                    keyword: this.filter.keyword,
                    status: this.filter.status,
                    count: 10,
                    option: 'orseries'
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
        openEdit(data){
            this.$refs.create.edit(data);
        },
        openView(data){
            this.$refs.view.show(data);
        }   
    }
}
</script>