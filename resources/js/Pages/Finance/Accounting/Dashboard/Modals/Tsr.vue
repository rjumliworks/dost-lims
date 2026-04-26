<template>
    <b-modal  v-model="showModal" title="Add TSR" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="modal-body mt-n4">
            <BCol lg="12 mt-2">
                <InputLabel for="customer" value="TSR Number" :message="form.errors.tsr_id"/>
                <Multiselect 
                :options="tsrs" 
                @search-change="checkSearchStr"
                v-model="form.tsr_id" 
                label="name"
                @input="handleInput('tsr_id')"
                :searchable="true" 
                placeholder="Select TSR"/>
            </BCol>
        </div>
         <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
            <b-button @click="submit('ok')" variant="primary" block>Submit</b-button>
        </template>
    </b-modal>
</template>
<script>
import _ from 'lodash';
import { useForm } from '@inertiajs/vue3';
import Multiselect from "@vueform/multiselect";
export default {
    components: { Multiselect },
    data(){
        return {
            form: useForm({
                id: null,
                tsr_id: null,
                option: 'tsr'
            }),
            tsrs: [],
            showModal: false,
        }
    },
    methods: { 
        show(){
            this.showModal = true;
        },
        checkSearchStr: _.debounce(function(string) {
            this.fetch(string);
        }, 300),
        fetch(code){
            axios.get('/orderofpayments',{
                params: {
                    option: 'tsrs',
                    keyword: code
                }
            })
            .then(response => {
                this.tsrs = response.data;
            })
            .catch(err => console.log(err));
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>