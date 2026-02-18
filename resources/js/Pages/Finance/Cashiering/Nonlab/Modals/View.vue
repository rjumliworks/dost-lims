<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 800px;" header-class="p-3 bg-light" title="View Order of Payment" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="row align-items-center g-3">
            <div class="col-md-12">
                <div>
                    <h6><span class="fw-semibold text-primary fs-14">{{selected.customer}}</span></h6>
                    <div class="hstack gap-3 fs-12 flex-wrap mt-n1">
                        <div>
                            <span class="text-muted"><i class="ri-user-fill me-1"></i></span> 
                            <span v-if="selected.created" class="fw-medium">{{selected.created}}</span>
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
            <div class="col-md-12">
                <div class="row mt-n3 g-3" v-if="selected">
                    <div class="col-sm-3" :class="(selected.detail) ? '' :'mb-3'">
                        <div class="p-1 border border-dashed rounded">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-0">
                                    <div class="avatar-title rounded bg-transparent text-primary fs-18"><i class="ri-file-list-2-line"></i></div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted fs-11 mb-0">OR Number :</p>
                                    <h5 class="fs-12 mb-0">{{selected.ornumber}}</h5>
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
                                    <h5 class="fs-12 mb-0">{{(selected.payment) ? selected.payment : 'Not Available'}}</h5>
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
                                    <p class="text-muted fs-11 mb-0">Total :</p>
                                    <h5 class="fs-12 mb-0">{{(selected.oramount) ?selected.oramount : 'Not Available'}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 mb-3" v-if="selected.detail">
                        <div class="p-1 border border-dashed rounded">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-0">
                                    <div class="avatar-title rounded bg-transparent text-primary fs-18"><i class="ri-bank-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted fs-11 mb-0">Bank Name :</p>
                                    <h5 class="fs-12 mb-0">{{(selected.detail) ? selected.detail.bank : 'Not Available'}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3" v-if="selected.detail">
                        <div class="p-1 border border-dashed rounded">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-0">
                                    <div class="avatar-title rounded bg-transparent text-primary fs-18"><i class="ri-hashtag"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted fs-11 mb-0">Account no. :</p>
                                    <h5 class="fs-12 mb-0">{{(selected.detail) ? selected.detail.number : 'Not Available'}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3" v-if="selected.detail">
                        <div class="p-1 border border-dashed rounded">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-0">
                                    <div class="avatar-title rounded bg-transparent text-primary fs-18"><i class="ri-hand-coin-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted fs-11 mb-0">Amount :</p>
                                    <h5 class="fs-12 mb-0">{{(selected.detail) ? selected.detail.amount : 'Not Available'}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3" v-if="selected.detail">
                        <div class="p-1 border border-dashed rounded">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-0">
                                    <div class="avatar-title rounded bg-transparent text-primary fs-18"><i class="ri-calendar-2-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted fs-11 mb-0">Date :</p>
                                    <h5 class="fs-12 mb-0">{{(selected.detail) ? selected.detail.date_at : 'Not Available'}}</h5>
                                </div>
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
                                    <span class="text-body">Order of payment Items</span>
                                </h5>
                                <p class="text-muted text-truncate-two-lines fs-11">These are items currently listed on the Order of Payment</p>
                            </div>
                            <div class="flex-shrink-0">
                                <b-button class="me-1" @click="openAdd(selected.id)" variant="soft-dark" v-b-tooltip.hover title="Add" size="sm">
                                    <i class="ri-add-circle-fill align-bottom"></i> Add Item
                                </b-button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-white">
                        <div class="table-responsive table-card">
                            <table class="table table-nowrap align-middle mb-0">
                                <thead>
                                    <tr class="table-light fs-11">
                                        <th style="width: 50%;" class="text-center">Item</th>
                                        <th style="width: 45%;" class="text-center">Total</th>
                                        <th style="width: 5%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="fs-12" v-for="(list,index) in selected.items" v-bind:key="index">
                                        <td class="text-center">{{list.itemable.name}}</td>
                                        <td class="text-center">{{list.amount}}</td>
                                        <td>
                                            <b-button @click="openEdit(list)" variant="warning" class="me-1" v-b-tooltip.hover title="Edit" size="sm">
                                                <i class="ri-pencil-fill align-bottom"></i>
                                            </b-button>
                                            <b-button class="me-1" @click="openRemove(list)" variant="danger" v-b-tooltip.hover title="Remove" size="sm">
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
        
        <!-- <h6 v-if="selected.detail" class="mb-n2 mt-4 text-muted fw-semibold">Bank Details :</h6>
        <hr v-if="selected.detail" class="text-muted"/>
        <div v-if="selected.detail" class="card-body text-center">
            <div class="row g-3">
                <div class="col-lg-3 col-6">
                    <p class="text-muted mb-2 fs-11 text-uppercase fw-semibold">Bank Name</p>
                    <h5 class="fs-12 mb-0"><span id="invoice-no">{{selected.detail.bank}}</span></h5>
                </div>
                <div class="col-lg-3 col-6">
                    <p class="text-muted mb-2 fs-11 text-uppercase fw-semibold">Account</p>
                    <h5 class="fs-12 mb-0"><span id="invoice-no">{{selected.detail.number}}</span></h5>
                </div>
                <div class="col-lg-3 col-6">
                    <p class="text-muted mb-2 fs-11 text-uppercase fw-semibold">Amount</p>
                     <h5 class="fs-12 mb-0"><span id="invoice-no">{{selected.detail.amount}}</span></h5>
                </div>
                <div class="col-lg-3 col-6">
                    <p class="text-muted mb-2 fs-11 text-uppercase fw-semibold">Date</p>
                    <h5 class="fs-12 mb-0">{{selected.detail.date_at}}</h5>
                </div>
            </div>
        </div> -->
        <hr v-if="selected.transaction" class="text-muted"/>
        <div v-if="selected.transaction" class="alert alert-primary alert-dismissible alert-label-icon label-arrow" role="alert">
            <i class="ri-wallet-3-fill label-icon"></i>
            An excess payment of <strong>{{selected.transaction.amount}}</strong> was added to the customer's wallet.
        </div>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
            <b-button v-if="selected.status.name == 'Pending'" @click="openOr" variant="primary" :disabled="form.processing" block>Create Receipt</b-button>
        </template>
    </b-modal>
    <Add @update="updateData" ref="add"/>
    <Edit @update="updateData" ref="edit"/>
    <Remove @update="updateData" ref="remove"/>
</template>
<script>
import Add from './Add.vue';
import Edit from './Edit.vue';
import Remove from './Remove.vue';
export default {
    components: { Edit, Remove, Add },
    data(){
        return {
            currentUrl: window.location.origin,
            selected: {
                collection: {},
                payment: {},
                payorable: {},
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
        openOr(){
            this.$refs.or.show(this.selected.customer,this.selected);
        },
        openAdd(id){
            this.$refs.add.show(id);
        },
        openEdit(data){
            this.$refs.edit.show(data);
        },
        openRemove(data){
            this.$refs.remove.show(data);
        },
        updateData(data){
            this.selected = data;
        }
    }
}
</script>