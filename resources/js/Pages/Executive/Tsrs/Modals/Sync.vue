<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 550px;" header-class="p-3 bg-light" title="Sync Printed TSRs" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <BRow>
            <BCol lg="12">
                <p class="text-muted fs-12 mb-0">Select a range of TSRs by code. Each TSR in the range will be updated one by one, refreshing its printed version with the latest data (e.g. customer name).</p>
            </BCol>
            <BCol lg="12" class="mt-3">
                <InputLabel value="From TSR" :message="form.errors.from_id"/>
                <Multiselect class="white" :options="fromOptions" @search-change="searchFrom" v-model="form.from_id" label="name" :searchable="true" placeholder="Search TSR code"/>
            </BCol>
            <BCol lg="12" class="mt-2">
                <InputLabel value="To TSR" :message="form.errors.to_id"/>
                <Multiselect class="white" :options="toOptions" @search-change="searchTo" v-model="form.to_id" label="name" :searchable="true" placeholder="Search TSR code"/>
            </BCol>
        </BRow>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="submit()" variant="primary" :disabled="form.processing || !form.from_id || !form.to_id" block>Submit</b-button>
        </template>
    </b-modal>
</template>
<script>
import _ from 'lodash';
import { useForm } from '@inertiajs/vue3';
import Multiselect from "@vueform/multiselect";
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
export default {
    components: { InputLabel, Multiselect },
    data(){
        return {
            form: useForm({
                from_id: null,
                to_id: null,
            }),
            fromOptions: [],
            toOptions: [],
            showModal: false,
        }
    },
    methods: {
        searchFrom: _.debounce(function(keyword){
            this.fetchCodes(keyword, 'fromOptions');
        }, 300),
        searchTo: _.debounce(function(keyword){
            this.fetchCodes(keyword, 'toOptions');
        }, 300),
        fetchCodes(keyword, target){
            axios.get('/tsrs-overview',{
                params: {
                    option: 'codes',
                    keyword: keyword
                }
            })
            .then(response => {
                this[target] = response.data;
            })
            .catch(err => console.log(err));
        },
        show(){
            this.showModal = true;
        },
        submit(){
            this.form.post('/tsrs-overview/sync',{
                preserveScroll: true,
                onSuccess: () => {
                    this.$emit('success', true);
                    this.hide();
                },
            });
        },
        hide(){
            this.form.reset();
            this.form.clearErrors();
            this.fromOptions = [];
            this.toOptions = [];
            this.showModal = false;
        }
    }
}
</script>
