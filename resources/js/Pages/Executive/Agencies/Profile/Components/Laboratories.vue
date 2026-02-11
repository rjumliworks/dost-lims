<template>
   <div class="table-responsive table-card" style="height: calc(100vh - 404px);">
        <table class="table table-nowrap align-middle mb-0">
            <thead class="bg-primary text-white thead-fixed">
                <tr class="fs-10">
                    <th style="width: 4%;"></th>
                    <th>Name</th>
                    <th style="width: 15%;" class="text-center">Short</th>
                    <th style="width: 5%;" class="text-center"></th>
                </tr>
            </thead>
            <tbody v-if="lists.length > 0">
                <tr v-for="(list,index) in lists" v-bind:key="index" class="fs-12">
                    <td>{{ index + 1 }}.</td>
                    <td>{{list.name}}</td>
                    <td class="text-center">{{list.short}}</td>
                    <td class="text-end">
                        <div class="d-flex gap-3 justify-content-center"> 
                            <div class="dropdown">
                                <BDropdown variant="link" toggle-class="btn btn-light btn-sm dropdown" no-caret menu-class="dropdown-menu-end" :offset="{ alignmentAxis: -130, crossAxis: 0, mainAxis: 10 }"> 
                                    <template #button-content> 
                                        <i class="ri-more-fill"></i>
                                    </template>
                                    <li>
                                        <a @click="openUpdate(list,index)" class="dropdown-item d-flex align-items-center" role="button">
                                            <i class="ri-edit-2-fill me-2"></i> Update
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a @click="openFees(list,index)" class="dropdown-item d-flex align-items-center" role="button">
                                            <i class="ri-flask-fill me-2"></i> Additional Fees
                                        </a>
                                    </li>
                                </BDropdown>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="6" class="text-center text-muted">No records found.</td>
                </tr>
            </tbody>
        </table>
   </div>
   <Fee :id="id" ref="fee"/>
</template>
<script>
import Fee from './Modals/Laboratory/Fee.vue';
export default {
    props: ['lists','id'],
    components: { Fee },
    data(){
        return {
            index: null
        }
    },
    methods: {
        openFees(data,index){
            this.index = index;
            this.$refs.fee.show(data);
        }
    }
}
</script>