<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 900px;" header-class="p-3 bg-light" title="View Order of Payment" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="row align-items-center g-3">
            <div class="col-md-12">
                <div>
                    <h6><span class="fw-semibold text-primary fs-14">{{selected.payorable.name}}</span></h6>
                    <div class="hstack gap-3 fs-12 flex-wrap mt-n1">
                        <div>
                            <span class="text-muted"><i class="ri-map-pin-fill me-1"></i></span> 
                            <span v-if="selected.payorable.address" class="fw-medium">{{selected.payorable.address}}</span>
                            <span v-else class="text-muted">Not Available</span>
                        </div>
                        <div class="vr" style="width: 1px;"></div>
                        <div><span class="text-muted"><i class="ri-calendar-2-fill me-1"></i></span> 
                            <span v-if="selected.date" class="fw-medium">{{selected.date}}</span>
                            <span v-else class="text-muted">Not Available</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-3 mt-n2 mb-n4">
            <div class="col-md-12 mt-0 mb-n3"><hr class="text-muted"/></div>
            <div class="row mt-0 g-3" v-if="selected">
                <div class="col-sm-3 mb-3">
                    <div class="p-1 border border-dashed rounded">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm me-0">
                                <div class="avatar-title rounded bg-transparent text-primary fs-18"><i class="ri-file-list-2-line"></i></div>
                            </div>
                            <div class="flex-grow-1" v-if="selected.or">
                                <p class="text-muted fs-11 mb-0">OR Number :</p>
                                <h5 class="fs-12 mb-0">{{selected.or.number}}</h5>
                            </div>
                            <div class="flex-grow-1" v-else>
                                <p class="text-muted fs-11 mb-0">Code :</p>
                                <h5 class="fs-12 mb-0">{{selected.code}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="p-1 border border-dashed rounded">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm me-0">
                                <div class="avatar-title rounded bg-transparent text-primary fs-18"><i class="ri-file-list-2-line"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted fs-11 mb-0">Payment :</p>
                                <h5 class="fs-12 mb-0">{{(selected.payment.name) ? selected.payment.name : 'Not Available'}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="p-1 border border-dashed rounded">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm me-0">
                                <div class="avatar-title rounded bg-transparent text-primary fs-18"><i class="ri-file-list-2-line"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted fs-11 mb-0">Collection :</p>
                                <h5 class="fs-12 mb-0">{{(selected.collection) ? selected.collection : 'Not Available'}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="p-1 border border-dashed rounded">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm me-0">
                                <div class="avatar-title rounded bg-transparent text-primary fs-18"><i class="ri-file-list-2-line"></i></div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted fs-11 mb-0">Status :</p>
                                <span :class="'badge '+selected.status.color+' '+selected.status.others">{{selected.status.name}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-n3 mb-n3"><hr class="text-muted"/></div>
            <div class="col-md-12">
                <div class="card bg-light-subtle shadow-none border">
                    <div class="card-header bg-light-subtle">
                        <div class="d-flex mb-n3">
                            <div class="flex-shrink-0 me-3">
                                <div style="height:2.2rem;width:2.2rem;">
                                    <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                        <i v-if="info" :class="info.icon+' text-primary fs-24'"></i>
                                        <i v-else class="ri-file-list-fill text-primary fs-24"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-0 fs-13">
                                    <span class="text-body">Technical Service Requests</span>
                                </h5>
                                <p class="text-muted text-truncate-two-lines fs-11">List of TSRs that are due for payment and awaiting settlement</p>
                            </div>
                            <div class="flex-shrink-0">
                             
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-white">
                        <div class="table-responsive table-card">
                            <table class="table table-nowrap align-middle mb-0">
                                <thead>
                                    <tr class="table-light fs-11">
                                        <th style="width: 50%;" class="text-center">TSR Number</th>
                                        <th style="width: 45%;" class="text-center">Total</th>
                                        <th style="width: 5%;" class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="fs-12" v-for="(list,index) in selected.items" v-bind:key="index">
                                        <td class="text-center">{{list.itemable.code}}</td>
                                        <td class="text-center">{{list.amount}}</td>
                                        <td>
                                           <b-button v-if="selected.status.name === 'Pending'" class="me-1" @click="openRemove(list,index)" variant="danger" v-b-tooltip.hover title="Remove" size="sm">
                                                <i class="ri-delete-bin-fill align-bottom"></i>
                                            </b-button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
            <b-button @click="openEdit(selected)" variant="primary" block>Update</b-button>
        </template>
    </b-modal>
    <Remove ref="remove"/>
    <Update :collections="dropdowns.collections" :payments="dropdowns.payments" @update="updateData" ref="update"/>
</template>
<script>
import Remove from './Remove.vue';
import Update from './Update.vue';
export default {
    components: { Update, Remove },
    props: ['dropdowns'],
    data(){
        return {
            currentUrl: window.location.origin,
            selected: {
                payorable: {},
                collection: {},
                payment: {},
                createdby: {
                    profile: {}
                },
                status: {},
                customer: {
                    customer_name: {},
                    address: {
                        barangay: {},
                        municipality: {},
                        province: {},
                        region: {}
                    }
                }
            },
            index: null,
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
        update(){
            this.$emit('update',true);
            this.showModal = false;
        },
        updateData(data){
            if(data !='Nothing found.'){
                this.selected.payment = data.payment;
                this.selected.collection = data.collection.name;
            }
        },
        openEdit(data){
            this.$refs.update.show(data);
        },
        openRemove(data){
            this.$refs.remove.show(data);
        }
    }
}
</script>