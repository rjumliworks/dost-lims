<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 700px;" header-class="p-3 bg-light" title="View Additional Fees" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div v-if="selected">
            <div class="row">
                <b-row>
                    <b-col md>
                        <b-row class="align-items-center g-3">
                            <b-col md>
                                <div>
                                    <h4 class="fw-semibold text-primary fs-14">{{selected.name}}</h4>
                                    <!-- <div class="hstack gap-3 flex-wrap mt-n1">
                                        <div>
                                            {{ selected.barangay.name }}, {{ selected.municipality.name }}, {{ selected.province.name }}, {{ selected.region.region }}
                                        </div>
                                        
                                    </div> -->
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
                            <h5 class="mb-0 mt-n1 fs-12"><span class="text-body">List of Additional Fees</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-11">Displays all laboratories available within the facility.</p>
                        </div>
                        <div class="flex-shrink-0">
                            <BButton @click="addFee(selected.id)" variant="danger" class="btn-sm waves-effect waves-light">
                                Add Fee
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
                                    <th style="width: 15%;" class="text-center">Fee</th>
                                    <th style="width: 7%;"></th>
                                </tr>
                            </thead>

                            <tbody class="table-white fs-12" v-if="selected.fees.length > 0">
                                <tr v-for="(list,index) in selected.fees" v-bind:key="index">
                                    <td class="text-center">{{ index + 1 }}</td>
                                    <td>
                                        <h5 class="fs-12 mb-0 text-dark">{{list.name}}</h5>
                                        <p class="fs-11 text-muted mb-0">{{ list.description }}</p>
                                    </td>
                                    <td class="text-center">{{list.fee}}</td>
                                    <td class="text-end">
                                       
                                    </td>
                                </tr>
                            </tbody>
                            <tbody class="table-white fs-12" v-else>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No fees added</td>
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
    <Fee :id="id" @update="updateList" ref="fee"/>
</template>
<script>
import Fee from '../Laboratory/AddFee.vue';
export default {
    components: { Fee },
    props: ['id'],
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
        addFee(id){
            this.$refs.fee.show(id);
        },
        updateList(data){
            this.selected.fees.push(data);
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