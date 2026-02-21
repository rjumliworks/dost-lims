<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 800px;" hide-footer header-class="p-3 bg-light" title="Sample Information" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        
        <template v-if="selected">
            <div class="card bg-light-subtle border-1 rounded-bottom shadow-none mb-0 p-3">
                <form class="customform">
                    <div class="row g-2 mt-0 mb-1">
                        <div class="col-sm-6">
                            <div class="p-0 border border-dashed bg-white rounded">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-hashtag"></i></div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="text-muted mb-0 fs-11">Code :</p>
                                        <h5 class="mb-0 fs-12">{{ selected.code }}</h5>
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
                                        <p class="text-muted mb-0 fs-11">Category :</p>
                                        <h5 class="mb-0 fs-12">{{ selected.category?.name }}</h5>
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
                                        <p class="text-muted mb-0 fs-11">Sample Type :</p>
                                        <h5 class="mb-0 fs-12">{{ selected.sampletype?.name }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-0 border border-dashed bg-white rounded">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-file-text-fill"></i></div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="text-muted mb-0 fs-11">Sample Name :</p>
                                        <h5 class="mb-0 fs-12">{{ selected.samplename?.name }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <hr class="text-muted mb-2 mt-2"/>
                        </div>
                        <div class="col-sm-12">
                            <div class="p-0 border border-dashed bg-white rounded">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-information-fill"></i></div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="text-muted mb-0 fs-11">Description provided by the Customer :</p>
                                        <h5 class="mb-0 fs-12">{{selected.customer_description}}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="p-0 border border-dashed bg-white rounded">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-information-fill"></i></div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="text-muted mb-0 fs-11">Description based on the sample submitted :</p>
                                        <h5 class="mb-0 fs-12">{{selected.description}}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <BCol lg="12"><hr class="text-muted mt-2 mb-0"/></BCol>
                        <BCol lg="6" class="mb-1">
                            <InputLabel for="name" value="Description provided by customer"/>
                            <Textarea id="name" v-model="selected.customer_description" class="form-control" rows="7" :light="false" readonly/>
                        </BCol>
                        <BCol lg="6" class="mb-1">
                            <InputLabel for="name" value="Description based on the sample submitted"/>
                            <Textarea id="name" v-model="selected.description" class="form-control" rows="7" :light="false" readonly/>
                        </BCol> -->
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