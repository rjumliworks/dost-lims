<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" title="TSR Releasing" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow class="g-3">
                <BCol lg="12">
                    <InputLabel for="customer" value="TSR Code" :message="form.errors.id"/>
                    <Multiselect 
                    :options="tsrs" 
                    @search-change="fetchTsr" 
                    v-model="tsr" 
                    object
                    label="name"
                    :searchable="true" 
                    @input="handleInput('id')"
                    placeholder="Select Tsr Code"/>
                </BCol>
                <BCol lg="12 mt-1" v-if="tsr">
                    <InputLabel value="Customer"/>
                    <TextInput :value="tsr.customer" type="text" class="form-control" readonly :light="true"/>
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
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    components: { Multiselect, InputLabel, TextInput },
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                tsr_id: null,
                option: 'release'
            }),
            tsr: null,
            tsrs: [],
            showModal: false,
            editable: false
        }
    },
    methods: { 
        show(){
            this.showModal = true;
        },
        submit(){
            this.form.tsr_id = (this.tsr) ? this.tsr.value : null;
            this.form.post('/release',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('success',this.$page.props.flash.data);
                    this.hide();
                },
            });
        },
        fetchTsr(code){
            axios.get('/search',{
                params: {
                    option: 'tsrs',
                    keyword: code
                }
            })
            .then(response => {
                this.tsrs = response.data;
            })
            .catch(err => console.log(err));
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        hide(){
            this.form.reset();
            this.editable = false;
            this.showModal = false;
        }
    }
}
</script>