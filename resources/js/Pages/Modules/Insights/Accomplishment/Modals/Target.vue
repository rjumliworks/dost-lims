<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" title="Set Target" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="row align-items-center g-3">
                    <div class="col-md">
                        <div>
                            <h6><span class="fw-semibold text-primary fs-15">{{ name }}</span></h6>
                            <div class="hstack gap-3  fs-12 flex-wrap">
                                <div><i class="ri-calendar-line align-bottom me-1"></i> Laboratory : 
                                    <span class="fw-medium"> {{ selected.name }}</span>
                                </div>
                                <div class="vr" style="width: 1px;"></div>
                                <div>Accomplishment : 
                                    <span class="fw-medium">{{selected.accomplish}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <div class="row g-2 mt-0 mb-1">
            <div class="col-sm-12">
                <hr class="text-muted mt-n2 mb-2"/>
            </div>
        </div>
        <form class="customform" v-if="selected.target == 0">
            <BRow>
                <BCol lg="12">
                    <InputLabel value="Target" :message="form.errors.target"/>
                    <TextInput v-if="selected.target == 0" v-model="form.target" type="text" class="form-control" placeholder="Please enter target" :light="true"/>
                </BCol>   
            </BRow>     
        </form>       
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
            <b-button @click="submit('ok')" variant="primary" :disabled="form.processing" block>Submit</b-button>
        </template>
    </b-modal>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    components: { InputLabel, TextInput },
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                id: null,
                target: null,
                list: null,
                option: 'target'
            }),
            name: null,
            selected: {},
            showModal: false
        }
    },
    methods: { 
        show(name,data){
            this.name = name;
            this.selected = data; 
            console.log(this.name);
            if(this.name == 'Overall'){
                console.log('wew');
                console.log(this.selected);
                this.form.id = data.id;
                this.form.option = 'overall';
                this.form.target = data.target; 
                this.form.list = this.selected.lists.map(item => item.id);
            }else{
                this.form.id = data.id;
                this.form.target = data.target; 
            } 
            this.showModal = true;
        },
        submit(){
            this.form.put('/accomplishments/update',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.hide();
                },
            });
        },
        hide(){
            this.form.id = null;
            this.form.customer_id = null;
            this.form.name = null;
            this.form.contact_no = null;
            this.showModal = false;
        }
    }
}
</script>