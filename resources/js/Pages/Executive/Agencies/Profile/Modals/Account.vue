<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" title="Add Account" class="v-modal-custom"
        modal-class="zoomIn" centered no-close-on-backdrop>
        <div>
            <form class="customform">
                <BRow class="g-2">
                    <BCol lg="12" class="mt-1">
                        <InputLabel for="name" value="Name" :message="form.errors.name"/>
                        <TextInput id="name" v-model="form.name" type="text" class="form-control" placeholder="Please enter name" @input="handleInput('name')" :light="true"/>
                    </BCol>
                    <BCol lg="6" class="mt-1">
                        <InputLabel for="code" value="Code" :message="form.errors.code"/>
                        <TextInput id="code" v-model="form.code" type="text" class="form-control" placeholder="Please enter code" @input="handleInput('code')" :light="true"/>
                    </BCol>
                    <BCol lg="6" class="mt-1">
                        <InputLabel for="account" value="Account" :message="form.errors.account"/>
                        <TextInput id="account" v-model="form.account" type="text" class="form-control" placeholder="Please enter account" @input="handleInput('account')" :light="true"/>
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
                    name: null,
                    code: null,
                    account: null,
                    agency_id: null,
                    option: 'account'
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
