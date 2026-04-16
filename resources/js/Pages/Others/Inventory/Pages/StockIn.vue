<template>
<Head title="Stock In"/>
    <PageHeader title="Stock In" pageTitle="Inventory" />
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
                            <p class="text-muted text-truncate-two-lines fs-12">Generate and track quotations for lab services requested by customers.</p>
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
                                <input type="text" v-model="filter.keyword" placeholder="Search Request" class="form-control" style="width: 20%;">
                                <!-- <Multiselect class="white" style="width: 15%;" :options="dates" v-model="filter.datetype" label="name" :allow-empty="false" :searchable="true" placeholder="Filter by date" />
                                <Multiselect class="white" style="width: 15%;" :options="dropdowns.laboratories" v-model="filter.laboratory" label="name" :allow-empty="false" :searchable="true" placeholder="Select Laboratory" />
                                <Multiselect class="white" style="width: 10%;" :options="['Local','Referral']" v-model="filter.type" label="name" :allow-empty="false" :searchable="true" placeholder="Select Type" /> -->
                               
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
                            <ul class="nav nav-tabs nav-tabs-custom nav-primary fs-12" role="tablist">
                                <li class="nav-item">
                                    <BLink @click="viewStatus(null,null)" class="nav-link py-3 active" data-bs-toggle="tab" role="tab" aria-selected="true">
                                    <i class="ri-apps-2-fill me-1 align-bottom"></i> All Requests
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
                        <table class="table align-middle table-centered table-striped mb-0">
                            <thead class="table-light thead-fixed">
                                <tr class="fs-11">
                                    <th style="width: 4%;"></th>
                                    <th>Item</th>
                                    <th style="width: 25%;" class="text-center">Supplier</th>
                                    <th style="width: 5%;" class="text-center">Quantity</th>
                                    <th style="width: 10%;" class="text-center">S.N./B.N.</th>
                                    <th style="width: 10%;" class="text-center">Content</th>
                                    <th style="width: 10%;" class="text-center">Price</th>
                                    <th style="width: 10%;" class="text-center">Date</th>
                                    <th class="text-center" style="width: 4%;"></th>
                                </tr>
                            </thead>
                            <tbody v-if="lists.length > 0">
                                <tr v-for="(list,index) in lists" v-bind:key="index" class="fs-12">
                                    <td class="text-center fs-12">{{ (meta.current_page - 1) * meta.per_page + index + 1 }}.</td>
                                    <td><h5 class="fs-12 mb-0">{{list.name}}</h5></td>
                                    <td class="text-center">{{list.supplier}}</td>
                                    <td class="text-center">{{list.onhand}}</td>
                                    <td class="text-center">{{list.number}}</td>
                                    <td class="text-center">{{list.unit}} {{list.type}}</td>
                                    <td class="text-center">{{list.price}}</td>
                                    <td class="text-center">{{list.bought_at}}</td>
                                    <td class="text-center">
                                        <div class="d-flex gap-3 justify-content-center">
                                            <div class="dropdown">
                                                <BDropdown variant="link" toggle-class="btn btn-light btn-sm dropdown"  strategy="fixed" no-caret menu-class="dropdown-menu-end" :offset="{ alignmentAxis: -130, crossAxis: 0, mainAxis: 10 }"> 
                                                    <template #button-content> 
                                                        <i class="ri-more-fill"></i>
                                                    </template>
                                                    <li>
                                                            <a :href="`/tsrs/${list.reference}`" target="_blank" class="dropdown-item d-flex align-items-center" role="button">
                                                            <i class="ri-eye-line me-2"></i> View
                                                            </a>
                                                    </li>
                                                    <li>
                                                        <a @click="openEdit(list,index)" class="dropdown-item d-flex align-items-center" role="button">
                                                            <i class="ri-pencil-line me-2"></i>Update
                                                        </a>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <a @click="openActivation('activation',list,index)" class="dropdown-item d-flex align-items-center" :class="(list.is_active) ? 'text-danger' : 'text-success'" href="#removeFileItemModal" data-id="1" data-bs-toggle="modal" role="button">
                                                            <span v-if="list.is_active"><i class="ri-lock-2-fill me-2"></i> Deactivate</span>
                                                            <span v-else><i class="ri-lock-unlock-line me-2"></i> Activate</span>
                                                        </a>
                                                    </li>
                                                </BDropdown>
                                            </div>
                                        </div>
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
import Multiselect from "@vueform/multiselect";
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { PageHeader, Pagination, Multiselect },
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            index: null,
            filter: {
                keyword: null,
            },
            selectedRow: null,
        }
    },
    watch: {
        "filter.keyword"(newVal){
            this.checkSearchStr(newVal)
        }
    },
    created(){
       this.fetch();
    },
    methods: {
        checkSearchStr: _.debounce(function(string) {
            this.fetch();
        }, 300),
        fetch(page_url) {
            page_url = page_url || '/inventory';
            axios.get(page_url,{
                params : {
                    option: 'stockins',
                    keyword : this.keyword,
                    count: 10
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
        selectRow(index) {
            this.selectedRow = index;
        },
        openCreate(){
            this.$refs.create.show(this.region);
        },
       
    }
}
</script>