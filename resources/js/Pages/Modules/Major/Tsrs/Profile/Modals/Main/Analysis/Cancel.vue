<template>
    <b-modal v-model="showModal" hide-footer hide-header title="Cancel Request" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="text-center" v-if="selected">
            <div class="mt-4">
                <h4 v-if="type == 'cancel'" class="mb-3">Cancel Analysis</h4>
                <h4 v-else-if="type == 'refund'" class="mb-3">Refund Analysis Cost</h4>
                <p class="text-muted mb-3">Are you sure you want to {{ type }} <span class="fw-bold text-primary">{{selected.testname}}</span>?</p>
                <p class="text-muted mb-0">
                    This service has already been paid. If you proceed with {{ (type == 'cancel') ? 'cancellation' : 'refund'}}, the amount of <span class="fw-semibold text-success">{{selected.fee}}</span> will be deposited to the customer's wallet.
                </p>
                <textarea id="attribute"  :class="{ 'is-invalid': form.errors.reason }" v-model="form.reason" maxlength="250" rows="2" type="text" class="form-control mt-4 mb-4" placeholder="Please enter reason" style="background-color: #f5f6f7;"/>
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
               id: null,
               tsr_id: null,
               status_id: 13,
               reason: null,
               type_id: null,
               customer_id: null,
               fee: null,
               option: 'cancel'
            }),
            type: null,
            option: null,
            selected: null,
            showModal: false
        }
    },
    methods: { 
        show(data,customer,id,type){
            this.type = type;
            this.selected = data;
            this.form.id = data.id;
            this.form.fee = data.fee;
            this.form.tsr_id = id;
            this.form.customer_id = customer;
            this.form.type_id = (this.type == 'refund') ? 86 : 85;
            this.showModal = true;
        },
        submit(){
            this.form.put('/analyses/update',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('success',true);
                    this.hide();
                },
            });
        },
        hide(){
            this.form.reset();
            this.showModal = false;
        }
    }
}
</script>