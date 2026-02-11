
<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" title="Add Fee" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
         <div>
            <form class="customform">
                <BRow class="g-2">
                    <BCol lg="8" class="mt-1">
                        <InputLabel for="middlename" value="Name" :message="form.errors.name"/>
                        <TextInput id="middlename" v-model="form.name" type="text" class="form-control" placeholder="Please enter name" @input="handleInput('name')" :light="true"/>
                    </BCol>
                    <BCol lg="4" class="mt-1">
                        <InputLabel for="middlename" value="Fee" :message="form.errors.fee"/>
                        <TextInput id="middlename" v-model="form.fee" type="text" class="form-control" placeholder="Please enter fee" @input="handleInput('fee')" :light="true"/>
                    </BCol>
                    <BCol lg="12" class="mt-1">
                        <InputLabel for="middlename" value="Description" :message="form.errors.description"/>
                        <TextInput id="middlename" v-model="form.description" type="text" class="form-control" placeholder="Please enter description" @input="handleInput('description')" :light="true"/>
                    </BCol>
                </BRow>
            </form>
            <div class="alert border-0 alert-warning material-shadow fs-11 mt-4 mb-0" role="alert">
                <strong>Note:</strong> This information is printed on system-generated reports such as the Technical Service Request (TSR) Report.
                Ensure that all entries are accurate, as these details will appear on official documents issued by the system.
            </div>

        </div>
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
    components: { TextInput, InputLabel },
    props: ['id'],
    data(){
        return {
            form: useForm({
                laboratory_id: null,
                name: null,
                description: null,
                fee: null,
                is_additional: 0,
                agency_id: this.id,
                option: 'addfee'
            }),
            labs: null,
            showModal: false,
        }
    },
    methods: { 
        show(id){
            this.form.laboratory_id = id;
            this.showModal = true;
        },
        submit(){
            this.form.post('/agencies', {
                preserveScroll: true,
                onSuccess: () => {
                    this.$emit('update',this.$page.props.flash.data);
                    this.hide();
                },
            });
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        hide(){
            this.form.reset();
            this.form.clearErrors();
            this.showModal = false;
        }
    }
}
</script>