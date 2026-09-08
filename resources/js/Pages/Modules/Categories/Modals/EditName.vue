<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" title="Edit Sample Name" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow>
                <BCol lg="12">
                    <InputLabel for="name" value="Sample Name" :message="form.errors.name"/>
                    <TextInput id="name" v-model="form.name" type="text" class="form-control" autofocus placeholder="Please enter name" autocomplete="name" required :light="true"/>
                </BCol>
            </BRow>
        </form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="submit()" variant="primary" :disabled="form.processing" block>Submit</b-button>
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
            form: useForm({
                id: null,
                name: null,
                type_id: null,
                option: 'name'
            }),
            showModal: false
        }
    },
    methods: {
        edit(data){
            this.form.id = data.id;
            this.form.name = data.name;
            this.form.type_id = data.type_id;
            this.showModal = true;
        },
        submit(){
            this.form.put('/categories/update',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('updated',true);
                    this.hide();
                },
            });
        },
        hide(){
            this.form.reset();
            this.form.clearErrors();
            this.showModal = false;
        }
    }
}
</script>
