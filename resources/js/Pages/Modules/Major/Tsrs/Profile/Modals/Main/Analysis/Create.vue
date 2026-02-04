<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 1000px;" header-class="p-3 bg-light" title="Add Analysis" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <BRow>
            <div class="col-md-12">
                <div class="card bg-light-subtle shadow-none border">
                    <div class="card-header bg-light-subtle">
                        <div class="d-flex mb-n3">
                            <div class="flex-shrink-0 me-3">
                                <div style="height:2.3rem; width:2.3rem;">
                                    <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                        <i class="ri-flask-fill text-primary fs-20"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-0 fs-12"><span class="text-body">List of Testservices ({{ checkedItems.length }} selected)</span></h5>
                                <p class="text-muted text-truncate-two-lines fs-12">Search and select the test services to be performed by the analyst for the specified sample.</p>
                            </div>
                            <div class="flex-shrink-0">
              
                            </div>
                        </div>
                    </div>
                    <div class="card bg-white border-bottom shadow-none" no-body>
                        <div class="table-responsive" style="max-height: calc(100vh - 600px); overflow: auto;">
                            <table class="table table-nowrap table-striped align-middle mb-0">
                                <thead class="table-light thead-fixed">
                                    <tr class="fs-11">
                                        <th style="width: 5%;" class="text-center">#</th>
                                        <th style="width: 20%;">Testname</th>
                                        <th style="width: 46%;" class="text-center">Method</th>
                                        <th style="width: 15%;" class="text-center">Fee</th>
                                        <th style="width: 4%;"></th>
                                    </tr>
                                </thead>
                                <tbody v-if="checkedItems.length > 0">
                                    <tr v-for="(list,index) in checkedItems" v-bind:key="index" :class="(isItemChecked(list.id)) ? 'table-success' : (index == matchedRowIndex) ? 'table-warning' : ''" :id="'row-' + index">
                                        <td style="width: 5%;" class="text-center fs-10">{{index+1}}</td>
                                        <td style="width: 20%;" class="fs-10">{{list.testname}}</td>
                                        <td style="width: 46%;" class="text-center fs-10">{{list.method}} <span v-if="list.method_short" class="text-muted">({{list.method_short}})</span></td>
                                        <td style="width: 15%;" class="text-center fs-10">{{list.fee}}</td>
                                        <td style="width: 4%;" class="text-center"> 
                                            <b-button @click="openDeleteTest(list)" variant="soft-danger" v-b-tooltip.hover title="Delete" size="sm">
                                                <i class="ri-delete-bin-fill align-bottom"></i>
                                            </b-button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted fs-12">Please select at least one test service to proceed</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <hr class="text-muted mt-n1"/>
            </div>
            <div class="col-md-12">
                <BRow class="g-3">
                    <b-col lg>
                        <div class="input-group mb-1">
                            <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                            <Multiselect class="white" @search-change="checkSearchSample" style="width: 45%;" :options="sampletypes" v-model="sampletype" label="name" :allow-empty="false" :searchable="true" placeholder="Search sampletype" ref="multiselectS"/>
                            <input type="text" v-model="filter.keyword" placeholder="Search" class="form-control" style="width: 40%;">
                            <b-button type="button" variant="primary">
                                <i class="ri-search-eye-line align-bottom me-1"></i> 
                            </b-button>
                        </div>
                    </b-col>
                </BRow>
            </div>
            <div class="col-md-12 mt-3">
                <simplebar data-simplebar style="max-height: 200px">
                    <div>
                        <table class="table table-centered table-bordered table-nowrap mb-0">
                            <tbody>
                                <tr v-for="(list,index) in sortedTestservices" v-bind:key="list.id" :class="(isItemChecked(list.id)) ? 'table-success' : (index == matchedRowIndex) ? 'table-warning' : ''" :id="'row-' + index">
                                    <td style="width: 7%;" class="text-center"> 
                                        <input class="form-check-input me-1" type="checkbox" :checked="isItemChecked(list.id)" @change="toggleChecked(list,$event)">
                                    </td>
                                    <td style="width: 25%;" class="text-center fs-11">{{list.testname}}</td>
                                    <td style="width: 53%;" class="text-center fs-11">{{list.method}} <span v-if="list.method_short" class="text-muted">({{list.method_short}})</span></td>
                                    <td style="width: 15%;" class="text-center fs-11">{{list.fee}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </simplebar>
            </div>
        </BRow>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button v-if="!has_many" @click="submit('ok')" variant="primary" block>Submit</b-button>
            <b-button v-else @click="submitMany('ok')" variant="primary" block>Submit</b-button>
        </template>
    </b-modal>
</template>
<script>
import _ from 'lodash';
import { useForm } from '@inertiajs/vue3';
import simplebar from 'simplebar-vue';
import Amount from '@/Shared/Components/Forms/Amount.vue';
import Multiselect from "@vueform/multiselect";
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
export default {
    components: { InputLabel, Multiselect, simplebar, Amount },
    data(){
        return {
            currentUrl: window.location.origin,
            selected: {},
            form: useForm({
                fee: null,
                lists: [],
                samples: [],
                option: 'analyses'
            }),
            filter: {
                keyword: null,
                sampletype: null
            },
            sampletypes: [],
            sampletype: null,
            testservices: [],
            selected: {},
            checkedItems: [],
            type: null,
            showModal: false
        }
    },
    watch: {
        sampletype(){
            this.testservices = [];
            this.fetchTest();
        },
        totalFee(newTotalFee) {
            this.form.fee = newTotalFee;
            // this.$refs.testing.emitValue(this.form.fee);
        },
        "filter.keyword"(newVal){
            this.fetchTest();
        }
    },
    computed: {
        totalFee() {
            const total = this.checkedItems.reduce((acc, item) => {
                return acc + parseFloat(item.fee_num);
            }, 0);
            return total.toFixed(2);
        },
        sortedTestservices() {
            return this.testservices.slice().sort((a, b) => {
            if (a.name < b.name) return -1;
            if (a.name > b.name) return 1;
            return 0;
            });
        },
    },
    methods: { 
        toggleChecked(item, event) {
            const isChecked = event.target.checked;
            const itemId = item.id;

            if (isChecked) {
                // Add item to checkedItems if not already present
                if (!this.checkedItems.some(checkedItem => checkedItem.id === itemId)) {
                    this.checkedItems.push(item);
                    // Remove item from testservices
                    const testIndex = this.testservices.findIndex(test => test.id === itemId);
                    if (testIndex !== -1) {
                        this.testservices.splice(testIndex, 1);
                    }
                }
            } else {
                // Remove item from checkedItems if present
                const checkedIndex = this.checkedItems.findIndex(checkedItem => checkedItem.id === itemId);
                if (checkedIndex !== -1) {
                    this.checkedItems.splice(checkedIndex, 1);
                    // Restore item to testservices if it was unchecked
                    const itemToRestore = this.checkedItems.find(item => item.id === itemId);
                    if (itemToRestore) {
                        this.testservices.push(itemToRestore);
                    }
                }
            }
        },
        isItemChecked(item) {
            return this.checkedItems.some(checkedItem => checkedItem.id === item);
        },
        openDeleteTest(data){
            const index = this.checkedItems.findIndex(test => test.id === data.id);
            if (index !== -1) {
                this.checkedItems.splice(index, 1);
            }
        },
        show(data,laboratory){
            this.testservices = [];
            this.form.samples = data
            this.selected = data;
            console.log(data);
            this.form.laboratory_id = laboratory;
            this.showModal = true;
        }, 
        submit(){
            this.form.lists = this.checkedItems;
            this.form.post('/analyses',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('success',true);
                    this.hide();
                },
            });
        },
        amount(val){
            this.form.fee = val;
        },
        checkSearchSample: _.debounce(function(string) {
            (string) ? this.fetchSample(string) : '';
            this.filter.sampletype = string;
        }, 300),
        fetchSample(code){
            this.sampletypes = [];
            axios.get('/testservices',{
                params: {
                    option: 'search',
                    laboratory_id: this.form.laboratory_id,
                    type: 30,
                    keyword: code
                }
            })
            .then(response => {
                this.sampletypes = response.data;
            })
            .catch(err => console.log(err));
        },
        fetchTest(code){
            axios.get('/testservices',{
                params: {
                    option: 'testservices',
                    laboratory_id: this.form.laboratory_id,
                    sampletype_id: this.sampletype,
                    ids: this.checkedItems.map(item => item.id),
                    keyword: this.filter.keyword,
                }
            })
            .then(response => {
                this.testservices = response.data.data;
            })
            .catch(err => console.log(err));
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        hide(){
            this.checkedItems = [];
            this.testservices = [];
            this.form.fee = null;
            this.$refs.multiselectS.clear();
            this.form.reset();
            this.form.clearErrors();
            this.editable = false;
            this.showModal = false;
        }
    }
}
</script>