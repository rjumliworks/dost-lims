<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 700px;" header-class="p-3 bg-light" title="View Agency" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <h5 class="fs-14 ms-1">Activate Agency</h5>
        <p class="text-muted ms-1"> You're about to activate this agency and grant it access to the laboratory system within your network.
            Activating this agency will enable the following:</p>
       
            <ul class="list-unstyled">
                <li class="py-1"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i>Full access to the Laboratory Information Management System (LIMS)</li>
                <li class="py-1"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i>Ability to request and manage test services</li>
                <li class="py-1"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i>Access to system features including sample tracking, reporting, and analytics</li>
                <li class="py-1"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i>Integration with other networked laboratories</li>
                <li class="py-1"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i>More tools to support laboratory operations and collaboration</li>
            </ul>
          <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="submit('ok')" variant="primary" :disabled="form.processing" block>Activate</b-button>
        </template>
    </b-modal>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
import Multiselect from "@vueform/multiselect";
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    components: {InputLabel, TextInput, Multiselect },
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                id: null,
                option: 'activate'
            }),
            selected: null,
            showModal: false
        }
    },
    methods: { 
        show(data){
            this.selected = data;
            this.showModal = true;
        },
        submit(){
            this.form.id = this.selected.id;
            this.form.post('/agencies',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('update',this.$page.props.flash.data.data);
                    this.hide();
                },
            });
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>