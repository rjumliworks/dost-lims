<template>
    <b-modal  v-if="selected" v-model="showModal"  style="--vz-modal-width: 1000px;" header-class="p-3 bg-light" title="View Equipment" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="row mb-3">
            <div class="col-md-9">
                <div class="row align-items-center g-3">
                    <div class="col-md">
                        <div>
                            <h6><span class="fw-semibold text-primary fs-15">{{ selected.name }}</span> <span class="text-muted fs-12"> - ({{ selected.code }})</span></h6>
                            <div class="hstack gap-3  fs-12 flex-wrap">
                                <div><i class="ri-calendar-line align-bottom me-1"></i> {{selected.acquired_at }} </div>
                                <div class="vr" style="width: 1px;"></div>
                                <div>Manufacturer : 
                                    <span v-if="selected.manufacturer" class="fw-medium"> {{ selected.manufacturer }}</span>
                                    <span v-else class="text-muted">Not Available</span>
                                </div>
                                <div class="vr" style="width: 1px;"></div>
                                <div>Model : 
                                    <span v-if="selected.model" class="fw-medium">{{selected.model}}</span>
                                    <span v-else class="text-muted">Not Available</span>
                                </div>
                                <div class="vr" style="width: 1px;"></div>
                                <div>Serial No. : 
                                    <span v-if="selected.serial_no" class="fw-medium">{{selected.serial_no}}</span>
                                    <span v-else class="text-muted">Not Available</span>
                                </div>
                                <div class="vr" style="width: 1px;"></div>
                                <div>Price : <span class="fw-medium">{{selected.price}}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="hstack gap-1 mt-n2 mb-n2 flex-wrap">
                    <div class="row g-1 text-end"  v-if="selected.status.name == 'Operational'">
                        <div class="col-md-12">
                            <b-button @click="openView(selected.id,selected.calibration_program,selected.calibration_due,'Calibration')" pill variant="primary" class="btn-label btn-sm waves-effect waves-light fs-11" style="width: 180px;">
                                <i class="ri-equalizer-line label-icon align-middle rounded-pill fs-12 me-2"></i> Perform Calibration
                            </b-button>
                        </div>
                        <div class="col-md-12">
                            <b-button @click="openView(selected.id,selected.maintenance_plan,selected.calibration_due,'Maintenance')" pill variant="primary" class="btn-label btn-sm waves-effect waves-light fs-11" style="width: 180px;">
                                <i class="ri-tools-fill label-icon align-middle rounded-pill fs-12 me-2"></i> Perform Maintenance
                            </b-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="text-muted"/>
        <div class="row mt-2">
            <div class="col-sm-6 col-lg-3">
                <div class="p-1 border border-dashed rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-2">
                            <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-calendar-line"></i></div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-0 fs-12">Last Calibration:</p>
                            <h5 class="mb-0 fs-13">{{(selected.calibration_program != 'Not Applicable') ? selected.last_calibration : selected.calibration_program}}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="p-1 border border-dashed rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-2">
                            <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-calendar-line"></i></div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-0 fs-12">Calibration Due :</p>
                           <h5 class="mb-0 fs-13">{{(selected.calibration_program != 'Not Applicable') ? selected.calibration_due : selected.calibration_program}}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="p-1 border border-dashed rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-2">
                            <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-calendar-line"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-0 fs-12">Last Maintenance :</p>
                            <h5 class="mb-0 fs-13">{{selected.last_maintenance}}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="p-1 border border-dashed rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-2">
                            <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-calendar-line"></i></div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-0 fs-12">Maintenance Due :</p>
                            <h5 class="mb-0 fs-13">{{selected.maintenance_due}}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="text-muted"/>
        <div v-if="selected.logs == 0" class="alert alert-danger alert-dismissible bg-warning text-white alert-label-icon mb-xl-0 fs-11" role="alert">
            <i class="ri-error-warning-line label-icon"></i>If no record exists, schedule a maintenance or calibration session to ensure the equipment meets operational and safety standards.
        </div>
        <hr v-if="selected.logs == 0" class="text-muted"/>
        <div class="table-responsive mt-2 mb-2">
            <simplebar data-simplebar style="max-height: 200px;">
                <table class="table table-bordered table-nowrap align-middle mb-0">
                    <thead class="table-primary thead-fixed">
                        <tr class="fs-11">
                            <th colspan="5" class="text-center text-primary">Calibration / Maintance Logs</th>
                        </tr>
                    </thead>
                    <thead class="table-light thead-fixed">
                        <tr class="fs-11">
                            <th style="width: 15%;" class="text-center">Type</th>
                            <th style="width: 15%;" class="text-center">Date</th>
                            <th style="width: 30%;" class="text-center">User</th>
                            <th style="width: 40%;" class="text-center">Note</th>
                            <th style="width: 5%;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="fs-11" v-for="(list,index) in selected.logs" v-bind:key="index">
                            <td class="text-center">
                                <span v-if="list.is_calibrated == 1" class="badge bg-success">Calibration</span>
                                <span v-else class="badge bg-danger">Maintenance</span>
                            </td>
                            <td class="text-center">{{ list.date }}</td>
                            <td class="text-center">{{ list.name }}</td>
                            <td class="text-center">{{ (list.note) ? list.note : 'n/a' }}</td>
                            <td>
                                <b-button  @click="openEdit(list,index)" variant="soft-warning" v-b-tooltip.hover title="Edit" size="sm">
                                    <i class="ri-delete-bin-fill align-bottom"></i>
                                </b-button>
                            </td>
                        </tr>
                        <tr v-if="selected.logs.length == 0">
                            <td colspan="4" class="text-center text-muted fs-10">
                                No records found. There are no logs available for the calibration or maintenance of the equipment.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </simplebar>
        </div>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
            <b-button v-if="selected.status.name == 'Not in Use'" @click="submit(35)" variant="success" :disabled="form.processing" block>Mark as Operational</b-button>
            <b-button v-if="selected.status.name == 'Operational'" @click="submit(37)" variant="warning" :disabled="form.processing" block>Mark as Not in Use</b-button>
            <b-button v-if="selected.status.name == 'Operational' || selected.status.name == 'Not in Use'" @click="submit(36)" variant="danger" :disabled="form.processing" block>Mark as Disposed</b-button>
        </template>
    </b-modal>
    <Perform @update="updateData" ref="perform"/>
    <Edit ref="edit"/>
</template>
<script>
import Edit from './Edit.vue';
import { useForm } from '@inertiajs/vue3';
import Perform from './Perform.vue';
import simplebar from "simplebar-vue";
export default {
    components : { simplebar, Perform, Edit }, 
    data(){
        return {
            currentUrl: window.location.origin,
            showModal: false,
            selected: null,
            form: useForm({
                id: null,
                status_id: null,
                option: 'status'
            }),
            index: null
        }
    },
    methods: { 
        show(data){
            this.selected = data;
            this.form.id = data.id;
            this.showModal = true;
        },
        openView(id,duration,date,type){
            this.$refs.perform.show(id,duration,date,type);
        },
        submit(id){
            this.form.status_id = id;
            this.form.put('/equipments/update',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.form.reset();
                    this.$emit('success',response.props.flash.data);
                    this.hide();
                }
            });
        },
        openEdit(data,index){
            this.index = index;
            this.$refs.edit.show(data.id);
        },
        updateData(data){
            this.selected = data;
            this.$emit('update',data);
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>