<template>
    <b-modal v-model="showModal" hide-footer hide-header title="Cancel Request" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="text-center" v-if="selected">
            <div class="mt-4">
                <h4 class="mb-3">Remove TSR</h4>
                <p class="text-muted mb-0">Are you sure you want to remove <span class="fw-bold text-primary">{{ selected.itemable.code }}</span>?</p>
                <p class="text-muted mb-4">This action cannot be undone.</p>
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
               op_id: null,
               tsr_id: null,
               option: 'remove'
            }),
            selected: null,
            showModal: false
        }
    },
    methods: { 
        show(data){
            this.form.id = data.id;
            this.form.op_id = data.op_id;
            this.form.tsr_id = data.itemable_id;
            this.selected = data;
            this.showModal = true;
        },
        submit(){
            this.form.put('/orderofpayments/update',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.hide();
                },
            });
        },
        hide(){
            this.option = null;
            this.showModal = false;
        }
    }
}
</script>