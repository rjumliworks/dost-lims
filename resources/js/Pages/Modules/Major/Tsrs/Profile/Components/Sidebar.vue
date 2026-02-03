<template>

    <table class="table table-bordered">
        <tbody>
            <tr>
                <td style="border-right: none; border-left: none; cursor: pointer;" @click="openInformation()"><span class="fw-semibold fs-12 ms-2">TSR Information</span></td>
            </tr>
            <tr>
                <td style="border-right: none; border-left: none;">
                    <div class="row ms-n2 mb-0">
                        <div class="col-md-12">
                            <div class="d-flex mt-0">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary"><i class="ri-qr-code-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden" v-if="selected.code">
                                    <p class="mb-1 fs-12 text-muted">Code :</p> 
                                    <h6 class="text-truncate mb-0 fs-12">
                                        <span class="fw-semibold" v-if="selected.code">{{selected.code}}</span>
                                        <span class="text-muted" v-else>Not yet Available</span>
                                    </h6>
                                </div>
                                <div class="flex-grow-1 overflow-hidden" v-else>
                                    <p class="mb-1 fs-12 text-muted">Laboratory :</p> 
                                    <h6 class="text-truncate mb-0 fs-12">
                                        <span class="fw-semibold">{{selected.laboratory.name}}</span>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex mt-3">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary"><i class="ri-service-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="mb-1 fs-12 text-muted">Current Status :</p> 
                                    <span :class="'badge '+selected.status.color">{{selected.status.name}}</span>
                                </div>
                            </div>
                        </div>
                       
                        <div class="col-md-12">
                            <div class="d-flex mt-3">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary"><i class="ri-calendar-event-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="mb-1 fs-12 text-muted">Due Date :</p>
                                    <h6 class="text-truncate mb-0 fs-12" v-if="selected.due_at">{{selected.due_at}}</h6>
                                    <h6 class="text-warning mb-0 fs-12" v-else>Not yet set</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="border-right: none; border-left: none;"><span class="fw-semibold fs-12 ms-2">Received Information</span></td>
            </tr>
            <tr>
                <td style="border-right: none; border-left: none;">
                    <div class="row ms-n2 mb-0">
                        <div class="col-md-12">
                            <div class="d-flex mt-0">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary"><i class="ri-calendar-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="mb-1 fs-12 text-muted">Date Requested :</p> 
                                    <h6 class="text-truncate mb-0 fs-12">{{selected.created_at}}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex mt-3">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary"><i class="ri-hotel-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="mb-1 fs-12 text-muted">Received At :</p>
                                    <h6 class="text-truncate mb-0"> <span class="fs-12">{{selected.facility.name}}</span></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex mt-3">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary"><i class="ri-account-circle-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="mb-1 fs-12 text-muted">Received By :</p>
                                    <h6 class="text-truncate mb-0"> <span class="fs-12">{{selected.received}}</span></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="border-right: none; border-left: none;"><span class="fw-semibold fs-12 ms-2">Other Information</span></td>
            </tr>
            <tr>
                <td style="border-right: none; border-left: none;">
                    <div class="row ms-n2 mb-0">
                        <div class="col-md-12">
                            <div class="d-flex">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary"><i class="ri-price-tag-3-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="mb-1 fs-12 text-muted">Discount :</p> 
                                    <h6 class="text-truncate mb-0 fs-12">
                                        <span >{{selected.payment.discounted.name}} ({{selected.payment.discounted.value }}%)</span>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex mt-3">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary"><i class="ri-calendar-line"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="mb-1 fs-12 text-muted">Purpose of Request :</p>
                                    <h6 class="text-truncate mb-0 fs-12" v-if="selected.purpose">{{selected.purpose.name}}</h6>
                                    <h6 class="text-warning mb-0 fs-12" v-else>Not Available</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr v-if="selected.services.length > 0">
                <td style="border-right: none; border-left: none; cursor: pointer;" @click="openService()">
                    <span class="fw-semibold fs-12 ms-2">Add-ons</span>
                    <i class="ri-information-fill fs-20 mb-n2 mt-n1 text-primary float-end" style="cursor: pointer;"></i>
                </td>
            </tr>
            <tr v-if="selected.referral">
                <td style="border-right: none; border-left: none; cursor: pointer;" @click="openReferral()">
                    <span class="fw-semibold fs-12 ms-2">Referral Information</span>
                    <i class="ri-information-fill fs-20 mb-n2 mt-n1 text-primary float-end" style="cursor: pointer;"></i>
                </td>
            </tr>
            <!-- <tr v-if="selected.service">
                <td style="border-right: none; border-left: none;">
                    <div v-if="selected.service" class="alert alert-warning fs-12 mb-0" role="alert">
                        <span class="fw-semibold">{{selected.service.service.name}}</span> ({{ selected.service.quantity }} {{ (selected.service.quantity > 1) ? 'days' : 'day' }})
                        <br />
                        <span class="fs-11 text-muted">({{selected.service.service.description}})</span>
                    </div>
                </td>
            </tr> -->
            <tr>
                <td style="border-right: none; border-left: none; cursor: pointer;" @click="openPayment()">
                    <span class="fw-semibold fs-12 ms-2">Payment Information</span>
                    <span class="float-end text-muted">{{selected.payment.total}}</span>
                    <!-- <i v-if="selected.payment.status.name == 'Paid'" class="ri-checkbox-circle-fill fs-20 mb-n2 mt-n1 text-success float-end"></i>
                    <i v-else class="ri-close-circle-fill fs-20 mb-n2 mt-n1 text-danger float-end"></i> -->
                </td>
            </tr>
        </tbody>
    </table>
    <Payment ref="payment"/>
    <Service ref="service"/>
    <Referral ref="referral"/>
    <Information ref="information"/>
</template>
<script>
import Payment from '../Modals/Sidebar/Payment.vue';
import Service from '../Modals/Sidebar/Service.vue';
import Referral from '../Modals/Sidebar/Referral.vue';
import Information from '../Modals/Sidebar/Information.vue';
export default {
    components: { Payment, Service, Referral, Information },
    props: ['selected','total'],
    methods: {
        openPayment(){
            this.$refs.payment.show(this.selected.payment,this.selected.services,this.total);
        },
        openService(){
            this.$refs.service.show(this.selected.services,this.selected.status,this.selected.id);
        },
        openReferral(){
            this.$refs.referral.show(this.selected.referral);
        },
        openInformation(){
            this.$refs.information.show(this.selected);
        }
    }
}
</script>