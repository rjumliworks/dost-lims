<template>
    <!-- style="--vz-modal-width: 650px;" -->
    <b-modal v-model="showModal" :style="(selected) ? (selected.laboratory_id == 3) ? '--vz-modal-width: 600px;' : '--vz-modal-width: 600px' : '--vz-modal-width: 600px'" header-class="p-3 bg-light" title="Generate Report Number" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow class="g-3">
                <BCol lg="12">
                    <InputLabel for="customer" value="Sample Code" :message="form.errors.sample"/>
                    <Multiselect 
                    :options="samples" 
                    @search-change="fetchSample" 
                    v-model="selected" 
                    object label="name"
                    :searchable="true" 
                    @input="handleInput('sample')"
                    placeholder="Select Sample"/>
                </BCol>
                <BCol lg="12">
                    <hr class="text-muted mt-0 mb-0"/>
                </BCol>
                <BCol lg="12" class="mb-n4">
                    <div class="card bg-light-subtle shadow-none border">
                        <div class="card-header bg-light-subtle">
                            <div class="d-flex mb-n3">
                                <div class="flex-shrink-0 me-3">
                                    <div style="height:2.2rem; width:2.2rem;">
                                        <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                            <i class="ri-flask-fill text-primary fs-20"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-0 fs-12"><span class="text-body">List of Samples</span></h5>
                                    <p class="text-muted text-truncate-two-lines fs-11">Samples that has no report number.</p>
                                </div>
                                <div class="flex-shrink-0">
                                </div>
                            </div>
                        </div>
                        <div class="card-body bg-white">
                            <div class="table-responsive table-card">
                                <table class="table align-middle table-centered table-nowrap">
                                    <thead class="bg-dark-subtle fs-11">
                                        <tr>
                                            <th><input class="form-check-input fs-16" v-model="mark" type="checkbox" value="option" /></th>
                                            <th>Sample Code</th>
                                            <th class="text-center" style="width: 50%">Report No.</th>
                                            <th class="text-end" style="width: 20%"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-light-subtle fs-12" v-if="selected">
                                        <tr class="fs-13 table-info">
                                            <td>
                                                <input type="checkbox"  @change="toggleChecked($event, selected, 5000)" v-model="selected.selected" class="form-check-input" />
                                            </td>
                                            <td class="fw-semibold text-primary">{{selected.name}}</td>
                                            <td class="text-center">{{(!selected.report) ? '-' : selected.report}}</td>
                                            <td class="text-end">
                                                <i v-if="checked.includes(selected.value) && !selected.report" class="ri-record-circle-fill text-primary fs-18"></i>
                                                <b-button v-if="!selected.report && !checked.includes(selected.value)" @click="generate('main',selected)" variant="primary" class="mb-n2 mt-n2" :disabled="form.processing" size="sm">Generate</b-button>
                                                <i v-if="selected.report" class="ri-checkbox-circle-fill text-success fs-18"></i>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <simplebar data-simplebar style="max-height: 200px;">
                                <table class="table align-middle table-centered table-nowrap mt-0">
                                    <thead class="bg-dark-subtle fs-11 thead-fixed"  v-if="selected">
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">Found {{selected.related.length}} related samples under the same TSR that is completed</td>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-light-subtle fs-12" v-if="selected">
                                        <tr v-for="(list,index) in selected.related" v-bind:key="index" class="fs-13" :class="(list.selected) ? 'table-info' : ''">
                                            <td>
                                                <input type="checkbox" @change="toggleChecked($event, list, index)" v-model="list.selected" class="form-check-input" />
                                            </td>
                                            <td class="fw-semibold text-primary">{{list.name}}</td>
                                            <td style="width: 50%" class="text-center">{{(!list.report) ? '-' : list.report}}</td>
                                            <td style="width: 20%" class="text-end">
                                                <i v-if="checked.includes(list.value) && !list.report" class="ri-record-circle-fill text-primary fs-18"></i>
                                                <b-button v-if="!list.report && !checked.includes(list.value)" @click="generate('sub',list,index)" variant="primary" class="mb-n2 mt-n2" :disabled="form.processing" size="sm">Generate</b-button>
                                                <i v-if="list.report" class="ri-checkbox-circle-fill text-success fs-18"></i>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </simplebar>
                            </div>
                        </div>
                    </div>
                </BCol>
            </BRow>
        </form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
            <b-button v-if="checked.length > 0" @click="openConfirmation()" variant="danger" :disabled="form.processing" block>Generate</b-button>
        </template>
    </b-modal>
    <Add @selected="set" ref="conforme"/>
    <Confirm @update="updateData" ref="confirm"/>
</template>
<script>
import _ from 'lodash';
import simplebar from "simplebar-vue";
import Confirm from './Confirm.vue';
import { useForm } from '@inertiajs/vue3';
import Multiselect from "@vueform/multiselect";
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    components: { Multiselect, InputLabel, TextInput, simplebar, Confirm },
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                id: null,
                option: 'single',
                laboratory_id: null
            }),
            index: null,
            selected: null,
            samples: [],
            checked: [],
            mark: null,
            showModal: false,
            editable: false
        }
    },
    watch: {
        mark(){
            if(this.mark){
                this.selected.related.forEach(item => {
                    item.selected = true;
                    this.checked.push(item.value);
                });
                this.selected.selected = true;
                this.checked.push(this.selected.value);
            }else{
                if(this.selected){
                    this.selected.related.forEach(item => {
                        item.selected = false;
                    });
                    this.selected.selected = null;
                }
                this.checked = [];
            }
        },
    },
    methods: { 
        show(){
            this.mark = null;
            this.checked = [];
            this.selected = null;
            this.showModal = true;
        },
        generate(type,data,index = null){
            this.form.id = data.value;
            this.form.laboratory_id = this.selected.laboratory_id;
            this.index = index;
            this.submit(type);
        },
        submit(type){
            this.form.post('/testreports',{
                preserveScroll: true,
                onSuccess: (response) => {
                    if(type == 'main'){
                        this.selected.report = this.$page.props.flash.data.code;
                    }else{
                        this.selected.related[this.index].report = this.$page.props.flash.data.code;
                    }
                    this.$emit('update',true);
                },
            });
        },
        fetchSample(code){
            axios.get('/testreports',{
                params: {
                    option: 'samples',
                    keyword: code
                }
            })
            .then(response => {
                this.samples = response.data;
            })
            .catch(err => console.log(err));
        },
        toggleChecked(event, item, index) {
            const isChecked = event.target.checked;
            item.selected = isChecked;
            if(index != 5000){
                this.selected.related[index].selected = isChecked;
            }else{
                this.selected.selected = isChecked;
            }

            if (isChecked) {
                if (!this.checked.includes(item.value)) {
                    this.checked.push(item.value);
                }
            } else {
                this.checked = this.checked.filter(val => val !== item.value);
            }
        },
        openConfirmation(){
            this.$refs.confirm.show(this.checked,this.selected.laboratory_id);
        },
        updateData(data){
            const match = data.find(item => item.id === this.selected.value);
            if (match) {
                this.selected.report = match.code;
            }
            this.selected.related.forEach(relatedItem => {
                const relatedMatch = data.find(item => item.id === relatedItem.value);
                if (relatedMatch) {
                    relatedItem.report = relatedMatch.code;
                }
            });

            this.$emit('update',true);
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        hide(){
            this.checked = [];
            this.form.reset();
            this.editable = false;
            this.showModal = false;
        }
    }
}
</script>