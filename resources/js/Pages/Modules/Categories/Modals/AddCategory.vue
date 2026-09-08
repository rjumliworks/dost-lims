<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" :title="(editable) ? 'Edit Category' : 'Add Category'" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow>
                <BCol lg="12">
                    <InputLabel for="name" value="Category" :message="form.errors.name"/>
                    <TextInput id="name" v-model="form.name" type="text" class="form-control" autofocus placeholder="Please enter name" autocomplete="name" required :class="{ 'is-invalid': errors.name }" :light="true"/>
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
                id: null,
                name: null,
                laboratory_id: null,
                agency_id: this.$page.props.user.data.agency,
                option: 'category'
            }),
            errors: '',
            showModal: false,
            editable: false
        }
    },
    methods: {
        show(laboratory,name){
            this.editable = false;
            this.form.id = null;
            this.form.name = name;
            this.form.laboratory_id = laboratory;
            this.showModal = true;
        },
        edit(data){
            this.editable = true;
            this.form.id = data.id;
            this.form.name = data.name;
            this.form.laboratory_id = data.laboratory_id;
            this.showModal = true;
        },
        submit(){
            if(this.editable){
                this.form.put('/categories/update',{
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.$emit('updated',true);
                        this.hide();
                    },
                });
            }else{
                this.form.post('/categories',{
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.$emit('selected',response.props.flash.data);
                        this.hide();
                    },
                });
            }
        },
        hide(){
            this.form.reset();
            this.form.clearErrors();
            this.editable = false;
            this.showModal = false;
        }
    }
}
</script>