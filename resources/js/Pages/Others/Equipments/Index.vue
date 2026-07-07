<template>
    <Head title="Equipments"/>
    <PageHeader title="Equipments" pageTitle="Menu" />
    <b-row class="g-3">
        
        <div class="col-md-12">
            <div class="row g-3">

                <b-col lg="3">
                    <b-card no-body class="bg-info-subtle border shadow-none">
                        <b-card-body>
                            <div class="d-flex align-items-center" v-if="calibrateable">
                                <div class="avatar-xs flex-shrink-0">
                                    <span class="avatar-title bg-light text-primary rounded-circle fs-4">
                                        <i class="ri-pencil-ruler-2-fill align-middle`"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase text-truncate fw-semibold fs-10 text-muted mb-1">
                                    {{ calibrateable.name }}
                                    </p>
                                    <h4 class="mb-0">
                                        <span class="counter-value">{{ calibrateable.count }}</span>
                                    </h4>
                                </div>
                            </div>
                        </b-card-body>
                    </b-card>
                </b-col>


                <b-col lg="6">
                    <div class="row g-3">
                        <b-col lg="4" v-for="(item, index) of counts" :key="index" style="cursor: pointer;" @click="filterStatus(item.value)">
                            <b-card no-body class="border shadow-none">
                                <b-card-body>
                                    <div class="d-flex align-items-center">
                                        <div style="height:2.5rem;width:2.5rem;">
                                            <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                                                <i :class="`${icons[index]} align-middle`"></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="text-uppercase text-truncate fw-semibold fs-12 text-muted mb-1">
                                                {{ item.name }}
                                            </p>
                                            <h4 class="mb-0 fs-17">
                                                <span class="counter-value">{{item.count}}</span>
                                            </h4>
                                        </div>
                                        <div class="flex-shrink-0 align-self-end">
                                        </div>
                                    </div>
                                </b-card-body>
                            </b-card>
                        </b-col>
                    </div>
                </b-col>

                <b-col lg="3">
                    <b-card no-body class="bg-success-subtle border shadow-none">
                        <b-card-body>
                            <div class="d-flex align-items-center" v-if="maintenanceable">
                                <div class="avatar-xs flex-shrink-0">
                                    <span class="avatar-title bg-light text-primary rounded-circle fs-4">
                                        <i class="ri-todo-fill align-middle`"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase text-truncate fw-semibold fs-10 text-muted mb-1">
                                    {{ maintenanceable.name }}
                                    </p>
                                    <h4 class="mb-0">
                                        <span class="counter-value">{{ maintenanceable.count }}</span>
                                    </h4>
                                </div>
                            </div>
                        </b-card-body>
                    </b-card>
                </b-col>

            </div>
        </div>

        <div class="col-md-3 mt-n2" v-if="!show">
           
            <div class="card shadow-none border">
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3 mt-1">
                            <div style="height:2rem;width:2rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-secure-payment-fill text-primary fs-20"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 mt-0 fs-13"><span class="text-body">Calibration Notice</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-11">Highlights urgency and updates</p>
                        </div>
                    </div>
                </div>
                <div class="card border-bottom shadow-none" no-body style="height: 431px;">
                    <b-list-group flush>
                            <BListGroupItem @click="filterReminder(list.name)" v-for="(list,index) in calibrations" v-bind:key="index" style="cursor: pointer;" :class="(isActive(list.name)) ? 'bg-info-subtle' : ''">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-xs">
                                            <div class="avatar-title rounded" :class="list.color">
                                                <i :class="list.icon+' '+list.color"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5 class="mb-0 fs-12">{{list.name}}</h5>
                                        <p class="mb-0 fs-11 text-muted">{{list.description}}</p>
                                    </div>
                                    <span class="text-muted fs-12">{{list.count}} </span>
                                </div>
                            </BListGroupItem>
                        </b-list-group>
                    
                </div>
            </div>
        </div>
        
                
        <b-col :lg="(show) ? '12' : '6'" class="mt-n2">
            <div class="card bg-light-subtle shadow-none border">
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3 mt-1">
                            <div style="height:2rem;width:2rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-trophy-fill text-primary fs-20"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-13"><span class="text-body">List of Equipments </span></h5>
                            <p class="text-muted text-truncate-two-lines fs-11">Shows all equipment due for calibration and maintenance.</p>
                        </div>
                        <div class="flex-shrink-0" >
                            <button v-if="!show" @click="showInfo()" type="button" class="btn btn-soft-info btn-sm material-shadow-none mt-1">
                                <i class="ri-file-list-3-line align-middle"></i> Show Information
                            </button>
                            <button v-else @click="showInfo()" type="button" class="btn btn-soft-info btn-sm material-shadow-none mt-1">
                                <i class="ri-file-list-3-line align-middle"></i> Hide Information
                            </button>
                        </div>
                    </div>
                </div>
                <div class="car-body bg-white border-bottom shadow-none">
                    <b-row class="mb-2 ms-1 me-1" style="margin-top: 12px;">
                        <b-col lg>
                            <div class="input-group mb-1">
                                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                                <input type="text" v-model="filter.keyword" placeholder="Search Request" class="form-control" style="width: 20%;">
                                <input v-if="filter.datetype" type="date" v-model="filter.date" placeholder="Search Request" class="form-control" style="width: 100px;">
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
                <div class="card-body border-bottom shadow-none" no-body>
                    <div class="table-responsive table-card" style="height: calc(100vh - 500px); overflow: auto;">
                        <table class="table align-middle table-centered mb-0">
                            <thead class="table-light thead-fixed">
                                <tr class="fs-11">
                                    <th style="width: 4%;"></th>
                                    <th>Equipment</th>
                                    <th v-if="show" style="width: 13%;" class="text-center">Last Calibration</th>
                                    <th :style="{ width: show ? '13%' : '20%' }" class="text-center">Calibration Due</th>
                                    <th v-if="show" style="width: 13%;" class="text-center">Last Maintenance</th>
                                    <th :style="{ width: show ? '13%' : '20%' }" class="text-center">Maintenance Due</th>
                                    <th style="width: 15%;" class="text-center">Status</th>
                                    <th v-if="show" style="width: 8%;" ></th>
                                </tr>
                            </thead>
                            <tbody class="table-white">
                                 <!-- @click="$inertia.visit(`/equipments/${list.reference}`)" -->
                                <tr v-for="(list,index) in lists" v-bind:key="index" style="cursor: pointer;">
                                    <td class="text-center fs-12"> 
                                    {{ (meta.current_page - 1) * meta.per_page + index + 1 }}.
                                    </td>
                                    <td  @click="$inertia.visit(`/equipments/${list.reference}`)">
                                        <h5 class="fs-12 mb-0 fw-semibold text-primary">{{list.code}}</h5>
                                        <p class="fs-12 text-muted mb-0">{{list.name}}</p>
                                    </td>
                                    <td v-if="show" class="text-center fs-12">
                                        <span v-if="list.calibration_program == 'Not Applicable'" class="text-muted fs-11">Not Applicable</span>
                                        <span v-else>{{ list.last_calibration }}</span>
                                    </td>
                                    <td class="text-center fs-11">
                                        <span v-if="list.calibration_program == 'Not Applicable'" class="text-muted fs-11">Not Applicable</span>
                                        <span v-else-if="isDue(list.calibration_due)" class="badge bg-danger">{{ list.calibration_due }}</span>
                                        <span v-else>{{ list.calibration_due }}</span>
                                    </td>
                                    <td v-if="show" class="text-center fs-12">
                                        <span v-if="list.status.name  == 'Disposed' || list.status.name  == 'Not in Use'" class="text-muted fs-11">-</span>
                                        <span v-else>{{list.last_maintenance}}</span>
                                    </td>
                                    <td class="text-center fs-11">
                                        <span v-if="list.status.name  == 'Disposed' || list.status.name  == 'Not in Use'" class="text-muted fs-11">-</span>
                                        <span v-else-if="isDue(list.maintenance_due)"
                                            class="badge bg-danger"
                                        >
                                            {{ list.maintenance_due }}
                                        </span>
                                        <span v-else>
                                            {{ list.maintenance_due }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span :class="'badge '+list.status.color">{{list.status.name}}</span>
                                    </td>
                                    <td class="text-end" v-if="show">
                                        <b-button @click="openView(list,index)" variant="soft-info" class="me-1" v-b-tooltip.hover title="View" size="sm">
                                            <i class="ri-eye-fill align-bottom"></i>
                                        </b-button>
                                        <b-button  @click="openEdit(list,index)" variant="soft-warning" v-b-tooltip.hover title="Edit" size="sm">
                                            <i class="ri-pencil-fill align-bottom"></i>
                                        </b-button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <Pagination class="ms-2 me-2 mt-n1" v-if="meta" @fetch="fetchList" :lists="lists.length" :links="links" :pagination="meta" />
                </div>
            </div>
        </b-col>

        <div class="col-md-3 mt-n2" v-if="!show">
            <div class="card bg-light-subtle shadow-none border">
                
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3 mt-1">
                            <div style="height:2rem;width:2rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-group-2-fill text-primary fs-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-13"><span class="text-body">Maintenance Notice</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-11">A summary of tasks completed</p>
                        </div>
                    </div>
                </div>
                <div class="card border-bottom shadow-none" no-body style="height: 431px;">
                    <b-list-group flush>
                        <BListGroupItem @click="filterReminder(list.name)"  v-for="(list,index) in maintenances" v-bind:key="index" style="cursor: pointer;" :class="(isActive(list.name)) ? 'bg-info-subtle' : ''">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="avatar-xs">
                                        <div class="avatar-title rounded" :class="list.color">
                                            <i :class="list.icon+' '+list.color"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-0 fs-12">{{list.name}}</h5>
                                    <p class="mb-0 fs-11 text-muted">{{list.description}}</p>
                                </div>
                                <span class="text-muted fs-12">{{list.count}} </span>
                            </div>
                        </BListGroupItem>
                    </b-list-group>
                </div>
            </div>
        </div>
        <Create @message="fetchList()" :dropdowns="dropdowns" ref="create"/>
        <View @success="updateStatus" @update="updateData" ref="view"/>
    </b-row>
</template>
<script>
import _ from 'lodash';
import View from './Modals/View.vue';
import Create from './Modals/Create.vue';
import Multiselect from "@vueform/multiselect";
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { PageHeader, Multiselect, Pagination, Create, View },
    props: ['dropdowns','years'],
    data(){
        return {
            lists: [],
            meta: {},
            links: {},
            name: null,
            filter: {
                keyword: null,
                status: null,
                laboratory: null,
                reminder: null,
            },
            icons: ['ri-checkbox-circle-fill text-success','ri-error-warning-fill text-danger','ri-close-circle-fill text-warning'],
            counts: [],
            calibrateable: null,
            maintenanceable: null,
            calibrations: [],
            maintenances: [],
            activeList: null,
            show: false
        }
    },
    created(){
        this.fetch();
        this.fetchList();
    },
    watch: {
        "filter.keyword"(newVal){
            this.checkSearchStr(newVal)
        },
        "filter.laboratory"(newVal){
            this.fetchList();
        }
    },
    methods: {
        showInfo(){
            this.show = (this.show) ? false : true;
        },
        fetch(){
            axios.get('/equipments',{
                params : {
                    option: 'fetch',
                }
            })
            .then(response => {
                this.calibrations = response.data.calibrations;
                this.maintenances = response.data.maintenances;
                this.maintenanceable = response.data.maintenanceable;
                this.calibrateable = response.data.calibrateable;
                this.counts = response.data.counts; 
            })
            .catch(err => console.log(err));
        },
        checkSearchStr: _.debounce(function(string) {
            this.fetchList();
        }, 300),
        fetchList(page_url){
            page_url = page_url || '/equipments';
            axios.get(page_url,{
                params : {
                    status: this.filter.status,
                    keyword: this.filter.keyword,
                    laboratory: this.filter.laboratory,
                    reminder: this.filter.reminder,
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
        handleResponse(data, activeList) {
            this.$refs.lists.filterReminder(data,activeList);
        },
        filterStatus(status){
            this.filter.status = status;
            this.fetchList();
        },
        filterReminder(data){
            if(data == this.activeList){
                this.activeList = null;
            }else{
                this.activeList = data;
            }
            // this.filterReminder(data,this.activeList,this.laboratory);

            if(this.activeList){
                this.name = data;
                this.filter.keyword = null;
                this.filter.laboratory = null;
                this.filter.reminder = data;
                this.fetchList();
            }else{
                this.refresh();
            }
        },
        openCreate(){
            this.$refs.create.show();
        },
        openEdit(data,index){
            this.index = index;
            this.$refs.create.edit(data);
        },
        openView(data,index){
            this.index = index;
            this.$refs.view.show(data);
        },
        refresh(){
            this.name = 'Equipment';
            this.filter.reminder = null;
            this.filter.laboratory = null;
            this.fetchList();
        },
        isActive(name) {
            return this.activeList === name;
        },
        updateStatus(data){
            this.lists[this.index].status = data;
        },
        isDue(date) {
            if (!date) return false;
            const today = new Date();
            const due = new Date(date);
            // Remove time part to compare only date
            today.setHours(0, 0, 0, 0);
            due.setHours(0, 0, 0, 0);
            return due <= today;
        },
    }
}
</script>