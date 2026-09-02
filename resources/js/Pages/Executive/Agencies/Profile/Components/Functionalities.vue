<template>
    <div class="table-responsive table-card" style="height: calc(100vh - 404px);">
        <simplebar data-simplebar style="height: calc(100vh - 410px);">
            <div v-if="!id" class="text-center text-muted py-5">
                This agency has no configuration yet. Activate the agency first before managing its functionalities.
            </div>
            <table v-else class="table table-nowrap align-middle mb-0">
                <thead class="bg-primary text-white thead-fixed">
                    <tr class="fs-10">
                        <th style="width: 4%;"></th>
                        <th>Module</th>
                        <th style="width: 15%;" class="text-center">Status</th>
                        <th style="width: 10%;" class="text-center">Enabled</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(option, index) in options" v-bind:key="option.key" class="fs-12">
                        <td>{{ index + 1 }}.</td>
                        <td>{{ option.label }}</td>
                        <td class="text-center fs-12">
                            <span v-if="states[option.key]" class="badge bg-success">Active</span>
                            <span v-else class="badge bg-danger">Inactive</span>
                        </td>
                        <td class="text-center">
                            <div class="form-check form-switch form-switch-md d-flex justify-content-center mb-0">
                                <input type="checkbox" class="form-check-input" role="switch"
                                    :checked="states[option.key]" :disabled="form.processing"
                                    @change="toggle(option.key, $event.target.checked)">
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </simplebar>
    </div>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
export default {
    props: ['id', 'values', 'options'],
    data() {
        return {
            states: this.buildStates(),
            form: useForm({
                id: this.id,
                functionalities: {},
                option: 'functionalities'
            }),
        }
    },
    watch: {
        values() {
            this.states = this.buildStates();
        },
        id(value) {
            this.form.id = value;
        }
    },
    methods: {
        buildStates() {
            const states = {};
            (this.options || []).forEach(option => {
                states[option.key] = this.values ? (this.values[option.key] !== false) : true;
            });
            return states;
        },
        toggle(key, enabled) {
            this.states[key] = enabled;
            this.form.id = this.id;
            this.form.functionalities = { ...this.states };
            this.form.post('/agencies', {
                preserveScroll: true,
                preserveState: true,
            });
        }
    }
}
</script>
