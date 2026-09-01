<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 1200px;" header-class="p-3 bg-light" title="Deposit Details" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="row g-3 mb-3" v-if="deposit">
            <div class="col-sm-3">
                <div class="p-1 border border-dashed rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-0">
                            <div class="avatar-title rounded bg-transparent text-primary fs-18"><i class="ri-calendar-2-line"></i></div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted fs-11 mb-0">Date Deposited :</p>
                            <h5 class="fs-12 mb-0">{{ deposit.date }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="p-1 border border-dashed rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-0">
                            <div class="avatar-title rounded bg-transparent text-primary fs-18"><i class="ri-coupon-line"></i></div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted fs-11 mb-0">OR Range :</p>
                            <h5 class="fs-12 mb-0">{{ deposit.start }} - {{ deposit.end }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="p-1 border border-dashed rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-0">
                            <div class="avatar-title rounded bg-transparent text-primary fs-18"><i class="ri-bank-line"></i></div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted fs-11 mb-0">Deposit Type :</p>
                            <h5 class="fs-12 mb-0">{{ deposit.type }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="p-1 border border-dashed rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-0">
                            <div class="avatar-title rounded bg-transparent text-primary fs-18"><i class="ri-hand-coin-line"></i></div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted fs-11 mb-0">Total :</p>
                            <h5 class="fs-12 mb-0">{{ deposit.total }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="p-1 border border-dashed rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-0">
                            <div class="avatar-title rounded bg-transparent text-primary fs-18"><i class="ri-price-tag-3-line"></i></div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted fs-11 mb-0">Account :</p>
                            <h5 class="fs-12 mb-0">{{ deposit.account || 'Not Available' }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="p-1 border border-dashed rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-0">
                            <div class="avatar-title rounded bg-transparent text-primary fs-18"><i class="ri-funds-line"></i></div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted fs-11 mb-0">Funding Source :</p>
                            <h5 class="fs-12 mb-0">{{ deposit.funding_source || 'Not Available' }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="p-1 border border-dashed rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-0">
                            <div class="avatar-title rounded bg-transparent text-primary fs-18"><i class="ri-price-tag-3-line"></i></div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted fs-11 mb-0">Fund Code :</p>
                            <h5 class="fs-12 mb-0">{{ deposit.fund_code || 'Not Available' }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="p-1 border border-dashed rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-0">
                            <div class="avatar-title rounded bg-transparent text-primary fs-18"><i class="ri-building-line"></i></div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted fs-11 mb-0">Agency Credited :</p>
                            <h5 class="fs-12 mb-0">{{ deposit.agency_credited }} ({{ deposit.agency_code }})</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="text-muted mt-0"/>
        <div class="table-responsive table-card">
            <table class="table table-nowrap align-middle mb-0">
                <thead class="table-light">
                    <tr class="fs-11">
                        <th style="width: 3%;"></th>
                        <th style="width: 12%;" class="text-center">Date</th>
                        <th style="width: 12%;" class="text-center">Reference No.</th>
                        <th>Payor</th>
                        <th style="width: 15%;" class="text-center">Nature of Collection</th>
                        <th style="width: 10%;" class="text-center">Payment</th>
                        <th style="width: 12%;" class="text-center">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row,index) in receipts" v-bind:key="index" class="fs-12">
                        <td class="text-center">{{ index + 1 }}.</td>
                        <td class="text-center">{{ row.date }}</td>
                        <td class="text-center">{{ row.reference }}</td>
                        <td>{{ row.payor }}</td>
                        <td class="text-center">{{ row.nature }}</td>
                        <td class="text-center">{{ row.payment }}</td>
                        <td class="text-center">{{ row.amount }}</td>
                    </tr>
                    <tr v-if="receipts.length === 0">
                        <td colspan="7" class="text-center text-muted py-4">No official receipts found for this deposit.</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
            <b-button @click="print()" variant="success" block>
                <i class="ri-printer-fill align-bottom me-1"></i> Print
            </b-button>
        </template>
    </b-modal>
</template>
<script>
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            depositId: null,
            deposit: null,
            receipts: [],
            showModal: false
        }
    },
    methods: {
        show(data){
            this.showModal = true;
            this.depositId = data.id;
            axios.get('/cashiering', {
                params: {
                    option: 'depositview',
                    id: data.id
                }
            })
            .then(response => {
                if(response){
                    this.deposit = response.data.deposit;
                    this.receipts = response.data.receipts;
                }
            })
            .catch(err => console.log(err));
        },
        print(){
            window.open(this.currentUrl + '/cashiering?option=depositprint&id='+this.depositId);
        },
        hide(){
            this.deposit = null;
            this.receipts = [];
            this.depositId = null;
            this.showModal = false;
        }
    }
}
</script>
