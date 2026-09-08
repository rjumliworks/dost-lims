<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 550px;" header-class="p-3 bg-light" title="Add Supplier" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow class="g-3 mt-0">
                <BCol lg="12" class="mt-1 mb-n2">
                    <InputLabel for="name" value="Name" :message="form.errors.name"/>
                    <TextInput id="name" v-model="form.name" type="text" class="form-control" placeholder="Please enter supplier name" @input="handleInput('name')" :light="true"/>
                </BCol>
                <BCol lg="6" class="mt-1 mb-n2">
                    <InputLabel for="email" value="Email" :message="form.errors.email"/>
                    <TextInput id="email" v-model="form.email" type="email" class="form-control" placeholder="Please enter email" @input="handleInput('email')" :light="true"/>
                </BCol>
                <BCol lg="6" class="mt-1 mb-n2">
                    <InputLabel for="contact_no" value="Contact no." :message="form.errors.contact_no"/>
                    <TextInput id="contact_no" v-model="form.contact_no" type="text" class="form-control" placeholder="Please enter contact no." @input="handleInput('contact_no')" :light="true"/>
                </BCol>
                <BCol lg="12"><hr class="text-muted mt-1 mb-0"/></BCol>
                <BCol lg="6" class="mt-2 mb-n2">
                    <InputLabel for="region_code" value="Region" :message="form.errors.region_code"/>
                    <Multiselect :options="dropdowns.regions" label="name" :searchable="true" v-model="form.region_code" placeholder="Select Region"/>
                </BCol>
                <BCol lg="6" class="mt-2 mb-n2">
                    <InputLabel for="province_code" value="Province" :message="form.errors.province_code"/>
                    <Multiselect :options="provinces" label="name" :searchable="true" v-model="form.province_code" placeholder="Select Province"/>
                </BCol>
                <BCol lg="6" class="mt-2 mb-n2">
                    <InputLabel for="municipality_code" value="Municipality" :message="form.errors.municipality_code"/>
                    <Multiselect :options="municipalities" label="name" :searchable="true" v-model="form.municipality_code" placeholder="Select Municipality"/>
                </BCol>
                <BCol lg="6" class="mt-2 mb-n2">
                    <InputLabel for="barangay_code" value="Barangay" :message="form.errors.barangay_code"/>
                    <Multiselect :options="barangays" label="name" :searchable="true" v-model="form.barangay_code" placeholder="Select Barangay"/>
                </BCol>
                <BCol lg="12" class="mt-2 mb-1">
                    <InputLabel for="address" value="Street, Landmark, Block, Lot, Unit" :message="form.errors.address"/>
                    <TextInput id="address" v-model="form.address" type="text" class="form-control" placeholder="Please enter address" @input="handleInput('address')" :light="true"/>
                </BCol>
            </BRow>
        </form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="submit()" variant="primary" :disabled="form.processing" block>Submit</b-button>
        </template>
    </b-modal>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
import Multiselect from '@/Shared/Components/Forms/Multiselect.vue';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    components: { InputLabel, TextInput, Multiselect },
    props: ['dropdowns'],
    data(){
        return {
            form: useForm({
                name: null,
                email: null,
                contact_no: null,
                address: null,
                region_code: null,
                province_code: null,
                municipality_code: null,
                barangay_code: null,
                option: 'supplier'
            }),
            provinces: [],
            municipalities: [],
            barangays: [],
            showModal: false
        }
    },
    watch: {
        "form.region_code"(newVal){
            if(!newVal){
                this.form.province_code = null;
                this.form.municipality_code = null;
                this.form.barangay_code = null;
            }
            this.fetchProvince(newVal);
        },
        "form.province_code"(newVal){
            if(!newVal){
                this.form.municipality_code = null;
                this.form.barangay_code = null;
            }
            this.fetchMunicipality(newVal);
        },
        "form.municipality_code"(newVal){
            if(!newVal){
                this.form.barangay_code = null;
            }
            this.fetchBarangay(newVal);
        }
    },
    methods: {
        show(){
            this.form.reset();
            this.form.clearErrors();
            this.provinces = [];
            this.municipalities = [];
            this.barangays = [];
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
        submit(){
            this.form.post('/inventory',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('message', this.$page.props.flash.data);
                    this.hide();
                },
            });
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        hide(){
            this.form.reset();
            this.form.clearErrors();
            this.showModal = false;
        }
    }
}
</script>
