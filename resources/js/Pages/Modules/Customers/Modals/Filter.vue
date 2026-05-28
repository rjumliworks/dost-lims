<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 550px;" header-class="p-3 bg-light" title="Filter Address" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow>
                <BCol lg="12">
                    <BRow class="g-3 mt-2">
                        <BCol lg="6" class="mt-1">
                            <InputLabel value="Region"/>
                            <Multiselect :options="regions" v-model="form.region" label="name" :searchable="true" placeholder="Select Region" />
                        </BCol>
                        <BCol lg="6" class="mt-1">
                            <InputLabel value="Province"/>
                            <Multiselect :options="provinces" object v-model="form.province" label="name" :searchable="true" placeholder="Select Province" />
                        </BCol>
                        <BCol lg="6" class="mt-1">
                            <InputLabel value="Municipality" :message="form.errors.municipality_code"/>
                            <Multiselect :options="municipalities" object v-model="form.municipality" label="name" :searchable="true" placeholder="Select Municipality" />
                        </BCol>
                        <BCol lg="6" class="mt-1">
                            <InputLabel value="Barangay" :message="form.errors.municipality_code"/>
                            <Multiselect :options="barangays" object v-model="form.barangay" label="name" :searchable="true" placeholder="Select Barangay" />
                        </BCol>
                    </BRow>  
                </BCol>
            </BRow>
        </form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <!-- <b-button @click="submitExcel('ok')" variant="success" block>Excel</b-button> -->
            <b-button @click="submit('ok')" variant="primary" :disabled="form.processing" block>Filter</b-button>
            <!-- || !isFormValid -->
        </template>
    </b-modal>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
import Multiselect from "@vueform/multiselect";
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    components: {InputLabel, TextInput, Multiselect },
    props: ['regions','region'],
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                region: null,
                province: null,
                municipality: null,
                barangay: null
            }),
            provinces: [],
            municipalities: [],
            barangays: [],
            index: null,
            showModal: false,
            editable: false,
            selected: null,
        }
    },
    watch: {
        "form.region"(newVal){
            if(!newVal){
                this.form.province = null;
                this.form.municipality = null;
                this.form.barangay = null;
            }
            this.fetchProvince(newVal);
        },
        "form.province"(newVal){
            if(!newVal){
                this.form.municipality = null;
                this.form.barangay = null;
            }
            this.fetchMunicipality(newVal);
        },
        "form.municipality"(newVal){
            if(!newVal){
                this.form.barangay = null;
            }
            this.fetchBarangay(newVal);
        }
    },
    // computed: {
    //     isFormValid() {
    //         return this.form.region && this.form.province && this.form.municipality && this.form.barangay;
    //     }
    // },
    methods: { 
        show(){
            this.form.region = this.region;
            this.fetchProvince(this.region);
            this.showModal = true;
        },  
        submitExcel() {
            const params = new URLSearchParams();

            params.append('option', 'peza');

            if (this.form.region) {
                params.append('region', this.form.region);
            }
            if (this.form.province?.value) {
                params.append('province', this.form.province?.value);
            }
            if (this.form.municipality?.value) {
                params.append('municipality', this.form.municipality?.value);
            }
            if (this.form.barangay?.value) {
                params.append('barangay', this.form.barangay?.value);
            }

            const url = `/reports?${params.toString()}`;
            window.open(url);
        },
        submit(){
            this.$emit('submit', {
                index: this.index,
                form: {
                    info: this.form.address,
                    region: this.form.region,
                    province: this.form.province,
                    municipality: this.form.municipality,
                    barangay: this.form.barangay,
                    longitude: this.form.longitude,
                    latitude: this.form.latitude,
                }
            });

            this.form.region = null;
            this.form.province = null;
            this.form.municipality = null;
            this.form.barangay = null;
            this.form.address = null;
            this.hide();
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
        fetchMunicipality(code){
            axios.get('/search',{
                params: {
                    option: 'municipalities',
                    code: code
                }
            })
            .then(response => {
                this.municipalities = response.data;
            })
            .catch(err => console.log(err));
        },
        fetchBarangay(code){
            axios.get('/search',{
                params: {
                    option: 'barangays',
                    code: code
                }
            })
            .then(response => {
                this.barangays = response.data;
            })
            .catch(err => console.log(err));
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