<template>
    <b-col lg="4">
        <div class="card bg-light-subtle shadow-none border">
        <div class="card-header bg-light-subtle">
            <div class="d-flex mb-n3">
                <div class="flex-shrink-0 me-3">
                    <div style="height:2.5rem;width:2.5rem;">
                        <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                            <i class="ri-settings-4-fill text-primary fs-24"></i>
                        </span>
                    </div>
                </div>
                <div class="flex-grow-1">
                    <h5 class="mb-0 fs-14"><span class="text-body">Configuration</span></h5>
                    <p class="text-muted text-truncate-two-lines fs-12">Summary of wallet balance and transaction history.</p>
                </div>
            </div>
        </div>
      
        <!-- <div class="card-body bg-white border-bottom">
            <div class="d-flex flex-column">
                <div class="mt-auto">
                    <div class="d-flex mb-0">
                        <div class="flex-grow-1">
                            <div class="text-primary fs-12 fw-semibold fs-12">Laboratories</div>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="mb-n1 mt-n1">
                                <button @click="openLaboratory" class="btn btn-sm btn-soft-info" type="button" data-original-title="View PDF">
                                    <i class="r ri-add-circle-fill align-bottom"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- <div class="card bg-white rounded-bottom shadow-none mb-0" style="height: 145px; overflow: auto;">
            <ul class="list-unstyled p-4 mb-n4 mt-n3">
                <li class="py-1" v-for="(list,index) in selected.data.configuration.laboratories" v-bind:key="index">
                    <i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i>{{ list.name }}
                </li>
            </ul>
            <div class="d-flex mb-n1" v-if="selected.data.configuration.laboratories.length == 0">
                <div class="flex-grow-1">
                    <p class="text-muted text-center fs-12 mb-2 mt-3"> No laboratory selected</p>
                </div>
            </div>
        </div> -->
        <div class="card-body bg-white border-top border-bottom">
            <div class="d-flex flex-column">
                <div class="mt-auto">
                    <div class="d-flex mb-0">
                        <div class="flex-grow-1">
                            <div class="text-primary fs-12 fw-semibold fs-12">Form Settings</div>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="mb-n1 mt-n1">
                                <button @click="openSetting" class="btn btn-sm btn-soft-info" type="button" data-original-title="View PDF">
                                    <i class="ri-file-settings-fill align-bottom"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card bg-white rounded-bottom shadow-none mb-0" style="height: calc(100vh - 406px); overflow: auto;">
            <simplebar data-simplebar style="max-height: 400px" v-if="selected.data.configuration.form">
                <div class="row p-3 mt-2 ms-0 me-0">
                    <div class="col-md-12">
                        <div class="p-0 border border-dashed rounded">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2">
                                    <div class="avatar-title rounded bg-transparent text-primary fs-20">
                                        <i class="ri-pages-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-0 fs-12">Form Name:</p>
                                    <h5 class="mb-0 fs-12">{{ selected.data.configuration.form.form_name }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="p-0 border border-dashed rounded">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2">
                                    <div class="avatar-title rounded bg-transparent text-primary fs-20">
                                        <i class="ri-map-pin-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-0 fs-12">Address:</p>
                                    <h5 class="mb-0 fs-12">{{ selected.data.configuration.form.address }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="p-0 border border-dashed rounded">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2">
                                    <div class="avatar-title rounded bg-transparent text-primary fs-20">
                                        <i class="ri-phone-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-0 fs-12">Contact number:</p>
                                    <h5 class="mb-0 fs-12 text-truncate">{{ truncateContact(selected.data.configuration.form.contact) }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="p-0 border border-dashed rounded">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2">
                                    <div class="avatar-title rounded bg-transparent text-primary fs-20">
                                        <i class="ri-mail-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-0 fs-12">Email Address:</p>
                                    <h5 class="mb-0 fs-12">{{ selected.data.configuration.form.email }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="p-0 border border-dashed rounded">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2">
                                    <div class="avatar-title rounded bg-transparent text-primary fs-20">
                                        <i class="ri-time-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-0 fs-12">Time:</p>
                                    <h5 class="mb-0 fs-12">{{ selected.data.configuration.form.time }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="p-0 border border-dashed rounded">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2">
                                    <div class="avatar-title rounded bg-transparent text-primary fs-20">
                                        <i class="ri-time-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-0 fs-12">Bank Account:</p>
                                    <h5 class="mb-0 fs-12">{{ selected.data.configuration.form.bank }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </simplebar>
            <div class="d-flex mb-n1" v-else>
                <div class="flex-grow-1">
                    <p class="text-muted text-center fs-12 mb-n2 mt-3"> No history of transaction</p>
                </div>
            </div>
        </div>
    </div>
    </b-col>
    <Setting :selected="selected" ref="setting"/>
    <Laboratory :laboratories="laboratories" :selected="selected" ref="laboratory"/>
</template>
<script>
import Setting from './Modals/Form.vue'
import Laboratory from './Modals/Laboratory.vue';
import simplebar from 'simplebar-vue';
export default {
    components : { simplebar, Laboratory, Setting },
    props: ['selected','laboratories'],
    data(){
        return {
            currentUrl: window.location.origin,
        }
    },
    methods: { 
        openLaboratory(){
            this.$refs.laboratory.show();
        },
        openSetting(){
            this.$refs.setting.show();
        },
        truncateContact(value) {
            if (!value) return '';
            return value.length > 40 ? value.slice(0, 40) + '...' : value;
        }
    }
}
</script>