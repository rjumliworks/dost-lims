<template>
    <Head title="History"/>
    <PageHeader title="TSR History" pageTitle="History" />
    <BRow>
        <div class="col-md-12">
            <div class="card bg-light-subtle shadow-none border">

                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height:2.5rem;width:2.5rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-history-line text-primary fs-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-14"><span class="text-body">TSR Change History</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">Track every change made to TSRs, samples, analyses, amendments, payments, and releases.</p>
                        </div>
                    </div>
                </div>

                <div class="car-body bg-white border-bottom shadow-none">
                    <b-row class="mb-2 ms-1 me-1 align-items-center" style="margin-top: 12px;">
                        <b-col lg="4">
                            <div class="input-group mb-1">
                                <span class="input-group-text"><i class="ri-search-line search-icon"></i></span>
                                <input type="text" v-model="filter.code" @keyup.enter="searchTsr" placeholder="Search by TSR code, e.g. R9-072026-MET-0537" class="form-control">
                                <b-button v-if="tsrView" type="button" variant="light" @click="clearSearch">
                                    Clear
                                </b-button>
                                <b-button v-else type="button" variant="primary" @click="searchTsr">
                                    Search
                                </b-button>
                            </div>
                        </b-col>
                        <b-col lg="2">
                            <select v-model="filter.month" @change="fetch()" class="form-select" :disabled="tsrView">
                                <option :value="null">All Months</option>
                                <option v-for="(name, index) in months" :key="index" :value="index + 1">{{ name }}</option>
                            </select>
                        </b-col>
                        <b-col lg="2">
                            <select v-model="filter.year" @change="fetch()" class="form-select" :disabled="tsrView">
                                <option :value="null">All Years</option>
                                <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
                            </select>
                        </b-col>
                        <b-col lg="4" class="text-end">
                            <span v-if="tsrView" class="fs-12 text-muted">
                                Showing full history for <span class="fw-semibold text-body">{{ tsrView.code }}</span>
                            </span>
                        </b-col>
                    </b-row>
                </div>

                <div class="card-body bg-white rounded-bottom">
                    <div class="table-responsive table-card" style="height: calc(100vh - 430px); overflow: auto;">
                        <table class="table align-middle table-striped table-centered mb-0">
                            <thead class="table-light thead-fixed">
                                <tr class="fs-11">
                                    <th style="width: 3%;"></th>
                                    <th style="width: 12%;">Date</th>
                                    <th style="width: 12%;">TSR Code</th>
                                    <th style="width: 14%;">Type</th>
                                    <th style="width: 10%;" class="text-center">Event</th>
                                    <th style="width: 15%;">Changed By</th>
                                    <th></th>
                                    <th style="width: 6%;"></th>
                                </tr>
                            </thead>
                            <tbody class="table-white fs-12" v-if="lists.length > 0">
                                <tr v-for="(list,index) in lists" v-bind:key="list.id">
                                    <td>{{ index + 1 }}.</td>
                                    <td>{{ formatDate(list.created_at) }}</td>
                                    <td>
                                        <a v-if="list.tsr_code" href="#" @click.prevent="viewTsr(list.tsr_code)" class="fw-semibold text-primary">
                                            {{ list.tsr_code }}
                                        </a>
                                        <span v-else class="text-muted">—</span>
                                    </td>
                                    <td>{{ list.log_name }}</td>
                                    <td class="text-center"><span class="badge bg-info-subtle text-info text-capitalize">{{ list.event }}</span></td>
                                    <td>{{ list.causer?.name || '—' }}</td>
                                    <td></td>
                                    <td class="text-end">
                                        <b-button @click="openLog(list)" variant="soft-info" v-b-tooltip.hover title="View changes" size="sm">
                                            <i class="ri-eye-fill align-bottom"></i>
                                        </b-button>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="8" class="text-center text-muted">No history records found.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer" v-if="!tsrView">
                    <Pagination class="ms-2 me-2 mt-n1" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
                </div>
            </div>
        </div>
    </BRow>
    <Log ref="log"/>
</template>
<script>
import Log from './Modals/Log.vue';
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { PageHeader, Pagination, Log },
    data(){
        return {
            lists: [],
            meta: {},
            links: {},
            tsrView: null,
            filter: {
                code: null,
                month: null,
                year: null,
            },
            months: [
                'January','February','March','April','May','June',
                'July','August','September','October','November','December'
            ],
        }
    },
    computed: {
        years() {
            const propYears = this.$page.props.years;
            if (propYears && propYears.length) {
                return propYears;
            }
            const current = new Date().getFullYear();
            return [current, current - 1, current - 2, current - 3, current - 4];
        }
    },
    created(){
        this.fetch();
    },
    methods: {
        fetch(page_url){
            page_url = page_url || '/history';
            axios.get(page_url,{
                params : {
                    option: 'list',
                    month: this.filter.month,
                    year: this.filter.year,
                    count: 20
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
        searchTsr(){
            if(!this.filter.code){
                return;
            }
            this.viewTsr(this.filter.code);
        },
        viewTsr(code){
            this.filter.code = code;
            axios.get('/history', {
                params: {
                    option: 'tsr',
                    code: code
                }
            })
            .then(response => {
                this.tsrView = response.data.tsr;
                this.lists = response.data.activities;
                this.meta = {};
                this.links = {};
            })
            .catch(err => console.log(err));
        },
        clearSearch(){
            this.filter.code = null;
            this.tsrView = null;
            this.fetch();
        },
        openLog(data){
            this.$refs.log.show(data);
        },
        formatDate(dateString) {
            const date = new Date(dateString)

            return date.toLocaleString('en-PH', {
                year: 'numeric',
                month: 'long',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                hour12: true,
            })
        }
    }
}
</script>
