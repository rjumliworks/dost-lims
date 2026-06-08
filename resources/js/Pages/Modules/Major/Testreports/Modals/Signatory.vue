<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" title="Set Signatory" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>

        <!-- <div class="text-center mt-4 pt-4">
            <h4 class="fs-14 fw-semibold text-capitalize">{{ type }} Signatories</h4>
            <p class="text-muted fs-12"> Select the personnel who will be assigned to {{ type.toLowerCase() }} this test report.</p>
            
        </div> -->
        <!-- Primary Alert -->
        <div class="alert alert-primary alert-dismissible alert-label-icon label-arrow fade show material-shadow fs-12" role="alert">
            <i class="ri-user-smile-line label-icon"></i><strong>Signature Assignment</strong> - Select the personnel who will be assigned to {{ action }} this test report.
        </div>

        <Multiselect :options="analysts" v-model="selectedAnalyst" label="name" :allow-empty="false" :searchable="true" placeholder="Select Analyst" />
        <template v-slot:footer>
            <b-button @click="hide" variant="light" block>Close</b-button>
            <b-button @click="submit" variant="primary" :disabled="form.processing" block>Submit</b-button>
        </template>
    </b-modal>
</template>

<script>
import { useForm } from '@inertiajs/vue3';
import Multiselect from "@vueform/multiselect";
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    components: { InputLabel, TextInput, Multiselect },
    props: ['analysts'],
    data() {
        return {
            form: useForm({
                id: null,
                analyzed_by: null,
                certified_by: null,
                option: 'signatory'
            }),
            type: null,
            showModal: false
        };
    },
    computed: {
        action() {
            const actions = {
                analyzed: 'analyze',
                certified: 'certify',
                approved: 'approve'
            };

            return actions[this.type] || 'sign';
        },
        selectedAnalyst: {
            get() {
                return this.type === 'analyzed' ? this.form.analyzed_by : this.form.certified_by;
            },
            set(value) {
                if (this.type === 'analyzed') { this.form.analyzed_by = value; } else { this.form.certified_by = value; }
            }
        }
    },
    methods: {
        show(type,id) {
            this.type = type;
            this.form.id = id;
            this.showModal = true;
        },
        submit(){
            this.form.transform((data) => {
                if (this.type === 'analyzed') {
                    delete data.certified_by;
                } else {
                    delete data.analyzed_by;
                }
                return data;
            }).post('/testreports', {
                preserveScroll: true,
                onSuccess: () => {
                    this.$emit('update', this.$page.props.flash.data);
                    this.hide();
                },
            });
        },
        hide() {
            this.showModal = false;
        },
    }
};
</script>
