<template>
    <Head title="Inventory"/>
    <PageHeader title="Inventory" pageTitle="Menu" />
    <b-row class="g-3">
        <div class="col-md-3">
            <b-card no-body class="bg-success-subtle border shadow-none">
                <b-card-body>
                    <div class="d-flex align-items-center">
                        <div class="avatar-xs flex-shrink-0">
                            <span class="avatar-title bg-light text-primary rounded-circle fs-4">
                                <i class="ri-pencil-ruler-2-fill align-middle`"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-uppercase text-truncate fw-semibold fs-12 text-muted mb-1">Active Items</p>
                            <h4 class="mb-0 fs-17"><span class="counter-value">{{statuses[0]}}</span></h4>
                        </div>
                    </div>
                </b-card-body>
            </b-card>
            <div class="card shadow-none border mt-n2">
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3 mt-1">
                            <div style="height:2rem;width:2rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-add-circle-fill  text-primary fs-20"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 mt-0 fs-13"><span class="text-body">Stock In</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-11">Increases available stock</p>
                        </div>
                    </div>
                </div>
                <div class="card border-bottom shadow-none" no-body style="height: 431px; overflow: auto;">
                    <div class="p-3">
                       <div v-for="(items, date) in stocks" :key="date">
                        <h6 class="text-muted text-uppercase mb-3 fs-11">{{date}}</h6>
                        </div>
                        <!-- <div class="d-flex align-items-center">
                            <div class="avatar-xs flex-shrink-0">
                                <span class="avatar-title bg-light rounded-circle material-shadow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-down-circle icon-dual-success icon-sm"><circle cx="12" cy="12" r="10"></circle><polyline points="8 12 12 16 16 12"></polyline><line x1="12" y1="8" x2="12" y2="16"></line></svg>
                                </span>
                            </div>

                            {{ stocks }}
                            <div class="flex-grow-1 ms-3">
                                <h6 class="fs-12 mb-0">Bought Bitcoin</h6>
                                <p class="text-muted fs-11 mb-0">+878.52 USD</p>
                            </div>
                            <div class="flex-shrink-0 text-end">
                                <h6 class="mb-0 text-success fs-12">+0.04025745<span class="text-uppercase ms-1">Btc</span></h6>
                                <p class="text-muted fs-11 mb-0">+878.52 USD</p>
                            </div>
                        </div>
                        

                        <h6 class="text-muted text-uppercase mb-3 mt-4 fs-11">24 Dec 2021</h6> -->
                        
                        <div class="mt-3 text-center">
                            <a href="javascript:void(0);" class="text-muted text-decoration-underline">Load More</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row g-3">
                <b-col lg="4" v-for="(item, index) of counts" :key="index" style="cursor: pointer;" @click="viewStatus(item)">
                    <b-card no-body class="border shadow-none">
                        <b-card-body>
                            <div class="d-flex align-items-center">
                                <div style="height:2.5rem;width:2.5rem;">
                                    <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                                        <i :class="`${item.icon} ${item.color} align-middle`"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase text-truncate fw-semibold fs-12 text-muted mb-1">
                                        {{ item.name }}
                                    </p>
                                    <h4 class="mb-0 fs-17">
                                        <span class="counter-value">{{item.total}}</span>
                                    </h4>
                                </div>
                                <div class="flex-shrink-0 align-self-end">
                                </div>
                            </div>
                        </b-card-body>
                    </b-card>
                </b-col>
                <b-col lg="12" class="mt-n2">
                    <div class="card bg-light-subtle shadow-none border">
                        <div class="card-header bg-light-subtle">
                            <div class="d-flex mb-n3">
                                <div class="flex-shrink-0 me-3 mt-1">
                                    <div style="height:2rem;width:2rem;">
                                        <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                            <i v-if="status" :class="[status.icon,status.color,'fs-20']"></i>
                                            <i v-else class="ri-list-unordered text-primary fs-20"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-0 fs-13">
                                        <span v-if="status" class="text-body">{{status.name}} Items</span>
                                        <span v-else class="text-body">List of Items</span>
                                    </h5>
                                    <p class="text-muted text-truncate-two-lines fs-11">Items in inventory, validated and available for distribution</p>
                                </div>
                            </div>
                        </div>
                         <div class="car-body bg-white border-bottom shadow-none">
                            <b-row class="mb-2 ms-1 me-1" style="margin-top: 12px;">
                                <b-col lg>
                                    <div class="input-group mb-1">
                                        <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                                        <input type="text" v-model="filter.keyword" placeholder="Search Item" class="form-control" style="width: 20%;">
                                        <Multiselect class="white" style="width: 35%;" :options="dropdowns.laboratories" v-model="filter.laboratory" label="name" :allow-empty="false" :searchable="true" placeholder="Select Laboratory" />
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
                        <div class="car-body bg-white border-bottom shadow-none">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <ul class="nav nav-tabs nav-tabs-custom nav-primary fs-12" style="margin-top: 2px;" role="tablist">
                                        <li class="nav-item">
                                            <BLink @click="viewCategory(null)" class="nav-link py-3" data-bs-toggle="tab" role="tab" aria-selected="false">
                                                <i class="ri-heart-fill me-1 align-bottom"></i> All Items
                                            </BLink>
                                        </li>
                                        <li class="nav-item" v-for="(list,index) in categories" v-bind:key="index">
                                            <BLink @click="viewCategory(list.id)" class="nav-link py-3" data-bs-toggle="tab" role="tab" aria-selected="false">
                                                <i :class="icons[index]" class="me-1 align-bottom"></i>
                                                {{ list.name }} ({{list.inventory_category_count}})
                                            </BLink>
                                        </li>
                                    </ul>
                                </div>
                                <div class="flex-shrink-0">
                                    <!-- <p class="text-primary fs-12 fw-semibold">Images & Videos</p> -->
                                </div>
                            </div>
                        </div>
                        <div class="card bg-light-subtle rounded-bottom shadow-none mb-0" style="height: calc(100vh - 551px); overflow-x: hidden;">
                            <div class="row row-cols-3 p-3 mt-2">
                                <div class="col list-element" v-for="(list,index) in lists" v-bind:key="index">
                                    <div class="card explore-box card-animate">
                                        <div class="explore-place-bid-img overflow-hidden rounded"> 
                                            <img :src="list.img"  alt="" 
                                            class="card-img-top explore-img">
                                            <div class="bg-overlay"></div>
                                        </div>
                                        <div class="card-body">
                                            <BDropdown variant="link" class="float-end dropdown mt-n1" toggle-class="btn btn-light btn-sm" no-caret data-bs-container="body" data-bs-display="static" menu-class="dropdown-menu-end" :offset="{ alignmentAxis: -130, crossAxis: 0, mainAxis: 10 }"> 
                                                <template #button-content> 
                                                    <i class="ri-more-2-fill"></i>
                                                </template>
                                                <li>
                                                    <Link :href="`/inventory/${list.reference}`" class="dropdown-item d-flex align-items-center" role="button">
                                                        <i class="ri-eye-fill me-2"></i> View
                                                    </Link>
                                                </li>
                                                <li>
                                                    <a @click="openDetail(list,index)" class="dropdown-item d-flex align-items-center" role="button">
                                                        <i class="ri-information-line me-2"></i> Details
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a :href="`/files?id=${list.id}&option=download`" target="_blank" class="dropdown-item d-flex align-items-center" role="button">
                                                        <i class="ri-download-2-line me-2"></i> Download
                                                    </a>
                                                </li>
                                            </BDropdown>
                                            
                                            <h5 class="mb-0 mt-n1 fs-12 text-truncate text-primary">{{ list.name }}</h5>
                                            <p class="text-muted fs-10 mb-n2">{{ list.code }}</p>
                                        </div>
                                        <div class="card-footer border-top border-top-dashed mt-n1 mb-n2 fs-12" style="cursor: pointer;" @click="openView(list)">
                                            <p class="fw-medium mb-0 mt-n2 float-end"><i class="ri-hand-coin-fill text-primary align-middle"></i>   {{ list.onhand }} </p>
                                            <p class="fw-medium mb-0 mt-n2"><i class="ri-shopping-basket-fill text-primary align-middle"></i> {{ list.stock }} {{ list.unit }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <Pagination class="ms-2 me-2 mt-n1" v-if="meta" @fetch="fetchList" :lists="lists.length" :links="links" :pagination="meta" />
                        </div>
                    </div>
                </b-col>
            </div>
        </div>

        <div class="col-md-3">
            <b-card no-body class="bg-danger-subtle border shadow-none">
                <b-card-body>
                    <div class="d-flex align-items-center">
                        <div class="avatar-xs flex-shrink-0">
                            <span class="avatar-title bg-light text-primary rounded-circle fs-4">
                                <i class="ri-pencil-ruler-2-fill align-middle`"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-uppercase text-truncate fw-semibold fs-12 text-muted mb-1">
                                Inactive Items
                            </p>
                            <h4 class="mb-0 fs-17">
                                <span class="counter-value">{{statuses[1]}}</span>
                            </h4>
                        </div>
                    </div>
                </b-card-body>
            </b-card>
            <div class="card shadow-none border mt-n2">
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3 mt-1">
                            <div style="height:2rem;width:2rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-indeterminate-circle-fill text-primary fs-20"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 mt-0 fs-13"><span class="text-body">Stock Out</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-11">Reduces available stock levels</p>
                        </div>
                    </div>
                </div>
                <div class="card border-bottom shadow-none" no-body style="height: 431px;">
                    
                </div>
            </div>
        </div>
    </b-row>
    <Create @message="fetch()" :dropdowns="dropdowns" ref="create"/>
</template>
<script>
import _ from 'lodash';
import Create from './Modals/Create.vue';
import Multiselect from "@vueform/multiselect";
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { PageHeader, Multiselect, Pagination, Create },
    props: ['dropdowns'],
    data(){
        return {
            lists: [],
            meta: {},
            links: {},
            name: null,
            filter: {
                keyword: null,
                status: null,
                category: null,
                laboratory: null,
                reminder: null,
            },
            counts: [],
            statuses: [],
            categories: [],
            stocks: [],
            status: null,
            icons: ['ri-information-line','ri-wallet-3-line','ri-indeterminate-circle-line','ri-checkbox-circle-line','ri-close-circle-line'],
        }
    },
    watch: {
        "filter.keyword"(newVal){
            this.checkSearchStr(newVal)
        },
        "filter.laboratory"(newVal){
            this.fetchList();
        }
    },
    created(){
        this.fetch();
        this.fetchList();
    },
    methods: {
        openCreate(){
            this.$refs.create.show();
        },
        fetch(){
            axios.get('/inventory',{
                params : {
                    option: 'fetch',
                }
            })
            .then(response => {
                this.counts = response.data.counts; 
                this.statuses = response.data.statuses;
                this.stocks = response.data.stocks;
            })
            .catch(err => console.log(err));
        },
        checkSearchStr: _.debounce(function(string) {
            this.fetchList();
        }, 300),
        fetchList(page_url){
            page_url = page_url || '/inventory';
            axios.get(page_url,{
                params : {
                    keyword: this.filter.keyword,
                    category: this.filter.category,
                    laboratory: this.filter.laboratory,
                    status: this.filter.status,
                    count: 12,
                    option: 'items'
                }
            })
            .then(response => {
                this.lists = response.data.data;
                this.meta = response.data.meta;
                this.links = response.data.links;   
                this.categories = response.data.categories;  
            })
            .catch(err => console.log(err));
        },
        viewCategory(category){
            this.filter.category = category;
            this.fetchList();
        },
        viewStatus(status){
            this.status = status;
            this.filter.status = status.name;
            this.fetchList();
        },
        refresh(){
            this.status = null;
            this.filter.keyword = null;
            this.filter.category = null;
            this.filter.laboratory = null;
            this.filter.status = null;
            this.fetchList();
        }
    }
}
</script>
