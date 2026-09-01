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
                            <p class="text-muted text-truncate-two-lines fs-12">Monthly record of collections and deposits (BTR = Cash/Cheque, Trust Fund = Online Transfer/Bank Deposit).</p>
                        </div>
                    </div>
                </div>
                <div class="car-body bg-white border-bottom shadow-none">
                    <b-row class="mb-2 ms-1 me-1" style="margin-top: 12px;">
                        <b-col lg>
                            <div class="input-group mb-1">
                                <input type="text" placeholder="Search Request" class="form-control" style="width: 10%;">
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
                                    <i class="ri-printer-fill align-bottom me-1"></i> PDF
                                </b-button>
                                <b-button type="button" variant="primary" @click="openExcel">
                                    <i class="ri-file-excel-2-fill align-bottom me-1"></i> Excel
                                </b-button>
                                <b-button type="button" variant="dark" :disabled="selected.length === 0" @click="openDeposit">
                                    <i class="ri-bank-fill align-bottom me-1"></i> Deposit ({{ selected.length }})
                                </b-button>
                            </div>
                        </b-col>
                    </b-row>
                </div>
                <div class="card-body bg-white rounded-bottom">

                    <div class="table-responsive table-card" style="height: calc(100vh - 360px); overflow: auto;">
                        <table class="table table-nowrap align-middle mb-0">
                            <thead class="thead-fixed table-light">
                                <tr class="fs-11">
                                    <th style="width: 3%;"></th>
                                    <th style="width: 8%;">Date</th>
                                    <th style="width: 10%;" class="text-center">Reference No.</th>
                                    <th>Payor</th>
                                    <th style="width: 13%;" class="text-center">Nature of Collection</th>
                                    <th style="width: 10%;" class="text-center">Collection</th>
                                    <th style="width: 10%;" class="text-center">BTR</th>
                                    <th style="width: 10%;" class="text-center">Trust Fund</th>
                                    <th style="width: 10%;" class="text-center">Deposited ({{ depositedCount }})</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(row,index) in rows" v-bind:key="index" class="fs-12" :class="{'table-success': row.deposit_date, 'table-info': row.trust}">
                                    <td class="text-center">
                                        <input v-if="row.can_deposit" type="checkbox" class="form-check-input" :checked="selected.includes(row.id)" @change="toggleCheckbox(row, index, $event.target.checked)">
                                    </td>
                                    <td>{{ row.date }}</td>
                                    <td class="text-center">{{ row.reference }}</td>
                                    <td>{{ row.payor }}</td>
                                    <td class="text-center">{{ row.nature }}</td>
                                    <td class="text-center">{{ row.collection }}</td>
                                    <td class="text-center">
                                        {{ row.btr || '-' }}
                                        <div v-if="row.deposit_date" class="fs-10 text-muted">Deposited {{ row.deposit_date }}</div>
                                    </td>
                                    <td class="text-center">{{ row.trust || '-' }}</td>
                                    <td class="text-center">
                                        <i v-if="row.undeposited" class="ri-close-circle-fill text-danger fs-16"></i>
                                        <i v-else class="ri-checkbox-circle-fill text-success fs-16"></i>
                                    </td>
                                </tr>
                                <tr v-if="rows.length === 0">
                                    <td colspan="9" class="text-center text-muted py-4">No collections recorded for the selected month.</td>
                                </tr>
                            </tbody>
                            <tfoot v-if="rows.length" class="table-light tfoot-fixed fw-semibold fs-12">
                                <tr>
                                    <td colspan="5" class="text-end">TOTAL</td>
                                    <td class="text-center">{{ totals.collection }}</td>
                                    <td class="text-center">{{ totals.btr }}</td>
                                    <td class="text-center">{{ totals.trust }}</td>
                                    <td class="text-center">{{ totals.undeposited }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </BRow>

    <b-modal v-model="depositModal" header-class="p-3 bg-light" title="Deposit to Bank" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <p class="fs-13">You are about to group <strong>{{ selected.length }}</strong> official receipt(s) as deposited to the bank.</p>
        <div class="mb-3">
            <label class="form-label fs-13">Deposit Date</label>
            <input type="date" v-model="depositDate" class="form-control">
        </div>
        <template v-slot:footer>
            <b-button @click="depositModal = false" variant="light" block>Close</b-button>
            <b-button @click="submitDeposit" variant="primary" :disabled="!depositDate || depositing" block>Confirm Deposit</b-button>
        </template>
    </b-modal>
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
            years: Array.from({length: 6}, (_, i) => currentYear - i),
            selected: [],
            lastCheckedIndex: null,
            depositModal: false,
            depositDate: null,
            depositing: false
        }
    },
    computed: {
        depositedCount(){
            const deposited = this.rows.filter(row => !row.undeposited).length;
            return deposited + '/' + this.rows.length;
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
                    this.selected = [];
                    this.lastCheckedIndex = null;
                }
            })
            .catch(err => console.log(err));
        },
        toggleCheckbox(row, index, checked){
            if(checked){
                if(this.lastCheckedIndex !== null){
                    const start = Math.min(this.lastCheckedIndex, index);
                    const end = Math.max(this.lastCheckedIndex, index);
                    for(let i = start; i <= end; i++){
                        const r = this.rows[i];
                        if(r.can_deposit && !this.selected.includes(r.id)){
                            this.selected.push(r.id);
                        }
                    }
                }else if(!this.selected.includes(row.id)){
                    this.selected.push(row.id);
                }
                this.lastCheckedIndex = index;
            }else{
                this.selected = this.selected.filter(id => id !== row.id);
                this.lastCheckedIndex = index;
            }
        },
        openPrint(){
            window.open(this.currentUrl + '/cashiering?option=cashreceiptsprint&month='+this.filter.month+'&year='+this.filter.year);
        },
        openExcel(){
            window.open(this.currentUrl + '/cashiering?option=cashreceiptsexcel&month='+this.filter.month+'&year='+this.filter.year);
        },
        openDeposit(){
            this.depositDate = new Date().toISOString().slice(0,10);
            this.depositModal = true;
        },
        submitDeposit(){
            this.depositing = true;
            axios.post('/cashreceipts/deposit', {
                ids: this.selected,
                date: this.depositDate
            })
            .then(() => {
                this.depositModal = false;
                this.fetch();
            })
            .catch(err => console.log(err))
            .finally(() => {
                this.depositing = false;
            });
        }
    }
}
</script>
