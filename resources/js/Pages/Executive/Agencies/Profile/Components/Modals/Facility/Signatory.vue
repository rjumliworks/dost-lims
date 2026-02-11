<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 650px;" header-class="p-3 bg-light" title="View Signatories" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
       
        <div class="card-body bg-white rounded-bottom">
            <div class="container text-center">
                <div class="row justify-content-center mt-4 mb-3" v-if="selected">
                    <div class="col-md-6" style="cursor: pointer;" @click="openSet('Cashier')">
                        <div class="card-body border rounded-4 text-center p-4">
                            <div class="mb-2 mx-auto">
                                <img :src="(selected.signatories) ? (selected.signatories.accountant) ? (selected.signatories.cashier.profile.avatar == 'noavatar.jpg') ? '/images/avatars/avatar.jpg' : '/'+selected.signatories.cashier.profile.avatar : '/images/avatars/avatar.jpg' : '/images/avatars/avatar.jpg'" alt="" id="candidate-img" class="avatar-sm img-thumbnail rounded-circle shadow-none">
                            </div>
            
                            <h5 v-if="selected.signatories?.cashier" class="fs-12 mb-0 text-warning fw-semibold">
                                {{ selected.signatories.cashier.profile.fullname }}
                            </h5>
                            <h5 v-else class="fs-12 text-warning mb-0">Not Assigned</h5>
                            <p class="fs-12 text-muted mb-0">Cashier</p>
                        </div>
                    </div>
                    <div class="col-md-6" style="cursor: pointer;" @click="openSet('Accountant')">
                        <div class="card-body border rounded-4 text-center p-4">
                            <div class="mb-2 mx-auto">
                                <img :src="(selected.signatories) ? (selected.signatories.accountant) ? (selected.signatories.accountant.profile.avatar == 'noavatar.jpg') ? '/images/avatars/avatar.jpg' : '/'+selected.signatories.accountant.profile.avatar : '/images/avatars/avatar.jpg' : '/images/avatars/avatar.jpg'" alt="" id="candidate-img" class="avatar-sm img-thumbnail rounded-circle shadow-none">
                            </div>
                        
                            <h5 v-if="selected.signatories?.accountant" class="fs-12 mb-0 text-warning fw-semibold">
                                {{ selected.signatories.accountant.profile.fullname }}
                            </h5>
                            <h5 v-else class="fs-12 text-warning mb-0">Not Assigned</h5>
                            <p class="fs-12 text-muted mb-0">Accountant</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <Set ref="set" @update="updateUser"/>    
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
        </template>
    </b-modal>
</template>
<script>
import Set from './SetSignatory.vue';
export default {
    components: { Set },
    data(){
        return {
            type: null,
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
        openSet(type){
            this.type = type;
            this.$refs.set.show(this.selected.id,type,this.selected.agency_id);
        },
        updateUser(data){
            if(this.type == 'Cashier'){
                this.selected.signatories.cashier = data.cashier;
            }else{
                this.selected.signatories.accountant = data.accountant;
            }
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>