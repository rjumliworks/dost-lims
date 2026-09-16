<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 850px;" header-class="p-3 bg-light" :title="(!action) ? 'Add Sampletype' : action+' Sampletype'" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow class="g-3 mt-3">
                <BCol lg="12" v-if="action == 'Copy'">
                    <hr class="text-muted mt-n2"/>
                </BCol>
                <BCol lg="9" v-if="action == 'Copy'" class="fs-12 mt-0" :class="{ 'text-danger': form.errors.count }">Please specify how many copies of the sample you want to add with its details.</BCol>
                <BCol lg="3" v-if="action == 'Copy'" class="fs-12" style="margin-top: -9px; margin-bottom: -6px;">
                    <TextInput id="name" v-model="form.count" type="text" class="form-control" style="width: 160px; text-align: center;" :light="true"/>
                </BCol>
                <BCol lg="12" v-if="action == 'Copy'">
                    <hr class="text-muted mt-n2"/>
                </BCol>
                <BCol lg="9" v-if="action == 'Copy'" class="fs-12 mt-0" :class="{ 'text-danger': form.errors.include_testservices }">Do you want to include the test services attached to the sample when copying?</BCol>
                <BCol lg="3" v-if="action == 'Copy'" class="fs-12 mt-0">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="custom-control custom-radio mb-0">
                                <input type="radio" id="c1" class="custom-control-input me-2" :value="true" v-model="form.include_testservices">
                                <label class="custom-control-label fw-normal fs-12" for="c1">Yes</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="custom-control custom-radio mb-0">
                                <input type="radio" id="c2" class="custom-control-input me-2" :value="false" v-model="form.include_testservices">
                                <label class="custom-control-label fw-normal fs-12" for="c2">No</label>
                            </div>
                        </div>
                    </div>
                </BCol>
                <BCol lg="12" v-if="action == 'Copy'">
                    <hr class="text-muted mt-0 mb-4"/>
                </BCol>
                <BCol lg="6" class="mt-n2 mb-3">
                    <InputLabel for="testname" value="Category" :message="form.errors.category_id"/>
                    <!--  @search-change="checkCategory"  -->
                    <Multiselect
                    @input="handleInput('category_id')"
                    :options="categories" label="name" :searchable="true" 
                    v-model="category" 
                    placeholder="Select Category" ref="multiselectC"/>
                </BCol>
                <BCol lg="6" class="mt-n2 mb-3">
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
                    @input="handleInput('samplename_id')"
                    @search-change="fetchName" 
                    :options="names" label="name" :searchable="true" 
                    object
                    v-model="samplename" 
                    placeholder="Select Sample name" ref="multiselectS"/>
                </BCol>
                <BCol lg="6" class="mt-n2">
                    <InputLabel for="name" value="Other Name (Optional)"/>
                    <TextInput id="name" v-model="form.name" type="text" class="form-control" placeholder="Please enter name"/>
                </BCol>
                <template v-if="category && sampletype && samplename">
                    <BCol lg="12">
                        <hr class="text-muted mt-0"/>
                    </BCol>
                    <BCol lg="12" class="mb-3 mt-n2">
                        <div class="d-flex">
                            <div style="width: 100%;">
                                <label class="form-label">Description Template, <span class="text-muted">(Optional)</span></label>
                                <Multiselect
                                :options="templates"
                                v-model="selectedTemplate"
                                label="name" object
                                :searchable="true"
                                placeholder="Apply a saved description template"/>
                                <div class="fs-11 text-muted mt-1">Add/Select a template if you don't want to retype the description every time. </div>
                            </div>
                            <div class="flex-shrink-0">
                                <b-button style="margin-top: 20px;" v-if="selectedTemplate" @click="clearTemplate()" variant="soft-danger" class="waves-effect waves-light ms-1" v-b-tooltip.hover title="Clear applied template"><i class="ri-close-line"></i></b-button>
                                <b-button style="margin-top: 20px;"  @click="$refs.saveTemplateModal.show()" variant="primary" class="waves-effect waves-light ms-1" v-b-tooltip.hover title="Save as Template"><i class="ri-save-3-fill"></i></b-button>
                            </div>
                        </div>
                    </BCol>
                    <BCol lg="12" class="mt-n2">
                        <hr class="text-muted mt-0"/>
                    </BCol>
                    <!-- <BCol lg="12" class="mt-n2 mb-2">
                        <div class="d-flex align-items-center gap-2">
                            <div class="flex-grow-1" style="max-width: 340px;">
                                <Multiselect
                                :options="templates"
                                v-model="selectedTemplate"
                                label="name" object
                                :searchable="true"
                                placeholder="Apply a saved description template"/>
                            </div>
                            <b-button v-if="selectedTemplate" type="button" size="sm" variant="soft-danger" @click="deleteTemplate">
                                <i class="ri-delete-bin-line align-bottom"></i>
                            </b-button>
                            <b-button type="button" size="sm" variant="soft-primary" @click="showSaveTemplate = !showSaveTemplate">
                                <i class="ri-save-3-line align-bottom"></i> Save as Template
                            </b-button>
                        </div>
                        <div v-if="showSaveTemplate" class="d-flex align-items-center gap-2 mt-2">
                            <input type="text" v-model="templateName" class="form-control form-control-sm" placeholder="Template name" style="max-width: 340px;">
                            <b-button type="button" size="sm" variant="primary" :disabled="!templateName || savingTemplate" @click="saveTemplate">Save</b-button>
                            <b-button type="button" size="sm" variant="light" @click="showSaveTemplate = false">Cancel</b-button>
                        </div>
                    </BCol> -->
                    <BCol lg="6" class="mt-n1">
                        <InputLabel for="name" value="Description provided by customer"/>
                        <Textarea id="name" @input="handleInput('customer_description')" v-model="form.customer_description" class="form-control" rows="5" :class="{ 'is-invalid': form.errors.customer_description }" :light="true"/>
                    </BCol>
                    <BCol lg="6" class="mt-n1">
                        <InputLabel for="name" value="Description based on the sample submitted"/>
                        <Textarea id="name" v-model="form.description" class="form-control" rows="5" :class="{ 'is-invalid': form.errors.description }" :light="true"/>
                    </BCol>
                    <BCol lg="12" class="mt-1">
                        <InputLabel for="name" value="Remarks"/>
                        <Textarea id="name" v-model="form.remarks" class="form-control" rows="2" :class="{ 'is-invalid': form.errors.remarks }" :light="true"/>
                    </BCol>
                </template>
            </BRow>
        </form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="submit('ok')" variant="primary" :disabled="form.processing" block>
                <span v-if="action == 'Edit'">Update</span>
                <span v-else-if="action == 'Copy'">Copy</span>
                <span v-else>Submit</span>
            </b-button>
        </template>
    </b-modal>
    <SaveTemplate ref="saveTemplateModal" :saving="savingTemplate" @save="saveTemplate"/>
</template>
<script>
import _ from 'lodash';
import { useForm } from '@inertiajs/vue3';
import Multiselect from "@vueform/multiselect";
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
import Textarea from '@/Shared/Components/Forms/Textarea.vue';
import SaveTemplate from './Modals/SaveTemplate.vue';
export default {
    components: { InputLabel, TextInput, Textarea, Multiselect, SaveTemplate },
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                id: null,
                name: null,
                description: null,
                customer_description: null,
                remarks: null,
                samplename_id: null,
                sampletype_id: null,
                category_id: null,
                laboratory_id: null,
                tsr_id: null,
                count: 1,
                include_testservices: null,
                option: 'create'
            }),
            action: null,
            category: null,
            sampletype: null,
            samplename: null,
            categories: [],
            types: [],
            names: [],
            templates: [],
            selectedTemplate: null,
            savingTemplate: false,
            showModal: false,
            editable: false,
            initializing: false
        }
    },
    watch: {
    sampletype(newVal) {

        if (this.initializing) return;

        if (newVal) {
            this.form.sampletype_id = newVal.value;
            this.names = newVal.names || [];
            this.samplename = null;
            this.form.samplename_id = null;
        } else {
            this.samplename = null;
            this.form.sampletype_id = null;
            this.form.samplename_id = null;
            this.names = [];
        }

        this.form.customer_description = null;
        this.form.description = null;
        this.selectedTemplate = null;
        this.fetchTemplates();
    },

    selectedTemplate(newVal) {
        if (newVal) {
            this.form.customer_description = newVal.customer_description;
            this.form.description = newVal.description;
        }
    },

    samplename(newVal) {
        
        if (!newVal) {
            this.form.samplename_id = null;
            return;
        }

        this.initializing = true;

        this.form.samplename_id = newVal.value;

        // Set Category
        if (!this.category) {
            this.category = newVal.category?.value;
        }

        // Ensure Sample Type exists in options
        if (newVal.sampletype) {
            const exists = this.types.find(
                x => x.value === newVal.sampletype.value
            );

            if (!exists) {
                this.types.push(newVal.sampletype);
            }
            this.handleInput('samplename_id');
            this.handleInput('sampletype_id');
            this.handleInput('category_id');
            this.sampletype = newVal.sampletype;
            this.form.sampletype_id = newVal.sampletype.value;
        }

        this.form.category_id = newVal.category?.value;

        this.$nextTick(() => {
            this.initializing = false;
        });
    },

    category(newVal) {

        if (this.initializing) return;

        this.sampletype = null;
        this.samplename = null;

        this.form.sampletype_id = null;
        this.form.samplename_id = null;

        this.form.customer_description = null;
        this.form.description = null;

        this.names = [];

        if (newVal) {
            this.fetchType(newVal);
        } else {
            this.types = [];
        }
    }
},
    methods: { 
        show(id, laboratory){
            this.empty();
            this.editable = false;
            this.action = null;
            this.form.tsr_id = id;
            this.form.laboratory_id = laboratory;
            this.showModal = true;
            this.fetchCategory();
            this.fetchTemplates();
        },
        edit(id, laboratory, data){
            console.log(data);
            this.empty();
            this.initializing = true;
            this.action = 'Edit';
            this.form.option = 'edit';
            this.form.id = data.id;
            this.form.name = data.name;
            this.form.description = data.description;
            this.form.remarks = data.remarks;
            this.form.customer_description = data.customer_description;
            this.form.tsr_id = id;
            this.form.laboratory_id = laboratory;
            this.setSample(data.category,data.sampletype,data.samplename);
            this.fetchCategory();
            this.fetchTemplates();
            this.showModal = true;
            this.$nextTick(() => {
                this.initializing = false;
            });
        },
        copy(id, laboratory, data){
            console.log(data);
            // this.empty();
            this.action = 'Copy';
            this.form.option = 'copy';
            this.form.tsr_id = id;
            this.form.id = data.id;
            this.form.name = data.name;
            this.form.description = data.description;
            this.form.customer_description = data.customer_description;
            this.form.remarks = data.remarks;
            this.form.laboratory_id = laboratory;
            this.setSample(data.category,data.sampletype,data.samplename);
            this.showModal = true;
        },
       setSample(category, type, name) {

            if (category) {
                this.categories = [{
                    value: category.id,
                    name: category.name
                }];
                this.category = category.id;
                this.form.category_id = category.id;
            } else {
                this.categories = [];
                this.category = null;
                this.form.category_id = null;
            }

            if (type) {
                this.types = [{
                    value: type.id,
                    name: type.name
                }];
                this.sampletype = {
                    value: type.id,
                    name: type.name
                };
                this.form.sampletype_id = type.id;
            } else {
                this.types = [];
                this.sampletype = null;
                this.form.sampletype_id = null;
            }

            if (name) {
                this.names = [{
                    value: name.id,
                    name: name.name
                }];
                this.samplename = {
                    value: name.id,
                    name: name.name
                };
                this.form.samplename_id = name.id;
            } else {
                this.names = [];
                this.samplename = null;
                this.form.samplename_id = null;
            }
        },
        fetchCategory(code){
            axios.get('/categories',{
                params: {
                    option: 'category',
                    laboratory_id: this.form.laboratory_id
                }
            })
            .then(response => {
                this.categories = response.data;
            })
            .catch(err => console.log(err));
        },
        fetchType(code){
            this.types = [];
            axios.get('/categories',{
                params: {
                    option: 'type',
                    with: true,
                    category_id: this.category,
                }
            })
            .then(response => {
                this.types = response.data;
            })
            .catch(err => console.log(err));
        },
        fetchName(code){
            this.types = [];
            (!this.form.sampletype_id) ? this.category = null : null;
            axios.get('/categories',{
                params: {
                    option: 'name',
                    keyword: code,
                    laboratory_id: this.form.laboratory_id,
                    sampletype_id: this.form.sampletype_id
                }
            })
            .then(response => {
                this.names = response.data;
            })
            .catch(err => console.log(err));
        },
        submit(){
            this.form.category_id = this.category;
            if(this.action == 'Edit'){
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
        fetchTemplates(){
            axios.get('/sample-templates', {
                params: { sampletype_id: this.form.sampletype_id }
            })
            .then(response => {
                this.templates = response.data;
            })
            .catch(err => console.log(err));
        },
        saveTemplate(name){
            this.savingTemplate = true;
            axios.post('/sample-templates', {
                name: name,
                sampletype_id: this.form.sampletype_id,
                customer_description: this.form.customer_description,
                description: this.form.description,
            })
            .then(response => {
                const template = {
                    value: response.data.id,
                    name: response.data.name,
                    sampletype_id: response.data.sampletype_id,
                    customer_description: response.data.customer_description,
                    description: response.data.description,
                };
                this.templates.push(template);
                this.selectedTemplate = template;
                this.$refs.saveTemplateModal.hide();
            })
            .catch(err => console.log(err))
            .finally(() => { this.savingTemplate = false; });
        },
        clearTemplate(){
            this.selectedTemplate = null;
            this.form.customer_description = null;
            this.form.description = null;
        },
        deleteTemplate(){
            if(!this.selectedTemplate) return;
            if(!confirm('Delete this saved template?')) return;
            axios.delete('/sample-templates/'+this.selectedTemplate.value)
            .then(() => {
                this.templates = this.templates.filter(t => t.value !== this.selectedTemplate.value);
                this.selectedTemplate = null;
            })
            .catch(err => console.log(err));
        },
        empty() {
            this.category = null;
            this.sampletype = null;
            this.samplename = null;
            this.templates = [];
            this.selectedTemplate = null;

            this.form.reset();

            this.categories = [];
            this.types = [];
            this.names = [];
        },
        hide(){
            this.action = null;
            this.editable = false;
            this.showModal = false;
        }
    }
}
</script>
