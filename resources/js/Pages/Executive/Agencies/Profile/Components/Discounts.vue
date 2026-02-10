<template>
   <div class="table-responsive table-card" style="height: calc(100vh - 404px);">
       <simplebar data-simplebar style="height: calc(100vh - 410px);">
           <table class="table table-nowrap align-middle mb-0">
                <thead class="bg-primary text-white">
                    <tr class="fs-10">
                        <th style="width: 4%;"></th>
                        <th>Name</th>
                        <th style="width: 12%;" class="text-center">Percentage</th>
                        <th style="width: 10%;" class="text-center">Type</th>
                        <th style="width: 10%;" class="text-center">Status</th>
                        <th style="width: 5%;" class="text-center"></th>
                    </tr>
                </thead>
                <tbody v-if="lists.length > 0">
                    <tr v-for="(list,index) in lists" v-bind:key="index" class="fs-12">
                        <td>{{ index + 1 }}.</td>
                        <td>{{list.discount.name}}</td>
                        <td class="text-center">{{list.discount.value}}<span v-if="list.discount.subtype_id == 10">%</span></td>
                        <td class="text-center">{{(list.is_occasional) ? 'Occasional' : 'Permanent'}}</td>
                        <td class="text-center fs-12">
                            <span v-if="list.is_active" class="badge bg-success">Active</span>
                            <span v-else class="badge bg-danger">Inactive</span>
                        </td>
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
                                            <a @click="openActivation('activation',list,index)" class="dropdown-item d-flex align-items-center" href="#removeFileItemModal" data-id="1" data-bs-toggle="modal" role="button">
                                                <span class="text-danger" v-if="list.is_active"><i class="ri-lock-2-fill me-2"></i>Deactivate Discount</span>
                                                <span class="text-success" v-else><i class="ri-lock-unlock-line me-2"></i>Activate Discount</span>
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
       </simplebar>
   </div>
</template>
<script>
export default {
    props: ['lists'],
    data(){
        return {
            currentUrl: window.location.origin,
            filter: { 
                keyword: null
            }
        }
    },
    methods: {
        openEdit(list){
            this.$refs.conforme.show(list);
        }
    }
}
</script>