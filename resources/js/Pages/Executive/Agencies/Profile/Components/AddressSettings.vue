<template>
    <div class="table-responsive table-card" style="height: calc(100vh - 404px);">
        <simplebar data-simplebar style="height: calc(100vh - 410px);">
            <div v-if="!id" class="text-center text-muted py-5">
                This agency has no configuration yet. Activate the agency first before managing its address settings.
            </div>
            <template v-else>
                <p class="text-muted fs-12 mb-2">
                    Choose which parts of the customer address to print on the TSR, and in what order. Use the arrows to reorder.
                </p>
                <table class="table table-nowrap align-middle mb-0">
                    <thead class="bg-primary text-white thead-fixed">
                        <tr class="fs-10">
                            <th style="width: 8%;" class="text-center">Order</th>
                            <th>Address Component</th>
                            <th style="width: 12%;" class="text-center">Shown</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in items" v-bind:key="item.key" class="fs-12" :class="{ 'text-muted': !item.enabled }">
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <button type="button" class="btn btn-sm btn-ghost-secondary btn-icon" :disabled="index === 0 || form.processing" @click="moveUp(index)">
                                        <i class="ri-arrow-up-line"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-ghost-secondary btn-icon" :disabled="index === items.length - 1 || form.processing" @click="moveDown(index)">
                                        <i class="ri-arrow-down-line"></i>
                                    </button>
                                </div>
                            </td>
                            <td>{{ item.label }}</td>
                            <td class="text-center">
                                <div class="form-check form-switch form-switch-md d-flex justify-content-center mb-0">
                                    <input type="checkbox" class="form-check-input" role="switch"
                                        :checked="item.enabled" :disabled="form.processing"
                                        @change="toggle(index, $event.target.checked)">
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="mt-3 fs-12">
                    <span class="text-muted">Preview: </span>
                    <span v-if="preview" class="fw-semibold text-uppercase">{{ preview }}</span>
                    <span v-else class="text-muted fst-italic">No components selected</span>
                </div>
            </template>
        </simplebar>
    </div>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
import simplebar from "simplebar-vue";
export default {
    components: { simplebar },
    props: ['id', 'values', 'options'],
    data() {
        return {
            items: this.buildItems(),
            form: useForm({
                id: this.id,
                address_format: [],
                option: 'printing'
            }),
        }
    },
    computed: {
        preview() {
            return this.items
                .filter(item => item.enabled)
                .map(item => item.label)
                .join(', ');
        }
    },
    watch: {
        values() {
            this.items = this.buildItems();
        },
        options() {
            this.items = this.buildItems();
        },
        id(value) {
            this.form.id = value;
        }
    },
    methods: {
        buildItems() {
            const defaultOrder = ['street', 'barangay', 'municipality', 'province'];
            const savedOrder = (this.values && this.values.length) ? this.values : defaultOrder;
            const labels = Object.fromEntries((this.options || []).map(option => [option.key, option.label]));
            const savedSet = new Set(savedOrder);

            const items = savedOrder
                .filter(key => labels[key])
                .map(key => ({ key, label: labels[key], enabled: true }));

            (this.options || []).forEach(option => {
                if (!savedSet.has(option.key)) {
                    items.push({ key: option.key, label: option.label, enabled: false });
                }
            });

            return items;
        },
        moveUp(index) {
            if (index === 0) return;
            const items = [...this.items];
            [items[index - 1], items[index]] = [items[index], items[index - 1]];
            this.items = items;
            this.save();
        },
        moveDown(index) {
            if (index === this.items.length - 1) return;
            const items = [...this.items];
            [items[index], items[index + 1]] = [items[index + 1], items[index]];
            this.items = items;
            this.save();
        },
        toggle(index, enabled) {
            this.items[index].enabled = enabled;
            this.save();
        },
        save() {
            this.form.id = this.id;
            this.form.address_format = this.items.filter(item => item.enabled).map(item => item.key);
            this.form.post('/agencies', {
                preserveScroll: true,
                preserveState: true,
            });
        }
    }
}
</script>
