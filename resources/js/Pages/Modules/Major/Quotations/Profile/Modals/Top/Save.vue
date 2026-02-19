<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 600px;" hide-footer hide-header title="Cancel Request" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="modal-body">
            <div class="mt-2">
                <h4 class="mb-1 text-center">Edit Information for the Quotation</h4>
                <p class="text-primary mb-4 fs-11 text-center">Upon confirming, you cannot add samples, analyses, or edit information for the quotation.</p>
                <!-- <p class="text-muted mb-4">Please double-check all data to avoid cancellation or updating of the data.</p> -->
                <div class="customform">
                    <h6 class="fw-semibold" style="font-size: 11px; margin-top: 12px;">1. VALIDITY DATE  </h6>
                    <BCol lg="12" class="mt-2">
                        <!-- <InputLabel for="due" value="Valid Until" :message="form.errors.due_at"/> -->
                        <TextInput v-model="form.due_at" type="date" class="form-control" @input="handleInput('due_at')" :light="true"/>
                    </BCol>
                    <h6 class="fw-semibold" style="font-size: 11px; margin-top: 15px;">2. TERMS AND CONDITION</h6>
                    <ul class="fs-11" style="margin-left: -20px;">
                        <li v-for="(list,index) in terms" v-bind:key="index" @click="editTerm(list, index)" :style="{ cursor: list.is_editable ? 'pointer' : 'default' }">{{list.name}}</li>
                    </ul>
                    <button @click="openTerm()" class="btn btn-sm btn-light mt-n1">Add Terms and Condition</button>
                    <h6 class="fw-semibold" style="font-size: 11px; margin-top: 12px;">3. CONFIRMATION  </h6>
                    <BCol lg="12" class="mt-2">
                        <!-- <InputLabel for="due" value="Please type CONFIRM to continue."/> -->
                        <TextInput v-model="keyword" type="text" placeholder="Please type CONFIRM to continue" class="form-control" :light="true"/>
                    </BCol>
                    <div class="hstack gap-2 justify-content-center mt-4">
                        <button @click="hide()" class="btn btn-light btn-md" type="button">
                            <div class="btn-content"> Close</div>
                        </button>
                        <button @click="submit()" :disabled="keyword !== 'CONFIRM'" class="btn btn-primary">Submit</button>
                    </div>
                    
                </div>
            </div>
        </div>
    </b-modal>
    <Term @new="addNew" @update="saveTerm" ref="term"/>
</template>
<script>
import Term from '../Terms/Add.vue';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
export default {
    components: { InputLabel, TextInput, Term },
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
               reference: null,
               status_id: 15,
               due_at: null,
               terms: null,
               option: 'save'
            }),
            editedTerm: { name: '', index: null },
            keyword: null,
            showModal: false
        }
    },
    computed: {
        terms() {
            return [
                { name: 'DOST-IX RSTL implements Payment First Policy.', is_editable: 0 },
                { name: 'Payment Method: Cheque payment should be paid to DOST IX;', is_editable: 0 },
                { name: 'DOST IX Trust Fund 1952101052 Landbank of the Philippines.', is_editable: 0 },
                { name: 'Cash payment should be made directly to the cashier or deposit to DOST IX account.', is_editable: 0 },
                { name: 'This quotation is valid only until ' + (this.form.due_at ? this.form.due_at : 'N/A'), is_editable: 1 },
                { name: 'Availability of testing and calibration services may change without prior notice. Please contact the laboratory to confirm before submitting your samples.'}
            ];
        }
    },
    methods: { 
        show(id){
            this.form.reference = id;
            this.showModal = true;
        },
        addNew(data) {
            this.terms.push({ name: data, is_editable: 1 });
        },
        openTerm(){
            this.$refs.term.show();
        },
        editTerm(list,index){
            if (list.is_editable) {
                this.editedTerm = { ...list, index };
                this.$refs.term.edit(this.editedTerm);
            }
        },
        saveTerm(data) {
            this.terms[this.editedTerm.index].name = data;
        },
        submit(){
            this.form.terms = this.terms;
            this.form.put('/quotations/update',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('selected',response.props.flash.data.data);
                    this.hide();
                },
            });
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>