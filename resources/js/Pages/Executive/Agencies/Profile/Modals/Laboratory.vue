<template>
    <b-modal v-model="showModal" size="lg" header-class="p-3 bg-light" title="View Laboratories" class="v-modal-custom"
        modal-class="zoomIn" centered no-close-on-backdrop>
        <div>
            <div class="alert alert-primary alert-dismissible alert-label-icon rounded-label fade show material-shadow" role="alert">
                <i class="ri-flask-fill label-icon"></i>
                <strong>List of laboratories</strong> – These are the checklists of laboratories your agency uses.
            </div>

            <div class="p-1 border border-dashed rounded p-3">
                <div class="d-flex flex-wrap">
                    <div class="w-50">
                        <div v-for="lab in leftColumnLabs" :key="'left-' + lab.value">
                            <div class="form-check mb-1">
                                <input class="form-check-input" type="checkbox" :value="lab.value" @change="toggleLab(lab)" :checked="isSelected(lab.value)">
                                <label class="form-check-label">
                                {{ lab.name }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="w-50">
                        <div v-for="lab in rightColumnLabs" :key="'right-' + lab.value">
                            <div class="form-check mb-1">
                                <input class="form-check-input" type="checkbox" :value="lab.value" @change="toggleLab(lab)" :checked="isSelected(lab.value)">
                                <label class="form-check-label">
                                {{ lab.name }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr />
            <BRow>
                <div class="col-md-12">
                    <div class="card bg-light-subtle shadow-none border">
                        <div class="card-header bg-light-subtle">
                            <div class="d-flex mb-n3">
                                <div class="flex-shrink-0 me-3">
                                    <div style="height:2.5rem;width:2.5rem;">
                                        <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                            <i class="ri-government-fill text-primary fs-24"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-0 fs-14"><span class="text-body">List of Laboratories</span></h5>
                                    <p class="text-muted text-truncate-two-lines fs-12">List of laboratories that serves</p>
                                </div>
                                <div class="flex-shrink-0">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="card-body bg-white rounded-bottom">
                            <div class="table-responsive table-card">
                                <table class="table align-middle table-centered mb-0">
                                    <thead class="table-light thead-fixed">
                                        <tr class="fs-11">
                                            <th style="width: 3%;"></th>
                                            <th>Name</th>
                                            <th style="width: 18%;" class="text-center">TSR Count</th>
                                            <th style="width: 18%;" class="text-center">Sample Count</th>
                                            <th style="width: 18%;" class="text-center">Report no. Count</th>
                                            <th style="width: 5%;"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-white fs-12">
                                        <tr v-for="(list,index) in form.laboratories" v-bind:key="index">
                                            <td class="text-center"> {{ index + 1 }}.</td>
                                            <td>
                                                <h5 class="fs-12 mb-0">{{list.name}}</h5>
                                            </td>
                                            <td class="text-center fs-12">
                                                <input type="number" v-model.number="list.tsr_count" class="form-control text-center form-control-sm" />
                                            </td>
                                            <td class="text-center fs-12">
                                                <input type="number" v-model.number="list.sample_count" class="form-control text-center form-control-sm" />
                                            </td>
                                            <td class="text-center fs-12">
                                                <input type="number" v-model.number="list.report_count" class="form-control text-center form-control-sm" />
                                            </td>
                                            <td class="text-center">
                                                <b-button @click="removeLab(list.value)" variant="soft-danger" class="me-1" v-b-tooltip.hover title="Remove" size="sm">
                                                    <i class="ri-delete-bin-fill align-bottom"></i>
                                                </b-button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </BRow>

            <div class="alert border-0 alert-danger material-shadow fs-11" role="alert">
                <strong>Note:</strong> These counts are only used when adoption of the system takes place midyear, not on the first working day of the year.
            </div>

        </div>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="submit('ok')" variant="primary" :disabled="form.processing" block>Submit</b-button>
        </template>
    </b-modal>
</template>
<script>
    import { useForm } from '@inertiajs/vue3';
    export default {
        props: ['selected','laboratories'],
        data() {
            return {
                currentUrl: window.location.origin,
                form: useForm({
                    id: this.selected.data.configuration.id,
                    laboratories: this.selected.data.configuration.laboratories,
                    option: 'laboratories'
                }),
                showModal: false,
                editable: false
            }
        },
        computed: {
            leftColumnLabs() {
                return this.laboratories.slice(0, Math.ceil(this.laboratories.length / 2));
            },
            rightColumnLabs() {
                return this.laboratories.slice(Math.ceil(this.laboratories.length / 2));
            }
        },
        methods: {
            show() {
                this.showModal = true;
            },
            submit() {
                this.form.post('/agencies', {
                    preserveScroll: true,
                    onSuccess: (response) => {
                        // this.$emit('update', true);
                        this.hide();
                    },
                });
            },
            handleInput(field) {
                this.form.errors[field] = false;
            },
            toggleLab(lab) {
                const index = this.form.laboratories.findIndex(item => item.value === lab.value)

                if (index === -1) {
                    this.form.laboratories.push({
                        name: lab.name,
                        value: lab.value,
                        tsr_count: '0',
                        report_count: '0',
                        sample_count: '0'
                    })
                } else {
                    this.form.laboratories.splice(index, 1)
                }
            },
            isSelected(id) {
                return this.form.laboratories.some(lab => lab.value === id)
            },
            removeLab(id) {
                this.form.laboratories = this.form.laboratories.filter(lab => lab.value !== id)
            },
            hide(){
                this.showModal = false;
            }
        }
    }

</script>
