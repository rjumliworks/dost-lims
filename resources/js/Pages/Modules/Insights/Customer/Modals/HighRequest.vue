<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 800px;" header-class="p-3 bg-light" title="View Top High-Request Customers" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
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
                                <h5 class="mb-0 fs-14"><span class="text-body">List of Customers</span></h5>
                                <p class="text-muted text-truncate-two-lines fs-12">Generate and track quotations for lab services requested by customers.</p>
                            </div>
                        </div>
                    </div>
                    <div class="car-body bg-white border-bottom shadow-none">
                        <b-row class="mb-2 ms-1 me-1" style="margin-top: 12px;">
                            <b-col lg>
                                <div class="input-group mb-1">
                                    <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                                    <input type="text" placeholder="Search Request" class="form-control" style="width: 20%;">
                                    <Multiselect class="white" v-model="filter.classification" style="width: 30%;" :options="dropdowns.classes" label="name" :allow-empty="false" :searchable="true" placeholder="Select Classification" />
                                    <b-button type="button" variant="primary" @click="openCreate">
                                        <i class="bx bx-refresh search-icon"></i>
                                    </b-button>
                                </div>
                            </b-col>
                        </b-row>
                    </div>
                    <div class="card bg-white border-bottom shadow-none" no-body>

                    </div>
                </div>
            </div>
        </BRow>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
        </template>
    </b-modal>
</template>
<script>
import _ from 'lodash';
import Multiselect from "@vueform/multiselect";
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    props: ['total','dropdowns'],
    components : { Pagination, Multiselect },
    data() {
        return {
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            sort: 'desc',
            filter: {
                classification: null,
                type: null,
                month: null,
                year: null,
                keyword: null
            },
            laboratory: null,
            showModal: false
        }
    },
    watch: {
        "filter.year"(newVal){
            this.fetch();
        }
    },
    methods : {
        show(){
            this.fetch();
            this.showModal = true;
        },
        fetch(page_url) {
            page_url = page_url || '/insights';
            axios.get(page_url, {
                params: { 
                    option: 'customers', 
                    type: 'tsr',
                    sort: this.sort,
                    year: this.filter.year,
                    month: this.filter.month
                }
            })
            .then(response => {
                this.lists = response.data.data;
                this.meta = response.data.meta;
                this.links = response.data.links;
            })
            .catch(err => console.log(err));
        },
        refresh(){
            this.fetch();
        },
        setSort(data){
            this.sort = data;
            this.fetch();
        },
        percentage(data){
            return (_.divide(data, this.total)*100).toFixed(2)+'%';
        },
        openTop(type){
            window.open('/reports?year='+this.filter.year+'&option='+type+'&laboratory='+this.laboratory);
        },
    }
}
</script>
