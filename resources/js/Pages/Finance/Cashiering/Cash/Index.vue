<template>
    <Head title="Cash Receipts Record"/>
    <PageHeader title="Cash Receipts Record" pageTitle="Reports" />
    <BRow>
        <div class="col-md-12">
            <div class="card bg-light-subtle shadow-none border">
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height:2.5rem;width:2.5rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-file-text-fill text-primary fs-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-14"><span class="text-body">Cash Receipts Record</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">Monthly record of collections and deposits (BTR = Online Payment, Trust Fund = Over-the-counter Deposit).</p>
                        </div>
                    </div>
                </div>
                <div class="car-body bg-white border-bottom shadow-none">
                    <b-row class="mb-2 ms-1 me-1" style="margin-top: 12px;">
                        <b-col lg>
                            <div class="input-group mb-1">
                                <select v-model="filter.month" class="form-select" style="max-width: 160px;">
                                    <option :value="list" v-for="list in months" v-bind:key="list">{{ list }}</option>
                                </select>
                                <select v-model="filter.year" class="form-select" style="max-width: 110px;">
                                    <option :value="list" v-for="list in years" v-bind:key="list">{{ list }}</option>
                                </select>
                                <span @click="fetch()" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;">
                                    <i class="bx bx-refresh search-icon"></i>
                                </span>
                                <b-button type="button" variant="success" @click="openPrint">
                                    <i class="ri-printer-fill align-bottom me-1"></i> Print
                                </b-button>
                            </div>
                        </b-col>
                    </b-row>
                </div>
                <div class="card-body bg-white rounded-bottom">
                    <div class="mb-3 fs-13">
                        <span class="fw-semibold">Accountable Officer:</span> {{ header.officer }}
                        <span class="fw-semibold ms-4">Station:</span> {{ header.station }}
                    </div>
                    <div class="table-responsive table-card" style="height: calc(100vh - 500px); overflow: auto;">
                        <table class="table table-nowrap align-middle mb-0">
                            <thead class="table-light">
                                <tr class="fs-11">
                                    <th style="width: 8%;">Date</th>
                                    <th style="width: 10%;">Reference No.</th>
                                    <th>Payor</th>
                                    <th style="width: 13%;">Nature of Collection</th>
                                    <th style="width: 10%;" class="text-end">Collection</th>
                                    <th style="width: 10%;" class="text-end">BTR</th>
                                    <th style="width: 10%;" class="text-end">Trust Fund</th>
                                    <th style="width: 10%;" class="text-end">Undeposited</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(row,index) in rows" v-bind:key="index" class="fs-12">
                                    <td>{{ row.date }}</td>
                                    <td>{{ row.reference }}</td>
                                    <td>{{ row.payor }}</td>
                                    <td>{{ row.nature }}</td>
                                    <td class="text-end">{{ row.collection }}</td>
                                    <td class="text-end">{{ row.btr }}</td>
                                    <td class="text-end">{{ row.trust }}</td>
                                    <td class="text-end">{{ row.undeposited }}</td>
                                </tr>
                                <tr v-if="rows.length === 0">
                                    <td colspan="8" class="text-center text-muted py-4">No collections recorded for the selected month.</td>
                                </tr>
                            </tbody>
                            <tfoot v-if="rows.length" class="table-light fw-semibold fs-12">
                                <tr>
                                    <td colspan="4" class="text-end">TOTAL</td>
                                    <td class="text-end">{{ totals.collection }}</td>
                                    <td class="text-end">{{ totals.btr }}</td>
                                    <td class="text-end">{{ totals.trust }}</td>
                                    <td class="text-end">{{ totals.undeposited }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </BRow>
</template>
<script>
import PageHeader from '@/Shared/Components/PageHeader.vue';
export default {
    components: { PageHeader },
    data(){
        const currentYear = new Date().getFullYear();
        return {
            currentUrl: window.location.origin,
            rows: [],
            header: { officer: '', station: '' },
            totals: { collection: '0.00', btr: '0.00', trust: '0.00', undeposited: '0.00' },
            filter: {
                month: new Date().toLocaleString('default', { month: 'long' }),
                year: currentYear
            },
            months: ['January','February','March','April','May','June','July','August','September','October','November','December'],
            years: Array.from({length: 6}, (_, i) => currentYear - i)
        }
    },
    watch: {
        "filter.month"(){ this.fetch(); },
        "filter.year"(){ this.fetch(); }
    },
    created(){
        this.fetch();
    },
    methods: {
        fetch(){
            axios.get('/cashiering', {
                params: {
                    option: 'cashreceipts',
                    month: this.filter.month,
                    year: this.filter.year
                }
            })
            .then(response => {
                if(response){
                    this.rows = response.data.rows;
                    this.header = response.data.header;
                    this.totals = response.data.totals;
                }
            })
            .catch(err => console.log(err));
        },
        openPrint(){
            window.open(this.currentUrl + '/cashiering?option=cashreceiptsprint&month='+this.filter.month+'&year='+this.filter.year);
        }
    }
}
</script>
