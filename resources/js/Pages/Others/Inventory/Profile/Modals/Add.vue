<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 800px;" header-class="p-3 bg-light" title="Add Stocks" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow class="g-3 mt-0">
                <BCol lg="8" class="mt-1 mb-n2">
                    <InputLabel for="name" value="Item"/>
                    <TextInput id="name" v-model="form.name" type="text" class="form-control" readonly :light="true"/>
                </BCol>
                <BCol v-if="status" lg="12" class="mt-n2">
                    <InputLabel for="item_id" value="Item" :message="form.errors.item_id"/>
                    <Multiselect :options="items" label="name" @search-change="fetchItem" :searchable="true" v-model="form.item_id" placeholder="Select Item"/>
                </BCol>
                <BCol lg="4" class="mt-1 mb-n2">
                    <InputLabel for="category_id" value="Unit" :message="form.errors.unit_id"/>
                    <div class="input-group mb-1">
                        <input type="text" v-model="form.unit" placeholder="Size" class="form-control" style="height: 39px; width: 50%; background-color: #f5f6f7;">
                        <select v-model="form.unit_id" class="form-select" id="inputGroupSelect02" style="height: 39px; width: 50%; background-color: #f5f6f7;">
                            <option :value="null" selected>Select</option>
                            <option :value="list.value" v-for="list in dropdowns.units" v-bind:key="list.value">{{list.name}}</option>
                        </select>
                    </div>
                </BCol>
                <BCol lg="12"><hr class="text-muted mt-0 mb-0"/></BCol>
                <BCol lg="4" class="mt-2 mb-n1">
                    <InputLabel for="name" value="Brand" :message="form.errors.brand"/>
                    <TextInput id="name" v-model="form.brand" type="text" class="form-control" placeholder="Please enter item brand" @input="handleInput('name')" :light="true"/>
                </BCol>
                <BCol lg="4" class="mt-2 mb-n1">
                    <InputLabel for="name" value="Serial no. / Batch no." :message="form.errors.number"/>
                    <TextInput id="name" v-model="form.number" type="text" class="form-control" placeholder="Please enter serial or batch no." @input="handleInput('number')" :light="true"/>
                </BCol>
                <BCol lg="4" class="mt-1 mb-n1">
                    <InputLabel for="name" value="Quantity" :message="form.errors.quantity"/>
                    <TextInput id="name" v-model="form.quantity" type="text" class="form-control" placeholder="Please enter quantity" autocomplete="name" @input="handleInput('quantity')" :light="true"/>
                </BCol>
                <BCol lg="4" class="mt-1 mb-n1">
                    <InputLabel for="name" value="Price" :message="form.errors.bought_at"/>
                    <Amount @amount="amount" ref="testing" :readonly="false"/>
                </BCol>
                <BCol lg="4" class="mt-1 mb-n1">
                    <InputLabel for="name" value="Expiration Date" :message="form.errors.expired_at"/>
                    <TextInput id="name" v-model="form.expired_at" type="date" class="form-control" placeholder="Please enter date" @input="handleInput('expired_at')" :light="true"/>
                </BCol>
                <BCol lg="4" class="mt-1 mb-n1">
                    <InputLabel for="name" value="Received Date" :message="form.errors.bought_at"/>
                    <TextInput id="name" v-model="form.bought_at" type="date" class="form-control" placeholder="Please enter bought date" @input="handleInput('bought_at')" :light="true"/>
                </BCol>
                <BCol lg="12"><hr class="text-muted mt-0 mb-0"/></BCol>
                <BCol v-if="form.laboratory_id == 1" lg="4" class="mt-2 mb-2">
                    <InputLabel for="name" value="CAS Number" :message="form.errors.cas_number"/>
                    <TextInput id="name" v-model="form.cas_number" type="text" class="form-control" placeholder="Please enter cas number" @input="handleInput('cas_number')" :light="true"/>
                </BCol>
                <BCol :lg="(form.laboratory_id == 1) ? 8 : 12" class="mt-2">
                    <div class="d-flex">
                        <div style="width: 100%;">
                            <InputLabel for="supplier_id" value="Supplier" :message="form.errors.supplier_id"/>
                            <Multiselect :options="dropdowns.suppliers" label="name" :searchable="true" v-model="form.supplier_id" placeholder="Select Supplier" ref="krad"/>
                        </div>
                        <div class="flex-shrink-0">
                            <b-button @click="openSupplier()" style="margin-top: 20px;" variant="light" class="waves-effect waves-light ms-1"><i class="ri-add-circle-fill"></i></b-button>
                        </div>
                    </div>
                </BCol>
    
                <BCol v-if="form.notify" lg="4" class="mt-3">
                    <!-- <InputLabel for="name" value="Notification Date" :message="form.errors.notify_at"/> -->
                    <TextInput id="name" v-model="form.notify_at" type="date" class="form-control" placeholder="Please enter notification date" @input="handleInput('notify_at')" :light="true"/>
                </BCol>
                <BCol lg="8" class="mt-4">
                    <input class="form-check-input fs-14" v-model="form.notify" type="checkbox" value="option" /> <span class="text-muted ms-1">Notify me in advanced when the expiration date is approaching.</span>
                </BCol>
            </BRow>
        </form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="submit('ok')" variant="primary" :disabled="form.processing" block>Submit</b-button>
        </template>
    </b-modal>
    <!-- <Supplier @message="pushNew" :dropdowns="dropdowns" ref="supplier"/> -->
</template>
<script>
import _ from 'lodash';
import { useForm } from '@inertiajs/vue3';
import Amount from '@/Shared/Components/Forms/Amount.vue';
import Multiselect from '@/Shared/Components/Forms/Multiselect.vue';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    components: { InputLabel, TextInput, Multiselect, Amount },
    props: ['dropdowns'],
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                item_id: null,
                name: null,
                id: null,
                unit: null,
                unit_id: null,
                supplier_id: null,
                item_id: null,
                bought_at: null,
                price: null,
                expired_at: null,
                number: null,
                cas_number: null,
                quantity: null,
                brand: null,
                notify: false,
                notify_at: null,
                laboratory_id: null,
                option: 'stock'
            }),
            editable: false,
            selected: null,
            showModal: false
        }
    },
    methods: { 
        show(data){
            this.editable = false;
            this.form.item_id = data.id;
            this.form.name = data.name;
            this.form.unit_id = data.unit_id;
            this.form.laboratory_id = data.laboratory_id;
            this.selected = data;
            this.showModal = true;
        },
        edit(data){
            this.selected = data;
            this.form.id = data.id;
            this.form.name = data.name;
            this.form.brand = data.brand;
            this.form.number = data.number;
            this.form.quantity = data.quantity;
            this.form.price = data.price;
            this.form.unit = data.unit;
            this.form.unit_id = data.unit_id;
            this.$refs.krad.emitSelectedValues(data.supplier_id);
            this.$refs.testing.emitValue(data.price);
            this.form.expired_at = data.expired_at;
            this.form.bought_at = data.bought_at;
            this.editable = true;
            this.showModal = true;
        },
        submit(){
            if(this.editable){
                this.form.put('/inventory/update',{
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.$emit('add',this.$page.props.flash.data.data);
                        this.form.reset();
                        this.hide();
                    },
                });
            }else{
                this.form.post('/inventory',{
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.$emit('add',this.$page.props.flash.data.data);
                        this.form.reset();
                        this.hide();
                    },
                });
            }
        },
        amount(val){
            this.form.price = val;
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        openSupplier(){
            this.$refs.supplier.show();
        },
        pushNew(data){
            this.form.supplier_id = data.data.id;
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>