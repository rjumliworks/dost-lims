<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 1200px;" hide-footer header-class="p-3 bg-light" title="View Customer Province" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <BRow>
            <div class="col-md-12">
                <div class="card bg-light-subtle shadow-none border">
                    <div class="card-header bg-light-subtle">
                        <div class="d-flex mb-n3">
                            <div class="flex-shrink-0 me-3">
                                <div style="height:2.5rem;width:2.5rem;">
                                    <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                        <i class="ri-map-pin-user-fill text-primary fs-24"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-0 fs-14">
                                    <a v-if="view == 'detail'" href="#/" @click.prevent="backToList" class="text-muted me-1" v-b-tooltip.hover title="Back to Provinces">
                                        <i class="ri-arrow-left-line align-bottom"></i>
                                    </a>
                                    <span class="text-body">{{ view == 'list' ? title : selectedProvince?.name }}</span>
                                </h5>
                                <p class="text-muted text-truncate-two-lines fs-12">
                                    <span v-if="view == 'list'">Customer distribution across provinces</span>
                                    <span v-else>List of customers from {{ selectedProvince?.name }}</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <template v-if="view == 'list'">
                        <div class="card bg-white border-bottom shadow-none">
                            <b-row class="mb-2 ms-1 me-1" style="margin-top: 12px;">
                                <b-col lg>
                                    <div class="input-group mb-1 d-flex flex-nowrap">
                                        <span class="input-group-text">
                                            <i class="ri-search-line search-icon"></i>
                                        </span>
                                        <Multiselect
                                            class="white no-radius"
                                            :options="years"
                                            v-model="year"
                                            :can-clear="false" :can-deselect="false"
                                            placeholder="Year"
                                        />
                                    </div>
                                </b-col>
                            </b-row>
                        </div>
                        <div class="card-body bg-white rounded-bottom">
                            <div class="table-responsive table-card" style="margin-top: -39px; margin-bottom: -33px; height: calc(100vh - 465px); overflow: auto;">
                                <table class="table align-middle table-centered table-nowrap mb-3">
                                    <thead class="text-muted table-light fs-11">
                                        <tr>
                                            <th class="text-center" style="width: 5%;">#</th>
                                            <th scope="col">Province</th>
                                            <th class="text-center" style="width: 10%;">Customers</th>
                                            <th class="text-center" style="width: 8%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(list,index) in provinces" v-bind:key="index">
                                            <td class="text-center">{{ index + 1 }}.</td>
                                            <td>{{ list.name }}</td>
                                            <td class="text-center">{{ list.address_count }}</td>
                                            <td class="text-center">
                                                <button @click="viewProvince(list)" class="btn btn-sm btn-soft-success" type="button" v-b-tooltip.hover title="View Customers">
                                                    <i class="ri-eye-fill align-bottom"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </template>

                    <template v-else>
                        <div class="card bg-white border-bottom shadow-none">
                            <b-row class="mb-2 ms-1 me-1" style="margin-top: 12px;">
                                <b-col lg>
                                    <div class="input-group mb-1 d-flex flex-nowrap">
                                        <span class="input-group-text">
                                            <i class="ri-search-line search-icon"></i>
                                        </span>
                                        <Multiselect
                                            class="white no-radius"
                                            v-model="filter.laboratory"
                                            :options="dropdowns.laboratories"
                                            label="name"
                                            placeholder="Laboratory"
                                        />
                                        <Multiselect
                                            class="white no-radius"
                                            v-model="filter.classification"
                                            :options="dropdowns.classes"
                                            label="name"
                                            placeholder="Classification"
                                        />
                                        <Multiselect
                                            class="white no-radius"
                                            :options="years"
                                            v-model="year"
                                            :can-clear="false" :can-deselect="false"
                                            placeholder="Year"
                                        />
                                        <Multiselect
                                            class="white no-radius"
                                            style="width: 50%"
                                            :options="[10,20,50,100]"
                                            :can-clear="false" :can-deselect="false"
                                            v-model="filter.count"
                                        />
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
                                            <th scope="col">Classification</th>
                                            <th class="text-center" style="width: 10%;">Requests</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(list,index) in lists" v-bind:key="index">
                                            <td class="text-center"> {{ (meta.current_page - 1) * meta.per_page + index + 1 }}.</td>
                                            <td>{{ list.fullname }}</td>
                                            <td>{{ list.customer_name?.classification?.name }}</td>
                                            <td class="text-center">{{ list.tsrs_count }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-light mb-n4">
                            <Pagination class="ms-2 me-2 mt-n1" v-if="meta" @fetch="fetchCustomers" :lists="lists.length" :links="links" :pagination="meta" />
                        </div>
                    </template>
                </div>
            </div>
        </BRow>
    </b-modal>
</template>
<script>
import Multiselect from "@vueform/multiselect";
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    props: ['dropdowns','current_year','years'],
    components: { Pagination, Multiselect },
    data() {
        return {
            title: null,
            view: 'list',
            provinces: [],
            selectedProvince: null,
            lists: [],
            meta: {},
            links: {},
            sort: 'desc',
            year: this.current_year,
            filter: {
                laboratory: null,
                classification: null,
                count: 10
            },
            showModal: false
        }
    },
    watch: {
        "year"(){
            (this.view == 'list') ? this.fetchProvinces() : this.fetchCustomers();
        },
        "filter.laboratory"(){
            this.fetchCustomers();
        },
        "filter.classification"(){
            this.fetchCustomers();
        },
        "filter.count"(){
            this.fetchCustomers();
        }
    },
    methods : {
        show(title){
            this.title = title;
            this.view = 'list';
            this.selectedProvince = null;
            this.fetchProvinces();
            this.showModal = true;
        },
        fetchProvinces(){
            axios.get('/insights/customers', {
                params: {
                    option: 'province',
                    year: this.year
                }
            })
            .then(response => {
                this.provinces = response.data.data;
            })
            .catch(err => console.log(err));
        },
        viewProvince(province){
            this.selectedProvince = province;
            this.view = 'detail';
            this.filter.laboratory = null;
            this.filter.classification = null;
            this.fetchCustomers();
        },
        fetchCustomers(page_url) {
            page_url = page_url || '/insights/customers';
            axios.get(page_url, {
                params: {
                    option: 'province',
                    code: this.selectedProvince.code,
                    laboratory: this.filter.laboratory,
                    classification: this.filter.classification,
                    year: this.year,
                    count: this.filter.count,
                    sort: this.sort
                }
            })
            .then(response => {
                this.lists = response.data.data;
                this.meta = response.data.meta;
                this.links = response.data.links;
            })
            .catch(err => console.log(err));
        },
        setSort(data){
            this.sort = data;
            this.fetchCustomers();
        },
        backToList(){
            this.view = 'list';
            this.selectedProvince = null;
            this.fetchProvinces();
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>
