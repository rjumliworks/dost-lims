<template>
    <b-modal v-if="selected.wallet.available" v-model="showModal" hide-footer title="Wallet" class="v-modal-custom"  header-class="p-3 bg-light" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show mb-xl-0 material-shadow fs-11" role="alert">
            <i class="ri-error-warning-line label-icon"></i><strong>{{selected.wallet.available}}</strong> - This customer has an existing wallet balance.
        </div>
        <div class="input-group mb-0 mt-2">
            <label class="input-group-text"><i class="ri-wallet-3-fill align-middle me-2"></i> Wallet Balance</label>
            <input type="text" :value="selected.wallet.available" class="form-control" readonly style="text-align: right;">
        </div>
        <div class="table-responsive mt-2 mb-2">
            <table class="table table-bordered mt-0 mb-0 fs-12">
                <tbody>  
                    <tr>
                        <td>Sub Total :</td>
                        <td class="text-end" id="cart-subtotal">{{selected.payment.subtotal}}</td>
                    </tr>
                    <tr>
                        <td>Discount : </td>
                        <td class="text-end" id="cart-discount">{{selected.payment.discount}}</td>
                    </tr>
                    <tr class="table-active">
                        <th>Total :</th>
                        <td class="text-end"><span class="fw-semibold" id="cart-total"> {{selected.payment.total}} </span></td>
                    </tr>
                    <!-- <tr>
                        <td>Wallet :</td>
                        <td class="text-end" id="cart-subtotal">{{selected.wallet.available}}</td>
                    </tr>
                    <tr>
                        <td>New Wallet Balance :</td>
                        <td class="text-end" id="cart-subtotal">{{selected.wallet.available}}</td>
                    </tr> -->
                </tbody>
            </table>
        </div>
        <div v-if="parseInt(this.selected.wallet.available.replace(/₱|,/g, '')) >= parseInt(this.selected.payment.total.replace(/₱|,/g, ''))"  class="alert alert-warning alert-dismissible alert-label-icon label-arrow fade show mb-xl-0 material-shadow fs-11" role="alert">
            <i class="ri-error-warning-line label-icon"></i>Wallet will be used for payment. No need to go to the cashier
        </div>
        <div v-else  class="alert alert-warning alert-dismissible alert-label-icon label-arrow fade show mb-xl-0 material-shadow fs-11" role="alert">
            <i class="ri-error-warning-line label-icon"></i>The system will deduct the total amount to be paid.
        </div>
        <hr class="text-muted mb-0"/>
        <div class="d-grid gap-2">
            <b-button @click="submit()" class="mt-3" variant="primary">Use Wallet</b-button>
        </div>
    </b-modal>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
               id: null,
               total: null,
               tsr_id: null,
               wallet_id: null,
               option: 'wallet'
            }),
            selected: {
                wallet: {},
                payment: {}
            },
            keyword: null,
            showModal: false
        }
    },
    methods: { 
        show(id,customer,payment){
            this.form.tsr_id = id;
            this.form.id = payment.id;
            this.form.total = payment.total;
            this.form.wallet_id = customer.wallet.id;
            this.selected = customer;
            this.selected.payment = payment;
            this.showModal = true;
        },
        submit(){
            this.form.post('/wallet',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('update',true);
                    this.hide();
                },
            });
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>