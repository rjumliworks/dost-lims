<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" title="Add Sample Name" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <!-- style="--vz-modal-width: 600px;"  -->
        <form class="customform">
            <BRow>
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
                    </div>
                </BCol>
                <BCol lg="12" class="mt-1 mb-1">
                    <div class="d-flex">
                        <div style="width: 100%;">
                            <InputLabel for="sampletype" value="Sample Type" :message="form.errors.sampletype_id"/>
                            <Multiselect 
                            @input="handleInput('type_id')"
                            :options="types" label="name" :searchable="true" 
                            :clearOnSearch="true"
                            v-model="form.sampletype_id" 
                            placeholder="Select Sample type" ref="multiselectT"/>
                        </div>
                    </div>
                </BCol> 
                <BCol lg="12" class="mt-1 mb-1">
                    <div class="d-flex">
                        <div style="width: 100%;">
                            <InputLabel for="sampletype" value="Sample Name" :message="form.errors.samplename_id"/>
                            <Multiselect 
                            mode="tags"
                            @input="handleInput('type_id')"
                            :options="names" label="name" :searchable="true" 
                            :clearOnSearch="true"
                            v-model="form.samplenames" 
                            placeholder="Select Sample type" ref="multiselectN"/>
                        </div>
                    </div>
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
import Multiselect from '@/Shared/Components/Forms/Multiselect.vue';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
export default {
    components: { InputLabel, Multiselect },
    data(){
        return {
            form: useForm({
                testservice_id: null,
                laboratory_id: null,
                category_id: null,
                sampletype_id: null,
                samplenames: [],
                agency_id: this.$page.props.user.data.agency,
                option: 'sampletype'
            }),
            filter: {
                type: null,
                category: null
            },
            names: [],
            types: [],
            categories: [],
            type: null,
            showModal: false,
            editable: false,
        }
    },
    watch: {
        "form.category_id"(newVal){
            if(!newVal){
                this.form.sampletype_id = null;
                this.form.samplenames = [];
            }
            this.fetchType(newVal);
        },
        "form.sampletype_id"(newVal){
            if(!newVal){
                this.form.samplenames = [];
            }
            this.fetchName(newVal);
        },
    },
    methods: { 
        show(id,laboratory){
            this.form.testservice_id = id;
            this.form.laboratory_id = laboratory;
            this.showModal = true;
        }, 
        submit(){
            this.form.post('/testservices',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('message',true);
                    this.hide();
                },
            });
        },
        checkCategory: _.debounce(function(string) {
            if(string){
                this.fetchCategory(string);
                this.filter.category = string;
            }
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
        // checkType: _.debounce(function(string) {
        //     (string) ? this.fetchType(string) : '';
        //     this.filter.type = string;
        // }, 300),
        fetchType(){
            this.types = [];
            axios.get('/categories',{
                params: {
                    option: 'type',
                    category_id: this.form.category_id
                }
            })
            .then(response => {
                this.types = response.data;
            })
            .catch(err => console.log(err));
        },
        fetchName(){
            this.types = [];
            axios.get('/categories',{
                params: {
                    option: 'name',
                    sampletype_id: this.form.sampletype_id,
                }
            })
            .then(response => {
                this.names = response.data;
            })
            .catch(err => console.log(err));
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        hide(){
            this.categories = [];
            this.types = [];
            this.form.reset();
            this.$refs.multiselectC.clear();
            this.$refs.multiselectT.clear();
            this.filter.category = null;
            this.filter.type = null;
            this.editable = false;
            this.showModal = false;
        }
    }
}
</script>