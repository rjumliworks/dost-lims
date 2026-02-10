<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" title="View Form Settings" class="v-modal-custom"
        modal-class="zoomIn" centered no-close-on-backdrop>
        <div>
            <form class="customform">
                <BRow class="g-2">
                    <BCol lg="12" class="mt-1">
                        <InputLabel for="middlename" value="Form Name" :message="form.errors.form_name"/>
                        <TextInput id="middlename" v-model="form.settings.form_name" type="text" class="form-control" placeholder="Please enter name" @input="handleInput('form_name')" :light="true"/>
                    </BCol>
                    <BCol lg="12" class="mt-0">
                        <InputLabel for="middlename" value="Address" :message="form.errors.address"/>
                        <TextInput id="middlename" v-model="form.settings.address" type="text" class="form-control" placeholder="Please enter address" @input="handleInput('address')" :light="true"/>
                    </BCol>
                    <BCol lg="6" class="mt-0">
                        <InputLabel for="middlename" value="Contact no." :message="form.errors.contact"/>
                        <TextInput id="middlename" v-model="form.settings.contact" type="text" class="form-control" placeholder="Please enter contact" @input="handleInput('contact')" :light="true"/>
                    </BCol>
                    <BCol lg="6" class="mt-0">
                        <InputLabel for="middlename" value="Email" :message="form.errors.email"/>
                        <TextInput id="middlename" v-model="form.settings.email" type="text" class="form-control" placeholder="Please enter email" @input="handleInput('email')" :light="true"/>
                    </BCol>
                    <BCol lg="6" class="mt-0">
                        <InputLabel for="middlename" value="Bank Account" :message="form.errors.time"/>
                        <TextInput id="middlename" v-model="form.settings.bank" type="text" class="form-control" placeholder="Please enter bank" @input="handleInput('bank')" :light="true"/>
                    </BCol>
                     <BCol lg="6" class="mt-0">
                        <InputLabel for="middlename" value="Time" :message="form.errors.time"/>
                        <TextInput id="middlename" v-model="form.settings.time" type="text" class="form-control" placeholder="Please enter time" @input="handleInput('time')" :light="true"/>
                    </BCol>
                </BRow>
            </form>
            <div class="alert border-0 alert-warning material-shadow fs-11 mt-4 mb-0" role="alert">
                <strong>Note:</strong> This information is printed on system-generated reports such as the Technical Service Request (TSR) Report.
                Ensure that all entries are accurate, as these details will appear on official documents issued by the system.
            </div>

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
    import TextInput from '@/Shared/Components/Forms/TextInput.vue';
    export default {
        props: ['selected'],
        components: {InputLabel, TextInput },
        data() {
            return {
                currentUrl: window.location.origin,
                form: useForm({
                    id: this.selected.data.configuration.id,
                    settings: this.selected.data.configuration.form,
                    option: 'settings'
                }),
                showModal: false,
                editable: false
            }
        },
        methods: {
            show() {
                this.showModal = true;
            },
            submit() {
                this.form.post('/agencies', {
                    preserveScroll: true,
                    onSuccess: (response) => {
                        // this.$emit('update', true);
                        this.hide();
                    },
                });
            },
            handleInput(field) {
                this.form.errors[field] = false;
            },
            toggleLab(lab) {
                const index = this.form.laboratories.findIndex(item => item.value === lab.value)

                if (index === -1) {
                    this.form.laboratories.push({
                        name: lab.name,
                        value: lab.value,
                        tsr_count: '0',
                        report_count: '0',
                        sample_count: '0'
                    })
                } else {
                    this.form.laboratories.splice(index, 1)
                }
            },
            isSelected(id) {
                return this.form.laboratories.some(lab => lab.value === id)
            },
            removeLab(id) {
                this.form.laboratories = this.form.laboratories.filter(lab => lab.value !== id)
            },
            hide(){
                this.showModal = false;
            }
        }
    }

</script>
