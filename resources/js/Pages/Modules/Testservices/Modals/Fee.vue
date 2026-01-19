<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" :title="(editable) ? 'Update Fee' : 'Add Fee'" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow class="g-3">
                <BCol lg="12">
                    <InputLabel for="name" value="Description" :message="form.errors.name"/>
                    <TextInput id="name" v-model="form.name" type="text" class="form-control" placeholder="Please enter name" :light="true"/>
                </BCol>   
                <BCol lg="12" class="mt-0">
                    <InputLabel for="short" value="Fee" :message="form.errors.fee"/>
                    <Amount @amount="amount" ref="testing" :readonly="false"/>
                </BCol> 
            </BRow>     
        </form>     
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button v-if="!fee" @click="submit('ok')" variant="primary" :disabled="form.processing" block>Submit</b-button>
        </template>
    </b-modal>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
import Amount from '@/Shared/Components/Forms/Amount.vue';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    components: { InputLabel, TextInput, Amount },
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                id: null,
                name: null,
                fee: null,
                agency_id: this.$page.props.user.data.agency,
                is_additional: true,
                description: 'n/a',
                option: 'fee'
            }),
            editable: false,
            showModal: false
        }
    },
    methods: { 
        show(id){
            this.form.reset();
            this.form.errors = [];
            this.$refs.testing.emitValue(0);
            this.form.id = id;
            this.editable = false;
            this.showModal = true;
        },
        amount(val){
            this.form.fee = val;
        },
        edit(data){
            this.form.id = data.id;
            this.form.name = data.name;
            this.form.fee = data.fee;
            this.$refs.testing.emitValue(this.form.fee);
            this.editable = true;
            this.showModal = true;
        },
        submit(){
            if(!this.editable){
                this.form.post('/testservices',{
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.hide();
                    },
                });
            }else{
                this.form.put('/testservices/update',{
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.hide();
                    },
                });
            }
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>