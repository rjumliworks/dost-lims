<template>
    <Head title="Dashboard"/>
    <PageHeader title="Dashboard" pageTitle="Accountant" />
    <b-row>
        <div class="col-md-3">
            <div class="card shadow-none border">
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height:2.5rem;width:2.5rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-bank-card-fill text-primary fs-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-14"><span class="text-body">Payment Processing Stages</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">Highlights urgency and updates</p>
                        </div>
                        <div class="flex-shrink-0"></div>
                    </div>
                </div>
                <div class="card-body border-bottom bg-white">
                    <p class="mb-0 text-primary fs-12 fw-semibold">Collection Status</p>
                </div>
                <div class="card bg-white border-bottom shadow-none mb-0" style="height: calc(100vh - 343px); overflow: auto;">
                    <b-list-group flush>
                        <BListGroupItem  v-for="(list,index) in dropdowns.reminders" v-bind:key="index">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="avatar-xs">
                                        <div class="avatar-title rounded" :class="list.color">
                                        <i class="fs-15" :class="list.icon"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-0 fs-12">{{list.name}}</h5>
                                    <p class="mb-0 fs-11 text-muted">{{list.short}}</p>
                                </div>
                                <span class="text-dark fs-12">{{formatMoney(list.count)}} </span>
                            </div>
                        </BListGroupItem>
                    </b-list-group>
                    <p class="ms-3 mb-0 text-primary fs-12 mt-3"><span class="fw-semibold">Pending OP Issuance</span> <span class="text-muted">({{ dropdowns.tsrs.data.length }})</span></p>
                    <hr class="text-muted"/>
                    <b-list-group flush class="mt-n3"  style="height: 300px; overflow: auto;" v-if="dropdowns.tsrs.data.length > 0">
                        <BListGroupItem v-for="(list,index) in dropdowns.tsrs.data" v-bind:key="index">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                
                                    <h5 class="mb-0 fs-12">{{list.code}}</h5>
                                    <p class="mb-0 fs-11 text-muted">{{list.customer.name}}</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="text-dark fs-12">{{list.payment.total}} </span>
                                </div>
                            
                            </div>
                        </BListGroupItem>
                    </b-list-group>
                    <b-list-group flush class="mt-n3" v-else>
                        <BListGroupItem>
                                <p class="text-muted fs-11 text-center">Nothing found.</p>
                        </BListGroupItem>
                    </b-list-group>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <Lists :dropdowns="dropdowns"/>
        </div>
    </b-row>
</template>
<script>
import Lists from './Components/Lists.vue';
import Unpaid from './Components/Unpaid.vue';
import PageHeader from '@/Shared/Components/PageHeader.vue';
export default {
    props: ['dropdowns'],
    components: { PageHeader, Lists, Unpaid },
    methods: {
        formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return '₱'+val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
    }
}
</script>