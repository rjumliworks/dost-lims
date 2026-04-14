<template>
    <Head title="Equipments"/>
    <PageHeader title="Equipments" pageTitle="Menu" />
    <b-row class="g-3">
        <div class="col-md-3">
            <b-card no-body class="bg-success-subtle border shadow-none">
                <b-card-body>
                    <div class="d-flex align-items-center">
                        <div class="avatar-xs flex-shrink-0">
                            <span class="avatar-title bg-light text-primary rounded-circle fs-4">
                                <i class="ri-pencil-ruler-2-fill align-middle`"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-uppercase text-truncate fw-semibold fs-10 text-muted mb-1">
                                Active Items
                            </p>
                            <h4 class="mb-0">
                                <span class="counter-value">{{statuses[0]}}</span>
                            </h4>
                        </div>
                    </div>
                </b-card-body>
            </b-card>
            <div class="card shadow-none border mt-n2">
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3 mt-1">
                            <div style="height:2rem;width:2rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-secure-payment-fill text-primary fs-20"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 mt-0 fs-13"><span class="text-body">Stock In</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-11">Highlights urgency and updates</p>
                        </div>
                    </div>
                </div>
                <div class="card border-bottom shadow-none" no-body style="height: 431px;">
                    
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row g-3">
                <b-col lg="4" v-for="(item, index) of counts" :key="index">
                    <b-card no-body class="border shadow-none">
                        <b-card-body>
                            <div class="d-flex align-items-center">
                                <div style="height:2.5rem;width:2.5rem;">
                                    <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                                        <i :class="`${item.icon} ${item.color} align-middle`"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase text-truncate fw-semibold fs-12 text-muted mb-1">
                                        {{ item.name }}
                                    </p>
                                    <h4 class="mb-0 fs-17">
                                        <span class="counter-value">{{item.total}}</span>
                                    </h4>
                                </div>
                                <div class="flex-shrink-0 align-self-end">
                                </div>
                            </div>
                        </b-card-body>
                    </b-card>
                </b-col>
                <b-col lg="12" class="mt-n2">
                    <div class="card bg-light-subtle shadow-none border">
                        <div class="card-header bg-light-subtle">
                            <div class="d-flex mb-n3">
                                <div class="flex-shrink-0 me-3 mt-1">
                                    <div style="height:2rem;width:2rem;">
                                        <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                            <i class="ri-trophy-fill text-primary fs-20"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-0 fs-13"><span class="text-body">List of Items</span></h5>
                                    <p class="text-muted text-truncate-two-lines fs-11">Items in inventory, validated and available for distribution</p>
                                </div>
                            </div>
                        </div>
                        <div class="car-body bg-white border-bottom shadow-none">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <ul class="nav nav-tabs nav-tabs-custom nav-primary fs-12" style="margin-top: 2px;" role="tablist">
                                        <li class="nav-item">
                                            <BLink @click="show('null')" class="nav-link py-3" data-bs-toggle="tab" role="tab" aria-selected="false">
                                                <i class="ri-heart-fill me-1 align-bottom"></i> All Laboratories
                                            </BLink>
                                        </li>
                                        <li class="nav-item">
                                            <BLink @click="show('image')" class="nav-link py-3" data-bs-toggle="tab" role="tab" aria-selected="false">
                                                <i class="ri-image-fill me-1 align-bottom"></i> Chemical
                                            </BLink>
                                        </li>
                                        <li class="nav-item">
                                            <BLink @click="show('video')" class="nav-link py-3" data-bs-toggle="tab" role="tab" aria-selected="false">
                                                <i class="ri-movie-fill me-1 align-bottom"></i> Microbiology
                                            </BLink>
                                        </li>
                                        <li class="nav-item">
                                            <BLink @click="show('liked')" class="nav-link py-3" data-bs-toggle="tab" role="tab" aria-selected="false">
                                                <i class="ri-heart-fill me-1 align-bottom"></i> Metrology
                                            </BLink>
                                        </li>
                                        <li class="nav-item">
                                            <BLink @click="show('liked')" class="nav-link py-3" data-bs-toggle="tab" role="tab" aria-selected="false">
                                                <i class="ri-heart-fill me-1 align-bottom"></i> Rubber
                                            </BLink>
                                        </li>
                                    </ul>
                                </div>
                                <div class="flex-shrink-0">
                                    <!-- <p class="text-primary fs-12 fw-semibold">Images & Videos</p> -->
                                </div>
                            </div>
                        </div>
                        <div class="card bg-light-subtle rounded-bottom shadow-none mb-0" style="height: calc(100vh - 433px); overflow-x: hidden;">

                        </div>
                    </div>
                </b-col>
            </div>
        </div>

        <div class="col-md-3">
            <b-card no-body class="bg-danger-subtle border shadow-none">
                <b-card-body>
                    <div class="d-flex align-items-center">
                        <div class="avatar-xs flex-shrink-0">
                            <span class="avatar-title bg-light text-primary rounded-circle fs-4">
                                <i class="ri-pencil-ruler-2-fill align-middle`"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-uppercase text-truncate fw-semibold fs-10 text-muted mb-1">
                                Inactive Items
                            </p>
                            <h4 class="mb-0">
                                <span class="counter-value">{{statuses[1]}}</span>
                            </h4>
                        </div>
                    </div>
                </b-card-body>
            </b-card>
            <div class="card shadow-none border mt-n2">
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3 mt-1">
                            <div style="height:2rem;width:2rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-secure-payment-fill text-primary fs-20"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 mt-0 fs-13"><span class="text-body">Stock Out</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-11">Highlights urgency and updates</p>
                        </div>
                    </div>
                </div>
                <div class="card border-bottom shadow-none" no-body style="height: 431px;">
                    
                </div>
            </div>
        </div>
    </b-row>
</template>
<script>
import _ from 'lodash';
import Multiselect from "@vueform/multiselect";
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { PageHeader, Multiselect, Pagination },
    data(){
        return {
            lists: [],
            meta: {},
            links: {},
            name: null,
            filter: {
                keyword: null,
                status: null,
                laboratory: null,
                reminder: null,
            },
            counts: [],
            statuses: []
        }
    },
    created(){
        this.fetch();
    },
    methods: {
        fetch(){
            axios.get('/inventory',{
                params : {
                    option: 'fetch',
                }
            })
            .then(response => {
                this.counts = response.data.counts; 
                this.statuses = response.data.statuses;
            })
            .catch(err => console.log(err));
        }
    }
}
</script>