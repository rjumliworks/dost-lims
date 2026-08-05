<template>
    <b-modal v-if="selected" v-model="showModal" style="--vz-modal-width: 600px;" header-class="p-3 bg-light" title="Edit TSR" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <div class="row g-2">
                <BCol lg="12">
                    <div class="alert alert-warning alert-dismissible alert-label-icon label-arrow fade show material-shadow fs-11" role="alert">
                        <i class="ri-alert-line label-icon"></i><strong>Warning</strong> - Only TSR's with <b>Pending</b> or <b>For Payment</b> status can be updated.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </BCol>
                <BCol lg="12" class="mt-n1">
                    <InputLabel for="customer" value="Customer" :message="form.errors.customer"/>
                    <Multiselect 
                    :options="customers" 
                    @search-change="fetchCustomer" 
                    v-model="form.customer" 
                    object label="name"
                    :searchable="true" 
                    @input="handleInput('customer')"
                    placeholder="Select Customer"/>
                </BCol>
                <BCol :lg="(form.conforme) ? 6 : 12" class="mt-1" v-if="form.customer">
                    <div class="d-flex">
                        <div style="width: 100%;">
                            <InputLabel for="conforme" value="Conforme" :message="form.errors.conforme"/>
                            <Multiselect 
                            :options="form.customer.conformes" 
                            v-model="form.conforme" 
                            label="name"
                            object
                            @input="handleInput('conforme')"
                            :searchable="true" 
                            placeholder="Select Conforme"/>
                        </div>
                        <div class="flex-shrink-0">
                            <b-button @click="openAdd()" style="margin-top: 20px;" variant="light" class="waves-effect waves-light ms-1"><i class="ri-add-circle-fill"></i></b-button>
                        </div>
                    </div>
                </BCol>
                <BCol lg="6" v-if="(form.conforme) ? true : false" class="mt-1">
                    <InputLabel for="due" value="Mobile No" :message="form.errors.conforme"/>
                    <TextInput v-model="form.conforme.contact_no" type="text" class="form-control" placeholder="Please enter name" @input="handleInput('conforme')" :light="true"/>
                </BCol>
            </div>
            <hr class="text-muted mb-2"/>
            <div class="row customform g-2 mt-n2">
                
                <BCol lg="6" class="mt-2">
                    <InputLabel for="region" value="Laboratory" :message="form.errors.laboratory_id"/>
                    <Multiselect 
                    :options="dropdowns.laboratories" 
                    v-model="form.laboratory_id"
                    @input="handleInput('laboratory_id')"
                    label="name"
                    placeholder="Select Laboratory"/>
                </BCol>
                  <BCol lg="6" class="mt-2">
                    <InputLabel for="region" value="Mode of Release" :message="form.errors.release_id"/>
                    <Multiselect 
                    :options="dropdowns.releases" 
                    v-model="form.release_id"
                    @input="handleInput('release_id')"
                    label="name"
                    placeholder="Select Mode"/>
                </BCol>
                <!-- <BCol lg="6" class="mt-2">
                    <InputLabel for="due" value="Report Due" :message="form.errors.due_at"/>
                    <TextInput v-model="form.due_at" type="date" class="form-control" placeholder="Please enter email" @input="handleInput('due_at')" :light="true"/>
                </BCol> -->
                <BCol lg="6" class="mt-1">
                    <InputLabel for="region" value="Discount" :message="form.errors.discount_id"/>
                    <Multiselect 
                    :options="dropdowns.discounts" 
                    v-model="form.discount_id"
                    @input="handleInput('discount_id')"
                    label="name"
                    placeholder="Select Discount"/>
                </BCol>
                <BCol lg="6" class="mt-1">
                    <InputLabel for="region" value="Purpose" :message="form.errors.purpose_id"/>
                    <Multiselect 
                    :options="dropdowns.purposes" 
                    v-model="form.purpose_id"
                    @input="handleInput('purpose_id')"
                    label="name"
                    placeholder="Select Purpose"/>
                </BCol>
                <BCol lg="12" class="mt-0">
                    <hr class="text-muted"/>
                </BCol>
                <BCol :lg="(selected.status.name == 'For Payment') ? 6 : 12" class="mt-n2">
                    <InputLabel for="due" value="Requested Date" :message="form.errors.created_at"/>
                    <TextInput v-model="form.created_at" type="date" class="form-control" @input="handleInput('created_at')" :light="true"/>
                </BCol>
                <BCol v-if="selected.status.name == 'For Payment'" lg="6" class="mt-n2">
                    <InputLabel for="due" value="Report Due" :message="form.errors.due_at"/>
                    <TextInput v-model="form.due_at" type="date" class="form-control" @input="handleInput('due_at')" :light="true"/>
                </BCol>
                <BCol lg="12" class="mt-0 mb-n2">
                    <hr class="text-muted"/>
                </BCol>
                <BCol lg="8" class="fs-12 mt-1">Is TSR classified as a referral?</BCol>
                <BCol lg="4" class="mt-1">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="custom-control custom-radio mb-0">
                                <input type="radio" id="er1" class="custom-control-input me-2" :value="true" v-model="form.is_referral">
                                <label class="custom-control-label fw-normal fs-12" for="er1">Yes</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="custom-control custom-radio mb-0">
                                <input type="radio" id="er2" class="custom-control-input me-2" :value="false" v-model="form.is_referral">
                                <label class="custom-control-label fw-normal fs-12" for="er2">No</label>
                            </div>
                        </div>
                    </div>
                </BCol>
                <BCol lg="12" class="mt-n1">
                    <hr class="text-muted"/>
                </BCol>
                <BCol :lg="(form.agency_id == form.my_agency) ? 6 : 12" class="mt-n2 mb-1" v-if="form.is_referral">
                    <InputLabel for="region" value="Agency" :message="form.errors.agency_id"/>
                    <Multiselect
                    @input="handleInput('agency_id')"
                    :options="dropdowns.agencies"
                    v-model="form.agency_id"
                    :searchable="true" label="name"
                    placeholder="Select Agency"/>
                </BCol>
                <BCol lg="6" class="mt-n2 mb-1" v-if="form.is_referral && form.my_agency == form.agency_id">
                    <InputLabel for="province" value="Province" :message="form.errors.province_code"/>
                    <Multiselect
                    @input="handleInput('province_code')"
                    :options="provinces"
                    v-model="form.province_code"
                    :searchable="true" label="name"
                    placeholder="Select Province"/>
                </BCol>
            </div>
            </form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
            <b-button @click="submit('ok')" variant="primary" :disabled="form.processing" block>Update</b-button>
        </template>
    </b-modal>
    <Add @selected="set" ref="conforme"/>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
import Add from './Add.vue';
import Multiselect from "@vueform/multiselect";
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    props: ['dropdowns','region'],
    components: { InputLabel, TextInput, Multiselect, Add },
    data(){
        return {
            currentUrl: window.location.origin,
            selected: null,
            provinces: [],
            form: useForm({
                id: null,
                release_id: null,
                purpose_id: null,
                discount_id: null,
                conforme: null,
                due_at: null,
                created_at: null,
                customer: null,
                laboratory_id: null,
                is_referral: null,
                agency_id: null,
                province_code: null,
                my_agency: this.$page.props.user.data.agency,
                option: 'Update'
            }),
            customers: [],
            showModal: false
        }
    },
    watch: {
        "form.is_referral"(newVal){
            if(!newVal){
                this.form.agency_id = null;
                this.form.province_code = null;
            }
        },
        "form.agency_id"(newVal){
            if(newVal == this.form.my_agency){
                this.fetchProvince(this.region);
            }else{
                this.form.province_code = null;
            }
        }
    },
    methods: {
        show(data){
            this.selected = data;
            this.form.id = data.id;
            this.form.customer = {
                value: this.selected.customer.id,
                name: this.selected.customer.name,
                conformes: this.selected.customer.conformes
            };
            this.form.conforme = {
                value: this.selected.conforme_id,
                name: this.selected.conforme,
                contact_no: this.selected.conforme_no
            };
            // this.form.due_at = (this.selected.due_at) ? this.convertToISO(this.selected.due_at) : null;
            this.form.created_at = this.formatToDateInput(this.selected.created_at);
            this.form.due_at = this.formatToDateInput(this.selected.due_at);
            this.form.purpose_id = (data.purpose) ? data.purpose.id : null;
            this.form.release_id = (data.mode) ? data.mode.id : null;
            this.form.discount_id = data.payment.discount_id;
            this.form.laboratory_id = this.selected.laboratory.id;
            this.form.is_referral = data.is_referral;
            if(data.referral){
                this.form.agency_id = data.referral.agency.id;
                if(this.form.agency_id == this.form.my_agency){
                    this.fetchProvince(this.region);
                    this.form.province_code = (data.referral.province) ? data.referral.province.code : null;
                }else{
                    this.form.province_code = null;
                }
            }else{
                this.form.agency_id = null;
                this.form.province_code = null;
            }
            this.showModal = true;
        },
        fetchProvince(code){
            axios.get('/search',{
                params: {
                    option: 'provinces',
                    code: code
                }
            })
            .then(response => {
                this.provinces = response.data;
            })
            .catch(err => console.log(err));
        },
        formatToDateInput(str) {
            const parts = new Date(str).toLocaleDateString('en-CA'); 
            return parts; // en-CA always returns YYYY-MM-DD in local timezone
        },
        submit(){
            this.form.put('/tsrs/update',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('update',this.$page.props.flash.data.data);
                    this.hide();
                },
            });
        },
        fetchCustomer(code){
            axios.get('/customers',{
                params: {
                    option: 'pick',
                    keyword: code
                }
            })
            .then(response => {
                this.customers = response.data;
            })
            .catch(err => console.log(err));
        },
        openAdd(){
            this.$refs.conforme.show(this.form.customer);
        },
        convertToISO(dateString) {
            const date = new Date(dateString);
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            console.log(`${year}-${month}-${day}`);

            return `${year}-${day}-${month}`;
        },
        set(data){
            this.form.customer.conformes.push(data);
            this.form.conforme = data;
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