<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" :title="objective + ' - Details'" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop size="lg">
        <BRow>
            <div class="col-md-12 mb-n4">
                <div class="card bg-light-subtle shadow-none border">
                    <div class="card-header bg-light-subtle mb-4">
                        <div class="d-flex mb-n1">
                           
                            <div class="flex-grow-1">
                               <div class="hstack gap-3 fs-12 flex-wrap">
                                    <div><i class="ri-calendar-line align-bottom me-1"></i> Period :
                                        <span class="fw-medium">{{ periodLabel }}</span>
                                    </div>
                                    <div class="vr" style="width: 1px;"></div>
                                    <div>Reported Total :
                                        <span class="fw-medium">{{ isAmount ? formatMoney(expectedTotal) : formatNumber(expectedTotal) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body bg-white rounded-bottom">
                        <div class="table-responsive table-card" style="margin-top: -39px; height: calc(100vh - 465px); overflow: auto;">
                            <table class="table align-middle table-centered table-striped mb-0">
                                <thead class="table-light thead-fixed">
                                    <tr class="fs-11">
                                        <th v-for="col in columns" :key="col.key" :class="col.class">{{ col.label }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="request in requests" :key="request.id">
                                        <td v-for="col in columns" :key="col.key" :class="col.class">
                                            {{ col.key === 'amount' ? formatMoney(request[col.key]) : request[col.key] }}
                                        </td>
                                    </tr>
                                    <tr v-if="requests.length === 0">
                                        <td :colspan="columns.length" class="text-center text-muted">No records found</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <Pagination class="ms-2 me-2 mt-n1" v-if="meta.total" :lists="requests.length" :links="links" :pagination="meta" @fetch="fetchRequests" />
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
import Pagination from "@/Shared/Components/Pagination.vue";

const COLUMN_SETS = {
    'Actual Fees Collected': [
        { key: 'code', label: 'TSR No.' },
        { key: 'customer', label: 'Customer' },
        { key: 'date', label: 'Date' },
        { key: 'amount', label: 'Amount', class: 'text-end' },
    ],
    'Firms Served': [
        { key: 'code', label: 'TSR No.' },
        { key: 'customer', label: 'Firm' },
        { key: 'date', label: 'Date' },
    ],
    'Customers Served': [
        { key: 'code', label: 'TSR No.' },
        { key: 'customer', label: 'Customer' },
        { key: 'date', label: 'Date' },
    ],
    'Samples Received': [
        { key: 'code', label: 'TSR No.' },
        { key: 'samples_count', label: 'No. of Samples', class: 'text-center' },
    ],
    'Services Conducted': [
        { key: 'code', label: 'TSR No.' },
        { key: 'samples_count', label: 'No. of Samples', class: 'text-center' },
        { key: 'analyses_count', label: 'No. of Analyses', class: 'text-center' },
    ],
};

export default {
    components: { Pagination },
    data(){
        return {
            showModal: false,
            objective: '',
            year: null,
            month: null,
            laboratoryId: null,
            facilityType: 'All',
            periodLabel: '',
            expectedTotal: 0,
            requestsLoading: false,
            requests: [],
            meta: {},
            links: {},
        }
    },
    computed: {
        columns(){
            return COLUMN_SETS[this.objective] || [];
        },
        isAmount(){
            return this.objective === 'Actual Fees Collected';
        }
    },
    methods: {
        show(objective, year, month, periodLabel, expectedTotal, facilityType, laboratoryId = null){
            this.objective = objective;
            this.year = year;
            this.month = month;
            this.laboratoryId = laboratoryId;
            this.facilityType = facilityType;
            this.periodLabel = periodLabel;
            this.expectedTotal = expectedTotal;
            this.requests = [];
            this.meta = {};
            this.links = {};
            this.showModal = true;
            this.fetchRequests();
        },
        fetchRequests(page_url){
            page_url = page_url || '/accomplishments';
            this.requestsLoading = true;
            axios.get(page_url, {
                params: {
                    option: 'objective-requests',
                    objective: this.objective,
                    year: this.year,
                    month: this.month,
                    facility_type: this.facilityType,
                    laboratory_id: this.laboratoryId,
                }
            })
            .then(response => {
                this.requests = response.data.data;
                this.meta = response.data.meta;
                this.links = response.data.links;
            })
            .catch(err => console.log(err))
            .finally(() => {
                this.requestsLoading = false;
            });
        },
        formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return '₱'+val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        formatNumber(value) {
            if (!value) return '0';
            return Number(value).toLocaleString(undefined, {
                minimumFractionDigits: 0,
                maximumFractionDigits: 2
            });
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>
