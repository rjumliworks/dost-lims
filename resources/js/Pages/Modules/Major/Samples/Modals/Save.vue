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
                <input v-if="form.option == 'end'" type="date" class="form-control mb-2" v-model="form.end_at">
                <!-- <input ref="input" class="form-control" v-model="keyword" placeholder="Please type CONFIRM to continue." style="min-height: 38.4px !important; text-align: center;"> -->
              
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
            showModal: false
        }
    },
    methods: { 
        show(form){
            this.form = form;
            this.showModal = true;
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
        hide(){
            this.showModal = false;
        }
    }
}
</script>