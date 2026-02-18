<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" title="Edit Receipt" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow class="g-3">
                <BCol lg="12 mt-3">
                    <InputLabel for="name" value="Name" :message="form.errors.name"/>
                    <TextInput id="name" v-model="form.name" type="text" class="form-control" placeholder="Please enter a name" :light="true"/>
                </BCol>
                <BCol lg="12 mt-0">
                    <InputLabel for="name" value="Start" :message="form.errors.amount"/>
                    <Amount @amount="amount" ref="testing" :readonly="false" @input="handleInput('amount')"/>
                </BCol>
            </BRow>
        </form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
            <b-button @click="submit()" variant="primary" :disabled="form.processing" block>Submit</b-button>
        </template>
    </b-modal>
</template>
<script>
import {VMoney} from 'v-money';
import { useForm } from '@inertiajs/vue3';
import Amount from '@/Shared/Components/Forms/Amount.vue';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    components: { InputLabel, TextInput, Amount },
    directives: {money: VMoney},
    data(){
        return {
            currentUrl: window.location.origin,
            selected: {},
            money: {
                decimal: '.',
                thousands: ',',
                prefix: '₱',
                precision: 2,
                masked: false
            },
            form: useForm({
                id: null,
                item_id: null,
                name: null,
                amount: null,
                option: 'edit'
            }),
            showModal: false
        }
    },
    methods: { 
        show(data){
            this.form.item_id = data.id;
            this.form.id = data.itemable.id;
            this.form.name = data.itemable.name;
            this.form.amount = data.amount;
            this.$refs.testing.emitValue(data.amount);
            this.selected = data;
            this.showModal = true;
        },
        amount(val){
            this.form.amount = val;
        },
        submit(){
            this.form.put('/nonlabreceipts/update',{
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
        },
    }
}
</script>