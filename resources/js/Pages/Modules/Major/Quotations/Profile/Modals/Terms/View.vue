<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 600px;" header-class="p-3 bg-light" title="Terms and Condition" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <!-- <form class="customform">
            <BRow class="g-3">
                <BCol lg="12" class="mt-1">
                    <InputLabel for="sampletype" value="Name"/>
                    <textarea v-model="name" rows="3" class="form-control" required @input="handleInput('name')" :light="true"></textarea>
                </BCol>
            </BRow>
        </form> -->
        <ul class="fs-12" style="margin-left: -20px;">
            <li v-for="(list,index) in terms" v-bind:key="index" @click="editTerm(list, index)" :style="{ cursor: list.is_editable ? 'pointer' : 'default' }">{{list.name}}</li>
        </ul><button @click="openTerm()" class="btn btn-sm btn-light mt-n1">Add Terms and Condition</button>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="submit('ok')" variant="primary" block>Update</b-button>
        </template>
    </b-modal>
    <Term @new="addNew" @update="saveTerm" ref="term"/>
</template>
<script>
import Term from './Add.vue';
import { useForm } from '@inertiajs/vue3';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    components: { InputLabel, TextInput, Term },
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
               id: null,
               terms: null,
               option: 'terms'
            }),
            terms: null,
            showModal: false,
            editedTerm: { name: '', index: null },
        }
    },
    methods: { 
        show(data,id){
            this.form.id = id;
            this.terms = data;
            this.showModal = true;
        }, 
        openTerm(){
            this.$refs.term.show();
        },
        addNew(data) {
            this.terms.push({ name: data, is_editable: 1 });
        },
        saveTerm(data) {
            this.terms[this.editedTerm.index].name = data;
        },
        editTerm(list,index){
            if (list.is_editable) {
                this.editedTerm = { ...list, index };
                this.$refs.term.edit(this.editedTerm);
            }
        },
        submit(){
            this.form.terms = this.terms;
            this.form.put('/quotations/update',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('selected',response.props.flash.data.data);
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