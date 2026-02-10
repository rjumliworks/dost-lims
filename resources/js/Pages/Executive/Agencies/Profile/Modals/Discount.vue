<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" title="Add Discount" class="v-modal-custom"
        modal-class="zoomIn" centered no-close-on-backdrop>
        <div>
            <form class="customform">
                <BRow class="g-2">
                    <BCol lg="12" class="mt-1">
                        <InputLabel for="middlename" value="Discount" :message="form.errors.discount_id"/>
                        <Multiselect :options="filteredOptions" v-model="form.discount_id" label="name" placeholder="Select Discount" @input="handleInput('discount_id')" :light="true"/>
                    </BCol>
                    <BCol lg="12"><hr class="text-muted mt-3 mb-2"/></BCol>
                    <BCol lg="12">
                        <BRow class="g-3">
                            <BCol lg="8"  style="margin-top: 13px; margin-bottom: -12px;" class="fs-12" :class="(form.errors.is_occasional) ? 'text-danger' : ''">Is Occasional?</BCol>
                            <BCol lg="4"  style="margin-top: 13px; margin-bottom: -12px;">
                            <div class="row">
                                    <div class="col-md-6">
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="customRadio1" class="custom-control-input me-2" @input="handleInput('is_occasional')" value="1" v-model="form.is_occasional">
                                            <label class="custom-control-label fw-normal fs-12" for="customRadio1">Yes</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="customRadio2" class="custom-control-input me-2" @input="handleInput('is_occasional')" value="0" v-model="form.is_occasional">
                                            <label class="custom-control-label fw-normal fs-12" for="customRadio2">No</label>
                                        </div>
                                    </div>
                                </div>
                            </BCol>
                            <BCol lg="12"><hr class="text-muted mt-n2"/></BCol>
                        </BRow>
                    </BCol>
                    <BCol lg="12" class="mt-0">
                        <BRow class="g-3">
                            <BCol lg="8"  style="margin-top: 13px; margin-bottom: -12px;" class="fs-12" :class="(form.errors.is_active) ? 'text-danger' : ''">Mark as Active?</BCol>
                            <BCol lg="4"  style="margin-top: 13px; margin-bottom: -12px;">
                            <div class="row">
                                    <div class="col-md-6">
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="customRadio1" class="custom-control-input me-2" @input="handleInput('is_active')" value="1" v-model="form.is_active">
                                            <label class="custom-control-label fw-normal fs-12" for="customRadio1">Yes</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="customRadio2" class="custom-control-input me-2" @input="handleInput('is_active')" value="0" v-model="form.is_active">
                                            <label class="custom-control-label fw-normal fs-12" for="customRadio2">No</label>
                                        </div>
                                    </div>
                                </div>
                            </BCol>
                            <BCol lg="12"><hr class="text-muted mt-n2"/></BCol>
                        </BRow>
                    </BCol>
                </BRow>
            </form>
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
    import Multiselect from "@vueform/multiselect";
    export default {
        props: ['selected','options','discounts'],
        components: {InputLabel, TextInput, Multiselect },
        data() {
            return {
                currentUrl: window.location.origin,
                form: useForm({
                    id: null,
                    discount_id: null,
                    agency_id: null,
                    is_occasional: null,
                    is_active: null,
                    option: 'discount'
                }),
                showModal: false,
                editable: false
            }
        },
        computed: {
            filteredOptions() {
                const usedIds = this.discounts.map(d => d.discount_id ?? d);
                return this.options.filter(option => !usedIds.includes(option.value));
            }
        },
        methods: {
            show(id) {
                this.form.agency_id = id;
                this.showModal = true;
            },
            submit() {
                this.form.post('/agencies', {
                    preserveScroll: true,
                    onSuccess: (response) => {
                        // this.$emit('update', true);
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
