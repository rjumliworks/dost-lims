<template>
    <b-modal v-if="selected" v-model="showModal" style="--vz-modal-width: 600px;" title="Referral Information" class="v-modal-custom"  header-class="p-3 bg-light" modal-class="zoomIn" centered no-close-on-backdrop>
       <div class="row g-2">
            <template v-if="!editable">
                <div class="col-md-12">
                    <div class="p-1 border border-dashed rounded">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm me-0">
                                <div class="avatar-title rounded bg-transparent text-primary fs-18"><i class="ri-government-line"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted fs-11 mb-0">Agency :</p>
                                <h5 class="fs-12 mb-0">{{(selected.agency) ? selected.agency.member.name : 'Not Available'}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-1 border border-dashed rounded">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm me-0">
                                <div class="avatar-title rounded bg-transparent text-primary fs-18"><i class="ri-map-pin-line"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted fs-11 mb-0">Province :</p>
                                <h5 class="fs-12 mb-0">{{(selected.province) ? selected.province.name : 'Not Available'}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-1 border border-dashed rounded">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm me-0">
                                <div class="avatar-title rounded bg-transparent text-primary fs-18"><i class="ri-calendar-2-line"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted fs-11 mb-0">Date :</p>
                                <h5 class="fs-12 mb-0">{{selected.created_at}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            <template v-else>
                <form class="customform">
                    <BCol lg="12" class="mt-2 mb-1">
                        <InputLabel for="region" value="Agency" :message="form.errors.agency_id"/>
                        <Multiselect 
                        @input="handleInput('agency_id')"
                        :options="agencies" 
                        v-model="form.agency_id"
                        :searchable="true" label="name"
                        placeholder="Select Agency"/>
                    </BCol>
                  
                    <BCol lg="12" class="mt-2 mb-1" v-if="form.my_agency == form.agency_id">
                        <InputLabel for="province" value="Province" :message="form.errors.province_code"/>
                        <Multiselect 
                        @input="handleInput('province_code')"
                        :options="provinces" 
                        v-model="form.province_code"
                        :searchable="true" label="name"
                        placeholder="Select Province"/>
                    </BCol>
                </form>
            </template>
       </div>
        <template v-slot:footer>
            <b-button v-if="!editable" @click="hide()" variant="light" block>Close</b-button>
            <b-button v-if="(status?.name == 'Pending' || status?.name == 'Ongoing') && !editable" @click="update()" variant="primary" block>Update</b-button>
            <b-button v-if="editable" @click="editable = false" variant="light" block>Cancel</b-button>
            <b-button v-if="editable" @click="save()" variant="primary" block>Save</b-button>
        </template>
    </b-modal>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
import Multiselect from "@vueform/multiselect";
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
export default {
    components: { InputLabel, Multiselect },
    props: ['region','agencies'],
    data(){
        return {
            currentUrl: window.location.origin,
            selected: {
                agency: { member: {}}, province: {}
            },
            provinces: [],
            province_code: null,
            agency_id: null,
            status: null,
            editable: false,
            showModal: false,
            form: useForm({
                id: null,
                agency_id: null,
                province_code: null,
                my_agency: this.$page.props.user.data.agency,
                option: 'referral'
            }),
        }
    },
    watch: {
        "form.agency_id"(newVal){
            if(newVal == this.form.my_agency){
                this.fetchProvince(this.region);
            }else{
                this.form.province_code = null;
            }
        }
    },
    methods: { 
        show(data,status){
            this.status = status;
            this.selected = data;
            this.showModal = true;
        },
        update(){
            console.log(this.selected);
            this.form.id = this.selected.id;
            this.form.agency_id = this.selected.agency.id;
            if(this.form.agency_id == this.form.my_agency){
                this.fetchProvince(this.region);
                this.form.province_code = this.selected.province.code;
            }else{
                this.form.province_code = null;
            }
            this.editable = true;
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
        save(){
            this.form.put('/tsrs/update',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.hide();
                },
            });
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        hide(){
            this.editable = false;
            this.showModal = false;
        }
    }
}
</script>