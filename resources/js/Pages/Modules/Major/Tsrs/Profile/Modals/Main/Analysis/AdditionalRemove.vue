<template>
    <b-modal  v-if="selected" v-model="showModal" hide-footer hide-header class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="text-center">
            <div class="mt-4">
                <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light" 
                    style="width: 50px; height: 50px;">
                    <i class="ri-delete-bin-2-fill text-danger fs-24"></i>
                </span>
                <h4 class="mb-2 mt-2 text-danger fw-semibold fs-12">
                    Remove Add-Ons from Selected Test Service
                </h4>
                <p class="text-muted mb-4 fs-11">
                    Removing these add-ons will automatically deduct their corresponding costs from the total amount and permanently remove any related configurations.
                </p>
            </div>
        </div>
        <div class="hstack gap-2 justify-content-center mb-3">
            <button @click="hide()" class="btn btn-light btn-md" type="button">
                <div class="btn-content"> Close</div>
            </button>
            <a @click="submit()" class="btn btn-danger" href="javascript:void(0);" target="_self">Confirm</a>
        </div>
    </b-modal>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
export default {
    data(){
        return {
            form: useForm({
               id: null,
               tsr_id: null,
               option: 'removefee'
            }),
            selected: null,
            showModal: false
        }
    },
    methods: { 
        show(data,id){
            this.form.id = data.id;
            this.form.tsr_id = id;
            this.selected = data;
            this.showModal = true;
        },
        submit(){
            this.form.post('/analyses',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('success',true);
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