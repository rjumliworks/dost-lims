<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 550px;" header-class="p-3 bg-light" title="Remove Logs" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="d-flex w-100 p-2 justify-content-center align-items-center">
            <div class="p-4 w-100 border rounded bg-light-subtle text-center">
                <h1 class="bx-tada"><i class="ri-close-circle-fill text-danger"></i></h1>
                <p class="mb-3 text-danger fw-semibold">Are you sure you want to remove this?</p>
                <p class="mb-0 text-dark fs-11">
                    Please ensure you have reviewed the details before proceeding.
                </p>
                
            </div>
        </div>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="submit('ok')" variant="danger" :disabled="form.processing" block>Submit</b-button>
        </template>
    </b-modal>
</template>

<script>
import { useForm } from "@inertiajs/vue3";
import Textarea from '@/Shared/Components/Forms/Textarea.vue';
    export default {
        components: { Textarea },
        data() {
            return {
                form: useForm({
                    id: null,
                    option: "delete",
                }),
                type: null,
                showModal: false,
                cameraStream: null,
            };
        },
        methods: {
            show(id) {
                this.form.id = id;
                this.showModal = true;
            },
            submit(){
                this.form.delete(`/equipments/${this.form.id}`, {
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.form.reset();
                        this.hide();
                    },
                });
            },
            hide() {
                this.showModal = false;
            },
        },
    };

</script>
