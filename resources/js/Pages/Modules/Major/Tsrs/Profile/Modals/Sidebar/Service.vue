<template>
    <b-modal v-if="selected.services.length > 0" v-model="showModal" style="--vz-modal-width: 650px;" :hide-footer="selected.status.name != 'Pending'" title="Additional Services" class="v-modal-custom"  header-class="p-3 bg-light" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="card-body">
            <table class="table align-middle table-bordered mb-n1">
                <thead class="table-light">
                    <tr class="fs-11">
                        <th style="width: 50%;">Addon</th>
                        <th style="width: 14%;" class="text-center">Days</th>
                        <th style="width: 18%;" class="text-center">Fee</th>
                        <th style="width: 18%;" class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody class="fs-12">
                    <tr class="" v-for="(list,index) in selected.services" v-bind:key="index">
                        <td>
                            <h5 class="fs-13 mb-0"> {{list.service.name}}</h5>
                            <p class="fs-12 text-muted mb-0">{{list.service.description}}</p>
                        </td>
                        <td class="text-center">{{ list.quantity }}</td>
                        <td class="text-center">{{ list.fee }}</td>
                        <td class="text-center">{{ list.total }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <template v-slot:footer>
            <b-button v-if="selected.status.id == 1 || selected.status.id == 2" @click="submit('delete')" variant="danger" block>Delete</b-button>
            <b-button v-if="!selected.status.id == 1 || !selected.status.id == 2" @click="hide()" variant="light" block>Close</b-button>
        </template>
    </b-modal>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                id: null,
                quantity: null,
                tsr_id: null,
                option: 'removeservice'
            }),
            selected: {
                status:{}, services: []
            },
            showModal: false
        }
    },
    methods: { 
        show(data,status,id){
            this.form.id = data.id;
            this.form.tsr_id = id;
            this.form.quantity = data.quantity;
            this.selected.services = data;
            this.selected.status = status;
            this.showModal = true;
        },
        submit(data){
            this.form.option = data;
            this.form.put('/analyses/update',{
                preserveScroll: true,
                onSuccess: (response) => {
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