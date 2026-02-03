<template>
    <b-col lg="4">
        <div class="card bg-light-subtle shadow-none border">
        <div class="card-header bg-light-subtle">
            <div class="d-flex mb-n3">
                <div class="flex-shrink-0 me-3">
                    <div style="height:2.5rem;width:2.5rem;">
                        <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                            <i class="ri-information-fill text-primary fs-24"></i>
                        </span>
                    </div>
                </div>
                <div class="flex-grow-1">
                    <h5 class="mb-0 fs-14"><span class="text-body">Test Service Overview</span></h5>
                    <p class="text-muted text-truncate-two-lines fs-12">Summary of Test service configuration and status.</p>
                </div>
            </div>
        </div>
        <div class="card-body bg-white rounded-bottom border-bottom">
            <p class="mb-0 text-primary fs-12 fw-semibold">Service Details</p>
        </div>
        <div class="card bg-white rounded-bottom shadow-none mb-0" style="height: calc(100vh - 380px); overflow: auto;">
            <ul class="list-group list-group-flush border-dashed mb-n4 mt-n3 p-3">
                <li class="list-group-item px-0">
                    <div class="d-flex">
                        <div class="flex-shrink-0 avatar-xs">
                            <span class="avatar-title bg-light p-1 rounded-circle">
                                <i class="ri-function-fill text-primary"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0 fs-12">{{service.data.method.method.name}}</h6>
                            <p class="fs-11 mb-0 text-muted">Method</p>
                        </div>
                    </div>
                </li> 
                <li class="list-group-item px-0">
                    <div class="d-flex">
                        <div class="flex-shrink-0 avatar-xs">
                            <span class="avatar-title bg-light p-1 rounded-circle">
                                <i class="ri-file-paper-fill text-primary"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0 fs-12">{{service.data.method.method.short}}</h6>
                            <p class="fs-11 mb-0 text-muted">Short Method</p>
                        </div>
                    </div>
                </li> 
                <li class="list-group-item px-0">
                    <div class="d-flex">
                        <div class="flex-shrink-0 avatar-xs">
                            <span class="avatar-title bg-light p-1 rounded-circle">
                                <i class="ri-file-text-fill  text-primary"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0 fs-12">{{ service.data.method.reference.name }}</h6>
                            <p class="fs-11 mb-0 text-muted">Reference</p>
                        </div>
                    </div>
                </li>
                <li class="list-group-item px-0">
                    <div class="d-flex">
                        <div class="flex-shrink-0 avatar-xs">
                            <span class="avatar-title bg-light p-1 rounded-circle">
                                <i class="ri-price-tag-fill text-primary"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0 fs-12">{{ service.data.method.fee }}</h6>
                            <p class="fs-11 mb-0 text-muted">Fee</p>
                        </div>
                    </div>
                </li>
            </ul>
            <!-- <hr class="text-muted"/>
                <p class="ms-3 mb-0 text-primary fs-12 fw-semibold">Sample Types</p>
            <hr class="text-muted mb-1"/>
               <div class="d-flex flex-wrap gap-2 p-3 mb-n3">
                    <span v-if="service.data.samples.length > 0" class="badge bg-secondary" v-for="(list,index) in service.data.samples" v-bind:key="index">{{ list.sampleable.name }}</span>
                    <span v-else @click="addTag()" style="cursor: pointer;" class="badge bg-light text-dark">Add Tag now</span>
                </div> -->
            <hr class="text-muted"/>
                <p class="ms-3 mb-0 text-primary fs-12 fw-semibold">Status Details</p>
            <hr class="text-muted mb-1"/>
            <ul class="list-group list-group-flush border-dashed mb-n4 mt-n3 p-3">
                <li class="list-group-item px-0">
                    <div class="d-flex">
                        <div class="flex-shrink-0 avatar-xs">
                            <span class="avatar-title bg-light p-1 rounded-circle">
                                <i class="ri-information-fill" :class="service.data.status.others"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0 fs-12">{{service.data.status.name}}</h6>
                            <p class="fs-11 mb-0 text-muted">Status</p>
                        </div>
                    </div>
                </li> 
                <li class="list-group-item px-0">
                    <div class="d-flex">
                        <div class="flex-shrink-0 avatar-xs">
                            <span class="avatar-title bg-light p-1 rounded-circle">
                                <i v-if="service.data.is_active" class="ri-checkbox-circle-fill text-success"></i>
                                <i v-else class="ri-close-circle-fill text-danger"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0 fs-12">{{ (service.data.is_active) ? 'Available' : 'Not Available' }}</h6>
                            <p class="fs-11 mb-0 text-muted">Availability</p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    </b-col>
</template>
<script>
import simplebar from 'simplebar-vue';
export default {
    components : { simplebar },
    props: ['service'],
}
</script>