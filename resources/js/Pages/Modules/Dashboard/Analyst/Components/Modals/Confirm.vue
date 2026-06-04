<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 650px;" header-class="p-3 bg-light" title="Confirm Report no. Generation" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <BRow class="g-3">
            <BCol lg="12">
                <!-- Warning Alert -->
                <div class="alert alert-warning alert-dismissible alert-label-icon label-arrow fade show material-shadow" role="alert">
                    <i class="ri-alert-line label-icon"></i><strong>Would you like to generate a single report number for all samples?</strong>
                </div>

            </BCol>
            <BCol lg="12">
                <BRow class="g-3 mt-n4 mb-n3">
                    <BCol lg="12"><hr class="text-muted mb-n3 mt-n1"/></BCol>
                    <BCol lg="12" style="margin-top: 0px; margin-bottom: -12px;">
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="custom-control custom-radio mb-1">
                                    <input type="radio" id="customRadio1" class="custom-control-input me-2" @input="handleInput('is_single')" :value="true" v-model="form.is_single">
                                    <label class="custom-control-label fw-normal fs-13" for="customRadio1">Yes, Generate one report number for all samples</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="custom-control custom-radio mb-3">
                                    <input type="radio" id="customRadio2" class="custom-control-input me-2" @input="handleInput('is_single')" :value="false" v-model="form.is_single">
                                    <label class="custom-control-label fw-normal fs-13" for="customRadio2">No, Generate a separate report number for each sample</label>
                                </div>
                            </div>
                        </div>
                    </BCol>
                    <BCol lg="12"><hr class="text-muted mt-n2"/></BCol>
                </BRow>
            </BCol>
        </BRow>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
            <b-button @click="submit()" variant="primary" :disabled="form.processing" block>Submit</b-button>
        </template>
    </b-modal>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                id: null,
                is_single: null,
                laboratory_id: null,
                option: 'multiple',
                checked: []
            }),
            selected: null,
            showModal: false
        }
    },
    methods: { 
        show(checked,laboratory_id){
            const sortedChecked = [...checked].sort((a, b) => a - b);
            this.form.checked = sortedChecked;
            this.form.laboratory_id = laboratory_id;
            this.showModal = true;
        },
        submit(type){
            this.form.post('/testreports',{
                preserveScroll: true,
                onSuccess: (response) => {
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
            this.showModal = false;
        }
    }
}
</script>