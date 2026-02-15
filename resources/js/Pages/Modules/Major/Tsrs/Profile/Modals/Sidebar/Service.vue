<template>
    <b-modal v-model="showModal" hide-footer style="--vz-modal-width: 750px;" title="Additional Services" class="v-modal-custom"  header-class="p-3 bg-light" modal-class="zoomIn" centered no-close-on-backdrop>
        <BRow class="mb-1">
            <BCol lg="12" class="mt-1">
                <div class="alert alert-warning alert-dismissible alert-label-icon label-arrow fade show material-shadow fs-11 lh-sm" role="alert">
                    <i class="ri-alert-line label-icon"></i><strong>Additional Service Notice</strong> <br/> This service is not included in the standard test services provided by the laboratory. Any fees associated with this service will be charged separately and must be paid by the customer in addition to the regular test service fees. Please review the details carefully before proceeding.
                    <button type="button" class="btn-close" data-bs-dismiss=" alert" aria-label="Close"></button>
                </div>
            </BCol>
            <div class="col-md-12 mt-0 mb-n3">
                <div class="card bg-light-subtle shadow-none border">
                    <div class="card-header bg-light-subtle">
                        <div class="d-flex" style="margin-bottom: -18px;">
                            <div class="flex-shrink-0 me-3">
                                <div style="height:2rem;width:2rem;">
                                    <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                        <i class="ri-price-tag-2-fill text-primary fs-20"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-0 mt-n1 fs-12"><span class="text-body">List of Additional Services</span></h5>
                                <p class="text-muted text-truncate-two-lines fs-11">Tracks attendance times and logs any changes for accurate records.</p>
                            </div>
                            <div class="flex-shrink-0">
                                <BButton @click="addAddons()" variant="danger" class="btn-sm waves-effect waves-light" style="margin-top: -1px;">
                                    <i class="ri-add-circle-fill search-icon me-1"></i> Add-ons
                                </BButton>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-white rounded-bottom">
                        <div class="table-responsive table-card">
                            <table class="table align-middle table-centered table-striped mb-0">
                                <thead class="table-light thead-fixed">
                                    <tr class="fs-11">
                                        <th>Addons</th>
                                        <th class="text-center" style="width: 10%;">Days</th>
                                        <th class="text-center" style="width: 15%;">Fee</th>
                                        <th class="text-center" style="width: 15%;">Total</th>
                                        <th  style="width: 7%;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="fs-12" v-for="(list,index) in lists" v-bind:key="index">
                                        <td>
                                            <h5 class="fs-12 mb-0"> {{list.service.name}}</h5>
                                            <p class="fs-11 text-muted mb-0">{{list.service.description}}</p>
                                        </td>
                                        <td class="text-center">{{ list.quantity }}</td>
                                        <td class="text-center">{{ list.fee }}</td>
                                        <td class="text-center">{{ list.total }}</td>
                                        <td class="text-end">
                                            <b-button v-if="selected.status.name == 'Pending' || selected.status.name == 'For Payment'" @click="openRemove(list)" variant="soft-danger" v-b-tooltip.hover title="Delete" size="sm">
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
        </BRow>
    </b-modal>
    <Service :services="services" ref="service"/>
    <Remove ref="remove"/>
</template>
<script>
import Service from '../Main/Service.vue';
import Remove from './Remove.vue';
export default {
    components: { Service, Remove },
    props: ['services','lists'],
    data(){
        return {
            tsr_id: null,
            selected: {
                status:{}
            },
            showModal: false
        }
    },
    methods: { 
        show(status,tsr){
            this.tsr_id = tsr;
            this.selected.status = status;
            this.showModal = true;
        },
        openRemove(data){
            this.$refs.remove.show(data,this.tsr_id);
        },
        addAddons(){
            console.log(this.tsr_id);
            this.$refs.service.show(this.tsr_id);
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>