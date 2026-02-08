<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 700px;" header-class="p-3 bg-light" :title="(!editable) ? 'Create Technical Service' : 'Edit Technical Service'" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <BRow>
            <BCol lg="12" class="mt-1 mb-n3">
                <div class="card bg-light-subtle border-1 rounded-bottom shadow-none mb-0 p-3">
                    <form class="customform">
                        <BRow>
                            <BCol lg="12" class="mt-2 mb-1">
                                <!-- <InputLabel for="customer" value="Customer" :message="form.errors.customer"/> -->
                                <Multiselect 
                                :options="customers" 
                                @search-change="checkSearchStr"
                                v-model="form.customer" 
                                object label="name"
                                :searchable="true" 
                                @input="handleInput('customer')"
                                placeholder="Select Customer"/>
                            </BCol>
                            <BCol lg="12" v-if="form.customer">
                                <hr class="text-muted" style="margin-top: 10px; margin-bottom: 12px;"/>
                            </BCol>
                            <BCol lg="6" class="mt-n1" v-if="form.customer">
                                <i class="ri-mail-fill me-1"></i><InputLabel value="Email" :message="form.errors.email"/>
                                <TextInput v-model="form.email" type="text" class="form-control" placeholder="Please enter email"/>
                            </BCol>   
                            <BCol lg="6" class="mt-n1" v-if="form.customer">
                                <i class="ri-phone-fill me-1"></i><InputLabel value="Mobile Number" :message="form.errors.contact_no"/>
                                <TextInput v-model="form.contact_no" type="text" class="form-control" placeholder="Please enter contact"/>
                            </BCol> 
                            <BCol :lg="(form.conforme) ? 6 : 12" class="mt-0 mb-2" v-if="form.customer">
                                <div class="d-flex">
                                    <div style="width: 100%;">
                                        <i class="ri-user-2-fill me-1"></i><InputLabel for="conforme" value="Conforme" :message="form.errors.conforme"/>
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
                            <BCol lg="6" v-if="(form.conforme) ? true : false" class="mt-0">
                                <i class="ri-phone-fill me-1"></i><InputLabel for="due" value="Mobile Number" :message="form.errors.conforme"/>
                                <TextInput v-model="form.conforme.contact_no" type="text" class="form-control" placeholder="Please enter name" @input="handleInput('conforme')"/>
                            </BCol>
                        </BRow>
                    </form>
                </div>

                <div class="card bg-light-subtle border-1 rounded-bottom shadow-none mt-3 p-3">
                    <form class="customform">
                        <BRow>
                            <BCol lg="12" class="mt-n1">
                                <i class="ri-flask-fill me-1"></i><InputLabel for="region" value="Laboratory" :message="form.errors.laboratory_id"/>
                                <Multiselect 
                                :options="dropdowns.laboratories" 
                                v-model="form.laboratory" object
                                @input="handleInput('laboratory_id')"
                                :searchable="true" label="name"
                                placeholder="Select Laboratory"/>
                            </BCol>
                            <BCol lg="6" class="mt-1 mb-1">
                                <i class="ri-price-tag-3-fill me-1"></i><InputLabel for="region" value="Discount" :message="form.errors.discount_id"/>
                                <Multiselect 
                                :options="dropdowns.discounts" 
                                v-model="form.discount_id"
                                @input="handleInput('discount_id')"
                                :searchable="true" label="name"
                                placeholder="Select Discount"/>
                            </BCol>
                            <BCol lg="6" class="mt-1 mb-1">
                                <i class="ri-hand-coin-fill me-1"></i><InputLabel for="region" value="Purpose" :message="form.errors.purpose_id"/>
                                <Multiselect 
                                :options="dropdowns.purposes" 
                                v-model="form.purpose_id"
                                @input="handleInput('purpose_id')"
                                :searchable="true" label="name"
                                placeholder="Select Purpose"/>
                            </BCol>
                        </BRow>
                    </form>
                </div>

            </BCol>
        </BRow>
     
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="submit('ok')" variant="primary" :disabled="form.processing" block>Submit</b-button>
        </template>
    </b-modal>
    <Add @selected="set" ref="conforme"/>
    <Confirm @confirm="confirmSubmit" 
    :dropdowns="dropdowns" :errors="form.errors"
    :my_agency="$page.props.user.data.agency" 
    ref="confirm"/>
</template>
<script>
import _ from 'lodash';
import { useForm } from '@inertiajs/vue3';
import Add from './Add.vue';
import Confirm from './Confirm.vue';
import Multiselect from "@vueform/multiselect";
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    components: { Multiselect, InputLabel, TextInput, Add, Confirm },
    props: ['dropdowns','facility'],
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                id: null,
                customer: null,
                email: null,
                contact_no: null,
                conforme: null,
                laboratory: null,
                laboratory_id: null,
                purpose_id: null,
                discount_id: null,
                is_referral: null,
                is_onsite: null,
                agency_id: null,
                province_code: null,
                my_agency: this.$page.props.user.data.agency,
                created_at: null,
                option: 'tsr'
            }),
            customers: [],
            conformes: [],
            provinces: [],
            region: null,
            showModal: false,
            editable: false
        }
    },
    watch: {
        "form.is_referral"(newVal){
            if(!newVal){
                this.form.agency_id = null;
                this.form.province_code = null;
            }
        },
        "form.laboratory_id"(newVal){
            this.form.is_onsite = null;
            this.form.created_at = null;
        },
        "form.is_onsite"(newVal){
            this.form.created_at = null;
        },
         "form.customer"(newVal){
            if(newVal){
                this.form.email = newVal.email;
                this.form.contact_no = newVal.contact_no;
            }else{
                this.form.email = null;
                this.form.contact_no = null;
            }
        },
        "form.laboratory"(newVal){
            if(newVal){
                this.form.laboratory_id = newVal.value;
            }else{
                this.form.facility_id = null;
            }
        }
    },
    methods: { 
        show(region){
            this.region = region;
            this.fetchProvince(this.region);
            this.showModal = true;
        },
        submit(){
            this.form.option = 'validation';
            this.form.laboratory_id = (this.form.laboratory) ? this.form.laboratory.value : null;
            this.form.post('/tsrs',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$refs.confirm.show({
                        region: this.region,
                        customer_name: this.form.customer?.name,
                        email: this.form.email,
                        contact_no: this.form.contact_no
                    });
                },
                onError: (errors) => {
                    console.log(errors); // backend validation errors
                }
            });
        },
        confirmSubmit(isReferral,agency,province) {
            this.form.is_referral = isReferral;
            this.form.agency_id = agency;
            this.form.province_code = province;
            this.form.option = 'tsr';

            this.form.post('/tsrs', {
                preserveScroll: true,
                onSuccess: () => {
                    this.names = [];
                    this.$emit('success',this.$page.props.flash.data);
                    this.hide();
                    this.$refs.confirm.hide();
                }
            });
        },
        checkSearchStr: _.debounce(function(string) {
            this.fetchCustomer(string);
        }, 300),
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
        openAdd(){
            this.$refs.conforme.show(this.form.customer);
        },
        set(data){
            this.form.customer.conformes.push(data);
            this.form.conforme = data;
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