<template>
    <div class="card bg-light-subtle shadow-none border">
        <div class="card-header bg-light-subtle">
            <div class="d-flex mb-n3">
                <div class="flex-shrink-0 me-3">
                    <div style="height:2.5rem;width:2.5rem;">
                        <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                            <i class="ri-parent-fill text-primary fs-24"></i>
                        </span>
                    </div>
                </div>
                <div class="flex-grow-1">
                    <h5 class="mb-0 fs-14"><span class="text-body">Customer Summary</span></h5>
                    <p class="text-muted text-truncate-two-lines fs-12">Overview of collected, uncollected, and complimentary amounts</p>
                </div>
              
            </div>
        </div>
        <div class="card-body bg-white border-bottom">
          
                    <div class="row g-0">
                        <ul class="list-group list-group-flush border-dashed mb-0">
                            <li class="list-group-item px-0" v-for="(list,index) in count" v-bind:key="index">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 avatar-xs">
                                        <span class="avatar-title bg-light p-1 rounded-circle">
                                            <i :class="list.icon+' '+list.color"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <h6 class="mb-0 fs-12">{{list.name}}</h6>
                                        <p class="fs-11 mb-0 text-muted">{{ list.description }}</p>
                                    </div>
                                    <div class="flex-shrink-0 text-end">
                                        <h6 class="mt-2">{{list.total}}</h6>
                                        <!-- <p class="text-success fs-12 mb-0">$19,405.12</p> -->
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <hr class="text-muted"/>
                        <ul class="list-group list-group-flush border-dashed mb-0 mt-n2">
                            <li class="list-group-item px-0" v-for="(list,index) in type" v-bind:key="index">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 avatar-xs">
                                        <span class="avatar-title bg-light p-1 rounded-circle">
                                            <i :class="list.icon+' '+list.color"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <h6 class="mb-0 fs-12">{{list.name}}</h6>
                                        <p class="fs-11 mb-0 text-muted">{{ list.description }}</p>
                                    </div>
                                    <div class="flex-shrink-0 text-end">
                                        <h6 class="mb-1">{{list.total}}</h6>
                                        <!-- <p class="text-success fs-12 mb-0">$19,405.12</p> -->
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
               
        </div>
        <div class="card-body">
            
        </div>
    </div>
</template>
<script>
export default {
    props: ['count','type'],
    data(){
        return {
            year: null,

        }
    },
    methods: {
        formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return '₱'+val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
    }
}
</script>