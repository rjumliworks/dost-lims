<template>
    <b-modal v-if="selected" v-model="showModal" style="--vz-modal-width: 950px;" header-class="p-3 bg-light" title="View Package" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
          
        <div class="row mb-5">
            <div class="col-md-12">
                <div class="row align-items-center g-3">
                    <div class="col-md">
                        <div>
                            <h6><span class="fw-semibold text-primary fs-16">{{ selected.name }}</span> </h6>
                            <div class="hstack gap-3 mt-n1 fs-13 flex-wrap">
                                <div>Laboratory : 
                                    <span v-if="selected.laboratory" class="fw-medium">{{selected.laboratory.name }}</span>
                                    <span v-else class="text-muted">Not Available</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            <hr class="text-muted mt-2"/>
            </div>
            <div class="col-md-12 mb-n5">
                <div class="card bg-light-subtle shadow-none border">
                    <div class="card-header bg-light-subtle">
                        <div class="d-flex mb-n3">
                            <div class="flex-shrink-0 me-3">
                                <div style="height:2.2rem;width:2.2rem;">
                                    <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                        <i v-if="info" :class="info.icon+' text-primary fs-24'"></i>
                                        <i v-else class="ri-file-list-fill text-primary fs-24"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-0 fs-13">
                                    <span class="text-body">Test Services</span>
                                </h5>
                                <p class="text-muted text-truncate-two-lines fs-11">Displays test services added to the package.</p>
                            </div>
                            <div class="flex-shrink-0">
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-white">
                        <div class="table-responsive table-card">
                            <table class="table table-nowrap align-middle mb-0">
                                <thead class="table-light thead-fixed">
                                    <tr class="fs-11">
                                        <th style="width: 5%;" class="text-center">#</th>
                                        <th style="width: 15%;">Testname</th>
                                        <th class="text-center">Method</th>
                                        <th style="width: 15%;" class="text-center">Fee</th>
                                        <th style="width: 4%;"></th>
                                    </tr>
                                </thead>
                                <tbody class="fs-12">
                                    <tr v-for="(list,index) in selected.testservices" v-bind:key="index" class="fs-12">
                                        <td  width="4%" class="text-center fs-12"> 
                                            {{index+1}}
                                        </td>
                                        <td>{{list.testname}}</td>
                                        <td class="text-center">{{list.method}}</td>
                                        <td class="text-center">{{list.fee}}</td>
                                        <td class="text-end">
                                            <b-button class="mt-n1 mb-n1" variant="soft-info" v-b-tooltip.hover title="View" size="sm">
                                                <i class="ri-eye-fill align-bottom"></i>
                                            </b-button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <template v-slot:footer>
         <b-button @click="hide()" variant="light" block>Close</b-button>
            <!-- <b-button v-if="selected.status.name == 'Approved' || selected.status.name == 'Pending'" @click="hide()" variant="light" block>Close</b-button>
            <b-button v-if="selected.status.name == 'Pending' && $page.props.roles[0] == 'Technical Manager'" @click="submit(34)" variant="danger" :disabled="form.processing" block>Reject</b-button>
            <b-button v-if="selected.status.name == 'Pending' && $page.props.roles[0] == 'Technical Manager'" @click="submit(32)" variant="primary" :disabled="form.processing" block>Approved</b-button>
            <b-button v-if="selected.status.name == 'Approved'" @click="submit(33)" variant="danger" :disabled="form.processing" block>Suspend</b-button>
            <b-button v-if="selected.status.name == 'Suspended'" @click="submit(32)" variant="primary" :disabled="form.processing" block>Reactivate</b-button> -->
        </template>
    </b-modal>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    components: { InputLabel, TextInput},
    data(){
        return {
            currentUrl: window.location.origin,
            selected: { 
                type: {},
                laboratory: {
                    member: {}
                },
                sampletype: {},
                testname: {},
                method: {
                    method: {},
                    reference: {}
                },
                status: {}
            },
            form: useForm({
                id: null,
                status_id: null,
                option: 'status'
            }),
            showModal: false
        }
    },
    computed: {
        refes() {
            const short = (this.selected.method.reference.short) ? '('+this.selected.method.reference.short+')' : '';
            const name = this.selected.method.reference.name;
            return name + short;
        }
    },
    methods: { 
        show(data){
            this.selected = data;
            this.showModal = true;
        },
        submit(id){
            this.form.id = this.selected.id;
            this.form.status_id = id;
            axios.post('/testservices', this.form)
            .then((response) => {
                this.$emit('success',true);
                this.hide();
            }).catch(error => {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors;
                     console.log(this.errors);
                }
            });
        },
        openFee(){
            this.$refs.fee.show(this.selected.id,this.selected.fees,this.selected.agency_id);
        },
        updateList(data){
            this.selected.fees.unshift(data);
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>