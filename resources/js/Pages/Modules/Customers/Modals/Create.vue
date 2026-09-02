<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 800px;" header-class="p-3 bg-light" :title="(!editable) ? 'Create Customer' : 'Edit Customer'" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <BRow>
            <BCol lg="12" class="mt-1 mb-n3">
                <template v-if="!customerType">
                    <div class="card bg-light-subtle border-1 rounded shadow-none p-4 text-center mb-0">
                        <p class="fs-13 text-muted mb-3">Is this customer an individual or a firm/company?</p>
                        <div class="d-flex justify-content-center gap-2">
                            <b-button @click="selectType('individual')" variant="outline-primary" class="px-4 py-3">
                                <i class="ri-user-fill fs-20 d-block mb-1"></i> Individual
                            </b-button>
                            <b-button @click="selectType('firm')" variant="outline-primary" class="px-4 py-3">
                                <i class="ri-building-fill fs-20 d-block mb-1"></i> Firm / Company
                            </b-button>
                        </div>
                    </div>
                </template>
                <template v-else>
                    <div class="d-flex justify-content-end mb-1">
                        <b-link @click="changeType" class="fs-11 text-muted">
                            <i class="ri-arrow-go-back-line align-bottom me-1"></i>Change customer type
                        </b-link>
                    </div>
                    <div class="card bg-light-subtle border-1 rounded-bottom shadow-none mb-3 p-3">
                        <form class="customform">
                            <BRow>
                                <template v-if="customerType === 'firm'">
                                    <BCol lg="12" class="mt-1">
                                        <Search @set="chooseName" @new="setName" :names="names" :classification-id="8" @search="checkSearchStr" ref="search" :class="(!form.customer) ? 'mb-n3' : ''"/>
                                        <div v-if="form.customer" class="mb-n2 mt-n3">
                                            <div v-if="(typeof form.customer === 'string')" class="alert alert-success mt-2 p-2 fs-12" role="alert">
                                                The inputted customer name is new. Please double-check the spelling.
                                            </div>
                                            <div v-else-if="typeof form.customer === 'object' && form.customer.classification == 8" class="alert alert-warning mt-2 p-2 fs-12" role="alert">
                                                The customer name already exists. This will add a branch for the customer name.
                                            </div>
                                            <div v-else class="alert alert-danger mt-2 p-2 fs-12" role="alert">
                                                 This customer already exists as an individual customer. Duplicate entries are not allowed.
                                            </div>
                                        </div>
                                    </BCol>
                                    <template v-if="typeof form.customer === 'string' || (typeof form.customer === 'object' && form.customer?.classification == 8)">
                                    <BCol lg="12">
                                        <BRow class="g-3">
                                            <BCol lg="12"><hr class="text-muted mb-0" :class="(form.customer) ? 'mt-1' : 'mt-3'"/></BCol>
                                            <BCol lg="8"  style="margin-top: 13px; margin-bottom: -12px;" class="fs-12" :class="(form.errors.has_branches) ? 'text-danger' : ''">Does the new customer represent a branch?</BCol>
                                            <BCol lg="4"  style="margin-top: 13px; margin-bottom: -12px;">
                                            <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="custom-control custom-radio mb-3">
                                                            <input type="radio" id="customRadio1" class="custom-control-input me-2" :value="true" v-model="form.has_branches" @input="handleInput('has_branches')">
                                                            <label class="custom-control-label fw-normal fs-12" for="customRadio1">Yes</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="custom-control custom-radio mb-3">
                                                            <input type="radio" id="customRadio2" class="custom-control-input me-2" :value="false" v-model="form.has_branches" @input="handleInput('has_branches')">
                                                            <label class="custom-control-label fw-normal fs-12" for="customRadio2">No</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </BCol>
                                            <BCol lg="12"><hr class="text-muted mt-n2" :class="(form.customer && form.has_branches) ? '' : 'mb-n3'"/></BCol>
                                        </BRow>
                                    </BCol>
                                    <BCol :lg="(typeof form.customer?.value === 'number') ? 6 : 12" v-if="form.has_branches" class="mt-n2 mb-0">
                                        <InputLabel for="name" value="Branch" :message="form.errors.name"/>
                                        <TextInput id="name" v-model="form.name" type="text" class="form-control" placeholder="Please enter name" @input="handleInput('name')" :light="false"/>
                                    </BCol>
                                    <BCol v-if="typeof form.customer?.value === 'number'" :lg="(form.sex_id == 71 || form.sex_id == 70) ? '3' : '6'" class="mt-n2 mb-1">
                                        <InputLabel for="sex_id" value="Sex" :message="form.errors.sex_id"/>
                                        <Multiselect :options="dropdowns.sexs" label="name" :searchable="true" v-model="form.sex_id" placeholder="Select Sex" @input="handleInput('sex_id')" />
                                    </BCol>
                                    <BCol v-if="typeof form.customer?.value === 'number' &&  form.sex_id == 71 && form.customer.classification != 9" lg="3" class="mt-n2 mb-1">
                                        <InputLabel for="led_id" value="Type" :message="form.errors.led_id"/>
                                        <Multiselect :options="dropdowns.females" label="name" v-model="form.led_id" placeholder="Select Type" @input="handleInput('led')" />
                                    </BCol>
                                    <BCol v-if="typeof form.customer?.value === 'number' &&  form.sex_id == 70 && form.customer.classification != 9" lg="3" class="mt-n2 mb-1">
                                        <InputLabel for="led_id" value="Type" :message="form.errors.led_id"/>
                                        <Multiselect :options="dropdowns.males" label="name" v-model="form.led_id" placeholder="Select Type" @input="handleInput('led')" />
                                    </BCol>
                                    </template>
                                </template>
                                <template v-else-if="customerType === 'individual'">
                                    <BCol lg="4" class="mt-1">
                                        <InputLabel for="firstname" value="First name" :message="form.errors.firstname"/>
                                        <TextInput id="firstname" v-model="form.firstname" type="text" class="form-control" placeholder="Please enter first name" @input="form.firstname = capitalizeWords(form.firstname); handleInput('firstname'); syncIndividualName()" :light="false"/>
                                    </BCol>
                                    <BCol lg="4" class="mt-1">
                                        <InputLabel for="middlename" value="Middle name" :message="form.errors.middlename"/>
                                        <TextInput id="middlename" v-model="form.middlename" type="text" class="form-control" placeholder="Please enter middle name" @input="form.middlename = capitalizeWords(form.middlename); handleInput('middlename'); syncIndividualName()" :light="false"/>
                                    </BCol>
                                    <BCol lg="4" class="mt-1">
                                        <InputLabel for="lastname" value="Last name" :message="form.errors.lastname"/>
                                        <TextInput id="lastname" v-model="form.lastname" type="text" class="form-control" placeholder="Please enter last name" @input="form.lastname = capitalizeWords(form.lastname); handleInput('lastname'); syncIndividualName()" :light="false"/>
                                    </BCol>
                                    <BCol lg="12" class="mt-2 mb-n2" v-if="form.firstname && form.lastname">
                                        <div v-if="individualDuplicate === true" class="alert alert-danger mt-2 p-2 fs-12" role="alert">
                                            This customer already exists as an individual customer. Duplicate entries are not allowed.
                                        </div>
                                        <div v-else-if="individualDuplicate === false" class="alert alert-success mt-2 p-2 fs-12" role="alert">
                                            No duplicate found. This appears to be a new customer.
                                        </div>
                                    </BCol>
                                </template>
                            </BRow>
                        </form>
                    </div>

                    <div class="card bg-light-subtle border-1 rounded-bottom shadow-none mt-3 p-3" v-if="typeof form.customer?.value != 'number' && form.customer">
                        <form class="customform">
                            <BRow>
                                <BCol v-if="form.classification_id != 9" :lg="(form.sex_id == 71 || form.sex_id == 70) ? '3' : '6'" class="mt-0 mb-1">
                                    <InputLabel for="sex_id" value="Sex" :message="form.errors.sex_id"/>
                                    <Multiselect :options="dropdowns.sexs" label="name" :searchable="true" v-model="form.sex_id" placeholder="Select Sex" @input="handleInput('sex_id')" />
                                </BCol>
                                <BCol v-if="form.classification_id == 9" lg="3" class="mt-0 mb-1">
                                    <InputLabel for="sex_id" value="Sex" :message="form.errors.sex_id"/>
                                    <Multiselect :options="dropdowns.sexs" label="name" v-model="form.sex_id" placeholder="Select Sex" @input="handleInput('sex_id')" />
                                </BCol>
                                <BCol lg="6" v-if="form.classification_id == 9" class="mt-0 mb-1">
                                    <InputLabel for="type_id" value="Type" :message="form.errors.type_id"/>
                                    <Multiselect :options="dropdowns.individuals" label="name" v-model="form.type_id" placeholder="Select Type" @input="handleInput('type_id')"/>
                                </BCol>
                                <BCol v-if="form.sex_id == 71 && form.classification_id != 9" lg="3" class="mt-0 mb-1">
                                    <InputLabel for="led_id" value="Type" :message="form.errors.led_id"/>
                                    <Multiselect :options="dropdowns.females" label="name" v-model="form.led_id" placeholder="Select Type" @input="handleInput('led')" />
                                </BCol>
                                <BCol v-if="form.sex_id == 70 && form.classification_id != 9" lg="3" class="mt-0 mb-1">
                                    <InputLabel for="led_id" value="Type" :message="form.errors.led_id"/>
                                    <Multiselect :options="dropdowns.males" label="name" v-model="form.led_id" placeholder="Select Type" @input="handleInput('led')" />
                                </BCol>
                                <BCol v-if="form.classification_id != 9" :lg="(subs.length > 0) ? '6' : '12'" class="mt-0 mb-1">
                                    <InputLabel for="industry_id" value="Industry Type" :message="form.errors.industry_id"/>
                                    <Multiselect :options="industries" :searchable="true" label="name" object v-model="industry" placeholder="Select Industry" @input="handleInput('industry')" />
                                </BCol>
                                <BCol lg="6" class="mt-0 mb-1" v-if="subs.length > 0">
                                    <InputLabel for="industry_id" value="Industry Subtype" :message="form.errors.industry_id"/>
                                    <Multiselect :options="subs" :searchable="true" label="name" v-model="form.industry_id" placeholder="Select Industry" @input="handleInput('industry_id')" />
                                </BCol>
                            </BRow>
                        </form>
                    </div>

                    <div v-if="form.customer && form.customer?.classification != 9" class="card bg-light-subtle border-1 rounded-bottom shadow-none mb-3 p-3" :class="(typeof form.customer?.value === 'number') ? 'mt-3' : 'mt-n2'">
                        <form class="customform">
                            <BRow>
                                <BCol lg="12" class="mt-0 mb-n1">
                                    <div class="d-flex">
                                        <div style="width: 100%;">
                                            <InputLabel value="Address" :message="form.errors.address"/>
                                            <TextInput readonly v-model="address" type="text" class="form-control" placeholder="Please enter address" @input="handleInput('address')"/>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <b-button @click="addLocation(index)" style="margin-top: 20px;" variant="light" class="waves-effect waves-light ms-1"><i class="ri-map-pin-fill"></i></b-button>
                                        </div>
                                    </div>
                                </BCol>
                                <BCol lg="6" class="mt-1 mb-0">
                                    <InputLabel for="email" value="Email" :message="form.errors.email"/>
                                    <TextInput id="email" v-model="form.email" type="email" class="form-control" placeholder="Please enter email" @input="handleInput('email')"/>
                                </BCol>
                                <BCol lg="6" class="mt-1 mb-0">
                                    <InputLabel for="contact_no" value="Mobile no." :message="form.errors.contact_no"/>
                                    <TextInput id="contact_no" v-model="form.contact_no" type="text" class="form-control" placeholder="Please enter contact" @input="handleInput('contact_no')"/>
                                </BCol>
                                <BCol lg="12" class="mt-2 mb-1" v-if="form.classification_id == 9">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="addToConforme" v-model="form.add_to_conforme">
                                        <label class="form-check-label fw-normal fs-11" for="addToConforme">
                                            Add this customer's name and contact to the Customer Confome list (for Individual Customers)
                                        </label>
                                    </div>
                                </BCol>
                            </BRow>
                        </form>
                    </div>
                </template>
            </BCol>
        </BRow>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button v-if="customerType" @click="submit('ok')" variant="primary" :disabled="!canSubmit" block>Submit</b-button>
        </template>
    </b-modal>
    <Confirm @confirm="confirmSubmit" ref="confirm"/>
    <Location :regions="dropdowns.regions" @submit="handleSubmit" ref="location"/>
</template>
<script>
import _ from 'lodash';
import { useForm } from '@inertiajs/vue3';
import Location from './Location.vue';
import Map from '../Components/Map.vue';
import Search from '../Components/Search.vue';
import Confirm from '../Modals/Confirm.vue';
import Multiselect from "@vueform/multiselect";
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    components: { InputLabel, TextInput, Multiselect, Map, Search, Location, Confirm },
    props: ['dropdowns','region'],
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                id: null,
                name: null,
                tin: null,
                email: null,
                is_main: false,
                contact_no: null,
                classification_id: null,
                sex_id: null,
                type_id: null,
                industry_id: null,
                has_branches: null,
                is_new: null,
                address: null,
                region_code: null,
                province_code: null,
                municipality_code: null,
                district_code: null,
                barangay_code: null,
                latitude: null,
                longitude: null,
                customer: null,
                name_id: null,
                led_id: null,
                firstname: null,
                middlename: null,
                lastname: null,
                add_to_conforme: false,
                option: 'validation'
            }),
            multiselectKey: 0,
            address: null,
            has_branch: false,
            names: [],
            industry: null,
            showModal: false,
            editable: false,
            subs: [],
            customerType: null,
            individualDuplicate: null
        }
    },
    watch: {
        'form.classification_id'(newVal){
            if(newVal == 9){
                this.industry = {
                    value: 107,
                    name: 'Individual'
                };
                this.form.industry_id = 107;
            }else{
                this.industry = null;
                this.form.industry = null;
            }
        },
        'form.customer'(){
            if(this.form.customer){
               if(typeof this.form.customer.value === 'number'){
                    this.form.has_branches = true;
                    this.form.name_id = this.form.customer.value;
                    this.form.classification_id = this.form.customer.classification;
                    this.form.industry_id = this.form.customer.industry;
                    this.form.type_id = this.form.customer.type_id;
                    if (this.$refs.search) this.$refs.search.set(this.form.customer.name);
               }else if(typeof this.form.customer === 'string' && this.customerType === 'firm'){
                    this.form.has_branches = null;
                    if (this.$refs.search) this.$refs.search.set(this.form.customer);
               }
            }else if(this.customerType === 'firm'){
                this.form.name_id = null;
                this.form.classification_id = null;
                this.form.industry_id = null;
                this.form.type_id = null;
                this.form.has_branches = false;
            }
        },
        'form.has_branches'(newVal){
            if(newVal === false){
                this.form.name = 'Main';
                this.form.is_main = true;
            }else if(newVal === true){
                this.form.name = null;
                this.form.is_main = false;
            }
        },
        'industry'(){
            if(this.industry){
                if(this.industry.is_alone == 1){
                    this.form.industry_id = this.industry.value;
                    this.subs = [];
                }else{
                    this.subs = this.dropdowns.industries.filter(industry => industry.industry_id == this.industry.value);
                }
            }else{
                this.subs = [];
            }
        }
    },
    computed: {
        industries() {
            return this.dropdowns.industries.filter(industry => industry.is_main == 1);
        },
        canSubmit() {
            if(this.form.processing) return false;
            if(this.customerType === 'individual' && this.individualDuplicate === true) return false;
            return true;
        }
    },
    methods: {
        show(){
            this.form.reset();
            this.names = [];
            this.customerType = null;
            this.individualDuplicate = null;
            this.showModal = true;
        },
        selectType(type){
            this.customerType = type;
            if(type === 'individual'){
                this.form.classification_id = 9;
                this.form.has_branches = false;
            }else{
                this.form.classification_id = 8;
            }
        },
        changeType(){
            this.customerType = null;
            this.form.customer = null;
            this.form.classification_id = null;
            this.form.firstname = null;
            this.form.middlename = null;
            this.form.lastname = null;
            this.form.has_branches = null;
            this.form.name = null;
            this.form.is_main = false;
            this.form.sex_id = null;
            this.form.led_id = null;
            this.form.type_id = null;
            this.individualDuplicate = null;
            this.names = [];
            if (this.$refs.search) this.$refs.search.clear();
        },
        capitalizeWords(str) {
            return str ? str.toLowerCase().replace(/\b\w/g, char => char.toUpperCase()) : '';
        },
        formatIndividualName(){
            const firstname = (this.form.firstname || '').trim();
            const middlename = (this.form.middlename || '').trim();
            const lastname = (this.form.lastname || '').trim();

            const parts = [];
            if (firstname) parts.push(firstname);
            if (middlename) parts.push(middlename[0].toUpperCase() + '.');
            if (lastname) parts.push(lastname);

            return parts.length ? parts.join(' ') : null;
        },
        syncIndividualName(){
            this.form.customer = this.formatIndividualName();
            this.checkIndividualDuplicate();
        },
        checkIndividualDuplicate: _.debounce(function() {
            if(!this.form.firstname || !this.form.lastname){
                this.individualDuplicate = null;
                return;
            }
            const fullName = this.form.customer;
            axios.get('/customers', {
                params: {
                    option: 'search',
                    keyword: fullName,
                    classification_id: 9
                }
            })
            .then(response => {
                const match = (response.data || []).some(item => (item.name || '').trim().toLowerCase() === fullName.trim().toLowerCase());
                this.individualDuplicate = match;
            })
            .catch(err => console.log(err));
        }, 400),
        checkSearchStr: _.debounce(function(string) {
            this.fetchCustomer(string);
        }, 300),
        fetchCustomer(code){
            axios.get('/customers',{
                params: {
                    option: 'search',
                    keyword: code
                }
            })
            .then(response => {
                this.names = response.data;
            })
            .catch(err => console.log(err));
        },
        submit(){
            this.form.option = 'validation';
            this.form.post('/customers',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$refs.confirm.show({
                        customer_name: (typeof this.form.customer === 'object' && this.form.customer) ? this.form.customer.name : this.form.customer,
                        branch_name: this.form.name,
                        address: this.address,
                        email: this.form.email,
                        contact_no: this.form.contact_no
                    });
                },
                onError: (errors) => {
                    console.log(errors); // backend validation errors
                }
            });
        },
        confirmSubmit(isNew) {
            this.form.is_new = isNew;
            this.form.option = 'customer';

            this.form.post('/customers', {
                preserveScroll: true,
                onSuccess: () => {
                    this.$emit('message', true);

                    this.$refs.location.emptyMap();
                    this.$refs.confirm.hide();

                    this.hide(); // ✅ central reset
                }
            });
        },
        chooseName(data){
            this.form.customer = data;
        },
        setName(name){
            this.form.customer = name;
        },
        addLocation(index){
            this.$refs.location.openEdit(this.region);
        },
        handleSubmit(data) {
            this.address = data.address;
            const index = data.index;

            if (index !== undefined) {
                this.form.address = data.form.info;
                this.form.region_code = data.form.region;
                this.form.province_code = data.form.province.value;
                this.form.municipality_code = data.form.municipality.value;
                this.form.barangay_code = data.form.barangay.value;
                this.form.district_code = (data.form.district) ? data.form.district.value : null;
                this.form.latitude = data.form.latitude;
                this.form.longitude = data.form.longitude;
            }
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        hide(){
            this.form.customer = null;
            this.address = null;
            this.industry = null;

            this.form.reset();
            this.form.clearErrors();

            this.form.email = null;
            this.form.contact_no = null;
            this.form.sex_id = null;
            this.form.led_id = null;
            this.form.type_id = null;
            this.form.firstname = null;
            this.form.middlename = null;
            this.form.lastname = null;
            this.form.add_to_conforme = false;

            this.form.name = 'Main';
            this.form.is_main = true;

            this.names = []; // clear search results
            this.customerType = null;
            this.individualDuplicate = null;

            // ✅ clear Search input safely
            if (this.$refs.search) {
                this.$refs.search.clear();
            }

            // ✅ force Search re-render (VERY important)
            this.multiselectKey++;

            this.editable = false;
            this.showModal = false;
        }
    }
}
</script>
