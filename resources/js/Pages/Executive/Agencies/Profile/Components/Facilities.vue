<template>
   <div class="table-responsive table-card" style="height: calc(100vh - 404px);">
       <simplebar data-simplebar style="height: calc(100vh - 410px);">
           <table class="table table-nowrap align-middle mb-0">
                <thead class="bg-primary text-white">
                    <tr class="fs-10">
                        <th style="width: 4%;"></th>
                        <th>Name</th>
                        <th style="width: 10%;" class="text-center">Short</th>
                        <th style="width: 10%;" class="text-center">Type</th>
                        <th style="width: 10%;" class="text-center">Status</th>
                        <th style="width: 5%;" class="text-center"></th>
                    </tr>
                </thead>
                <tbody v-if="lists.length > 0">
                    <tr v-for="(list,index) in lists" v-bind:key="index" class="fs-12">
                        <td>{{ index + 1 }}.</td>
                        <td>
                            <h5 class="fs-12 mb-0 text-dark">{{list.name}}</h5>
                            <p class="fs-11 text-muted mb-0">{{ list.barangay.name }}, {{ list.municipality.name }}, {{ list.province.name }}, {{ list.region.region }}</p>
                        </td>
                        <td class="text-center">{{list.short}}</td>
                        <td class="text-center">
                            <span v-if="list.is_regional" class="badge bg-info">Region</span>
                            <span v-else class="badge bg-warning">PSTO</span>
                        </td>
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
                                            <a @click="openRole(list,index)" class="dropdown-item d-flex align-items-center" role="button">
                                                <i class="ri-quill-pen-fill me-2"></i> Set Signatories
                                            </a>
                                        </li>
                                        <li>
                                            <a @click="openActivation('verification',list,index)" class="dropdown-item d-flex align-items-center" role="button">
                                                <i class="ri-flask-fill me-2"></i> Set Laboratories
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a @click="openActivation('activation',list,index)" class="dropdown-item d-flex align-items-center" :class="(list.is_active) ? 'text-danger' : 'text-success'" href="#removeFileItemModal" data-id="1" data-bs-toggle="modal" role="button">
                                                <span v-if="list.is_active"><i class="ri-lock-2-fill me-2"></i>Deactivate Facility</span>
                                                <span v-else><i class="ri-lock-unlock-line me-2"></i>Activate Facility</span>
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
import Create from './Modals/Facility/Create.vue';
export default {
    props: ['lists'],
    components: { Create }, 
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