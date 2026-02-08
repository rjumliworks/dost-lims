<template>
    <b-modal  v-if="selected" v-model="showModal" style="--vz-modal-width: 800px;" header-class="p-3 bg-light" title="View Analysis" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <!-- <div class="alert alert-dismissible alert-label-icon label-arrow fade show material-shadow fs-15" 
        :class="{
            'alert-warning': selected.status.name === 'Pending',
            'alert-primary': selected.status.name === 'Ongoing',
            'alert-success': selected.status.name === 'Completed',
            'alert-danger': selected.status.name === 'Cancelled'
        }" role="alert">
            <i :class="statusAlert.icon + ' label-icon'"></i>
            <strong>{{ selected.testname }}</strong>
        </div> -->
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="row align-items-center g-3">
                    <div class="col-md">
                        <div>
                            <h6><span class="fw-semibold text-primary fs-15">{{ selected.testname }}</span></h6>
                            <div class="hstack gap-3  fs-12 flex-wrap">
                                <div><i class="ri-hashtag align-bottom me-1"></i> {{ (selected.code) ? selected.code : 'Not yet set' }} </div>
                                <div class="vr" style="width: 1px;"></div>
                                <div><i class="ri-calendar-line align-bottom me-1"></i> Date Added : 
                                    <span class="fw-medium"> {{ selected.created_at }}</span>
                                </div>
                                <div class="vr" style="width: 1px;"></div>
                                <div>Status : 
                                    <span :class="'ms-1 fs-11 badge '+selected.status.color+' '+selected.status.others">{{selected.status.name}}</span>
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
       
        <div class="row g-2 mt-0 mb-1">
            <div class="col-sm-12">
                <hr class="text-muted mt-n2 mb-2"/>
            </div>
            <div class="col-sm-12">
                <div class="p-1 border border-dashed bg-white rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-2">
                            <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="bx bx-test-tube"></i></div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-0 fs-12">Method :</p>
                            <h5 class="mb-0 fs-12">{{selected.method }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="p-1 border border-dashed bg-white rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-2">
                            <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="bx bx-detail"></i></div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-0 fs-12">Reference :</p>
                            <h5 class="mb-0 fs-12">{{ selected.reference }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <hr class="text-muted mt-2 mb-2"/>
            </div>
        </div>

        <div class="row g-2 mt-n1 mb-1" v-if="selected.status.name != 'Pending'">
            <div class="col-sm-6">
                <div class="p-1 border border-dashed bg-white rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-2">
                            <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-calendar-2-fill"></i></div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-0 fs-12">Start Date :</p>
                            <h5 class="mb-0 fs-12">{{(selected.start_at) ? selected.start_at : '-'}}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="p-1 border border-dashed bg-white rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-2">
                            <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-calendar-2-fill"></i></div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-0 fs-12">End Date :</p>
                            <h5 class="mb-0 fs-12">{{(selected.end_at) ? selected.end_at : '-'}}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive mt-2 mb-2" v-if="selected.status.name == 'Pending' && selected.addfee.length > 0">
            <simplebar data-simplebar style="max-height: 200px;">
                <table class="table table-bordered table-nowrap align-middle mb-0">
                    <thead class="table-primary thead-fixed">
                        <tr class="fs-11">
                            <th colspan="5" class="text-center text-primary">Additional Fees</th>
                        </tr>
                    </thead>
                    <thead class="table-light thead-fixed">
                        <tr class="fs-10">
                            <th>Service</th>
                            <th style="width: 20%;" class="text-center">Quantity</th>
                            <th style="width: 15%;" class="text-center">Total</th>
                            <th style="width: 5%;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="fs-11" v-for="(list,index) in selected.addfee" v-bind:key="index">
                            <td>
                                <h5 class="fs-11 mb-0 fw-semibold text-primary">{{list.service.name}}</h5>
                            </td>
                            <td class="text-center">{{list.fee}} x {{ list.quantity }}</td>
                            <td class="text-center">{{ list.total }}</td>
                            <td>
                                <b-button  @click="removeAdditional(list,index)" class="mt-n1 mb-n1" variant="soft-danger" v-b-tooltip.hover title="Remove Add-ons" size="sm">
                                    <i class="ri-delete-bin-fill align-bottom"></i>
                                </b-button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </simplebar>
        </div>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
            <b-button v-if="status == 'Ongoing' && selected.status.name == 'Pending' && selected.is_refunded == 0" @click="openCancel(selected,'refund')" variant="success" block>Refund</b-button>
            <b-button v-if="status == 'Ongoing' && selected.status.name == 'Pending' && selected.is_refunded == 0" @click="openCancel(selected,'cancel')" variant="danger" block>Cancel</b-button>
        </template>
    </b-modal>
    <AdditionalView @success="updateAdditional" ref="additionalview"/>
</template>
<script>
import simplebar from "simplebar-vue";
import AdditionalView from "./AdditionalRemove.vue";
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    props: ['status','customer','id'],
    components : { InputLabel, TextInput, simplebar, AdditionalView }, 
    data(){
        return {
            currentUrl: window.location.origin,
            showModal: false,
            selected: {
                analyses: [],
                lists: [],
                report: {},
                status: {}
            },
            id: null,
            index: null
        }
    },
    computed: {
        statusAlert() {
            switch (this.selected.status.name) {
            case 'Pending':
                return { class: 'alert-warning', icon: 'ri-question-fill' };
            case 'Ongoing':
                return { class: 'alert-primary', icon: 'ri-information-fill' };
            case 'Completed':
                return { class: 'alert-success', icon: 'ri-checkbox-circle-fill' };
            case 'Cancelled':
                return { class: 'alert-danger', icon: 'ri-close-circle-fill' };
            default:
                return { class: 'alert-secondary', icon: 'ri-alert-line' };
            }
        }
    },
    methods: { 
        show(data,id){
            this.id = id;
            this.selected = data;   
            this.showModal = true;
        },
        getRowClass(list, index) {
            if (list.selected) {
                return 'bg-warning-subtle';
            }
            if (list.status.name == 'Completed') {
                return 'bg-success-subtle';
            }
            return '';
        },
        printQr(id){
            window.open('/testreports?option=qrcode&id='+this.selected.qr);
        },
        removeAdditional(data,index){
            this.index = index;
            this.$refs.additionalview.show(data,this.id);
        },
        updateAdditional(){
            this.selected.addfee.splice(this.index, 1);
        },
        openCancel(data,type){
            this.$refs.cancel.show(data,this.customer,this.id,type);
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>