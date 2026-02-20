<template>
<Head title="Sample Register"/>
    <PageHeader title="Sample Register" pageTitle="Laboratory" />
    <BRow>
        <div class="col-md-12">
            <div class="card bg-light-subtle shadow-none border">
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height:2.5rem;width:2.5rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-flask-fill text-primary fs-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-14"><span class="text-body">List of Samples</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">Register incoming samples and monitor their status throughout the testing process.</p>
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
                                <input type="text" v-model="filter.keyword" placeholder="Search Sample" class="form-control" style="width: 30%;">
                                <input type="text" v-model="filter.sample" placeholder="Search Sample name" class="form-control">
                                <Multiselect class="white" style="width: 20%;" :options="laboratories" :searchable="true" v-model="filter.code" label="name" placeholder="Filter Laboratory" />
                                <span @click="refresh()" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;"> 
                                    <i class="bx bx-refresh search-icon"></i>
                                </span>
                                <b-button type="button" variant="primary" :disabled="!samples.length > 0" @click="openUpdate">
                                    Update
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
                                    <i class="ri-apps-2-fill me-1 align-bottom"></i> All Samples
                                    </BLink>
                                </li>
                                <li class="nav-item">
                                    <BLink @click="viewStatus(0,0)" class="nav-link py-3" :class="(this.index == 0) ? 'text-warning active' : ''" data-bs-toggle="tab" role="tab" aria-selected="true">
                                    <i class="ri-close-circle-line me-1 align-bottom"></i> Pending <BBadge v-if="counts[0] > 0" class="bg-warning align-middle ms-1">{{counts[0]}}</BBadge>
                                    </BLink>
                                </li>
                                <li class="nav-item">
                                    <BLink @click="viewStatus(1,1)" class="nav-link py-3" :class="(this.index == 1) ? 'text-success active' : ''" data-bs-toggle="tab" role="tab" aria-selected="true">
                                    <i class="ri-checkbox-circle-line me-1  align-bottom"></i> Completed <BBadge v-if="counts[1] > 0" class="bg-success align-middle ms-1">{{counts[1]}}</BBadge>
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
                                    <th v-if="filter.code" class="text-center" style="width: 4%;">
                                        <input class="form-check-input fs-16" v-model="mark" type="checkbox" value="option" />
                                    </th>
                                    <th style="width: 3%;" v-else></th>
                                    <th>Code</th>
                                    <th style="width: 10%;" class="text-center">Analyses</th>
                                    <th style="width: 15%;" class="text-center">Received Date</th>
                                    <th style="width: 15%;" class="text-center">Due Date</th>
                                    <th style="width: 10%" class="text-center">Status</th>
                                    <th style="width: 15%;" class="text-center">Manner of Disposal</th>
                                    <th style="width: 10%;" class="text-center">Disposed Date</th>
                                    <th style="width: 7%;" ></th>
                                </tr>
                            </thead>
                            <tbody class="fs-12">
                                <tr v-for="(list,index) in lists" v-bind:key="index" :class="getRowClass(list, index)">
                                    <td class="text-center fs-14" v-if="filter.code"> 
                                        <i v-if="list.is_completed" class="text-success ri-checkbox-circle-fill fs-18"></i>
                                        <!-- <i v-else-if="countOngoing(list.analyses) > 0" class="text-info ri-checkbox-circle-fill fs-18"></i> -->
                                        <input v-else type="checkbox" v-model="list.selected" class="form-check-input" />
                                    </td>
                                    <td class="text-center" v-else> 
                                        {{ (meta.current_page - 1) * meta.per_page + index + 1 }}.
                                    </td>
                                    <td>
                                        <h5 class="fs-13 mb-0 fw-semibold text-primary">{{list.code}}</h5>
                                        <p class="fs-13 text-muted mb-0">{{list.name}}</p>
                                    </td>
                                    <td class="text-center">{{ countCompleted(list.analyses) }} of {{ list.analyses.length }} </td>
                                    <td class="text-center">{{ list.created_at }}</td>
                                    <td class="text-center">{{ list.due_at }}</td>
                                    <td class="text-center">
                                        <span v-if="list.is_completed" class="badge bg-success">Completed</span>
                                        <span v-else-if="countOngoing(list.analyses) > 0" class="badge bg-info">Ongoing</span>
                                        <span v-else class="badge bg-warning">Pending</span>
                                    </td>
                                    <td class="text-center">{{ (list.is_disposed) ? list.disposal.disposal : '-' }}</td>
                                    <td class="text-center">{{ (list.is_disposed) ? list.disposal.disposed_at : '-' }}</td>
                                    <td class="text-end">
                                        <a :href="`/samples/${list.reference}`" target="_blank" @click="selectedIndex = index">
                                            <b-button variant="soft-info" class="me-1" v-b-tooltip.hover title="View" size="sm">
                                                <i class="ri-eye-fill align-bottom"></i>
                                            </b-button>
                                        </a>
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
    <!-- <Update @update="updateList" ref="update"/> -->
</template>
<script>
import _ from 'lodash';
// import Update from './Modals/Update.vue';
import Multiselect from "@vueform/multiselect";
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { PageHeader, Pagination, Multiselect },
    props: ['counts','laboratories'],
    data(){
        return {
            lists: [],
            meta: {},
            links: {},
            filter: {
                keyword: null,
                month: null,
                code: null,
                sample: null,
                status: null
            },
            tsrs: [],
            statuses: [
                { value: 0, name: 'Pending' },
                { value: 1, name: 'Completed' },
            ],
            mark: false,
            index: null,
            selectedIndex: null,
        }
    },
    watch: {
        "filter.keyword"(newVal){
            this.checkSearchStr(newVal);
        },
        "filter.month"(newVal){
            this.fetch();
        },
        "filter.code"(newVal){
            this.fetch();
        },
        "filter.sample"(newVal){
            this.checkSearchStr(newVal);
        },
        mark(){
            if(this.mark){
                this.lists.forEach(item => {
                    if(item.is_completed){ //&& this.countOngoing(item.analyses) > 
                        item.selected = false;
                    }else{
                        item.selected = true;
                    }
                    
                });
            }else{
                this.lists.forEach(item => {
                    item.selected = false;
                });
            }
        }
    },
    created(){
        this.fetch();
    },
    computed : {
        samples() {
            return this.lists
                .filter(item => item.selected);
        }
    },
    methods: {
        checkSearchStr: _.debounce(function(string) {
            this.fetch();
        }, 300),
        fetch(page_url){
            page_url = page_url || '/samples';
            axios.get(page_url,{
                params : {
                    keyword: this.filter.keyword,
                    laboratory: this.filter.laboratory,
                    code: (this.filter.code) ? this.filter.code.name : null,
                    sample: this.filter.sample,
                    status: this.filter.status,
                    count: (this.filter.code) ? null : 10,
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
        fetchTsrs(code){
            axios.get('/search',{
                params: {
                    option: 'tsrsamples',
                    keyword: code
                }
            })
            .then(response => {
                this.tsrs = response.data;
            })
            .catch(err => console.log(err));
        },
        viewStatus(status,index){
            this.index = index;
            this.filter.status = status;
            this.fetch();
        },
        getRowClass(list, index) {
            if(this.filter.status == null){
                if (list.selected === true) {
                    return 'bg-dark-subtle';
                }
                if (this.selectedIndex === index) {
                    return 'bg-dark-subtle';
                }
                if(this.countOngoing(list.analyses) > 0){
                    return 'bg-info-subtle';
                }
                if (this.isOverdue(list.due_at, list.is_completed)) {
                    return 'bg-danger-subtle';
                }
                if (this.isDueApproaching(list.due_at, list.is_completed)) {
                    return 'bg-warning-subtle';
                }
                if (list.is_completed == 1) {
                    return 'bg-success-subtle';
                }
            }else{
                return '';
            }
        },
        updateList(data){
            this.mark = false;
            this.lists = data;
        },
        countCompleted(items){
            return items.filter(item => item.status.name === 'Completed').length;
        },
        countOngoing(items){
            return items.filter(item => item.status.name === 'Ongoing').length;
        },
        isDueApproaching(dueDate,status) {
            if (status == 0 ){
                const today = new Date();
                const due = new Date(dueDate);
                const diffTime = due - today;
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                return diffDays <= 5 && diffDays >= 0; 
            }else{
                return false;
            }
           
        },
        isOverdue(dueDate,status) {
            if(status == 0){
                if (dueDate){ 
                    const today = new Date();
                    const due = new Date(dueDate);
                    return due <= today;
                }
            }else{
                return false;
            }
        },
        openUpdate(){
            this.$refs.update.show(this.samples);
        }
    }
}
</script>