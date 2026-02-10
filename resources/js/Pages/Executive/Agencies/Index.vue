<template>
    <Head title="Agencies"/>
        <PageHeader title="Agency Management" pageTitle="List" />
        <BRow>
            <div class="col-md-12">
                <div class="card bg-light-subtle shadow-none border">
                    <div class="card-header bg-light-subtle">
                        <div class="d-flex mb-n3">
                            <div class="flex-shrink-0 me-3">
                                <div style="height:2.5rem;width:2.5rem;">
                                    <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                        <i class="ri-government-fill text-primary fs-24"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-0 fs-14"><span class="text-body">List of Agencies</span></h5>
                                <p class="text-muted text-truncate-two-lines fs-12">Shows all users with access to the application, along with their roles and permissions for managing system features</p>
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
                                    <input type="text" v-model="filter.keyword" placeholder="Search Agency" class="form-control" style="width: 30%;">
                                    <Multiselect class="white" style="width: 15%;" :options="members" v-model="filter.member" label="acronym" :searchable="true" placeholder="Select Member" />
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
                                        <i class="ri-apps-2-line me-1 align-bottom"></i> All Users
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
                            <table class="table align-middle table-centered mb-0">
                                <thead class="table-light thead-fixed">
                                    <tr class="fs-11">
                                        <th style="width: 3%;"></th>
                                        <th>Name</th>
                                        <th style="width: 10%;" class="text-center">Code</th>
                                        <th style="width: 12%;" class="text-center">Short</th>
                                        <th style="width: 12%;" class="text-center">Contact no.</th>
                                        <th style="width: 12%;" class="text-center">Status</th>
                                        <th style="width: 8%;"></th>
                                    </tr>
                                </thead>
                                <tbody class="table-white fs-12">
                                    <tr v-for="(list,index) in lists" v-bind:key="index" @click="selectRow(index)" 
                                    :class="{
                                        'bg-dark-subtle': selectedRow === index,
                                        'bg-success-subtle': list.is_active,
                                    }">
                                        <td class="text-center"> {{ (meta.current_page - 1) * meta.per_page + index + 1 }}.</td>
                                        <td>
                                            <h5 class="fs-12 mb-0" :class="(selectedRow === index) ? 'text-primary fw-bold' : 'text-dark'">{{list.member.name}}</h5>
                                            <p class="fs-12 mb-0" :class="(selectedRow === index) ? 'text-dark' : 'text-muted'">{{list.type.name}}</p>
                                        </td>
                                        <td class="text-center fs-12">{{list.short}}</td>
                                        <td class="text-center fs-12">{{list.name}}</td>
                                        <td class="text-center fs-12">{{(list.contact_no) ? list.contact_no : '-'}}</td>
                                        <td class="text-center fs-12">
                                            <span v-if="list.is_active" class="badge bg-success">Active</span>
                                            <span v-else class="badge bg-danger">Inactive</span>
                                        </td>
                                        <td class="text-end">
                                            <Link :href="`/agencies/${list.reference}`" v-if="list.is_active">
                                                <b-button variant="info" class="me-1" v-b-tooltip.hover title="View" size="sm">
                                                    <i class="ri-eye-fill align-bottom"></i>
                                                </b-button>
                                            </Link>
                                            <b-button v-else @click="openActivation(list,index)" variant="info" class="me-1" v-b-tooltip.hover title="View" size="sm">
                                                <i class="ri-eye-fill align-bottom"></i>
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
        <Create ref="create"/>
        <Activation @update="updateData" ref="activation"/>
    </template>
    <script>
    import _ from 'lodash';
    import Create from './Modals/Create.vue';
    import Activation  from './Modals/Activation.vue';
    import Multiselect from "@vueform/multiselect";
    import PageHeader from '@/Shared/Components/PageHeader.vue';
    import Pagination from "@/Shared/Components/Pagination.vue";
    export default {
        components: { PageHeader, Pagination, Multiselect, Activation, Create },
        props: ['members'],
        data(){
            return {
                currentUrl: window.location.origin,
                lists: [],
                meta: {},
                links: {},
                filter: {
                    keyword: null,
                    member: null
                },
                selectedRow: null,
                index: null,
                units: []
            }
        },
        watch: {
            "filter.role"(newVal){
                this.fetch();
            },
            "filter.agency"(newVal){
                this.fetch();
            },
            "filter.keyword"(newVal){
                this.checkSearchStr(newVal);
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
                page_url = page_url || '/agencies';
                axios.get(page_url,{
                    params : {
                        member: this.filter.member,
                        keyword: this.filter.keyword,
                        count: 10,
                        option: 'lists'
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
            openActivation(data,index){
                this.index = index;
                this.$refs.activation.show(data);
            },
            updateData(data){
                this.lists[this.index] = data;
            },
            selectRow(index) {
                this.selectedRow = index;
            }
        }
    }
    </script>