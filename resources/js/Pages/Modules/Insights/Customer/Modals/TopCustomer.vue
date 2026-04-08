<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 1200px;" hide-footer header-class="p-3 bg-light" title="View Top" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
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
                                <h5 class="mb-0 fs-14"><span class="text-body">{{top}}</span></h5>
                                <p class="text-muted text-truncate-two-lines fs-12">Top 10 customers based on {{ this.total }} total requests.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card bg-white border-bottom shadow-none">
                        <b-row class="mb-2 ms-1 me-1" style="margin-top: 12px;">
                            <b-col lg>
                                <div class="input-group mb-1 d-flex flex-nowrap">

                                    <span class="input-group-text">
                                        <i class="ri-search-line search-icon"></i>
                                    </span>

                                    <Multiselect
                                        v-if="filter.classification == 9"
                                        class="white no-radius"
                                        v-model="filter.individual"
                                        :options="dropdowns.individuals"
                                        label="name"
                                        :allow-empty="false"
                                        placeholder="Individuals"
                                    />

                                    <Multiselect
                                        class="white no-radius"
                                        v-model="filter.classification"
                                        :options="dropdowns.classes"
                                        label="name"
                                        :allow-empty="false"
                                        placeholder="Classification"
                                    />

                                    <Multiselect
                                        class="white no-radius"
                                        v-model="filter.type"
                                        :options="['All','External','Internal']"
                                        :allow-empty="false"
                                        placeholder="Type"
                                    />

                                    <Multiselect
                                        v-if="by == 'By Semester'"
                                        class="white no-radius"
                                        :options="semesters"
                                        v-model="semester"
                                        placeholder="Semester"
                                    />

                                    <Multiselect
                                        v-if="by == 'By Quarter'"
                                        class="white no-radius"
                                        :options="quarters"
                                        v-model="quarter"
                                        placeholder="Quarter"
                                    />

                                    <Multiselect
                                        v-if="by == 'By Month'"
                                        class="white no-radius"
                                        :options="months"
                                        v-model="month"
                                        placeholder="Month"
                                    />

                                    <Multiselect
                                        class="white no-radius"
                                        :options="['By Month','By Quarter','By Semester']"
                                        v-model="by"
                                        placeholder="Filter"
                                    />

                                    <Multiselect
                                        class="white no-radius"
                                        :options="years"
                                        v-model="year"
                                        placeholder="Year"
                                    />
                                    <Multiselect
                                        class="white no-radius"
                                        style="width: 50%"
                                        :options="[10,20,50,100]"
                                        :can-clear="false" :can-deselect="false" 
                                        v-model="filter.count" 
                                    />
                                    
                                    <span @click="openExcel(top)" class="input-group-text" v-b-tooltip.hover title="Download Excel" style="cursor: pointer;"> 
                                        <i class="ri-file-excel-fill text-success earch-icon"></i>
                                    </span>
                                    <b-button @click="openPrint(top)" type="button" variant="primary">
                                        <i class="ri ri-printer-fill search-icon"></i>
                                    </b-button>

                                    </div>
                            </b-col>
                        </b-row>
                    </div>
                   <div class="card-body bg-white rounded-bottom">
                        <div class="table-responsive table-card" style="margin-top: -39px; margin-bottom: -33px; height: calc(100vh - 465px); overflow: auto;">
                            <table class="table align-middle table-centered table-nowrap mb-3">
                                <thead class="text-muted table-light fs-11">
                                    <tr>
                                        <th style="cursor: pointer; width: 5%;" class="text-center">  
                                            <i @click="setSort('asc')" v-if="sort == 'desc'" class="ri-sort-asc"></i> 
                                            <i @click="setSort('desc')" v-else class="ri-sort-desc"></i> 
                                        </th>
                                        <th scope="col">Customer</th>
                                        <th class="text-center" style="width: 7%;">#</th>
                                        <th class="text-center" style="width: 8%;">%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(list,index) in lists" v-bind:key="index">
                                        <td class="text-center"> {{ (meta.current_page - 1) * meta.per_page + index + 1 }}.</td>
                                        <td>{{list.fullname}}</td>
                                        <td class="text-center">{{(list.tsrs_count) ? list.tsrs_count : formatMoney(list.total)}} </td>
                                        <td class="text-center">{{percentage(list.total)}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-light mb-n4">
                        <Pagination class="ms-2 me-2 mt-n1" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
                    </div>
                    
                </div>
            </div>
        </BRow>
    </b-modal>
</template>
<script>
import _ from 'lodash';
import Multiselect from "@vueform/multiselect";
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    props: ['dropdowns','current_year','years'],
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
                individual: null,
                type: 'All',
                month: null,
                year: null,
                count:10,
                keyword: null
            },
            laboratory: null,
            top: null,
            year: this.current_year,
            by: null,
            month: null,
            quarter: null,
            semester: null,
            months: ['January','February','March','April','May','June','July','August','September','October','November','December'],
            quarters: ['1st Quater','2nd Quarter','3rd Quarter','4th Quarter'],
            semesters: ['1st Semester','2nd Semester'],
            total: 0,
            showModal: false
        }
    },
    watch: {
        "filter.year"(newVal){
            this.fetch();
        },
        "filter.classification"(newVal){
            if(newVal){
                this.fetch();
            }else{
                this.filter.individual = null;
            }
        },
        "filter.individual"(){
            this.fetch();
        },
        "filter.count"(){
            this.fetch();
        },
        "filter.type"(){
            this.fetch();
        },
        "quarter"(newVal){
            this.fetch();
        },
        "semester"(newVal){
            this.fetch();
        },
        "month"(newVal){
            this.fetch();
        }
    },
    methods : {
        show(type){
            this.top = type;
            this.fetch();
            this.showModal = true;
        },
        fetch(page_url) {
            page_url = page_url || '/insights/customers';
            axios.get(page_url, {
                params: { 
                    by: this.by,
                    top: this.top,
                    option: 'top', 
                    sort: this.sort,
                    external: this.filter.type,
                    month: this.month,
                    year: this.year,
                    semester: this.semester,
                    quarter: this.quarter,
                    count: this.filter.count,
                    classification: this.filter.classification
                }
            })
            .then(response => {
                this.lists = response.data.data;
                this.meta = response.data.meta;
                this.links = response.data.links;
                this.total = response.data.total_tsrs;
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
         formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return '₱'+val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        openPrint(){
            window.open(
                '/insights/customers?option=top&subtype=print'
                + '&by=' + (this.by ?? '')
                + '&sort=' + (this.sort ?? '')
                + '&top=' + (this.top ?? '')
                + '&semester=' + (this.semester ?? '')
                + '&quarter=' + (this.quarter ?? '')
                + '&month=' + (this.month ?? '')
                + '&year=' + (this.year ?? '')
                + '&classification=' + (this.filter.classification ?? '')
                + '&count=' + (this.filter.count ?? '')
                + '&external=' + (this.filter.type ?? '')
            );
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>
