<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 600px;" header-class="p-3 bg-light" :title="editing ? 'Edit Due Date Request' : 'Request Due Date Update'" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <BRow class="g-3">
            <BCol lg="12" v-if="editing">
                <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show material-shadow fs-11 lh-sm" role="alert">
                    <i class="ri-information-line label-icon"></i><strong>Pending Request</strong> <br/> This TSR already has a due date request awaiting Technical Manager review. Submitting again will revise that same request instead of creating a new one.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </BCol>
            <BCol lg="12" v-else>
                <div class="alert alert-warning alert-dismissible alert-label-icon label-arrow fade show material-shadow fs-11 lh-sm" role="alert">
                    <i class="ri-alert-line label-icon"></i><strong>Approval Required</strong> <br/> This TSR is already {{ status?.toLowerCase() }}, so the due date can no longer be edited directly. Your requested update will be sent to the Technical Manager for review and will only take effect once approved.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </BCol>
            <BCol lg="6" class="mt-1">
                <InputLabel for="current" value="Current Due Date"/>
                <TextInput :model-value="current" type="text" class="form-control" disabled :light="true"/>
            </BCol>
            <BCol lg="6" class="mt-1">
                <InputLabel for="proposed_due_at" value="Proposed Due Date" :message="form.errors.proposed_due_at"/>
                <TextInput v-model="form.proposed_due_at" type="date" class="form-control" :class="{ 'is-invalid': form.errors.proposed_due_at }" @input="handleInput('proposed_due_at')" :light="true"/>
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
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
import Textarea from '@/Shared/Components/Forms/Textarea.vue';
export default {
    components: { InputLabel, TextInput, Textarea },
    data(){
        return {
            form: useForm({
                reference: null,
                proposed_due_at: null,
                remarks: null,
                option: 'RequestDueDate'
            }),
            current: null,
            status: null,
            editing: false,
            showModal: false,
        }
    },
    methods: {
        show(tsr, pending = null){
            this.form.reset();
            this.form.reference = tsr.reference;
            this.current = tsr.due_at;
            this.status = tsr.status.name;
            this.editing = !!pending;
            this.form.proposed_due_at = pending ? this.formatToDateInput(pending.proposed_due_at) : this.formatToDateInput(tsr.due_at);
            this.form.remarks = pending ? pending.remarks : null;
            this.showModal = true;
        },
        formatToDateInput(str) {
            if(!str) return null;
            return new Date(str).toLocaleDateString('en-CA');
        },
        submit(){
            this.form.put('/tsrs/update', {
                preserveScroll: true,
                onSuccess: () => this.hide(),
            });
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>
