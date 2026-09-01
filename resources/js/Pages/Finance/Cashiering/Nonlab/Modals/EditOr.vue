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
                <BCol lg="6 mt-0">
                    <InputLabel value="Payment Type" :message="form.errors.payment_id"/>
                    <Multiselect
                    :options="dropdowns.payments"
                    v-model="or.payment_id"
                    label="name"
                    :searchable="true"
                    @input="handleInput('payment_id')"
                    placeholder="Select Payment Type"/>
                </BCol>
                <BCol lg="6 mt-0">
                    <InputLabel value="Nature of Collection" :message="form.errors.collection_id"/>
                    <Multiselect
                    :options="dropdowns.collections"
                    v-model="or.collection_id"
                    label="name"
                    :searchable="true"
                    @input="handleInput('collection_id')"
                    placeholder="Select Collection Type"/>
                </BCol>
                <template v-if="needsDetail">
                    <BCol lg="12 mt-0 mb-0"><hr class="text-muted"/></BCol>
                    <BCol lg="6 mt-0">
                        <InputLabel :value="selectedPayment ? selectedPayment.others : 'Reference No.'" :message="form.errors.details_number"/>
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
            </BRow>
        </form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
            <b-button @click="submit()" variant="primary" :disabled="form.processing" block>Update</b-button>
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
    props: ['dropdowns'],
    data(){
        return {
            currentUrl: window.location.origin,
            or: {
                op_id: null,
                receipt_id: null,
                customer: null,
                number: null,
                payment_id: null,
                total: null
            },
            details: {
                number: null,
                bank: null,
                date_at: null,
                amount: null,
                is_cheque: false,
            },
            form : {
                errors: []
            },
            showModal: false
        }
    },
    computed: {
        selectedPayment() {
            if (!this.or.payment_id || !this.dropdowns.payments) return null;
            return this.dropdowns.payments.find(p => p.value === this.or.payment_id) || null;
        },
        needsDetail() {
            return this.selectedPayment && ['Cheque', 'Online Transfer', 'Bank Deposit'].includes(this.selectedPayment.name);
        },
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
            this.or.op_id = data.id;
            this.or.receipt_id = data.or_id;
            this.or.customer = data.customer;
            this.or.number = data.ornumber;
            this.or.total = data.oramount;
            const currentPayment = (this.dropdowns.payments || []).find(p => p.name === data.payment);
            this.or.payment_id = currentPayment ? currentPayment.value : null;
            const currentCollection = (this.dropdowns.collections || []).find(c => c.name === data.collection);
            this.or.collection_id = currentCollection ? currentCollection.value : null;
            if(data.detail){
                this.details.bank = data.detail.bank;
                this.details.number = data.detail.number;
                this.details.date_at = data.detail.date_at;
                this.$nextTick(() => {
                    if (this.$refs.testing) {
                        this.$refs.testing.emitValue(data.detail.amount);
                    }
                });
            }
            this.showModal = true;
        },
        submit(){
            this.form = this.$inertia.form({
                'op_id': this.or.op_id,
                'receipt_id': this.or.receipt_id,
                'payment_id': this.or.payment_id,
                'collection_id': this.or.collection_id,
                'details_number': this.details.number,
                'details_date_at': this.details.date_at,
                'details_bank': this.details.bank,
                'details_amount': this.details.amount,
                'option': 'op'
            });
            this.form.put('/nonlabreceipts/update',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('update');
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
            this.or.op_id = null;
            this.or.receipt_id = null;
            this.or.customer = null;
            this.or.number = null;
            this.or.payment_id = null;
            this.or.collection_id = null;
            this.or.total = null;
            this.details.number = null;
            this.details.bank = null;
            this.details.date_at = null;
            this.details.amount = null;
            this.showModal = false;
        }
    }
}
</script>
