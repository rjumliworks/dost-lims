<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 950px;" hide-footer header-class="p-3 bg-light" title="View Sample" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div v-if="summary" class="row mb-3">
            <div class="col-md-12">
                <div class="row align-items-center g-3">
                    <div class="col-md">
                        <div>
                            <h6><span class="fw-semibold text-primary fs-15">{{ summary.code }}</span></h6>
                            <div class="hstack gap-3  fs-12 flex-wrap">
                                <!-- {{ summary }} -->
                                <div>Sample Name :  {{ summary.samplename.name }} </div>
                                <div class="vr" style="width: 1px;"></div>
                                <div>Sample Type : 
                                    <span class="fw-medium"> {{ summary.sampletype.name }}</span>
                                </div>
                                <div class="vr" style="width: 1px;"></div>
                                <div>Sample Category : 
                                    <span class="fw-medium"> {{ summary.category.name }}</span>
                                </div>
                                <!-- <div class="vr" style="width: 1px;"></div>
                                <div>Serial No. : 
                                    <span v-if="selected.serial_no" class="fw-medium">{{selected.serial_no}}</span>
                                    <span v-else class="text-muted">Not Available</span>
                                </div>
                                <div class="vr" style="width: 1px;"></div>
                                <div>Price : <span class="fw-medium">{{selected.price}}</span></div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="summary" class="row g-2 mt-0 mb-1">
            <div class="col-sm-12">
                <hr class="text-muted mt-n2 mb-2"/>
            </div>
            <!-- {{ summary }} -->
            <div class="col-sm-4">
                <div class="p-1 border border-dashed bg-white rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-2">
                            <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-hashtag"></i></div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-0 fs-12">Report Number :</p>
                            <h5 class="mb-0 fs-12"> {{ summary?.report?.report?.code ?? '-' }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="p-1 border border-dashed bg-white rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-2">
                            <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-account-circle-fill"></i></div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-0 fs-12">Analyst :</p>
                            <h5 class="mb-0 fs-12">{{ summary?.report?.report?.user?.profile?.name ?? '-' }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="p-1 border border-dashed bg-white rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-2">
                            <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-quill-pen-fill"></i></div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-0 fs-12">Signatories :</p>
                            <h5 class="mb-0 fs-12">
                                <span v-if="summary?.report?.report.signatory.status_id == 41">3 of 3</span>
                                <span v-else-if="summary?.report?.report.signatory.status_id == 39">1 of 3</span>
                                <span v-else-if="summary?.report?.report.signatory.status_id == 40">2 of 3</span>
                                <span v-else>0 of 3</span>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <hr class="text-muted mt-2 mb-2"/>
            </div>
            <!-- <div class="col-sm-12">
                <div class="p-1 border border-dashed bg-white rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-2">
                            <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-file-text-fill"></i></div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-0 fs-12">Customer Description :</p>
                            <h5 class="mb-0 fs-12">{{ summary.customer_description }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="p-1 border border-dashed bg-white rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-2">
                            <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-file-text-fill"></i></div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-0 fs-12">Description :</p>
                            <h5 class="mb-0 fs-12">{{ (summary.description) ? summary.description : '-'}}</h5>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="col-md-12 mt-2 mb-n4" v-if="summary.analyses">
                <div class="card bg-light-subtle shadow-none border">
                    <div class="card-header bg-light-subtle">
                        <div class="d-flex" style="margin-bottom: -18px;">
                            <div class="flex-shrink-0 me-3">
                                <div style="height:2rem;width:2rem;">
                                    <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                        <i class="ri-price-tag-2-fill text-primary fs-20"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-0 mt-n1 fs-12"><span class="text-body">List of Test Services</span></h5>
                                <p class="text-muted text-truncate-two-lines fs-11">Overview of services availed, including statuses and assignments.</p>
                            </div>
                            <div class="flex-shrink-0">
                              
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-white rounded-bottom">
                        <div class="table-responsive table-card rounded-bottom" style="max-height: 250px; overflow: auto;">
                            <table class="table align-middle table-nowraptable-centered">
                                <thead class="table-light thead-fixed">
                                    <tr class="fs-11">
                                        <th class="text-center" style="width: 7%">#</th>
                                        <th>Test Name</th>
                                        <th class="text-center" style="width: 20%;">Status</th>
                                    </tr>
                                </thead>
                                <tbody v-if="summary.analyses.length > 0">
                                    <tr v-for="(list,index) in summary.analyses" v-bind:key="index" 
                                    :class="list.status?.name === 'Cancelled' ? 'bg-danger-subtle' : 'bg-light-subtle'">
                                        <td class="text-center"> 
                                            {{index + 1}}
                                        </td>
                                        <td >
                                            <h5 class="fs-12 mb-0">{{list.testname}}</h5>
                                            <p class="fs-11 text-muted mb-0">{{list.method}}</p>
                                        </td>
                                        <td class="text-center">
                                            <span :class="'badge '+list.status.color+' '+list.status.others">{{list.status.name}}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
        
                </div>
            </div>
        </div>

    </b-modal>
</template>
<script>
export default {
    data(){
        return {
            showModal: false,
            summary: {
                category: {},
                sampletype: {},
                samplename: {}
            },
        }
    },
    methods: { 
        show(data){
            this.summary = data;
            this.showModal = true;
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>