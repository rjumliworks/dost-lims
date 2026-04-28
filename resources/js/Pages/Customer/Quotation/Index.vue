<template>
    <PageHeader title="Quotation" pageTitle="Customer" />
    <b-row class="g-3" v-if="selected">
        
        <b-col lg="8">
            <div class="card shadow-none border">
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3 mt-1">
                            <div style="height:2rem;width:2rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-hand-coin-fill text-primary fs-20"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 mt-0 fs-13"><span class="text-body">List of Samples</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-11">Generate and track quotations for lab services requested by customers.</p>
                        </div>
                    </div>
                </div>
                <div class="car-body bg-white border-bottom shadow-none">
                    <b-row class="mb-2 ms-1 me-1" style="margin-top: 12px;">
                        <b-col lg>
                          
                            <div class="input-group mb-1">
                                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                                <input type="text" placeholder="Search Sample" class="form-control" style="width: 40%;">
                                 <span @click="addService()" class="input-group-text fs-12" v-b-tooltip.hover title="Add Analysis" style="cursor: pointer;"> 
                                    <i class="ri-flask-fill text-primary search-icon me-1"></i>Add Service
                                </span>
                                <b-button type="button" variant="primary" class="fs-12" @click="addSample()">
                                    <i class="ri-add-circle-fill align-bottom me-1"></i>Add Sample
                                </b-button>
                            </div>
                        </b-col>
                    </b-row>
                </div>
                <div class="card shadow-none" no-body style="height: calc(100vh - 422px);">
                     <div class="table-responsive" :style="containerStyle">
                    <table class="table table-nowrap table-striped align-middle mb-0">
                        <thead class="table-light thead-fixed">
                            <tr class="fs-11">
                                <th width="4%" class="text-center">
                                    <input class="form-check-input fs-16" v-model="mark" type="checkbox" value="option" />
                                </th>
                                <th :class="(selected.data.status.name == 'Pending') ? '' : 'text-center'" width="3%">#</th>
                                <th width="20%">Sample Name</th>
                                <th width="63%">Description</th>
                                <th width="7%"></th>
                            </tr>
                        </thead>
                        <tbody v-if="selected.data.samples.length > 0">
                            <template v-for="(list,index) in selected.data.samples" v-bind:key="index">
                                <tr :class="(showAnalyses) ? 'bg-info-subtle' : ''">
                                    <td v-if="selected.data.status.name == 'Pending'"  width="4%" class="text-center">
                                        <input type="checkbox" v-model="list.selected" class="form-check-input" />
                                    </td>
                                    <td width="3%">{{index+1}}</td>
                                    <td width="20%" style="cursor: pointer;" @click="openSampleView(list)">
                                        <h5 class="fs-12 mb-0 fw-semibold text-primary">{{list.samplename.name}}</h5>
                                        <p class="fs-12 text-muted mb-0">{{list.sampletype.name}}</p>
                                    </td>
                                    <td width="63%" class="fs-12" style=" white-space: normal;overflow: hidden; text-overflow: ellipsis; max-width: 150px;">
                                        <i>{{list.customer_description}}</i>, {{list.description}}
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
                                                    <th class="text-center" width="60%">Method Reference</th>
                                                    <th class="text-center" width="12%">Fee</th>
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
                                                        
                                                    </td>
                                                    <td>
                                                        <b-button @click="openAnalysisView(list)" variant="soft-info" class="me-1" v-b-tooltip.hover title="View" size="sm">
                                                            <i class="ri-eye-fill align-bottom"></i>
                                                        </b-button>
                                                        <b-button @click="openAnalysisAddons(list.additional,list.id)" v-if="selected.data.status.name == 'Pending' && list.additional.length > 0 && list.addfee.length == 0" variant="soft-success" class="me-1" v-b-tooltip.hover title="Add-ons" size="sm">
                                                            <i class="ri-add-circle-fill align-bottom"></i>
                                                        </b-button>
                                                        <b-button v-if="selected.data.status.name == 'Pending' || selected.data.status.name == 'For Payment'" @click="openAnalysisRemove(list)" variant="soft-danger" v-b-tooltip.hover title="Delete" size="sm">
                                                            <i class="ri-delete-bin-fill align-bottom"></i>
                                                        </b-button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tbody v-else>
                                                <tr>
                                                    <td colspan="4" class="text-center">No analysis found</td>
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
        </b-col>
        <b-col lg="4">
            <div class="card shadow-none border">
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3 mt-1">
                            <div style="height:2rem;width:2rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-hand-coin-fill text-primary fs-20"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 mt-0 fs-13"><span class="text-body">Payment Information</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-11">Highlights urgency and updates</p>
                        </div>
                    </div>
                </div>
                <div class="card shadow-none" no-body style="height: calc(100vh - 360px);">
                    <table class="table table-bordered">
        <tbody>
           
      
            <tr>
                <td style="border-right: none; border-left: none;">
                    <div class="row ms-n2 mb-0">
                        <div class="col-md-12 margin-space">
                            <div class="d-flex">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary"><i class="ri-price-tag-2-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="margin-custom fs-12 text-muted">Subtotal :</p> 
                                    <h6 class="text-truncate mb-0 fs-12">
                                        <span>{{selected.data.subtotal}} </span>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 margin-space">
                            <div class="d-flex mt-3">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary"><i class="ri-coupon-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="margin-custom fs-12 text-muted">Discount :</p> 
                                    <h6 class="text-truncate mb-0 fs-12">
                                        <span >{{selected.data.discount}} <span class="text-muted">({{selected.data.discounted.name}} - {{selected.data.discounted.value }}%)</span></span>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex mt-3">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary"><i class="ri-price-tag-3-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="margin-custom fs-12 text-muted">Total :</p>
                                    <h6 class="text-truncate mb-0 fs-12">{{selected.data.total}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
                    
                </div>
            </div>
        </b-col>
        
        
        
  <AddAnalysis @success="mark = false" ref="analysis"/>
    </b-row>
    <Create ref="sample"/>
</template>
<script>
import AddAnalysis from './Modals/Analysis/Create.vue';
import Create from './Modals/Create.vue';
import PageHeader from '@/Shared/Components/PageHeader.vue';
export default {
    components: { PageHeader, Create, AddAnalysis },
    props: ['selected'],
    data() {
        return {
            samples : [],
            sample: {},
            showAnalyses: true,
            view: false,
            mark: false,
        }
    },
    watch: {
        mark(){
            if(this.mark){
                this.selected.data.samples.forEach(item => {
                    item.selected = true;
                });
            }else{
                this.selected.data.samples.forEach(item => {
                    item.selected = false;
                });
            }
        },
        'selected.data.samples': {
            deep: true,
            handler() {
                this.samples = this.selected.data.samples
                    .filter(item => item.selected)
                    .map(item => ({
                        id: item.id,
                        category: item.category,
                        sampletype: item.sampletype,
                    }));
            }
        }
    },
    computed: {
        analysisCounts() {
            let completed = 0;
            let notCompleted = 0;

            this.selected.data.samples.forEach(sample => {
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
            let offset = 320;
            if (this.selected.data.status.name === 'Ongoing') {offset = 320;}
            return {
                maxHeight: `calc(100vh - ${offset}px)`,
                overflow: 'auto'
            };
        },
    },
    methods: {
        addSample(){
            this.$refs.sample.show(1,1);
        },
        addService(){
            console.log(this.selected);
            (this.samples.length > 0) ? this.$refs.analysis.show(this.samples,this.selected.data.laboratory.id) : '';
        },
        formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return '₱'+val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
    },
}
</script>