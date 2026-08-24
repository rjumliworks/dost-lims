<template>
    <b-row class="mb-4 mt-n1 ms-n3 me-n3">
        <b-col lg>
            <div class="input-group mb-1">
                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                <input type="text" v-model="filter.keyword" placeholder="Search Item" class="form-control" style="width: 20%;">
                
                <span @click="refresh()" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;"> 
                    <i class="bx bx-refresh search-icon"></i>
                </span>
                <b-button type="button" variant="primary" @click="addStock(item)">
                    <i class="ri-add-circle-fill align-bottom me-1"></i> Create
                </b-button>
            </div>
        </b-col>
    </b-row>
    <div class="table-responsive table-card" style="height: calc(100vh - 504px);">
        <table class="table table-nowrap align-middle mb-0">
            <thead class="bg-primary text-white">
                <tr class="fs-10">
                    <th style="width: 4%;"></th>
                    <th>Supplier</th>
                    <th style="width: 15%;" class="text-center">S.N./B.N.</th>
                    <th style="width: 15%;" class="text-center">Quantity</th>
                    <th style="width: 15%;" class="text-center">Content</th>
                    <th style="width: 10%;" class="text-center">Price</th>
                    <th class="text-center" style="width: 7%;"></th>
                </tr>
            </thead>
            <tbody v-if="lists.length > 0">
                <tr v-for="(list,index) in lists" v-bind:key="index" class="fs-12">
                    <td  width="5%" class="text-center fs-12"> 
                        {{ (meta.current_page - 1) * meta.per_page + index + 1 }}.
                    </td>
                    <td  width="30%">
                        <h5 class="fs-11 mb-0">{{list.supplier}}</h5>
                    </td>
                    <td class="text-center">{{list.number}}</td>
                    <td class="text-center">{{list.onhand}}</td>
                    <td class="text-center">{{list.unit}} {{list.type}}</td>
                    <td class="text-center">{{list.price}}</td>
                    <td class="text-center">
                        <div class="d-flex gap-3 justify-content-center">
                            <div class="dropdown">
                                <BDropdown variant="link" toggle-class="btn btn-light btn-sm dropdown"  strategy="fixed" no-caret menu-class="dropdown-menu-end" :offset="{ alignmentAxis: -130, crossAxis: 0, mainAxis: 10 }">
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
                                            <i class="ri-pencil-line me-2"></i>Update
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
    <div class="card-footer" style="margin-left: -15px; margin-right: -15px;">
        <Pagination class="ms-2 me-2 mt-n1 mb-n3" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
    </div>
    <Add @add="fetch()" :dropdowns="dropdowns" ref="stock"/>
    <View ref="view"/>
</template>
<script>
import _ from 'lodash';
import Add from '../Modals/Add.vue';
import View from '../Modals/View.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { Pagination, Add, View },
    props: ['item','dropdowns'],
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            filter : {
                keyword: null,
            },
            index: null
        }
    },
    watch: {
        "filter.keyword"(newVal){
            this.checkSearchStr(newVal)
        },
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
                    id: this.item.id,
                    option: 'stockin',
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
        openEdit(data,index){
            this.index = index;
            this.$refs.stock.edit(data);
        },
        addStock(data){
            this.$refs.stock.show(data);
        },
        openView(data){
            this.$refs.view.show(data);
        },
    }
}
</script>