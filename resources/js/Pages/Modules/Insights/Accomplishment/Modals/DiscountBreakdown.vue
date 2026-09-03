<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" title="Values of Assistance Rendered - Breakdown by Discount Type" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop size="lg">
        <BRow>
            <div class="col-md-12 mb-n4">
                <div class="card bg-light-subtle shadow-none border">
                    <div class="card-header bg-light-subtle mb-4">
                        <div class="d-flex mb-n1 align-items-center">
                            <div class="flex-grow-1">
                                <div class="hstack gap-3 fs-12 flex-wrap">
                                    <div><i class="ri-calendar-line align-bottom me-1"></i> Period :
                                        <span class="fw-medium">{{ periodLabel }}</span>
                                    </div>
                                    <div class="vr" style="width: 1px;"></div>
                                    <div>Reported Total :
                                        <span class="fw-medium">{{ formatMoney(expectedTotal) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div v-if="view === 'requests'" class="flex-shrink-0">
                                <b-button size="sm" variant="light" @click="backToBreakdown">
                                    <i class="ri-arrow-left-line align-bottom me-1"></i> Back
                                </b-button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body bg-white rounded-bottom" v-if="view === 'breakdown'">
                        <div v-if="loading" class="text-center py-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <template v-else>
                            <div class="table-responsive table-card" style="margin-top: -39px; height: calc(100vh - 465px); overflow: auto;">
                                <table class="table align-middle table-centered table-striped mb-0">
                                    <thead class="table-light thead-fixed">
                                        <tr>
                                            <th>Discount Type</th>
                                            <th class="text-end">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="cursor: pointer;" v-for="row in breakdown" :key="row.discount_id" @click="viewRequests(row)">
                                            <td>{{ row.name }} <i class="ri-arrow-right-s-line float-end"></i></td>
                                            <td class="text-end">{{ formatMoney(row.amount) }}</td>
                                        </tr>
                                        <tr v-if="breakdown.length === 0">
                                            <td colspan="2" class="text-center text-muted">No data for this period</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class="fw-semibold">
                                            <td>Sum of Breakdown</td>
                                            <td class="text-end">{{ formatMoney(breakdownSum) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="alert mb-0 mt-2 py-2 fs-12" :class="isMatch ? 'alert-success' : 'alert-danger'">
                                <i class="align-bottom me-1" :class="isMatch ? 'ri-checkbox-circle-fill' : 'ri-error-warning-fill'"></i>
                                <span v-if="isMatch">Breakdown matches the reported total.</span>
                                <span v-else>Breakdown does not match the reported total (difference: {{ formatMoney(Math.abs(expectedTotal - breakdownSum)) }}).</span>
                            </div>
                        </template>
                    </div>

                    <div class="card-body bg-white rounded-bottom" v-else>
                        <div v-if="requestsLoading" class="text-center py-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <template v-else>
                            <div class="hstack justify-content-between mb-2 fs-12">
                                <span class="fw-semibold">{{ selectedRow?.name }}</span>
                                <span class="text-muted">{{ formatMoney(selectedRow?.amount) }}</span>
                            </div>
                            <div class="table-responsive table-card" style="height: calc(100vh - 500px); overflow: auto;">
                                <table class="table align-middle table-centered table-striped mb-0">
                                    <thead class="table-light thead-fixed">
                                        <tr>
                                            <th>TSR No.</th>
                                            <th>Customer</th>
                                            <th>Date</th>
                                            <th class="text-end">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="request in requests" :key="request.id">
                                            <td>{{ request.code }}</td>
                                            <td>{{ request.customer }}</td>
                                            <td>{{ request.date }}</td>
                                            <td class="text-end">{{ formatMoney(request.amount) }}</td>
                                        </tr>
                                        <tr v-if="requests.length === 0">
                                            <td colspan="4" class="text-center text-muted">No requests found</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </template>
                    </div>

                    <div class="card-footer" v-if="view === 'requests' && meta.total">
                        <Pagination class="ms-2 me-2 mt-n1" :lists="requests.length" :links="links" :pagination="meta" @fetch="fetchRequests" />
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
export default {
    components: { Pagination },
    data(){
        return {
            showModal: false,
            loading: false,
            periodLabel: '',
            expectedTotal: 0,
            breakdown: [],
            year: null,
            month: null,
            laboratoryId: null,
            view: 'breakdown',
            selectedRow: null,
            requestsLoading: false,
            requests: [],
            meta: {},
            links: {},
        }
    },
    computed: {
        breakdownSum() {
            return this.breakdown.reduce((sum, row) => sum + Number(row.amount || 0), 0);
        },
        isMatch() {
            return Math.abs(this.breakdownSum - Number(this.expectedTotal || 0)) < 0.01;
        }
    },
    methods: {
        show(year, month, periodLabel, expectedTotal, laboratoryId = null){
            this.year = year;
            this.month = month;
            this.laboratoryId = laboratoryId;
            this.periodLabel = periodLabel;
            this.expectedTotal = expectedTotal;
            this.breakdown = [];
            this.view = 'breakdown';
            this.selectedRow = null;
            this.requests = [];
            this.meta = {};
            this.links = {};
            this.showModal = true;
            this.loading = true;
            axios.get('/accomplishments', {
                params: {
                    option: 'assistance-breakdown',
                    year,
                    month,
                    laboratory_id: laboratoryId,
                }
            })
            .then(response => {
                this.breakdown = response.data.breakdown;
            })
            .catch(err => console.log(err))
            .finally(() => {
                this.loading = false;
            });
        },
        viewRequests(row){
            this.selectedRow = row;
            this.view = 'requests';
            this.requests = [];
            this.meta = {};
            this.links = {};
            this.fetchRequests();
        },
        fetchRequests(page_url){
            page_url = page_url || '/accomplishments';
            this.requestsLoading = true;
            axios.get(page_url, {
                params: {
                    option: 'assistance-requests',
                    year: this.year,
                    month: this.month,
                    discount_id: this.selectedRow.discount_id,
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
        backToBreakdown(){
            this.view = 'breakdown';
            this.selectedRow = null;
        },
        formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return '₱'+val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>
