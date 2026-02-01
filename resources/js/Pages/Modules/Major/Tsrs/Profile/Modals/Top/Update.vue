<template>
    <b-modal v-if="selected" v-model="showModal" header-class="p-3 bg-light" title="Update Payment Discount" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <div class="row customform g-2 mt-n2">
                <BCol lg="12" class="mt-1">
                    <InputLabel for="region" value="Discount" :message="form.errors.discount_id"/>
                    <Multiselect 
                    :options="dropdowns.discounts" 
                    v-model="form.discount_id"
                    @input="handleInput('discount_id')"
                    label="name"
                    placeholder="Select Discount"/>
                </BCol>
                <BCol lg="12">
                    <p class="text-muted mb-n3 fs-11 mt-2">
                        Changing the discount while an ongoing TSR exists will update the total amount.
                        Please enter the reason for changing the discount.
                    </p>
                    <textarea id="attribute"  :class="{ 'is-invalid': form.errors.reason }" v-model="form.reason" maxlength="250" rows="2" type="text" class="form-control mt-4 mb-4" placeholder="Please enter reason" style="background-color: #f5f6f7;"/>
                </BCol>
            </div>
        </form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
            <b-button @click="submit('ok')" variant="primary" :disabled="form.processing" block>Update</b-button>
        </template>
    </b-modal>
    <Add @selected="set" ref="conforme"/>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
import Multiselect from "@vueform/multiselect";
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    props: ['dropdowns'],
    components: { InputLabel, TextInput, Multiselect },
    data(){
        return {
            currentUrl: window.location.origin,
            selected: null,
            form: useForm({
                id: null,
                discount_id: null,
                reason: null,
                option: 'Discount'
            }),
            showModal: false
        }
    },
    methods: { 
        show(data){
            this.selected = data;
            this.form.id = data.id;
            this.form.discount_id = data.payment.discount_id;
            this.showModal = true;
        },
        submit(){
            this.form.put('/tsrs/update',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('update',this.$page.props.flash.data.data);
                    this.hide();
                },
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