<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light"  title="Sample Tagging" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="alert alert-warning alert-dismissible alert-label-icon label-arrow fade show material-shadow fs-11" role="alert">
            <i class="ri-user-smile-line label-icon"></i><strong>System will detect if the start or end date is being updated.</strong>
        </div>

        <div class="mt-2 customform">
            <input type="date" class="form-control mb-4" v-model="form.date">
        </div>
        <div class="table-responsive" style="height: 200px; overflow: auto;">
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
                            <span class="fs-13 mb-0 fw-semibold text-primary me-1">{{list.code}}</span><span class="text-muted fs-13">({{ list.samplename.name }})</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="submit('ok')" variant="primary" :disabled="form.processing" block>Submit</b-button>
        </template>
    </b-modal>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
export default {
    components: { InputLabel },
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            form: useForm({
                date: null,
                lists: [],
                type: 'Sample Code',
                option: 'group'
            }),
            keyword: null,
            showModal: false
        }
    },
    methods: { 
        show(data){
            this.lists = data;
            this.form.lists = this.lists.map(item => item.id);;
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