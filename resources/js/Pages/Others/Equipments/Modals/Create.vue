<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 900px;" header-class="p-3 bg-light" :title="(!editable) ? 'Add Equipment' : 'Edit Equipment'" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow class="g-3 mt-1">
                <BCol lg="3" class="mt-1"> 
                    <InputLabel value="Code" :message="form.errors.code"/>
                    <TextInput v-model="form.code" type="text" class="form-control" placeholder="Please enter code" @input="handleInput('code')" :light="true"/>
                </BCol>
                <BCol lg="9" class="mt-1"> 
                    <InputLabel value="Name" :message="form.errors.name"/>
                    <TextInput v-model="form.name" type="text" class="form-control" placeholder="Please enter name" @input="handleInput('name')" :light="true"/>
                </BCol>
                <BCol lg="3" class="mt-0"> 
                    <InputLabel value="Manufacturer" :message="form.errors.manufacturer"/>
                    <TextInput v-model="form.manufacturer" type="text" class="form-control" placeholder="Please enter manufacturer" @input="handleInput('manufacturer')" :light="true"/>
                </BCol>
                <BCol lg="3" class="mt-0"> 
                    <InputLabel value="Model" :message="form.errors.model"/>
                    <TextInput v-model="form.model" type="text" class="form-control" placeholder="Please enter model" @input="handleInput('model')" :light="true"/>
                </BCol>
                <BCol lg="3" class="mt-0"> 
                    <InputLabel value="Serial No." :message="form.errors.serial_no"/>
                    <TextInput v-model="form.serial_no" type="text" class="form-control" placeholder="Please enter serial no." @input="handleInput('serial_no')" :light="true"/>
                </BCol>
                <BCol lg="3" class="mt-0"> 
                    <InputLabel value="Price" :message="form.errors.price"/>
                    <Amount @amount="amount" ref="testing" :readonly="false" @input="handleInput('price')"/>
                </BCol>
                <BCol lg="12">
                    <hr class="text-muted mt-0 mb-2"/>
                </BCol>
                
                <BCol lg="3" class="mt-0">
                    <InputLabel value="Acquired Date" :message="form.errors.acquired_at"/>
                    <TextInput v-model="form.acquired_at" type="date" class="form-control" placeholder="Please select date" @input="handleInput('acquired_at')" :light="true"/>
                </BCol>
                <BCol lg="3" class="mt-0"> 
                    <InputLabel value="Laboratory" :message="form.errors.laboratory_id"/>
                    <Multiselect 
                    :options="dropdowns.laboratories" 
                    v-model="form.laboratory_id" 
                    label="name"
                    @input="handleInput('laboratory_id')"
                    placeholder="Select Laboratory"/>
                </BCol>
                <BCol lg="6" class="mt-0">
                    <div class="d-flex">
                        <div style="width: 100%;">
                            <InputLabel for="supplier_id" value="Supplier" :message="form.errors.supplier_id"/>
                            <Multiselect :options="dropdowns.suppliers" label="name" :searchable="true" v-model="form.supplier_id" placeholder="Select Supplier"/>
                        </div>
                        <div class="flex-shrink-0">
                            <b-button @click="openSupplier()" style="margin-top: 20px;" variant="light" class="waves-effect waves-light ms-1"><i class="ri-add-circle-fill"></i></b-button>
                        </div>
                    </div>
                </BCol>
                <BCol lg="12">
                    <hr class="text-muted mt-0 mb-2"/>
                </BCol>
                <BCol lg="3" class="mt-0"> 
                    <InputLabel value="Maintenance Plan" :message="form.errors.maintenance_plan"/>
                    <Multiselect 
                    :options="['1 month','2 months','6 months','1 year','2 years','Not Available']" 
                    v-model="form.maintenance_plan" 
                    label="name"
                    @input="handleInput('maintenance_plan')"
                    placeholder="Select plan"/>
                </BCol>
                <BCol lg="3" class="mt-0"> 
                    <InputLabel value="Calibration Program" :message="form.errors.calibration_program"/>
                    <Multiselect 
                    :options="['6 months','1 year','2 years','Not Applicable']" 
                    v-model="form.calibration_program" 
                    label="name"
                    @input="handleInput('calibration_program')"
                    placeholder="Select program"/>
                </BCol>
                <BCol lg="6" class="mt-0">
                    <InputLabel value="Calibration test points" :message="form.errors.calibration_testpoints"/>
                    <TextInput v-model="form.calibration_testpoints" type="text" class="form-control" placeholder="Enter calibration testpoints" @input="handleInput('calibration_testpoints')" :light="true"/>
                </BCol>
                <BCol lg="12">
                    <hr class="text-muted mt-0 mb-2"/>
                </BCol>
                <BCol lg="12" class="mt-0">
                    <InputLabel for="comment" value="Other Specification(s)" />
                    <textarea id="comment" v-model="form.others" maxlength="250" rows="2" type="text" class="form-control" placeholder="Please enter description" style="background-color: #f5f6f7;"/>
                </BCol>
            </BRow>
        </form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button v-if="editable" @click="submit('ok')" variant="primary" :disabled="form.processing" block>Update</b-button>
            <b-button v-else @click="submit('ok')" variant="primary" :disabled="form.processing" block>Submit</b-button>
        </template>
    </b-modal>
    <!-- <Supplier @message="pushNew" :dropdowns="dropdowns" ref="create"/> -->
</template>
<script>
import _ from 'lodash';
import { useForm } from '@inertiajs/vue3';
import Multiselect from "@vueform/multiselect";
// import Supplier from '../../Inventory/Suppliers/Modals/Create.vue';
import Amount from '@/Shared/Components/Forms/Amount.vue';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    props: ['dropdowns'],
    components: { InputLabel, TextInput, Multiselect, Amount },
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                id: null,
                code: null,
                name: null,
                manufacturer: null,
                model: null,
                serial_no: null,
                price: null,
                others: null,
                maintenance_plan: null,
                calibration_program: null,
                calibration_testpoints: null,
                laboratory_id: null,
                supplier_id: null,
                acquired_at: null,
            }),
            showModal: false,
            editable: false
        }
    },
    methods: { 
        show(){
            this.showModal = true;
        },
        edit(data){
            console.log(data);
            const p = data.price.replace(/[₱,]/g, "");
            this.form.id = data.id;
            this.form.code = data.code;
            this.form.name = data.name;
            this.form.manufacturer = data.manufacturer;
            this.form.model = data.model;
            this.form.serial_no = data.serial_no;
            this.form.price = p;
            this.form.maintenance_plan = data.maintenance_plan;
            this.form.calibration_program = data.calibration_program;
            this.form.calibration_testpoints = data.calibration_testpoints;
            this.form.laboratory_id = data.laboratory_id;
            this.form.acquired_at = (data.acquired_at == '-' || data.acquired_at == null) ? null : data.acquired_at;
            this.form.calibration_due = data.calibration_due;
            this.form.others = data.others;
            this.form.supplier_id = data.supplier_id;
            this.editable = true;
            this.showModal = true;

            this.$nextTick(() => {
                if (this.$refs.testing) {
                    this.$refs.testing.emitValue(p);
                }
            });
        },
        submit(){
            if(this.editable){
                this.form.put('/equipments/update',{
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.form.reset();
                        this.$emit('message',true);
                        this.hide();
                    }
                });
            }else{
                this.form.post('/equipments',{
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.form.reset();
                        this.$emit('message',true);
                        this.hide();
                    },
                });
            }
        },
        pushNew(data){
            this.form.supplier_id = data.data.id;
        },
        openSupplier(){
            this.$refs.create.show();
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        amount(val){
            this.form.price = val;
        },
        hide(){
            this.form.reset();
            this.editable = false;
            this.showModal = false;
        }
    }
}
</script>