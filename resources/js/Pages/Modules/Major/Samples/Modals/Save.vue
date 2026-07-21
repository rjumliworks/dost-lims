<template>
    <b-modal v-model="showModal" hide-footer hide-header title="Cancel Request" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="modal-body">
            <div class="mt-2 customform">
                <h4 class="mb-4 text-center" v-if="form.option == 'start'">Start Analysis</h4>
                <h4 class="mb-4 text-center" v-if="form.option == 'end'">End Analysis</h4>
                <!-- <span class="text-muted text-start fs-12 mb-0">Please enter a start date if it has passed.</span> -->
                <InputLabel v-if="form.option == 'start' && form.errors" value="Start Date" :message="form.errors.start_at"/>
                <InputLabel v-if="form.option == 'end' && form.errors" value="End Date" :message="form.errors.end_at"/>
                <input v-if="form.option == 'start'" type="date" class="form-control mb-2" v-model="form.start_at">
                <input @input="handleInput('end_at')" v-if="form.option == 'end'" type="date" class="form-control mb-2" v-model="form.end_at">
                <!-- <input ref="input" class="form-control" v-model="keyword" placeholder="Please type CONFIRM to continue." style="min-height: 38.4px !important; text-align: center;"> -->
              <div class="row g-2" v-if="selected == 1 && form.option == 'end'">
                    <BCol lg="12">
                        <hr class="text-muted mb-1"/>
                    </BCol>
                    <BCol lg="8" style="margin-top: 15px; margin-bottom: -12px;" class="fs-12" :class="(form.errors.requires_report) ? 'text-danger' : ''">Does this TSR require a test report?</BCol>
                    <BCol lg="4" style="margin-top: 15px; margin-bottom: -12px;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="custom-control custom-radio mb-0">
                                    <input type="radio" id="c1" @input="handleInput('requires_report')" class="custom-control-input me-2" :value="true" v-model="form.requires_report">
                                    <label class="custom-control-label fw-normal fs-12" for="c1">Yes</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="custom-control custom-radio mb-0">
                                    <input type="radio" id="c2" @input="handleInput('requires_report')" class="custom-control-input me-2" :value="false" v-model="form.requires_report">
                                    <label class="custom-control-label fw-normal fs-12" for="c2">No</label>
                                </div>
                            </div>
                        </div>
                    </BCol>
                    <BCol lg="12">
                        <hr class="text-muted mb-n1"/>
                    </BCol>
                    <BCol lg="12">
                       <div class="mt-2 fs-12 alert alert-warning alert-dismissible alert-label-icon label-arrow fade show material-shadow" role="alert">
                            <i class="ri-alert-line label-icon"></i>
                            <strong>Note:</strong> If you select <strong>No</strong>, this TSR will not require a test report and will be excluded from the <strong>TSRs Without Reports</strong> count on the Monitoring page.
                        </div>
                    </BCol>
                </div>
                <div class="hstack gap-2 justify-content-center mt-4">
                    <button @click="hide" class="btn btn-light btn-md" type="button">
                        <div class="btn-content"> Close</div>
                    </button>
                    <button @click="submit()" :disabled="form.processing" class="btn btn-primary">Confirm</button>
                </div>
            </div>
        </div>
    </b-modal>
</template>
<script>
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
export default {
    components: { InputLabel },
    data(){
        return {
            currentUrl: window.location.origin,
            form: {},
            keyword: null,
            showModal: false,
            selected: null
        }
    },
    methods: { 
        show(form){
            this.form = form;
            this.showModal = true;
            this.check();
        },
         check(id){
            axios.get('/analyses',{
                params : {
                    tsr_id: this.form.tsr_id,
                    option: 'check'
                }
            })
            .then(response => {
                this.selected = response.data;
                this.form.total = response.data;
            })
            .catch(err => console.log(err));
        },
        submit(){
            this.form.put('/analyses/update',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('update',this.$page.props.flash.data);
                    this.hide();
                },
            });
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>