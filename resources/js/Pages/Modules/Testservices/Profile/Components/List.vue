<template>
    <div class="table-responsive table-card" style="height: calc(100vh - 380px);">
        <table class="table table-nowrap align-middle mb-0">
            <thead class="bg-primary text-white">
                <tr class="fs-10">
                    <th style="width: 4%;"></th>
                    <th>Name</th>
                    <th style="width: 12%;" class="text-center">Fee</th>
                    <th style="width: 5%;" class="text-center">Status</th>
                    <th class="text-end" style="width: 5%;"></th>
                </tr>
            </thead>
            <tbody class="fs-12" v-if="(fees) ? fees.length > 0 : ''">
                <tr v-for="(list,index) in fees" v-bind:key="index" class="fs-12">
                    <td  width="4%" class="text-center fs-12"> 
                        {{index+1}}
                    </td>
                    <td>
                        <h5 class="fs-12 mb-0">{{list.name}}</h5>
                        <!-- <p class="text-muted mb-0">{{list.code}}</p> -->
                    </td>
                    <td class="text-center">{{list.fee}}</td>
                    <td class="text-center">
                        <span v-if="list.is_active" class="fs-17 text-success"><i class="ri-checkbox-circle-fill"></i></span>
                        <span v-else class="fs-17 text-danger"><i class="ri-close-circle-fill"></i></span>
                    </td>
                    <td class="text-end">
                        <b-button @click="openEdit(list)" class="mt-n1 mb-n1" variant="soft-info" v-b-tooltip.hover title="View" size="sm">
                            <i class="ri-eye-fill align-bottom"></i>
                        </b-button>
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="6" class="text-center text-muted">No add-ons available for this service at the moment.</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
import _ from 'lodash';
export default {
    props: ['fees'],
    methods: {
        openEdit(data){
           this.$emit('edit-fee', data);
        }
    }
}
</script>