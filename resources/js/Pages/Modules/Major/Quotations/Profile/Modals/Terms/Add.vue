<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" title="Add Terms and Condition" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow class="g-3">
                <BCol lg="12" class="mt-1">
                    <InputLabel for="sampletype" value="Name"/>
                    <textarea v-model="name" rows="3" class="form-control" required @input="handleInput('name')" :light="true"></textarea>
                </BCol>
            </BRow>
        </form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="submit('ok')" variant="primary" block>Save</b-button>
        </template>
    </b-modal>
</template>
<script>
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    components: { InputLabel, TextInput },
    data(){
        return {
            currentUrl: window.location.origin,
            selected: {},
            name: null,
            showModal: false,
            editable: false
        }
    },
    methods: { 
        show(){
            this.showModal = true;
        }, 
        edit(data){
            this.editable = true;
            this.name = data.name;
            this.showModal = true;
        },
        submit(){
            (this.editable) ? this.$emit('update',this.name) : this.$emit('new',this.name);
            this.hide();
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        hide(){
            this.name = null;
            this.editable = false;
            this.showModal = false;
        }
    }
}
</script>