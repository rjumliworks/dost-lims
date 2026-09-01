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
                                      <select v-model="filter.nature" class="form-select" style="max-width: 220px;">
                                    <option :value="null">All Nature of Collection</option>
                                    <option v-for="(c,index) in dropdowns.collections" :key="index" :value="c.name">{{ c.name }}</option>
                                </select>
                                <select v-model="filter.payment" class="form-select" style="max-width: 180px;">
                                    <option :value="null">All Payment Types</option>
                                    <option v-for="(p,index) in dropdowns.payments" :key="index" :value="p.name">{{ p.name }}</option>
                                </select>
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
                                    <th style="width: 13%;" class="text-center" role="button" @click="sortBy('nature')">
                                        Nature of Collection
                                        <i :class="sortIcon('nature')"></i>
                                    </th>
                                    <th style="width: 10%;" class="text-center" role="button" @click="sortBy('collection')">
                                        Collection
                                        <i :class="sortIcon('collection')"></i>
                                    </th>
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
                                        <i v-if="row.is_deposited" class="ri-checkbox-circle-fill text-success fs-16"></i>
                                        <i v-else class="ri-close-circle-fill text-danger fs-16"></i>
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
        <div class="row g-3 customform">
            <div class="col-md-12">
                <label class="form-label fs-13">Deposit Date</label>
                <input type="date" v-model="deposit.date" class="form-control">
            </div>
            <div class="col-md-12 mt-1">
                <label class="form-label fs-13">Account</label>
                <Multiselect
                :options="dropdowns.accounts"
                v-model="deposit.account_id"
                label="name"
                :searchable="true"
                placeholder="Select Account">
                    <template #option="{ option }">
                        <span>{{ option.account || option.name }} <span class="text-muted ms-1" v-if="option.account">({{ option.name }})</span></span>
                    </template>
                    <template #singlelabel="{ value }">
                        <span class="multiselect-single-label">{{ value.account || value.name }} <span class="text-muted ms-1" v-if="value.account">({{ value.name }})</span></span>
                    </template>
                </Multiselect>
            </div>
            <div class="col-md-12 mt-2">
                <label class="form-label fs-13">Funding Source</label>
                <Multiselect
                :options="dropdowns.funds"
                v-model="deposit.funding_id"
                label="name"
                :searchable="true"
                placeholder="Select Funding Source">
                    <template #option="{ option }">
                        <span>{{ option.source }} <span class="text-muted" v-if="option.code">({{ option.code }})</span></span>
                    </template>
                    <template #singlelabel="{ value }">
                        <span class="multiselect-single-label">{{ value.source }} <span class="text-muted ms-1" v-if="value.code">({{ value.code }})</span></span>
                    </template>
                </Multiselect>
            </div>
            <div class="col-md-12" v-if="selectedFund">
                <div class="alert alert-light border mb-0 fs-12">
                    <div><strong>Agency to be Credited:</strong> {{ selectedFund.agency_name }} ({{ selectedFund.agency_code }})</div>
                    <div><strong>Funding Source Code:</strong> {{ selectedFund.source || 'Not Available' }}</div>
                    <div><strong>Fund Code:</strong> {{ selectedFund.code || 'Not Available' }}</div>
                </div>
            </div>
        </div>
        <template v-slot:footer>
            <b-button @click="depositModal = false" variant="light" block>Close</b-button>
            <b-button @click="submitDeposit" variant="primary" :disabled="!deposit.date || depositing" block>Confirm Deposit</b-button>
        </template>
    </b-modal>
</template>
<script>
import Multiselect from "@vueform/multiselect";
import PageHeader from '@/Shared/Components/PageHeader.vue';
export default {
    components: { PageHeader, Multiselect },
    props: ['dropdowns'],
    data(){
        const currentYear = new Date().getFullYear();
        return {
            currentUrl: window.location.origin,
            rows: [],
            header: { officer: '', station: '' },
            totals: { collection: '0.00', btr: '0.00', trust: '0.00', undeposited: '0.00' },
            filter: {
                month: new Date().toLocaleString('default', { month: 'long' }),
                year: currentYear,
                nature: null,
                payment: null
            },
            months: ['January','February','March','April','May','June','July','August','September','October','November','December'],
            years: Array.from({length: 6}, (_, i) => currentYear - i),
            selected: [],
            lastCheckedIndex: null,
            sortField: null,
            sortDirection: 'asc',
            depositModal: false,
            deposit: {
                date: null,
                account_id: null,
                funding_id: null
            },
            depositing: false
        }
    },
    computed: {
        depositedCount(){
            const deposited = this.rows.filter(row => row.is_deposited).length;
            return deposited + '/' + this.rows.length;
        },
        selectedFund(){
            if(!this.deposit.funding_id || !this.dropdowns.funds) return null;
            return this.dropdowns.funds.find(f => f.value === this.deposit.funding_id) || null;
        }
    },
    watch: {
        "filter.month"(){ this.fetch(); },
        "filter.year"(){ this.fetch(); },
        "filter.nature"(){ this.fetch(); },
        "filter.payment"(){ this.fetch(); }
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
                    year: this.filter.year,
                    nature: this.filter.nature,
                    payment: this.filter.payment
                }
            })
            .then(response => {
                if(response){
                    this.rows = response.data.rows;
                    this.header = response.data.header;
                    this.totals = response.data.totals;
                    this.selected = [];
                    this.lastCheckedIndex = null;
                    this.sortField = null;
                }
            })
            .catch(err => console.log(err));
        },
        sortBy(field){
            if(this.sortField === field){
                this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
            }else{
                this.sortField = field;
                this.sortDirection = 'asc';
            }

            const direction = this.sortDirection === 'asc' ? 1 : -1;

            this.rows.sort((a, b) => {
                let valA = a[field];
                let valB = b[field];

                if(field === 'collection'){
                    valA = parseFloat((valA || '0').toString().replace(/,/g, ''));
                    valB = parseFloat((valB || '0').toString().replace(/,/g, ''));
                }else{
                    valA = (valA || '').toString().toLowerCase();
                    valB = (valB || '').toString().toLowerCase();
                }

                if(valA < valB) return -1 * direction;
                if(valA > valB) return 1 * direction;
                return 0;
            });

            this.lastCheckedIndex = null;
        },
        sortIcon(field){
            if(this.sortField !== field) return 'ri-expand-up-down-line text-muted';
            return this.sortDirection === 'asc' ? 'ri-sort-asc' : 'ri-sort-desc';
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
        exportParams(){
            return 'month='+encodeURIComponent(this.filter.month)
                +'&year='+encodeURIComponent(this.filter.year)
                +'&nature='+encodeURIComponent(this.filter.nature || '')
                +'&payment='+encodeURIComponent(this.filter.payment || '');
        },
        openPrint(){
            window.open(this.currentUrl + '/cashiering?option=cashreceiptsprint&'+this.exportParams());
        },
        openExcel(){
            window.open(this.currentUrl + '/cashiering?option=cashreceiptsexcel&'+this.exportParams());
        },
        openDeposit(){
            this.deposit = {
                date: new Date().toISOString().slice(0,10),
                account_id: null,
                funding_id: null
            };
            this.depositModal = true;
        },
        submitDeposit(){
            this.depositing = true;
            axios.post('/cashreceipts/deposit', {
                ids: this.selected,
                date: this.deposit.date,
                account_id: this.deposit.account_id,
                funding_id: this.deposit.funding_id
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
