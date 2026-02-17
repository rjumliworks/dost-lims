<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" title="Update Order of Payment" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow class="g-3">
                <BCol lg="12" class="mt-1">
                    <InputLabel for="collection" value="Collection" :message="form.errors.collection_id"/>
                    <Multiselect 
                    :options="collections" 
                    v-model="form.collection_id"
                    label="name"
                    placeholder="Select Collection type"/>
                </BCol>
                 <BCol lg="12" class="mt-1">
                    <InputLabel for="payment" value="Payment" :message="form.errors.payment_id"/>
                    <Multiselect 
                    :options="payments" 
                    v-model="form.payment_id"
                     @input="handleInput('payment_id')"
                    label="name"
                    placeholder="Select Payment type"/>
                </BCol>
            </BRow>
        </form>  
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="submit('ok')" variant="primary" :disabled="form.processing" block>Submit</b-button>
        </template>
    </b-modal>
</template>
<script>
import _ from 'lodash';
import { useForm } from '@inertiajs/vue3';
import Multiselect from "@vueform/multiselect";
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
export default {
    components: { Multiselect, InputLabel },
    props: ['collections','payments'],
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                id: null,
                collection_id: 54,
                payment_id: null,
                option: 'op'
            }),
            showModal: false,
            editable: false
        }
    },
    methods: { 
        show(data){
            this.form.id = data.id;
            this.form.collection_id = 54;
            this.form.payment_id = data.payment.id;
            this.showModal = true;
        },
        submit(){
            this.form.put('/orderofpayments/update',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('update',this.$page.props.flash.data);
                    this.hide();
                },
            });
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        hide(){
            this.form.collection_id = null;
            this.form.payment_id = null;
            this.showModal = false;
        }
    }
}
</script>