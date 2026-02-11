<template lang="">
    <Head :title="selected.data.name"/>
    <Top :selected="selected"/>
    <b-row class="g-3">
        <Sidebar :laboratories="laboratories" :selected="selected"/>
        <b-col lg="8">
            <b-row>
                <b-col lg="12 ">
                    <div class="card bg-light-subtle shadow-none border">
                        <div class="card-header bg-light-subtle">
                            <div class="d-flex mb-n3">
                                <div class="flex-shrink-0 me-3">
                                    <div style="height:2.5rem;width:2.5rem;">
                                        <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                            <i class="ri-bar-chart-2-fill text-primary fs-24"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-0 fs-14"><span class="text-body">Profile</span></h5>
                                    <p class="text-muted text-truncate-two-lines fs-12">A comprehensive list of all TSRs (Test Service Requests) and Conformes, including their statuses and associated details.</p>
                                </div>
                                <template v-if="type == 'Facilities'">
                                    <div class="flex-shrink-0">
                                        <BButton @click="addFacility(selected.data.id)" variant="danger" class="btn-sm waves-effect waves-light mt-1">
                                            Add Facility
                                        </BButton>
                                    </div>
                                </template>
                                <template v-if="type == 'Discounts'">
                                    <div class="flex-shrink-0">
                                        <BButton @click="addDiscount(selected.data.id)" variant="danger" class="btn-sm waves-effect waves-light mt-1">
                                            Add Discount
                                        </BButton>
                                    </div>
                                </template>
                                <template v-if="type == 'Fees'">
                                    <div class="flex-shrink-0">
                                        <BButton @click="addFee(selected.data.id)" variant="danger" class="btn-sm waves-effect waves-light mt-1">
                                            Add Fee
                                        </BButton>
                                    </div>
                                </template>
                            </div>
                        </div>
                        <div class="card bg-white rounded-bottom shadow-none mb-0">
                            <div class="step-arrow-nav mt-0">
                                <ul class="nav nav-pills nav-justified custom-nav" role="tablist">
                                    <li class="nav-item" role="presentation" v-for="(menu, index) in menus" v-bind:key="index">
                                        <button @click="type = menu" class="nav-link fs-12 p-3" :class="(index == 0) ? 'active' : ''" 
                                            :id="menu+'-tab'" data-bs-toggle="pill" :data-bs-target="'#'+menu" 
                                            type="button" role="tab" :aria-controls="menu" aria-selected="true">
                                            {{menu}}
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body bg-white rounded-bottom">
                            <div class="tab-content">
                                <div class="tab-pane" :class="(index == 0) ? 'show active' : ''" :id="menu" role="tabpanel" :aria-labelledby="menu+'-tab'" v-for="(menu, index) in menus" v-bind:key="index">
                                    
                                    <div class="carousel-container">
                                        <div class="carousel-content">
                                            <transition mode="out-in">
                                                <div :key="index" class="tab-content">
                                                    <Laboratories :id="selected.data.id" :lists="labs" v-if="menu == 'Laboratories'"/>
                                                    <Facilities :lists="selected.data.facilities" :laboratories="laboratories" v-if="menu == 'Facilities'"/>
                                                    <Discounts :lists="selected.data.discounts" v-if="menu == 'Discounts'"/>
                                                    <Services :lists="selected.data.fees" v-if="menu == 'Fees'"/>
                                                    <!-- <Lists :id="customer.data.id" v-if="menu == 'TSRs'"/>
                                                    <Conforme :lists="customer.data.conformes" v-if="menu == 'Conformes'"/>
                                                    <Payor :lists="customer.data.payors" v-if="menu == 'Payors'"/>
                                                    <Logs :id="customer.data.id" v-if="menu == 'Logs'"/> -->
                                                </div>
                                            </transition>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </b-col>
            </b-row>
        </b-col>
    </b-row>
    <Fee ref="fee"/>
    <Facility :regions="regions" ref="facility"/>
    <Discount :discounts="selected.data.discounts" :options="discounts" ref="discount"/>
</template>
<script>
import Top from './Top.vue';
import Sidebar from './Sidebar.vue';
import Logs from './Components/Logs.vue';
import Services from './Components/Services.vue';
import Laboratories from './Components/Laboratories.vue';
import Facilities from './Components/Facilities.vue';
import Discounts from './Components/Discounts.vue';
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Facility from './Modals/Facility.vue';
import Discount from './Modals/Discount.vue';
import Fee from './Modals/Fee.vue';
export default {
    props:['selected','laboratories','discounts','regions','labs'],
    components: { PageHeader, Top, Sidebar, Discounts, Facilities, Laboratories, Services, Logs, Facility, Discount, Fee },
    data(){
        return {
            menus: [
                'Discounts','Facilities','Laboratories','Fees','Activity Logs'
            ],
            type: 'Discounts',
            index: null,
        }
    },
    methods: {
        addFee(id){
            this.$refs.fee.show(id);
        },
        addDiscount(id){
            this.$refs.discount.show(id);
        },
        addFacility(id){
            this.$refs.facility.show(id,this.selected.data.address.region_code);
        },
    }
}
</script>