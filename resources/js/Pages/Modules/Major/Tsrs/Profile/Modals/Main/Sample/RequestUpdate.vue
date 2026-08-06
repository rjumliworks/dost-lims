<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 700px;" header-class="p-3 bg-light" :title="editing ? 'Edit Update Request' : 'Request Sample Update'" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <BRow class="g-3">
            <BCol lg="12" v-if="editing">
                <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show material-shadow fs-11 lh-sm" role="alert">
                    <i class="ri-information-line label-icon"></i><strong>Pending Request</strong> <br/> You already have a request for this sample awaiting Technical Manager review. Submitting again will revise that same request instead of creating a new one.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </BCol>
            <BCol lg="12" v-else>
                <div class="alert alert-warning alert-dismissible alert-label-icon label-arrow fade show material-shadow fs-11 lh-sm" role="alert">
                    <i class="ri-alert-line label-icon"></i><strong>Approval Required</strong> <br/> This sample is already {{ status?.toLowerCase() }}, so the description can no longer be edited directly. Your requested update will be sent to the Technical Manager for review and will only take effect once approved.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </BCol>
            <BCol lg="6" class="mt-1">
                <InputLabel for="current" value="Current Description provided by customer"/>
                <Textarea id="current" :model-value="currentCustomerDescription" class="form-control" rows="3" disabled :light="true"/>
            </BCol>
            <BCol lg="6" class="mt-1">
                <InputLabel for="customer_description" value="Proposed Description provided by customer" :message="form.errors.customer_description"/>
                <Textarea id="customer_description" v-model="form.customer_description" class="form-control" rows="3" :class="{ 'is-invalid': form.errors.customer_description }" :light="true"/>
            </BCol>
            <BCol lg="6" class="mt-1">
                <InputLabel for="current" value="Current Description based on the sample submitted"/>
                <Textarea id="current" :model-value="current" class="form-control" rows="4" disabled :light="true"/>
            </BCol>
            <BCol lg="6" class="mt-1">
                <InputLabel for="description" value="Proposed Description based on the sample submitted" :message="form.errors.description"/>
                <Textarea id="description" v-model="form.description" class="form-control" rows="4" :class="{ 'is-invalid': form.errors.description }" :light="true"/>
            </BCol>
            <BCol lg="12" class="mt-1">
                <InputLabel for="remarks" value="Reason for Update" :message="form.errors.remarks"/>
                <Textarea id="remarks" v-model="form.remarks" class="form-control" rows="2" :class="{ 'is-invalid': form.errors.remarks }" :light="true" placeholder="Briefly explain why this update is needed"/>
            </BCol>
        </BRow>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="submit()" variant="primary" :disabled="form.processing" block>{{ editing ? 'Update Request' : 'Submit Request' }}</b-button>
        </template>
    </b-modal>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import Textarea from '@/Shared/Components/Forms/Textarea.vue';
export default {
    components: { InputLabel, Textarea },
    data(){
        return {
            form: useForm({
                id: null,
                description: null,
                customer_description: null,
                remarks: null,
                option: 'amendment'
            }),
            current: null,
            currentCustomerDescription: null,
            status: null,
            editing: false,
            showModal: false,
        }
    },
    methods: {
        show(sample, status, pending = null){
            this.form.reset();
            this.form.id = sample.id;
            this.current = sample.description;
            this.currentCustomerDescription = sample.customer_description;
            this.status = status;
            this.editing = !!pending;
            this.form.description = pending ? pending.proposed_description : sample.description;
            this.form.customer_description = pending ? pending.proposed_customer_description : sample.customer_description;
            this.form.remarks = pending ? pending.remarks : null;
            this.showModal = true;
        },
        submit(){
            this.form.post('/samples', {
                preserveScroll: true,
                onSuccess: () => this.hide(),
            });
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>
