<template>
    <b-modal v-model="showModal" title="View Sample"  style="--vz-modal-width: 1100px;" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <div class="row">
            <div class="col-sm-12">
                <div class="row align-items-center g-3">
                    <div class="col-md">
                        <div>
                            <h6><span class="fw-semibold text-primary fs-15">{{selected.code}} ({{ selected.sampletype }})</span></h6>
                            <div class="hstack gap-3 fs-12 flex-wrap">
                                <div><span class="text-muted">Sample code</span> :  <span class="fw-medium">{{selected.code }}</span></div>
                                <div class="vr" style="width: 1px;"></div>
                                <div><span class="text-muted">Sample name</span> : 
                                    <span v-if="selected.samplename" class="fw-medium"> {{ selected.samplename }}</span>
                                    <span v-else class="text-muted">Not Available</span>
                                </div>
                                <div class="vr" style="width: 1px;"></div>
                                <div><span class="text-muted">Due Date</span>: 
                                    <span v-if="selected.tsr.due_at" class="fw-medium">{{selected.tsr.due_at}}</span>
                                    <span v-else class="text-muted">Not Available</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          
            <div class="col-sm-12"><hr class="text-muted"/></div>

            <div class="col-sm-12 mb-n4">
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
                                <h5 class="mb-0 fs-12"><span class="text-body">List of Test services</span></h5>
                                <p class="text-muted text-truncate-two-lines fs-11">A laboratory or technical service that performs specific analyses</p>
                            </div>
                            <div class="flex-shrink-0">
                            </div>
                        </div>
                    </div>
                
                    <div class="card-body bg-white">
                        <div class="table-responsive table-card">
                            <simplebar data-simplebar style="max-height: 300px;">
                                <table class="table align-middle table-centered table-nowrap">
                                    <thead class="bg-dark-subtle fs-11 thead-fixed">
                                        <tr>
                                            <th class="text-center" style="width: 5%" v-if="status!== 'Completed'">
                                                <input class="form-check-input fs-16" v-model="mark" type="checkbox" value="option" />
                                            </th>
                                            <th class="text-center" style="width: 5%" v-else>#</th>
                                            <th style="width: 20%">Test Name</th>
                                            <th class="text-center" style="width: 35%">Method Reference</th>
                                            <th class="text-center" style="width: 20%">Analyst</th>
                                            <th class="text-center" style="width: 20%">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-light-subtle fs-12">
                                        <tr v-for="(list,index) in selected.analyses" v-bind:key="index" class="fs-11" :class="(list.selected) ? 'table-info' : ''">
                                            <td width="5%" class="text-center fs-14" v-if="status == 'Pending'"> 
                                                <input v-if="list.status.name !== 'Completed'" type="checkbox" v-model="list.selected" class="form-check-input" />
                                                <i v-else class="text-success ri-checkbox-circle-fill fs-18"></i>
                                            </td>
                                            <td width="5%" class="text-center fs-14" v-else-if="list.started_by === $page.props.user.data.id"> 
                                                <input v-if="list.status.name !== 'Completed'" type="checkbox" v-model="list.selected" class="form-check-input" />
                                                <i v-else class="text-success ri-checkbox-circle-fill fs-18"></i>
                                            </td>
                                            <td width="5%" class="text-center fs-14" v-else>
                                                <span class="text-muted">-</span>
                                            </td>
                                            <td width="24%">
                                                <h5 class="fs-11 fw-semibold mb-0">{{list.testname}}</h5>
                                                <p class="text-muted mb-0">{{list.sample}}</p>
                                            </td>
                                            <td width="47%" class="text-center">
                                                <h5 class="fs-11 mb-0">{{list.method}}</h5>
                                                <p class="text-muted mb-0">{{list.reference}}</p>
                                            </td>
                                            <td width="12%" class="text-center">{{list.analyst}}</td>
                                            <td width="12%" class="text-center fs-13">
                                                <span :class="'badge '+list.status.color+' '+list.status.others">{{list.status.name}}</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </simplebar>
                        </div>
                    </div>
                </div>
                
               
            </div>
        </div>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button v-if="status === 'Pending'" @click="save(11,'start')" variant="primary" :disabled="form.processing" block>Start Analysis</b-button>
            <b-button v-if="status === 'Ongoing'" @click="save(12,'end')" variant="primary" :disabled="form.processing" block>End Analysis</b-button>
            <b-button v-if="status === 'Completed'" @click="openGenerate()" variant="success" :disabled="form.processing" block>Generate Report Number</b-button>
        </template>
    </b-modal>
    <Save @hide="hide" ref="save"/>
    <Generate ref="generate"/>
</template>
<script>
import simplebar from "simplebar-vue";
import Save from './Save.vue';
import Generate from './Generate.vue';
import Multiselect from "@vueform/multiselect";
import "@vueform/multiselect/themes/default.css";
export default {
    components: { Multiselect, Save, simplebar, Generate },
    data(){
        return {
            selected: {
                tsr: {},
                analyses: []
            },
            filterCode: null,
            status: null,
            form: {},
            showModal: false,
            mark: false
        }
    },
    watch: {
        mark(){
            if(this.mark){
                this.selected.analyses.forEach(item => {
                    if(this.status == 'Ongoing'){
                        if (item.started_by === this.$page.props.user.data.id) {
                            item.selected = true;
                        }
                    }else{
                        item.selected = true;
                    }
                });
            }else{
                this.selected.analyses.forEach(item => {
                    item.selected = false;
                });
            }
        }
    },
    computed: {
        tests() {
            return this.selected.analyses
                .filter(item => item.selected)
                .map(item => item.id);
        }
    },
    methods : {
        show(data,status,type) {
            this.status = status;
            this.fetch(data); 
            this.mark = null;
            this.showModal = true;
        },
        fetch(id){
            axios.get('analyses',{
                params : {
                    id: id,
                    option: 'view'
                }
            })
            .then(response => {
                this.selected = response.data;
            })
            .catch(err => console.log(err));
        },
        save(status,type){
            this.form = this.$inertia.form({
                sample_id: this.selected.id,
                tsr_id: this.selected.tsr_id,
                id: this.tests,
                status_id: status,
                start_at: null,
                end_at: null,
                option: type
            });
            this.$refs.save.show(this.form);
        },
        openGenerate(){
            this.$refs.generate.show(this.selected.id);
        },
        formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return '₱'+val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        hide(){
            this.$emit('update',true);
            this.mark = null;
            this.showModal = false;
        },
    }
}
</script>
<style>
.thead-fixed {
   position: sticky;
   top: 0;
   background-color: #fff; /* Set the background color for the fixed header */
   z-index: 1; /* Ensure the fixed header is above the scrolling content */
}
</style>