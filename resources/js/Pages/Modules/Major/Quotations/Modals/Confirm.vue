<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 600px;" header-class="p-3 bg-light" title="Confirm Technical Service Request" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="card bg-light-subtle border-1 rounded-bottom shadow-none mb-0 p-3">
            <form class="customform">
                <div class="row g-2 mt-0 mb-1">
                    <div class="col-sm-12">
                        <div class="p-0 border border-dashed bg-white rounded">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2">
                                    <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-user-2-fill"></i></div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-0 fs-11">Customer Name :</p>
                                    <h5 class="mb-0 fs-12">{{summary.customer_name}} <span v-if="summary.branch_name"> - {{ summary.branch_name }}</span></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-0 border border-dashed bg-white rounded">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2">
                                    <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-mail-fill"></i></div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-0 fs-11">Email :</p>
                                    <h5 class="mb-0 fs-12">{{ summary.email }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-0 border border-dashed bg-white rounded">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2">
                                    <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-phone-fill"></i></div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-0 fs-11">Contact no. :</p>
                                    <h5 class="mb-0 fs-12">{{ summary.contact_no }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- <div class="alert alert-warning alert-border-left alert-dismissible fade show material-shadow fs-11 mt-3 mb-3" role="alert">
            <span class="fs-10" style="line-height: 1.2; display: inline-block;"> <strong>Security Notice :</strong> This system is restricted to authorized government personnel only. Unauthorized access is prohibited.</span>
        </div> -->

        <div class="card bg-light-subtle border-1 rounded-bottom shadow-none mt-3 mb-0 p-3">
            <form class="customform">
                <div class="row g-2" :class="(!is_referral) ? 'mt-2 mb-3' : 'mt-2'">
                    <BCol lg="8" style="margin-top: 0px; margin-bottom: -12px;" class="fs-12">Is TSR classified as a referral?</BCol>
                    <BCol lg="4" style="margin-top: 0px; margin-bottom: -12px;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="custom-control custom-radio mb-0">
                                    <input type="radio" id="c1" class="custom-control-input me-2" :value="true" v-model="is_referral">
                                    <label class="custom-control-label fw-normal fs-12" for="c1">Yes</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="custom-control custom-radio mb-0">
                                    <input type="radio" id="c2" class="custom-control-input me-2" :value="false" v-model="is_referral">
                                    <label class="custom-control-label fw-normal fs-12" for="c2">No</label>
                                </div>
                            </div>
                        </div>
                    </BCol>
                    <BCol lg="12" v-if="is_referral">
                        <hr class="text-muted mb-n1"/>
                    </BCol>
                    <BCol :lg="(agency_id == my_agency ) ? 6 : 12" class="mt-2 mb-1" v-if="is_referral">
                        <InputLabel for="region" value="Agency" :message="errors.agency_id"/>
                        <Multiselect 
                        @input="handleInput('agency_id')"
                        :options="dropdowns.agencies" 
                        v-model="agency_id"
                        :searchable="true" label="name"
                        placeholder="Select Agency"/>
                    </BCol>
                    <BCol lg="6" class="mt-2 mb-1" v-if="is_referral && my_agency == agency_id">
                        <InputLabel for="province" value="Province" :message="errors.province_code"/>
                        <Multiselect 
                        @input="handleInput('province_code')"
                        :options="provinces" 
                        v-model="province_code"
                        :searchable="true" label="name"
                        placeholder="Select Province"/>
                    </BCol>
                </div>
            </form>
        </div>
    
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button v-if="is_referral != null" @click="submit('ok')" variant="primary" block>Submit</b-button>
        </template>
    </b-modal>
</template>
<script>
import _ from 'lodash';
import Multiselect from "@vueform/multiselect";
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    components: { InputLabel, TextInput, Multiselect },
    props: ['dropdowns','my_agency','errors'],
    data(){
        return {
            showModal: false,
            is_referral : null,
            agency_id: null,
            province_code: null,
            provinces: [],
            summary: {}
        }
    },
    methods: { 
        show(data){
            this.summary = data;
            this.is_referral = null;
            this.fetchProvince(data.region);
            this.showModal = true;
        },
        submit() {
            if (this.is_referral === null) {
                return;
            }
            this.$emit('confirm', this.is_referral, this.agency_id, this.province_code);
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
        handleInput(field) {
            this.errors[field] = false;
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>