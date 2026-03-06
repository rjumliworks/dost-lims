<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" title="Set Signatory" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
         <b-col lg class="mt-2">
            <label style="font-size: 12px; margin-bottom: 3px;">Started By / Date :</label>
            <div class="input-group mb-1">
                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                <Multiselect class="white" style="width: 60%;" :options="analysts" v-model="form.started" object label="name" :allow-empty="false" :searchable="true" placeholder="Select Analyst" />
                <TextInput v-model="form.start_at" type="date" class="form-control" @input="handleInput('start_at')" :light="true"/>
            </div>
        </b-col>

        <template v-slot:footer>
            <b-button @click="hide" variant="light" block>Close</b-button>
            <b-button @click="openResult" variant="primary" block>Submit</b-button>
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
    data() {
        return {
            form: useForm({
                id: null,
                started: null,
                start_at: null,
                ended: null,
                end_at: null,
                option: 'tagging'
            }),
            type: null,
            showModal: false
        };
    },
   
    methods: {
        show(type) {
            this.type = type;
            this.showModal = true;
        },
        hide() {
            this.showModal = false;
        },
    }
};
</script>
