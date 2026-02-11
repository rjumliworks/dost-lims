
<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" title="Add Laboratory" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow class="g-3 mt-n1">
                <BCol lg="12" class="mt-0 mb-2">
                    <div class="alert fs-10 alert-danger alert-dismissible alert-label-icon label-arrow fade show mb-xl-0 material-shadow" role="alert">
                        <i class="ri-error-warning-line label-icon"></i><strong>Notice</strong>
                        - Adding a new laboratory to the facility.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </BCol>
                <BCol lg="12" class="mt-0 mb-2">
                    <InputLabel value="Laboratory" :message="form.errors.laboratory_id"/>
                     <Multiselect
                    v-model="form.laboratory_id" 
                    :options="filteredLaboratories"
                    label="name"
                    ref="multiselect2"
                    placeholder="Select Laboratory"/>
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
import Multiselect from "@vueform/multiselect";
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
export default {
    components: { Multiselect, InputLabel },
    props: ['laboratories'],
    data(){
        return {
            form: useForm({
                id: null,
                laboratory_id: null,
                option: 'laboratory'
            }),
            labs: null,
            showModal: false,
        }
    },
    computed: {
        filteredLaboratories() {
            if (!this.laboratories) return [];

            if (!this.labs || this.labs.length === 0) {
                return this.laboratories;
            }

            // Get existing laboratory IDs from labs
            const existingIds = this.labs.map(l => l.laboratory_id);

            // Filter laboratories that are NOT in labs
            return this.laboratories.filter(
                lab => !existingIds.includes(lab.value)
            );
        }
    },
    methods: { 
        show(id,labs){
            this.labs = labs;
            this.form.id = id;
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