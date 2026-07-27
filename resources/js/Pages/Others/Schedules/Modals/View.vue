<template>
    <b-modal v-if="selected" v-model="showModal" style="--vz-modal-width: 700px;" header-class="p-3 bg-light" title="View Schedule" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="row align-items-center g-3">
                        <div class="col-md">
                            <div>
                                <h6><span class="fw-semibold text-primary fs-15">{{ selected.title}}</span></h6>
                                <div class="hstack gap-3 fs-12 flex-wrap mt-n1">
                                    <div>Created By : 
                                        <span v-if="selected.extendedProps" class="fw-medium">{{selected.extendedProps.full_name}}</span>
                                        <span v-else class="text-muted">Not Available</span>
                                    </div>
                                    <div class="vr" style="width: 1px;"></div>
                                    <div>Date Created. : 
                                        <span v-if="selected.extendedProps" class="fw-medium">{{selected.extendedProps.created_at}}</span>
                                        <span v-else class="text-muted">Not Available</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="text-muted"/>
            <div class="row mt-n2 g-2">
                <div class="col-sm-6">
                    <div class="p-1 border border-dashed rounded">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm me-2">
                                <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class=" ri-file-list-fill "></i></div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted mb-0 fs-12">{{ selected.extendedProps.event.type }}:</p>
                                <h5 class="mb-0 fs-12">{{selected.extendedProps.event.name}} </h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="p-1 border border-dashed rounded">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm me-2">
                                <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-calendar-fill"></i></div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted mb-0 fs-12">Date:</p>
                                <h5 class="mb-0 fs-12">{{selected.extendedProps.datee}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12" v-if="selected.extendedProps.venue">
                    <div class="p-1 border border-dashed rounded">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm me-2">
                                <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-map-pin-fill"></i></div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted mb-0 fs-12">Venue:</p>
                                <h5 class="mb-0 fs-12">{{selected.extendedProps.venue}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12" v-if="selected.extendedProps.tsr">
                    <div class="p-1 border border-dashed rounded">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm me-2">
                                <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-flask-fill"></i></div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted mb-0 fs-12">TSR no.:</p>
                                <h5 class="mb-0 fs-12">{{selected.extendedProps.tsr.code}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12" v-if="selected.extendedProps.tsr">
                    <div class="p-1 border border-dashed rounded">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm me-2">
                                <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-map-pin-fill"></i></div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted mb-0 fs-12">Address:</p>
                                <h5 class="mb-0 fs-12">{{selected.extendedProps.customer.fulladdress}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6" v-if="selected.extendedProps.conforme">
                    <div class="p-1 border border-dashed rounded">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm me-2">
                                <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-account-circle-fill"></i></div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted mb-0 fs-12">Conforme: </p>
                                <h5 class="mb-0 fs-12">{{selected.extendedProps.conforme.name}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6" v-if="selected.extendedProps.conforme">
                    <div class="p-1 border border-dashed rounded">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm me-2">
                                <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class=" ri-phone-fill "></i></div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted mb-0 fs-12">Contact no.: </p>
                                <h5 class="mb-0 fs-12">{{selected.extendedProps.conforme.contact_no}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-12" v-if="selected.extendedProps.samples">
                    <div class="p-1 border border-dashed rounded">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm me-2">
                                <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-flask-fill"></i></div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted mb-0 fs-12">No. of samples :</p>
                                <h5 class="mb-0 fs-12">{{selected.extendedProps.samples}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12" v-if="selected.extendedProps.description">
                    <div class="p-1 border border-dashed rounded">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm me-2">
                                <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-file-list-3-fill"></i></div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted mb-0 fs-12">Information :</p>
                                <h5 class="mb-0 fs-12">{{selected.extendedProps.description}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="text-muted mb-n2"/>
            <div class="col-sm-12 mt-4" v-if="selected.extendedProps.users.length > 0">
                <div class="p-1 border border-dashed rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-2">
                            <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-team-fill"></i></div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-0 fs-12">Users Tag :</p>
                            <h5 class="mb-0 fs-12">
                                <span v-for="(user, index) in selected.extendedProps.users" :key="index">
                                    {{ user.name }}<span v-if="index !== selected.extendedProps.users.length - 1">, </span>
                                </span>   
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
            <template v-if="selected.extendedProps.user_id == $page.props.user.data.id">
                <b-button @click="deleteEvent(selected.id)" variant="danger" block>Delete</b-button>
                <b-button @click="editSchedule()" variant="primary" block>Edit</b-button>
            </template>
        </template>
    </b-modal>
</template>
<script>
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            selected: null,
            showModal: false
        }
    },
    methods: {
        show(data){
            this.selected = data;
            this.showModal = true;
        },
        editSchedule(){
            this.$emit('edit', this.selected);
            this.hide();
        },
        deleteEvent(id){
            if (confirm("Are you sure you want to delete this event?")) {
                this.$inertia.delete(`/schedules/${id}`, {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.$emit('message', true); // Emit a success message or reload event list
                        this.showModal = false;
                    },
                    onError: (errors) => {
                        console.error("Failed to delete event:", errors);
                    },
                });
            } else {
                console.log("Deletion canceled");
            }
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>