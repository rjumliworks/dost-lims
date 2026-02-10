<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" title="Add Payor" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow>
                <BCol lg="12">
                    <!-- <i class="ri-user-2-fill me-1"></i> -->
                    <InputLabel value="Name" :message="form.errors.name"/>
                    <TextInput v-model="form.name" type="text" class="form-control" placeholder="Please enter name" :light="true"/>
                </BCol>   
                <BCol lg="12">
                    <!-- <i class="ri-phone-fill me-1"></i> -->
                    <InputLabel value="Contact" :message="form.errors.tin"/>
                    <TextInput v-model="form.tin" type="text" class="form-control" placeholder="Please enter tin" :light="true"/>
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
import { useForm } from '@inertiajs/vue3';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    components: { InputLabel, TextInput },
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                name: null,
                tin: null,
                customer_id: null,
                option: 'payor'
            }),
            showModal: false
        }
    },
    methods: { 
        show(customer){
            this.form.customer_id = customer;
            this.showModal = true;
        },
        submit(){
            this.form.post('/customers',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('selected',response.props.flash.data);
                    this.hide();
                },
            });
        },
        hide(){
            this.form.name = null;
            this.form.tin = null;
            this.showModal = false;
        }
    }
}
</script>