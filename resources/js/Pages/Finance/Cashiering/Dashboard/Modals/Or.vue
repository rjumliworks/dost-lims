<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 600px;" header-class="p-3 bg-light" title="Create Official Receipt" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow class="g-3">
                <BCol lg="12 mt-2">
                    <InputLabel for="payor" value="Payor"/>
                    <TextInput id="name" v-model="customer" type="text" class="form-control" autofocus :light="true" readonly/>
                </BCol>
                <BCol lg="6 mt-1">
                    <InputLabel for="deposit" value="Deposit Type" :message="form.errors.deposit_id"/>
                    <Multiselect 
                    :options="deposits" 
                    v-model="or.deposit_id" 
                    label="name"
                    @input="handleInput('deposit_id')"
                    placeholder="Select Deposit type"/>
                </BCol>
                <BCol lg="6 mt-1">
                    <InputLabel for="orseries" value="O.R Series" :message="form.errors.orseries"/>
                    <Multiselect 
                    :options="orseries" 
                    v-model="or.orseries" 
                    object
                    label="name"
                    @input="handleInput('orseries')"
                    placeholder="Select OR"/>
                </BCol>
                <BCol lg="12" v-if="or.orseries">
                    <hr class="text-muted mt-0"/>
                    <div class="d-grid gap-2" v-if="or.orseries.value != 0">
                        <b-button variant="success">O.R # : {{or.orseries.next}}</b-button>
                    </div>
                    <BCol lg="12 mt-n2 mb-n2" v-else>
                        <InputLabel value="Customer OR Number" :message="form.errors.details_date_at"/>
                        <TextInput v-model="or.orseries.next" type="text" class="form-control" @input="handleInput('details_date_at')" :light="true"/>
                    </BCol>
                </BCol>
                <BCol lg="12" v-if="orseries.length == 0">
                    <hr class="text-muted mt-0"/>
                    <div class="alert alert-danger mb-xl-0 material-shadow" role="alert">
                        No active Official Receipt (OR) series found. Please activate one to continue processing transactions.
                    </div>
                </BCol>
                <BCol lg="12 mt-1 mb-n3">
                    <hr class="text-muted"/>
                </BCol>
                <template v-if="or.selected">
                    <template v-if="or.selected.payment.name == 'Cheque' || or.selected.payment.name == 'Online Transfer' || or.selected.payment.name == 'Bank Deposit'">
                        <BCol lg="12" class="mb-n3" v-if="or.selected.payment.name == 'Bank Deposit'">
                            <BRow class="g-3">
                                <BCol lg="8"  style="margin-top: 13px; margin-bottom: -12px;" class="fs-12">Please choose type of deposit?</BCol>
                                <BCol lg="4"  style="margin-top: 13px; margin-bottom: -12px;">
                                <div class="row">
                                        <div class="col-md-6">
                                            <div class="custom-control custom-radio mb-3">
                                                <input type="radio" id="customRadio1" class="custom-control-input me-2" :value="false" v-model="details.is_cheque">
                                                <label class="custom-control-label fw-normal fs-12" for="customRadio1">Cash</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="custom-control custom-radio mb-3">
                                                <input type="radio" id="customRadio2" class="custom-control-input me-2" :value="true" v-model="details.is_cheque">
                                                <label class="custom-control-label fw-normal fs-12" for="customRadio2">Cheque</label>
                                            </div>
                                        </div>
                                    </div>
                                </BCol>
                                <BCol lg="12"><hr class="text-muted mt-n2"/></BCol>
                            </BRow>
                        </BCol>
                        <BCol lg="6 mt-2">
                            <InputLabel :value="or.selected.payment.others" :message="form.errors.details_number"/>
                            <TextInput v-model="details.number" type="text" class="form-control" @input="handleInput('details_number')" :light="true"/>
                        </BCol>
                        <BCol lg="6 mt-2">
                            <InputLabel value="Date" :message="form.errors.details_date_at"/>
                            <TextInput v-model="details.date_at" type="date" class="form-control" @input="handleInput('details_date_at')" :light="true"/>
                        </BCol>
                        <BCol lg="6 mt-0">
                            <InputLabel value="Amount" :message="form.errors.details_amount"/>
                            <Amount @amount="amount" ref="testing" :readonly="false" @input="handleInput('details_amount')"/>
                        </BCol>
                        <BCol lg="6 mt-0">
                            <InputLabel value="Bank Name" :message="form.errors.details_bank"/>
                            <TextInput v-model="details.bank" type="text" class="form-control" @input="handleInput('details_bank')" :light="true"/>
                        </BCol>
                        <BCol v-if="excessPayment.show" lg="12">
                            <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fs-11" role="alert">
                                <i class="ri-error-warning-line label-icon"></i><strong>Excess Payment Notice</strong><p class="mt-2 mb-0">The customer has overpaid by <b>{{ excessPayment.amount }}</b>. This excess amount will be automatically credited to their e-wallet and can be used for future transactions. </p>
                            </div>
                        </BCol>
                    </template>
                </template>
            </BRow>
        </form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
            <b-button @click="submit('ok')" variant="primary" :disabled="form.processing" block>Submit</b-button>
        </template>
    </b-modal>
</template>
<script>
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import Multiselect from "@vueform/multiselect";
import Amount from '@/Shared/Components/Forms/Amount.vue';
export default {
    components: { Multiselect, InputLabel, TextInput, Amount },
    props: ['deposits','orseries'],
    data(){
        return {
            currentUrl: window.location.origin,
            or: {
                id: null,
                deposit_id: null,
                orseries: null,
                selected: {payment:{}},
                total: null,
                type: null,
                option: 'receipt'
            },
            details: {
                type: null,
                number: null,
                bank: null,
                date_at: null,
                is_cheque: false,
                amount: null,
            },
            form : {
                errors: []
            },
            type: null,
            customer: null,
            showModal: false
        }
    },
    computed: {
        excessPayment() {
        const totalStr = this.or.selected.total || '₱0';
        const paidStr = this.details.amount || '₱0';

        const total = parseFloat(totalStr.toString().replace(/[^0-9.-]+/g, ""));
        const paid = parseFloat(paidStr.toString().replace(/[^0-9.-]+/g, ""));

        const excess = paid - total;

        if (excess > 0) {
            return {
                show: true,
                amount: `₱${excess.toFixed(2)}`
            };
        }
        return {
            show: false,
            amount: 0
        };
    }
    },
    methods: { 
        show(customer,data){
            this.customer = customer;
            this.or.selected = data;
            this.or.total =  this.or.selected.total;
            this.or.series = this.orseries;
            this.type =  this.or.selected.payment.name;
            this.showModal = true;
        },
        submit(){

            if(this.type === 'Cheque' || this.type === 'Online Transfer' || this.type === 'Bank Deposit'){
                this.form = this.$inertia.form({
                    'deposit_id': this.or.deposit_id,
                    'orseries': this.or.orseries,
                    'orseries_id': (this.or.orseries) ? this.or.orseries.value : null,
                    'details_number': this.details.number,
                    'details_date_at': this.details.date_at,
                    'details_bank': this.details.bank,
                    'details_is_cheque': this.details.is_cheque,
                    'details_amount': this.details.amount,
                    'selected': this.or.selected,
                    'total': this.or.total,
                    'type': this.type,
                    'option': 'receipt'
                });
            }else{
                this.form = this.$inertia.form({
                    'deposit_id': this.or.deposit_id,
                    'orseries_id': (this.or.orseries) ? this.or.orseries.value : null,
                    'orseries': this.or.orseries,
                    'type': this.type,
                    'selected': this.or.selected,
                    'total': this.or.total,
                    'option': 'receipt'
                });
            }

            this.form.post('/receipts',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('update',true);
                    this.hide();
                },
            });
        },
        amount(val){
            this.details.amount = val;
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        hide(){
            this.or.id = null;
            this.or.deposit_id = null;
            this.or.orseries = null;
            this.or.selected = {payment:{}};
            this.or.total = null;
            this.or.type = null;
            this.details.type = null;
            this.details.number = null;
            this.details.bank = null;
            this.details.date_at = null;
            this.details.amount = null;
            this.showModal = false;
        }
    }
}
</script>