<template>
    <b-col lg="3">
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
                    <h5 class="mb-0 fs-14"><span class="text-body">Equipment Overview</span></h5>
                    <p class="text-muted text-truncate-two-lines fs-12">Item details </p>
                </div>
            </div>
        </div>
        <div class="card-body bg-white rounded-bottom border-bottom">
            <p class="mb-0 text-primary fs-12 fw-semibold">Calibration Information</p>
        </div>
        <div class="card bg-white rounded-bottom shadow-none mb-0" style="height: calc(100vh - 405px); overflow: auto;">
            <ul class="list-group list-group-flush border-dashed mb-n4 mt-n2 p-3">
                <li class="list-group-item px-0">
                    <div class="d-flex">
                        <div class="flex-shrink-0 avatar-xs">
                            <span class="avatar-title bg-light p-1 rounded-circle">
                                <i class="ri-calendar-2-fill text-success fs-17"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0 fs-12">{{equipment.calibration_due}}</h6>
                            <p class="fs-11 mb-0 text-muted">Calibration Due</p>
                        </div>
                    </div>
                </li>
                 <li class="list-group-item px-0">
                    <div class="d-flex">
                        <div class="flex-shrink-0 avatar-xs">
                            <span class="avatar-title bg-light p-1 rounded-circle">
                                <i class="ri-calendar-2-fill text-purple fs-17"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0 fs-12">{{ equipment.last_calibration}}</h6>
                            <p class="fs-11 mb-0 text-muted">Last Calibration</p>
                        </div>
                    </div>
                </li>
                <li class="list-group-item px-0">
                    <div class="d-flex">
                        <div class="flex-shrink-0 avatar-xs">
                            <span class="avatar-title bg-light p-1 rounded-circle">
                                <i class="ri-error-warning-fill text-warning fs-17"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0 fs-12">{{equipment.calibration_program }}</h6>
                            <p class="fs-11 mb-0 text-muted">Calibration Program</p>
                        </div>
                    </div>
                </li>
            </ul>
            <hr class="text-muted"/>
                <p class="ms-3 mb-0 text-primary fs-12 fw-semibold">Maintenance Information</p>
            <hr class="text-muted mb-1"/>
            <ul class="list-group list-group-flush border-dashed mb-n4 mt-n2 p-3">
                <li class="list-group-item px-0">
                    <div class="d-flex">
                        <div class="flex-shrink-0 avatar-xs">
                            <span class="avatar-title bg-light p-1 rounded-circle">
                                <i class="ri-calendar-2-fill text-success fs-17"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0 fs-12">{{equipment.maintenance_due}}</h6>
                            <p class="fs-11 mb-0 text-muted">Maintenance Due</p>
                        </div>
                    </div>
                </li>
                 <li class="list-group-item px-0">
                    <div class="d-flex">
                        <div class="flex-shrink-0 avatar-xs">
                            <span class="avatar-title bg-light p-1 rounded-circle">
                                <i class="ri-calendar-2-fill text-purple fs-17"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0 fs-12">{{ equipment.last_maintenance}}</h6>
                            <p class="fs-11 mb-0 text-muted">Last Maintenance</p>
                        </div>
                    </div>
                </li>
                <li class="list-group-item px-0">
                    <div class="d-flex">
                        <div class="flex-shrink-0 avatar-xs">
                            <span class="avatar-title bg-light p-1 rounded-circle">
                                <i class="ri-error-warning-fill text-warning fs-17"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0 fs-12">{{equipment.maintenance_plan }}</h6>
                            <p class="fs-11 mb-0 text-muted">Maintenance Program</p>
                        </div>
                    </div>
                </li>
            </ul>
            <!-- <ul class="list-group list-group-flush border-dashed mb-n4 mt-n2 p-3">
                <li class="list-group-item px-0">
                    <div class="d-flex">
                        <div class="flex-shrink-0 avatar-xs">
                            <span class="avatar-title bg-light p-1 rounded-circle">
                                <i class="ri-stack-line text-success fs-17"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0 fs-12">{{item.category }}</h6>
                            <p class="fs-11 mb-0 text-muted">Category</p>
                        </div>
                    </div>
                </li>
                 <li class="list-group-item px-0">
                    <div class="d-flex">
                        <div class="flex-shrink-0 avatar-xs">
                            <span class="avatar-title bg-light p-1 rounded-circle">
                                <i class="ri-flask-fill text-purple fs-17"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0 fs-12">{{item.laboratory}}</h6>
                            <p class="fs-11 mb-0 text-muted">Laboratory</p>
                        </div>
                    </div>
                </li>
            </ul> -->
        </div>
    </div>
    </b-col>
</template>
<script>
import simplebar from 'simplebar-vue';
export default {
    components : { simplebar },
    props: ['equipment'],
    data(){
        return {
            currentUrl: window.location.origin,
        }
    },
}
</script>