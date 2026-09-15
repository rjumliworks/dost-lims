<template>
    <div v-if="grouped.length === 0" class="text-center text-muted py-4">No facilities found.</div>
    <div v-for="(group,gIndex) in grouped" v-bind:key="gIndex" class="card bg-light-subtle shadow-none border mb-3">
        <div class="card-header bg-light-subtle">
            <div class="d-flex align-items-center mb-n2">
                <div class="flex-grow-1">
                    <h5 class="mb-0 fs-13">
                        {{group.facility_name}}
                        <span class="badge ms-1" :class="group.is_regional ? 'bg-info' : 'bg-warning'">{{ group.is_regional ? 'Region' : 'PSTO' }}</span>
                    </h5>
                </div>
                <div class="flex-shrink-0" v-if="missing(group).length > 0">
                    <BButton @click="openGenerate(group)" variant="danger" class="btn-sm waves-effect waves-light">
                        Generate Sequence
                    </BButton>
                </div>
            </div>
        </div>
        <div class="card-body bg-white rounded-bottom">
            <div class="table-responsive table-card">
                <table class="table align-middle table-striped table-centered mb-0">
                    <thead class="table-light thead-fixed">
                        <tr class="fs-11">
                            <th>Laboratory</th>
                            <th style="width: 15%;" class="text-center">Sequence Type</th>
                            <th style="width: 8%;" class="text-center">Year</th>
                            <th style="width: 14%;" class="text-center">Next Sequence</th>
                            <th style="width: 10%;" class="text-center">Status</th>
                            <th style="width: 8%;" class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody class="fs-12" v-if="group.rows.length > 0">
                        <tr v-for="(row,index) in group.rows" v-bind:key="index">
                            <td>
                                {{ row.laboratory_name || 'All Laboratories' }}
                                <span v-if="row.laboratory_short" class="text-muted"> ({{row.laboratory_short}})</span>
                            </td>
                            <td class="text-center">{{ row.type_name }}</td>
                            <td class="text-center">{{ row.year }}</td>
                            <td class="text-center">
                                <input v-if="editingId === row.sequence_id && row.sequence_id" type="number" min="1"
                                v-model="editValue" class="form-control form-control-sm text-center d-inline-block" style="width: 100px;"/>
                                <span v-else-if="row.sequence_id" class="fw-semibold">{{ row.next_sequence }}</span>
                                <span v-else class="text-muted">-</span>
                            </td>
                            <td class="text-center">
                                <span v-if="row.sequence_id" class="badge bg-success">Generated</span>
                                <span v-else class="badge bg-danger">Missing</span>
                            </td>
                            <td class="text-center">
                                <template v-if="row.sequence_id">
                                    <template v-if="editingId === row.sequence_id">
                                        <a href="#" @click.prevent="save(row)" class="text-success me-2"><i class="ri-check-line"></i></a>
                                        <a href="#" @click.prevent="cancel()" class="text-danger"><i class="ri-close-line"></i></a>
                                    </template>
                                    <a v-else href="#" @click.prevent="edit(row)" class="text-primary"><i class="ri-edit-2-fill"></i></a>
                                </template>
                            </td>
                        </tr>
                    </tbody>
                    <tbody class="fs-12" v-else>
                        <tr>
                            <td colspan="6" class="text-center text-muted">No laboratories assigned to this facility.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <Generate ref="generate"/>
</template>
<script>
import Generate from './Modals/Sequence/Generate.vue';
export default {
    components: { Generate },
    props: ['lists'],
    data(){
        return {
            editingId: null,
            editValue: null,
        }
    },
    computed: {
        grouped(){
            const map = {};
            (this.lists || []).forEach(row => {
                if(!map[row.facility_id]){
                    map[row.facility_id] = {
                        facility_id: row.facility_id,
                        facility_name: row.facility_name,
                        is_regional: row.is_regional,
                        rows: []
                    };
                }
                map[row.facility_id].rows.push(row);
            });
            return Object.values(map);
        }
    },
    methods: {
        missing(group){
            return group.rows.filter(row => !row.sequence_id);
        },
        openGenerate(group){
            this.$refs.generate.show(group.facility_id, group.facility_name, this.missing(group));
        },
        edit(row){
            this.editingId = row.sequence_id;
            this.editValue = row.next_sequence;
        },
        cancel(){
            this.editingId = null;
            this.editValue = null;
        },
        save(row){
            this.$inertia.post('/agencies', {
                id: row.sequence_id,
                next_sequence: this.editValue,
                option: 'update_sequence'
            }, {
                preserveScroll: true,
                onSuccess: () => {
                    this.cancel();
                },
            });
        }
    }
}
</script>
