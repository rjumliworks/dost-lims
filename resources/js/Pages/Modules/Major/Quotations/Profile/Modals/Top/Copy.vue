<template>
    <b-modal v-model="showModal" hide-footer hide-header title="Cancel Request" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="text-center">
            <div class="mt-4">
               <h4 class="mb-3">Duplicate TSR Request</h4>
            <p class="text-muted mb-4">
                This will create a copy including its test samples and services, with the status reset to Pending.
            </p>
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
import _ from 'lodash';
import { useForm } from '@inertiajs/vue3';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
import Textarea from '@/Shared/Components/Forms/Textarea.vue';
export default {
    components: { InputLabel, TextInput, Textarea },
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                id: null,
                option: 'copy'
            }),
            showModal: false
        }
    },
    methods: { 
        show(data){
            this.form.id = data.id;
            this.showModal = true;
        },
        submit(){
            this.form.post('/tsrs',{
                preserveScroll: true,
                onSuccess: (response) => {
                    window.location.href = `/tsrs/${this.$page.props.flash.data}`;
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