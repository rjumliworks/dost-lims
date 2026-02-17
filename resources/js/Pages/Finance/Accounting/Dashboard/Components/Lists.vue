<template>
    <div class="card bg-light-subtle shadow-none border">
        <div class="card-header bg-light-subtle">
            <div class="d-flex mb-n3">
                <div class="flex-shrink-0 me-3">
                    <div style="height:2.5rem;width:2.5rem;">
                        <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                            <i class="ri-file-text-fill  text-primary fs-24"></i>
                        </span>
                    </div>
                </div>
                <div class="flex-grow-1">
                    <h5 class="mb-0 fs-14"><span class="text-body">List of Order of Payments</span></h5>
                    <p class="text-muted text-truncate-two-lines fs-12">A document authorizing a payment, including details like the payee, amount and more.</p>
                </div>
                <div class="flex-shrink-0">
                    <div class="input-group mb-1">
                        <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                        <input type="text" placeholder="Search Request" class="form-control" style="width: 40%;">
                        <b-button type="button" variant="primary" @click="openCreate">
                            <i class="ri-add-circle-fill align-bottom me-1"></i> Create
                        </b-button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card bg-white border-bottom shadow-none" no-body>
            <div class="d-flex">
                <div class="flex-grow-1">
                    <!-- border border-dashed border-end-0 border-start-0 -->
                    <ul class="nav nav-tabs nav-tabs-custom nav-success fs-12" role="tablist">
                        <li class="nav-item">
                            <BLink @click="viewStatus(10,null)" class="nav-link py-3 active text-primary" data-bs-toggle="tab" role="tab" aria-selected="true">
                            <i class="ri-apps-2-line me-1 align-bottom"></i> All Requests
                            </BLink>
                        </li>
                    </ul>
                </div>
                <div class="flex-shrink-0">
                    <!-- <Pagination class="ms-3 me-3" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" /> -->
                </div>
            </div>
        </div>
        <div class="card-body bg-white rounded-bottom">
            <div class="table-responsive table-card" style="margin-top: -39px; height: calc(100vh - 400px);">
                <table class="table align-middle table-centered mb-0">
                    <thead class="table-light thead-fixed">
                        <tr class="fs-11">
                            <th style="width: 4%;"></th>
                            <th>Customer</th>
                            <th style="width: 13;" class="text-center">Collection</th>
                            <th style="width: 13%;" class="text-center">Payment</th>
                            <th style="width: 10%;" class="text-center">Status</th>
                            <th style="width: 10%;" class="text-center">Total</th>
                            <th style="width: 10%;" ></th>
                        </tr>
                    </thead>
                    <tbody v-if="lists.length > 0" class="table-white">
                        <tr v-for="(list,index) in lists" v-bind:key="index">
                            <td class="text-center"> 
                                {{ (meta.current_page - 1) * meta.per_page + index + 1 }}.
                            </td>
                            <td>
                                <h5 class="fs-13 mb-0 text-dark" v-if="list.or">OR# : {{list.or.number}}</h5>
                                <h5 class="fs-13 mb-0 text-dark" v-else>{{list.code}}</h5>
                                <p class="fs-12 text-muted mb-0">{{list.payorable.name}}</p>
                            </td>
                            <td class="text-center fs-12">{{list.collection}}</td>
                            <td class="text-center fs-12">{{list.payment.name}}</td>
                            <td class="text-center">
                                <span :class="'badge '+list.status.color+' '+list.status.others">{{list.status.name}}</span>
                            </td>
                            <td class="text-center">{{list.total}}</td>
                            <td class="text-end">
                                <b-button @click="openView(list)" variant="soft-info" class="me-1" v-b-tooltip.hover title="View" size="sm">
                                    <i class="ri-eye-fill align-bottom"></i>
                                </b-button>
                                <b-button @click="openPrint(list.id)" variant="soft-success" class="me-1" v-b-tooltip.hover title="Print" size="sm">
                                    <i class="ri-printer-fill align-bottom"></i>
                                </b-button>
                                <!-- <b-button @click="openDelete(list)" v-if="$page.props.user.data.assigned_role == 'Accountant' && list.status.name == 'Pending'" variant="soft-danger" class="me-1" v-b-tooltip.hover title="Delete" size="sm">
                                    <i class="ri-delete-bin-fill align-bottom"></i>
                                </b-button> -->
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                There are no records to display
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
    <Create :collections="dropdowns.collections" :payments="dropdowns.payments" @update="fetch()" ref="create"/>
    <View :dropdowns="dropdowns" @update="fetch()" ref="view"/>
    <Delete @update="fetch()" ref="delete"/>
</template>
<script>
import _ from 'lodash';
import View from '../Modals/View.vue';
import Create from '../Modals/Create.vue';
import Delete from '../Modals/Delete.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { Pagination, Create, View, Delete },
    props: ['dropdowns'],
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            index: null,
            filter: {
                keyword: null,
                status: null
            }
        }
    },
    created(){
        this.fetch();
    },
    watch: {
        "filter.keyword"(newVal){
            this.checkSearchStr(newVal)
        }
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
                    status: 6,
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
        openView(data){
            this.$refs.view.show(data);
        },
        openDelete(data){
            this.$refs.delete.show(data);
        },
        openPrint(id){
            window.open(this.currentUrl + '/orderofpayments?option=print&id='+id);
        },
    }
}
</script>