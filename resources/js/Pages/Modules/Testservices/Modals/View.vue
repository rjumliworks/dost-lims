<template>
    <b-modal v-if="selected" v-model="showModal" style="--vz-modal-width: 750px;" header-class="p-3 bg-light" title="View Testservice" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
          
        <div class="row mb-5">
            <div class="col-md-12">
                <!-- <div class="row align-items-center g-3">
                    <div class="col-md">
                        <div>
                            <h6><span class="fw-semibold text-primary fs-16">{{ selected.testname.name }}</span> </h6>
                            <div class="hstack gap-3 mt-n1 fs-13 flex-wrap">
                                <div>Sampletype : 
                                    <span v-if="selected.sampletype" class="fw-medium"> {{ selected.sampletype .name}}</span>
                                    <span v-else class="text-muted">Not Available</span>
                                </div>
                                <div class="vr" style="width: 1px;"></div>
                                <div>Laboratory : 
                                    <span v-if="selected.laboratory" class="fw-medium">{{selected.laboratory.name }}</span>
                                    <span v-else class="text-muted">Not Available</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="row mt-n2 g-2">
                    <div class="col-sm-12">
                        <div class="p-1 border border-dashed rounded bg-light">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2">
                                    <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-flask-fill"></i></div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-0 fs-12">Testname:</p>
                                    <h5 class="mb-0 fs-13">{{ selected.testname.name }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="text-muted"/>
                <div class="row mt-n2 g-2">
                    <div class="col-sm-12">
                        <div class="p-1 border border-dashed rounded">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2">
                                    <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-pages-line"></i></div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-0 fs-12">Method:</p>
                                    <h5 class="mb-0 fs-13">{{selected.method.method.name }} <span class="text-muted">({{ selected.method.method.short }})</span></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-1 border border-dashed rounded">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2">
                                    <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-bill-line"></i></div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-0 fs-12">Reference:</p>
                                    <h5 class="mb-0 fs-13">{{selected.method.reference.name }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-1 border border-dashed rounded">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2">
                                    <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-price-tag-3-line"></i></div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-0 fs-12">Fee:</p>
                                    <h5 class="mb-0 fs-13">{{selected.method.fee }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <template v-slot:footer>
            <div class="row align-items-center g-0 float-end mt-n2">
                <div class="col-md">
                    <div>
                        <div class="hstack gap-4 mt-n1 fs-14 flex-wrap" style="cursor: pointer;">
                            <div class="text-muted" @click="hide()">  
                                <i class="ri-close-circle-line fs-16"></i> Close
                            </div>
                            <div class="text-muted" @click="submit(34)" v-if="selected.status.name == 'Pending' && $page.props.roles[0] == 'Technical Manager'">  
                                <i class="ri-delete-bin-line fs-16"></i> Reject
                            </div>
                            <div class="vr" style="width: 1px;"></div>
                            <div>  
                                <b-button @click="submit(32)" v-if="selected.status.name == 'Pending' && $page.props.roles[0] == 'Technical Manager'" variant="primary" :disabled="form.processing" block>Approved</b-button>
                                <b-button @click="submit(33)" v-if="selected.status.name == 'Approved'" variant="primary" :disabled="form.processing" block>Suspend</b-button>
                                <b-button @click="submit(32)" v-if="selected.status.name == 'Suspended'" variant="primary" :disabled="form.processing" block>Reactivate</b-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </b-modal>
</template>
<script>
import Fee from '../Modals/Fee.vue';
import { useForm } from '@inertiajs/vue3';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    components: { InputLabel, TextInput, Fee },
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
    methods: { 
        show(data){
            this.selected = data;
            this.showModal = true;
        },
        submit(id){
            this.form.id = this.selected.id;
            this.form.status_id = id;
            this.form.post('/testservices', {
                preserveScroll: true,
                onSuccess: () => {
                    this.$emit('update',this.$page.props.flash.data.data);
                    this.hide();
                },
            });
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>