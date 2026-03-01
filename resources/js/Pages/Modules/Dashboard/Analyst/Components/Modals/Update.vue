<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light"  title="Sample Tagging" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="alert alert-warning alert-dismissible alert-label-icon label-arrow fade show material-shadow fs-11" role="alert">
            <i class="ri-user-smile-line label-icon"></i><strong>System will detect if the start or end date is being updated.</strong>
        </div>

        <div class="mt-2 customform">
            <input type="date" class="form-control mb-4" v-model="form.date">
        </div>
        <!-- <div class="table-responsive" style="height: 200px; overflow: auto;">
            <table class="table align-middle table-centered mb-0">
                <thead class="table-light thead-fixed">
                    <tr class="fs-11">
                        <th class="text-center" style="width: 5%;">#</th>
                        <th>Code</th>
                    </tr>
                </thead>
                <tbody class="fs-12">
                    <tr v-for="(list,index) in lists" v-bind:key="index">
                        <td class="text-center"> 
                            {{index + 1 }}.
                        </td>
                        <td>
                            <span class="fs-13 mb-0 fw-semibold text-primary me-1">{{(form.type == 'Sample Code' || form.type == 'TSR Code') ? list.code : list.testservice_name}}</span><span class="text-muted fs-13">({{ (form.type == 'Sample Code' || form.type == 'Sample Code') ? list.name : list.code }})</span>
                            <p v-if="form.type == 'Sample Name'" class="mb-0">{{list.name}}</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div> -->
        <div class="card bg-light-subtle shadow-none border">
                    <div class="card-header bg-light-subtle">
                        <div class="d-flex mb-n3">
                            <div class="flex-shrink-0 me-3">
                                <div style="height:2.2rem; width:2.2rem;">
                                    <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                        <i class="ri-flask-fill text-primary fs-20"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-0 fs-12"><span class="text-body">{{ lists.length }} Samples selected</span></h5>
                                <p class="text-muted text-truncate-two-lines fs-11">Start or End Samples submitted</p>
                            </div>
                            <div class="flex-shrink-0">
                            </div>
                        </div>
                    </div>
                
                    <div class="card-body bg-white">
                        <div class="table-responsive table-card">
                            <simplebar data-simplebar style="max-height: 200px;">
                                <table class="table align-middle table-striped table-centered table-nowrap">
                                    <thead class="bg-dark-subtle fs-11 thead-fixed">
                                        <tr>
                                            <th class="text-center" style="width: 6%">#</th>
                                            <th style="width: 65%">Sample</th>
                                            <th class="text-center">Code</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-light-subtle fs-12">
                                       <tr v-for="(list,index) in lists" v-bind:key="index">
                                            <td class="text-center">{{index + 1 }}.</td>
                                            <td>
                                                <h5 class="fs-11 text-primary fw-semibold mb-0 mt-n1">{{list.type}}</h5>
                                                <p class="text-muted mb-n1">{{list.name}}</p>
                                            </td>
                                            <td class="text-center fs-12">{{  list.code }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </simplebar>
                        </div>
                    </div>
                </div>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="submit('ok')" variant="primary" :disabled="form.processing" block>Submit</b-button>
        </template>
    </b-modal>
</template>
<script>
import simplebar from "simplebar-vue";
import { useForm } from '@inertiajs/vue3';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
export default {
    components: { InputLabel, simplebar },
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            form: useForm({
                date: null,
                lists: [],
                type: null,
                option: 'group'
            }),
            keyword: null,
            showModal: false
        }
    },
    methods: { 
        show(data,type){
            this.form.type = type;
            this.lists = data;
            this.form.lists = this.lists.map(item => item.id);
            this.showModal = true;
        },
        submit(){
            this.form.put('/analyses/update',{
                preserveScroll: true,
                onSuccess: (response) => {
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