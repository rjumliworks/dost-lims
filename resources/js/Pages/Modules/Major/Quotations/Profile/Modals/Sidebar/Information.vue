<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 600px;" title="View more Information" class="v-modal-custom"  header-class="p-3 bg-light" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="card-body">
            <table class="table table-bordered mb-0">
                <tbody>
                    <tr> 
                        <td style="border-right: none; border-left: none; cursor: pointer;"><span class="fw-semibold fs-13 text-primary ms-2">Customer Information</span></td>
                    </tr>
                    <tr>
                        <td style="border-right: none; border-left: none;">
                            <div class="row ms-n2 mb-0">
                                <div class="col-md-12">
                                    <div class="d-flex mt-0 mb-3">
                                        <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                            <div class="avatar-title bg-light rounded-circle fs-16 text-primary"><i class="ri-user-3-fill"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="mb-1 fs-12 text-muted">Name :</p> 
                                            <h6 class="text-truncate mb-0 fs-12">
                                                <span class="fw-semibold" >{{selected.customer.name}}</span>
                                            </h6>
                                        </div>
                                    </div>
                                </div>        
                                <div class="col-md-12">
                                    <div class="d-flex mt-0 mb-3">
                                        <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                            <div class="avatar-title bg-light rounded-circle fs-16 text-primary"><i class="ri-map-pin-fill"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="mb-1 fs-12 text-muted">Address :</p> 
                                            <h6 class="text-truncate mb-0 fs-12">
                                                <span class="fw-semibold" >{{selected.customer.address.name}}</span>
                                            </h6>
                                        </div>
                                    </div>
                                </div>  
                                <div class="col-md-12">
                                    <div class="d-flex mt-0 mb-3">
                                        <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                            <div class="avatar-title bg-light rounded-circle fs-16 text-primary"><i class="ri-phone-fill"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="mb-1 fs-12 text-muted">Contact no. :</p> 
                                            <h6 class="text-truncate mb-0 fs-12">
                                                <span class="fw-semibold" >{{selected.customer.contact_no}}</span>
                                            </h6>
                                        </div>
                                    </div>
                                </div>     
                                <div class="col-md-12">
                                    <div class="d-flex mt-0 mb-3">
                                        <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                            <div class="avatar-title bg-light rounded-circle fs-16 text-primary"><i class="ri-mail-fill "></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="mb-1 fs-12 text-muted">Email Address :</p> 
                                            <h6 class="text-truncate mb-0 fs-12">
                                                <span class="fw-semibold" >{{selected.customer.email}}</span>
                                            </h6>
                                        </div>
                                    </div>
                                </div>                      
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="border-right: none; border-left: none;"><span class="fw-semibold fs-13 text-primary ms-2">Conforme Information</span></td>
                    </tr>
                    <tr>
                        <td style="border-right: none; border-left: none;">
                            <div class="row ms-n2 mb-0">
                                <div class="col-md-6">
                                    <div class="d-flex mt-0">
                                        <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                            <div class="avatar-title bg-light rounded-circle fs-16 text-primary"><i class="ri-account-circle-line"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="mb-1 fs-12 text-muted">Name :</p> 
                                            <h6 class="text-truncate mb-0 fs-12">{{selected.conforme}}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex mt-0">
                                        <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                            <div class="avatar-title bg-light rounded-circle fs-16 text-primary"><i class="ri-phone-line "></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="mb-1 fs-12 text-muted">Contact no. :</p>
                                            <h6 class="text-truncate mb-0"> <span class="fs-12">{{selected.conforme_no}}</span></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
        </template>
    </b-modal>
</template>
<script>
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            selected: {
                status:{}, service:{ service: {}},
                laboratory: {},
                payment: { discounted: {}},
                customer: { address: {}}
            },
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
        }
    }
}
</script>