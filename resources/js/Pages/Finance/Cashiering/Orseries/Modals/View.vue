<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 600px;" header-class="p-3 bg-light" title="OR Series Details" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="row align-items-center g-3">
            <div class="col-md-12" v-if="selected">
                <div>
                    <h6><span class="fw-semibold text-primary fs-16">{{selected.name}}</span></h6>
                    <div class="hstack gap-3 fs-13 flex-wrap mt-0">
                        <div>
                            <span class="text-muted"><i class="ri-user-fill me-1"></i></span> 
                            <span class="fw-medium">{{selected.user.profile.fullname}}</span>
                        </div>
                        <div class="vr" style="width: 1px;"></div>
                        <div><span class="text-muted"><i class="ri-calendar-2-fill me-1"></i></span> 
                            <span class="fw-medium">{{selected.created_at}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-3 mt-n2 mb-n4">
            <div class="col-md-12 mt-0 mb-n3"><hr class="text-muted"/></div>
            <div class="col-md-12">
                <div class="row mt-n3 g-3" v-if="selected">
                    <div class="col-sm-4 mb-3">
                        <div class="p-1 border border-dashed rounded">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-0">
                                    <div class="avatar-title rounded bg-transparent text-primary fs-18"><i class="ri-file-list-2-line"></i></div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted fs-13 mb-0">Start :</p>
                                    <h5 class="fs-14 mb-0">{{selected.start}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <div class="p-1 border border-dashed rounded">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-0">
                                    <div class="avatar-title rounded bg-transparent text-primary fs-18"><i class="ri-file-list-2-line"></i></div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted fs-13 mb-0">Next :</p>
                                    <h5 class="fs-14 mb-0">{{selected.next}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <div class="p-1 border border-dashed rounded">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-0">
                                    <div class="avatar-title rounded bg-transparent text-primary fs-18"><i class="ri-file-list-2-line"></i></div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted fs-13 mb-0">End :</p>
                                    <h5 class="fs-14 mb-0">{{selected.end}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-n3"><hr class="text-muted"/></div>
            <div class="col-md-12 mt-0" v-if="selected.is_finished">
                <div class="alert alert-dark alert-dismissible alert-label-icon label-arrow fade show material-shadow" role="alert">
                    <i class="ri-error-warning-line label-icon"></i><strong>Danger</strong> - The current Official Receipt series is finished.
                </div>
            </div>
            <div class="col-md-12 mt-0" v-if="selected.is_active">
                <div class="alert alert-warning alert-dismissible alert-label-icon label-arrow fade show material-shadow fs-12" role="alert">
                    <i class="ri-error-warning-line label-icon"></i>The Receipt series is active. Receipts are being issued from this series.
                </div>
            </div>
            <div class="col-md-12 mt-0" v-if="!selected.is_active && !selected.is_finished">
                <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show material-shadow fs-12" role="alert">
                    <i class="ri-error-warning-line label-icon"></i>This Official Receipt series is inactive and not currently in use.
                </div>
            </div>
        </div>
        
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
            <b-button v-if="selected.next == selected.end && !selected.is_finished" variant="primary" :disabled="form.processing" block>Mark as Finished</b-button>
        </template>
    </b-modal>
</template>
<script>
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            selected: {
               user: { profile: {}}
            },
            form: {},
            showModal: false
        }
    },
    methods: { 
        show(data){
            this.selected = data;
            this.showModal = true;
        },
        hide(){
            this.showModal = false;
        },
        openOr(){
            this.$refs.or.show(this.selected.customer,this.selected);
        },
        update(){
            this.$emit('update',true);
            this.showModal = false;
        }
    }
}
</script>