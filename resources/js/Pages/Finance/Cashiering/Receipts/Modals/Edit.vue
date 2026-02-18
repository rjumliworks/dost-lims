<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 600px;" header-class="p-3 bg-light" title="Update Official Receipt" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="row align-items-center g-3">
            <div class="col-md-12 mb-3" v-if="or.number">
                <div>
                    <h6><span class="fw-semibold text-primary fs-15">OR #: {{or.number}}</span></h6>
                    <div class="hstack gap-3 fs-12 flex-wrap mt-0">
                        <div>
                            <span class="text-muted"><i class="ri-user-fill me-1"></i></span> 
                            <span class="fw-medium">{{or.customer}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form class="customform">
            <BRow class="g-3">
                <template v-if="details.number">
                    <template v-if="or.payment == 'Cheque' || or.payment == 'Online Transfer' || or.payment == 'Bank Deposit'">
                        <BCol lg="12 mt-0 mb-0"><hr class="text-muted"/></BCol>
                        <BCol lg="6 mt-0">
                            <InputLabel :value="or.payment" :message="form.errors.details_number"/>
                            <TextInput v-model="details.number" type="text" class="form-control" @input="handleInput('details_number')" :light="true"/>
                        </BCol>
                        <BCol lg="6 mt-0">
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
            <b-button @click="submit('ok')" variant="primary" :disabled="form.processing" block>Update</b-button>
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
    data(){
        return {
            currentUrl: window.location.origin,
            or: {
                customer: null,
                number: null,
                payment: null,
                total: null
            },
            details: {
                id: null,
                number: null,
                bank: null,
                date_at: null,
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
        const totalStr = this.or.total || '₱0';
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
        show(data){
            this.or.customer = data.customer;
            this.or.number = data.ornumber;
            this.or.total = data.oramount;
            this.or.payment = data.payment;
            this.details.id = data.detail.id;
            this.details.bank = data.detail.bank;
            this.details.number = data.detail.number;
            this.details.date_at = data.detail.date_at;
            this.$nextTick(() => {
                if (this.$refs.testing) {
                    this.$refs.testing.emitValue(data.detail.amount);
                }
            });
            this.showModal = true;
        },
        submit(){
            this.form = this.$inertia.form({
                'id': this.details.id,
                'number': this.details.number,
                'date_at': this.details.date_at,
                'bank': this.details.bank,
                'amount': this.details.amount,
                'option': 'detail'
            });
            this.form.put('/receipts/update',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('update',response.props.flash.data);
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