<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" title="Values of Assistance Rendered - Breakdown by Discount Type" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop size="lg">
        <div class="row mb-3">
            <div class="col-md-12">
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
        </div>
        <div v-if="loading" class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div v-else>
            <table class="table table-bordered table-sm align-middle">
                <thead>
                    <tr>
                        <th>Discount Type</th>
                        <th class="text-end">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="row in breakdown" :key="row.discount_id">
                        <td>{{ row.name }}</td>
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
            <div class="alert mb-0" :class="isMatch ? 'alert-success' : 'alert-danger'">
                <i class="align-bottom me-1" :class="isMatch ? 'ri-checkbox-circle-fill' : 'ri-error-warning-fill'"></i>
                <span v-if="isMatch">Breakdown matches the reported total.</span>
                <span v-else>Breakdown does not match the reported total (difference: {{ formatMoney(Math.abs(expectedTotal - breakdownSum)) }}).</span>
            </div>
        </div>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
        </template>
    </b-modal>
</template>
<script>
export default {
    data(){
        return {
            showModal: false,
            loading: false,
            periodLabel: '',
            expectedTotal: 0,
            breakdown: [],
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
        show(year, month, periodLabel, expectedTotal){
            this.periodLabel = periodLabel;
            this.expectedTotal = expectedTotal;
            this.breakdown = [];
            this.showModal = true;
            this.loading = true;
            axios.get('/accomplishments', {
                params: {
                    option: 'assistance-breakdown',
                    year,
                    month,
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
