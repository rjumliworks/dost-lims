<template>
    <b-modal v-model="showModal"  header-class="p-3 bg-light" title="Generate Test Report" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="alert alert-danger alert-dismissible alert-label-icon rounded-label fade show mb-n2" role="alert">
            <i class="ri-qr-code-fill label-icon"></i><strong class="fs-11">The result will not be saved to the database.</strong>
        </div>
        <hr class="text-muted"/> 
        <form class="customform mt-2">
            <BRow class="g-3 mt-1" v-for="(list,index) in parameters" v-bind:key="index">
                <BCol lg="6" class="mt-0">
                    <InputLabel for="name" value="Parameter"/>
                    <TextInput v-model="list.name" type="text" class="form-control" placeholder="Enter calibration testpoints"  :light="true"/>
                </BCol>
                <BCol lg="6" class="mt-0">
                    <InputLabel for="name" value="Result"/>
                    <TextInput v-model="list.result" type="text" class="form-control" placeholder="Enter calibration testpoints" :light="true"/>
                </BCol>
            </BRow>
        </form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
            <b-button @click="submit('ok')" variant="primary" block>Generate</b-button>
        </template>
    </b-modal>
</template>
<script>
import simplebar from "simplebar-vue";
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    components : { InputLabel, TextInput, simplebar }, 
    data(){
        return {
            currentUrl: window.location.origin,
            id: null,
            parameters: null,
            showModal: false,
        }
    },
    methods: { 
        show(parameters,id){
            this.id = id;
            this.parameters = parameters;
            this.showModal = true;
        },
        submit(){
           window.open(this.currentUrl + '/testreports?option=print&id='+this.id+'&data='+JSON.stringify(this.parameters));
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>