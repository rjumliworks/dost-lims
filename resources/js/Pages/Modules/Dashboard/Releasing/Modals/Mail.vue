<template>
    <b-modal v-if="selected" style="--vz-modal-width: 600px;" v-model="showModal" header-class="p-3 bg-light" title="TSR Mailing" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="row">
            <div class="col-sm-12">
                <div class="row align-items-center g-3">
                    <div class="col-md">
                        <div>
                            <h6><span class="fw-semibold text-primary fs-15">{{selected.code}}</span></h6>
                            <div class="hstack gap-3 fs-12 flex-wrap mt-n1">
                                <div><span class="fw-medium">{{selected.customer }}</span></div>
                                <div class="vr" style="width: 1px;"></div>
                                <div><span class="text-muted">Email Address</span> : 
                                    <span v-if="selected.contact_no" class="fw-medium"> {{ selected.email }}</span>
                                    <span v-else class="text-muted">Not Available</span>
                                </div>
                                <!-- <div class="vr" style="width: 1px;"></div>
                                <div><span class="text-muted">Due Date</span>: 
                                    <span v-if="selected.due_at" class="fw-medium">{{selected.due_at}}</span>
                                    <span v-else class="text-muted">Not Available</span>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12"><hr class="text-muted"/></div>
        </div>
        <form class="customform">
            <BRow class="g-3">
                <BCol lg="12">
                    <InputLabel value="Mailed Date" :message="form.errors.released_at"/>
                    <TextInput v-model="form.mailed_at" type="date" class="form-control" placeholder="Please select date" @input="handleInput('released_at')" :light="true"/>
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
                id: null,
                mailed_at: null,
                status_id: 43,
                option: 'release'
            }),
            selected: null,
            showModal: false,
            editable: false
        }
    },
    methods: { 
        show(data){
            console.log(data);
            this.form.id = data.id;
            this.selected = data;
            this.showModal = true;
        },
        submit(){
            this.form.tsr_id = (this.tsr) ? this.tsr.value : null;
            this.form.put('/releasing/update',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('update',this.$page.props.flash.data.data);
                    this.hide();
                },
            });
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