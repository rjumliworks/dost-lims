<template>
    <b-modal v-model="showModal"  style="--vz-modal-width: 600px;" header-class="p-3 bg-light" title="Update Analysis" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <b-col lg class="mt-2">
            <label style="font-size: 12px; margin-bottom: 3px;">Started By / Date :</label>
            <div class="input-group mb-1">
                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                <Multiselect class="white" style="width: 60%;" :options="analysts" v-model="form.started" object label="name" :allow-empty="false" :searchable="true" placeholder="Select Analyst" />
                <TextInput v-model="form.start_at" type="date" class="form-control" @input="handleInput('start_at')" :light="true"/>
            </div>
        </b-col>
        <b-col lg class="mt-2" v-if="form.ended">
            <label style="font-size: 12px; margin-bottom: 3px;">Ended By / Date :</label>
            <div class="input-group mb-1">
                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                <Multiselect class="white" style="width: 60%;" :options="analysts" v-model="form.ended" object label="name" :allow-empty="false" :searchable="true" placeholder="Select Analyst" />
                <TextInput v-model="form.end_at" type="date" class="form-control" @input="handleInput('ended_at')" :light="true"/>
            </div>
        </b-col>
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
    components: { InputLabel, TextInput, Multiselect },
    props: ['analysts'],
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                id: null,
                started: null,
                start_at: null,
                ended: null,
                end_at: null,
                option: 'tagging'
            }),
            showModal: false
        }
    },
    methods: { 
        show(data){
            this.form.id = data.id;
            if(data.started){
                this.form.started = {
                    value: data.started_id,
                    name: data.started
                };
                this.form.start_at = this.convertToISO(data.start_at);
            }
            if(data.ended){
                this.form.ended = {
                    value: data.ended_id,
                    name: data.ended
                };
                this.form.end_at = this.convertToISO(data.end_at);
            }
            this.showModal = true;
        },
        submit(){
            this.form.put('/analyses/update',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('update',response.props.flash.data.data);
                    this.hide();
                },
            });
        },
        convertToISO(dateString) {
            const date = new Date(dateString);
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');

            return `${year}-${month}-${day}`;
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