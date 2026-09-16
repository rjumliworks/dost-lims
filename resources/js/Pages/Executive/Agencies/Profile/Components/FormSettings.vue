<template>
    <div>
        <div class="d-flex mb-2">
            <div class="flex-grow-1">
                <div class="text-primary fs-12 fw-semibold fs-12">Form Settings</div>
                <p class="text-muted fs-12 mb-0">This information is printed on system-generated reports such as the Technical Service Request (TSR) Report.</p>
            </div>
            <div class="flex-shrink-0">
                <button @click="openSetting" class="btn btn-sm btn-soft-info" type="button">
                    <i class="ri-file-settings-fill align-bottom"></i> Edit
                </button>
            </div>
        </div>
        <div class="card bg-white border shadow-none mb-0" style="height: calc(100vh - 470px); overflow: auto;">
            <simplebar data-simplebar style="max-height: 100%;" v-if="selected.data.configuration.form">
                <div class="row p-3 mt-2 ms-0 me-0">
                    <div class="col-md-6">
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
                    <div class="col-md-6">
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
                    <div class="col-md-6">
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
                    <div class="col-md-6">
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
                    <div class="col-md-6">
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
                    <div class="col-md-6">
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
                    <p class="text-muted text-center fs-12 mb-n2 mt-3"> No form settings configured yet.</p>
                </div>
            </div>
        </div>
        <Setting :selected="selected" ref="setting"/>
    </div>
</template>
<script>
import Setting from '../Modals/Form.vue'
import simplebar from 'simplebar-vue';
export default {
    components: { simplebar, Setting },
    props: ['selected'],
    methods: {
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
