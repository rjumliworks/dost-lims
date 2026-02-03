<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 850px;" header-class="p-3 bg-light" :title="(!editable) ? 'Add Sampletype' : 'Edit Sampletype'" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow class="g-3 mt-3">
                <BCol lg="12" v-if="action == 'copy'" class="mt-0 mb-2">
                    <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow" role="alert"><i class="ri-error-warning-line label-icon"></i>
                        <div class="d-flex mb-n2">
                            <div class="flex-shrink-0 me-3">
                                <TextInput id="name" v-model="form.count" type="text" class="form-control" style="width: 45px; text-align: center;" :light="true"/>
                            </div>
                            <div class="flex-grow-1 mt-2"> 
                                <span>Please specify how many copies of the sample you want to add with its details.</span>
                            </div>
                        </div>
                    </div>
                </BCol>
                <BCol lg="12" v-if="action == 'copy'">
                    <hr class="text-muted mt-n3"/>
                </BCol>
                <BCol lg="6" class="mt-n3 mb-3">
                    <InputLabel for="testname" value="Category"/>
                    <Multiselect @search-change="checkCategory" 
                    :options="categories" label="name" :searchable="true" 
                    v-model="category" 
                    placeholder="Select Category" ref="multiselectC"/>
                </BCol>
                <BCol lg="6" class="mt-n3 mb-3">
                    <InputLabel for="sampletype" value="Sample Type" :message="form.errors.sampletype_id"/>
                    <Multiselect @search-change="checkType" 
                    @input="handleInput('sampletype_id')"
                    :options="types" label="name" :searchable="true" 
                    :clearOnSearch="true" object
                    v-model="sampletype" 
                    placeholder="Select Sample type" ref="multiselectT"/>
                </BCol>
                <BCol lg="6" class="mt-n2">
                    <InputLabel for="testname" value="Sample Name" :message="form.errors.samplename_id"/>
                    <Multiselect
                    :options="names" label="name" :searchable="true" 
                    v-model="form.samplename_id" 
                    placeholder="Select Sample name" ref="multiselectS"/>
                </BCol>
                <BCol lg="6" class="mt-n2">
                    <InputLabel for="name" value="Other Name (Optional)"/>
                    <TextInput id="name" v-model="form.name" type="text" class="form-control" placeholder="Please enter name"/>
                </BCol>
                <BCol lg="12">
                    <hr class="text-muted mt-0"/>
                </BCol>
                <BCol lg="6" class="mt-n1">
                    <InputLabel for="name" value="Description provided by customer"/>
                    <Textarea id="name" v-model="form.customer_description" class="form-control" rows="7" :class="{ 'is-invalid': form.errors.customer_description }" :light="true"/>
                </BCol>
                <BCol lg="6" class="mt-n1">
                    <InputLabel for="name" value="Description based on the sample submitted"/>
                    <Textarea id="name" v-model="form.description" class="form-control" rows="7" :class="{ 'is-invalid': form.errors.description }" :light="true"/>
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
import { useForm } from '@inertiajs/vue3';
import Multiselect from "@vueform/multiselect";
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
import Textarea from '@/Shared/Components/Forms/Textarea.vue';
export default {
    components: { InputLabel, TextInput, Textarea, Multiselect },
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                id: null,
                name: null,
                description: null,
                customer_description: null,
                samplename_id: null,
                sampletype_id: null,
                laboratory_id: null,
                tsr_id: null,
                count: 1,
            }),
            action: null,
            category: null,
            sampletype: null,
            categories: [],
            types: [],
            names: [],
            showModal: false,
            editable: false
        }
    },
    watch: {
        "sampletype"(newVal){
            if(newVal){
                this.form.sampletype_id = this.sampletype.value;
                this.names = this.sampletype.names;
            }else{
                this.form.sampletype_id = null;
                this.names = [];
            }
        }
    },
    methods: { 
        show(id, laboratory){
            this.editable = false;
            this.form.reset();
            this.categories = [];
            this.types = [];
            this.action = null;
            this.form.tsr_id = id;
            this.form.laboratory_id = laboratory;
            this.showModal = true;
        },
        checkCategory: _.debounce(function(string) {
            (string) ? this.fetchCategory(string) : '';
        }, 300),
        fetchCategory(code){
            axios.get('/categories',{
                params: {
                    option: 'category',
                    laboratory_id: this.form.laboratory_id,
                    keyword: code
                }
            })
            .then(response => {
                this.categories = response.data;
            })
            .catch(err => console.log(err));
        },
        checkType: _.debounce(function(string) {
            (string) ? this.fetchType(string) : '';
        }, 300),
        fetchType(code){
            this.types = [];
            axios.get('/categories',{
                params: {
                    option: 'type',
                    with: true,
                    category_id: this.category,
                    keyword: code
                }
            })
            .then(response => {
                this.types = response.data;
            })
            .catch(err => console.log(err));
        },
        submit(){
            if(this.editable){
                this.form.put('/samples/update',{
                    preserveScroll: true,
                    onSuccess: () => this.hide(),
                });
            } else {
                this.form.post('/samples',{
                    preserveScroll: true,
                    onSuccess: () => this.hide(),
                });
            }
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        hide(){
            this.form.reset();
            this.editable = false;
            this.action = null;
            this.types = [];
            this.categories = [];
            this.showModal = false;
        }
    }
}
</script>
