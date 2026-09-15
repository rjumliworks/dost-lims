
<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 650px;" header-class="p-3 bg-light" title="Generate Sequence" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div v-if="form.rows.length > 0">
            <div class="alert fs-10 alert-danger alert-dismissible alert-label-icon label-arrow fade show mb-3 material-shadow" role="alert">
                <i class="ri-error-warning-line label-icon"></i><strong>Notice</strong>
                - Set the starting sequence number for <strong>{{facilityName}}</strong>. Use 1 for a fresh start, or continue from an existing manual sequence if the agency adopted mid-year.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="table-responsive">
                <table class="table align-middle table-striped table-centered mb-0">
                    <thead class="table-light">
                        <tr class="fs-11">
                            <th>Laboratory</th>
                            <th style="width: 22%;" class="text-center">Sequence Type</th>
                            <th style="width: 25%;" class="text-center">Starting No.</th>
                        </tr>
                    </thead>
                    <tbody class="fs-12">
                        <tr v-for="(row,index) in form.rows" v-bind:key="index">
                            <td>{{ row.laboratory_name || 'All Laboratories' }}</td>
                            <td class="text-center">{{ row.type_name }}</td>
                            <td class="text-center">
                                <input type="number" min="1" v-model="row.next_sequence" class="form-control form-control-sm text-center"/>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div v-else class="text-center text-muted py-3">Nothing to generate, all sequences already exist for this facility.</div>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="submit()" variant="primary" :disabled="form.processing || form.rows.length === 0" block>Generate</b-button>
        </template>
    </b-modal>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
export default {
    data(){
        return {
            form: useForm({
                facility_id: null,
                rows: [],
                option: 'generate_sequence'
            }),
            facilityName: null,
            showModal: false,
        }
    },
    methods: {
        show(facilityId, facilityName, missingRows){
            this.facilityName = facilityName;
            this.form.facility_id = facilityId;
            this.form.rows = missingRows.map(row => ({
                type_id: row.type_id,
                type_name: row.type_name,
                laboratory_id: row.laboratory_id,
                laboratory_name: row.laboratory_name,
                next_sequence: 1
            }));
            this.showModal = true;
        },
        submit(){
            this.form.post('/agencies', {
                preserveScroll: true,
                onSuccess: () => {
                    this.$emit('update');
                    this.hide();
                },
            });
        },
        hide(){
            this.form.reset();
            this.form.clearErrors();
            this.showModal = false;
        }
    }
}
</script>
