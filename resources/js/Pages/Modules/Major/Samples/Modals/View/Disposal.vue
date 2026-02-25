<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 800px;" hide-footer header-class="p-3 bg-light" title="Disposal Details" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        
        <template v-if="selected">
            <div class="card bg-light-subtle border-1 rounded-bottom shadow-none mb-0 p-3">
                <form class="customform">
                    <div class="row g-2 mt-0 mb-1">
                        <div class="col-sm-12">
                            <div class="p-0 border border-dashed bg-white rounded">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-hashtag"></i></div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="text-muted mb-0 fs-11">Manner of Disposal</p>
                                        <h5 class="mb-0 fs-12">{{ selected.disposal }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-0 border border-dashed bg-white rounded">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-hand-coin-fill"></i></div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="text-muted mb-0 fs-11">Date Disposed :</p>
                                        <h5 class="mb-0 fs-12">{{ selected.disposed_at }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-0 border border-dashed bg-white rounded">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-hand-coin-fill"></i></div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="text-muted mb-0 fs-11">Disposed By :</p>
                                        <h5 class="mb-0 fs-12">{{ selected.user }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    </div>
                </form>
            </div>
        </template>
        
        <!-- {{ selected }} -->
           
        <!-- <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="submit('ok')" variant="primary" :disabled="form.processing" block>Update</b-button>
        </template> -->
    </b-modal>
    <!-- <Add @selected="set" ref="conforme"/> -->
</template>
<script>
import _ from 'lodash';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
import Textarea from '@/Shared/Components/Forms/Textarea.vue';
export default {
    components: { InputLabel, TextInput, Textarea },
    data(){
        return {
            selected: null,
            showModal: false
        }
    },
    methods: { 
        show(data){
            this.selected = data;
            this.showModal = true;
        },
        hide(){
            this.form.reset();
            this.showModal = false;
        }
    }
}
</script>