<template>
    <b-modal v-model="showModal" hide-footer hide-header class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="text-center">
            <div class="mt-2">
                <span class="d-inline-flex align-items-center justify-content-center rounded-circle"
                    :class="type === 'suspend' ? 'bg-danger-subtle' : 'bg-success-subtle'"
                    style="width: 55px; height: 55px;">
                    <i v-if="type === 'approve'" class="ri-checkbox-circle-fill text-success fs-24"></i>
                    <i v-else-if="type === 'suspend'" class="ri-forbid-2-fill text-danger fs-24"></i>
                    <i v-else class="ri-restart-fill text-success fs-24"></i>
                </span>
                <h4 class="mb-2 mt-3 fw-semibold fs-14" :class="type === 'suspend' ? 'text-danger' : 'text-success'">
                    <span v-if="type === 'approve'">Approve Test Service</span>
                    <span v-else-if="type === 'suspend'">Suspend Test Service</span>
                    <span v-else>Reactivate Test Service</span>
                </h4>
                <p class="text-muted mb-4 mt-2 fs-12 px-2">
                    <span v-if="type === 'approve'">You are about to approve <span class="fw-semibold text-body">{{ name }}</span>. Once approved, it will be available for use in TSR creation.</span>
                    <span v-else-if="type === 'suspend'">You are about to suspend <span class="fw-semibold text-body">{{ name }}</span>. It will no longer be available for use in TSR creation until reactivated.</span>
                    <span v-else>You are about to reactivate <span class="fw-semibold text-body">{{ name }}</span>. It will be available again for use in TSR creation.</span>
                </p>
            </div>
        </div>
        <div class="hstack gap-2 justify-content-center mb-3">
            <button @click="hide()" class="btn btn-light btn-md" type="button" :disabled="form.processing">
                <div class="btn-content">Close</div>
            </button>
            <b-button @click="submit()" :variant="variant" :disabled="form.processing" block>
                <span v-if="type === 'approve'">Yes, Approve</span>
                <span v-else-if="type === 'suspend'">Yes, Suspend</span>
                <span v-else>Yes, Reactivate</span>
            </b-button>
        </div>
    </b-modal>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
export default {
    data(){
        return {
            form: useForm({
               reference: null,
               status_id: null,
               option: 'status'
            }),
            type: 'approve',
            name: null,
            showModal: false
        }
    },
    computed: {
        variant(){
            if(this.type === 'suspend') return 'danger';
            if(this.type === 'reactivate') return 'success';
            return 'primary';
        }
    },
    methods: {
        show(type,id,reference,name){
            this.type = type;
            this.form.status_id = id;
            this.form.reference = reference;
            this.name = name;
            this.showModal = true;
        },
        submit(){
            this.form.post('/testservices',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.form.reset();
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
