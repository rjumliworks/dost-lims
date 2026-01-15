<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 900px;" header-class="p-3 bg-light" title="Add Test Service" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>     
       
        <div class="card bg-light-subtle border-1 rounded-bottom shadow-none mb-0 p-3">
            <form class="customform">
                <BRow>
                    <BCol lg="6" class="mt-n1 mb-1">
                        <InputLabel for="laboratory_id" value="Laboratory" :message="form.errors.laboratory_id"/>
                        <Multiselect :options="dropdowns.laboratories" 
                        @input="handleInput('laboratory_id')" 
                        :searchable="true" v-model="form.laboratory_id" 
                        placeholder="Select Laboratory type" ref="multiselect1"/>
                    </BCol>
                    <BCol lg="6" class="mt-n1 mb-1">
                        <div class="d-flex">
                            <div style="width: 100%;">
                                <InputLabel for="testname" value="Test Name" :message="form.errors.testname_id"/>
                                <Multiselect @search-change="checkCategory" 
                                @input="handleInput('testname_id')"
                                :options="categories" label="name" :searchable="true" 
                                v-model="form.category_id" 
                                placeholder="Select Test name" ref="multiselectC"/>
                            </div>
                            <div class="flex-shrink-0">
                                <b-button @click="addCategory()" style="margin-top: 20px;" variant="light" class="waves-effect waves-light ms-1" :disabled="(form.laboratory_id && categories.length === 0) ? false : true"><i class="ri-add-circle-fill"></i></b-button>
                            </div>
                        </div>
                    </BCol> 
                </BRow>
            </form>
        </div>

         <div class="card bg-light-subtle shadow-none border mt-3">

            <div class="card-header bg-light-subtle">
                <div class="d-flex mb-n3">
                    <div class="flex-shrink-0 me-2">
                        <div style="height:2rem;width:2rem;">
                            <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                <i class="ri-list-check text-primary fs-16"></i>
                            </span>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="mb-0 fs-12" style="margin-top: -3px;"><span class="text-body">Method Reference</span></h5>
                        <p class="text-muted text-truncate-two-lines fs-11">View and manage customer profiles along with their laboratory test requests and related transactions.</p>
                    </div>
                    <div class="flex-shrink-0" >
                    
                    </div>
                </div>
            </div>
            <div class="car-body bg-white border-bottom shadow-none">
                <b-row class="mb-2 ms-1 me-1" style="margin-top: 12px;">
                    <b-col lg>
                        <div class="input-group mb-1">
                            <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                            <input type="text" v-model="filter.keyword" placeholder="Search Sample Name" class="form-control" style="width: 20%;">
                            
                            <b-button type="button" variant="primary" @click="openCreate">
                                <i class="ri-add-circle-fill align-bottom me-1"></i> Add
                            </b-button>
                        </div>
                    </b-col>
                </b-row>
            </div>
            <div class="card-body bg-white rounded-bottom">
                <div class="table-responsive table-card" style="min-height: 100px; max-height: calc(100vh - 465px); overflow: auto;">
                    <table class="table align-middle table-centered table-striped mb-0">
                        <thead class="table-light thead-fixed">
                            <tr class="fs-11">
                                <td></td>
                                <td>Method</td>
                                <td class="text-center">Reference</td>
                                <td class="text-center">Fee</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="4" class="text-center text-muted fs-12">No methods found. Please use search box.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
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
                testname_id: null,
                method_id: null,
                status_id: 31,
                agency_id: this.$page.props.user.data.agency,
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