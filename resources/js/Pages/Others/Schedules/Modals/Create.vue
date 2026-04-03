<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 550px;" header-class="p-3 bg-light" :title="(!editable) ? 'Create Schedule' : 'Edit Schedule'" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow class="g-3 mt-1">
                <BCol lg="12" class="mt-1">
                    <InputLabel for="role" value="Event" :message="form.errors.event"/>
                    <Multiselect
                    v-model="form.event" :groups="true"
                    :options="events"
                    label="name"
                    object
                    @input="handleInput('event_id')"
                    ref="multiselect2"
                    placeholder="Select Event"/>
                    <hr v-if="form.event" class="text-muted"/>
                </BCol>
                <BCol lg="12" class="mt-n2 mb-n1" v-if="form.event?.fields.title">
                    <InputLabel for="name" value="Title" :message="form.errors.event"/>
                    <TextInput id="name" v-model="form.title" type="text" class="form-control" placeholder="Please enter title" @input="handleInput('name')" :light="true"/>
                </BCol>
                <BCol lg="12" class="mt-n1 mb-0" v-if="form.event?.fields.customer">
                    <InputLabel for="customer" value="Customer" :message="form.errors.customer"/>
                    <Multiselect 
                    :options="customers" 
                    @search-change="checkSearchCustomer"
                    v-model="form.customer" 
                    object label="name"
                    :searchable="true" 
                    @input="handleInput('customer')"
                    placeholder="Select Customer"/>
                </BCol>
                <BCol lg="12" class="mt-1 mb-0" v-if="form.event?.fields.conforme && form.customer">
                    <InputLabel for="conforme" value="Conforme" :message="form.errors.customer"/>
                    <Multiselect 
                    :options="form.customer?.conformes" 
                    v-model="form.conforme" 
                    label="name"
                    object
                    @input="handleInput('conforme')"
                    :searchable="true" 
                    placeholder="Select Conforme"/>
                </BCol>
                 <BCol lg="12" class="mt-1 mb-0" v-if="form.event?.fields.tsr">
                    <InputLabel for="conforme" value="TSR Number" :message="form.errors.tsr_id"/>
                    <Multiselect 
                    :options="tsrs" 
                    v-model="form.tsr_id" 
                    label="name"
                    object
                    @input="handleInput('tsr_id')"
                    :searchable="true" 
                    placeholder="Select TSR"/>
                </BCol>
                <BCol lg="12" class="mt-1 mb-n1" v-if="form.event?.fields.samples">
                    <InputLabel for="name" value="Samples" :message="form.errors.event"/>
                    <TextInput id="name" v-model="form.samples" type="text" class="form-control" placeholder="Please enter no. of samples" @input="handleInput('samples')" :light="true"/>
                </BCol>
                <BCol lg="12" class="mt-1 mb-n1" v-if="form.event?.fields.venue">
                    <InputLabel for="name" value="Venue" :message="form.errors.venue"/>
                    <TextInput id="name" v-model="form.venue" type="text" class="form-control" placeholder="Please enter venue" @input="handleInput('venue')" :light="true"/>
                </BCol>
                <BCol lg="12" class="mt-1 mb-0" v-if="form.event?.fields.info">
                    <InputLabel for="attribute" value="Information" :message="form.errors.information"/>
                    <textarea id="attribute" v-model="form.information" maxlength="250" rows="2" type="text" class="form-control" placeholder="Please enter information" style="background-color: #f5f6f7;"/>
                </BCol>
               
                <BCol lg="12"><hr class="text-muted mt-0 mb-n3"/></BCol>
                <BCol lg="8" style="margin-top: 10px; margin-bottom: -15px;" class="fs-12">Is the event all day?</BCol>
                <BCol lg="4" style="margin-top: 10px; margin-bottom: -20px;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="custom-control custom-radio mb-3">
                                <input type="radio" id="customRadio1" class="custom-control-input me-2" :value="true" v-model="form.is_allday">
                                <label class="custom-control-label fw-normal fs-12" for="customRadio1">Yes</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="custom-control custom-radio mb-3">
                                <input type="radio" id="customRadio2" class="custom-control-input me-2" :value="false" v-model="form.is_allday">
                                <label class="custom-control-label fw-normal fs-12" for="customRadio2">No</label>
                            </div>
                        </div>
                    </div>
                </BCol>
                <BCol lg="12"><hr class="text-muted mt-n1 mb-n3"/></BCol>
                <BCol lg="12" v-if="form.is_allday" class="mt-2 mb-n2"> 
                    <!-- <label>Date <span v-if="form.errors.date" class="text-danger" style="font-size: 9px;">({{ form.errors.date }})</span></label> -->
                    <div class="input-group">
                        <flat-pickr ref="datepicker" 
                        placeholder="Select date" 
                        v-model="form.date" 
                        :config="config"
                        class="form-control flatpickr-input" id="calendar">
                        </flat-pickr>
                    </div>
                </BCol>
                <BCol v-if="form.is_allday != null && form.is_allday == false"  lg="12" class="mt-2 mb-n2">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <!-- <label>Start Date</label> -->
                            <flat-pickr ref="datepicker" 
                                placeholder="Select start date & time" 
                                v-model="form.start" 
                                :config="timeConfig"
                                class="form-control flatpickr-input" id="caledate">
                            </flat-pickr>
                        </div>
                        <div class="col-md-6">
                            <!-- <label>End Date</label> -->
                            <flat-pickr ref="datepicker" 
                                placeholder="Select end date & time" 
                                v-model="form.end" 
                                :config="timeConfig"
                                class="form-control flatpickr-input" id="caledate">
                            </flat-pickr>
                        </div>
                    </div>
                </BCol>
                <BCol v-if="form.event?.fields.employees" lg="12"><hr class="text-muted mt-0 mb-n3"/></BCol>
                <BCol v-if="form.event?.fields.employees" lg="8" style="margin-top: 10px; margin-bottom: -15px;" class="fs-12">Is for all employees?</BCol>
                <BCol v-if="form.event?.fields.employees" lg="4" style="margin-top: 10px; margin-bottom: -20px;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="custom-control custom-radio mb-3">
                                <input type="radio" id="customRadio1" class="custom-control-input me-2" :value="true" v-model="form.is_forall">
                                <label class="custom-control-label fw-normal fs-12" for="customRadio1">Yes</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="custom-control custom-radio mb-3">
                                <input type="radio" id="customRadio2" class="custom-control-input me-2" :value="false" v-model="form.is_forall">
                                <label class="custom-control-label fw-normal fs-12" for="customRadio2">No</label>
                            </div>
                        </div>
                    </div>
                </BCol>
                <BCol lg="12" v-if="form.event?.fields.employees"><hr class="text-muted mt-n1 mb-n3"/></BCol>
                <BCol lg="12" class="mt-2" v-if="form.event?.fields.employees">
                     <Multiselect 
                    :options="tsrs" 
                    v-model="form.tsr_id" 
                    label="name"
                    object
                    @input="handleInput('tsr_id')"
                    :searchable="true" 
                    placeholder="Select TSR"/>
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
import flatPickr from "vue-flatpickr-component";
import { useForm } from '@inertiajs/vue3';
import Multiselect from "@vueform/multiselect";
import "@vueform/multiselect/themes/default.css";
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    props: ['events'],
    components: { InputLabel, TextInput, Multiselect, flatPickr },
    data(){
        return {
            currentUrl: window.location.origin,
            employees: [],
            customers: [],
            form: useForm({
                id: null,
                event: null,
                title: null,
                date: null,
                start: null,
                end: null,
                information: null,
                venue: null,
                is_allday: false,
                is_forall: false,
                type: null,
                samples: null,
                tsr_id: null,
                customer: null,
                conforme: null,
                users: []
            }),
            timeConfig: {
                enableTime: true,
                altInput: true,
                dateFormat: "Y-m-d H:i:S",
                altFormat: "M d, Y H:i",
            },
            config: {
                enableTime: false,
                altInput: true,
                dateFormat: "Y-m-d H:i:S",
                altFormat: "M d, Y",
                mode: "range"
            },
            selected: null,
            showModal: false,
            isLoading: false,
            editable: false
        }
    },
    methods: { 
        show(){
            this.showModal = true;
        },
        toggleDateFormat() {
            this.config = {
                ...this.config,
               enableTime: false
            };
        },
        submit(){
            this.form.post('/schedules',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.form.reset();
                    this.$emit('message',true);
                    this.hide();
                },
            });
        },
        checkSearchStr: _.debounce(function(string) {
            (string) ? this.searchUser(string) : '';
        }, 300),
        searchUser(string){
            if (!string || string.trim() === '') {
                this.employees = [];
                return;
            }
            axios.get('/search',{
                params: {
                    option: 'users',
                    keyword: string
                }
            })
            .then(response => {
                this.employees = response.data;
            })
            .catch(err => console.log(err));
        }, 
        checkSearchCustomer: _.debounce(function(string) {
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
        handleInput(field) {
            this.form.errors[field] = false;
        },
        hide(){
            this.form.reset();
            this.form.clearErrors();
            this.editable = false;
            this.showModal = false;
        }
    }
}
</script>