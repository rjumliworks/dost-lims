<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" title="Add Funding Source" class="v-modal-custom"
        modal-class="zoomIn" centered no-close-on-backdrop>
        <div>
            <form class="customform">
                <BRow class="g-2">
                    <BCol lg="8" class="mt-1">
                        <InputLabel for="source" value="Funding Source" :message="form.errors.source"/>
                        <TextInput id="source" v-model="form.source" type="text" class="form-control" placeholder="Please enter funding source" @input="handleInput('source')" :light="true"/>
                    </BCol>
                    <BCol lg="4" class="mt-1">
                        <InputLabel for="code" value="Code" :message="form.errors.code"/>
                        <TextInput id="code" v-model="form.code" type="text" class="form-control" placeholder="Please enter code" @input="handleInput('code')" :light="true"/>
                    </BCol>
                </BRow>
            </form>
        </div>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="submit()" variant="primary" :disabled="form.processing" block>Submit</b-button>
        </template>
    </b-modal>
</template>
<script>
    import { useForm } from '@inertiajs/vue3';
    import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
    import TextInput from '@/Shared/Components/Forms/TextInput.vue';
    export default {
        components: { InputLabel, TextInput },
        data() {
            return {
                currentUrl: window.location.origin,
                form: useForm({
                    source: null,
                    code: null,
                    agency_id: null,
                    option: 'funding'
                }),
                showModal: false
            }
        },
        methods: {
            show(id) {
                this.form.agency_id = id;
                this.showModal = true;
            },
            submit() {
                this.form.post('/agencies', {
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.hide();
                    },
                });
            },
            handleInput(field) {
                this.form.errors[field] = false;
            },
            hide(){
                this.form.reset();
                this.showModal = false;
            }
        }
    }
</script>
