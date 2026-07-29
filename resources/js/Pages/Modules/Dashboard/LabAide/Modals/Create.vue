<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" title="Sample Disposal" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <template  v-if="selected">
        <div class="d-flex mb-n3 mt-2">
            <div class="flex-shrink-0 me-3">
                <div style="height:2.5rem;width:2.5rem;">
                    <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                        <i class="ri-flask-fill  text-primary fs-24"></i>
                    </span>
                </div>
            </div>
            <div class="flex-grow-1">
                <h5 class="mb-0 fs-14"><span class="text-body">{{selected.sample.code}}</span></h5>
                <p class="text-muted text-truncate-two-lines fs-12">{{selected.sample.name}}</p>
            </div>
        </div>
        <div class="alert alert-warning mt-3" role="alert">Due Date : <b>{{ selected.due_at }}</b></div>
        <hr class="text-muted mt-3 mb-2"/>
        <form class="customform">
            <BRow class="g-2">
                <BCol lg="12" class="mt-2">
                    <InputLabel value="Type of Disposal" :message="form.errors.disposal_id"/>
                    <Multiselect 
                    :options="disposals" 
                    v-model="form.disposal_id" 
                    label="name"
                    :searchable="true" 
                    @input="handleInput('disposal_id')"
                    placeholder="Select Type"/>
                </BCol>
                <BCol lg="12" class="mt-1">
                    <InputLabel value="Disposed Date" :message="form.errors.disposed_at"/>
                    <TextInput v-model="form.disposed_at" type="date" class="form-control" placeholder="Please select date" @input="handleInput('disposed_at')" :light="true"/>
                </BCol>
            </BRow>
        </form>
           </template>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="submit('ok')" variant="primary" :disabled="form.processing" block>Submit</b-button>
        </template>
    </b-modal>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
import Multiselect from "@vueform/multiselect";
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    components: { Multiselect, InputLabel, TextInput },
    props: ['disposals'],
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                sample: null,
                disposal_id: null,
                disposed_at: null,
                option: 'disposal'
            }),
            selected: null,
            showModal: false
        }
    },
    methods: { 
        show(data){
            this.selected = data;
            this.form.sample = data.sample;
            this.showModal = true;
        },
        submit(){
            this.form.post('/samples',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('success',this.$page.props.flash.data.data);
                    this.hide();
                },
            });
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        hide(){
            this.form.reset();
            this.showModal = false;
        }
    }
}
</script>