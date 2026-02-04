<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 650px;" hide-footer header-class="p-3 bg-light" title="View Sample" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div v-if="summary" class="card bg-light-subtle border-1 rounded-bottom shadow-none mb-0 p-3">
            <form class="customform">
                <div class="row g-2 mt-0 mb-1">
                    <div class="col-sm-12">
                        <div class="p-1 border border-dashed bg-white rounded">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2">
                                    <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-information-fill"></i></div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-0 fs-12">Sample Name :</p>
                                    <h5 class="mb-0 fs-12"> {{ summary.samplename.name }} </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-1 border border-dashed bg-white rounded">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2">
                                    <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-file-paper-2-fill"></i></div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-0 fs-12">Sample Type :</p>
                                    <h5 class="mb-0 fs-12">{{ summary.sampletype.name }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-1 border border-dashed bg-white rounded">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2">
                                    <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-file-list-fill"></i></div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-0 fs-12">Sample Category :</p>
                                    <h5 class="mb-0 fs-12">{{ summary.category.name }}</h5>
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
                    </div>
                </div>
            </form>
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
            }
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