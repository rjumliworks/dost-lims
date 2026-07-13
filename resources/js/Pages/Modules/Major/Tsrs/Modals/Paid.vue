<template>
    <b-modal v-model="showModal" hide-footer hide-header title="Cancel Request" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="text-center">
            <div class="mt-4">
                <h4 class="mb-3">Mark as Paid</h4>
                <p class="text-muted mb-2">
                    You are about to mark the following TSR as paid:
                </p>

                <div class="alert alert-light border text-start mb-3">
                    <div class="text-dark"><strong class="text-muted">TSR Code:</strong> {{ code }}</div>
                    <div class="text-dark"><strong class="text-muted">Customer:</strong> {{ customer }}</div>
                </div>

                
                <p class="text-muted mb-4 fs-12">This will temporarily mark the TSR as paid, allowing its status to change to <strong>Ongoing</strong> so analysts can begin tagging and processing the analyses. You can update the payment details later if needed.</p>
                <div class="hstack gap-2 justify-content-center mb-3">
                    <button @click="hide()" class="btn btn-light btn-md" type="button">
                        <div class="btn-content"> Close</div>
                    </button>
                    <a @click="submit()" class="btn btn-danger" href="javascript:void(0);" target="_self">Confirm</a>
                </div>
            </div>
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
               reference: null,
               status_id: 3,
               option: 'Paid'
            }),
            customer: null,
            code: null,
            showModal: false
        }
    },
    methods: { 
        show(customer,code,data){
            this.form.reference = data;
            this.customer = customer;
            this.code = code;
            this.showModal = true;
        },
        submit(){
            this.form.put('/tsrs/update',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('update',this.$page.props.flash.data.data);
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