<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 700px;" header-class="p-3 bg-light" title="View Laboratories" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div v-if="selected">
            <div class="row">
                <b-row>
                    <b-col md>
                        <b-row class="align-items-center g-3">
                            <b-col md>
                                <div>
                                    <h4 class="fw-semibold text-primary fs-14">{{selected.name}}</h4>
                                    <div class="hstack gap-3 flex-wrap mt-n1">
                                        <div>
                                            {{ selected.barangay.name }}, {{ selected.municipality.name }}, {{ selected.province.name }}, {{ selected.region.region }}
                                        </div>
                                        
                                    </div>
                                </div>
                            </b-col>
                        </b-row>
                    </b-col>
                </b-row>
            </div>
            <hr class="text-muted"/>
            <div class="card bg-light-subtle shadow-none border mb-n1">
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height:2rem;width:2rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-flask-fill text-primary fs-20"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 mt-n1 fs-12"><span class="text-body">List of Laboratories</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-11">Displays all laboratories available within the facility.</p>
                        </div>
                        <div class="flex-shrink-0">
                            <BButton @click="addLaboratory(selected.id)" variant="danger" class="btn-sm waves-effect waves-light">
                                Add Laboratory
                            </BButton>
                        </div>
                    </div>
                </div>
                <div class="card-body bg-white rounded-bottom">
                    <div class="table-responsive table-card">
                        <table class="table align-middle table-striped table-centered mb-0">
                            <thead class="table-light thead-fixed">
                                <tr class="fs-11">
                                    <th class="text-center" style="width: 7%;">#</th>
                                    <th>Name</th>
                                    <th style="width: 15%;" class="text-center">Short</th>
                                    <th style="width: 7%;"></th>
                                </tr>
                            </thead>
                            <tbody class="table-white fs-12" v-if="selected.laboratories.length > 0">
                                <tr v-for="(list,index) in selected.laboratories" v-bind:key="index">
                                    <td class="text-center">{{ index + 1 }}</td>
                                    <td>{{ list.laboratory.name }}</td>
                                    <td class="text-center">{{ list.laboratory.short }}</td>
                                    <td class="text-end">
                                        <div class="d-flex gap-3 justify-content-center">
                                            <div class="dropdown">
                                                <BDropdown variant="link" toggle-class="btn btn-light btn-sm dropdown" no-caret menu-class="dropdown-menu-end" :offset="{ alignmentAxis: -130, crossAxis: 0, mainAxis: 10 }"> 
                                                    <template #button-content> 
                                                        <i class="ri-more-fill"></i>
                                                    </template>
                                                    <li>
                                                        <Link :href="`/users/${list.code}`" class="dropdown-item d-flex align-items-center" role="button">
                                                            <i class="ri-eye-fill me-2"></i> View
                                                        </Link>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center" :class="(list.is_active) ? 'text-danger' : 'text-success'" href="#removeFileItemModal" data-id="1" data-bs-toggle="modal" role="button">
                                                            <span v-if="list.is_active"><i class="ri-lock-2-fill me-2"></i> Deactivate User</span>
                                                            <span v-else><i class="ri-lock-unlock-line me-2"></i> Activate User</span>
                                                        </a>
                                                    </li>
                                                </BDropdown>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody class="table-white fs-12" v-else>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No laboratories added</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
           
        </div>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
        </template>
    </b-modal>
    <Lab :laboratories="laboratories" @update="updateList" ref="lab"/>
</template>
<script>
import Lab from './AddLab.vue';
export default {
    components: { Lab },
    props: ['laboratories'],
    data(){
        return {
            showModal: false,
            selected: null,
        }
    },
    
    methods: { 
        show(data){
            this.selected = data;
            this.showModal = true;
        },  
        submit(){
            this.form.post('/agencies',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.names = [];
                    this.$emit('message',true);
                    this.hide();
                },
            });
        },
        addLaboratory(id){
            this.$refs.lab.show(id,this.selected.laboratories);
        },
        updateList(data){
            this.selected.laboratories.push(data);
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        hide(){
            this.editable = false;
            this.showModal = false;
        }
    }
}
</script>