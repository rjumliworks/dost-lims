<template>

    <table class="table table-bordered">
        <tbody>
            <tr>
                <td style="border-right: none; border-left: none; cursor: pointer;" @click="openInformation()"><span class="fw-semibold fs-12 ms-2">TSR Information</span></td>
            </tr>
            <tr>
                <td style="border-right: none; border-left: none;">
                    <div class="row ms-n2 mb-0">
                        <div class="col-md-12 margin-space">
                            <div class="d-flex mt-0">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary">
                                        <i class="ri-qr-code-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden" v-if="selected.code">
                                    <p class="fs-12 text-muted margin-custom">Code :</p> 
                                    <h6 class="text-truncate mb-0 fs-12">
                                        <span class="fw-semibold" v-if="selected.code">{{selected.code}}</span>
                                        <span class="text-muted" v-else>Not yet Available</span>
                                    </h6>
                                </div>
                                <div class="flex-grow-1 overflow-hidden" v-else>
                                    <p class="margin-custom fs-12 text-muted">Laboratory :</p> 
                                    <h6 class="text-truncate mb-0 fs-12">
                                        <span class="fw-semibold">{{selected.laboratory.name}}</span>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 margin-space">
                            <div class="d-flex mt-3">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary"><i class="ri-service-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="margin-custom fs-12 text-muted">Current Status :</p> 
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
                                    <p class="margin-custom fs-12 text-muted">Due Date :</p>
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
                        <div class="col-md-12 margin-space">
                            <div class="d-flex mt-0">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary"><i class="ri-calendar-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="margin-custom fs-12 text-muted">Date Requested :</p> 
                                    <h6 class="text-truncate mb-0 fs-12">{{selected.created_at}}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 margin-space">
                            <div class="d-flex mt-3">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary"><i class="ri-information-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="margin-custom fs-12 text-muted">Purpose of Request :</p>
                                    <h6 class="text-truncate mb-0 fs-12" v-if="selected.purpose">{{selected.purpose.name}}</h6>
                                    <h6 class="text-warning mb-0 fs-12" v-else>Not Available</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 margin-space">
                            <div class="d-flex mt-3">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary"><i class="ri-hotel-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="margin-custom fs-12 text-muted">Received At :</p>
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
                                    <p class="margin-custom fs-12 text-muted">Received By :</p>
                                    <h6 class="text-truncate mb-0"> <span class="fs-12">{{selected.received}}</span></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr v-if="selected.services.length > 0">
                <td style="border-right: none; border-left: none; cursor: pointer;" @click="openService()">
                    <span class="fw-semibold fs-12 ms-2">Add-ons Details</span>
                    <i class="ri-information-fill fs-20 mb-n2 mt-n1 text-primary float-end" style="cursor: pointer;"></i>
                </td>
            </tr>
            <tr v-if="selected.referral">
                <td style="border-right: none; border-left: none; cursor: pointer;" @click="openReferral()">
                    <span class="fw-semibold fs-12 ms-2">Referral Information</span>
                    <i class="ri-information-fill fs-20 mb-n2 mt-n1 text-primary float-end" style="cursor: pointer;"></i>
                </td>
            </tr>
            <tr>
                <td style="border-right: none; border-left: none; cursor: pointer;" @click="openPayment()">
                    <span class="fw-semibold fs-12 ms-2">Payment Information</span>
                    <i class="ri-information-fill fs-20 mb-n2 mt-n1 text-primary float-end" style="cursor: pointer;"></i>
                </td>
            </tr>
            <!-- <tr>
                <td style="border-right: none; border-left: none;">
                    <div class="row ms-n2 mb-0">
                        <div class="col-md-12 margin-space">
                            <div class="d-flex">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary"><i class="ri-coupon-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="margin-custom fs-12 text-muted">Discount :</p> 
                                    <h6 class="text-truncate mb-0 fs-12">
                                        <span >{{selected.payment.discounted.name}} ({{selected.payment.discounted.value }}%)</span>
                                    </h6>
                                </div>
                            </div>
                        </div>
                          <div class="col-md-12">
                            <div class="d-flex mt-3">
                                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                    <div class="avatar-title bg-light rounded-circle fs-16 text-primary"><i class="ri-price-tag-3-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="margin-custom fs-12 text-muted">Total :</p>
                                    <h6 class="text-truncate mb-0 fs-12">{{selected.payment.total}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="border-right: none; border-left: none; cursor: pointer;" @click="openReferral()">
                    <span class="fw-semibold fs-12 ms-2">Released Information</span>
                </td>
            </tr>
            <tr>
                <td style="border-right: none; border-left: none;">
                    <div class="row ms-n2 mb-0">
                        <template v-if="!selected.release">
                            <div class="col-md-12">
                                <div class="d-flex mt-0">
                                    <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                        <div class="avatar-title bg-light rounded-circle fs-16 text-primary"><i class="ri-hand-coin-fill"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="margin-custom fs-12 text-muted">Mode of Release :</p>
                                        <h6 class="text-truncate mb-0 fs-12" v-if="selected.mode">{{selected.mode.name}}</h6>
                                        <h6 class="text-warning mb-0 fs-12" v-else>Not Available</h6>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <template v-else>
                            <div class="col-md-12 margin-space">
                                <div class="d-flex mt-0">
                                    <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                        <div class="avatar-title bg-light rounded-circle fs-16 text-primary"><i class="ri-hand-coin-fill"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="margin-custom fs-12 text-muted">Mode of Release :</p>
                                        <h6 class="text-truncate mb-0 fs-12" v-if="selected.release.mode">{{selected.release.mode.name}}</h6>
                                        <h6 class="text-warning mb-0 fs-12" v-else>Not Available</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 margin-space">
                                <div class="d-flex mt-3">
                                    <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                        <div class="avatar-title bg-light rounded-circle fs-16 text-primary"><i class="ri-calendar-fill"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="margin-custom fs-12 text-muted">Released Date :</p>
                                        <h6 class="text-truncate mb-0" v-if="selected.release.released_at"> <span class="fs-12">{{selected.release.released_at}}</span></h6>
                                        <h6 class="text-warning mb-0 fs-12" v-else>Not Available</h6>
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
                                        <p class="margin-custom fs-12 text-muted">Released By :</p>
                                        <h6 class="text-truncate mb-0" v-if="selected.release.profile"> <span class="fs-12">{{selected.release.profile.fullname}}</span></h6>
                                        <h6 class="text-warning mb-0 fs-12" v-else>Not Available</h6>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </td>
            </tr> -->
        </tbody>
    </table>
    <Payment ref="payment"/>
    <Service :services="services" :lists="selected.services" ref="service"/>
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
    props: ['selected','total','services'],
    methods: {
        openPayment(){
            this.$refs.payment.show(this.selected.payment,this.selected.services,this.total);
        },
        openService(){
            this.$refs.service.show(this.selected.status,this.selected.id);
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
<style scoped>
.margin-custom {
    margin-bottom: -0.5px; margin-top: -2px;
}
.margin-space {
    margin-bottom: -3px;
}
</style>