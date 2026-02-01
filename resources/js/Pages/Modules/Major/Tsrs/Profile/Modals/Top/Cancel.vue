<template>
    <b-modal v-model="showModal" hide-footer hide-header title="Cancel Request" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="text-center">
            <div class="mt-4">
                <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light" 
                    style="width: 50px; height: 50px;">
                    <i class="ri-delete-bin-2-fill text-danger fs-24"></i>
                </span>
                <h4 class="mb-2 mt-2 text-danger fw-semibold fs-14">Cancel Technical Service Request</h4>
                <p class="text-muted mb-0 fs-12">Please confirm if you wish to cancel this TSR request.</p>
                <p class="text-muted mb-4 fs-12">Once cancelled, the Technical Service Request cannot be recovered.</p>
                  <BCol lg="12">
                    <label class="form-label fs-12 text-muted">
    Reason for cancellation <span class="text-danger">*</span>
</label>
                    <textarea id="attribute"  :class="{ 'is-invalid': form.errors.reason }" v-model="form.reason" maxlength="250" rows="2" type="text" class="form-control mt-4 mb-4" placeholder="Please enter reason" style="background-color: #f5f6f7;"/>
                </BCol>
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
               status_id: 5,
               reason: null,
               option: 'Cancel'
            }),
            showModal: false
        }
    },
    methods: { 
        show(data){
            this.form.id = data;
            this.showModal = true;
        },
        submit(){
            this.form.put('/tsrs/update',{
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