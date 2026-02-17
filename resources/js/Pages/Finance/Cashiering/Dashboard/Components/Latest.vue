<template>
    <b-row class="g-2 mb-2 mt-n2">
        <b-col lg>
            <div class="input-group mb-1">
                <span class="input-group-text">Latest OR Receipt</span>
                <input type="text" :value="'OR# : '+receipts.data[0].number"  class="form-control" style="width: 25%;">
                <!-- <span @click="refresh" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;"> 
                    <i class="bx bx-refresh search-icon"></i>
                </span> -->
                <b-button type="button" variant="success" @click="openPrint(receipts.data[0].id)">
                    <i class="ri-printer-fill align-bottom me-1"></i> Print
                </b-button>
            </div>
        </b-col>
    </b-row>
    <div class="table-responsive">
        <table class="table table-nowrap align-middle mb-0">
            <thead class="table-light">
                <tr class="fs-11">
                    <th style="width: 80%;">Latest 5 receipts/customers</th>
                    <th style="width: 20%;" class="text-center"></th>
                </tr>
            </thead>
            <tbody v-if="receipts.data.length > 0">
                <tr v-for="(list,index) in receipts.data" v-bind:key="index">
                    <td>
                        <h5 class="fs-13 mb-0 text-dark">OR# : {{list.number}}</h5>
                        <p class="fs-12 text-muted mb-0">{{list.customer}}</p>
                    </td>
                    <td class="text-end">
                        <b-button @click="openPrint(list.id)" variant="soft-success" class="me-1" v-b-tooltip.hover title="Print" size="sm">
                            <i class="ri-printer-fill align-bottom"></i>
                        </b-button>
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="7" class="text-center text-muted">
                        There are no records to display
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
export default {
    props: ['receipts'],
    data(){
        return {
            currentUrl: window.location.origin
        }
    },
    methods: {
        openPrint(id){
            window.open(this.currentUrl + '/receipts?option=print&id='+id);
        }
    }
}
</script>