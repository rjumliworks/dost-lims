<template>
    <Head title="Dashboard"/>
    <PageHeader title="Dashboard" pageTitle="Menu" />
    <b-row class="g-3">


        <div class="col-md-12">
            <b-card no-body class="bg-white-subtle border shadow-none">
                <b-card-body>
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex flex-lg-row flex-column">
                                <div class="flex-grow-1">
                                    <h4 class="fs-14 mb-0">{{monthName}} Summary View</h4>
                                    <p class="text-muted mb-0">Here's what's happening with the laboratory for month of {{monthName}}.</p>
                                </div>
                                <div class="mt-3 mt-lg-0">
                                    <form action="javascript:void(0);">
                                        <div class="row g-3 mb-0 align-items-center">
                                            <div class="col-sm-auto">
                                                <div class="input-group">
                                                    <select style="width: 250px;" v-model="filter.laboratory" class="form-select" aria-label="Default select example">
                                                        <option :value="null">All Laboratories</option>
                                                        <option :value="list.value" v-for="list in dropdowns.laboratories" v-bind:key="list.value">{{list.name}}</option>
                                                    </select>
                                                    <select style="width: 160px;" v-model="monthName" class="form-select" aria-label="Default select example">
                                                        <option :value="null">All Months</option>
                                                        <option :value="list" v-for="list in months" v-bind:key="list">{{list}}</option>
                                                    </select>
                                                    <select style="width: 100px;" v-model="filter.year" class="form-select" aria-label="Default select example">
                                                        <option :value="null">All Years</option>
                                                        <option :value="list" v-for="list in years" v-bind:key="list">{{list}}</option>
                                                    </select>
                                                    <div class="input-group-text bg-primary border-primary text-white">
                                                        <i class="ri-calendar-2-line"></i> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </b-card-body>
            </b-card>
        </div>


        <div class="col-md-12 mt-n2">
            <div class="row g-3">

                <div class="col-md-3">
                    <div class="row g-3">
                        <div class="col-12">
                            <b-card no-body class="bg-info-subtle border shadow-none">
                                <b-card-body>
                                    <div class="d-flex align-items-center" v-if="disposed">
                                        <div class="avatar-xs flex-shrink-0">
                                            <span class="avatar-title bg-light text-primary rounded-circle fs-4">
                                                <i class="ri-delete-bin-6-line align-middle"></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="text-uppercase text-truncate fw-semibold fs-10 text-muted mb-1">
                                            {{ disposed.name }}
                                            </p>
                                            <h4 class="mb-0">
                                                <span class="counter-value">{{ disposed.total }}</span>
                                            </h4>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <p class="card-text placeholder-glow mb-1">
                                            <span class="placeholder col-7"></span>
                                            <span class="placeholder col-4"></span>
                                            <span class="placeholder col-4"></span>
                                            <span class="placeholder col-6"></span>
                                        </p>
                                    </div>
                                </b-card-body>
                            </b-card>
                        </div>

                        <div class="col-12 mt-n2">
                            <div class="card shadow-none border">
                                <div class="card-header bg-light-subtle">
                                    <div class="d-flex mb-n3">
                                        <div class="flex-shrink-0 me-3 mt-1">
                                            <div style="height:2rem;width:2rem;">
                                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                                    <i class="ri-alarm-warning-fill text-primary fs-20"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h5 class="mb-0 mt-0 fs-13"><span class="text-body">Request Monitoring & Alerts</span></h5>
                                            <p class="text-muted text-truncate-two-lines fs-11">Highlights urgency and updates</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card border-bottom shadow-none" no-body style="height: calc(100vh - 494px)">
                                    <ul class="list-group list-group-flush border-dashed mb-0 p-3">
                                    <li class="list-group-item px-0" v-for="(list,index) in disposals" v-bind:key="index">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 avatar-xs">
                                                <span class="avatar-title bg-light p-1 rounded-circle">
                                                    <i :class="list.icon+' '+list.color"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <h6 class="mb-0 fs-12">{{list.name}}</h6>
                                                <p class="fs-11 mb-0 text-muted">{{ list.description }}</p>
                                            </div>
                                            <div class="flex-shrink-0 text-end">
                                                <h6 class="mt-2 fs-12">{{list.total}}</h6>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="row g-3 mb-n2">
                        <template v-if="overview.length > 0">
                            <div class="col-md-4" v-for="(item, index) in overview" :key="index">
                                <b-card no-body class="border shadow-none">
                                    <b-card-body>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-xs flex-shrink-0">
                                                <span class="avatar-title bg-light rounded-circle fs-4">
                                                    <i :class="item.icon+' '+item.color"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <p class="text-uppercase text-truncate fw-semibold fs-10 text-muted mb-1">
                                                    {{ item.name }}
                                                </p>
                                                <h4 class="mb-0">
                                                    <span class="counter-value">{{ item.total }}</span>
                                                </h4>
                                            </div>
                                        </div>
                                    </b-card-body>
                                </b-card>
                            </div>
                        </template>
                        <template v-else>
                            <div class="col-md-4" v-for="n in 3" :key="n">
                                <b-card no-body class="border shadow-none">
                                    <b-card-body>
                                        <p class="card-text placeholder-glow mb-1">
                                            <span class="placeholder col-7"></span>
                                            <span class="placeholder col-4"></span>
                                            <span class="placeholder col-4"></span>
                                            <span class="placeholder col-6"></span>
                                        </p>
                                    </b-card-body>
                                </b-card>
                            </div>
                        </template>
                    </div>

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
                                    <h5 class="mb-0 fs-13"><span class="text-body">Sample Disposal Queue</span></h5>
                                    <p class="text-muted text-truncate-two-lines fs-11">Samples awaiting disposal and their disposal history</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="input-group" style="width: 220px;">
                                        <span class="input-group-text bg-white"><i class="ri-search-line search-icon"></i></span>
                                        <input type="text" v-model="filter.keyword" placeholder="Search Code" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body bg-white rounded-bottom">
                            <div class="table-responsive table-card" style="height: calc(100vh - 525px)">
                                <table class="table align-middle table-centered mb-0">
                                    <thead class="table-light thead-fixed">
                                        <tr class="fs-11">
                                            <th style="width: 4%;"></th>
                                            <th>Code</th>
                                            <th style="width: 20%;" class="text-center">Manner of Disposal</th>
                                            <th style="width: 18%;" class="text-center">Disposed By</th>
                                            <th style="width: 13%;" class="text-center">Due date</th>
                                            <th style="width: 13%;" class="text-center">Disposed Date</th>
                                            <th style="width: 10%;" class="text-center">Status</th>
                                            <th style="width: 5%;" ></th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-white fs-12">
                                        <tr v-for="(list,index) in lists" v-bind:key="index">
                                            <td class="text-center">
                                                {{ (meta.current_page - 1) * meta.per_page + index + 1 }}.
                                            </td>
                                            <td>
                                                <h5 class="fs-13 mb-0 fw-semibold text-primary">{{list.sample.code}}</h5>
                                                <p class="fs-13 text-muted mb-0">{{list.sample.name}}</p>
                                            </td>
                                            <td class="text-center">{{list.disposal}}</td>
                                            <td class="text-center">{{list.user}}</td>
                                            <td class="text-center">{{list.due_at}}</td>
                                            <td class="text-center" v-if="list.status.name == 'Completed'">{{list.disposed_at}}</td>
                                            <td class="text-center" v-else>{{timeAgo(list.created_at)}}</td>
                                            <td class="text-center">
                                                <span :class="'badge '+list.status.color">{{list.status.name}}</span>
                                            </td>
                                            <td class="text-end">
                                                <b-button v-if="list.status.name == 'Pending'" @click="openDispose(list,index)" variant="soft-danger" v-b-tooltip.hover title="Dispose" size="sm">
                                                    <i class="ri-delete-bin-2-fill align-bottom"></i>
                                                </b-button>
                                                <b-button v-else @click="openCancel(list)" variant="soft-info" v-b-tooltip.hover title="View" size="sm">
                                                    <i class="ri-eye-fill align-bottom"></i>
                                                </b-button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <Pagination class="ms-2 me-2 mt-n1" v-if="meta.total" @fetch="fetchList" :lists="lists.length" :links="links" :pagination="meta" />
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </b-row>
    <Create :disposals="disposals" @success="onDisposed" ref="disposal"/>
</template>
<script>
import _ from 'lodash';
import Create from './Modals/Create.vue';
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { PageHeader, Pagination, Create },
    props: ['dropdowns','years'],
    data(){
        return {
            lists: [],
            meta: {},
            links: {},
            monthName: null,
            months: ['January','February','March','April','May','June','July','August','September','October','November','December'],
            filter: {
                keyword: null,
                laboratory: null,
                year: new Date().getFullYear()
            },
            disposals: [],
            disposed: null,
            overview: []
        }
    },
    watch: {
        'filter.laboratory'(val){
            this.fetch();
            this.fetchList();
        },
        'filter.keyword'(val){
            this.checkSearchStr(val);
        },
        'monthName'(val) {
            this.fetch();
        },
        'filter.year'(val) {
            this.fetch();
            this.fetchList();
        },
    },
    created(){
        this.fetch();
        this.fetchList();
    },
    methods: {
        fetch(){
            axios.get('/fetch',{
                params : {
                    year: this.filter.year,
                    month: this.monthName,
                    laboratory: this.filter.laboratory,
                    option: 'labaide',
                }
            })
            .then(response => {
                this.disposals = response.data.disposals;
                this.disposed = response.data.disposed;
                this.overview = response.data.overview;
            })
            .catch(err => console.log(err));
        },
        checkSearchStr: _.debounce(function(string) {
            this.fetchList();
        }, 300),
        fetchList(page_url){
            page_url = page_url || '/samples';
            axios.get(page_url,{
                params : {
                    keyword: this.filter.keyword,
                    count: 15,
                    laboratory: this.filter.laboratory,
                    year: this.filter.year,
                    option: 'disposals'
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
        timeAgo(date) {
            const createdDate = new Date(date);
            const now = new Date();
            const diffTime = Math.abs(now - createdDate);
            const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));

            if (diffDays === 0) return "Today";
            if (diffDays === 1) return "1 day ago";
            return `${diffDays} days ago`;
        },
        openDispose(data,index){
            this.index = index;
            this.$refs.disposal.show(data);
        },
        openCancel(data){
            window.open('/samples/'+data.reference, '_blank');
        },
        onDisposed(){
            this.fetch();
            this.fetchList();
        },
    }
}
</script>