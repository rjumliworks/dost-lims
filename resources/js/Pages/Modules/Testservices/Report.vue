<template>
    <Head title="Test Services"/>
    <PageHeader title="Test Service Management" pageTitle="List" />
    <BRow>
        <div class="col-md-12">
            <div class="card bg-light-subtle shadow-none border">

                <!-- <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height:2.5rem;width:2.5rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-list-check text-primary fs-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-14"><span class="text-body">List of Test Services</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">Manage the complete list of laboratory test services with full configuration and details.</p>
                        </div>
                        <div class="flex-shrink-0" style="width: 45%;">
                           
                        </div>
                    </div>
                </div> -->

                <div class="car-body bg-white border-bottom shadow-none">
                    <b-row class="mb-2 ms-1 me-1" style="margin-top: 12px;">
                        <b-col lg>
                            <div class="input-group mb-1">
                                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                                <input type="text" v-model="filter.keyword" placeholder="Search Sample" class="form-control" style="width: 15%;">
                                <Multiselect class="white" style="width: 15%;" :options="names" v-model="filter.name" label="name" :searchable="true" placeholder="Select Name" />
                                <Multiselect class="white" style="width: 15%;" :options="types" v-model="filter.type" label="name" :searchable="true" placeholder="Select Type" />
                                <Multiselect class="white" style="width: 15%;" :options="categories" v-model="filter.category" label="name" :searchable="true" placeholder="Select Category" />
                                <Multiselect class="white" style="width: 18%;" :options="dropdowns.laboratories" v-model="filter.laboratory" label="name" :searchable="true" placeholder="Select Laboratory" />
                                <span @click="filterAddress()" class="input-group-text" v-b-tooltip.hover title="Filter by Address" style="cursor: pointer;"> 
                                    <i class="bx bxs-map search-icon" :class="{'bx-tada text-danger': hasAddressFilter}"></i>
                                </span>
                                <span @click="refresh()" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;"> 
                                    <i class="bx bx-refresh search-icon"></i>
                                </span>
                                <b-button type="button" variant="primary" @click="openPrint()" :disabled="samples.length == 0">
                                    <i class="ri-printer-fill align-bottom me-1"></i> Print
                                </b-button>
                            </div>
                        </b-col>
                    </b-row>
                </div>
                <div v-if="samples.length == 0" class="card-body bg-white rounded-bottom" style="height: calc(100vh - 360px); overflow: auto;">
             
                </div>
            </div>
        </div>

        <template v-if="samples.length > 0">
            <div class="col-md-4">
                <div class="card bg-light-subtle shadow-none border">
                    <div class="card-header bg-light-subtle">
                        <div class="d-flex mb-n3">
                            <div class="flex-shrink-0 me-3 mt-1">
                                <div style="height:2rem;width:2rem;">
                                    <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                        <i class="ri-account-circle-fill text-primary fs-20"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-0 fs-13"><span class="text-body">Sample Revenue Summary</span></h5>
                                <p class="text-muted text-truncate-two-lines fs-11">Total earnings grouped by sample name, category or type.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card border-bottom shadow-none" style="height: calc(100vh - 405px);">
                        <div class="card-body">
                             <div class="row align-items-center">
                                <div class="col-6">
                                    <h6 class="text-muted text-uppercase fw-semibold text-truncate fs-12 mb-3">Total Income for sample <span class="text-danger">"{{ filter.keyword }}"</span></h6>
                                    <h4 class="mb-0">{{formatMoney(totalIncome)}}</h4>
                                    <!-- <p class="mb-0 mt-2 text-muted"><span class="badge bg-success-subtle text-success mb-0"> <i class="ri-arrow-up-line align-middle"></i> 15.72 % </span> vs. previous month</p> -->
                                </div>
                                <div class="col-6">
                                    <div class="text-center">
                                        <img src="assets/images/illustrator-1.png" class="img-fluid" alt="">
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3 pt-2">
                                <div class="progress progress-lg rounded-pill">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 18%" aria-valuenow="18" aria-valuemin="0" aria-valuemax="100"></div>
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 22%" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 16%" aria-valuenow="16" aria-valuemin="0" aria-valuemax="100"></div>
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 19%" aria-valuenow="19" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <simplebar data-simplebar style="max-height: calc(100vh - 520px);">
                                <div class="mt-3 pt-2">
                                   <div
                                            class="d-flex mb-2 border-bottom p-1 sample-item"
                                            :class="{ active: selectedSample === list.sample_name }"
                                            v-for="(list,index) in sortedSamples"
                                            :key="index"
                                            @click="selectedSample = list.sample_name"
                                            style="cursor: pointer;"
                                        >
                                        <div class="flex-grow-1">
                                            <p class="text-truncate text-capitalize text-muted fs-14 mb-0"><i class="mdi mdi-circle align-middle text-primary me-2"></i>{{ list.sample_name }}</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <p class="mb-0">{{formatMoney(list.total_fee)}}</p>
                                        </div>
                                    </div>
                                </div>
                            </simplebar>
                        </div>
                    </div>
                </div>    
            </div>
            <div class="col-md-8">
                <div class="card bg-light-subtle shadow-none border">
                    <div class="card-header bg-light-subtle">
                        <div class="d-flex mb-n3">
                            <div class="flex-shrink-0 me-3 mt-1">
                                <div style="height:2rem;width:2rem;">
                                    <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                        <i class="ri-account-circle-fill text-primary fs-20"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-0 fs-13">
                                    <span v-if="selectedSample" class="text-body">
                                        Test Services for
                                        <span class="text-danger text-capitalize fw-semibold">{{ selectedSample }}</span>
                                    </span>

                                    <span v-else class="text-body">
                                        List of Samples and Testservices
                                    </span>
                                </h5>
                                <p class="text-muted text-truncate-two-lines fs-11">Consolidated list of samples and associated test services for the current period.</p>
                            </div>
                            <div class="flex-shrink-0">
                                <button type="button" class="btn btn-primary btn-sm mt-1" @click="selectedSample = null">Show All</button>  
                            </div>
                        </div>
                    </div>
                    <div class="cards border-bottom shadow-none" style="height: calc(100vh - 381px);">
                        <div class="card-body">
                            <div class="table-responsive table-card" style="height: calc(100vh - 382px); overflow: auto;">
                                <table class="table align-middle table-centered mb-0">
                                    <thead class="table-light thead-fixed">
                                        <tr class="fs-11">
                                            <th style="width: 4%;"></th>
                                            <th>Test Service</th>
                                            <th style="width: 20%;" class="text-center">No. of Times Performed</th>
                                            <th style="width: 20%;" class="text-center">Total Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="ribbon-box" v-for="(list,index) in flattenedTests" v-bind:key="index">
                                            <td class="text-center"> 
                                                {{ index + 1 }}.
                                            </td>
                                            <td>
                                                <h5 class="fs-13 mb-0 fw-semibold text-capitalize text-primary">{{list.test_name}}</h5>
                                            </td>
                                            <td class="text-center fs-12">{{list.count}}</td>
                                            <td class="text-center fs-12">{{formatMoney(list.total_fee)}}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot class="tfoot-fixed">
                                        <tr class="table-light fw-bold text-primary">
                                            <td colspan="2"></td>
                                            <td class="text-center">
                                                {{ tableTotalCount }}
                                            </td>
                                            <td class="text-center">
                                                {{ formatMoney(tableTotal) }}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
        </template>
        <Filter @submit="handleSubmit" :regions="dropdowns.regions" :region="region" ref="filter"/>
    </BRow>
</template>
<script>
import _ from 'lodash';
import simplebar from "simplebar-vue";
import Filter from './Modals/Filter.vue';
import Multiselect from "@vueform/multiselect";
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { PageHeader, Pagination, Multiselect, simplebar, Filter },
    props: ['counts','dropdowns','region'],
    data(){
        return {
            filter: {
                keyword: null,
                laboratory: null,
                category: null,
                type: null,
                name: null,
                status: null
            },
            location: {
                region: null,
                province: null,
                municipality: null,
                province: null
            },
            categories: [],
            types: [],
            names: [],
            index: null,
            samples: [],
            selectedSample: null
        }
    },
    computed: {
        totalIncome() {
            return this.samples.reduce((sum, sample) => {
            return sum + Number(sample.total_fee || 0);
            }, 0);
        },
        flattenedTests() {
            const samples = this.selectedSample
                ? this.samples.filter(s => s.sample_name === this.selectedSample)
                : this.samples;

            return samples.flatMap(sample =>
                sample.testnames.map(test => ({
                    sample_name: sample.sample_name,
                    test_id: test.id,
                    test_name: test.name,
                    count: test.count,
                    total_fee: test.total_fee
                }))
            ).sort((a, b) => b.total_fee - a.total_fee);
        },
        sortedSamples() {
            return [...this.samples].sort((a, b) => b.total_fee - a.total_fee);
        },
        tableTotal() {
            return this.flattenedTests.reduce((sum, item) => {
                return sum + Number(item.total_fee || 0);
            }, 0);
        },
        tableTotalCount() {
            return this.flattenedTests.reduce((sum, item) => {
                return sum + Number(item.count || 0);
            }, 0);
        },
        hasAddressFilter() {
            return ['province', 'municipality', 'barangay']
            .some(key => this.location[key] && this.location[key] !== '');
        }
    },
    created() {
        this.debouncedFetch = _.debounce(() => {
            this.fetch();
        }, 300);
    },
    watch: {
        'filter.keyword'(newVal, oldVal) {
            if (newVal !== oldVal) {
                this.checkSearchStr(newVal);
            }
        },
        "filter.laboratory"(newVal){
            this.fetch();
            this.fetchCategory();
        },
        "filter.category"(newVal){
            if(newVal){
                this.fetch();
                this.fetchType();
            }else{
                this.filter.type = null;
                this.types = [];
            }
        },
        "filter.type"(newVal){
            this.fetch();
            this.fetchName();
        },
        "filter.name"(newVal){
            this.fetch();
        },
    },
    methods: {
         checkSearchStr: _.debounce(function(string) {
            this.fetch();
        }, 300),
        fetch(page_url){
            page_url = page_url || '/testservices';
            axios.get(page_url,{
                params : {
                    keyword: this.filter.keyword,
                    laboratory: this.filter.laboratory,
                    category: this.filter.category,
                    type: this.filter.type,
                    name: this.filter.name,
                    status: this.filter.status,
                    region: this.location.region,
                    province: this.location.province,
                    municipality: this.location.municipality,
                    barangay: this.location.barangay,
                    count: 10,
                    option: 'sample'
                }
            })
            .then(response => {
                if(response){
                    this.selectedSample = null;
                    this.samples = response.data;      
                }
            })
            .catch(err => console.log(err));
        },
        fetchCategory(){
            axios.get('/categories',{
                params: {
                    option: 'category',
                    laboratory_id: this.filter.laboratory,
                }
            })
            .then(response => {
                this.categories = response.data;
            })
            .catch(err => console.log(err));
        },
        fetchType(){
            axios.get('/categories',{
                params: {
                    option: 'type',
                    category_id: this.filter.category,
                }
            })
            .then(response => {
                this.types = response.data;
            })
            .catch(err => console.log(err));
        },
        fetchName(){
            axios.get('/categories',{
                params: {
                    option: 'name',
                    sampletype_id: this.filter.type,
                }
            })
            .then(response => {
                this.names = response.data;
            })
            .catch(err => console.log(err));
        },
        openPrint() {
            const params = new URLSearchParams();

            params.append('option', 'print');

            params.append('keyword', this.filter.keyword || '');
            params.append('laboratory', this.filter.laboratory || '');
            params.append('category', this.filter.category || '');
            params.append('type', this.filter.type || '');
            params.append('name', this.filter.name || '');
            params.append('status', this.filter.status || '');

            params.append('region', this.location.region || '');
            params.append('province', this.location.province || '');
            params.append('municipality', this.location.municipality || '');
            params.append('barangay', this.location.barangay || '');

            window.open('/testservices?' + params.toString(), '_blank');
        },
        filterAddress(){
            this.$refs.filter.show();
        },
        handleSubmit(data) {
            this.location.region       = data?.form?.region       ?? null;
            this.location.province     = data?.form?.province?.value     ?? null;
            this.location.municipality = data?.form?.municipality?.value ?? null;
            this.location.barangay     = data?.form?.barangay?.value     ?? null;
            this.fetch();
        },
        formatMoney(value) {
            let val = (value / 1).toFixed(2).replace(',', '.');
            return '₱' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
        refresh() {
            this.location.region       = null;
            this.location.province     = null;
            this.location.municipality = null;
            this.location.barangay     = null;
        }
    }
}
</script>
<style scoped>
.sample-item.active {
    background-color: rgba(var(--vz-primary-rgb), 0.15);
    border-radius: 6px;
    border-left: 4px solid var(--vz-primary);
}

.sample-item.active p {
    color: var(--vz-primary) !important;
    font-weight: 600;
}</style>