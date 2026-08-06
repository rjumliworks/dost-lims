<template>
    <b-modal v-model="showModal" hide-footer style="--vz-modal-width: 850px;" header-class="p-3 bg-light" title="Review Update Request" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div v-if="selected" class="row g-2 mb-2">
            <div class="col-sm-4">
                <div class="p-1 border border-dashed bg-white rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-2">
                            <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-hand-coin-fill"></i></div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-0 fs-12">TSR Code :</p>
                            <h5 class="mb-0 fs-12 fw-semibold text-primary">{{ selected.code ?? 'Not yet available' }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="p-1 border border-dashed bg-white rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-2">
                            <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-account-circle-fill"></i></div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-0 fs-12">Customer :</p>
                            <h5 class="mb-0 fs-12">{{ selected.customer?.fullname }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="p-1 border border-dashed bg-white rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-2">
                            <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-flask-fill"></i></div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-0 fs-12">Laboratory :</p>
                            <h5 class="mb-0 fs-12">{{ selected.laboratory?.name }}</h5>
                            <!-- <span class="badge fs-10 mt-1" :class="selected.status?.color+' '+selected.status?.others">{{ selected.status?.name }}</span> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="text-muted mt-1 mb-2"/>
        <div v-if="selected" class="request-list" style="max-height: 55vh; overflow-y: auto;">
            <div v-if="selected.due_date_amendments && selected.due_date_amendments.length > 0" class="card bg-light-subtle shadow-none border mb-2">
                <div class="card-header bg-light-subtle py-2">
                    <h5 class="mb-0 fs-13 fw-semibold text-primary"><i class="ri-calendar-2-line align-bottom me-1"></i>Due Date</h5>
                    <p class="mb-0 fs-12 text-muted">Current : {{ selected.due_at }}</p>
                </div>
                <div class="card-body bg-white p-2">
                    <div v-for="(amendment,aIndex) in selected.due_date_amendments" v-bind:key="aIndex" class="border border-dashed rounded p-2" :class="{'mb-2': aIndex < selected.due_date_amendments.length - 1}">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="fs-12 text-muted">
                                Requested by <span class="fw-semibold text-body">{{ amendment.requested_by?.profile?.fullname }}</span> on {{ amendment.created_at }}
                            </div>
                            <span class="badge fs-10" :class="amendment.status?.color+' '+amendment.status?.others">{{ amendment.status?.name }}</span>
                        </div>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <p class="text-muted mb-0 fs-11">Current Due Date :</p>
                                <p class="fs-12 mb-0">{{ amendment.previous_due_at || '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted mb-0 fs-11">Proposed Due Date :</p>
                                <p class="fs-12 mb-0 fw-semibold">{{ amendment.proposed_due_at }}</p>
                            </div>
                            <div class="col-md-12">
                                <p class="text-muted mb-0 fs-11 mt-1">Reason for Update :</p>
                                <p class="fs-12 mb-0 fst-italic">{{ amendment.remarks }}</p>
                            </div>
                        </div>

                        <template v-if="amendment.status?.name == 'Pending'">
                            <hr class="text-muted mt-2 mb-2"/>
                            <div v-if="rejectingId !== 'due-'+amendment.id" class="d-flex gap-2 justify-content-end">
                                <b-button v-if="canReview" @click="rejectingId = 'due-'+amendment.id" variant="soft-danger" size="sm">
                                    <i class="ri-close-circle-line align-bottom me-1"></i>Reject
                                </b-button>
                                <b-button v-if="canReview" @click="approve(amendment,'due_date')" variant="success" size="sm" :disabled="form.processing">
                                    <i class="ri-checkbox-circle-line align-bottom me-1"></i>Approve
                                </b-button>
                                <span v-if="!canReview" class="fs-11 text-muted">Only the Technical Manager can review this request.</span>
                            </div>
                            <div v-else>
                                <Textarea v-model="form.remarks" class="form-control" rows="2" placeholder="State the reason for rejecting this request" :light="true"/>
                                <div class="d-flex gap-2 justify-content-end mt-2">
                                    <b-button @click="rejectingId = null" variant="light" size="sm">Cancel</b-button>
                                    <b-button @click="reject(amendment,'due_date')" variant="danger" size="sm" :disabled="form.processing || !form.remarks">Confirm Reject</b-button>
                                </div>
                            </div>
                        </template>
                        <template v-else>
                            <hr class="text-muted mt-2 mb-2"/>
                            <p class="fs-11 text-muted mb-0">
                                Reviewed by <span class="fw-semibold text-body">{{ amendment.reviewed_by?.profile?.fullname }}</span> on {{ amendment.reviewed_at }}
                                <span v-if="amendment.review_remarks"> &mdash; "{{ amendment.review_remarks }}"</span>
                            </p>
                        </template>
                    </div>
                </div>
            </div>
            <div v-for="(sample,sIndex) in selected.samples" v-bind:key="sIndex" class="card bg-light-subtle shadow-none border mb-2">
                <div class="card-header bg-light-subtle py-2">
                    <h5 class="mb-0 fs-13 fw-semibold text-primary">{{ sample.code ?? 'Not yet available' }}</h5>
                    <p class="mb-0 fs-12 text-muted">{{ sample.name ?? sample.samplename?.name }}</p>
                </div>
                <div class="card-body bg-white p-2">
                    <div v-for="(amendment,aIndex) in sample.amendments" v-bind:key="aIndex" class="border border-dashed rounded p-2" :class="{'mb-2': aIndex < sample.amendments.length - 1}">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="fs-12 text-muted">
                                Requested by <span class="fw-semibold text-body">{{ amendment.requested_by?.profile?.fullname }}</span> on {{ amendment.created_at }}
                            </div>
                            <span class="badge fs-10" :class="amendment.status?.color+' '+amendment.status?.others">{{ amendment.status?.name }}</span>
                        </div>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <p class="text-muted mb-0 fs-11">Current Description (customer) :</p>
                                <p class="fs-12 mb-0">{{ amendment.previous_customer_description || '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted mb-0 fs-11">Proposed Description (customer) :</p>
                                <p class="fs-12 mb-0 fw-semibold">{{ amendment.proposed_customer_description || '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted mb-0 fs-11">Current Description :</p>
                                <p class="fs-12 mb-0">{{ amendment.previous_description || '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted mb-0 fs-11">Proposed Description :</p>
                                <p class="fs-12 mb-0 fw-semibold">{{ amendment.proposed_description }}</p>
                            </div>
                            <div class="col-md-12">
                                <p class="text-muted mb-0 fs-11 mt-1">Reason for Update :</p>
                                <p class="fs-12 mb-0 fst-italic">{{ amendment.remarks }}</p>
                            </div>
                        </div>

                        <template v-if="amendment.status?.name == 'Pending'">
                            <hr class="text-muted mt-2 mb-2"/>
                            <div v-if="rejectingId !== amendment.id" class="d-flex gap-2 justify-content-end">
                                <b-button v-if="canReview" @click="rejectingId = amendment.id" variant="soft-danger" size="sm">
                                    <i class="ri-close-circle-line align-bottom me-1"></i>Reject
                                </b-button>
                                <b-button v-if="canReview" @click="approve(amendment,'sample')" variant="success" size="sm" :disabled="form.processing">
                                    <i class="ri-checkbox-circle-line align-bottom me-1"></i>Approve
                                </b-button>
                                <span v-if="!canReview" class="fs-11 text-muted">Only the Technical Manager can review this request.</span>
                            </div>
                            <div v-else>
                                <Textarea v-model="form.remarks" class="form-control" rows="2" placeholder="State the reason for rejecting this request" :light="true"/>
                                <div class="d-flex gap-2 justify-content-end mt-2">
                                    <b-button @click="rejectingId = null" variant="light" size="sm">Cancel</b-button>
                                    <b-button @click="reject(amendment,'sample')" variant="danger" size="sm" :disabled="form.processing || !form.remarks">Confirm Reject</b-button>
                                </div>
                            </div>
                        </template>
                        <template v-else>
                            <hr class="text-muted mt-2 mb-2"/>
                            <p class="fs-11 text-muted mb-0">
                                Reviewed by <span class="fw-semibold text-body">{{ amendment.reviewed_by?.profile?.fullname }}</span> on {{ amendment.reviewed_at }}
                                <span v-if="amendment.review_remarks"> &mdash; "{{ amendment.review_remarks }}"</span>
                            </p>
                        </template>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <b-button @click="hide()" variant="light">Close</b-button>
        </div>
    </b-modal>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
import Textarea from '@/Shared/Components/Forms/Textarea.vue';
export default {
    components: { Textarea },
    data(){
        return {
            form: useForm({
                id: null,
                remarks: null,
                option: null,
                type: null
            }),
            selected: null,
            rejectingId: null,
            changed: false,
            showModal: false,
        }
    },
    computed: {
        canReview(){
            return this.$page.props.roles?.includes('Technical Manager');
        }
    },
    methods: {
        show(data){
            this.selected = data;
            this.rejectingId = null;
            this.changed = false;
            this.showModal = true;
        },
        approve(amendment,type){
            this.form.id = amendment.id;
            this.form.remarks = null;
            this.form.option = 'approve';
            this.form.type = type;
            this.form.post('/requests', {
                preserveScroll: true,
                onSuccess: () => {
                    this.changed = true;
                    this.hide();
                },
            });
        },
        reject(amendment,type){
            this.form.id = amendment.id;
            this.form.option = 'reject';
            this.form.type = type;
            this.form.post('/requests', {
                preserveScroll: true,
                onSuccess: () => {
                    this.changed = true;
                    this.rejectingId = null;
                    this.hide();
                },
            });
        },
        hide(){
            this.showModal = false;
            if(this.changed){
                this.$emit('updated');
            }
        }
    }
}
</script>
