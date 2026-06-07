<template>
    <Head title="Customers"/>
    <PageHeader title="Customer Management" pageTitle="List" />
    <BRow>
        <div class="col-md-12">
            <div class="card bg-light-subtle shadow-none border">

                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height:2.5rem;width:2.5rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-team-fill text-primary fs-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-14"><span class="text-body">List of Customers</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">View and manage customer profiles along with their laboratory test requests and related transactions.</p>
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
                                <input type="text" v-model="filter.keyword" placeholder="Search Customer" class="form-control" style="width: 20%;">
                                <Multiselect class="white" style="width: 13%;" :options="dropdowns.sexs" v-model="filter.sex" label="name" :searchable="true" placeholder="Select Sex" />
                                <Multiselect v-if="filter.industry == 107" class="white" style="width: 17%;" :options="dropdowns.individuals" v-model="filter.individual" label="name" :searchable="true" placeholder="Select Individual" />
                                <Multiselect v-if="filter.class == 8" class="white" style="width: 17%;" :options="dropdowns.industries" v-model="filter.industry" label="name" :searchable="true" placeholder="Select Industry" />
                                <Multiselect v-if="$page.props.roles.includes('Admnistrator')" class="white" style="width: 15%;" :options="dropdowns.agencies" v-model="filter.agency" label="short" :searchable="true" placeholder="Select Agency" />
                                <Multiselect class="white" style="width: 15%;" :options="dropdowns.classes" v-model="filter.class" label="name" :searchable="true" placeholder="Select Classification" />
                                <span @click="filterAddress()" class="input-group-text" v-b-tooltip.hover title="Filter by Address" style="cursor: pointer;"> 
                                    <i class="ri-map-pin-fill search-icon"></i>
                                </span>
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
                                    <BLink @click="viewClass(null,null)" class="nav-link py-3 active" data-bs-toggle="tab" role="tab" aria-selected="true">
                                    <i class="ri-apps-2-fill me-1 align-bottom"></i> All Customers
                                    </BLink>
                                </li>
                                <li class="nav-item" v-for="(list,index) in types" v-bind:key="index">
                                    <BLink @click="viewClass(index,list.value)" class="nav-link py-3" :class="index2 === index ? `${list.others} active` : ''" data-bs-toggle="tab" role="tab" aria-selected="false">
                                        <i :class="icons[index]" class="me-1 align-bottom"></i>
                                        {{ list }} 
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
                                    <th style="width: 3%;"></th>
                                    <th>Name</th>
                                    <th style="width: 13%;" class="text-center">Contact Details</th>
                                    <th style="width: 13%;" class="text-center">Date Created</th>
                                    <th style="width: 7%;" class="text-center">Status</th>
                                    <th style="width: 4%;" ></th>
                                </tr>
                            </thead>
                            <tbody class="table-white fs-12">
                                <tr v-for="(list,index) in lists" v-bind:key="index" @click="selectRow(index)" :class="{
                                    'bg-info-subtle': index === selectedRow,
                                    'bg-danger-subtle': list.is_active === 0 && index !== selectedRow
                                }">
                                    <td class="text-center"> 
                                        {{ (meta.current_page - 1) * meta.per_page + index + 1 }}.
                                    </td>
                                    <td>
                                        <h5 class="fs-13 mb-0 text-dark">{{list.customer}}</h5>
                                        <p class="fs-12 text-muted mb-0">{{ list.address?.name || '—' }}</p>
                                    </td>
                                    <td class="text-center fs-12">
                                        <h5 class="fs-11 mb-0 text-dark">{{list.email}}</h5>
                                        <p class="fs-11 text-muted mb-0">{{list.contact_no}}</p>
                                    </td>
                                    <td class="text-center fs-11">{{list.created_at}}</td>
                                    <td class="text-center">
                                        <span v-if="list.is_active" class="badge bg-success">Active</span>
                                        <span v-else class="badge bg-danger">Inactive</span>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex gap-3 justify-content-center">
                                            <div class="dropdown">
                                                <BDropdown variant="link" toggle-class="btn btn-light btn-sm dropdown" no-caret menu-class="dropdown-menu-end" :offset="{ alignmentAxis: -130, crossAxis: 0, mainAxis: 10 }"> 
                                                    <template #button-content> 
                                                        <i class="ri-more-fill"></i>
                                                    </template>
                                                    <li>
                                                        <Link :href="`/customers/${list.code}`" class="dropdown-item d-flex align-items-center" role="button">
                                                            <i class="ri-eye-fill me-2"></i> View
                                                        </Link>
                                                    </li>
                                                    <li>
                                                        <a @click="openEdit(list,index)" class="dropdown-item d-flex align-items-center" role="button">
                                                            <i class="ri-edit-2-fill me-2"></i>Edit
                                                        </a>
                                                    </li>
                                                    <!-- <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <a @click="openRole(list,index)" class="dropdown-item d-flex align-items-center" role="button">
                                                            <i class="ri-calendar-fill me-2"></i>Update Date
                                                        </a>
                                                    </li> -->
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
                        </table>
                        <div class="d-flex flex-column justify-content-center align-items-center h-100" v-if="lists.length == 0">
                        
                            <i class="ri-user-search-line fs-24 text-muted"></i>
                            <p class="mt-2 fs-12 text-muted mb-0">No customers have been added to the list.</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <Pagination class="ms-2 me-2 mt-n1" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
                </div>

            </div>
        </div>
    </BRow>
    <Filter @submit="handleSubmit" :regions="dropdowns.regions" :region="region" ref="filter"/>
    <Activation @update="updateData" ref="activation"/>
    <Create @message="fetch()" :dropdowns="dropdowns" :region="region" ref="create"/>
    <Edit :dropdowns="dropdowns" :region="region" @update="fetch()" ref="edit"/>
</template>
<script>
import _ from 'lodash';
import Edit from './Modals/Edit.vue';
import Create from './Modals/Create.vue';
import Filter from './Modals/Filter.vue';
import Activation from './Modals/Activation.vue';
import Multiselect from "@vueform/multiselect";
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { PageHeader, Pagination, Multiselect, Create, Filter, Edit, Activation },
    props: ['region','dropdowns'],
    data(){
        return {
            lists: [],
            meta: {},
            links: {},
            filter: {
                keyword: null,
                class: null,
                industry: null,
                sex: null,
                agency: null,
                individual: null,
                type: null
            },
            location: {
                region: null,
                province: null,
                municipality: null,
                province: null
            },
            types: ['New Customer','Old Customer','Not Identified'],
            icons: ['ri-building-2-fill','ri-user-fill'],
            index: null,
            index2: null,
            selectedRow: null,
        }
    },
    watch: {
        'filter.keyword'(newVal, oldVal) {
            if (newVal !== oldVal) {
                this.debouncedFetch();
            }
        },
        'filter.sex'() { this.fetch(); },
        'filter.type'() { this.fetch(); },
        'filter.industry'() { this.fetch(); },
        'filter.individual'() { this.fetch(); },
        'filter.class'() { this.fetch(); },
        'filter.agency'() { this.fetch(); },
    },
    created() {
        this.debouncedFetch = _.debounce(() => {
            this.fetch();
        }, 300);
        this.fetch();
    },
    methods: {
        fetch(page_url){
            page_url = page_url || '/customers';
            axios.get(page_url,{
                params : {
                    keyword: this.filter.keyword,
                    class: this.filter.class,
                    industry: this.filter.industry,
                    sex: this.filter.sex,
                    type: this.filter.type,
                    individual: this.filter.individual,
                    region: this.location.region,
                    province: this.location.province,
                    municipality: this.location.municipality,
                    barangay: this.location.barangay,
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
        openEdit(data,index){
            this.index = index;
            this.$refs.edit.show(data);
        },
        openActivation(type,data,index){
            this.index = index;
            this.selectedRow = index;
            this.$refs.activation.show(type,data);
        },
        updateData(data){
            this.lists[this.index] = data;
        },
        viewClass(index,data){
            this.index2 = index;
            this.filter.class = data;
        },
        filterAddress(){
            this.$refs.filter.show();
        },
        handleSubmit(data) {
            this.location.region = data.form.region;
            this.location.province = data.form.province?.value;
            this.location.municipality = data.form.municipality?.value;
            this.location.barangay = data.form.barangay?.value;
            this.fetch();
        },
        selectRow(index) {
            if (this.selectedRow === index) {
                this.selectedRow = null;
            } else {
                this.selectedRow = index;
            }
        }
    }
}
</script>
