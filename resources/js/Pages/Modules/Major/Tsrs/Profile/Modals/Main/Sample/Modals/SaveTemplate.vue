<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 450px;" header-class="p-3 bg-light" title="Save as Template" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="mb-2">
            <InputLabel for="templatename" value="Template Name"/>
            <input ref="input" type="text" v-model="name" class="form-control" placeholder="Enter template name" @keyup.enter="save">
        </div>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="save()" variant="primary" :disabled="!name || saving" block>Save</b-button>
        </template>
    </b-modal>
</template>
<script>
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
export default {
    components: { InputLabel },
    props: ['saving'],
    emits: ['save'],
    data(){
        return {
            showModal: false,
            name: null,
        }
    },
    methods: {
        show(){
            this.name = null;
            this.showModal = true;
            this.$nextTick(() => this.$refs.input?.focus());
        },
        save(){
            if(!this.name || this.saving) return;
            this.$emit('save', this.name);
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>
