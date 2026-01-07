<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 600px;" header-class="p-3 bg-light" title="Add Sample Name" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
            
        <form class="customform">
            <BRow>
                <BCol lg="12" class="mt-1 mb-1">
                    <InputLabel for="classification_id" value="Laboratory" :message="form.errors.laboratory_id"/>
                    <Multiselect :options="dropdowns.laboratories" 
                    @input="handleInput('laboratory_id')" 
                    :searchable="true" v-model="form.laboratory_id" 
                    placeholder="Select Laboratory type" ref="multiselect1"/>
                </BCol>
                <BCol lg="12" class="mt-1 mb-1">
                    <div class="d-flex">
                        <div style="width: 100%;">
                            <InputLabel for="testname" value="Category" :message="form.errors.category_id"/>
                            <Multiselect @search-change="checkCategory" 
                            @input="handleInput('testname_id')"
                            :options="categories" label="name" :searchable="true" 
                            v-model="form.category_id" 
                            placeholder="Select Category" ref="multiselectC"/>
                        </div>
                        <div class="flex-shrink-0">
                            <b-button @click="addCategory()" style="margin-top: 20px;" variant="light" class="waves-effect waves-light ms-1" :disabled="(form.laboratory_id && categories.length === 0) ? false : true"><i class="ri-add-circle-fill"></i></b-button>
                        </div>
                    </div>
                </BCol>
                <BCol lg="12" class="mt-1 mb-1">
                    <div class="d-flex">
                        <div style="width: 100%;">
                            <InputLabel for="sampletype" value="Sample Type" :message="form.errors.type_id"/>
                            <Multiselect @search-change="checkType" 
                            @input="handleInput('type_id')"
                            :options="types" label="name" :searchable="true" 
                            :clearOnSearch="true"
                            v-model="form.type_id" 
                            placeholder="Select Sample type" ref="multiselectT"/>
                        </div>
                        <div class="flex-shrink-0">
                            <b-button @click="addType()" style="margin-top: 20px;" variant="light" class="waves-effect waves-light ms-1" :disabled="(form.laboratory_id && types.length === 0) ? false : true"><i class="ri-add-circle-fill"></i></b-button>
                        </div>
                    </div>
                </BCol>
                <BCol lg="12">
                    <InputLabel for="name" value="Sample Name"/>
                    <TextInput id="name" v-model="form.name" type="text" class="form-control" placeholder="Please enter name"  :light="true"/>
                </BCol>  
            </BRow>
        </form>
        
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="submit('ok')" variant="primary" :disabled="form.processing" block>Submit</b-button>
        </template>
    </b-modal>
    <AddType @selected="setType" ref="type"/>
    <AddCategory @selected="setCategory" ref="category"/>
</template>
<script>
import _ from 'lodash';
import { useForm } from '@inertiajs/vue3';
import AddType from './AddType.vue';
import AddCategory from './AddCategory.vue';
import Multiselect from '@/Shared/Components/Forms/Multiselect.vue';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    components: { InputLabel, TextInput, Multiselect, AddCategory, AddType },
    props: ['dropdowns'],
    data(){
        return {
            form: useForm({
                id: null,
                laboratory_id: null,
                type_id: null,
                category_id: null,
                name: null,
                option: 'name'
            }),
            filter: {
                keyword: null,
                type: null,
                category: null
            },
            types: [],
            categories: [],
            type: null,
            showModal: false,
            editable: false,
        }
    },
    watch: {
        'form.laboratory_id'(){
            this.types = [];
            this.categories = [];
            this.$refs.multiselectC.clear();
            this.$refs.multiselectT.clear();
            this.form.type_id = null;
            this.form.category_id = null;
        }
    },
    methods: { 
        show(){
            this.showModal = true;
        }, 
        submit(){
            this.form.post('/categories',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('message',true);
                    this.hide();
                },
            });
        },
        checkCategory: _.debounce(function(string) {
            this.fetchCategory(string);
            this.filter.category = string;
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
            this.filter.type = string;
        }, 300),
        fetchType(code){
            this.types = [];
            axios.get('/categories',{
                params: {
                    option: 'type',
                    category_id: this.form.category_id,
                    keyword: code
                }
            })
            .then(response => {
                this.types = response.data;
            })
            .catch(err => console.log(err));
        },
        addCategory(){
            this.$refs.category.show(this.form.laboratory_id,this.filter.category);
        },
        setCategory(data){
            this.fetchCategory(data.name);
            this.$refs.multiselectC.emitSelectedValues(data.value);
        },
        addType(){
            this.$refs.type.show(this.form.category_id,this.filter.type);
        },
        setType(data){
            this.fetchType(data.name);
            this.$refs.multiselectT.emitSelectedValues(data.value);
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        hide(){
            this.methods = [];
            this.form.reset();
            this.$refs.multiselect1.clear();
            this.$refs.multiselectC.clear();
            this.$refs.multiselectT.clear();
            this.filter.keyword = null;
            this.editable = false;
            this.showModal = false;
        }
    }
}
</script>