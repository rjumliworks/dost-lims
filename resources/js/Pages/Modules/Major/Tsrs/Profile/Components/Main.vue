<template>
    <BRow>
        <div class="col-md-12">
            <div class="card bg-light-subtle shadow-none border">
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height:2.5rem;width:2.5rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-flask-fill text-primary fs-22"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-14"><span class="text-body">List of Samples Received</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">Generate and track quotations for lab services requested by customers.</p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="form-check form-switch form-switch-right form-switch-md mt-2">
                                <label for="navbarscrollspy-showcode" class="form-label text-muted">Show Analyses</label>
                                <input class="form-check-input code-switcher" v-model="showAnalyses" type="checkbox" id="navbarscrollspy-showcode">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card bg-light overflow-hidden mb-0" v-if="selected.status.name == 'Ongoing'">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h6 class="mb-0"><b class="text-secondary">Overall Progress: {{analysisCounts.percentage}}% of analyses completed successfully</b></h6>
                            </div>
                            <div class="flex-shrink-0">
                                <h6 class="mb-0">{{analysisCounts.completed}} of {{ analysisCounts.total }} completed</h6>
                            </div>
                        </div>
                    </div>
                    <div class="progress  bg-secondary-subtle">
                        <div class="progress-bar progress-bar-striped bg-secondary progress-bar-animated" role="progressbar" :aria-valuenow="analysisCounts.percentage" aria-valuemin="0" aria-valuemax="100" :style="'width: '+analysisCounts.percentage+'%'"></div>
                    </div>
                </div>
                <div class="car-body bg-white border-bottom shadow-none">
                    <b-row class="mb-2 ms-1 me-1" style="margin-top: 12px;">
                        <b-col lg>
                          
                            <div class="input-group mb-1">
                                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                                 <input type="text" placeholder="Search Sample" class="form-control" style="width: 40%;">
                                <span v-if="selected.status.name == 'Pending' || selected.status.name == 'For Payment'" @click="addAddons()" class="input-group-text fs-12" v-b-tooltip.hover title="Add Service" style="cursor: pointer;"> 
                                    <i class="ri-add-circle-fill text-primary search-icon me-1"></i>Add-ons
                                </span>
                                <span v-if="selected.status.name == 'Pending' || selected.status.name == 'For Payment'" @click="addService()" class="input-group-text fs-12" v-b-tooltip.hover title="Add Analysis" style="cursor: pointer;"> 
                                    <i class="ri-flask-fill text-primary search-icon me-1"></i>Add Service
                                </span>
                                <b-button v-if="selected.status.name == 'Pending'" type="button" variant="primary" class="fs-12" @click="addSample()">
                                    <i class="ri-add-circle-fill align-bottom me-1"></i>Add Sample
                                </b-button>
                                 <b-button type="button" variant="success" @click="printAll()">
                                    <i class="ri-printer-fill align-bottom"></i>
                                </b-button>
                            </div>
                        </b-col>
                    </b-row>
                </div>
                <div class="card bg-white border-bottom shadow-none" no-body>
                    <div class="table-responsive" :style="containerStyle">
                        <table class="table table-nowrap table-striped align-middle mb-0">
                            <thead class="table-light thead-fixed">
                                <tr class="fs-11">
                                    <th v-if="selected.status.name == 'Pending' || selected.status.name == 'For Payment'" width="4%" class="text-center">
                                        <input class="form-check-input fs-16" v-model="mark" type="checkbox" value="option" />
                                    </th>
                                    <th :class="(selected.status.name == 'Pending') ? '' : 'text-center'" width="3%">#</th>
                                    <th width="20%">Sample Name</th>
                                    <th width="63%">Description</th>
                                    <th v-if="selected.status.name != 'Pending' && selected.status.name != 'For Payment'" width="4%" class="text-center">Status</th>
                                    <th width="7%"></th>
                                </tr>
                            </thead>
                            <tbody v-if="selected.samples.length > 0">
                                <template v-for="(list,index) in selected.samples" v-bind:key="index">
                                    <tr :class="(showAnalyses) ? 'bg-info-subtle' : ''">
                                        <td v-if="selected.status.name == 'Pending' || selected.status.name == 'For Payment'"  width="4%" class="text-center">
                                            <input type="checkbox" v-model="list.selected" class="form-check-input" />
                                        </td>
                                        <td :class="(selected.status.name == 'Pending') ? '' : 'text-center'" width="3%">{{index+1}}</td>
                                        <td width="20%" style="cursor: pointer;" @click="openSampleView(list)">
                                            <h5 class="fs-13 mb-0 fw-semibold text-primary">{{(list.code) ? list.code : 'Not yet available'}}</h5>
                                            <p class="fs-13 text-muted mb-0">{{list.samplename.name}}</p>
                                        </td>
                                        <td width="63%" class="fs-12" style=" white-space: normal;overflow: hidden; text-overflow: ellipsis; max-width: 150px;">
                                            <i>{{list.customer_description}}</i>, {{list.description}}
                                        </td>
                                        <td v-if="selected.status.name != 'Pending' && selected.status.name != 'For Payment'" width="4%" class="text-center">
                                            <span class="fs-12" v-if="list.analyses.filter(item => item.status.name == 'Completed').length != list.analyses.length">{{list.analyses.filter(item => item.status.name == "Completed").length}} / {{list.analyses.length}}</span>
                                            <span v-else><i class="ri-checkbox-circle-fill text-success fs-18" v-b-tooltip.hover :title="list.analyses.filter(item => item.status.name == 'Completed').length+'/'+list.analyses.length"></i></span>
                                        </td>
                                        <td width="7%" class="text-end">
                                            <template v-if="showAnalyses">
                                                <div class="d-flex gap-3 justify-content-center">
                                                    <div class="dropdown">
                                                        <BDropdown variant="link" strategy="fixed" toggle-class="btn btn-light btn-sm dropdown" no-caret menu-class="dropdown-menu-end" :offset="{ alignmentAxis: -130, crossAxis: 0, mainAxis: 10 }"> 
                                                            <template #button-content> 
                                                                <i class="ri-more-fill"></i>
                                                            </template>
                                                            <li>
                                                                <a @click="openSampleView(list)" class="dropdown-item d-flex align-items-center" role="button">
                                                                    <i class="ri-eye-line me-2"></i> View
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a @click="openSampleEdit(list,index)" class="dropdown-item d-flex align-items-center" role="button">
                                                                    <i class="ri-pencil-line me-2"></i>Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a @click="openSampleCopy(list)" class="dropdown-item d-flex align-items-center" role="button">
                                                                    <i class="ri-file-copy-2-line me-2"></i>Copy
                                                                </a>
                                                            </li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li>
                                                                <a @click="openSampleRemove(list)" class="dropdown-item d-flex align-items-center" :class="(list.is_active) ? 'text-danger' : 'text-success'" href="#removeFileItemModal" data-id="1" data-bs-toggle="modal" role="button">
                                                                    <span class="text-danger"><i class="ri-delete-bin-fill me-2"></i> Remove</span>
                                                                </a>
                                                            </li>
                                                        </BDropdown>
                                                    </div>
                                                </div>
                                            </template>
                                            <template v-else>

                                            </template>
                                        </td>
                                    </tr>
                                    <tr v-if="list.analyses.length > 0 && showAnalyses" class="bg-info-subtle">
                                        <td colspan="5">
                                            <table class="table table-nowrap border align-middle mb-0">
                                                <thead class="table-light thead-fixed">
                                                    <tr class="fs-10">
                                                        <th class="text-center" width="5%">#</th>
                                                        <th width="20%">Test Name</th>
                                                        <th class="text-center" width="50%">Method Reference</th>
                                                        <th class="text-center" width="12%">Fee</th>
                                                        <th class="text-center" width="10%">Status</th>
                                                        <th width="10%"></th>
                                                    </tr>
                                                </thead>
                                                <tbody v-if="list.analyses.length > 0">
                                                    <tr v-for="(list,index) in list.analyses" v-bind:key="index" 
                                                    :class="list.status?.name === 'Cancelled' ? 'bg-danger-subtle' : 'bg-light-subtle'">
                                                        <td class="text-center"> 
                                                            {{index + 1}}
                                                        </td>
                                                        <td>
                                                            <h5 class="fs-12 mb-0">{{list.testname}}</h5>
                                                        </td>
                                                        <td class="text-center">
                                                            <h5 class="fs-12 mb-0">{{list.method}}</h5>
                                                            <p class="fs-11 text-muted mb-0">{{list.reference}}</p>
                                                        </td>
                                                        <td class="text-center">
                                                            <h5 class="fs-12 mb-0">{{list.fee}}</h5>
                                                            <span v-if="list.addfee.length > 0" class="text-muted fs-11">
                                                            {{ addfeeText(list.addfee) }}
                                                            </span>
                                                        </td>
                                                        <td class="text-center">
                                                            <span :class="'badge '+list.status.color+' '+list.status.others">{{list.status.name}}</span>
                                                        </td>
                                                        <td>
                                                            <b-button @click="openAnalysisView(list)" variant="soft-info" class="me-1" v-b-tooltip.hover title="View" size="sm">
                                                                <i class="ri-eye-fill align-bottom"></i>
                                                            </b-button>
                                                            <b-button @click="openAnalysisAddons(list.additional,list.id)" v-if="selected.status.name == 'Pending' && list.additional.length > 0 && list.addfee.length == 0" variant="soft-success" class="me-1" v-b-tooltip.hover title="Add-ons" size="sm">
                                                                <i class="ri-add-circle-fill align-bottom"></i>
                                                            </b-button>
                                                            <b-button v-if="selected.status.name == 'Pending' || selected.status.name == 'For Payment'" @click="openAnalysisRemove(list)" variant="soft-danger" v-b-tooltip.hover title="Delete" size="sm">
                                                                <i class="ri-delete-bin-fill align-bottom"></i>
                                                            </b-button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tbody v-else>
                                                    <tr>
                                                        <td colspan="5" class="text-center">No analysis found</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                             <tbody v-else>
                                <tr>
                                    <td colspan="5" class="text-center text-muted fs-12">No samples found. Please add at least one sample to proceed with the TSR.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </BRow>
    <ViewSample ref="view"/>
    <CreateSample ref="sample"/>
    <RemoveSample ref="remove"/>
    <AddAnalysis @success="mark = false" ref="analysis"/>
    <RemoveAnalysis ref="removeanalysis"/>
    <AdditionalAnalysis ref="additionalanalysis"/>
    <ViewAnalysis ref="viewanalysis"/>
    <Service :services="services" ref="service"/>
</template>
<script>
import Service from '../Modals/Main/Service.vue';
import ViewSample from '../Modals/Main/Sample/View.vue';
import CreateSample from '../Modals/Main/Sample/Create.vue';
import RemoveSample from '../Modals/Main/Sample/Remove.vue';
import AddAnalysis from '../Modals/Main/Analysis/Create.vue';
import ViewAnalysis from '../Modals/Main/Analysis/View.vue';
import RemoveAnalysis from '../Modals/Main/Analysis/Remove.vue';
import AdditionalAnalysis from '../Modals/Main/Analysis/Additional.vue';
export default {
    props:['selected','services','analyses'],
    components: { 
        CreateSample, RemoveSample, ViewSample, 
        AddAnalysis, RemoveAnalysis, AdditionalAnalysis, ViewAnalysis,
        Service 
    },
    data(){
        return {
            currentUrl: window.location.origin,
            samples : [],
            sample: {},
            showAnalyses: true,
            view: false,
            mark: false,
        }
    },
    computed: {
        analysisCounts() {
            let completed = 0;
            let notCompleted = 0;

            this.selected.samples.forEach(sample => {
                sample.analyses.forEach(analysis => {
                    if (analysis.status.id === 12) {
                    completed++;
                    } else {
                    notCompleted++;
                    }
                });
            });
            const total = completed + notCompleted;
            const percentage = total > 0 ? (completed / total) * 100 : 0;

            return { completed,notCompleted,total,percentage: percentage.toFixed(2) };
        },
        containerStyle() {
            let offset = 325;
            if (this.selected.status.name === 'Ongoing') {offset = 360;}
            return {
                maxHeight: `calc(100vh - ${offset}px)`,
                overflow: 'auto'
            };
        },
    },
    watch: {
        mark(){
            if(this.mark){
                this.selected.samples.forEach(item => {
                    item.selected = true;
                });
            }else{
                this.selected.samples.forEach(item => {
                    item.selected = false;
                });
            }
        },
        'selected.samples': {
            deep: true,
            handler() {
                this.samples = this.selected.samples
                    .filter(item => item.selected)
                    .map(item => ({
                        id: item.id,
                        category: item.category,
                        sampletype: item.sampletype,
                    }));
            }
        }
    },
    methods: { 
        addfeeText(fees) {
            if (!fees || fees.length === 0) return '';
            const total = fees.reduce((sum, fee) => {
                const feeValue = Number(fee.total.toString().replace(/[₱,]/g, ''));
                return sum + feeValue;
            }, 0);
            const details = fees
                .map(fee => {
                    const feeVal = Number(fee.fee.toString().replace(/[₱,]/g, ''));
                    return `(${feeVal} x ${fee.quantity}) = ${Number(fee.total.toString().replace(/[₱,]/g, ''))}`;
                })
                .join(', '); 
                // ${details} → 
            return `(with ${this.formatMoney(total)} additional fees)`;
        },
        formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return '₱'+val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        addSample(){
            this.mark = false;
            this.$refs.sample.show(this.selected.id,this.selected.laboratory.id);
        },
        addService(){
            (this.samples.length > 0) ? this.$refs.analysis.show(this.samples,this.selected.laboratory.id) : '';
        },
        addAddons(){
            this.$refs.service.show(this.selected.id);
        },
        openSampleEdit(sample){
            this.$refs.sample.edit(this.selected.id,this.selected.laboratory.id,sample);
        },
        openSampleView(sample){
            this.$refs.view.show(sample);
        },
        openSampleCopy(sample){
            this.mark = false;
            this.$refs.sample.copy(this.selected.id,this.selected.laboratory.id,sample);
        },
        openSampleRemove(data){
            this.$refs.remove.show(data,this.selected.id);
        },
        openAnalysisView(data){
            this.$refs.viewanalysis.show(data,this.selected.id);
        },
        openAnalysisAddons(data,id){
            this.$refs.additionalanalysis.show(data,id,this.selected.id);
        },
        openAnalysisRemove(data){
            this.$refs.removeanalysis.show(data,this.selected.id);
        }
    }
}
</script>
