<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" title="Download Testservices" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form enctype="multipart/form-data">
            <BRow>
                <BCol lg="12" class="mt-1 mb-1">
                    <InputLabel value="Laboratory"/>
                    <Multiselect :options="dropdowns.laboratories" 
                    :searchable="true" v-model="laboratory_id" 
                    placeholder="Select Laboratory" ref="multiselect1"/>
                </BCol>
            </BRow>
        </form>
          <template v-slot:footer>
            <b-button @click="submitExcel('ok')" variant="primary" :disabled="!laboratory_id" block>Download</b-button>
        </template>
    </b-modal>
</template>
<script>
import _ from 'lodash';
import Multiselect from '@/Shared/Components/Forms/Multiselect.vue';
export default {
    components: { Multiselect },
    props: ['dropdowns'],
    data(){
        return {
            currentUrl: window.location.origin,
            showModal: false,
            laboratory_id: null
        }
    },
    methods: { 
        show(){
            this.showModal = true;
        },
        submitExcel() {
            const params = new URLSearchParams();
            params.append('option', 'download');
            params.append('laboratory', this.laboratory_id);
            const url = `/testservices?${params.toString()}`;
            window.open(url);
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        hide(){
            this.form.reset();
            this.form.clearErrors();
            this.editable = false;
            this.showModal = false;
        }
    }
}
</script>
<style scoped>
.multiselect-search {
  background: #f5f6f7 !important;
}
/* .input-group input {
    border: 1px solid #e9eaed;
    background-color: #f5f6f7;
    height: 37.5px;
}
.testbutton {
    height: 38px;
} */
</style>