<template>
    <b-modal  v-if="selected" v-model="showModal" style="--vz-modal-width: 650px;" header-class="p-3 bg-light" title="View Analysis" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="alert alert-dismissible alert-label-icon label-arrow fade show material-shadow fs-15" 
        :class="{
            'alert-warning': selected.status.name === 'Pending',
            'alert-primary': selected.status.name === 'Ongoing',
            'alert-success': selected.status.name === 'Completed',
            'alert-danger': selected.status.name === 'Cancelled'
        }" role="alert">
            <i :class="statusAlert.icon + ' label-icon'"></i>
            <strong>{{ selected.testname }}</strong>
        </div>
        <div class="card bg-light-subtle border-1 rounded-bottom shadow-none mb-0 p-3">
            <form class="customform">
                <div class="row g-2 mt-0 mb-1">
                    <div class="col-sm-12">
                        <div class="p-1 border border-dashed bg-white rounded">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2">
                                    <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-user-2-fill"></i></div>
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
                                    <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-map-pin-fill"></i></div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-0 fs-12">Reference :</p>
                                    <h5 class="mb-0 fs-12">{{ selected.reference }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card bg-light-subtle border-1 rounded-bottom shadow-none mb-0 mt-3 p-3">
            <form class="customform">
                <div class="row g-2 mt-0 mb-1">
                    <div class="col-sm-12">
                        <div class="p-1 border border-dashed bg-white rounded">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2">
                                    <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-user-2-fill"></i></div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-0 fs-12">Analyst :</p>
                                    <h5 class="mb-0 fs-12">{{ (selected.analyst) ? selected.analyst : '-'}}</h5>
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
            </form>
        </div>
        
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
            <b-button v-if="status == 'Ongoing' && selected.status.name == 'Pending' && selected.is_refunded == 0" @click="openCancel(selected,'refund')" variant="success" block>Refund</b-button>
            <b-button v-if="status == 'Ongoing' && selected.status.name == 'Pending' && selected.is_refunded == 0" @click="openCancel(selected,'cancel')" variant="danger" block>Cancel</b-button>
        </template>
    </b-modal>
</template>
<script>
import simplebar from "simplebar-vue";
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    props: ['status','customer','id'],
    components : { InputLabel, TextInput, simplebar }, 
    data(){
        return {
            currentUrl: window.location.origin,
            showModal: false,
            selected: {
                analyses: [],
                lists: [],
                report: {},
                status: {}
            }
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
        show(data){
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
        openCancel(data,type){
            this.$refs.cancel.show(data,this.customer,this.id,type);
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>